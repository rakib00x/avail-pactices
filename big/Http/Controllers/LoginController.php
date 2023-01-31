<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;

use DB;
use Session;
use Mail;
use Cookie;
use \Swift_Mailer;
use \Swift_SmtpTransport as SmtpTransport;

 
class LoginController extends Controller
{
    private $rcdate;
    private $logged_id;
    private $current_time;

    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate           = date('Y-m-d');
        $this->logged_id        = Session::get('admin_id');
        $this->current_time     = date('H:i:s');
        $this->current_date_time =date('Y-m-d H:i:s') ;
        
        $this->agent = new Agent() ;

        $clientIP = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $clientIP = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $clientIP = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $clientIP = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $clientIP = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $clientIP = $_SERVER['REMOTE_ADDR'];
        else
        $clientIP = 'UNKNOWN';    

        $explode = explode(",",$clientIP);
        $ip = $explode[0];
        
        $clientIP_s =  $ip;
        
        $url = "http://ip-api.com/json/".$clientIP_s ;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);
            
        $json_object = json_encode($resp);
        $decode = json_decode($json_object);
        $geo_object = json_decode($decode);
        
        $county_info = DB::table('tbl_countries')->where('stuas', 1)->first();
        $countryCode = $county_info->countryCode;
        
        

        $getCount    = DB::table('tbl_currency_status')->where('code',$countryCode)->count();

        if($getCount == 0){
            $getCurrencyd = DB::table('tbl_currency_status')->where('default_status', 1)->first();
            $currency_id = $getCurrencyd->id;
            $countryCode = $getCurrencyd->code ;
        }else{
            $getCurrency = DB::table('tbl_currency_status')->where('code', $county_info->countryCode)->first();
            $currency_id = $getCurrency->id;
            $countryCode = $getCurrency->code ;
        }
        
        if(Cache::get('cookie_currency') != null && Cache::get('cookie_browser') == $this->agent->browser() && Cache::get('cookie_device')  == $this->agent->device()){
            Session::put('requestedCurrency', null);
            Session::put('requestedCurrency', Cache::get('cookie_currency'));
            Session::put('countrycode', Cache::get('countryCode'));
        }else{
            Session::put('requestedCurrency', null);
            Session::put('requestedCurrency', $currency_id);
            Session::put('countrycode', $countryCode);
        }

    }


    # BUYER AND SELLER LOGIN
    public function buyerLogin(){
        if($this->agent->isDesktop()){
            $product = DB::table('tbl_product')
            ->inRandomOrder()
            ->where('status', 1)
            ->take(15)
            ->orderBy('id', 'desc')
            ->get();
            $social = DB::table('tbl_social_media')->first();
            return view('frontEnd.login')->with('social',$social)->with('product',$product);
        }else{
            return Redirect::to("m/signin");
        }
        
    } 
    
    public function buyerSignIn(Request $request){
        
        $email    = trim($request->email);
        $password = trim($request->password);
        $remember = $request->remember;

        if(strpos($email, "@") !== false){
            $filed_name = "email" ;
        }else{
            $filed_name = "mobile" ;
        } 

        $salt      = 'a123A321';
        $encrypted = sha1($password.$salt);

        $attem_count = DB::table('express')
            ->where('password',$encrypted)
            ->where('status', 3)
            ->whereIn('type', [2,3])
            ->where($filed_name,$email)
            ->where('attem_time', '>', 0)
            ->count();

        if($attem_count > 0){
            $attem_info = DB::table('express')
            ->where('password',$encrypted)
            ->where('status', 3)
            ->whereIn('type', [2,3])
            ->where($filed_name,$email)
            ->first();

            if($attem_info->block_time > $this->current_date_time){
                Session::put('login_faild', 'Sorry! Your Account Hold For '.date("d-m-Y h:i A", strtotime($attem_info->block_time)).'. Please wait');
                $notification = array(
                    'message'    => 'Sorry! Your Account Hold For '.date("d-m-Y h:i A", strtotime($attem_info->block_time)).'. Please wait', 
                    'alert-type' => 'failed',
                );
                return Redirect::to('login')->with($notification) ;
            }else{
                $main_data_s                = array();
                $main_data_s['fail_attem'] = 0 ;
                $main_data_s['block_time'] = null ;
                $main_data_s['attem_time'] = 0 ;
                $main_data_s['status']     = 1 ;
                DB::table('express')->where('id', $attem_info->id)->update($main_data_s) ;
            }

        }

        $count = DB::table('express')
            ->where('password',$encrypted)
            ->where('status', 1)
            ->whereIn('type', [2,3])
            ->where($filed_name,$email)
            ->count();

        if($count > 0){

            $query  = DB::table('express')
                ->where('password',$encrypted)
                ->where('status', 1)
                ->whereIn('type', [2,3,4])
                ->where($filed_name,$email)
                ->first();

            if ($query->verify_status == 1) {

                $main_data_s                = array();
                $main_data_s['fail_attem'] = 0 ;
                $main_data_s['block_time'] = null ;
                $main_data_s['attem_time'] = 0 ;
                DB::table('express')->where('id', $query->id)->update($main_data_s) ;

                if($query->type == 2 && $query->seller_type == 0){
                    
                    if($query->package_id > 0 && $query->package_status ==1 ){
                        
                        if($remember){
                            setcookie('cookie_username', $email, time() + (86400 * 7), "/");
                            setcookie('cookie_password', $request->password, time() + (86400 * 7), "/");
                        }
                        
                        // ini_set('session.cookie_domain', '.availtrade.com');
                        // ini_set('session.cookie_domain', '.m.availtrade.com');
                        
                        Session::put('supplier_email',$query->email);
                        Session::put('supplier_id',$query->id);
                        Session::put('supplier_type',$query->type);
                        Session::put('seller_type', $query->seller_type);
                        
                        Cache::put('user_session_cache', $query->id, 525000);
    
                        $notification = array(
                            'message'    => 'Login granted successfully', 
                            'alert-type' => 'success',
                        );
                        
                        if ($request->prev == "https://www.availtrade.com/login" || $request->prev == "http://www.availtrade.com/login" || $request->prev == "http://availtrade.com/change-password" || $request->prev == "https://availtrade.com/change-password") {
                            return Redirect::to('')->with($notification) ;
                        }else{
                            return redirect()->intended($request->prev)->with($notification);
                            
                        }
                    }elseif($query->package_id > 0 && $query->package_status == 0){
                        Session::put('login_faild', 'Your account under review. Please wait');

                        $notification = array(
                            'message'    => 'Your account under review. Please wait', 
                            'alert-type' => 'failed',
                        );
                        return Redirect::to('login')->with($notification) ;
                    }else{
                        
                        if($remember){
                            setcookie('cookie_username', $email, time() + (86400 * 7), "/");
                            setcookie('cookie_password', $request->password, time() + (86400 * 7), "/");
                        }
                        
                        // ini_set('session.cookie_domain', '.availtrade.com');
                        // ini_set('session.cookie_domain', '.m.availtrade.com');
                        
                        Session::put('supplier_email',$query->email);
                        Session::put('supplier_id',$query->id);
                        Session::put('supplier_type',$query->type);
                        Session::put('seller_type', $query->seller_type);
                        
                        Cache::put('user_session_cache', $query->id, 525000);
    
                        $notification = array(
                            'message'    => 'Login granted successfully', 
                            'alert-type' => 'success',
                        );
                        
                        return Redirect::to('package')->with($notification) ;
                    }
                    

                }else if($query->type == 3){
                    
                    if($remember){
                        setcookie('cookie_username', $email, time() + (86400 * 7), "/");
                        setcookie('cookie_password', $request->password, time() + (86400 * 7), "/");
                    }
                        
                    $auth_number_length           = 30 ;
                    $auth_number                  = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'),1,$auth_number_length);
                    $track_no                     = rand(10000 , 99999) ;

                    // ini_set('session.cookie_domain', '.availtrade.com');
                    // ini_set('session.cookie_domain', '.m.availtrade.com');

                    Session::put('auth_number',$auth_number);
                    Session::put('track_no',$track_no);

                    Session::put('buyer_email', $query->email);
                    Session::put('buyer_id', $query->id);
                    Session::put('buyer_type', $query->type);

                    $notification = array(
                        'message'    => 'Login granted successfully', 
                        'alert-type' => 'success',
                    );

                    if ($request->prev == "https://www.availtrade.com/login" || $request->prev == "http://www.availtrade.com/login" || $request->prev == "http://availtrade.com/change-password" || $request->prev == "https://availtrade.com/change-password") {
                        return Redirect::to('')->with($notification) ;
                    }else{
                        return redirect()->intended($request->prev)->with($notification);
                    }

                }else if($query->type == 2 && $query->seller_type == 1){
                    if($remember){
                        setcookie('cookie_username', $email, time() + (86400 * 7), "/");
                        setcookie('cookie_password', $request->password, time() + (86400 * 7), "/");
                    }
                        

                    Session::put('supplier_email',$query->email);
                    Session::put('supplier_id',$query->id);
                    Session::put('supplier_type', $query->type);
                    Session::put('seller_type', $query->seller_type);
                    

                    $notification = array(
                        'message'    => 'Login granted successfully', 
                        'alert-type' => 'success',
                    );

                    if ($request->prev == "https://www.availtrade.com/login" || $request->prev == "http://www.availtrade.com/login" || $request->prev == "http://availtrade.com/change-password" || $request->prev == "https://availtrade.com/change-password") {
                        return Redirect::to('')->with($notification) ;
                    }else{
                        return redirect()->intended($request->prev)->with($notification);
                    }

                    
                
            }
                
            }else{

                Session::put('login_faild', 'Please check your Email and Verify Then Try Again.');

                $notification = array(
                    'message'    => 'Please check your email and verify, then try again.', 
                    'alert-type' => 'failed',
                );
                return Redirect::to('login')->with($notification) ;
            }
        }

        $verify_count = DB::table('express')
            ->where('verify_status', 0)
            ->where('status', 0)
            ->where($filed_name, $email)
            ->where('password', $encrypted)
            ->count();

        if ($verify_count > 0) {

            Session::put('login_faild', 'Please check your Email and Verify Then Try Again.');

            $notification = array(
                'message'    => 'Please check your email and verify, Then try again.', 
                'alert-type' => 'failed',
            );
            return Redirect::to('login')->with($notification) ;
        }


        $login_fail_attem = DB::table('express')
            ->whereIn('type', [2,3])
            ->where($filed_name,$email)
            ->count();

        if($login_fail_attem > 0){

            $login_fail_attem_info = DB::table('express')
                ->whereIn('type', [2,3])
                ->where($filed_name,$email)
                ->first() ;
        
            $main_attem = $login_fail_attem_info->fail_attem + 1 ;

            if($main_attem <= 6){
                $attem_data                 = array();
                $attem_data['fail_attem']   = $main_attem ;

                if($main_attem == 3){
                    $attem_data['block_time'] = date("Y-m-d H:i:s", strtotime('+10 minutes')) ;
                    $attem_data['attem_time'] = 1 ;
                    $attem_data['status']     = 3 ;
                }

                if($main_attem == 6 && $login_fail_attem_info->fail_attem){
                    $attem_data['block_time'] = date("Y-m-d H:i:s", strtotime('+24 hours')) ;
                    $attem_data['attem_time'] = 2 ;
                    $attem_data['status']     = 3 ;
                }

                DB::table('express')->where($filed_name,$email)->update($attem_data) ;
            }
            
            if($login_fail_attem_info->status == 3){
                Session::put('login_faild', 'Sorry! Your Account Hold For '.date("d-m-Y h:i A", strtotime($login_fail_attem_info->block_time)).'. Please wait');
                $notification = array(
                    'message'    => 'Sorry! Your Account Hold For '.date("d-m-Y h:i A", strtotime($login_fail_attem_info->block_time)).'. Please wait', 
                    'alert-type' => 'failed',
                );
                return Redirect::to('login')->with($notification) ;
            }
            
        }


        $status_count = DB::table('express')
            ->where($filed_name, $email)
            ->where('password', $encrypted)
            ->whereIn('type', [2,3])
            ->count();

        if ($status_count > 0) {
            $status_check = DB::table('express')
                ->where($filed_name, $email)
                ->where('password', $encrypted)
                ->whereIn('type', [2,3])
                ->first();

            if($status_check->status == 2 || $status_check->status == 3){
                Session::put('login_faild', 'Your Account Hold By Admin If you have any query Contact With Us : info@availtrade.com');
                $notification = array(
                    'message'    => 'Your Account Hold By Admin If you have any query Contact With Us : info@availtrade.com', 
                    'alert-type' => 'failed',
                );
                return Redirect::to('login')->with($notification) ;
            }
        }else{
            Session::put('login_faild', 'Email Or Password Not Match');
            $notification = array(
                'message'    => 'Email Or Password Not Match', 
                'alert-type' => 'failed',
            );

            return Redirect::to('login')->with($notification) ;
        }

    }

    // public function buyerSignIn(Request $request){
        
    //     $email    = trim($request->email);
    //     $password = trim($request->password);
    //     $remember = $request->remember;

    //     if(strpos($email, "@") !== false){
    //         $filed_name = "email" ;
    //     }else{
    //         $filed_name = "mobile" ;
    //     }

    //     $salt      = 'a123A321';
    //     $encrypted = sha1($password.$salt);

    //     $count = DB::table('express')
    //         ->where('password',$encrypted)
    //         ->where('status', 1)
    //         ->whereIn('type', [2,3])
    //         ->where($filed_name,$email)
    //         ->count();

    //     if($count > 0){

    //         $query  = DB::table('express')
    //             ->where('password',$encrypted)
    //             ->where('status', 1)
    //             ->whereIn('type', [2,3])
    //             ->where($filed_name,$email)
    //             ->first();

    //         if ($query->verify_status == 1) {
                


    //             if($query->type == 2){
                    
    //                 if($query->package_id > 0 && $query->package_status ==1 ){
                        
    //                     if($remember){
    //                         setcookie('cookie_username', $email, time() + (86400 * 7), "/");
    //                         setcookie('cookie_password', $password, time() + (86400 * 7), "/");
    //                     }
                        
    //                     // ini_set('session.cookie_domain', '.availtrade.com');
    //                     // ini_set('session.cookie_domain', '.m.availtrade.com');
                        
    //                     Session::put('supplier_email',$query->email);
    //                     Session::put('supplier_id',$query->id);
    //                     Session::put('supplier_type',$query->type);
                        
    //                     Cache::put('user_session_cache', $query->id, 525000);
    
    //                     $notification = array(
    //                         'message'    => 'Login granted successfully', 
    //                         'alert-type' => 'success',
    //                     );
                        
    //                     if ($request->prev == "https://www.availtrade.com/login" || $request->prev == "http://www.availtrade.com/login" || $request->prev == "http://availtrade.com/change-password" || $request->prev == "https://availtrade.com/change-password") {
    //                         return Redirect::to('')->with($notification) ;
    //                     }else{
    //                         return redirect()->intended($request->prev)->with($notification);
                            
    //                     }
    //                 }elseif($query->package_id > 0 && $query->package_status == 0){
    //                     Session::put('login_faild', 'Your account under review. Please wait');

    //                     $notification = array(
    //                         'message'    => 'Your account under review. Please wait', 
    //                         'alert-type' => 'failed',
    //                     );
    //                     return Redirect::to('login')->with($notification) ;
    //                 }else{
                        
    //                     if($remember){
    //                         setcookie('cookie_username', $email, time() + (86400 * 7), "/");
    //                         setcookie('cookie_password', $password, time() + (86400 * 7), "/");
    //                     }
                        
    //                     // ini_set('session.cookie_domain', '.availtrade.com');
    //                     // ini_set('session.cookie_domain', '.m.availtrade.com');
                        
    //                     Session::put('supplier_email',$query->email);
    //                     Session::put('supplier_id',$query->id);
    //                     Session::put('supplier_type',$query->type);
                        
    //                     Cache::put('user_session_cache', $query->id, 525000);
    
    //                     $notification = array(
    //                         'message'    => 'Login granted successfully', 
    //                         'alert-type' => 'success',
    //                     );
                        
    //                     return Redirect::to('package')->with($notification) ;
    //                 }
                    

    //             }else if($query->type == 3){
                    
    //                 if($remember){
    //                     setcookie('cookie_username', $email, time() + (86400 * 7), "/");
    //                     setcookie('cookie_password', $password, time() + (86400 * 7), "/");
    //                 }
                        
    //                 $auth_number_length           = 30 ;
    //                 $auth_number                  = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'),1,$auth_number_length);
    //                 $track_no                     = rand(10000 , 99999) ;

    //                 // ini_set('session.cookie_domain', '.availtrade.com');
    //                 // ini_set('session.cookie_domain', '.m.availtrade.com');

    //                 Session::put('auth_number',$auth_number);
    //                 Session::put('track_no',$track_no);

    //                 Session::put('buyer_email', $query->email);
    //                 Session::put('buyer_id', $query->id);
    //                 Session::put('buyer_type', $query->type);

    //                 $notification = array(
    //                     'message'    => 'Login granted successfully', 
    //                     'alert-type' => 'success',
    //                 );

    //                 if ($request->prev == "https://www.availtrade.com/login" || $request->prev == "http://www.availtrade.com/login" || $request->prev == "http://availtrade.com/change-password" || $request->prev == "https://availtrade.com/change-password") {
    //                     return Redirect::to('')->with($notification) ;
    //                 }else{
    //                     return redirect()->intended($request->prev)->with($notification);
    //                 }

    //             }
    //         }else{

    //             Session::put('login_faild', 'Verify Your Email First And Try Again.');

    //             $notification = array(
    //                 'message'    => 'Verify Your Email First And Try Again.', 
    //                 'alert-type' => 'failed',
    //             );
    //             return Redirect::to('login')->with($notification) ;
    //         }
    //     }

    //     $verify_count = DB::table('express')
    //         ->where('verify_status', 0)
    //         ->where('status', 0)
    //         ->where($filed_name, $email)
    //         ->where('password', $encrypted)
    //         ->count();

    //     if ($verify_count > 0) {

    //         Session::put('login_faild', 'Verify Your Email First And Try Again.');

    //         $notification = array(
    //             'message'    => 'Verify Your Email First And Try Again.', 
    //             'alert-type' => 'failed',
    //         );
    //         return Redirect::to('login')->with($notification) ;
    //     }


    //     $status_count = DB::table('express')
    //         ->where($filed_name, $email)
    //         ->where('password', $encrypted)
    //         ->whereIn('type', [2,3])
    //         ->count();

    //     if ($status_count > 0) {
    //         $status_check = DB::table('express')
    //             ->where($filed_name, $email)
    //             ->where('password', $encrypted)
    //             ->whereIn('type', [2,3])
    //             ->first();

    //         if($status_check->status == 2 || $status_check->status == 3){
    //             Session::put('login_faild', 'Your Account Hold By Admin If you have any query Contact With Us : info@availtrade.com');
    //             $notification = array(
    //                 'message'    => 'Your Account Hold By Admin If you have any query Contact With Us : info@availtrade.com', 
    //                 'alert-type' => 'failed',
    //             );
    //             return Redirect::to('login')->with($notification) ;
    //         }
    //     }else{
    //         Session::put('login_faild', 'Email Or Password Not Match');
    //         $notification = array(
    //             'message'    => 'Email Or Password Not Match', 
    //             'alert-type' => 'failed',
    //         );

    //         return Redirect::to('login')->with($notification) ;
    //     }

    // }
    
    
    public function usermoallogin(Request $request){
        
        $email    = trim($request->email);
        $password = trim($request->password);
        $remember = $request->remember;
        
        
        if(strpos($email, "@") !== false){
            $filed_name = "email" ;
        }else{
            $filed_name = "mobile" ;
        }

        $salt      = 'a123A321';
        $encrypted = sha1($password.$salt);
        
        
        $attem_count = DB::table('express')
            ->where('password',$encrypted)
            ->where('status', 3)
            ->whereIn('type', [2,3])
            ->where($filed_name,$email)
            ->where('attem_time', '>', 0)
            ->count();

        if($attem_count > 0){
            $attem_info = DB::table('express')
            ->where('password',$encrypted)
            ->where('status', 3)
            ->whereIn('type', [2,3])
            ->where($filed_name,$email)
            ->first();

            if($attem_info->block_time > $this->current_date_time){
                echo "account_hold_by_admin";
                exit() ;
            }else{
                $main_data_s                = array();
                $main_data_s['fail_attem'] = 0 ;
                $main_data_s['block_time'] = null ;
                $main_data_s['attem_time'] = 0 ;
                $main_data_s['status']     = 1 ;
                DB::table('express')->where('id', $attem_info->id)->update($main_data_s) ;
            }

        }

        $count = DB::table('express')
            ->where('password',$encrypted)
            ->where('status', 1)
            ->whereIn('type', [2,3])
            ->where($filed_name,$email)
            ->count();

        if($count > 0){

            $query  = DB::table('express')
                ->where('password',$encrypted)
                ->where('status', 1)
                ->whereIn('type', [2,3])
                ->where($filed_name,$email)
                ->first();

            if ($query->verify_status == 1) {
                

                if($query->type == 2){
                    
                    if($query->package_id > 0 && $query->package_status ==1 ){
                        
                        if($remember){
                            setcookie('cookie_username', $email, time() + (86400 * 7), "/");
                            setcookie('cookie_password', $password, time() + (86400 * 7), "/");
                        }
                        
                        // ini_set('session.cookie_domain', '.availtrade.com');
                        // ini_set('session.cookie_domain', '.m.availtrade.com');
                        
                        Session::put('supplier_email',$query->email);
                        Session::put('supplier_id',$query->id);
                        Session::put('supplier_type',$query->type);
                        
                        Cache::put('user_session_cache', $query->id, 525000);
    
                        echo "success";
                        
                    }elseif($query->package_id > 0 && $query->package_status == 0){
                        echo "package_hold";
                        exit() ;
                    }else{
                        
                        if($remember){
                            setcookie('cookie_username', $email, time() + (86400 * 7), "/");
                            setcookie('cookie_password', $password, time() + (86400 * 7), "/");
                        }
                        
                        // ini_set('session.cookie_domain', '.availtrade.com');
                        // ini_set('session.cookie_domain', '.m.availtrade.com');
                        
                        Session::put('supplier_email',$query->email);
                        Session::put('supplier_id', $query->id);
                        Session::put('supplier_type',   $query->type);
                        
                        Cache::put('user_session_cache', $query->id, 525000);
    
                        echo "login_but_not_active_package";
                    }
                    

                }else if($query->type == 3){
                    
                    if($remember){
                        setcookie('cookie_username', $email, time() + (86400 * 7), "/");
                        setcookie('cookie_password', $password, time() + (86400 * 7), "/");
                    }
                        
                    $auth_number_length           = 30 ;
                    $auth_number                  = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'),1,$auth_number_length);
                    $track_no                     = rand(10000 , 99999) ;

                    // ini_set('session.cookie_domain', '.availtrade.com');
                    // ini_set('session.cookie_domain', '.m.availtrade.com');

                    Session::put('auth_number',$auth_number);
                    Session::put('track_no',$track_no);

                    Session::put('buyer_email', $query->email);
                    Session::put('buyer_id', $query->id);
                    Session::put('buyer_type', $query->type);

                    echo "success";

                }
            }else{

                echo "mail_not_verifyed";
                exit() ;
            }
        }
        
        

        $verify_count = DB::table('express')
            ->where('verify_status', 0)
            ->where('status', 0)
            ->where($filed_name, $email)
            ->where('password', $encrypted)
            ->count();

        if ($verify_count > 0) {

            echo "mail_not_verifyed";
            exit() ;
        }
        
        
        $login_fail_attem = DB::table('express')
            ->whereIn('type', [2,3])
            ->where($filed_name,$email)
            ->count();

        if($login_fail_attem > 0){

            $login_fail_attem_info = DB::table('express')
                ->whereIn('type', [2,3])
                ->where($filed_name,$email)
                ->first() ;
        
            $main_attem = $login_fail_attem_info->fail_attem + 1 ;

            if($main_attem <= 6){
                $attem_data                 = array();
                $attem_data['fail_attem']   = $main_attem ;

                if($main_attem == 3){
                    $attem_data['block_time'] = date("Y-m-d H:i:s", strtotime('+10 minutes')) ;
                    $attem_data['attem_time'] = 1 ;
                    $attem_data['status']     = 3 ;
                }

                if($main_attem == 6 && $login_fail_attem_info->fail_attem){
                    $attem_data['block_time'] = date("Y-m-d H:i:s", strtotime('+24 hours')) ;
                    $attem_data['attem_time'] = 2 ;
                    $attem_data['status']     = 3 ;
                }

                DB::table('express')->where($filed_name,$email)->update($attem_data) ;
            }
            
            if($login_fail_attem_info->status == 3){
                echo "account_hold_by_admin";
                exit() ;
            }
            
        }


        $status_count = DB::table('express')
            ->where($filed_name, $email)
            ->where('password', $encrypted)
            ->whereIn('type', [2,3])
            ->count();

        if ($status_count > 0) {
            $status_check = DB::table('express')
                ->where($filed_name, $email)
                ->where('password', $encrypted)
                ->whereIn('type', [2,3])
                ->first();

            if($status_check->status == 2 || $status_check->status == 3){
                echo "account_hold_by_admin";
                exit() ;
            }
        }else{
            echo "login_failed";
            exit() ;
        }
        
    }

    public function logout()
    {

        Session::put('supplier_email', null);
        Session::put('supplier_id', null);
        Session::put('type', null);
        Session::put('supplier_type', null);
        Session::put('seller_type', null);

        Session::put('buyer_email', null);
        Session::put('buyer_id', null);
        Session::put('buyer_type', null);
        
        Session::put('email', null);
        Session::put('seller_id', null);
        Session::put('type', null);
        
        Cache::forget('user_session_cache');
            
            

        $notification = array(
            'message'    => 'Logout Succesfully Done', 
            'alert-type' => 'failed',
        );

        return Redirect::to('')->with($notification) ;
    }


    #============= SUPPLIER AND BUYER FORGET PASSWORD SECTION ==============#
    public function forgotPassword(){
        return view('forgot_password.forgotPassword');
    }

    # SEND FORGOT PASSWORD RECOVEY CODE
    public function sendForgotRecoveyCode(Request $request){

        $email = $request->email;
        $query = DB::table('express')->where('email',$email)->first();
        $count = DB::table('express')
        ->where('email', $email)
        ->whereNotIn('type', [1])
        ->count();

        if($count == 0){
            
            $notification = array(
                'message'       => 'Sorry !! '.$email.' Email does not match', 
                'alert-type'    => 'failed'
            );

            Session::put('failed','Sorry !! '.$email.' Email does not match');
            return back()->with($notification);
        }
        
        
        

        $email_code = encrypt($email);
        $to_name    = $query->first_name." ".$query->last_name;
        $to_email   = $email;
        
        
        $smtpQuery = DB::table('tbl_smtp')->where('target','f')->first();
        $driver = $smtpQuery->mail_driver;
        $host = $smtpQuery->mail_host;
        $port = $smtpQuery->mail_port;
        $from_address = $smtpQuery->mail_username;
        $from_name = $smtpQuery->from_name;
        $mail_username = $smtpQuery->mail_username;
        $mail_password = $smtpQuery->mail_password;
        $encryption = $smtpQuery->mail_encryption;
        $rowid = $smtpQuery->id;
        
        $transport = (new SmtpTransport($host, $port, $encryption))
            ->setUsername($mail_username)
            ->setPassword($mail_password);


        $mailer = new Swift_Mailer($transport);

        Mail::setSwiftMailer($mailer);

        $rand = rand(999999, 111111) ;

        Session::put('recovery_email', $email_code) ;

        $data = array('name'=>"Avail Trade ", 'body' => "Your Recovery Code Is : ". $rand);
        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Foreget Password ');
            $message->from('avialtradebd@gmail.com',"avialtradebd");
        });
        
        $settings = DB::table('tbl_settings')->first() ;

        $data                   = array();
        $data['recover_code']   = $rand ;
        $data['code_expire_time']   = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +$settings->timeout minutes")); ;
        DB::table('express')->where('email', $email)->update($data);

        $notification = array(
            'message' => 'Thanks !! '.$email.' Recovery Code Succesfully Send.Check Your Password', 
            'alert-type' => 'success'
        );
        return back()->with($notification);
    } 
    # RECOVERY PASSWORD CODE FORM
    public function password_recovery(){
        $social = DB::table('tbl_social_media')->first();
        $email          = decrypt(Session::get('recovery_email')) ;
        $code_info = DB::table('express')->where('email', $email)->first() ;
        return view('forgot_password.password_recovery')->with('social',$social)->with('code_info', $code_info);
}
    public function recoveryCodeCheck(Request $request)
    {
        
        $recover_code   = $request->recovery_code;
        $email          = decrypt(Session::get('recovery_email')) ;
        $code_check     = DB::table('express')->where('recover_code', $recover_code)->where('email', $email)->count();
        
        if ($code_check == 0) {

            $notification = array(
                'message'    => 'Sorry ! Recovery Code Not Match', 
                'alert-type' => 'failed'
            );
            Session::put('failed', 'Sorry ! Recovery Code Not Match');
            return back()->with($notification) ;
        }else{
            $data = array();
            $data['recover_code'] = null ;
            DB::table('express')->where('email', $email)->update($data) ;
            
            if($this->agent->isDesktop()){
                return Redirect::to('change-password') ;
            }else{
                return Redirect::to('m/mpsc') ;
            }
        }

    }

    public function changePassword()
    {
        return view('forgot_password.frontPasswordChange');

}
    public function frontPasswordUpdate(Request $request)
    {
        $this->validate($request, [
            'new_password'      => 'min:8|required',
            'confirm_password'  => 'min:8|required_with:confirm_password|same:new_password',
        ]);


        $new_password 	    = $request->new_password ;
        $confirm_password 	= $request->confirm_password ;
        
        if($new_password != $confirm_password){
            Session::put('failed','Sorry! New password and confrim password not match.');
            return back();
        }
        
        $email          = decrypt(Session::get('recovery_email')) ;
        
        

        $salt      = 'a123A321';
        $password = sha1($new_password.$salt);

        $data                   = array();
        $data['password']       = $password ;
        DB::table('express')->where('email', $email)->update($data) ;

        $notification = array(
            'message'    => 'Password Change Succesfully Done', 
            'alert-type' => 'success'
        );
        
        Session::put('success', 'Password Change Succesfully Done');
        
        if($this->agent->isDesktop()){
            return Redirect::to('change-password')->with($notification) ;
        }else{
            return Redirect::to('m/signin')->with($notification) ;
        }
        
    }
    
    # MOBILE FORGOT PASSWORD 
    public function mforgotpassword()
    {
        return view('mobile.forgotpassword.mforgotpassword');
    }
    
    public function mpasswordrecovery()
    {
        return view('mobile.forgotpassword.mpasswordrecovery');
    }
    
    public function mpasswordchange()
    {
        return view('mobile.forgotpassword.mpasswordchange');
    }
    
    # RE SEND RECOVERY COD E
    public function resendpasswordRecoveryCode(Request $request)
    {
        $email = decrypt(Session::get('recovery_email'));
        $query = DB::table('express')->where('email',$email)->first();

        $email_code = encrypt($email);
        $to_name    = $query->first_name." ".$query->last_name;
        $to_email   = $email;

        $rand = rand(999999, 111111) ;
        Session::put('recovery_email', $email_code) ;
        
        $data = array('name'=>"Avail Trade ", 'body' => "Your Recovery Code Is : ". $rand);
        
        $smtpQuery = DB::table('tbl_smtp')->where('target','f')->first();
        $driver = $smtpQuery->mail_driver;
        $host = $smtpQuery->mail_host;
        $port = $smtpQuery->mail_port;
        $from_address = $smtpQuery->mail_username;
        $from_name = $smtpQuery->from_name;
        $mail_username = $smtpQuery->mail_username;
        $mail_password = $smtpQuery->mail_password;
        $encryption = $smtpQuery->mail_encryption;
        $rowid = $smtpQuery->id;
        
        $transport = (new SmtpTransport($host, $port, $encryption))
            ->setUsername($mail_username)
            ->setPassword($mail_password);


        $mailer = new Swift_Mailer($transport);

        Mail::setSwiftMailer($mailer);

        Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Foreget Password ');
            $message->from('avialtradebd@gmail.com',"avialtradebd");
        });
        
        $settings = DB::table('tbl_settings')->first() ;

        $data                       = array();
        $data['recover_code']       = $rand ;
        $data['code_expire_time']   = date("Y-m-d H:i:s",strtotime(date("Y-m-d H:i:s")." +$settings->timeout minutes")); ;
        DB::table('express')->where('email', $email)->update($data);

        echo "success";
        exit() ;
    }
    
    public function allHoldAccount()
    {
        $result = DB::table('express')
            ->leftJoin('tbl_package', 'express.package_id', '=', 'tbl_package.id')
            ->select('express.*', 'tbl_package.package_name')
            ->where('express.status', 3)
            ->where('express.attem_time', '>', 0)
            ->get() ;

        return view('admin.allHoldAccount')->with('result', $result) ;
    }


    public function changeHOldAccountToActive(Request $request)
    {
        $seller_id = $request->seller_id ;
    
        $main_data_s                = array();
        $main_data_s['fail_attem'] = 0 ;
        $main_data_s['block_time'] = null ;
        $main_data_s['attem_time'] = 0 ;
        $main_data_s['status']     = 1 ;
        DB::table('express')->where('id', $seller_id)->update($main_data_s) ;

        return "success"; 
    }


}
