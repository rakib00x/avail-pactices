<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;
use DB;
use Session;
use Str;
use Input;
use Hash;
use Mail;
use Cookie;
use \Swift_Mailer;
use \Swift_SmtpTransport as SmtpTransport;

class MobileFrontendController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate           = date('Y-m-d');
        $this->logged_id        = Session::get('admin_id');
        $this->current_time     = date('H:i:s');
        $this->current_date_time = date("Y-m-d H:i:s") ;
        
        $this->random_number_one = rand(10000 , 99999).mt_rand(1000000000, 9999999999);
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
        
        $clientIP_s = \Request::ip();
        
        $url = "http://ip-api.com/json/".$clientIP_s;

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
        // $countryCode = $geo_object->countryCode;
        
        $county_info = DB::table('tbl_countries')->where('stuas', 1)->first() ;
        
        $countryCode = $county_info->currencyCode;
        
        // dd($county_info);
        // exit();
        

        $getCount    = DB::table('tbl_currency_status')->where('code',$county_info->currencyCode)->count();
        if($getCount == 0){
            $currency_id = 1;
        }else{
            $getCurrency = DB::table('tbl_currency_status')->where('code', $county_info->currencyCode)->first();
            $currency_id = $getCurrency->id;
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
    
    //
    public function index()
    {
        $slider             = DB::table('tbl_slider')->where('type',1)->where('status',1)->get();

        $primarycategory    = DB::table('tbl_primarycategory')
                    ->where('supplier_id',0)
                    ->where('sidebar_active', 1)
                    ->orderBy('sidebar_decoration', 'asc')
                    ->where('status', 1)
                    ->take(7)
                    ->get();


        $feature_product  = DB::table('tbl_product')
            ->inRandomOrder()
            ->where('status', 1)
            ->take(12)
            ->get();

        $home_category_product = DB::table('tbl_home_category')
            ->where('status', 1)
            ->orderBy('home_descending', 'asc')
            ->get();

        $first_category_icon = DB::table('tbl_primarycategory')
                ->where('status', 1)
                ->inRandomOrder()
                ->limit(12)
                ->get() ;

        $second_category_icon = DB::table('tbl_secondarycategory')
                ->where('status', 1)
                ->inRandomOrder()
                ->limit(4)
                ->get() ;

        $top_category_value = DB::table('tbl_home_top_category')
            ->first() ;

        $secondary_category_value = DB::table('tbl_home_secondary_category')
            ->first() ;

        $weaklydeal = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->select(DB::raw('sum(quantity) as final_quantity'), 'order_product.*', 'tbl_product.visitor_count')
            ->groupBy('order_product.product_id')
            ->orderBy('final_quantity', 'desc')
            ->inRandomOrder()
            ->limit(3)
            ->get() ;

        $new_products  = DB::table('tbl_product')
            ->inRandomOrder()
            ->where('status', 1)
            ->take(3)
            ->orderBy('id', 'desc')
            ->get();
            
        
        if($this->agent->isDesktop()){
            $mobile_home_url = env("APP_URL");
            return Redirect::to($mobile_home_url);
        }else{
            return view('mobile.index')
            ->with('slider',$slider)
            ->with('primarycategory',$primarycategory)
            ->with('home_category_product',$home_category_product)
            ->with('first_category_icon',$first_category_icon)
            ->with('second_category_icon',$second_category_icon)
            ->with('top_category_value',$top_category_value)
            ->with('secondary_category_value',$secondary_category_value)
            ->with('weaklydeal',$weaklydeal)
            ->with('new_products',$new_products)
            ->with('feature_product',$feature_product);
        }
        
    }
    
    public function getmobileindexproduct(Request $request)
    {
        $start      = $request->start ;
        $limit      = $request->limit ;
        
        if($start < 481){
            $just_for_you = DB::table('tbl_product')
            ->where('tbl_product.status', 1)
            ->inRandomOrder()
            ->offset($start)
            ->limit($limit)
            ->get() ;
        }
        
        return view('mobile.getmobileindexproduct')->with('just_for_you', $just_for_you) ;
    }


    public function contactSupplier()
    {
        return view('mobile.contact-supplier');
    }

    public function signin()
    {
        if($this->agent->isDesktop()){
            return Redirect::to('login');
        }else{
            if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){
                return Redirect::to('') ;
            }else{
                return view('mobile.singin');
            }
        }

    }

    public function mobilelogin(Request $request)
    {
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
                
                if($remember){
                    setcookie('cookie_username', $email, time() + (86400 * 7), "/");
                    setcookie('cookie_password', $password, time() + (86400 * 7), "/");
                }


                if($query->type == 2){
                    
                    
                    Session::put('supplier_email',$query->email);
                    Session::put('supplier_id',$query->id);
                    Session::put('supplier_type',$query->type);
                    Session::put('seller_type', $query->seller_type);

                    $notification = array(
                        'message'    => 'Login granted successfully', 
                        'alert-type' => 'success',
                    );
                    
                    if ($request->prev != "") {
                        return redirect()->intended($request->prev)->with($notification);
                    }else{
                        return Redirect::to('/')->with($notification) ;
                    }
                    
                    
                }else if($query->type == 3){
                    
                    
                    $auth_number_length           = 30 ;
                    $auth_number                  = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'),1,$auth_number_length);
                    $track_no                     = rand(10000 , 99999) ;

                    Session::put('auth_number',$auth_number);
                    Session::put('track_no',$track_no);

                    Session::put('buyer_email', $query->email);
                    Session::put('buyer_id', $query->id);
                    Session::put('buyer_type', $query->type);

                    $notification = array(
                        'message'    => 'Login granted successfully', 
                        'alert-type' => 'success',
                    );
                    
                    if ($request->prev != "") {
                        return redirect()->intended($request->prev)->with($notification);
                    }else{
                        {}
                        return back()->with($notification) ;
                    }
                    
                   
                }
            }else{

                Session::put('login_faild', 'Verify Your Email First And Try Again.');

                $notification = array(
                    'message'    => 'Verify Your Email First And Try Again.', 
                    'alert-type' => 'failed',
                );
                return Redirect::to('m/signin')->with($notification) ;
            }
        }

        $verify_count = DB::table('express')
            ->where('verify_status', 0)
            ->where('status', 0)
            ->where($filed_name, $email)
            ->where('password', $encrypted)
            ->count();

        if ($verify_count > 0) {

            Session::put('login_faild', 'Verify Your Email First And Try Again.');

            $notification = array(
                'message'    => 'Verify Your Email First And Try Again.', 
                'alert-type' => 'failed',
            );
            return Redirect::to('m/signin')->with($notification) ;
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
                return Redirect::to('m/signin')->with($notification) ;
            }
        }else{
            Session::put('login_faild', 'Email Or Password Not Match');
            $notification = array(
                'message'    => 'Email Or Password Not Match', 
                'alert-type' => 'failed',
            );

            return Redirect::to('m/signin')->with($notification) ;
        }

    }

    public function signup()
    {
        return view('mobile.signup');
    }
     public function supplierSignup()
    {
    if($this->agent->isDesktop()){
         return Redirect::to('supplierregistration');
        }else{
        return view('mobile.supliersignup');
        }
    }
    
    public function checkSupplierStore(Request $request)
    {
        $storeName = trim($request->store_name);

        $count = DB::table('express')->where('storeName', $storeName)->where('type', 2)->count() ;
        if ($count > 0) {
            echo "failed";
            exit() ;
        }else{
            echo "success";
            exit() ;
        }
    }
    
    
    public function registrationStore(Request $request){
        
     

        $type		        = trim($request->user_type);
        $country	        = trim($request->country);
        $first_name         = trim($request->first_name);
        $last_name          = trim($request->last_name);
        $email 		        = trim($request->email);
        $mobile 	        = trim($request->mobile);
        $password 	        = trim($request->password);
        $repassword         = trim($request->repassword);
        $newsletter_status  = trim($request->newsletter);
        $store_name         = trim($request->store_name);
        
        
        
        if($type == 2){
            $full_name = $first_name." ".$last_name;
            $explode = explode(" ",$full_name);
            $final_store_name = implode("-",$explode);
        }else{
            if ($store_name != "") {
                $explode = explode(" ",$store_name);
                $final_store_name = implode("-",$explode);
            }else{
                $final_store_name = "";
            }
        }
        

        $count = DB::table('express')
        ->where('email', $email)
        ->count();

        // if(!preg_match("/^[a-zA-Z0-9]+$/", $store_name)){
        //     echo "regex_matched";
        //     exit();
        // }

        if($count > 0){
            echo "email_duplicate";
            exit() ;
        }

        $m_count = DB::table('express')
        ->where('mobile', $mobile)
        ->count();
        
        if($m_count > 0){
            echo "mobile_duplicate";
            exit() ;
        }
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            echo "invalid_mail";
            exit() ;
        }

        if($newsletter_status != 1){
            echo "news_status" ;
            exit() ;
        }

       
       $salt       = 'a123A321';
        $passwordss = sha1($password.$salt);
        
         if($type == 2){
            $seller_type = 1; 
        }else{
            $seller_type = 0;
        }

        $data = array();
        $data['type'] 		        = $type;
        $data['country']  	        = $country;
        $data['first_name']         = $first_name;
        $data['last_name']          = $last_name;
        $data['seller_type'] 		= $seller_type;
        $data['email']              = $email;
        $data['storeName']  	    = $final_store_name;
        $data['mobile']  	        = $mobile;
        $data['password']           = $passwordss;
        $data['newsletter_status']  = $newsletter_status;
        $data['created_at']         = $this->rcdate;
        $data['status']             = 0;
        $data['profile_verify_status'] = 1;
        $data['token'] 		        = Str::random(32);
        
        $query = DB::table('express')->insert($data);
        
        $email_code = encrypt($email);

        $site_url = 'https://availtrade.com/verify/'.$email_code ;
        $to_name = $first_name." ".$last_name;
        $to_email = $email;
        $data = array('name'=>"Avail Trade", 'body' => "Your Verification Url Is : ". $site_url);
        
        $smtpQuery = DB::table('tbl_smtp')->where('target','r')->first();
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
            $message->to($to_email, $to_name)->subject('Verifycation Mail');
            $message->from('registration@availtrade.com',"avialtradebd");
        });

        echo "success";
        exit() ;

    }
    public function checkSupplierStoreName(Request $request)
    {
        $storeName = trim($request->store_name);

        $count = DB::table('express')->where('storeName', $storeName)->where('type', 2)->count() ;
        if ($count > 0) {
            echo "failed";
            exit() ;
        }else{
            echo "success";
            exit() ;
        }
    }

    public function verify($email){
        $social = DB::table('tbl_social_media')->first();
        $email                  = decrypt($email);
        $data                   = array();
        $data['verify_status']  = 1;
        $data['status']         = 1;
        $query = DB::table('express')->where('email', $email)->update($data);

        $supplier_info = DB::table('express')->where('email',$email)->first() ;

        $data2                      = array() ;
        $data2['supplier_id']       = $supplier_info->id ;
        $data2['background_color']  = '#000000';
        $data2['font_color']        = '#ffffff';
        $data2['hover_color']       = '#0a7208';
        $data2['created_at']        = date("Y-m-d");
        DB::table('tbl_supplier_header_settings')->insert($data2) ;

        $notification = array(
            'message'       => 'Mail Verification Successfully Completed',
            'alert-type'    => 'success'
        );

        Session::put('success', "Mail Verification Successfully Completed");
        return Redirect::to('login')->with('social',$social)->with($notification);
    }
    public function registrationEmailCheck(Request $request)
    {
        $email = trim($request->email) ;
        $check = DB::table('express')->where('email', $email)->count();
        if ($check > 0) {
            echo "<p style='color:red;'> ".$email." Email already Exist. </p>" ;
        }else{
            echo "" ;
        }
    }

    public function registrationMobileCheck(Request $request)
    {
        $mobile = trim($request->mobile) ;
        $check = DB::table('express')->where('mobile', $mobile)->count();
        if ($check > 0) {
            echo "<p style='color:red;'>This ".$mobile." Mobile Number already Exist. </p>" ;
        }else{
            echo "" ;
        }
    }
    public function SubscribeInfo(Request $request)
    {
        $email = $request->email;
        
        $duplicate = DB::table('tbl_subscribes')->where('email', $email)->count() ;
        if($duplicate > 0){
            echo "email_exist";
            exit();
        }
        
        $data = array() ;
        $data['email'] = $email ;
        $data['status'] = 1 ;
        $data['created_at'] = date("Y-m-d H:i:s") ;
        
        $query = DB::table('tbl_subscribes')->insert($data);
        if($query){
            echo "success";
            exit();
        }else{
            echo "failed";
            exit ;
        }
    }

    public function primarycategoryindex($category_slug, $pricefilter)
    {
        
        $all_catgeory_1 = DB::table('tbl_secondarycategory')
            ->join('tbl_primarycategory', 'tbl_secondarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_secondarycategory.*', 'tbl_primarycategory.catgeory_slug', 'tbl_primarycategory.category_name')
            ->where('tbl_primarycategory.catgeory_slug', $category_slug)
            ->where('tbl_secondarycategory.status', 1)
            ->limit(6)
            ->inRandomOrder()
            ->get() ;

        if ($pricefilter == "heightolow") {
            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_primarycategory.catgeory_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_primarycategory.catgeory_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'desc')
                ->paginate(5) ;

        }else{
            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_primarycategory.catgeory_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_primarycategory.catgeory_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'asc')
                ->paginate(5) ;
                
        }
    

        $category_info = DB::table('tbl_primarycategory')
            ->where('catgeory_slug', $category_slug)
            ->first() ;

        $all_catgeory_2 = DB::table('tbl_secondarycategory')
            ->join('tbl_primarycategory', 'tbl_secondarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_secondarycategory.*', 'tbl_primarycategory.catgeory_slug', 'tbl_primarycategory.category_name')
            ->where('tbl_primarycategory.catgeory_slug', $category_slug)
            ->where('tbl_secondarycategory.status', 1)
            ->limit(8)
            ->inRandomOrder()
            ->get() ;        

        $all_catgeory_3 = DB::table('tbl_secondarycategory')
            ->join('tbl_primarycategory', 'tbl_secondarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_secondarycategory.*', 'tbl_primarycategory.catgeory_slug', 'tbl_primarycategory.category_name')
            ->where('tbl_primarycategory.catgeory_slug', $category_slug)
            ->where('tbl_secondarycategory.status', 1)
            ->limit(6)
            ->inRandomOrder()
            ->get() ;

        $category_slider =DB::table('tbl_category_slider')
            ->where('status', 1)
            ->where('primary_category_id', $category_info->id)
            ->get() ; 
            
        
        if($this->agent->isDesktop()){
            $mobile_home_url =  env("APP_URL")."category/".$category_slug.'/'.$pricefilter;
            return Redirect::to($mobile_home_url);
        }else{
            return view('mobile.primarycategoryindex')->with('all_catgeory_1', $all_catgeory_1)->with('all_product', $all_product)->with('category_info', $category_info)->with('all_catgeory_2', $all_catgeory_2)->with('category_slider', $category_slider)->with('all_catgeory_3', $all_catgeory_3)->with('category_slug', $category_slug)->with('pricefilter',$pricefilter);
        }
        
    }


    public function getmaincategoryproductpaginate(Request $request)
    {
        $page           = $request->page ;
        $pricefilter    = $request->pricefilter ;
        $category_slug  = $request->category_slug ;
        $limit          = $request->limit ;
        $start          = $request->start ;


        if ($pricefilter == "heightolow") {
            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_primarycategory.catgeory_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_primarycategory.catgeory_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'desc')
                ->limit($limit)
                ->offset($start)
                ->get() ;

        }else{
            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_primarycategory.catgeory_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_primarycategory.catgeory_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'asc')
                ->limit($limit)
                ->offset($start)
                ->get() ;
                
        }

        
        return view('mobile.getmaincategoryproductpaginate')->with('all_product', $all_product);
    }

    public function secondarycategoryindex($category_slug, $pricefilter)
    {
        $tertiary_category = DB::table('tbl_tartiarycategory')
            ->join('tbl_secondarycategory', 'tbl_tartiarycategory.secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->select('tbl_tartiarycategory.*', 'tbl_secondarycategory.secondary_category_slug', 'tbl_secondarycategory.secondary_category_name')
            ->where('tbl_secondarycategory.secondary_category_slug', $category_slug)
            ->where('tbl_tartiarycategory.status', 1)
            ->limit(6)
            ->inRandomOrder()
            ->get() ;

        if ($pricefilter == 'heightolow') {

            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_secondarycategory.secondary_category_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                    ->orderBy('tbl_product_price.product_price', 'desc')
                ->paginate(16) ;

        }else{

            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_secondarycategory.secondary_category_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                    ->orderBy('tbl_product_price.product_price', 'asc')
                ->paginate(16) ;

        }

        $secondary_category = DB::table('tbl_secondarycategory')
            ->where('secondary_category_slug', $category_slug) 
            ->first() ;
        
        
        if($this->agent->isDesktop()){
            $mobile_home_url = env("APP_URL")."seccategory/".$category_slug."/".$pricefilter;
            return Redirect::to($mobile_home_url);
        }else{
            return view('mobile.secondarycategoryindex')->with('tertiary_category', $tertiary_category)->with('all_product', $all_product)->with('pricefilter', $pricefilter)->with('category_slug', $category_slug)->with('secondary_category', $secondary_category);
        }
        
    }

    public function getsecondarycategoryproductpaginate(Request $request)
    {
        $page           = $request->page ;
        $pricefilter    = $request->pricefilter ;
        $category_slug  = $request->category_slug ;
        $limit          = $request->limit ;
        $start          = $request->start ;


        if ($pricefilter == 'heightolow') {

            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_secondarycategory.secondary_category_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'desc')
                ->limit($limit)
                ->offset($start)
                ->get() ;

        }else{

            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_secondarycategory.secondary_category_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                    ->orderBy('tbl_product_price.product_price', 'asc')
                ->limit($limit)
                ->offset($start)
                ->get() ;

        }

        return view('mobile.getsecondarycategoryproductpaginate')->with('all_product', $all_product) ;
    }


    public function tertiarycategoryindex($category_slug, $pricefilter)
    {
        if ($pricefilter == 'heightolow') {
            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->join('tbl_tartiarycategory', 'tbl_product.w_tertiary_categroy_id', '=', 'tbl_tartiarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name','tbl_tartiarycategory.tartiary_category_name','tbl_tartiarycategory.tartiary_category_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_tartiarycategory.tartiary_category_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'desc')
                ->paginate(12) ;
        }else{
            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->join('tbl_tartiarycategory', 'tbl_product.w_tertiary_categroy_id', '=', 'tbl_tartiarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name','tbl_tartiarycategory.tartiary_category_name','tbl_tartiarycategory.tartiary_category_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_tartiarycategory.tartiary_category_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'asc')
                ->paginate(12) ;
        }

        $tertiary_category = DB::table('tbl_tartiarycategory')->where('tartiary_category_slug', $category_slug)->first() ;
        

        return view('mobile.tertiarycategoryindex')->with('all_product', $all_product)->with('pricefilter', $pricefilter)->with('category_slug', $category_slug)->with('tertiary_category', $tertiary_category);
    }

    public function gettertiarycategoryproductpaginate(Request $request)
    {
        $page           = $request->page ;
        $pricefilter    = $request->pricefilter ;
        $category_slug  = $request->category_slug ;
        $limit          = $request->limit ;
        $start          = $request->start ;

        if ($pricefilter == 'heightolow') {
            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->join('tbl_tartiarycategory', 'tbl_product.w_tertiary_categroy_id', '=', 'tbl_tartiarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name','tbl_tartiarycategory.tartiary_category_name','tbl_tartiarycategory.tartiary_category_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_tartiarycategory.tartiary_category_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'desc')
                ->limit($limit)
                ->offset($start)
                ->get() ;
        }else{
            $all_product = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->join('tbl_tartiarycategory', 'tbl_product.w_tertiary_categroy_id', '=', 'tbl_tartiarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name','tbl_tartiarycategory.tartiary_category_name','tbl_tartiarycategory.tartiary_category_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_tartiarycategory.tartiary_category_slug', $category_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'asc')
                ->limit($limit)
                ->offset($start)
                ->get() ;
        }

        return view('mobile.gettertiarycategoryproductpaginate')->with('all_product', $all_product) ;
    }


    public function productdetails(Request $request, $slug)
    {
        $slug       = $request->slug;
        $social     = DB::table('tbl_social_media')->first();
        $ptitle     = DB::table('tbl_product')->where('slug',$slug)->get();
        $product    = DB::table('tbl_product')
            ->where('slug',$slug)
            ->first();

        $supplier_info = DB::table('express')->where('id', $product->supplier_id)->first();

        $feature_product  = DB::table('tbl_product')->inRandomOrder()->take(18)->get();
        $data = array() ;
        $data['visitor_count'] = $product->visitor_count+1 ;
        DB::table('tbl_product')->where('slug', $slug)->update($data);
        
    
        $agent = new Agent;
        $desktopResult= $agent->isDesktop();
        if ($desktopResult) {
            $mobile_home_url = env("APP_URL")."product/".$slug;
            return Redirect::to($mobile_home_url);
        }else{
            return view('mobile.productdetails')
                ->with('social',$social)
                ->with('ptitle',$ptitle)
                ->with('feature_product',$feature_product)
                ->with('supplier_info',$supplier_info)
                ->with('product',$product);
        }
    }

    # get all primary catgeory 
    public function allprimarycategorylist()
    {
       $all_primary_category = DB::table('tbl_primarycategory')
        ->where('status', 1)
        ->get() ;

        return view('mobile.allprimarycategorylist')->with('all_primary_category', $all_primary_category) ;
    }

    # get SECONDARY CATGEORY 
    public function allsecondarycategory($category_slug)
    {


        $all_secondary_category = DB::table('tbl_secondarycategory')
            ->join('tbl_primarycategory', 'tbl_secondarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_secondarycategory.*', 'tbl_primarycategory.category_name', 'tbl_primarycategory.catgeory_slug')
            ->where('tbl_secondarycategory.status', 1)
            ->where('tbl_primarycategory.catgeory_slug', $category_slug)
            ->get() ;
        
        $primary_category = DB::table('tbl_primarycategory')
            ->where('catgeory_slug', $category_slug)
            ->first() ;


        return view('mobile.allsecondarycategory')->with('all_secondary_category', $all_secondary_category)->with('primary_category', $primary_category) ;
    }

    # GET SEARCH RESULT 
    public function searchresult(Request $request)
    {
        $keywords = $request->search_keyword;

        $all_product = DB::table('tbl_product')
            ->where('status', 1)
            ->where('product_name', 'like', '%'.$keywords.'%')
            ->paginate(12) ;
        $pricefilter = "heightolow" ;
        
        
        if($this->agent->isDesktop()){
            $mobile_home_url = env("APP_URL")."search?search_type=product&keywords=".$keywords."&viewType=L";
            return Redirect::to($mobile_home_url);
        }else{
            return view('mobile.searchresult')->with('all_product', $all_product)->with('keywords', $keywords)->with('pricefilter', $pricefilter) ;
        }
        
    }
    
    public function addQueryMessage(Request $request)
    {
         $subject        = $request->subject;
        $message        = $request->message;
        $product_slug   = $request->product_slug;

        
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }
        
        if($customer_id == "" || $customer_id == null){
            $notification = array(
                'message'    => 'Please Login First.', 
                'alert-type' => 'failed',
            );
            return Redirect::to('m/product/'.$product_slug)->with($notification);
        }
        
        $supplier_info = DB::table('tbl_product')
            ->join('express', 'tbl_product.supplier_id', '=', 'express.id')
            ->select('tbl_product.*', 'express.storeName', 'express.email')
            ->where('tbl_product.slug', $product_slug)
            ->first() ;

        $customer_info  = DB::table('express')->where('id', $customer_id)->first();
        $to_name        = $customer_info->first_name." ".$customer_info->last_name;
        $to_email       = $customer_info->email;

        $message_body   = "Product ".$supplier_info->product_name." Message: ".$request->message.".Quotation Quantity : ".$request->start_quantity." ".$request->unit_name;
        if($request->start_quantity){
            $total_quantity = $request->start_quantity;
        }else{
            $total_quantity = 0;
        }

        $data2 = array() ;
        $data2['customer_id']    = $customer_id; 
        $data2['supplier_id']    = $supplier_info->supplier_id; 
        $data2['product_id']     = $supplier_info->id;
        $data2['quantity']       = $total_quantity; 
        $data2['unit_name']      = $request->unit_name; 
        $data2['subject']        = $subject; 
        $data2['message']        = $message_body; 
        $data2['status']         = 0; 
        $data2['created_at']     = date("Y-m-d H:i:s"); 
        $query = DB::table('tbl_supplier_quotation')->insert($data2);
        
        $products_image_explode = explode("#",$supplier_info->products_image);
        $product_images = $products_image_explode[0];
        
        // Chatting part
        $chat = array();
        $chat['chatting_id']    = Str::random(32);
        $chat['sender_id']      = $customer_id;
        $chat['receiver_id']    = $supplier_info->supplier_id;
        $chat['product_id']     = $supplier_info->id;
        $chat['message']        = $message;
        $chat['image']          = $product_images;
        $chat['is_read']        = '0';
        $chat['created_at']     = date("Y-m-d H:i:s"); 
        DB::table('tbl_messages')->insert($chat);
        
        
        $data['title']           = "Availtrade Quotation";
        $data['subject']         = $subject;
        $data['contact_email']   = $to_email;
        $data['name']            = $to_name;
        $data['contact_message'] = $message_body;
        $data['to_email']        = $supplier_info->email;


        $result=  Mail::send(['html' => 'emails.quotation'], $data, function($message) use ($data){
            $message->to($data['to_email']);
            $message->subject($data['subject']);
            $message->from($data['contact_email'], $data['name']);
            $message->replyTo($data['contact_email']);
        });
        

        $notification = array(
            'message'    => 'Quotation send successfully', 
            'alert-type' => 'info',
        );
        return Redirect::to('m/product/'.$product_slug)->with($notification);
    }

    # get search result paginate 
    public function getsearchresultpaginate(Request $request)
    {
        $keywords       = $request->keywords;
        $limit          = $request->limit;
        $start          = $request->start;
        $pricefilter    = $request->pricefilter ;

        $all_product = DB::table('tbl_product')
            ->where('status', 1)
            ->where('product_name', 'like', '%'.$keywords.'%')
            ->limit($limit)
            ->offset($start)
            ->get() ;
 

        return view('mobile.getsearchresultpaginate')->with('all_product', $all_product)->with('keywords', $keywords)->with('pricefilter', $pricefilter) ;
    }

    # logout 
    public function signout()
    {
        Session::put('email', null);
        Session::put('supplier_id', null);
        Session::put('type', null);

        Session::put('email', null);
        Session::put('buyer_id', null);
        Session::put('type', null);


        $notification = array(
            'message'    => 'Logout Succesfully Done', 
            'alert-type' => 'failed',
        );

        return Redirect::to('m/signin')->with($notification) ;
    }

    public function register()
    {
        if($this->agent->isDesktop()){
            return Redirect::to('registration');
        }else{
            return view('mobile.signup') ;
        }
        
    }
    
    public function suppliermobile(Request $request, $storename)
    {

        $pricefilter = 'lowtohigh';
        
        $supplier_info = DB::table('express')
        ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
        ->select('express.*', 'tbl_countries.countryCode', 'tbl_countries.countryName')
        ->where('express.storeName', $storename)
        ->first() ;
        
        $all_slider = DB::table('tbl_slider')->where('supplier_id', $supplier_info->id)->where('status', 1)->get();
        
        $just_for_you = DB::table('tbl_product')
            ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
            ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
            ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
            ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->join('tbl_tartiarycategory', 'tbl_product.w_tertiary_categroy_id', '=', 'tbl_tartiarycategory.id')
            ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name','tbl_tartiarycategory.tartiary_category_name','tbl_tartiarycategory.tartiary_category_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
            ->where('tbl_product.status', 1)
            ->groupBy('tbl_product_price.product_id')
            ->orderBy('tbl_product_price.product_price', 'asc')
            ->where('tbl_product.supplier_id', $supplier_info->id)
            ->paginate(12) ;

        if($this->agent->isDesktop()){
            $mobile_home_url = env("APP_URL")."store/".$storename;
            return Redirect::to($mobile_home_url);
        }else{
            return view('mobile.storemain')->with('supplier_info', $supplier_info)->with('all_slider', $all_slider)->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter);
        }
        
    }
    
    # HOME PRICE FILTER 
    public function suppliermobilepagevlauewithfilter(Request $request)
    {
        $pricefilter = $request->pricefilter ;
        $store_id = $request->store_id ;
        $start      = $request->start ;
        $limit      = $request->limit ;
        
        
        if($pricefilter == "lowtohigh"){
            $just_for_you = DB::table('tbl_product')
            ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
            ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
            ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
            ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->join('tbl_tartiarycategory', 'tbl_product.w_tertiary_categroy_id', '=', 'tbl_tartiarycategory.id')
            ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name','tbl_tartiarycategory.tartiary_category_name','tbl_tartiarycategory.tartiary_category_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
            ->where('tbl_product.status', 1)
            ->groupBy('tbl_product_price.product_id')
            ->orderBy('tbl_product_price.product_price', 'asc')
            ->where('tbl_product.supplier_id', $store_id)
            ->offset($start)
            ->limit($limit)
            ->get() ;
        }else{
            $just_for_you = DB::table('tbl_product')
            ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
            ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
            ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
            ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->join('tbl_tartiarycategory', 'tbl_product.w_tertiary_categroy_id', '=', 'tbl_tartiarycategory.id')
            ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name','tbl_tartiarycategory.tartiary_category_name','tbl_tartiarycategory.tartiary_category_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
            ->where('tbl_product.status', 1)
            ->groupBy('tbl_product_price.product_id')
            ->orderBy('tbl_product_price.product_price', 'desc')
            ->where('tbl_product.supplier_id', $store_id)
            ->offset($start)
            ->limit($limit)
            ->get() ;
        }
        
        return view('mobile.suppliermobilepagevlauewithfilter')->with('just_for_you', $just_for_you) ;
    }
    
    # GET HOME PAGE PAGINATE 
    public function getsuppliermobilepagepagination(Request $request)
    {
        $page           = $request->page ;
        $pricefilter    = $request->pricefilter ;
        $store_id       = $request->store_id ;
        $limit          = $request->limit ;
        $start          = $request->start ;

        if ($pricefilter == 'heightolow') {
            $just_for_you = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->join('tbl_tartiarycategory', 'tbl_product.w_tertiary_categroy_id', '=', 'tbl_tartiarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name','tbl_tartiarycategory.tartiary_category_name','tbl_tartiarycategory.tartiary_category_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $store_id)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'desc')
                ->limit($limit)
                ->offset($start)
                ->get() ;
        }else{
            $just_for_you = DB::table('tbl_product')
                ->join('tbl_product_price', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
                ->join('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
                ->join('tbl_tartiarycategory', 'tbl_product.w_tertiary_categroy_id', '=', 'tbl_tartiarycategory.id')
                ->select('tbl_product.*', 'tbl_primarycategory.category_name', 'tbl_currency_status.symbol', 'tbl_secondarycategory.secondary_category_slug','tbl_unit_price.unit_name','tbl_tartiarycategory.tartiary_category_name','tbl_tartiarycategory.tartiary_category_slug', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $store_id)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'asc')
                ->limit($limit)
                ->offset($start)
                ->get() ;
        }
        
        return view('mobile.getsuppliermobilepagepagination')->with('just_for_you', $just_for_you) ;
    }
    
    # SUPPLIER MAIN PAGE 
    public function sproduct($storename, $pricefilter)
    {
        echo $pricefilter ;
        exit() ;
    }
    
    # ADMIN SECTOIN 
    public function mobilechangeCurrency($currency_id)
    {
        $agent = new Agent ;
    
        Session::put('requestedCurrency', null);
        Session::put('requestedCurrency',$currency_id);
        Cookie::queue('cookie_currency', $currency_id, 525000);
        Cache::put('cookie_currency', $currency_id, 525000);
        Cache::put('cookie_browser', $agent->browser(), 525000);
        Cache::put('cookie_device', $agent->platform(),525000);

        return back() ;
     }
     
    public function mssearch(Request $request, $store)
    {
        $pricefilter         = $request->filter ;
        $keywords = $request->keywords ;
        
        $supplier_info = DB::table('express')
        ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
        ->select('express.*', 'tbl_countries.countryCode', 'tbl_countries.countryName')
        ->where('express.storeName', $store)
        ->first() ;
        $supplier_id = $supplier_info->id;
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
            
        if($pricefilter == "heightolow"){
            
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_product.product_name', 'LIKE', '%'.keywords.'%')
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->get() ;

                
        }else{

            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_product.product_name', 'LIKE', '%'.$keywords.'%')
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->get() ;
                
            
        }
        
        return view('mobile.mssearch')->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('keywords', $keywords)->with('supplier_info', $supplier_info) ;
    }    
    
    public function suppliersearchmobilepagevlauewithfilter(Request $request, $store)
    {
        $keywords       = $request->keywords;
        $pricefilter    = $request->filter ;
        $supplier_id    = $request->store_id ;
    

        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
            
        if($pricefilter == "heightolow"){
            
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_product.product_name', 'LIKE', '%'.keywords.'%')
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->get() ;

                
        }else{
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_product.product_name', 'LIKE', '%'.$keywords.'%')
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->get() ;

        }
        
        return view('mobile.getsuppliesearchrmobilepagepagination')->with('just_for_you', $just_for_you) ;
    }
    
    public function getsuppliesearchrmobilepagepagination(Request $request)
    {
        $keywords       = $request->keywords;
        $limit          = $request->limit;
        $start          = $request->start;
        $pricefilter    = $request->pricefilter ;
        $supplier_id    = $request->store_id ;

        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
            
        if($pricefilter == "heightolow"){
            
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_product.product_name', 'LIKE', '%'.keywords.'%')
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->limit($limit)
                ->offset($start)
                ->get() ;

                
        }else{

            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_product.product_name', 'LIKE', '%'.$keywords.'%')
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->limit($limit)
                ->offset($start)
                ->get() ;

        }
        
        return view('mobile.getsuppliesearchrmobilepagepagination')->with('just_for_you', $just_for_you) ;
    }
    
    # MOBIILE SUPPLIER CATEGORYS 
    public function smcatgeorys(Request $request, $store)
    {
        $supplier_info = DB::table('express')
            ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
            ->select('express.*', 'tbl_countries.countryCode', 'tbl_countries.countryName')
            ->where('express.storeName', $store)
            ->first() ;
        $supplier_id = $supplier_info->id;
         $all_slider = DB::table('tbl_slider')->where('supplier_id', $supplier_id)->where('status', 1)->get();
        
        $all_primary_category = DB::table('tbl_supplier_primary_category')
            ->where('supplier_id', $supplier_id)
            ->where('status', 1)
            ->get() ;

        return view('mobile.smcatgeorys')->with('all_primary_category', $all_primary_category)->with('supplier_info', $supplier_info)->with('all_slider', $all_slider) ;
    }
    # MOBIILE SUPPLIER Overview 
    public function companyoverview(Request $request, $store)
    {
       $store_info = DB::table('express')
            ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
            ->select('express.*', 'tbl_countries.countryCode')
            ->where('express.storeName', $store)
            ->first() ;

        return view('mobile.company-overview')->with('store_info', $store_info) ;
    }
    
    # get supplier primary category wise product 
    public function suppleirprimarycategoryproduct($store, $categoryslug, $pricefilter)
    {
        
        $supplier_info = DB::table('express')
        ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
        ->select('express.*', 'tbl_countries.countryCode', 'tbl_countries.countryName')
        ->where('express.storeName', $store)
        ->first() ;
        $supplier_id = $supplier_info->id;
        
        $all_slider = DB::table('tbl_slider')->where('supplier_id', $supplier_id)->where('status', 1)->get();
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
            
        if($pricefilter == "heightolow"){
            
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_primary_category.catgeory_slug', $categoryslug)
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(12) ;

                
        }else{

            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_primary_category.catgeory_slug', $categoryslug)
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(12) ;

        }
        
        $allsecondarycategorys =  DB::table('tbl_supplier_secondary_category')
            ->join('tbl_supplier_primary_category', 'tbl_supplier_secondary_category.primary_category_id', '=', 'tbl_supplier_primary_category.id')
            ->select('tbl_supplier_secondary_category.*', 'tbl_supplier_primary_category.catgeory_slug')
            ->where('tbl_supplier_primary_category.catgeory_slug', $categoryslug)
            ->where('tbl_supplier_secondary_category.status', 1)
            ->limit(6)
            ->inRandomOrder()
            ->get() ;

        
        return view('mobile.suppleirprimarycategoryproduct')->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('categoryslug', $categoryslug)->with('supplier_info', $supplier_info)->with('allsecondarycategorys', $allsecondarycategorys)->with('all_slider',  $all_slider);
    }
    
    # MOBILE SUPPLIER PRIMARY CATGEORY PRICE FILTERING 
    public function getsupplierprimarycategryfilter(Request $request, $store)
    {
        $supplier_id = $request->store_id ;
        $pricefilter = $request->pricefilter ;
        $categoryslug = $request->categoryslug ;
        
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
            
        if($pricefilter == "heightolow"){
            
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_primary_category.catgeory_slug', $categoryslug)
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(12) ;

                
        }else{

            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_primary_category.catgeory_slug', $categoryslug)
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(12) ;

        }
        
        return view('mobile.getsupplierprimarycategryfilter')->with('just_for_you', $just_for_you);
    }
    
    # MOBILE SUPPLIER PRIMARY CATGEORY PRICE FILTERING 
    public function getmoiblesupplierprimarycategoryproductpanigate(Request $request, $store)
    {
        $supplier_id    = $request->store_id ;
        $pricefilter    = $request->pricefilter ;
        $categoryslug   = $request->categoryslug ;
        $limit          = $request->limit ;
        $start          = $request->start ;
        
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
            
        if($pricefilter == "heightolow"){
            
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_primary_category.catgeory_slug', $categoryslug)
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->limit($limit)
                ->offset($start)
                ->get() ;

                
        }else{

            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_primary_category.catgeory_slug', $categoryslug)
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->limit($limit)
                ->offset($start)
                ->get() ;

        }
        
        return view('mobile.getmoiblesupplierprimarycategoryproductpanigate')->with('just_for_you', $just_for_you);
    }
    
    # MOBILE SECONDARY CATEGORY PRODUCT 
    public function suppliersecondarycategoryproduct($store, $categoryslug, $pricefilter)
    {
        $supplier_info = DB::table('express')
        ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
        ->select('express.*', 'tbl_countries.countryCode', 'tbl_countries.countryName')
        ->where('express.storeName', $store)
        ->first() ;
        $supplier_id = $supplier_info->id;
         $all_slider = DB::table('tbl_slider')->where('supplier_id', $supplier_id)->where('status', 1)->get();
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
            
        if($pricefilter == "heightolow"){
            
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->join('tbl_supplier_secondary_category', 'tbl_product.secondary_category_id', '=', 'tbl_supplier_secondary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate', 'tbl_supplier_secondary_category.secondary_category_slug')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_secondary_category.secondary_category_slug', $categoryslug)
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(12) ;

                
        }else{

            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->join('tbl_supplier_secondary_category', 'tbl_product.secondary_category_id', '=', 'tbl_supplier_secondary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate', 'tbl_supplier_secondary_category.secondary_category_slug')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_secondary_category.secondary_category_slug', $categoryslug)
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(12) ;

        }

        return view('mobile.suppliersecondarycategoryproduct')->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('categoryslug', $categoryslug)->with('supplier_info', $supplier_info)->with('all_slider', $all_slider);
    }
    
    # SUPPILER SECONDARY CATEGORY 
    public function getsuppliersecondarycategryfilter(Request $request)
    {
        $pricefilter    = $request->pricefilter;
        $categoryslug   = $request->categoryslug;
        $supplier_id    = $request->store_id;
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
        
        if($pricefilter == "heightolow"){
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->join('tbl_supplier_secondary_category', 'tbl_product.secondary_category_id', '=', 'tbl_supplier_secondary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate', 'tbl_supplier_secondary_category.secondary_category_slug')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_secondary_category.secondary_category_slug', $categoryslug)
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(12) ;

                
        }else{

            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->join('tbl_supplier_secondary_category', 'tbl_product.secondary_category_id', '=', 'tbl_supplier_secondary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate', 'tbl_supplier_secondary_category.secondary_category_slug')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_secondary_category.secondary_category_slug', $categoryslug)
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(12) ;

        }
        
        return view('mobile.getsuppliersecondarycategryfilter')->with('just_for_you', $just_for_you);
    }
    
    public function getmoiblesuppliersecondarycategoryproductpanigate(Request $request)
    {

        $supplier_id    = $request->store_id ;
        $pricefilter    = $request->pricefilter ;
        $categoryslug   = $request->categoryslug ;
        $limit          = $request->limit ;
        $start          = $request->start ;
        
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
            
        if($pricefilter == "heightolow"){
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->join('tbl_supplier_secondary_category', 'tbl_product.secondary_category_id', '=', 'tbl_supplier_secondary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate', 'tbl_supplier_secondary_category.secondary_category_slug')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_secondary_category.secondary_category_slug', $categoryslug)
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->limit($limit)
                ->ofset($start)
                ->get() ;

                
        }else{

            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->join('tbl_supplier_secondary_category', 'tbl_product.secondary_category_id', '=', 'tbl_supplier_secondary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate', 'tbl_supplier_secondary_category.secondary_category_slug')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_supplier_secondary_category.secondary_category_slug', $categoryslug)
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->limit($limit)
                ->ofset($start)
                ->get() ;
        }
        
        return view('mobile.getmoiblesuppliersecondarycategoryproductpanigate')->with('just_for_you', $just_for_you);
    }
    
    # MOBILE PACKAGE 
    public function mobilepackage()
    {
        $package_category_list  = DB::table('tbl_package_category')->where('status', 1)->get() ;
         
        return view('mobile.mobilepackage')->with('package_category_list', $package_category_list);
    }
  public function terms()
    {
        $terms = DB::table('tbl_terms')->first() ;
         
        return view('mobile.termscondition',compact('terms'));
    }
    public function privacy()
    {
        $privacy = DB::table('tbl_privacy')->get() ;
         
        return view('mobile.privacy',compact('privacy'));
    }
    
    public function contact()
    {
        return view('mobile.contact');
    }
    public function fcontact(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);
        
        $data                   = array() ;
       $data['name']    = $request->name;
       $data['email']    = $request->email;
       $data['phone']    = $request->phone;
      $data['subject']    = $request->subject;
        $data['message']    = $request->message;
       $query = DB::table('contact')->insert($data) ;
       if($query){
         $notification = array(
            'message'       => 'Contact Message Sent Successfully',
            'alert-type'    => 'success'
        );
        return back()->with($notification) ;
        
        }else{
            echo "Your Message not send" ;
            exit();
            
        }
        
    }
    
       # SAVE CUSTOMER ADDRESS 
    public function addNewAddress(Request $request)
    {
        $country        = $request->country ;
        $address        = $request->address ;
        $state          = $request->state ;
        $city           = $request->city ;
        $zip_code       = $request->zip_code ;
        $contact_name   = $request->contact_name ;
        $phone_number   = $request->phone_number ;
        $express_id   = $request->express_id ;

        $check_duplicate = DB::table('tbl_shipping_address')
        ->where('country_id', $country)
        ->where('address', $address)
        ->where('state_name', $state)
        ->where('city_name', $city)
        ->where('zip_code', $zip_code)
        ->where('contact_name', $contact_name)
        ->where('mobile_number', $phone_number)
        ->where('express_id', $express_id)
        ->Count() ;

        if($check_duplicate > 0){

            $notification = array(
                'message'       => 'Adress Information Already Exist',
                'alert-type'    => 'failed'
            );

            return back()->with($notification) ;

        }

        $check_has_address = DB::table('tbl_shipping_address')->where('express_id', $express_id)->count() ;
        if($check_has_address == 0){
            $status = 1 ;
        }else{
            $status = 0 ;
        }

        $data                   = array();
        $data['country_id']     = $country;
        $data['address']        = $address;
        $data['state_name']     = $state;
        $data['city_name']      = $city;
        $data['zip_code']       = $zip_code;
        $data['contact_name']   = $contact_name;
        $data['mobile_number']  = $phone_number;
        $data['express_id']     = $express_id;
        $data['status']         = $status;

        DB::table('tbl_shipping_address')->insert($data);

        $notification = array(
            'message'       => 'Adress Information Add Successfully',
            'alert-type'    => 'success'
        );

        return back()->with($notification) ;
    }
    
     public function addChangeAddress(Request $request)
    {
        $address_id = $request->address_id ;
        $express_id = $request->express_id ;

        $data = array();
        $data['status'] = 0 ;
        DB::table('tbl_shipping_address')->where('express_id', $express_id)->whereNotIn('id', [$address_id])->update($data);


        $data_1 = array();
        $data_1['status'] = 1 ;
        DB::table('tbl_shipping_address')->where('id', $address_id)->update($data_1);
        
    }
    
    public function emplterms(){
        return view('mobile.employeeterms');
    }
   public function autocompeletd(Request $request){
       
       $search = $request->search_keyword;
          return DB::table('tbl_product')
            ->where('product_name', 'like', '%'.$search.'%')
            ->where('status', 1)
            ->limit(10)->pluck('product_name'); ;
            // return response()->json($data);
   }



}
