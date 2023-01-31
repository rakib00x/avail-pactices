<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use App\Http\Requests;
use App\Models\SecondaryCategoryModel;
use App\Models\TertiaryCategoryModel;
use DB;
use Session;
use Response;
use Hash;
use Mail;
use Cookie;
use \Swift_Mailer;
use \Swift_SmtpTransport as SmtpTransport;

class ApiController extends Controller
{

    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate           = date('Y-m-d');
        $this->logged_id        = Session::get('admin_id');
        $this->current_time     = date('H:i:s');
        
        
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
        $countryCode = $geo_object->countryCode;
        $county_info = DB::table('tbl_countries')->where('countryCode', $countryCode)->first() ;
        

        $getCount    = DB::table('tbl_currency_status')->where('code',$county_info->currencyCode)->count();
        if($getCount == 0){
            $currency_id = 1;
        }else{
            $getCurrency = DB::table('tbl_currency_status')->where('code', $county_info->currencyCode)->first();
            $currency_id = $getCurrency->id;
        }
        
        if(Cache::get('cookie_currency') != null && Cache::get('cookie_browser')){
            Session::put('requestedCurrency', null);
            Session::put('requestedCurrency', Cache::get('cookie_currency'));
            Session::put('countrycode', Cache::get('countryCode'));
        }else{
            Session::put('requestedCurrency', null);
            Session::put('requestedCurrency', $currency_id);
            Session::put('countrycode', $countryCode);
        }
    }

#login
public function searchresult(Request $request)
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
                
            $notification = response()->json([
                'message' =>'Sorry! Your Account Hold For '.date("d-m-Y h:i A", strtotime($attem_info->block_time)).'. Please wait'
            ], 201);
                
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

                    
                   $notification =  response()->json([
                        'message' =>'Login granted successfully'
                    ], 201);
                    
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

                    $notification =  response()->json([
                        'message' =>'Login granted successfully'
                    ], 201);
                    
                    if ($request->prev != "") {
                        return redirect()->intended($request->prev)->with($notification);
                    }else{
                        
                        $notification =  response()->json([
                        'message' =>'Login Fail'
                    ], 201);
                    }
                    
                   
                }
            }else{

                Session::put('login_faild', 'Verify Your Email First And Try Again.');

               $notification = response()->json([
                        'message' =>'Verify Your Email First And Try Again'
                    ], 201);
                // return Redirect::to('signin')->with($notification) ;
            }
       }
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

        return response()->json([
                        'message' =>'Logout Succesfully Done'
                    ], 201);
        
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

             return response()->json([
                        'message' =>'Succsefully'
                    ], 201);
    }
    

    
    
    public function registrationstore(Request $request){

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
          return response()->json([
                        'message' =>'email_duplicate'
                    ], 201);
        }

        $m_count = DB::table('express')
        ->where('mobile', $mobile)
        ->count();
        
        if($m_count > 0){
           return response()->json([
                        'message' =>'mobile_duplicate'
                    ], 201);
        }
        
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return response()->json([
                        'message' =>'invalid_mail'
                    ], 201);
        }

        if($newsletter_status != 1){
             return response()->json([
                        'message' =>'news_status'
                    ], 201);

        }

        $count = DB::table('express')->where('storeName', $store_name)->where('type', 2)->count() ;
        if ($count > 0) {
            return response()->json([
                        'message' =>'duplicate_storename'
                    ], 201);
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
      
          return response()->json([
                        'message' =>'Regration success'
                    ], 201);
        
    }






    # Seconary category with tertiary category 
    public function secondarytertiarycatgeorylist()
    {
        $result = SecondaryCategoryModel::with('tertiarycategorys')->where('status', 1)->get() ;
        return Response::json($result) ;
    }
    
    # ALL PRIMARY CATEGORY LIST 
    public function primarycategorylist()
    {
        $primarycategory    = DB::table('tbl_primarycategory')
            ->where('supplier_id',0)
            ->where('sidebar_active', 1)
            ->orderBy('sidebar_decoration', 'asc')
            ->where('status', 1)
            ->take(7)
            ->get();
            
        return Response::json($primarycategory) ;
    }
    # HOME MAIN SLIDER LIST
    public function homesliderlist()
    {
        $slider             = DB::table('tbl_slider')->where('type',1)->where('status',1)->get();
        return Response::json($slider) ;
    }
    
    #serach
    public function searchresult(Request $request)
    {
        $keywords = $request->keyword;

        $all_product = DB::table('tbl_product')
            ->where('status', 1)
            ->where('product_name', 'like', '%'.$keywords.'%')
            ->paginate(12) ;
            return Response::json($all_product, 200) ;
    }
    # HOME AFTER SLIDER PRODUCT
    public function homeleftthreeproduct()
    {

		$random_first_category = DB::table('tbl_primarycategory')
			->join('tbl_product', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
			->select('tbl_primarycategory.*', 'tbl_product.product_name')
			->inRandomOrder()
			->limit(1)
			->where('tbl_primarycategory.status', 1)
			->first() ;
		if($random_first_category){
		    
		    $three_product_first = DB::table('tbl_product')
    			->join('express', 'tbl_product.supplier_id', '=', 'express.id')
    			->select('tbl_product.*','express.storeName')
    			->where('tbl_product.w_category_id', $random_first_category->id)
    			->inRandomOrder()
    			->limit(3)
    			->where('tbl_product.status', 1)
    			->get() ;
    			
    		return Response::json($three_product_first) ;
    			
		}
			
    }
    
    # JUST FOR PRODUCT 
    public function homejustforproduct()
    {
        $result = DB::table('tbl_product')
            ->join('tbl_product_price', 'tbl_product.id', '=', 'tbl_product_price.product_id')
            ->leftJoin('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
            ->select('tbl_product.*', 'tbl_unit_price.unit_name', 'tbl_currency_status.rate as currency_rate', 'tbl_product_price.product_price', 'tbl_currency_status.symbol', 'tbl_product_price.start_quantity')
            ->where('tbl_product.status', 1)
            ->inRandomOrder()
            ->get() ;
        
        return Response::json($result) ;  
    }
    
   #Second category
   
   public function wkeely_product()
    {
        
        
       $weekly = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->select(DB::raw('sum(quantity) as final_quantity'), 'order_product.*', 'tbl_product.visitor_count')
            ->groupBy('order_product.product_id')
            ->orderBy('final_quantity', 'desc')
            ->inRandomOrder()
            ->limit(3)
            ->get() ;
        
        return Response::json($weekly) ;  
    }
    public function new_product()
    {
      $new  = DB::table('tbl_product')
            ->inRandomOrder()
            ->where('status', 1)
            ->take(3)
            ->orderBy('id', 'desc')
            ->get();
        
        return Response::json($new) ;  
    }
    
     public function feature_product()
    {
      $feature = DB::table('tbl_product')
            ->inRandomOrder()
            ->where('status', 1)
            ->take(12)
            ->get();
        
        return Response::json($feature) ;  
    }
    
     public function allsecondarycategory($category_slug)
    {


        $all_secondary = DB::table('tbl_secondarycategory')
            ->join('tbl_primarycategory', 'tbl_secondarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_secondarycategory.*', 'tbl_primarycategory.category_name', 'tbl_primarycategory.catgeory_slug')
            ->where('tbl_secondarycategory.status', 1)
            ->where('tbl_primarycategory.catgeory_slug', $category_slug)
            ->get() ;
            return Response::json($all_secondary) ;
    }
    
    public function alltertiarycategory($category_slug)
    {


       $tertiary_category = DB::table('tbl_tartiarycategory')
            ->join('tbl_secondarycategory', 'tbl_tartiarycategory.secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->select('tbl_tartiarycategory.*', 'tbl_secondarycategory.secondary_category_slug', 'tbl_secondarycategory.secondary_category_name')
            ->where('tbl_secondarycategory.secondary_category_slug', $category_slug)
            ->where('tbl_tartiarycategory.status', 1)
            ->limit(6)
            ->inRandomOrder()
            ->get() ;
            return Response::json($tertiary_category) ;
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
        
        $p= [];
        array_push($p, $supplier_info);
        array_push($p, $ptitle);
        array_push($p, $social);
        array_push($p, $product);
        array_push($p, $feature_product);
        
        $data = array() ;
        $data['visitor_count'] = $product->visitor_count+1 ;
         DB::table('tbl_product')->where('slug', $slug)->update($data);
        
        return Response::json($p) ;
    }
     public function supplierpackage()
    {
        $package  = DB::table('tbl_package_category')->where('status', 1)->get() ;
         return Response::json($package, 200) ;
    }
    
    public function terms()
    {
        $terms  = DB::table('tbl_terms')->first();
         return Response::json($terms, 200) ;
    }
    
    public function policy()
    {
        $privacy = DB::table('tbl_privacy')->get() ;
        return Response::json($privacy, 200) ;
    }
    // subscribe
    
    public function Subscribe(Request $request)
    {
        $email = $request->email;
        
        $duplicate = DB::table('tbl_subscribes')->where('email', $email)->count() ;
        if($duplicate > 0){
            return response()->json([
                'message' => 'email_exist'
            ], 401);
        }
        
        $data = array() ;
        $data['email'] = $email ;
        $data['status'] = 1 ;
        $data['created_at'] = date("Y-m-d H:i:s") ;
        
        $query = DB::table('tbl_subscribes')->insert($data);
        
            return response()->json([
                'message' => 'success'
            ], 201);

      
    }
    
    // contact
    public function Contact(Request $request){
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
       
   
       return response()->json([
                'message' => 'Contact Message Sent Successfully'
            ], 201);

       
     
    }
    
    
    //Supplier Page
    
 public function supplierpage(Request $request, $storename)
    {

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
            ->paginate(12);
            
            
        $p= [];
        array_push($p, $supplier_info);
        array_push($p, $just_for_you);
        array_push($p, $all_slider);
        
        return Response::json($p, 200) ;   
            
            
        
    }
    public function suppliercatgeorys(Request $request, $store)
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
            
        $p= [];
        array_push($p, $supplier_info);
        array_push($p, $all_primary_category);
        array_push($p, $all_slider);
        
        return Response::json($p, 200) ; 
            
        
    }
    
    public function companyoverview(Request $request, $store)
    {
       $store_info = DB::table('express')
            ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
            ->select('express.*', 'tbl_countries.countryCode')
            ->where('express.storeName', $store)
            ->first() ;
            
            return Response::json($store_info, 200) ; 
    }
    
    public function suppleircategoryproduct($store, $categoryslug)
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
        $allsecondarycategorys =  DB::table('tbl_supplier_secondary_category')
            ->join('tbl_supplier_primary_category', 'tbl_supplier_secondary_category.primary_category_id', '=', 'tbl_supplier_primary_category.id')
            ->select('tbl_supplier_secondary_category.*', 'tbl_supplier_primary_category.catgeory_slug')
            ->where('tbl_supplier_primary_category.catgeory_slug', $categoryslug)
            ->where('tbl_supplier_secondary_category.status', 1)
            ->limit(6)
            ->inRandomOrder()
            ->get() ;  
            
        $p= [];
        array_push($p, $supplier_info);
        array_push($p, $just_for_you);
        array_push($p, $all_slider);
        array_push($p, $allsecondarycategorys);
        array_push($p, $main_currancy_status2);
        
        return Response::json($p, 200) ; 
                
                
    }
    
    public function suppliersecondaryproduct($store, $slug)
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
                
        $p= [];
        array_push($p, $supplier_info);
        array_push($p, $just_for_you);
        array_push($p, $all_slider);
        array_push($p, $allsecondarycategorys);
        array_push($p, $main_currancy_status2);
        
        return Response::json($p, 200) ;      
                
    }
    
    public function ssearch(Request $request, $store)
    {
        $keywords = $request->keywords ;
        
        $supplier_info = DB::table('express')
        ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
        ->select('express.*', 'tbl_countries.countryCode', 'tbl_countries.countryName')
        ->where('express.storeName', $store)
        ->first() ;
        $supplier_id = $supplier_info->id;
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
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
                
        $p= [];
        array_push($p, $supplier_info);
        array_push($p, $just_for_you);
        array_push($p, $keywords);
       
        return Response::json($p, 200) ; 

        
    }
    
    
    //end store page
    public function currency(){
        $main_currancy = DB::table('tbl_currency_status')->where('status', 1)->get() ;
        return Response::json($main_currancy, 200) ;  
    }
    
    
     # CART SECTION 
    public function addtocart(Request $request)
    {
        $product_id  = $request->product_id ;
        $quantity    = $request->quantity ;
        $size_id     = $request->size_id ;
        $color_id    = $request->color_id ;

        if ($size_id != "") {
            $main_size_id = $size_id ;
        }else{
            $main_size_id = 0;
        }

        if (Session::get('buyer_id') == null && Session::get('supplier_id') == null) {
            echo "invalid_login" ;
            exit() ;
        }

        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        $auth_number = Session::get('auth_number') ;
        $track_no    = Session::get('track_no') ;

        $check__product_count = DB::table('cart')
            ->where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->where('size_id', $main_size_id)
            ->where('color_id', $color_id)
            ->count();

        $product_info = DB::table('tbl_product')
            ->where('id', $product_id)
            ->first() ;

        if ($product_info->supplier_id == $customer_id) {
            echo "supplier_not_buy";
            return false ;
        }


        $product_price_info = DB::table('tbl_product_price')
            ->where('product_id',$product_id)
            ->orderBy('id','desc')
            ->first() ;

        if ($check__product_count > 0) {

            $check__product_info = DB::table('cart')
                ->where('product_id', $product_id)
                ->where('customer_id', $customer_id)
                ->where('size_id', $main_size_id)
                ->where('color_id', $color_id)
                ->first() ;

            $quantity = $request->quantity + 1 ;

            $data = array() ;
            $data['quantity']       = $quantity ;
            $data['total_price']    = $check__product_info->sale_price * $quantity ;
            $data['updated_at']     = date('Y-m-d H:i:s') ;

            DB::table('cart')
            ->where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->where('size_id', $main_size_id)
            ->where('color_id', $color_id)
            ->update($data) ;

        }else{

            $discount_count = DB::table('tbl_product')
                ->where('offer_start', '<=', $this->date_time)
                ->where('offer_end', '>=', $this->date_time)
                ->where('id', $product_id)
                ->count() ;

            if ($discount_count){
                if ($product_price_info->discount_type == 1) {
                    $product_price = $product_price_info->product_price - $product_price_info->discount ;
                    $discount__amount = $product_price_info->discount ;
                }else{
                    $discount__amount = $product_price_info->product_price * $product_price_info->discount /100 ;
                    $product_price = $product_price_info->product_price - $discount__amount ;
                }
               
            }else{
                $discount__amount   = 0 ;
                $product_price      = $product_price_info->product_price ;
            }

            $data = array() ;
            $data['auth_number']        = $auth_number ;
            $data['tracking_number']    = $track_no ;
            $data['customer_id']        = $customer_id ;
            $data['supplier_id']        = $product_info->supplier_id ;
            $data['product_id']         = $product_id ;
            $data['color_id']           = $color_id ;
            $data['size_id']            = $main_size_id ;
            $data['quantity']           = $quantity ;
            $data['sale_price']         = $product_price ;
            $data['single_discount']    = $discount__amount ;
            $data['total_price']        = $product_price * $quantity ;
            $data['total_discount']     = $discount__amount * $quantity ;
            $data['created_at']         = date('Y-m-d H:i:s') ;
            DB::table('cart')->insert($data) ;
        }
         return response()->json([
                'message' => 'Add to cart Successfully'
            ], 201);

    }
    
    public function cart()
    {
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        if ($customer_id) {
            $data2 = array() ;
            $data2['status'] = 1 ;
            DB::table('cart')->where('customer_id', $customer_id)->update($data2);
        }

        $result = DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->groupBy('cart.supplier_id')
            ->where('cart.customer_id', $customer_id)
            ->get() ;


        $total_product = DB::table('cart')
            ->where('cart.customer_id', $customer_id)
            ->count();
            
            
        $p= [];
        array_push($p, $result);
        array_push($p, $total_product);
        
        return Response::json($p, 200) ;
    }
     public function cartupdate(Request $request)
    {
        $cart_id     = $request->cart_id ;
        $quantity    = $request->quantity ;

        $cart_info = DB::table('cart')->where('id', $cart_id)->first(); 
        
        
        $total_price = $quantity * $cart_info->sale_price ;

        $data2 = array() ;
        $data2['quantity']      = $quantity;
        $data2['total_price']   = $total_price ;
        DB::table('cart')->where('id', $cart_id)->update($data2);
        
         return response()->json([
                'message' => 'Cart Update Successfully'
            ], 201);
    }
    
    public function checkout($supplier_id = null)
    {

        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

       if ($supplier_id) {
           $total_amount = DB::table('cart')
            ->where('supplier_id', $supplier_id)
            ->where('customer_id', $customer_id)
            ->sum('total_price') ;

            $total_discount = DB::table('cart')
            ->where('supplier_id', $supplier_id)
            ->where('customer_id', $customer_id)
            ->sum('total_discount') ;

            $customer_info = DB::table('express')
                ->where('id', $customer_id)
                ->first() ;
               $p= [];
        array_push($p, $total_amount);
        array_push($p, $total_discount);
        array_push($p, $customer_info);
        array_push($p, $supplier_id);
        return Response::json($p, 200) ;
       }else{
        $total_amount   = 0; 
        $total_discount = 0; 

        $customer_info  = DB::table('express')
                ->where('id', $customer_id)
                ->first() ;
        $p= [];
        array_push($p, $total_amount);
        array_push($p, $total_discount);
        array_push($p, $supplier_id);
        array_push($p, $customer_info);
        return Response::json($p, 200) ;
       } 
                
       }
       
       public function orderplace($supplier_id)
    {
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }


        $result = DB::table('cart')
                ->join('express', 'cart.supplier_id', '=', 'express.id')
                ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
                ->where('cart.customer_id', $customer_id)
                ->where('cart.supplier_id', $supplier_id)
                ->where('cart.status', 1)
                ->get() ;

        $total_order_price = DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->groupBy('cart.supplier_id')
            ->where('cart.customer_id', $customer_id)
            ->where('cart.supplier_id', $supplier_id)
            ->where('cart.status', 1)
            ->sum('total_price') ;

        $total_quantity = 0 ;
        $total_discount = 0 ;
        foreach($result as $value)
        {
            $total_quantity += $value->quantity ;
            $total_discount += $value->total_discount ;
        }

        $invoice = rand(999999, 111111) ;

        $data = array() ;
        $data['invoice_number'] = $invoice ;
        $data['supplier_id']    = $supplier_id ;
        $data['customer_id']    = $customer_id ;
        $data['total_quantity'] = $total_quantity ;
        $data['total_price']    = $total_order_price ;
        $data['total_discount'] = $total_discount ;
        $data['status']         = 0 ;
        $data['created_at']     = date("Y-m-d H:i:s") ;

        DB::table('order')->insert($data) ;

        foreach($result as $value2)
        {
            $data2 = array() ;
            $data2['invoice_number'] = $invoice ;
            $data2['auth_number'] = $value2->auth_number ;
            $data2['tracking_number'] = $value2->tracking_number ;
            $data2['customer_id'] = $value2->customer_id ;
            $data2['supplier_id'] = $value2->supplier_id ;
            $data2['product_id'] = $value2->product_id ;
            $data2['color_id'] = $value2->color_id ;
            $data2['size_id'] = $value2->size_id ;
            $data2['quantity'] = $value2->quantity ;
            $data2['sale_price'] = $value2->sale_price ;
            $data2['single_discount'] = $value2->single_discount ;
            $data2['total_price'] = $value2->total_price ;
            $data2['total_discount'] = $value2->total_discount ;
            $data2['status'] = 0 ;
            $data2['created_at'] = date("Y-m-d H:i:s") ;

            DB::table('order_product')->insert($data2) ;
        }


        DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->where('cart.customer_id', $customer_id)
            ->where('cart.status', 1)
            ->delete() ;
            
            return response()->json([
                'message' => 'Order Place Successfully'
            ], 201);
    }
    
    public function removecart($id)
    {
        DB::table('cart')
        ->where('id', $id)
        ->delete() ;
        
        return response()->json([
                'message' => 'Product remove successfully'
            ], 201);
    }
    
    
     public function sentQuery(Request $request)
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
            $notification = response()->json([
                'message' => 'Quotation send successfully'
            ], 201);
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
        
          return response()->json([
                'message' => 'Quotation send successfully'
            ], 201);
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

            return response()->json([
                'message' => 'Address Information Already Exist'
            ], 201);

            // return back()->with($notification) ;

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

        
      return response()->json([
                'message' => 'Address Information Add Successfully'
            ], 201);
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
         return response()->json([
                'message' => 'Address Information Change Successfully'
            ], 201);
    }
    
    //chat option
    public function chatperson()
    {
        if(Session::get('buyer_id') != NULL || Session::get('supplier_id') != null){
            if(Session::get('buyer_id') != NULL){
                $login_primary_id = Session::get('buyer_id');
            }else{
                $login_primary_id = Session::get('supplier_id');
            }
        }else{
            $login_primary_id =0 ;
        }
        
        if($login_primary_id == 0){
            return Redirect::to('m/signin');
        }

        $getSupplier = DB::table('tbl_messages')->where('sender_id',$login_primary_id)->orWhere('receiver_id',  $login_primary_id)->get();
        
        $allSupplierIds = array();
        $allSenderIds = array();
        foreach($getSupplier as $supplierChatValue){
            $allSupplierIds[]   = $supplierChatValue->receiver_id;
            $allSenderIds[]     = $supplierChatValue->sender_id;
            
            $data_main_chat                         = array();
            $data_main_chat['chat_person_count']    = 1;
            DB::table('tbl_messages')->where('receiver_id', $login_primary_id)->update($data_main_chat) ;
        }
        
        $mainSupplierMarge = array_merge($allSupplierIds, $allSenderIds);
        
        $uniqueArray = array_unique($mainSupplierMarge);
        
        $p= [];
        array_push($p, $login_primary_id);
        array_push($p, $uniqueArray);
        return Response::json($p, 200) ;
        
    }
    
    
    public function chatnewperson(Request $request)
    {
        if (Session::get('supplier_id') != null) {
            $my_id      = Session::get('supplier_id') ;
        }else{
            $my_id      = Session::get('buyer_id') ;
        }
        
        $result = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('express.*', 'tbl_messages.sender_id', 'tbl_messages.receiver_id', 'tbl_messages.chat_person_count')
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.chat_person_count', 0)
            ->get() ;
        
        $total_count_user = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('express.*', 'tbl_messages.sender_id', 'tbl_messages.receiver_id', 'tbl_messages.chat_person_count')
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.chat_person_count', 0)
            ->count() ;

        if($total_count_user > 0){
            $data_main_chat                         = array();
            $data_main_chat['chat_person_count']    = 1;
            DB::table('tbl_messages')->where('receiver_id', $my_id)->update($data_main_chat) ;
        $p= [];
        array_push($p, $result);
        array_push($p, $my_id);
        return Response::json($p, 200) ;
        
        }else{
            
            return response()->json([
                'message' => '2'
            ], 201);
        }
    }
    
      # MOBILE CHAT SECTION 
    public function appchat($receiver_id)
    {
        
    	if(Session::get('buyer_id') != NULL){
    		$sender_id = Session::get('buyer_id');
    	}else{
    		$sender_id = Session::get('supplier_id');
    	}

        $receiverPhotoQuery = DB::table('express')->where('id',$receiver_id)->first();
        if($receiverPhotoQuery->image != "" || $receiverPhotoQuery->image != null){

            if(strpos($receiverPhotoQuery->image, "https") !== false){
                $rphoto = $receiverPhotoQuery->image ;
            } else{
                $rphoto = "public/images/".$receiverPhotoQuery->image;
            }
        }else{
            $rphoto = "public/images/Image 4.png";
        } 


        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.receiver_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image','express.type','tbl_messages.image as chatphoto')
            ->whereIn('sender_id', [$sender_id, $receiver_id])
            ->whereIn('receiver_id', [$receiver_id, $sender_id])
            ->get();

        $data = array();
        $data['is_read'] = 1; 
            
        DB::table('tbl_messages')->where('receiver_id', $sender_id)->update($data);
        
        $p= [];
        array_push($p, $fetchingChat);
        array_push($p, $rphoto);
        array_push($p, $sender_id);
        array_push($p, $receiver_id);
        array_push($p, $receiverPhotoQuery);
        return Response::json($p, 200) ;
    }
    public function loadMessages(Request $request)
    {
        $receiver_id = $request->receiver_id ;
        if(Session::get('buyer_id') != NULL){
    		$sender_id = Session::get('buyer_id');
    	}else{
    		$sender_id = Session::get('supplier_id');
    	}

        $receiverPhotoQuery = DB::table('express')->where('id',$receiver_id)->first();
        if($receiverPhotoQuery->image != "" || $receiverPhotoQuery->image != null){

            if(strpos($receiverPhotoQuery->image, "https") !== false){
                $rphoto = $receiverPhotoQuery->image ;
            } else{
                $rphoto = "public/images/".$receiverPhotoQuery->image;
            }
        }else{
            $rphoto = "public/images/Image 4.png";
        } 


        $fetchingChat = DB::table('tbl_messages')
            ->join('express','tbl_messages.receiver_id','=','express.id')
            ->select('tbl_messages.*','express.first_name','express.last_name','express.image','express.type','tbl_messages.image as chatphoto')
            ->whereIn('sender_id', [$sender_id, $receiver_id])
            ->whereIn('receiver_id', [$receiver_id, $sender_id])
            ->get();

        $data = array();
        $data['is_read'] = 1; 
            
        DB::table('tbl_messages')->where('receiver_id', $sender_id)->update($data);
        
        $p= [];
        array_push($p, $fetchingChat);
        array_push($p, $rphoto);
        array_push($p, $sender_id);
        array_push($p, $receiver_id);
        array_push($p, $receiverPhotoQuery);
        return Response::json($p, 200) ;
        
    }
    
    public function saveMessage(Request $request)
    {
        $message    = $request->message;
        $attachment = $request->file('attachment');

        $receiver_id = $request->receiver_id;

        if(Session::get('supplier_id') != NULL){
            $sender_id = Session::get('supplier_id');
        }else{
            $sender_id = Session::get('buyer_id');
        }

        $data = array();

        if($attachment){
            $image_name        = Str::random(12);
            $ext               = strtolower($attachment->getClientOriginalExtension());
            $image_full_name   = $image_name.'.'.$ext;
            $upload_path       = "public/images/";
            $success           = $attachment->move($upload_path,$image_full_name);
            // with image
            $data['image']     = $image_full_name;
        }

        $data['sender_id'] = $sender_id;
        $data['receiver_id'] = $receiver_id;
        $data['product_id'] = 0;
        $data['message'] = $message;
        $data['is_read'] = 0;
        $data['chat_person_count'] = 1;
        $data['created_at'] = date('Y-m-d H:i:s');

        $query = DB::table('tbl_messages')->insert($data);

                // pusher
                $options = array(
                    'cluster' => 'ap2',
                    'useTLS' => true
                );
        
                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options
                );
        
                $data = ['from' => $sender_id, 'to' => $receiver_id, 'messages'=> $message]; // sending from and to user id when pressed enter
                $pusher->trigger('my-channel', 'my-event', $data);
        

        if($query){
            return response()->json([
                'message' => '1'
            ], 201);
        }else{
           return response()->json([
                'message' => '2'
            ], 201);
        }
    }
    
    
    public function getUnreadMessage(Request $request)
    {
        $receiver_id        = $request->receiver_id;
        
        if(Session::get('buyer_id') != NULL){
            $sender_id = Session::get('buyer_id');
        }else{
            $sender_id = Session::get('supplier_id');
        }

        $count = DB::table('tbl_messages')->where('receiver_id', $sender_id)->where('is_read',0)->count();

        if($count > 0){
            return response()->json([
                'message' => 'load'
            ], 201);
        }else{
            return response()->json([
                'message' => 'sorry'
            ], 201);
           
        }
    }
    
    # NEW CHAT PERSON COUNT 
    public function userMessagecount(Request $request)
    {
        if (Session::get('supplier_id') != null) {
            $my_id      = Session::get('supplier_id') ;
        }else{
            $my_id      = Session::get('buyer_id') ;
        }
        
        $result = DB::table('tbl_messages')
            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
            ->select('tbl_messages.*', DB::raw('count(tbl_messages.id) as totalnewmessage'))
            ->where('tbl_messages.receiver_id', $my_id)
            ->where('tbl_messages.is_read', 0)
            ->groupBy('tbl_messages.sender_id')
            ->get() ;
        
        
        return response()->json($result, 200); 
    }
    
    
     public function insertChatInfo($product_id, $supplier_id)
    {

        if(Session::get('buyer_id') != NULL || Session::get('supplier_id') != null){
            if(Session::get('buyer_id') != NULL){
                $login_primary_id = Session::get('buyer_id');
            }else{
                $login_primary_id = Session::get('supplier_id');
            }
        }else{
            $login_primary_id =0 ;
        }
        
        // if($login_primary_id == 0){
            
        //     // return Redirect::to('m/signin');
        // }

        // if($login_primary_id == $supplier_id){
            
        //     // return back() ;
        // }
    
        $sender_id      = $login_primary_id;


        
        if($product_id > 0){
            $productQuery = DB::table('tbl_product')->where('id',$product_id)->first();
            $product_images = $productQuery->products_image;
    
            $array = explode("#",$product_images);
            $image = $array[0];
    
            $product_count = DB::table('tbl_messages')->where('product_id', $product_id)->where('sender_id', $sender_id)->where('receiver_id',$supplier_id)->count();
            if($product_count == 0){
                $message = array();
                $message['chatting_id'] = 0;
                $message['sender_id']   = $sender_id;
                $message['receiver_id'] = $supplier_id;
                $message['product_id']  = $product_id;
                $message['message']     = $productQuery->product_name;
                $message['image']       = $image;
                $message['is_read']     = 0;
                $message['created_at']  = $this->rcdate;
                $query = DB::table('tbl_messages')->insert($message);
            }

            $messageCount = DB::table('tbl_messages')->where('sender_id', $sender_id)->where('receiver_id',$supplier_id)->count();

        }else{

            $messageCount = DB::table('tbl_messages')->where('sender_id', $sender_id)->where('receiver_id',$supplier_id)->count();
            if($messageCount == 0){
                $message = array();
                $message['chatting_id'] = 0;
                $message['sender_id']   = $sender_id;
                $message['receiver_id'] = $supplier_id;
                $message['product_id']  = $product_id;
                $message['message']     = "Hello";
                $message['image']       = null;
                $message['is_read']     = 0;
                $message['created_at']  = $this->rcdate;
                $query = DB::table('tbl_messages')->insert($message);
            }
            
        }
         return response()->json([
                'message' => 'Chat Start'
            ], 201);
    }
}
