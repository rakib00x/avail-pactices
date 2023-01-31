<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Cache;
use DB;
use Cookie;
use Session;
use Str;
use Input;
use Hash;
use Mail;
use \Swift_Mailer;
use \Swift_SmtpTransport as SmtpTransport;
use Brian2694\Toastr\Facades\Toastr;


class frontEndController extends Controller {

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
        $ip     = $explode[0];
        $url    = "https://api.ipgeolocation.io/ipgeo?apiKey=c5cbdca84f864713abb3eac51dbf6135&ip=".$ip;
        
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);
            
        $json_object    = json_encode($resp);
        $decode         = json_decode($json_object);
        $geo_object     = json_decode($decode);
        

        $county_info = DB::table('tbl_countries')->where('stuas', 1)->first();
        $countryCode = $county_info->countryCode;
        

        $getCount    = DB::table('tbl_currency_status')->where('code', $county_info->countryCode)->count();
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

    public function requestedCurrency(Request $request)
    {
        $currency_id = $request->currency_id;
        Session::put('requestedCurrency',$currency_id);
    }

    public function index($store = null)
    {
        
        $result_siam = DB::table('tbl_product')->get() ;
        foreach($result_siam as $siamvalue){
            $check_count = DB::table('tbl_product_price')->where('product_id', $siamvalue->id)->count() ;
            if($check_count == 0){
                $data = array() ;
                $data['status'] = 2;
                
                DB::table('tbl_product')->where('id', $siamvalue->id)->update($data) ;
            }
        }
        

        $agent          = new Agent;
        $desktopResult  = $agent->isDesktop();
        
        if ($desktopResult) {
            
            
        if(Session::get('availtrades') == 1){
            
        }else{
            //start of auto currency change
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
                
            $explode    = explode(",",$clientIP);
            $ip         = $explode[0];
            $url        = "https://api.ipgeolocation.io/ipgeo?apiKey=c5cbdca84f864713abb3eac51dbf6135&ip=".$ip;
            
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $resp = curl_exec($curl);
            curl_close($curl);
                
            $json_object = json_encode($resp);
            $decode     = json_decode($json_object);
            $geo_object = json_decode($decode);
            // $countryCode = $geo_object->country_code2;
            
            $county_info = DB::table('tbl_countries')->where('stuas', 1)->first();
            
            
            $country        = $county_info->countryCode ;
            $count = DB::table('tbl_currency_status')->where('code',$country)->count();
           
            if($count !=0){
               $query = DB::table('tbl_currency_status')->where('code',$country)->first();
               $currency_id    = $query->id;
            }else{
                $currency_id    = 1;
            }
           
            $agent = new Agent ;
    
            if($currency_id != ""){
                Session::put('requestedCurrency', null);
                Session::put('requestedCurrency',$currency_id);
            }
    
            if($country != "")
            {
                Session::put('countrycode', null);
                Session::put('countrycode', $country);
            }
            //end of auto currency change
        }
            

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
            ->orderBy('id', 'desc')
            ->get();

            $home_category_product = DB::table('tbl_home_category')
                ->join('tbl_primarycategory', 'tbl_home_category.category_id', '=', 'tbl_primarycategory.id')
                ->select('tbl_home_category.*', 'tbl_primarycategory.catgeory_slug')
                ->where('tbl_home_category.status', 1)
                ->orderBy('tbl_home_category.home_descending', 'asc')
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
            

            return view('frontEnd.index')
            ->with('slider',$slider)
            ->with('primarycategory',$primarycategory)
            ->with('home_category_product',$home_category_product)
            ->with('first_category_icon',$first_category_icon)
            ->with('second_category_icon',$second_category_icon)
            ->with('top_category_value',$top_category_value)
            ->with('secondary_category_value',$secondary_category_value)
            ->with('feature_product',$feature_product)
            ->with('requestedCurrency', Session::get('currency_id'));
        }else{
            $mobile_home_url = env("APP_URL")."m";
            return Redirect::to($mobile_home_url);
        }



    }

    public function supplierHome($store)
    {
        $store_name = $store;
            
        $store_query = DB::table('express')->where('storeName',$store_name)->first();
        
        $supplier_id = $store_query->id;
        $category_slider = DB::table('tbl_category_slider')->where('status',1)->get();
        
        return view('frontEnd.store.index')->with('category_slider', $category_slider)->with('store_name',$store_name)->with('supplier_id',$supplier_id);

    }

    public function passwordChange(){
        $social = DB::table('tbl_social_media')->first();
        return view('emails.passwordChange')->with('social',$social);
    }

    public function passChange(Request $request){
        $email = $request->user_email;
        $curr_password = $request->curr_password;
        $new_password  = $request->new_password;

        if($curr_password == $new_password){
            $data           = array();
            $data['password'] = bcrypt($new_password);
            $query = DB::table('express')->where('email', $email)->update($data);
            echo 'The password changed';
            return Redirect::to('/login');
        }else{
            echo "wrong password";
        }
    }

    public function passwordChangeEmail(Request $request){

        $old_password = bcrypt($request->old_password);
        $curr_password = $request->curr_password;
        $new_password  = $request->new_password;

        $count = DB::table('express')
        ->where('password', $old_password)
        ->where('id', Session::get('supplier_id'))
        ->count();
        if($count == 0){
            Session::put('failed','Sorry !!  Email does not match');
            return Redirect::to('passwordChange');
        }

        if($curr_password == $new_password){
            $data           = array();
            $data['password'] = bcrypt($new_password);
            $query = DB::table('express')->where('id', Session::get('supplier_id'))->update($data);
            echo 'The password changed';
            return Redirect::to('/supplierDashboard');
        }else{
            echo "wrong password";
            return Redirect::to('/login');
        }
    }

    public function registration(){

        if($this->agent->isDesktop()){
            $social = DB::table('tbl_social_media')->first();
            $result = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get() ;
            return view('frontEnd.registration')->with('social',$social)->with('result', $result);
        }else{
            return Redirect::to('m/register');
        }
        
    }
    public function suplierreg(){
        if($this->agent->isDesktop()){
            $social = DB::table('tbl_social_media')->first();
            $result = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get() ;
            return view('frontEnd.subregistration')->with('social',$social)->with('result', $result);
        }else{
            return Redirect::to('m/register');
        }
        
    }
    
    public function termsAndCondition()
    {
        $result = DB::table('tbl_terms')->where('id', 1)->first() ;
        return view('frontEnd.terms-and-condition',compact('result'));
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
        // $newsletter_status  = trim($request->newsletter);
        $store_name         = trim($request->store_name);
        $marketing_id        = trim($request->marketing_id);
        

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

        
        // $count = DB::table('express')->where('storeName', $store_name)->where('type', 2)->count() ;
        // if ($count > 0) {
        //     echo "duplicate_storename";
        //     exit() ;
        // }

        $salt       = 'a123A321';
        $passwordss = sha1($password.$salt);

        if($type == 2){
            $seller_type = 1; 
        }else{
            $seller_type = 0;
        }

        $data = array();
        $data['type'] 		        = $type;
        $data['seller_type'] 		= $seller_type;
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
        $data['marketing_id'] 		= $marketing_id;
        
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

    public function product(Request $request, $slug){
        $slug=$request->slug;
        $social = DB::table('tbl_social_media')->first();
        $ptitle  = DB::table('tbl_product')->where('slug',$slug)->get();
        $product  = DB::table('tbl_product')
            ->where('slug',$slug)
            ->first();
  
        if($product){
            $supplier_info = DB::table('express')->where('id', $product->supplier_id)->first();

            $feature_product  = DB::table('tbl_product')->inRandomOrder()->take(18)->get();
            $agent = new Agent;
            $desktopResult= $agent->isDesktop();
            if ($desktopResult) {

                return view('frontEnd.productView')
                ->with('social',$social)
                ->with('ptitle',$ptitle)
                ->with('feature_product',$feature_product)
                ->with('supplier_info',$supplier_info)
                ->with('product',$product);
            }else{
                $mobile_home_url = env("APP_URL").'m/product/'.$slug;
                return Redirect::to($mobile_home_url);
            }
        }else{
            return view('errors.product_404') ;
        }
        
    }

    public function allCategory(){
        
        $ads                = DB::table('tbl_category_ads')->where('status',1)->get();
        $social             = DB::table('tbl_social_media')->first();
        $primarycategory1   = DB::table('tbl_primarycategory')->where('supplier_id',0)->get();
        $primarycategory    = DB::table('tbl_primarycategory')->where('supplier_id',0)->get();
        $secondaryCategory  = DB::table('tbl_secondarycategory')->where('supplier_id',0)->get();
        $tartiarycategory   = DB::table('tbl_tartiarycategory')->where('supplier_id',0)->get();
        
        if($this->agent->isDesktop){
            $mobile_home_url =  env("APP_URL")."all-categories";
            return Redirect::to($mobile_home_url);
        }else{
            return view('frontEnd.allCategory')
            ->with('social',$social)
            ->with('primarycategory',$primarycategory)
            ->with('primarycategory1',$primarycategory1)
            ->with('secondaryCategory',$secondaryCategory)
            ->with('ads',$ads)
            ->with('tartiarycategory',$tartiarycategory);
        }

        
    }
    public function categoryProduct(){
        $slider = DB::table('tbl_category_slider')->where('type',1)->where('status',1)->get();
        $social = DB::table('tbl_social_media')->first();

        $feature_product  = DB::table('tbl_product')
        ->inRandomOrder()
        ->where('status', 1)
        ->orderBy('id','desc')
        ->get();

        return view ('frontEnd.categoryProduct')->with('social',$social)->with('slider',$slider)
        ->with('feature_product',$feature_product);;
    }

    public function supplierWeb($storeName){
        $storeName_info = explode("-", $storeName);
        $storeNames     = implode(" ", $storeName_info) ;

        $store_info     = DB::table('express')->where('storeName', $storeNames)->first() ;
        $social         = DB::table('tbl_social_media')->first();
        $slider         = DB::table('tbl_slider')->where('supplier_id', $store_info->id)->where('type',2)->get();
        $menu           = DB::table('tbl_menu')->where('supplier_id', $store_info->id)->get() ;
        $sub_menu       = DB::table('tbl_sub_menu')->where('supplier_id', $store_info->id)->get();

        $category       = DB::table('tbl_supplier_primary_category')->where('supplier_id', $store_info->id)->where('status',1)->get();
        $subcategory    = DB::table('tbl_supplier_secondary_category')->where('supplier_id', $store_info->id)->where('status',1)->get();

        $sub_sub_menu   = DB::table('tbl_sub_sub_menu')->where('supplier_id', $store_info->id)->get();
        $header_colors  = DB::table('tbl_supplier_header_settings')->where('supplier_id', $store_info->id)->first() ;

        return view ('frontEnd.supplierweb')->with('social',$social)->with('slider',$slider)
        ->with('menu',$menu)
        ->with('sub_sub_menu',$sub_sub_menu)
        ->with('category',$category)
        ->with('subcategory',$subcategory)
        ->with('header_colors',$header_colors)
        ->with('store_info',$store_info)
        ->with('sub_menu',$sub_menu);
    }

    public function secondaryCategoryindex(Request $request, $secondary_category_slug){

        $slug    = $request->secondary_category_slug;
        $result  = DB::table('tbl_secondarycategory')
            ->join('tbl_primarycategory', 'tbl_secondarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_secondarycategory.*', 'tbl_primarycategory.category_name', 'tbl_primarycategory.catgeory_slug')
            ->where('tbl_primarycategory.catgeory_slug',$slug)
            ->where('tbl_secondarycategory.status', 1)
            ->get();

        $social = DB::table('tbl_social_media')->first();
        $slider = DB::table('tbl_secondcategory_slider')->where('categorytype',1)->where('status',1)->get();
        $primarycategory   = DB::table('tbl_primarycategory')->where('supplier_id',0)->where('status', 1)->get();

        $secondaryCategory  = DB::table('tbl_secondarycategory')->where('supplier_id',0)->where('status', 1)->get();

        $feature_product  = DB::table('tbl_product')
            ->inRandomOrder()
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->limit(20)
            ->get();

        $product_result = DB::table('tbl_product')
            ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_product.*', 'tbl_primarycategory.catgeory_slug')
            ->where('tbl_primarycategory.catgeory_slug', $secondary_category_slug)
            ->orderBy('tbl_product.id', 'desc')
            ->get();

        $icon_result  = DB::table('tbl_secondarycategory')
            ->join('tbl_primarycategory', 'tbl_secondarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_secondarycategory.*', 'tbl_primarycategory.category_name', 'tbl_primarycategory.catgeory_slug')
            ->where('tbl_primarycategory.catgeory_slug',$slug)
            ->where('tbl_secondarycategory.status', 1)
            ->inRandomOrder()
            ->limit(12)
            ->get();
            

        return view('frontEnd.secondCategory')
        ->with('social',$social)
        ->with('result',$result)
        ->with('icon_result',$icon_result)
        ->with('slider',$slider)
        ->with('primarycategory',$primarycategory)
        ->with('secondaryCategory',$secondaryCategory)
        ->with('product_result',$product_result)
        ->with('feature_product',$feature_product);
    
        
    }

    public function getMoreProduct(Request $request)
    {
        $product_result = DB::table('tbl_product')
            ->join('tbl_primarycategory', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_product.*', 'tbl_primarycategory.catgeory_slug')
            ->where('tbl_primarycategory.catgeory_slug', $request->category_slug)
            ->limit($request['limit'])
            ->offset($request['start'])
            ->where('tbl_product.status', 1)
            ->get();


        return view('frontEnd.product_data')->with('product_result' ,$product_result) ;
    }

    public function getTartirayMoreProduct(Request $request)
    {

        $product_result = DB::table('tbl_product')
            ->join('tbl_secondarycategory', 'tbl_product.w_category_id', '=', 'tbl_secondarycategory.id')
            ->select('tbl_product.*', 'tbl_secondarycategory.secondary_category_slug')
            ->where('tbl_secondarycategory.secondary_category_slug', $request->category_slug)
            ->limit($request['limit'])
            ->offset($request['start'])
            ->where('tbl_product.status', 1)
            ->get();

        return view('frontEnd.product_data')->with('product_result' ,$product_result) ;
    }

    // public function tertiaryCategoryindex(Request $request, $tartiary_category_slug){

    //     $slug = $request->tartiary_category_slug;
    //     $result  = DB::table('tbl_tartiarycategory')
    //         ->join('tbl_secondarycategory', 'tbl_tartiarycategory.secondary_category_id', '=', 'tbl_secondarycategory.id')
    //         ->select('tbl_tartiarycategory.*', 'tbl_secondarycategory.*')
    //         ->where('tbl_secondarycategory.secondary_category_slug',$slug)
    //         ->where('tbl_tartiarycategory.status', 1)
    //         ->get();

    //     $social = DB::table('tbl_social_media')->first();
    //     $slider = DB::table('tbl_secondcategory_slider')->where('categorytype',2)->where('status',1)->get();
    //     $primarycategory   = DB::table('tbl_primarycategory')->where('supplier_id',0)->where('status', 1)->get();

    //     $secondaryCategory  = DB::table('tbl_secondarycategory')->where('supplier_id',0)->where('status', 1)->get();

    //     $tartiarycategory   = DB::table('tbl_tartiarycategory')->where('supplier_id',0)->where('status', 1)->get();

    //     $feature_product  = DB::table('tbl_product')
    //         ->inRandomOrder()
    //         ->where('status', 1)
    //         ->orderBy('id', 'desc')
    //         ->limit(20)
    //         ->get();

    //     return view('frontEnd.tertiaryCategory')
    //     ->with('social',$social)
    //     ->with('result',$result)
    //     ->with('slider',$slider)
    //     ->with('primarycategory',$primarycategory)
    //     ->with('secondaryCategory',$secondaryCategory)
    //     ->with('tartiarycategory',$tartiarycategory)
    //     ->with('feature_product',$feature_product);
    // }


    public function getSupplierProduct(Request $request)
    {
        $supplier_id = $request->supplier_id ;

        $category_product = DB::table('tbl_product')
            ->where('supplier_id', $supplier_id)
            ->where('status', 1)
            ->paginate(12) ;
        return view('frontEnd.getSupplierProduct')->with('category_product', $category_product) ;
    }

    public function supplierProductPagination(Request $request)
    {
        if($request->ajax())
        {
            $supplier_id        = $request->supplier_id ;
            $category_product   = DB::table('tbl_product')
                ->where('supplier_id', $supplier_id)
                ->where('status', 1)
                ->paginate(12) ;

            return view('frontEnd.supplierProductPagination')->with('category_product', $category_product) ;
        }
    }

    public function getSupplierCategroyProduct(Request $request)
    {
        $supplier_id = $request->supplier_id ;
        $category_id = $request->category_id ;
        $category_product = DB::table('tbl_product')
            ->inRandomOrder()
            ->where('supplier_id', $supplier_id)
            ->where('main_category_id', $category_id)
            ->where('status', 1)
            ->paginate(12) ;
        return view('frontEnd.getSupplierProduct')->with('category_product', $category_product) ;
        
    }

    public function getSupplierSecondaryCategroyProduct(Request $request)
    {
        $supplier_id            = $request->supplier_id ;
        $category_id            = $request->category_id ;
        $secondary_category_id  = $request->secondary_category_id ;

        $category_product = DB::table('tbl_product')
            ->inRandomOrder()
            ->where('supplier_id', $supplier_id)
            ->where('main_category_id', $category_id)
            ->where('secondary_category_id', $secondary_category_id)
            ->where('status', 1)
            ->get() ;
        return view('frontEnd.getSupplierProduct')->with('category_product', $category_product) ;
    }

    public function supplierContact(Request $request)
    {
        $social         = DB::table('tbl_social_media')->where('supplier_id', $request->supplier_id)->first();
        $supplier_info  = DB::table('express')
            ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
            ->select('express.*', 'tbl_countries.countryName')
            ->where('express.id', $request->supplier_id)
            ->first() ;

        return view('frontEnd.supplierContact')->with('social',$social)->with('supplier_info' ,$supplier_info);
    }

    public function getSupplirSerachResult(Request $request)
    {
        $supplier_id            = $request->supplier_id ;
        $search_keyword         = $request->search_keyword ;

        $result = DB::table('tbl_product')
            ->inRandomOrder()
            ->where('supplier_id', $supplier_id)
            ->where('product_name', 'like', '%'.$search_keyword.'%')
            ->where('status', 1)
            ->get() ;

        if (count($result) == 0) {
            echo '<p class="text-danger text-center" style="height:100px;margin-top:50px;">Sorry No Product Found.</p>';
            exit() ;
        }

        return view('frontEnd.getSupplirSerachResult')->with('result', $result)->with('search_keyword', $search_keyword) ;
    }
    public function autocomplete(Request $request)
    {
        $search = $request->search_keyword;
      return DB::table('tbl_product')
            ->where('product_name', 'like', '%'.$search.'%')
            ->where('status', 1)
            ->limit(10)->pluck('product_name');
            
            // dd($name);
            // exit();
            
           //return substr($name->product_name, 0, 10);
            
    //   $search = $request->keywords;
        // $name= DB::table('tbl_product')
        //     ->where('product_name', 'like', '%'.$search.'%')
        //     ->where('status', 1)
        //     ->limit(10)->get(); 
            
        //     foreach($name as $product){
        //         $pro= substr($product->product_name, 0, 10);
                
        //     }
        //     return response()->json($pro);
    }
    

    # ABOUT US PAGE
    public function aboutUs()
    {
        $about_section = DB::table('tbl_about_us')->get() ;
        return view('frontEnd.aboutUs')->with('about_section', $about_section) ;
    }

    # CONTACT US
    public function contactUs()
    {

        return view('frontEnd.contactUs') ;
    }

    public function contact(Request $request)
     {
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
            'message'    => 'Contact Sent Successfully', 
            'alert-type' => 'info',
        );
        
        return back()->with($notification);
        }else{
            Session::put('failed', 'Your Message not send');
            echo "failed";
           return back()->with($notification);
            
        }
        
       
    
    }
    #Reportating Page
    public function reportsUs()
    {

        return view('frontEnd.reportUs') ;
    }
    # ABOUT PAGE SECTION
    public function aboutpage()
    {
        return view('admin.aboutus.aboutpage');
    }

    # ABOUT PAGE DATA
    public function getAboutPageList()
    {
        $result = DB::table('tbl_about_us')
            ->orderBy('id', 'desc')
            ->get() ;

        return view('admin.aboutus.getAboutPageList')->with('result', $result) ;
    }

    public function insertAboutInfo(Request $request)
    {
        $about_title        = $request->about_title;
        $about_details      = $request->about_details;
        $image_position     = $request->image_position;
        $image              = $request->image;
        $image_extension    = $request->file('image')->extension();

        # DUPLICATE ABOUT SECTION
        $count = DB::table('tbl_about_us')
            ->where('about_title', $about_title)
            ->count() ;

        if ($count > 0) {
            echo "duplicate_about" ;
            exit() ;
        }

        $valid_extentation = ["jpg", "jpeg", "png", "web"];
        if(in_array($image_extension, $valid_extentation))
        {
            $data                   = array() ;
            $data['about_title']    = $request->about_title;
            $data['about_details']  = $request->about_details;
            $data['image_position'] = $request->image_position;
            
            if ($image) {
                $imageName = 'about-'.Str::random(12).'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $data['image']      = $imageName;
            }
            
            $data['status']         = 0 ;
            $data['image_position'] = $image_position ;
            $data['created_at']     = $this->rcdate ;
            $query                  = DB::table('tbl_about_us')->where('id',1)->update($data);

            echo "success" ;
            exit() ;
            
        }else{
            
            echo "extension_not_exit" ;
            exit();
            
        }
    }

    # DELETE ABOUT PAGE INFO
    public function deleteAboutPageInfo(Request $request)
    {
        DB::Table('tbl_about_us')->where('id', $request->id)->delete() ;
        echo "success" ;
    }



    # MAIN CATEGORY PRODUCT INFO 
    public function maincatgeoryindex($category_slug, $pricefilter)
    {
        $all_catgeory_1 = DB::table('tbl_secondarycategory')
            ->join('tbl_primarycategory', 'tbl_secondarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_secondarycategory.*', 'tbl_primarycategory.catgeory_slug', 'tbl_primarycategory.category_name')
            ->where('tbl_primarycategory.catgeory_slug', $category_slug)
            ->where('tbl_secondarycategory.status', 1)
            ->limit(2)
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
                ->paginate(18) ;

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
                ->paginate(18) ;
                
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
            ->where('tbl_primarycategory.id', $category_info->id)
            ->limit(6)
            ->inRandomOrder()
            ->get() ;

        $category_slider = DB::table('tbl_category_slider')
            ->where('status', 1)
            ->where('primary_category_id', $category_info->id)
            ->get() ;
            

        if($this->agent->isDesktop()){
            return view('frontEnd.maincatgeoryindex')->with('all_catgeory_1', $all_catgeory_1)->with('all_product', $all_product)->with('category_info', $category_info)->with('all_catgeory_2', $all_catgeory_2)->with('category_slider', $category_slider)->with('all_catgeory_3', $all_catgeory_3)->with('category_slug', $category_slug)->with('pricefilter',$pricefilter);
        }else{
            $mobile_home_url = env('APP_URL')."m/category/".$category_slug.'/'.$pricefilter;
            return Redirect::to($mobile_home_url);
        }
        

    }
    
    
    public function getmaincategoryproductforpagination(Request $request)
    {
        $page           = $request->page ;
        $pricefilter    = $request->pricefilter ;
        $category_slug  = $request->category_slug ;

        if($request->ajax())
        {
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
                    ->paginate(18) ;
    
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
                    ->paginate(18) ;
                    
            }
        }  
        
        return view('frontEnd.getmaincategoryproductforpagination')->with('all_product', $all_product);
    }

    # secondary category index 
    public function secondarycatgeoryindex($catgeory_slug, $pricefilter)
    {

        $tertiary_category = DB::table('tbl_tartiarycategory')
            ->join('tbl_secondarycategory', 'tbl_tartiarycategory.secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->select('tbl_tartiarycategory.*', 'tbl_secondarycategory.secondary_category_slug', 'tbl_secondarycategory.secondary_category_name')
            ->where('tbl_secondarycategory.secondary_category_slug', $catgeory_slug)
            ->where('tbl_tartiarycategory.status', 1)
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
                ->where('tbl_secondarycategory.secondary_category_slug', $catgeory_slug)
                ->groupBy('tbl_product_price.product_id')
                    ->orderBy('tbl_product_price.product_price', 'asc')
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
                ->where('tbl_secondarycategory.secondary_category_slug', $catgeory_slug)
                ->groupBy('tbl_product_price.product_id')
                ->orderBy('tbl_product_price.product_price', 'desc')
                ->paginate(16) ;

        }
        
        $secondary_category_info = DB::table('tbl_secondarycategory')
            ->where('secondary_category_slug',$catgeory_slug)
            ->first() ;
            
        if($this->agent->isDesktop()){
            return view('frontEnd.secondarycatgeoryindex')->with('tertiary_category', $tertiary_category)->with('all_product', $all_product)->with('pricefilter', $pricefilter)->with('category_slug', $catgeory_slug)->with('secondary_category_info', $secondary_category_info);
        }else{
            $mobile_home_url =  env('APP_URL')."m/seccategory/".$catgeory_slug."/".$pricefilter;
            return Redirect::to($mobile_home_url);
        }
    
    }


    public function getsecondarycategoryproductforpagination(Request $request)
    {
        $page           = $request->page ;
        $pricefilter    = $request->pricefilter ;
        $category_slug  = $request->category_slug ;

        if($request->ajax())
        {
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
        }  
        
        return view('frontEnd.getsecondarycategoryproductforpagination')->with('all_product', $all_product);
    }

    public function tertiarycatgeoryindex($category_slug, $pricefilter)
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
                ->paginate(18) ;
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
                ->paginate(18) ;
        }
        
        $tertiary_category_info = DB::table('tbl_tartiarycategory')
            ->where('tartiary_category_slug', $category_slug)
            ->first() ;
            
        if($this->agent->isDesktop()){
            return view('frontEnd.tertiarycatgeoryindex')->with('all_product', $all_product)->with('pricefilter', $pricefilter)->with('category_slug', $category_slug)->with('tertiary_category_info', $tertiary_category_info);
        }else{
            $mobile_home_url =  env('APP_URL')."m/tercategory/".$category_slug."/".$pricefilter;
            return Redirect::to($mobile_home_url);
        }

    }
    
    public function gettertiarycategoryproductforpagination(Request $request)
    {
        $page           = $request->page ;
        $pricefilter    = $request->pricefilter ;
        $category_slug  = $request->category_slug ;

        if($request->ajax())
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
                    ->paginate(18) ;
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
                    ->paginate(18) ;
            }
        }  
        
        return view('frontEnd.gettertiarycategoryproductforpagination')->with('all_product', $all_product);
    }

    public function sendSupplierQuotation(Request $request)
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
            return Redirect::to('product/'.$product_slug)->with($notification);
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
        return Redirect::to('product/'.$product_slug)->with($notification);
        
    }
    
    public function insertsuppliercontactmessage(Request $request)
    {
        
        $subject            = $request->subject;
        $message            = $request->message;
        $product_id_slug     = $request->product_id_slug;
        $supplier_id_message        = $request->supplier_id_message;
        
        if($product_id_slug){
            $product_id = $product_id_slug;
        }else{
            $product_id = 0;
        }
        
        
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }
        
        if($customer_id == "" || $customer_id == null){
            echo "login_first";
            exit() ;
        }
        
        $supplier_info = DB::table('express')
            ->where('id', $supplier_id_message)
            ->first() ;
            
        if($supplier_info->id == $customer_id){
            echo "send_failed";
            exit() ;
        }

        $customer_info  = DB::table('express')->where('id', $customer_id)->first();
        $to_name        = $customer_info->first_name." ".$customer_info->last_name;
        $to_email       = $customer_info->email;

        $message_body   = "Message: ".$request->message;


        $data2 = array() ;
        $data2['customer_id']    = $customer_id; 
        $data2['supplier_id']    = $supplier_id_message; 
        $data2['product_id']     = $product_id;
        $data2['quantity']       = 0; 
        $data2['unit_name']      = null; 
        $data2['subject']        = $subject; 
        $data2['message']        = $message_body; 
        $data2['status']         = 0; 
        $data2['created_at']     = date("Y-m-d H:i:s"); 
        $query = DB::table('tbl_supplier_quotation')->insert($data2);
        
        
        // Chatting part
        $chat = array();
        $chat['chatting_id']    = Str::random(32);
        $chat['sender_id']      = $customer_id;
        $chat['receiver_id']    = $supplier_info->id;
        $chat['product_id']     = $product_id;
        $chat['message']        = $message;
        $chat['image']          = null;
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
        

        echo "success";
        
    }

    public function allCategories()
    {
        if($this->agent->isDesktop()){
            return view('frontEnd.all-categories');
        }else{
            $mobile_home_url =  env('APP_URL')."m/all-categories";
            return Redirect::to($mobile_home_url);
        }
        
        
    }
    
    public function countrysupplier($countrycode)
    {
        $country_info = DB::table('tbl_countries')->where('urlCode', $countrycode)->first() ;
        $supplier_search = DB::table('express')
                ->join('tbl_countries', 'express.country', '=', 'tbl_countries.id')
                ->select('express.*', 'tbl_countries.countryName')
                ->where('express.country', $country_info->id)
                ->paginate(12);
        

        $all_catgeorys = DB::table('tbl_primarycategory')
            ->where('status', 1)
            ->get();

        $category_wise_product = DB::table('tbl_product')
            ->where('status', 1)
            ->inRandomOrder()
            ->limit(8)
            ->get() ;


        $serach_banner = DB::table('tbl_banner')
            ->where('status', 1)
            ->inRandomOrder()
            ->first() ;

            return view('frontEnd.countrysupplier')->with('countrycode',$countrycode)->with('supplier_search',$supplier_search)->with('serach_banner',$serach_banner)->with('all_catgeorys', $all_catgeorys)->with('category_wise_product', $category_wise_product);
    }
    
    public function sendsuppliercontactmessage(Request $request)
    {
        $message        = $request->message;
        $supplierid      = $request->supplierid;
        
        
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }
        
        echo Session::get('buyer_id') ;
        exit() ;
        
        if($customer_id == "" || $customer_id == null){
             $notification = array(
                'message'    => 'Please Login First.', 
                'alert-type' => 'failed',
            );
            
            Session::put('failed', 'Please Login First');
            
            echo "failed";
        exit() ;

            return back()->with($notification);
        }

        $supplier_info = DB::table('express')->where('id', $supplierid)->first();
        $customer_info = DB::table('express')->where('id', $customer_id)->first();
        
        $to_name        = $customer_info->first_name." ".$customer_info->last_name;
        $to_email       = $customer_info->email;

        $message_body = $request->message;

        $data2 = array() ;
        $data2['customer_id']    = $customer_id; 
        $data2['supplier_id']    = $request->supplier_id; 
        $data2['product_id']     = 0; 
        $data2['quantity']       = 0; 
        $data2['unit_name']      = ""; 
        $data2['message']        = $message_body; 
        $data2['status']         = 0; 
        $data2['created_at']     = date("Y-m-d H:i:s"); 
        $query = DB::table('tbl_supplier_quotation')->insert($data2) ;
        

        $data['title']           = "Supplier Contact";
        $data['subject']         = "Contact Message";
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
        
        $data3 = array();
        $data3['sender_id'] = $customer_id;
        $data3['receiver_id'] = $supplierid;
        $data3['product_id'] = 0;
        $data3['message'] = $message_body;
        $data3['is_read'] = 0;
        $data3['created_at'] = date("Y-m-d- H:i:s");
        DB::table('tbl_messages')->insert($data3);
        

        $notification = array(
            'message'    => 'Message send successfully', 
            'alert-type' => 'info',
        );
        
        Session::put('success', 'Message send successfully');
        
        echo "success";
        exit() ;
        return back('')->with($notification);
        
    }
    
    public function homefilter($store,$slug, $type)
    {
        $store_name = $store;
        $store_query = DB::table('express')->where('storeName',$store_name)->first();
        $supplier_id = $store_query->id;
        

        if($slug == "heightolow"){
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->orderBy('tbl_product_price.product_price', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->paginate(16) ;
        }else{


            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id')
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->orderBy('tbl_product_price.product_price', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->paginate(16) ;
        }
        
        if($this->agent->isDesktop()){
            if($type == "g"){
                return view('frontEnd.store.homefilterviewgrid')->with('supplier_id',$supplier_id)->with('slug', $slug)->with('store_name', $store_query->storeName)->with('just_for_you', $just_for_you)->with('type', $type);
            }else{
                return view('frontEnd.store.homefilterviewlist')->with('supplier_id',$supplier_id)->with('slug', $slug)->with('storeName', $store_query->storeName)->with('store_name', $store_query->storeName)->with('just_for_you', $just_for_you)->with('type', $type);
            }
        }else{
            $mobile_home_url =  env('APP_URL').'m/'.strtolower($store);
            return Redirect::to($mobile_home_url);
        }

    }
    
    # SUPPLIER CONTACT PAGE 
    public function storeContact($store)
    {
        $store_query = DB::table('express')
        ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
        ->select('express.*', 'tbl_countries.countryName')
        ->where('express.storeName',$store)
        ->first();
        $supplier_id = $store_query->id;
    
        $category_slider = DB::table('tbl_category_slider')->where('status',1)->get();
        if($this->agent->isDesktop()){
            return view('frontEnd.store.contact')->with('category_slider', $category_slider)->with('store_name',$store)->with('supplier_id',$supplier_id)->with('store_query', $store_query);
        }else{
            $mobile_home_url = env('APP_URL').'m/'.strtolower($store);
            return Redirect::to($mobile_home_url);
        }
    }
    
    # SUPPLIER COMPANY OVERVIEW
    public function companyoverview($store)
    {
        $store_query = DB::table('express')->where('storeName',$store)->first();
        $supplier_id = $store_query->id;
    
        $category_slider = DB::table('tbl_category_slider')->where('status',1)->get();
        
        if($this->agent->isDesktop()){
            return view('frontEnd.store.company-overview')->with('category_slider', $category_slider)->with('store_name',$store)->with('supplier_id',$supplier_id)->with('store_query', $store_query);
        }else{
            $mobile_home_url = env('APP_URL').'m/'.strtolower($store);;
            return Redirect::to($mobile_home_url);
        }
    }
    
    # SUPPLIER COMPANY OVERVIEW
    public function productionCapacity($store)
    {
        $store_query = DB::table('express')->where('storeName',$store)->first();
        $supplier_id = $store_query->id;
    
        $category_slider = DB::table('tbl_category_slider')->where('status',1)->get();
        
        if($this->agent->isDesktop()){
            return view('frontEnd.store.production-capacity')->with('category_slider', $category_slider)->with('store_name',$store)->with('supplier_id',$supplier_id);
        }else{
            $mobile_home_url = env('APP_URL').'m/'.strtolower($store);
            return Redirect::to($mobile_home_url);
        }
    }
    
    # SUPPLIER COMPANY OVERVIEW
    public function tradeCapacity($store)
    {
        $store_query = DB::table('express')->where('storeName',$store)->first();
        $supplier_id = $store_query->id;
        $category_slider = DB::table('tbl_category_slider')->where('status',1)->get();
        
        if($this->agent->isDesktop()){
            return view('frontEnd.store.trade-capacity')->with('category_slider', $category_slider)->with('store_name',$store)->with('supplier_id',$supplier_id);
        }else{
            $mobile_home_url = env('APP_URL').'m/'.strtolower($store);
            return Redirect::to($mobile_home_url);
        }
    }
    
    # SUPPLIER COMPANY OVERVIEW
    public function spscategory($store,$slug, $type, $pricefilter)
    {

        if($this->agent->isDesktop()){
            $store_name = $store;
            $store_query = DB::table('express')->where('storeName',$store_name)->first();
            $supplier_id = $store_query->id;
    
            if($pricefilter == "heightolow"){
    
                $just_for_you = DB::table('tbl_product_price')
                    ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                    ->join('tbl_supplier_secondary_category', 'tbl_product.secondary_category_id', '=', 'tbl_supplier_secondary_category.id')
                    ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_secondary_category.secondary_category_slug')
                    ->where('tbl_product.status', 1)
                    ->where('tbl_product.supplier_id', $supplier_id)
                    ->where('tbl_supplier_secondary_category.secondary_category_slug', $slug)
                    ->orderBy('tbl_product_price.product_price', 'DESC')
                    ->where('tbl_product_price.product_price', '>', 0)
                    ->groupBy('tbl_product_price.product_id')
                    ->paginate(16) ;
    
    
    
            }else{
                $just_for_you = DB::table('tbl_product_price')
                    ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                    ->join('tbl_supplier_secondary_category', 'tbl_product.secondary_category_id', '=', 'tbl_supplier_secondary_category.id')
                    ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_secondary_category.secondary_category_slug')
                    ->where('tbl_product.status', 1)
                    ->where('tbl_product.supplier_id', $supplier_id)
                    ->where('tbl_supplier_secondary_category.secondary_category_slug', $slug)
                    ->orderBy('tbl_product_price.product_price', 'ASC')
                    ->where('tbl_product_price.product_price', '>', 0)
                    ->groupBy('tbl_product_price.product_id')
                    ->paginate(16) ;
    
            }
            
    
            if($type == "g"){
                return view('frontEnd.store.secondaryCategoryGridView')->with('supplier_id',$supplier_id)->with('slug', $slug)->with('storeName', $store_query->storeName)->with('store_name', $store_query->storeName)->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('type', $type);
            }else{
                return view('frontEnd.store.secondaryCategoryListView')->with('supplier_id',$supplier_id)->with('slug', $slug)->with('storeName', $store_query->storeName)->with('store_name', $store_query->storeName)->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('type', $type);
            }
        }else{
            $mobile_home_url = env('APP_URL').'m/'.strtolower($store);
            return Redirect::to($mobile_home_url);
        }
    }
    
    # SUPPLIER COMPANY OVERVIEW
    public function stpcategory($store,$slug, $type, $pricefilter)
    {

        if($this->agent->isDesktop()){
            $store_name = $store;
            $store_query = DB::table('express')->where('storeName',$store_name)->first();
            $supplier_id = $store_query->id;
    
            if($pricefilter == "heightolow"){
                $just_for_you = DB::table('tbl_product_price')
                    ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                    ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                    ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug')
                    ->where('tbl_product.status', 1)
                    ->where('tbl_product.supplier_id', $supplier_id)
                    ->where('tbl_supplier_primary_category.catgeory_slug', $slug)
                    ->orderBy('tbl_product_price.product_price', 'desc')
                    ->groupBy('tbl_product_price.product_id')
                    ->paginate(16) ;
            }else{
    
                $just_for_you = DB::table('tbl_product_price')
                    ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                    ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                    ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug')
                    ->where('tbl_product.status', 1)
                    ->where('tbl_product.supplier_id', $supplier_id)
                    ->where('tbl_supplier_primary_category.catgeory_slug', $slug)
                    ->orderBy('tbl_product_price.product_price', 'asc')
                    ->groupBy('tbl_product_price.product_id')
                    ->paginate(16) ;
            }

            if($type == "g"){
                return view('frontEnd.store.categoryGridView')->with('supplier_id',$supplier_id)->with('slug', $slug)->with('storeName', $store_query->storeName)->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('type', $type)->with('store_name', $store_query->storeName);
            }else{
                return view('frontEnd.store.categoryListView')->with('supplier_id',$supplier_id)->with('slug', $slug)->with('storeName', $store_query->storeName)->with('store_name', $store_query->storeName)->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('type', $type);
            }
        }else{
            $mobile_home_url = env('APP_URL').'m/'.strtolower($store);
            return Redirect::to($mobile_home_url);
        }
    }
    
    # SUPPLIER TERMS AND CONDITIONS 
    public function suppliertermsconditions(Request $reques, $store)
    {
        $store_info     = $store_query = DB::table('express')
        ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
        ->select('express.*', 'tbl_countries.countryName')
        ->where('express.storeName',$store)
        ->first();
        $supplier_id = $store_query->id;
        
        
        $result = DB::table('tbl_supplier_terms_conditions')
            ->where('status', 1)
            ->where('supplier_id', $store_info->id)
            ->get() ;

        return view('frontEnd.store.suppliertermsconditions')->with('store_name',$store)->with('supplier_id',$supplier_id)->with('store_query', $store_query)->with('result', $result);
    }
    
    # SUPPLIER PACKAGE 
    public function package()
    {
        $package_category_list  = DB::table('tbl_package_category')->where('status', 1)->get() ;
        
        return view('frontEnd.package.package')->with('package_category_list', $package_category_list);
    }

    public function packagePage()
    {   
        $package_category_list  = DB::table('tbl_package_category')->where('status', 1)->get() ;
        
        if($this->agent->isDesktop()){
            return view('frontEnd.package')->with('package_category_list', $package_category_list);
        }else{
            return Redirect::to('m/package');
        }
        
    }
    
    # set package 
    public function setpackage($id)
    {


        if(Session::get('supplier_id') != null){
            
            $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
            
            if($supplier_info->package_id != 0){
                $notification = array(
                    'message'       => 'Sorry! You have a active package',
                    'alert-type'    => 'failed'
                );
                return Redirect::to('package')->with($notification);
            }
            
            
            $package_info = DB::table('tbl_package')->where('id', $id)->first() ;
            if($package_info->package_price == 0){
                $data = array();
                $data['package_id'] = $id;
                $data['package_status'] = 1;
                $data['updated_at'] = date('Y-m-d');
                DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;
                
                
                
                $pacakge_data                           = array();
                $package_data['supplier_id']            = Session::get('supplier_id');
                $package_data['package_id']             = $id;
                $package_data['package_duration']       = $package_info->package_duration;
                $package_data['currency_id']            = Session::get('requestedCurrency');
                $package_data['package_price']          = $package_info->package_price ;
                $package_data['discount_percentage']    = $package_info->discount_percentage;
                $package_data['status']                 = 1;
                
                DB::table('tbl_supplier_package_history')->insert($package_data);
                
                $notification = array(
                    'message'       => 'Thanks ! Package update Successfully. Please Wait for admin approve',
                    'alert-type'    => 'success'
                );
                return Redirect::to('package')->with($notification);
            }else{
                
                return view('frontEnd.packagepayment')->with('id', $id)->with('package_info', $package_info);
            }
            
        }else{
            return Redirect::to('login');
        }

    }
    
    
    
    public function getallbankforpayment(Request $request)
    {
        $method_type = $request->method_type;
    
        if($method_type == 1){
            $result = DB::table('tbl_bank')->where('status', 1)->get() ;
        }else{
            $result = DB::table('tbl_mobile_bank')->where('status', 1)->get() ;
        }
        
        echo "<option value=''>Select Bank</option>";
        foreach($result as $bank_value){
            echo "<option value='".$bank_value->id."'>".$bank_value->bank_name."</option>";
        }

    }
    
    public function getpaymentbandetails(Request $request)
    {
        $package_id = $request->package_id;
        $bank_id    = $request->bank_id;
        $method_type    = $request->method_type;
        
        $package    = DB::table('tbl_package')->where('id', $package_id)->first() ;
        
        $main_currancy_status   = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $now_product_price_is   = $package->package_price * $main_currancy_status->rate ;
        $discount               = $now_product_price_is * $package->discount_percentage / 100 ;
        
        $final_product_price = $now_product_price_is - $discount;
        
        if($method_type == 1){
            $bank_info = DB::table('tbl_bank')->where('id', $bank_id)->first() ;
            if($bank_info){
                echo "Branch: <strong>".$bank_info->bank_branch_name .'</strong></br> Account Name:  <strong>'.$bank_info->bank_account_name.'</strong></br> Account Number :<strong>'.$bank_info->bank_account_number.'</strong></br> Payment Amount: <strong>'.'<span style="font-family:SolaimanLipi">'.$main_currancy_status->symbol.'</span> '.$final_product_price.'</strong></br>';
            }else{
                echo "<span style='color:red'> Select Bank </span>";
            }
        }else{
            $bank_info = DB::table('tbl_mobile_bank')->where('id', $bank_id)->first() ;
            if($bank_info){
                echo "Account Number: <strong>".$bank_info->payment_number .'</strong></br> Counter Number: <strong>'.$bank_info->counter_number.'</strong></br> Payment Amount: <strong>'.'<span style="font-family:SolaimanLipi">'.$main_currancy_status->symbol.'</span> '.$final_product_price.'</strong></br>';
            }else{
                echo "<span style='color:red'> Select Bank </span>";
            }
        }

    }
    
    public function getsupplierpaymentbandetails(Request $request)
    {
        $package_id = $request->package_id;
        $bank_id    = $request->bank_id;
        $method_type    = $request->method_type;
        
        $package    = DB::table('tbl_package')->where('id', $package_id)->first() ;
        
        $main_currancy_status   = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $now_product_price_is   = $package->package_price * $main_currancy_status->rate ;
        $discount               = $now_product_price_is * $package->discount_percentage / 100 ;
        
        $final_product_price = $now_product_price_is - $discount;
        
        if($method_type == 1){
            $bank_info = DB::table('tbl_bank')->where('id', $bank_id)->first() ;
            if($bank_info){
                
                return view('supplier.package.paymentbankdetails')->with('bank_info', $bank_info)->with('main_currancy_status', $main_currancy_status)->with('final_product_price', $final_product_price);
            }else{
                echo "<span style='color:red'> Select Bank </span>";
            }
            
            
        }else{
            $bank_info = DB::table('tbl_mobile_bank')->where('id', $bank_id)->first() ;
            if($bank_info){
                return view('supplier.package.paymentmobilebankdetails')->with('bank_info', $bank_info)->with('main_currancy_status', $main_currancy_status)->with('final_product_price', $final_product_price);
                echo "Account Number: <strong>".$bank_info->payment_number .'</strong></br> Counter Number: <strong>'.$bank_info->counter_number.'</strong></br> Payment Amount: <strong>'.'<span style="font-family:SolaimanLipi">'.$main_currancy_status->symbol.'</span> '.$final_product_price.'</strong></br>';
            }else{
                echo "<span style='color:red'> Select Bank </span>";
            }
        }

    }
    
    public function closeMainPopupAds(Request $request)
    {
        $ads_id = $request->ads_id ;
        if($ads_id){
            Session::put('ads_id', $ads_id) ;
            Session::put('ads_close', 1) ;
            
        }
    }
    
    public function insertsupplierpackagepaymentinfo(Request $request)
    {
        
        $payment_bank_id    = $request->payment_bank_id;
        $branch_name        = $request->branch_name;
        $account_name       = $request->account_name;
        $account_number     = $request->account_number;
        $transaction_number = $request->transaction_number;
        $method_type        = $request->method_type;
        $package_id         = $request->package_id;
        $image              = $request->file('recept_copy');
        
        
        if($method_type == 1){
            if($payment_bank_id == "" || $branch_name == "" || $account_name == "" || $account_number == "" || $transaction_number == "")
            {
                echo "all_filed_r_required";
                exit() ;
            } 
        }else{
            if($account_number == "" || $transaction_number == "")
            {
                echo "all_filed_r_required";
                exit() ;
            } 
        }
        
        
        $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        
        $package_info = DB::table('tbl_package')->where('id', $package_id)->first() ;


        $data = array();
        $data['package_id'] = $package_id;
        $data['updated_at'] = date('Y-m-d');
        DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;
        
        
        
        $pacakge_data                           = array();
        $package_data['supplier_id']            = Session::get('supplier_id');
        $package_data['package_id']             = $package_id;
        $package_data['package_duration']       = $package_info->package_duration;
        $package_data['currency_id']            = Session::get('requestedCurrency');
        $package_data['package_price']          = $package_info->package_price ;
        $package_data['discount_percentage']    = $package_info->discount_percentage;
        $package_data['status']                 = 0;
        
        DB::table('tbl_supplier_package_history')->insert($package_data);
        
        $last_package_info = DB::table('tbl_supplier_package_history')->orderBy('id', 'desc')->first() ;
        $main_package_id = $last_package_info->id ;
        
        $payment_data                       = array();
        $payment_data['package_main_id']    = $main_package_id;
        $payment_data['supplier_id']        = Session::get('supplier_id');
        $payment_data['package_id']         = $package_id;
        $payment_data['bank_id']            = $payment_bank_id;
        $payment_data['branch_name']        = $branch_name;
        $payment_data['account_number']     = $account_number;
        $payment_data['package_amount']     = $package_info->package_price;
        $payment_data['discount_percentage'] = $package_info->discount_percentage;
        $payment_data['final_amount']       = $package_info->package_price-$package_info->discount_percentage;
        $payment_data['transaction_id']     = $transaction_number;
        $payment_data['method_type']        = $method_type;
        $payment_data['status']             = 0;
        
        if($image){
            $imageName  = $image->getClientOriginalName();
            $image->move(public_path('images'),$imageName);
            $image_name_with_path = 'public/images/'.$imageName ;
            Image::make($image_name_with_path)->fit(400)->save($image_name_with_path) ;
            
            $payment_data['receipt_copy'] = $imageName;
        }
        
        $payment_data['created_at'] = date("Y-m-d H:i:s") ;
        
        DB::table('tbl_supplier_pacakge_payment_history')->insert($payment_data) ;
        
        echo "success";
        exit() ;

    }
    
    # s
    public function insertSubscribeInfo(Request $request)
    {
        $subscribe_email_address = $request->subscribe_email_address ;
        
        $duplicate = DB::table('tbl_subscribes')->where('email', $subscribe_email_address)->count() ;
        if($duplicate > 0){
            echo "email_exist";
            exit();
        }
        
        $data = array() ;
        $data['email'] = $subscribe_email_address ;
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



}
