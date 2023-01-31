<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;
use Image;
use DB;
use Session;
use Str;
use Input;
use Hash;
use Mail;
use Cookie;
use \Swift_Mailer;
use \Swift_SmtpTransport as SmtpTransport;


class marketingTeamController extends Controller
{
    
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate           = date('Y-m-d');
        $this->logged_id        = Session::get('admin_id');
        $this->current_time     = date('H:i:s');
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
        $countryCode = $geo_object->countryCode;
        $county_info = DB::table('tbl_countries')->where('countryCode', $countryCode)->first() ;
        //  $county_info = DB::table('tbl_countries')->first() ;
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

     public function margetinglogin(){
        if($this->agent->isDesktop()){
        return view('marketing.login');
    }else{
    return Redirect::to('m/employee/login') ;
       }
     }

     public function marketingregister(){
        if($this->agent->isDesktop()){
        return view('marketing.registration');
    }else{
    return Redirect::to('m/employee/register') ;
       }

     }
     public function save(Request $request){
         //Validate requests
        $request->validate([
            'name'=>'required',
            'mobile'=>'required|min:11|numeric|regex:/(01)[0-9]/|unique:marketings',
            'email'=>'required|email|unique:marketings',
            'father_name'=>'required',
            'mather_name'=>'required',
            'dob'=>'required',
            'gender'=>'required',
            'password'=>'required|confirmed|min:5|max:12',
            'photo' => 'mimes:jpeg,png,jpg,gif,svg'
            
        ]);


         $name    = $request->name;
         $email    = $request->email;
         $password = $request->password;
     

        $data              = array();
        $data['name'] = $request->name;
        $data['username'] = $request->username;
        $data['mobile'] = $request->mobile;
        $data['email'] = $request->email; 
        $data['father_name'] = $request->father_name;
        $data['mather_name'] = $request->mather_name;
        $data['city'] = $request->city;
        $data['thana'] = $request->thana;
        $data['dob'] = $request->dob;
        $data['gender'] = $request->gender;  
        $data['address'] = $request->address;
        $data['edu_qulification'] = $request->edu_qulification;
        $data['work_experience'] = $request->work_experience;
        $data['work_area'] = $request->work_area;
        $data['password'] = Hash::make($password);
        $data['profile_verify_status'] = 1;
        $data['verify_status'] = 0;
        $data['created_at'] =$this->rcdate;
        $data['token']       = Str::random(32);
        $data['status'] = 0;
        
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(450,450)->save(base_path('public/images/marketing/') . $new_image_name);
            $data['photo']  = $new_image_name;
        }
        
        
        $query = DB::table('marketings')->insert($data);

        $email_code = encrypt($email);

        $site_url = 'https://availtrade.com/everify/'.$email_code ;
        $to_name = $name;
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


        if($query){
            return back()->with('success','Check Your Email Verifiy Link Sent');
         }else{
             return back()->with('fail','Something went wrong, try again later');
         }



     }

     public function verify($email){
        $email                  = decrypt($email);
        $data                   = array();
        $data['verify_status']  = 1;
        $data['status'] = 1;
        $query = DB::table('marketings')->where('email', $email)->update($data);
        if($this->agent->isDesktop()){
        return Redirect::to('/employee/login')->with('success','Verifiy Employee Email has ben successfuly');
    }else{
        return Redirect::to('m/employee/login')->with('success','Verifiy Employee Email has ben successfuly');
    }
    }
    
     public function check(Request $request){
        //Validate requests
        $request->validate([
             'email'=>'required|email',
             'password'=>'required|min:5|max:12'
        ]);

         
        $userInfo = DB::table('marketings')->where('email','=', $request->email)->first();

        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }else{
            if ($userInfo->verify_status == 1) {
            //check password
            if(Hash::check($request->password, $userInfo->password)){
                
                $request->session()->put('LoggedUser', $userInfo->id);
                $request->session()->put('LoggedInfo', $userInfo->username);
                return redirect('/marketing/dasboard');
           

            }else{
                return back()->with('fail','Incorrect password');
            }
             }else{
                return back()->with('fail','Verify Your Email First And Try Again');
             }
     
     }
    
}


      public function logout(){
         if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            session()->pull('LoggedInfo');
            if($this->agent->isDesktop()){
            return redirect('/employee/login');
        }else{
            return redirect('m/employee/login');
        }
        }
      }

    public function ForgetPassword() {
        if($this->agent->isDesktop()){
        return view('marketing.forget-password.email');
    }else{
        return redirect('m/employee/forget-password');
    }
    }
     public function ForgetPasswordStore(Request $request) {
         
         
        $request->validate([
            'email' => 'required|email|exists:marketings',
        ]);
        
        $email = $request->email;
        $query = DB::table('marketings')->where('email',$email)->first();
        $count = DB::table('marketings')
        ->where('email', $email)
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
        $to_name    = $query->name;
        $to_email   = $email;
        
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
        
        $token = Str::random(64);
        

         DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token
        ]);
        
        Mail::send('marketing.forget-password.provide', ['token' => $token], function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Verifycation Mail');
            $message->from('registration@availtrade.com',"avialtradebd");
        });
        
        return back()->with('message', 'We have emailed your password reset link!');
    }

    public function ResetPassword($token) {
        if($this->agent->isDesktop()){
        return view('marketing.forget-password.forget-password-link', ['token' => $token]);
    }else{
        // return redirect()->route('ResetPasswordGet');
        return view('marketing.forget-password.mforget-password', ['token' => $token]);
    }
    }
    public function ResetPasswordStore(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:marketings',
            'password' => 'required|string|min:5|confirmed',
            'password_confirmation' => 'required'
        ]);

        $update = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();

        if(!$update){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = DB::table('marketings')->where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        // Delete password_resets record
        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/employee/login')->with('message', 'Your password has been successfully changed!');
    }

/*Employee Dashboard Funcionality*/

    public function marketing(){
    $data = DB::table('marketings')->where('id','=', session('LoggedUser'))->first();
      return view('marketing.dashboard', compact('data'));

     }

    public function setting(){
    $info = DB::table('marketings')->where('id','=', session('LoggedUser'))->first();
     return view('marketing.settingEmployee',compact('info'));
    }

     public function marketingUpdate(Request $request){

        $image      =$request->file('photo');
        $name= $request->name ;
        $username  = $request->username ;

        $data = array() ;
        if($image){
            $image_name        = Str::random(10).time();
            $ext               = strtolower($image->getClientOriginalExtension());
            $image_full_name   = $image_name.'.'.$ext;
            $upload_path       = "public/images/marketing/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $image->move($upload_path,$image_full_name);
            $data['photo']     = $image_full_name;
        }

        $data['name'] = $name ;
        $data['username']  = $username ;

        $query = DB::table('marketings')->where('id', session('LoggedUser'))->update($data) ;

        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }
    public function marketingUpdateInfo(Request $request){
        
        $dob= $request->dob;
        $city  = $request->city ;
        $thana  = $request->thana ;
        $mobile= $request->mobile;
        $father_name  = $request->father_name ;
        $mather_name  = $request->mather_name ;
        $address= $request->address;
        $edu_qulification  = $request->edu_qulification ;
        $work_area  = $request->work_area ;

        $data = array() ;
        $data['dob'] = $dob ;
        $data['city']  = $city ;
        $data['thana'] = $thana ;
        $data['mobile']  = $mobile ;
        $data['father_name'] = $father_name ;
        $data['mather_name']  = $mather_name ;
        $data['address'] = $address ;
        $data['edu_qulification']  = $edu_qulification ;
        $data['work_area']  = $work_area ;

        $query = DB::table('marketings')->where('id', session('LoggedUser'))->update($data) ;

        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }
    public function changeEmpoylee(Request $request)
    {

        $user = DB::table('marketings')->where('id','=', session('LoggedUser'))->first();
       $old_password       = $request->old_password ;
        $password           = $request->password ;
        $confrim_password   = $request->confrim_password ;

        if(Hash::check($request->old_password, $user->password)){
            $data = array() ;
        $data['password'] =Hash::make($password);
        DB::table('marketings')->where('id', session('LoggedUser'))->update($data) ;

        echo "success" ;
        exit() ;
        }else{
           echo "password_not_match" ;
            exit() ; 
        }

    }
    //Mobile version
    public function loginmarketing(){
        return view('marketing.mlogin');
    }
    public function registermarketing(){
        return view('marketing.mregistration');
    }
    public function mForgetPassword(){
       return view('marketing.forget-password.memail');
    }
    public function mResetPassword($token){
        return view('marketing.forget-password.mforget-password', ['token' => $token]);
    }
     // Supplier Regitration
     public function supplierRegistration(){
        return view('marketing.supplierRegitration');
    }
    
     public function registrationStore(Request $request){
         
           //Validate requests
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'user_type'=>'required',
            'country'=>'required',
            'mobile'=>'required|min:11|numeric|regex:/(01)[0-9]/|unique:express',
            'email'=>'required|email|unique:express',
            'password'=>'required|min:8|max:12'
        ]);
        
         $user = DB::table('marketings')->where('id','=', session('LoggedUser'))->first();
         $reqq = $user->id;

        $type		        = $request->user_type;
        $country	        = $request->country;
        $first_name         = $request->first_name;
        $last_name          = $request->last_name;
        $email 		        = $request->email;
        $mobile 	        = $request->mobile;
        $password 	        = $request->password;
        $repassword         = $request->repassword;
        $newsletter_status  = $request->newsletter;
        $store_name         = $request->store_name;

        if ($store_name != "") {
            $explode = explode(" ",$store_name);
            $final_store_name = implode("-",$explode);
        }else{
            $final_store_name = "";
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

        $count = DB::table('express')->where('storeName', $store_name)->where('type', 2)->count() ;
        if ($count > 0) {
            echo "duplicate_storename";
            exit() ;
        }

        $salt       = 'a123A321';
        $passwordss = sha1($password.$salt);

        $data = array();
        $data['type'] 		        = $type;
        $data['country']  	        = $country;
        $data['first_name']         = $first_name;
        $data['last_name']          = $last_name;
        $data['email']              = $email;
        $data['storeName']  	    = $final_store_name;
        $data['mobile']  	        = $mobile;
        $data['password']           = $passwordss;
        $data['created_at']         = $this->rcdate;
        $data['status']             = 0;
        $data['profile_verify_status'] = 1;
        $data['token'] 		        = Str::random(32);
        $data['marketing_id']           = $reqq;
        
        
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

    if ($query) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
      exit() ;
    }

    }
    
    public function getSupplierStroe(){
         $result = DB::table('express')->where('marketing_id', session('LoggedUser'))->get() ;
    return view('marketing.getAllSupplier')->with('result' ,$result) ;
    }
    
     public function viewSupplier(Request $request){
          $id =  $request->id;
         $value = DB::table('express')->where('marketing_id', session('LoggedUser'))->where('id', $id)->first() ;
         $product = DB::table('tbl_product')->where('supplier_id', $value->id)->count();
         
         
        return view('marketing.viewSuppliert')->with('value' ,$value)->with('product' ,$product);
    }
    public function terms(){
    return view('marketing.terms') ;
    }
    
     public function sellerlogin(){
         return view('seller.login');
    //     if($this->agent->isDesktop()){
    //     return view('marketing.login');
    // }else{
    // return Redirect::to('m/employee/login') ;
    //   }
     }
     
      public function sellercheck(Request $request){
        //Validate requests
        $request->validate([
             'email'=>'required|email',
             'password'=>'required|min:5|max:12'
        ]);

         
        $userInfo = DB::table('seller')->where('email','=', $request->email)->first();

        if(!$userInfo){
            return back()->with('fail','We do not recognize your email address');
        }else{
            if ($userInfo->verify_status == 1) {
            //check password
            if(Hash::check($request->password, $userInfo->password)){
                
                $request->session()->put('LoggedUser', $userInfo->id);
                $request->session()->put('LoggedInfo', $userInfo->name);
                return redirect('/seller/dasboard');
           

            }else{
                return back()->with('fail','Incorrect password');
            }
             }else{
                return back()->with('fail','Verify Your Email First And Try Again');
             }
     
     }
    
}


      public function sellerlogout(){
         if(session()->has('LoggedUser')){
            session()->pull('LoggedUser');
            session()->pull('LoggedInfo');
            return redirect('/seller/login');
        }
       
      }

     public function selregister(){
    //     if($this->agent->isDesktop()){
    //     return view('marketing.registration');
    // }else{
    // return Redirect::to('m/employee/register') ;
    //   }
     return view('seller.resigration');
     }
     public function sellersave(Request $request){
        //Validate requests
        $request->validate([
            'name'=>'required',
            'mobile'=>'required|min:11|numeric|regex:/(01)[0-9]/|unique:seller',
            'email'=>'required|email|unique:seller',
            'password'=>'required|confirmed|min:5|max:12'
            
        ]);
        
        

         $name    = $request->name;
         $email    = $request->email;
         $password = $request->password;
     

        $data              = array();
        $data['name'] = $request->name;
        $data['mobile'] = $request->mobile;
        $data['email'] = $request->email;
        $data['shop_name'] = $request->shop_name; 
        $data['dob'] = $request->dob;
        $data['gender'] = $request->gender;  
        $data['address'] = $request->address;
        $data['password'] = Hash::make($password);
        $data['verify_status'] = 0;
        $data['create_at'] =$this->rcdate;
        $data['token']       = Str::random(32);
        $data['status'] = 0;
        
        // if ($request->hasFile('photo')) {
        //     $image = $request->file('photo');
        //     $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
        //     Image::make($image)->resize(450,450)->save(base_path('public/images/marketing/') . $new_image_name);
        //     $data['photo']  = $new_image_name;
        // }
        
        
        $query = DB::table('seller')->insert($data);

        $email_code = encrypt($email);

        $site_url = 'https://availtrade.com/sverify/'.$email_code ;
        $to_name = $name;
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


        if($query){
            return back()->with('success','Check Your Email Verifiy Link Sent');
         }else{
             return back()->with('fail','Something went wrong, try again later');
         }



     }

     public function sverify($email){
        $email                  = decrypt($email);
        $data                   = array();
        $data['verify_status']  = 1;
        $data['status'] = 1;
        $query = DB::table('seller')->where('email', $email)->update($data);
        return Redirect::to('/seller/login')->with('success','Verifiy Employee Email has ben successfuly');
    //     if($this->agent->isDesktop()){
    //     return Redirect::to('/employee/login')->with('success','Verifiy Employee Email has ben successfuly');
    // }else{
    //     return Redirect::to('m/employee/login')->with('success','Verifiy Employee Email has ben successfuly');
    // }
    }
    
    public function sellerDashboard(){
    // $data = DB::table('seller')->where('id','=', session('LoggedUser'))->first();
    
      echo "Hi";
    //   return view('seller.dashboard');

     }
    


} 