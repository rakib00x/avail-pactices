<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;
use Image;
use DB;
use Session;
use Cookie;
use Response;
use Mail;
use \Swift_Mailer;
use \Swift_SmtpTransport as SmtpTransport;

class AdminController extends Controller{
// basic function
    private $rcdate;
    private $logged_id;
    private $current_time;

    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate           = date('Y-m-d');
        $this->logged_id        = Session::get('admin_id');
        $this->current_time     = date('H:i:s');
    }

    public function adminLogin(Request $request){
        $email    = trim($request->email);
        $password = trim($request->password);
        $remember = $request->remember;

        $salt      = 'a123A321';
        $encrypted = sha1($password.$salt);

        $count = DB::table('express')->where('email',$email)->where('password',$encrypted)->where('type', 1)->count();

        if($count > 0){

            $query = DB::table('express')->where('email',$email)->where('password',$encrypted)->where('type', 1)->first();

            $first_name = $query->first_name;
            $last_name  = $query->last_name;
            $full_name  = $first_name." ".$last_name;

            Session::put('admin_id',$query->id);
            Session::put('full_name',$full_name);
            Session::put('type',$query->type);

            if($remember){
                Cookie::queue('admin_cookie_email', $email, 525000);
                Cookie::queue('admin_cookie_password', $request->password, 525000);
                Cookie::queue('admin_remember', $remember, 525000);
            }

            return "1";
        }else{
            return "2";
        }
    }

    public function adminDashboard(){
        return view('admin.adminDashboard');
    }

    public function adminLogout(){
        Session::put('admin_id', null);
        Session::put('full_name', null);
        Session::put('type', null);

        return Redirect::to('/');
    }



     //SMTP.............................................................
  public function smtp(){
      $smtp_registration = DB::table('tbl_smtp')->where('target','r')->first();
      $smtp_forget = DB::table('tbl_smtp')->where('target','f')->first();
      $smtp_subscribtion = DB::table('tbl_smtp')->where('target','s')->first();
      return view('admin.smtp')->with('smtp_registration',$smtp_registration)->with('smtp_forget',$smtp_forget)->with('smtp_subscribtion',$smtp_subscribtion);
  }

  public function updateRegistrationSmtp(Request $request)
  {
      // Validation
      $this->validate($request, [
          'mail_host' => 'required',
          'mail_port' => 'required',
          'mail_username' => 'required',
          'mail_password' => 'required',
          'mail_encryption' => 'required',
          'reply_email' => 'required',
          'from_name' => 'required'
      ]);

      //Collecting data from html form
      $mail_host = trim($request->mail_host);
      $mail_port = trim($request->mail_port);
      $mail_username = trim($request->mail_username);
      $mail_password = trim($request->mail_password);
      $mail_encryption = trim($request->mail_encryption);
      $reply_email = trim($request->reply_email);
      $from_name = trim($request->from_name);

      $data = array();
      $data['mail_host']  = $mail_host;
      $data['mail_port']  = $mail_port;
      $data['mail_username'] = $mail_username;
      $data['mail_password'] = $mail_password;
      $data['mail_encryption'] = $mail_encryption;
      $data['reply_email'] = $reply_email;
      $data['from_name'] = $from_name;

      $query = DB::table('tbl_smtp')->where('target','r')->update($data);

      if($query){
          Session::put('success-r','Congratulations, SMTP updated sucessfully !!');
          return Redirect::to('smtp');
      }else{
          Session::put('failed-r','Alas !! Error occured, try again.');
          return Redirect::to('smtp');
      }
  }

    public function updateForgetSmtp(Request $request)
    {
        // Validation
        $this->validate($request, [
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'reply_email' => 'required',
            'from_name' => 'required'
        ]);

        //Collecting data from html form
        $mail_host = trim($request->mail_host);
        $mail_port = trim($request->mail_port);
        $mail_username = trim($request->mail_username);
        $mail_password = trim($request->mail_password);
        $mail_encryption = trim($request->mail_encryption);
        $reply_email = trim($request->reply_email);
        $from_name = trim($request->from_name);

        $data = array();
        $data['mail_host']  = $mail_host;
        $data['mail_port']  = $mail_port;
        $data['mail_username'] = $mail_username;
        $data['mail_password'] = $mail_password;
        $data['mail_encryption'] = $mail_encryption;
        $data['reply_email'] = $reply_email;
        $data['from_name'] = $from_name;

        $query = DB::table('tbl_smtp')->where('target','f')->update($data);

        if($query){
            Session::put('success-f','Congratulations, SMTP updated sucessfully !!');
            return Redirect::to('smtp');
        }else{
            Session::put('failed-f','Alas !! Error occured, try again.');
            return Redirect::to('smtp');
        }
    }

    public function updateSubscribeSmtp(Request $request)
    {
        // Validation
        $this->validate($request, [
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'reply_email' => 'required',
            'from_name' => 'required'
        ]);

        //Collecting data from html form
        $mail_host = trim($request->mail_host);
        $mail_port = trim($request->mail_port);
        $mail_username = trim($request->mail_username);
        $mail_password = trim($request->mail_password);
        $mail_encryption = trim($request->mail_encryption);
        $reply_email = trim($request->reply_email);
        $from_name = trim($request->from_name);

        $data = array();
        $data['mail_host']  = $mail_host;
        $data['mail_port']  = $mail_port;
        $data['mail_username'] = $mail_username;
        $data['mail_password'] = $mail_password;
        $data['mail_encryption'] = $mail_encryption;
        $data['reply_email'] = $reply_email;
        $data['from_name'] = $from_name;

        $query = DB::table('tbl_smtp')->where('target','s')->update($data);

        if($query){
            Session::put('success-s','Congratulations, SMTP updated sucessfully !!');
            return Redirect::to('smtp');
        }else{
            Session::put('failed-s','Alas !! Error occured, try again.');
            return Redirect::to('smtp');
        }
    }

     // Admin Social Media  .............................................................
  public function socialMedia(){
    $social = DB::table('tbl_social_media')->where('supplier_id', 0)->first();
    return view ('admin.socialMedia')->with('social',$social);
  }

  //update
  public function socialMediaUpdate(Request $request){
    $facebook   = $request->facebook ;
    $twitter    = $request->twitter ;
    $google     = $request->google ;
    $youtube    = $request->youtube ;
    $instagram  = $request->instagram ;
    $linkedin   = $request->linkedin ;
    $pinterest  = $request->pinterest ;
    $primary_id = $request->primary_id ;

    $data               = array() ;
    $data['supplier_id']   = 0 ;
    $data['facebook']   = $facebook ;
    $data['twitter']    = $twitter ;
    $data['google']     = $google ;
    $data['youtube']    = $youtube ;
    $data['instagram']  = $instagram ;
    $data['linkedin']   = $linkedin ;
    $data['pinterest']  = $pinterest ;
    $data['created_at'] = $this->rcdate ;
    $query  = DB::table('tbl_social_media')->where('supplier_id',0)->count() ;
    if($query == 0){
         $main_query = DB::table('tbl_social_media')->insert($data) ;
    }else{
         $main_query = DB::table('tbl_social_media')->where('id', $primary_id)->update($data) ;
    }
    if ($main_query) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
      exit() ;
    }
  }

    //Add New Form.............................................................
     public function addForm(){
        return view('admin.addForm');
    }

    // View Media Image .............................................................
     public function viewMediaImage(){
        return view('admin.viewMediaImage');
    }

    //currency
     public function currencysiam(){
         
        return view ('admin.currency');
     }

     // Get Currency
     public function getCurrency(){
         $currency = DB::table('tbl_currency_status')->get();
        return view ('admin.getCurrency')->with('currency',$currency);
     }

     // Get Currency List
     public function getCurrencyList(){
         $currencies = DB::table('tbl_currency_status')->get();
        return view ('admin.getCurrencyList')->with('currencies',$currencies);
     }
     // Get Currency List
     public function getSymbolList(){
         $result = DB::table('tbl_symbol')->get();
        return view ('admin.getSymbolList')->with('symbols',$result);
     }

     public function changeCurrencyStatus(Request $request)
     {
         $currencyid = $request->currencyid;

         $query = DB::table('tbl_currency_status')->where('id',$currencyid)->first();
         $currentStatus = $query->status;

         if($currentStatus == 0){

             $data = array();
             $data['status'] = 1;
             DB::table('tbl_currency_status')->where('id',$currencyid)->update($data);

             return 1;

         }else{

             $data = array();
             $data['status'] = 0;
             DB::table('tbl_currency_status')->where('id',$currencyid)->update($data);

             return 2;
         }

     }
     
     public function defultCurrency(Request $request)
     {
         $currencyid = $request->currencyid;
        
         $query = DB::table('tbl_countries')->get();
         
         
         foreach($query as $querys){
             $ids = $querys->id;
             $data = array();
              $data['stuas'] = 0;
              DB::table('tbl_countries')->where('id', $ids)->update($data);
            }
            
        $findcurency = DB::table('tbl_countries')->where('id', $currencyid)->first();
           if($findcurency->stuas !=1){
             $data = array();
             $data['stuas'] = 1;
              DB::table('tbl_countries')->where('id', $currencyid)->update($data);
              return 1;
           }else{
             return 2;
             
         }

     }

    public function currencyChangeStatus(Request $request){
        $id = $request->id;
        $currency = DB::table('tbl_currency_status')->where('id',$id)->first();
        $data = array();

        $data ->status = $request->status;
        $query = DB::table('tbl_currency_status')->where('id',$id)->update($data);
        if($query){
            Session::put('success','Record Updated sucessfully !!');
            return response()->json(['success'=>'Status change successfully.']);
        }

    }


    public function setDefaultSymbol(Request $request){
        $id = $request->symbol_id;
        $symbol_status = DB::table('tbl_symbol')->where('id',$id)->first();

        $data                   = array();
        $data['status']         = 1;
        $query = DB::table('tbl_symbol')->where('id',$id)->update($data);

        $data2                    = array();
        $data2['status']  = 0 ;
        DB::table('tbl_symbol')->whereNotIn('id',[$id])->update($data2);

        echo "success" ;
    }

    public function currencyAdd(Request $request){

        $name = trim($request->name);
        $rate = trim($request->rate);
        $code = trim($request->code);
        $symbol = trim($request->symbol);


        $count = DB::table('tbl_currency_status')
        ->where('name', $name)
        ->where('rate', $rate)
        ->where('code', $code)
        ->count();

//        if($count > 0){
//            Session::put('failed','Sorry !! '.$color_name.' This Name already exits. Try to add new Name');
//            return Redirect::to('currency');
//            exit();
//        }

        $data = array();
        $data['name']  = $name;
        $data['rate']  = $rate;
        $data['code']  = $code;
        $data['symbol']  = $symbol;
        $data['status']  = 0;

        $query = DB::table('tbl_currency_status')->insert($data);

        if($query){
//            Session::put('success','New Record added sucessfully !!');
//            return Redirect::to('currency');
            return 1;

        }else{
//            Session::put('failed','Alas !! Error occured, try again.');
//            return Redirect::to('currency');
            return 2;
        }
    }

    public function currencyEdit(Request $request){
        $id = $request->id;
        $currency = DB::table('tbl_currency_status')->where('id',$id)->first();
        echo $currency->name."|".$currency->symbol."|".$currency->rate."|".$currency->code."|".$currency->bdrate."|".$id ;
    }

    public function currencyUpdate(Request $request){
         $this->validate($request, [
            'name' => 'required',
            'rate' => 'required',
            'code' => 'required',
            'symbol' => 'required'
        ]);

        $name           = $request->name;
        $rate           = $request->rate;
        $code           = $request->code;
        $symbol         = $request->symbol;
        $id             =$request->primary_id;


        $count = DB::table('tbl_currency_status')
        ->where('name', $name)
        ->where('code', $code)
        ->where('symbol', $symbol)
        ->where('rate', $rate)
        ->whereNotIn('id', [$id])
        ->count();

        if($count > 0){
           echo "duplicate_count";
           exit() ;
        }

        $data             = array();
        $data['name']     = $name;
        $data['rate']     = $rate;
        $data['code']     = $code;
        $data['symbol']   = $symbol;

        $query = DB::table('tbl_currency_status')->where('id',$id)->update($data);

        if($query){
          echo "success";
          exit() ;
        }else{
          echo "failed";
          exit() ;
        }
    }

    public function currencyDelete(Request $request){
      $id = $request->id ;
        $query = DB::table('tbl_currency_status')->where('id',$id)->delete();

        if($query){
            echo "success";
            exit() ;
        }else{
            echo "failed";
            exit() ;
        }
    }
    //buyer list
     public function allBuyer(){
      return view('admin.buyer.allBuyer');
    }
   public function getAllBuyer(Request $request)
    {
      $result = DB::table('express')
        ->where('type', 3)
        ->orderBy('id', 'desc')
        ->get();

      return view('admin.buyer.getAllBuyer')->with('result', $result) ;
    }
    
    public function getBuyerByStatus(Request $request)
    {
      $status = $request->status ;

      if ($status == "") {
        $result = DB::table('express')
            ->where('type', 3)
            ->orderBy('id', 'desc')
            ->get();
      }else{
        $result = DB::table('express')
            ->where('type', 3)
            ->where('status', $status)
            ->orderBy('id', 'desc')
            ->get();
      }

      return view('admin.buyer.getAllBuyer')->with('result', $result) ;
    }
    // subSeller Admin Dashboard  Setting......................................
    public function allSubSeller(){
      return view('admin.seller.allSubSeller');
    }
     # GET ALL SupSELLER USING ON PAGE LOAD
    public function getSubAllSaller(Request $request)
    {
      $result = DB::table('express')->where('type', 2)->where('seller_type', 1)->orderBy('id', 'desc')->get();

      return view('admin.seller.getAllSubSeller')->with('result', $result) ;
    }
    
    public function getSubSellerByStatus(Request $request)
    {
      $status = $request->status ;

      if ($status == "") {
        $result = DB::table('express')->where('type', 2)->where('seller_type', 1)->orderBy('id', 'desc')->get();
      }else{
        $result = DB::table('express')->where('type', 2)->where('seller_type', 1)
              ->where('status', $status)
             ->orderBy('id', 'desc')
             ->get();
      }

      return view('admin.seller.getAllSubSeller')->with('result', $result) ;
    }
  //Seller Profile
      public function sellerSubProfile($id){
        $value = DB::table('express')->where('id', $id)->first();
        return view('admin.sellerProfile')->with('value', $value);
    }
    
    
    // Seller Admin Dashboard  Setting......................................
    public function allSeller(){
      return view('admin.allSeller');
    }

    # GET ALL SELLER USING ON PAGE LOAD
    public function getAllSaller(Request $request)
    {
      $result = DB::table('express')
        ->leftJoin('tbl_package', 'express.package_id', '=', 'tbl_package.id')
        ->select('express.*', 'tbl_package.package_name')
        ->where('express.type', 2)
        ->where('express.seller_type', 0)
        ->orderBy('express.id', 'desc')
        ->get();

      return view('admin.getAllSeller')->with('result', $result) ;
    }

    public function getSellerByVerifyStatus(Request $request)
    {
      $verify_status = $request->verify_status ;

      if ($verify_status == "") {
        $result = DB::table('express')
            ->leftJoin('tbl_package', 'express.package_id', '=', 'tbl_package.id')
            ->select('express.*', 'tbl_package.package_name')
            ->where('express.type', 2)
            ->where('express.seller_type', 0)
            ->orderBy('express.id', 'desc')
            ->get();
      }else{

        $result = DB::table('express')
        ->leftJoin('tbl_package', 'express.package_id', '=', 'tbl_package.id')
        ->select('express.*', 'tbl_package.package_name')
        ->where('express.type', 2)
        ->where('express.seller_type', 0)
        ->where('express.verify_status',  $verify_status)
        ->orderBy('express.id', 'desc')
        ->get();
      }

      return view('admin.getAllSeller')->with('result', $result) ;
    }

    public function getSellerByStatus(Request $request)
    {
      $status = $request->status ;

      if ($status == "") {
        $result = DB::table('express')
            ->leftJoin('tbl_package', 'express.package_id', '=', 'tbl_package.id')
            ->select('express.*', 'tbl_package.package_name')
            ->where('express.type', 2)
            ->where('express.seller_type', 0)
            ->orderBy('id', 'desc')
            ->get();
      }else{
        $result = DB::table('express')
            ->leftJoin('tbl_package', 'express.package_id', '=', 'tbl_package.id')
            ->select('express.*', 'tbl_package.package_name')
            ->where('express.status', $status)
            ->where('express.seller_type', 0)
            ->orderBy('express.id', 'desc')
            ->get();
      }

      return view('admin.getAllSeller')->with('result', $result) ;
    }


    //Seller Payouts
      public function sellerPayout(){
        return view('admin.sellerPayout');
    }
    //Seller Profile
      public function sellerProfile($id){
        $value = DB::table('express')->where('id', $id)->first();
        return view('admin.sellerProfile')->with('value', $value);
    }

    public function loginWithSeller($id)
    {
      $query = DB::table('express')->where('type', 2)->where('seller_type', 0)->where('id', $id)->first() ;
      Session::put('email', $query->email);
      Session::put('supplier_id', $query->id);
      Session::put('supplier_type', $query->type);
      Session::put('seller_type', $query->seller_type);
      return Redirect::to('supplierDashboard') ;
    }
    
     public function loginWithSubSeller($id)
     {
      $query = DB::table('express')->where('type', 2)->where('seller_type', 1)->where('id', $id)->first() ;
      Session::put('email', $query->email);
      Session::put('supplier_id', $query->id);
      Session::put('supplier_type', $query->type);
      Session::put('seller_type', $query->seller_type);
      return Redirect::to('sellerDashboard') ;
     }
    
   public function loginWithBuyer($id)
    {
      $query = DB::table('express')->where('type', 3)->where('id', $id)->first() ;
      Session::put('email', $query->email);
      Session::put('buyer_id', $query->id);
      Session::put('buyer_type', $query->type);
      return Redirect::to('buyerDashboard') ;
    }
    
    public function changeSellerStatus(Request $request)
    {
      $seller_id = $request->seller_id ;
      $seller_info = DB::table('express')->where('id', $request->seller_id)->first() ;

    if($seller_info->status == 2 || $seller_info->status == 3){
        $status = 1 ;
     }else{
        $status = 2 ;
     }

      $data = array() ;
      $data['status'] = $status ;
      DB::table('express')->where('id', $seller_id)->update($data);
      if ($status == 1) {
        echo "success";
        exit() ;
      }else{
        echo "failed" ;
        exit() ;
      }

    }

    //Seller Payout Request
      public function sellerPayoutRequest(){
        return view('admin.sellerPayoutRequest');
    }
     //Seller Payment Show
      public function sellerPaymentShow(){
        return view('admin.sellerPaymentShow');
    }
    //Seller Package
      public function sellerPackage(){
        return view('admin.sellerPackage');
    }
    //Seller Package
      public function addSellerPackage(){
        return view('admin.addSellerPackage');
    }
            //Seller Update Package
    public function updateSellerPackage(){
        return view('admin.updateSellerPackage');
    }


  // category  slider
 public function categorySlider(){
    $all_primarycategory = DB::table('tbl_primarycategory')->where('status', 1)->get();
    $result = DB::table('tbl_category_slider')->orderBy('slider_title', 'asc')->get();
    return view('admin.categorySlider.categorySliderList')->with('result', $result)->with('all_primarycategory', $all_primarycategory);
  }

  public function insertCategorySlider(Request $request){
       $request->validate([
            'primary_category' => 'required',
            'slider_image' => 'required|mimes:jpeg,png,jpg,gif,svg'
        ]);
      
    $primary_category = $request->primary_category;  
    $slider_title = $request->slider_title;
    $slider_link = $request->slider_link;
    $slider_image = $request->slider_image;

    $data_count = DB::table('tbl_category_slider')
    ->where('slider_title', $slider_title)
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }

    // if ($slider_title == "" || $slider_image == "" ) {
    //   echo "invalid_input" ;
    //   exit() ;
    // }

    $data                  = array();
    $data['slider_title']  = $slider_title;
    $data['slider_link']   = $slider_link;
    // $data['slider_image']  = $slider_image;
    $data['primary_category_id']  = $primary_category;
    $data['status']        = 1 ;
    $data['type']          = 1 ;
    $data['created_at']    = $this->rcdate ;
        if ($request->hasFile('slider_image')) {
            $image = $request->file('slider_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1100,550)->save(base_path('public/images/categorySlider/') . $new_image_name);
            $data['slider_image']  = $new_image_name;
        } 

    $query = DB::table('tbl_category_slider')->insert($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function getAllCategorySlider(Request $request){
    $result = DB::table('tbl_category_slider')->orderBy('slider_title', 'asc')->get();
    return view('admin.categorySlider.categorySliderData')->with('result', $result) ;
  }

  public function changeCategorySliderStatus(Request $request){
    $slider_id = $request->slider_id;
    $status_check   = DB::table('tbl_category_slider')->where('id', $slider_id)->first() ;
    $status         = $status_check->status;

    if ($status == 1) {
      $db_status = 2 ;
    }else{
      $db_status = 1 ;
    }

    $data           = array() ;
    $data['status'] = $db_status ;
    $query = DB::table('tbl_category_slider')->where('id', $slider_id)->update($data) ;
    if ($db_status == 1) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
    }
  }

  public function editCategorySlider(Request $request){
    $id = $request->id ;
    $value   = DB::table('tbl_category_slider')->where('id', $id)->first();
    return view('admin.categorySlider.editCategorySlider')->with('value', $value) ;
  }

  public function updateCategorySlider(Request $request){
    $slider_title = $request->slider_title;
    $slider_link = $request->slider_link;
    $slider_image = $request->slider_image;
    $primary_id     = $request->primary_id ;
    
    
$image = DB::table('tbl_category_slider')->where('id', $request->primary_id)->first() ;



    if ($slider_title == "") {
      echo "invalid_input" ;
      exit() ;
    }

    $data_count = DB::table('tbl_category_slider')
    ->where('slider_title', $slider_title)
    ->whereNotIn('id', [$primary_id])
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }

    $data                   = array() ;
    $data['slider_title']  = $slider_title;
    $data['slider_link']  = $slider_link;
    // $data['slider_image']  = $slider_image;
    $data['created_at']     = $this->rcdate ;
    
    if ($request->hasFile('slider_image')) {
         $image_path = public_path('images/categorySlider/' .$image->slider_image);
        if ($image->slider_image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('slider_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1100,550)->save(base_path('public/images/categorySlider/') . $new_image_name);
            $data['slider_image']  = $new_image_name;
        } 

    $query = DB::table('tbl_category_slider')->where('id', $primary_id)->update($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function categorySliderDelete(Request $request)
  {
    $id = $request->id ;
    $image = DB::table('tbl_category_slider')->where('id', $id)->first() ;
    $image_path = public_path('images/categorySlider/' .$image->slider_image);
        if ($image->slider_image && file_exists($image_path)) {
                    unlink($image_path);
                }
    $query = DB::table('tbl_category_slider')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }
  }

  // category  slider
  public function homeSlider(){
    $result = DB::table('tbl_slider')->orderBy('slider_title', 'asc')->get();
    return view('admin.homeSlider.sliderList')->with('result', $result) ;
  }

  public function insertSliderInfo(Request $request){
      
    //   $this->validate($request, [
    //         'slider_image'              => 'required|image|mimes:jpeg,png,jpg,gif,svg',
    //     ]);
        
    // $image = Image::make($request->file('slider_image')->getRealPath());
    $image = $request->slider_image;
      

    $data                = array();
    $data['slider_title']  = $request->slider_title;
    $data['slider_link']  = $request->slider_link;
    $data['slider_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $request->slider_title)) ;
    // $data['slider_image']  = $slider_image;
    $data['status']      = 1 ;
    $data['type']      = 1 ;
    $data['created_at']  = $this->rcdate ;
   if ($request->hasFile('slider_image')) {
            $image = $request->file('slider_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/homeSlider/') . $new_image_name);
            $data['slider_image']  = $new_image_name;
        } 
    
    $query = DB::table('tbl_slider')->insert($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function getAllSlider(Request $request)
  {
    $result = DB::table('tbl_slider')->where('type', 1)->orderBy('slider_title', 'asc')->get() ;

    return view('admin.homeSlider.sliderData')->with('result', $result) ;
  }

  public function changeSliderStatus(Request $request)
  {
    $slider_id = $request->slider_id;

    $status_check   = DB::table('tbl_slider')->where('id', $slider_id)->first() ;
    $status         = $status_check->status;

    if ($status == 1) {
      $db_status = 2 ;
    }else{
      $db_status = 1 ;
    }

    $data           = array() ;
    $data['status'] = $db_status ;
    $query = DB::table('tbl_slider')->where('id', $slider_id)->update($data) ;
    if ($db_status == 1) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
    }

  }

  public function editSlider(Request $request)
  {
    $id = $request->id ;
    $value   = DB::table('tbl_slider')->where('id', $id)->first() ;

    return view('admin.homeSlider.editSlider')->with('value', $value) ;
  }

  public function updateSliderInfo(Request $request){
      $request->validate([
            'slider_image'              => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
    $slider_title = $request->slider_title;
    $slider_link = $request->slider_link;
    $slider_image =$request->hasFile('slider_image');
    $primary_id     = $request->primary_id ;
    
    $image = DB::table('tbl_slider')->where('id', $request->primary_id)->first() ;
    
   

    if ($slider_title == "" || $slider_image == "") {
      echo "invalid_input" ;
      exit() ;
    }

    $data_count = DB::table('tbl_slider')
    ->where('slider_title', $slider_title)
    ->whereNotIn('id', [$primary_id])
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }
    

    $data                   = array() ;
    $data['slider_title']  = $slider_title;
    $data['slider_link']  = $slider_link;
    $data['slider_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $slider_title)) ;
    // $data['slider_image']  = $slider_image;
    $data['created_at']     = $this->rcdate ;
    
    if ($request->hasFile('slider_image')) {
        $image_path = public_path('images/homeSlider/' .$image->slider_image);
        if ($image->slider_image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('slider_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/homeSlider/') . $new_image_name);
            $data['slider_image']  = $new_image_name;
        } 

    $query = DB::table('tbl_slider')->where('id', $primary_id)->update($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function sliderDelete(Request $request)
  {
    $id = $request->id ;
    $image = DB::table('tbl_slider')->where('id', $id)->first() ;
    
    $image_path = public_path('images/homeSlider/' .$image->slider_image);
        if ($image->slider_image && file_exists($image_path)) {
                    unlink($image_path);
                }
    $query = DB::table('tbl_slider')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }
  }
      // Admin Dashboard Account Setting
     public function adminAccountSettings(){
         $values         = DB::table('express')->where('id', Session::get('admin_id'))->first();
        $all_countries  = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get();
        return view('admin.adminAccountSettings')->with('values', $values)->with('all_countries', $all_countries);
    }
        // supplier account settings
    public function getAllAdminImages(Request $request)
    {
        $media_result = DB::table('tbl_media')->where('supplier_id',0)->orderBy('id', 'desc')->get();
        return view('categorys.paginations')->with('media_result', $media_result);
    }
    public function adminFileStore(Request $request)
    {
       $request->validate([
            'image' => 'mimes:jpeg,png,jpg,gif,svg',
        ]); 
        
        $image      = $request->file('file');
        $imageName  = $image->getClientOriginalName();
        $image->move(public_path('images'),$imageName);

        $data                   = array() ;
        $data['supplier_id']    = 0 ;
        $data['image']          = $imageName ;
        $data['status']         = 0 ;
        $data['created_at']     = $this->rcdate ;

        DB::table('tbl_media')->insert($data) ;
        
        // if ($request->hasFile('file')) {
        //     $image = $request->file('file');
        //     $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
        //     Image::make($image)->resize(450,450)->save(base_path('public/images/adminPic/') . $new_image_name);
        //     $data['image']  = $new_image_name;
        // } 
       // DB::table('express')->where('id', 1)->update($data) ;

        return response()->json(['success'=>$imageName]);
    }

   # UPDATE ADMIN GENERAL INFO
    public function updateAdminGeneralInfo(Request $request){
        
        $images     = $request->images ;
        $first_name = $request->first_name ;
        $last_name  = $request->last_name ;
        $email      = $request->email ;

        $user_info   = DB::table('express')->where('id', Session::get('admin_id'))->first();

        if (!$user_info) {
            $count = DB::table('express')
                ->whereNotIn('id', [Session::get('admin_id')])
                ->where('email', $email)
                ->count();

            if ($count > 0) {
                $notification = array(
                    'message'       => 'Sorry !! Invalid Email '.$email,
                    'alert-type'    => 'failed'
                );
                return Redirect::to('adminAccountSettings')->with($notification);
            }
        }

        $data               = array();
        // if ($images) {
        //     $data['image'] = $images ;
        // }
        $data['first_name'] = $first_name ;
        $data['last_name']  = $last_name ;
        $data['email']      = $email ;
        
        if ($request->hasFile('images')) {
            $image_path = public_path('images/adminPic/' .$user_info->image);
            if ($user_info->image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('images');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(450,450)->save(base_path('public/images/adminPic/') . $new_image_name);
            $data['image']  = $new_image_name;
        } 

        DB::table('express')->where('id', Session::get('admin_id'))->update($data) ;

        $notification = array(
            'message'       => 'General Info Updated Successfully',
            'alert-type'    => 'success'
        );

        return Redirect::to('adminAccountSettings')->with($notification);
    }

    public function adminPasswordChange(Request $request)
    {
        $old_password       = $request->old_password ;
        $password           = $request->password ;
        $confrim_password   = $request->confrim_password ;

        $salt      = 'a123A321';
        $old_pass = sha1($old_password.$salt);

        $count = DB::table('express')->where('password', $old_pass)->where('id', Session::get('admin_id'))->count();
        if ($count == 0) {
            echo "password_not_match" ;
            exit() ;
        }

        $data = array() ;
        $data['password'] =sha1($password.$salt) ;
        DB::table('express')->where('id', Session::get('admin_id'))->update($data) ;
        echo "success" ;
        exit() ;
    }
    public function updateAdminBasicInfo(Request $request){
        $dob        = date("Y-m-d", strtotime($request->dob)) ;
        $country_id = $request->country_id ;
        $mobile     = $request->mobile ;

        if ($mobile != "") {
            $count = DB::table('express')
                ->whereNotIn('id', [Session::get('admin_id')])
                ->where('mobile', $mobile)
                ->count();
            if ($count > 0) {
                echo "duplicate_found" ;
                exit() ;
            }
        }

        $data                   = array() ;
        $data['mobile']         = $mobile ;
        $data['dob']            = $dob ;
        $data['country']        = $country_id ;
        DB::table('express')->where('id', Session::get('admin_id'))->update($data) ;
        echo "success" ;
        exit();
    }


  //email send
  public function sendEmail(){
    $supplier   = DB::table('express')->where('type', 2)->orderBy('id', 'desc')->get();
    $buyer      = DB::table('express')->where('type', 3)->orderBy('id', 'desc')->get();
    $subscribers = DB::table('tbl_subscribes')->where('status', 1)->orderBy('id', 'desc')->get();
    return view('admin.emailSendToSeller')->with('supplier',$supplier)->with('buyer',$buyer)->with('subscribers',$subscribers);
  }

    public function sendEmailToSeller(Request $request)
    {
        $subject = $request->mail_subject;
        $mail_body = $request->mail_body;
        $mail_array = $request->mail_array;

        $smtpQuery = DB::table('tbl_smtp')->where('target','s')->first();
        $driver = $smtpQuery->mail_driver;
        $host = $smtpQuery->mail_host;
        $port = $smtpQuery->mail_port;
        $from_address = $smtpQuery->mail_username;
        $from_name = $smtpQuery->from_name;
        $mail_username = $smtpQuery->mail_username;
        $mail_password = $smtpQuery->mail_password;
        $encryption = $smtpQuery->mail_encryption;
        $reply_email = $smtpQuery->reply_email;
        $rowid = $smtpQuery->id;
        
        $transport = (new SmtpTransport($host, $port, $encryption))
            ->setUsername($mail_username)
            ->setPassword($mail_password);

        $mailer = new Swift_Mailer($transport);
        Mail::setSwiftMailer($mailer);

        foreach ($mail_array as $mail){
            $data['subject']         = $subject;
            $data['reply_email']     = $reply_email;
            $data['name']            = $from_name;
            $data['contact_message'] = $mail_body;
            $data['to_email']        = $mail;
            Mail::send(['html' => 'admin.send-mail-to-seller'], $data, function($message) use ($data){
                $message->to($data['to_email']);
                $message->subject($data['subject']);
                $message->from($data['reply_email'], $data['name']);
                $message->replyTo($data['reply_email']);
            });
        }
        return "success";
    }

    public function sendEmailToCustomer(Request $request)
    {
        $subject = $request->mail_subject;
        $mail_body = $request->mail_body;
        $mail_array = $request->mail_array;

        $smtpQuery = DB::table('tbl_smtp')->where('active',1)->where('target','s')->first();
        $driver = $smtpQuery->mail_driver;
        $host = $smtpQuery->mail_host;
        $port = $smtpQuery->mail_port;
        $from_address = $smtpQuery->mail_username;
        $from_name = $smtpQuery->from_name;
        $mail_username = $smtpQuery->mail_username;
        $mail_password = $smtpQuery->mail_password;
        $encryption = $smtpQuery->mail_encryption;
        $reply_email = $smtpQuery->reply_email;
        
        $transport = (new SmtpTransport($host, $port, $encryption))
            ->setUsername($mail_username)
            ->setPassword($mail_password);

        $mailer = new Swift_Mailer($transport);
        Mail::setSwiftMailer($mailer);

        foreach ($mail_array as $mail){
            $data['subject']         = $subject;
            $data['reply_email']     = $reply_email;
            $data['name']            = $from_name;
            $data['contact_message'] = $mail_body;
            $data['to_email']        = $mail;
            Mail::send(['html' => 'admin.send-mail-to-seller'], $data, function($message) use ($data){
                $message->to($data['to_email']);
                $message->subject($data['subject']);
                $message->from($data['reply_email'], $data['name']);
                $message->replyTo($data['reply_email']);
            });
        }
        return "success";
    }

    public function sendEmailToSubscriber(Request $request)
    {
        $subject = $request->mail_subject;
        $mail_body = $request->mail_body;
        $mail_array = $request->mail_array;

        $smtpQuery = DB::table('tbl_smtp')->where('target','s')->first();
        $driver = $smtpQuery->mail_driver;
        $host = $smtpQuery->mail_host;
        $port = $smtpQuery->mail_port;
        $from_address = $smtpQuery->mail_username;
        $from_name = $smtpQuery->from_name;
        $mail_username = $smtpQuery->mail_username;
        $mail_password = $smtpQuery->mail_password;
        $reply_email = $smtpQuery->reply_email;
        $encryption = $smtpQuery->mail_encryption;
        $rowid = $smtpQuery->id;
        
        $transport = (new SmtpTransport($host, $port, $encryption))
            ->setUsername($mail_username)
            ->setPassword($mail_password);

        $mailer = new Swift_Mailer($transport);
        Mail::setSwiftMailer($mailer);

        foreach ($mail_array as $mail){
            $data['subject']         = $subject;
            $data['reply_email']     = $reply_email;
            $data['name']            = $from_name;
            $data['contact_message'] = $mail_body;
            $data['to_email']        = $mail;
            Mail::send(['html' => 'admin.send-mail-to-seller'], $data, function($message) use ($data){
                $message->to($data['to_email']);
                $message->subject($data['subject']);
                $message->from($data['reply_email'], $data['name']);
                $message->replyTo($data['reply_email']);
            });
        }
        return "success";
    }

//  public function sendEmailToSeller(Request $request){
//
//    $result = DB::table('express')->where('type', 2)->first();
//
//    $to_name = $result->first_name." ".$result->last_name;
//
//    $to_email = $result->email;
//    $data = array('name'=>"Avail Trade", 'body' => "Congratulations: ");
//    Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
//      $message->to($to_email, $to_name)->subject('Congratulations Mail');
//      $message->from('avialtradebd@gmail.com',"avialtradebd");
//    });
//
//    echo "Email Send Successfully";
//
//  }

//  public function sendEmailToAllSeller(Request $request){
//
//    $result = DB::table('express')->where('type', 2)->get();
//
//
//    foreach ($result as $user){
//      $to_name  = $user->first_name." ".$user->last_name;
//      $to_email = $user->email;
//
//    $data = array('name'=>"Avail Trade It Solutions", 'body' => "Congratulations: ");
//    Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {
//
//      $message->to($to_email, $to_name)->subject('Congratulations Mail');
//      $message->from('avialtradebd@gmail.com',"avialtradebd");
//    });
//
//    }
//
//    echo "Email Send Successfully";
//    return Redirect::to('/sendEmail');
//
//  }

  // meta Tags
  public function metaTags()
  {
    $value = DB::table('tbl_meta_tags')->first() ;
    return view('admin.metaTags.metaTags')->with('value' ,$value);
  }

//update
  public function updateMetaTags(Request $request){
      $request->validate([
            'meta_title' => 'required',
            'meta_details' => 'required',
            'meta_keywords' => 'required',
            'meta_image' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
    $meta_title    = $request->meta_title ;
    $meta_details  = $request->meta_details ;
    $meta_keywords = $request->meta_keywords ;
    $meta_image    = $request->meta_image ;
    $primary_id    = $request->primary_id ;
    $image = DB::table('tbl_meta_tags')->where('id', $primary_id)->first() ;

    $data                   = array() ;
    $data['meta_title']     = $meta_title ;
    $data['meta_details']   = $meta_details ;
    $data['meta_keywords']  = $meta_keywords ;
    // $data['meta_image']     = $meta_image ;
    $data['created_at']     = $this->rcdate ;
    
    if ($request->hasFile('meta_image')) {
        $image_path = public_path('images/mettag/' .$image->meta_image);
        if ($image->meta_image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('meta_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(450,450)->save(base_path('public/images/mettag/') . $new_image_name);
            $data['meta_image']  = $new_image_name;
        } 

    $query = DB::table('tbl_meta_tags')->where('id', $primary_id)->update($data) ;
    if ($query) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
      exit() ;
    }
  }


    //admin bank
  public function bankList()
  {
    $result = DB::table('tbl_bank')->orderBy('bank_name', 'asc')->get();
    return view('admin.bank.bankList')->with('result', $result) ;
  }


  public function insertBankInfo(Request $request)
  {
      $request->validate([
            'bank_name' => 'required',
            'bank_branch_name' => 'required',
            'bank_branch_name' => 'required',
            'bank_account_number' => 'required',
            'bank_logo' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);
    $bank_name = $request->bank_name;
    $bank_account_name = $request->bank_account_name;
    $bank_branch_name = $request->bank_branch_name;
    $bank_account_number = $request->bank_account_number;
    $bank_logo = $request->bank_logo;

    $data_count = DB::table('tbl_bank')
    ->where('bank_name', $bank_name)
    ->where('bank_branch_name', $bank_branch_name)
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }

    if ($bank_name == "" || $bank_account_name == "" || $bank_branch_name == "" || $bank_account_number == "" || $bank_logo == "" ) {
      echo "invalid_input" ;
      exit() ;
    }

    $data                = array();
    $data['bank_name']  = $bank_name;
    $data['bank_account_name']  = $bank_account_name;
    $data['bank_branch_name']  = $bank_branch_name;
    $data['bank_account_number']  = $bank_account_number;
    $data['bank_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $bank_name)) ;
    $data['status']      = 1 ;
    $data['created_at']  = $this->rcdate ;
    if ($request->hasFile('bank_logo')) {
            $image = $request->file('bank_logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/bankLogo/') . $new_image_name);
            $data['bank_logo']  = $new_image_name;
        } 

    $query = DB::table('tbl_bank')->insert($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function getAllBank(Request $request)
  {
  $result = DB::table('tbl_bank')->orderBy('bank_name', 'asc')->get() ;

    return view('admin.bank.bankData')->with('result', $result) ;
  }

  public function changeBankStatus(Request $request)
  {
    $bank_id = $request->bank_id ;

    $status_check   = DB::table('tbl_bank')->where('id', $bank_id)->first() ;
    $status         = $status_check->status ;

    if ($status == 1) {
      $db_status = 2 ;
    }else{
      $db_status = 1 ;
    }

    $data           = array() ;
    $data['status'] = $db_status ;
    $query = DB::table('tbl_bank')->where('id', $bank_id)->update($data) ;
    if ($db_status == 1) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
    }

  }

  public function editBank(Request $request)
  {
    $id = $request->id ;
    $value   = DB::table('tbl_bank')->where('id', $id)->first() ;
    return view('admin.bank.editBank')->with('value', $value) ;
  }

  public function updateBankInfo(Request $request)
  {
      $request->validate([
            'bank_name' => 'required',
            'bank_branch_name' => 'required',
            'bank_branch_name' => 'required',
            'bank_account_number' => 'required',
            'bank_logo' => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    $bank_name  = $request->bank_name ;
    $bank_account_name  = $request->bank_account_name ;
    $bank_branch_name  = $request->bank_branch_name ;
    $bank_account_number  = $request->bank_account_number ;
    $bank_logo  = $request->bank_logo;
    $primary_id     = $request->primary_id ;
    
    $image = DB::table('tbl_bank')->where('id', $primary_id)->first() ;

    if ($bank_name == "" || $bank_account_name == "" || $bank_branch_name == "" || $bank_account_number == "") {
      echo "invalid_input" ;
      exit() ;
    }

    $data_count = DB::table('tbl_bank')
    ->where('bank_name', $bank_name)
    ->where('bank_branch_name', $bank_branch_name)
    ->whereNotIn('id', [$primary_id])
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }

    $data                   = array() ;
    $data['bank_name']  = $bank_name ;
    $data['bank_account_name']  = $bank_account_name ;
    $data['bank_branch_name']  = $bank_branch_name ;
    $data['bank_account_number']  = $bank_account_number ;
    $data['bank_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $bank_name)) ;
    
    $data['created_at']     = $this->rcdate ;
        if ($request->hasFile('bank_logo')) {
             $image_path = public_path('images/bankLogo/' .$image->bank_logo);
           if ($image->bank_logo && file_exists($image_path)) {
                    unlink($image_path);
                }
            
            $image = $request->file('bank_logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(500,500)->save(base_path('public/images/bankLogo/') . $new_image_name);
            $data['bank_logo']  = $new_image_name;
        } 
    

    $query = DB::table('tbl_bank')->where('id', $primary_id)->update($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function bankDelete(Request $request)
  {
    $id = $request->id ;
    $image = DB::table('tbl_bank')->where('id', $id)->first() ;
      $image_path = public_path('images/bankLogo/' .$image->bank_logo);
        if ($image->bank_logo && file_exists($image_path)) {
                    unlink($image_path);
        }
    $query = DB::table('tbl_bank')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }
  }

    # update site settings
  public function insertSiteSettingInfo(Request $request)
  {

    $this->validate($request, [
      'logo'      => 'mimes:jpeg,jpg,png',
    ]);

    $logo     = $request->logo ;
    $favicon  = $request->favicon ;

    $data_insert = array() ;

    if($logo){
        $imageName = 'logo-'.date('d-m-Y').'-'.rand(10000 , 99999).mt_rand(1000000000, 9999999999).'.'.$request->logo->extension();
        $request->logo->move(public_path('images'), $imageName);
        $data_insert['logo'] = $imageName;
     }

     if($favicon){
        $imageName2 = 'favicon-'.date('d-m-Y').'-'.rand(10000 , 99999).mt_rand(1000000000, 9999999999).'.'.$request->favicon->extension();
        $request->favicon->move(public_path('images'), $imageName2);
        $data_insert['favicon'] = $imageName2;
     }
     $data_insert['status'] = 2 ;
     $data_insert['created_at'] = date("Y-m-d H:i:s") ;

     DB::table('tbl_logo_settings')->insert($data_insert);

    echo "success" ;
  }

  # SITE SETTINGS
  public function siteSettings()
  {
    $settings = DB::table('tbl_logo_settings')->get();
    return view('admin.siteSettings')->with('settings', $settings) ;
  }

  # update site settings
  public function updateSiteSettings(Request $request)
  {
    $this->validate($request, [
      'logo'      => 'mimes:jpeg,jpg,png',
    ]);

    $logo         = $request->logo ;
    $favicon      = $request->favicon ;
    $primary_id   = $request->primary_id ;


    $data_insert = array() ;
    if($logo){
        $imageName = 'logo-'.date('d-m-Y').'-'.rand(10000 , 99999).mt_rand(1000000000, 9999999999).'.'.$request->logo->extension();
        $request->logo->move(public_path('images'), $imageName);
        $data_insert['logo'] = $imageName;
     }

     if($favicon){
        $imageName2 = 'favicon-'.date('d-m-Y').'-'.rand(10000 , 99999).mt_rand(1000000000, 9999999999).'.'.$request->favicon->extension();
        $request->favicon->move(public_path('images'), $imageName2);
        $data_insert['favicon'] = $imageName2;
     }


     DB::table('tbl_logo_settings')->where('id', $primary_id)->update($data_insert);

     echo "success" ;
     exit() ;
  }

  # change site setting status
  public function changeSiteSetttingstatus(Request $request)
  {
    $setting_id = $request->setting_id ;

    $settings_info = DB::table('tbl_logo_settings')->where('id', $setting_id)->first() ;
    $check_count = DB::table('tbl_logo_settings')->where('status', 1)->count() ;

    if($settings_info->status == 1 ){
      $status = 2 ;
    }else{
      $status = 1 ;
    }

    if ($check_count > 0 and $status == 1) {
      echo "exits" ;
      exit() ;
    }

    $data           = array();
    $data['status'] = $status ;
    DB::table('tbl_logo_settings')->where('id', $setting_id)->update($data) ;

    echo "success" ;
    exit() ;
  }

  # get admin setting info
  public function editSiteSettings(Request $request)
  {
    $setting = DB::table('tbl_logo_settings')->where('id', $request->id)->first() ;
    return view('admin.editSiteSettings')->with('settings', $setting) ;
  }

  # delete info
  public function deleteSettingLogo(Request $request)
  {
    $info = DB::table('tbl_logo_settings')->where('id', $request->id)->first() ;

    unlink('public/images/'.$info->logo) ;
    unlink('public/images/'.$info->favicon) ;

    DB::table('tbl_logo_settings')->where('id', $request->id)->delete() ;

    echo "success";
    exit() ;
  }

  # ADMIN SECTOIN
  public function changeCurrency(Request $request)
  {

        Session::put('availtrades','1');
        
        $country        = $request->country ;
        $currency_id    = $request->currency_id;
        $agent = new Agent ;

        if($currency_id != ""){
            Session::put('requestedCurrency', null);
            Session::put('requestedCurrency',$currency_id);
            Cookie::queue('cookie_currency', $currency_id, 525000);
            Cache::put('cookie_currency', $currency_id, 525000);
        }


        if($country != "")
        {
            Session::put('countrycode', null);
            Session::put('countrycode', $country);
            Cache::put('countryCode', $country, 525000);
        }


        $notification = array(
            'all_message'       => 'Currency Update Successfully',
            'alert-type'    => 'currency_success'
        );

        return back()->with($notification) ;
  }

  # all subscriber
  public function allsubscriber()
  {
      $result = DB::table('tbl_subscribes')->get() ;

      return view('admin.subscribers.allsubscriber')->with('result', $result);
  }

  public function changeSubscriberStatus(Request $request)
  {
        $subscriber = $request->subscriber ;

        $sub_info = DB::table('tbl_subscribes')->where('id', $subscriber)->first() ;
        if($sub_info->status == 1){
            $status = 2;
        }else{
            $status = 1;
        }

        $data = array();
        $data['status'] = $status;

        $query = DB::table('tbl_subscribes')->where('id', $subscriber)->update($data);
        if($query){
            echo "success";
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
  }
  
    public function changeSellerStatusToSuspend(Request $request){
      
        $seller_id = $request->seller_id ;
        $seller_info = DB::table('express')->where('id', $seller_id)->first() ;
        $mail = $seller_info->email ;
        
        $data = array() ;
        $data['status'] = 3 ;
        DB::table('express')->where('id', $seller_id)->update($data);
        
        $smtpQuery = DB::table('tbl_smtp')->where('target','s')->first();
        $driver = $smtpQuery->mail_driver;
        $host = $smtpQuery->mail_host;
        $port = $smtpQuery->mail_port;
        $from_address = $smtpQuery->mail_username;
        $from_name = $smtpQuery->from_name;
        $mail_username = $smtpQuery->mail_username;
        $mail_password = $smtpQuery->mail_password;
        $encryption = $smtpQuery->mail_encryption;
        $reply_email = $smtpQuery->reply_email;
        $rowid = $smtpQuery->id;
        
        $transport = (new SmtpTransport($host, $port, $encryption))
            ->setUsername($mail_username)
            ->setPassword($mail_password);

        $mailer = new Swift_Mailer($transport);
        Mail::setSwiftMailer($mailer);

        $data['subject']         = "Account Suspend";
        $data['reply_email']     = $reply_email;
        $data['name']            = $from_name;
        $data['contact_message'] = "Dear Customer your Avail Trade Supplier account is suspend . Plz Contack to Avail Trade Admin ";
        $data['to_email']        = $mail;
        Mail::send(['html' => 'admin.send-mail-to-seller'], $data, function($message) use ($data){
            $message->to($data['to_email']);
            $message->subject($data['subject']);
            $message->from($data['reply_email'], $data['name']);
            $message->replyTo($data['reply_email']);
        });
      
        echo "success";
        exit() ;

    }
    
    public function editSupplierInfoForAdmin(Request $request){
        
        $seller_id = $request->seller_id ;
        
        $value = DB::table('express')->where('id', $seller_id)->first() ;
        $all_countires = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get();
        
        return view('admin.editSupplierInfoForAdmin')->with('value', $value)->with('all_countires', $all_countires);
        
    }
    
    public function updateSupplierCountryInfo(Request $request){
        $primary_id = $request->primary_id ;
        $country_id = $request->country_id ;
        
        $supplier_info = DB::table('express')->where('id', $primary_id)->first() ;
        if($supplier_info->country == $country_id){
            return "failed";
            exit() ;
        }
        
        $data = array();
        $data['country'] = $country_id;
        $query = DB::table('express')->where('id', $primary_id)->update($data);
        if($query){
            return "success";
            exit() ;
        }else{
            return "not_update";
            exit() ;
        }
        
    }
    
    public function deleteBuyerInfo(Request $request)
    {
        $buyer_id = $request->buyer_id ;
        # DELETE CART 
        DB::table('cart')->where('customer_id', $buyer_id)->delete() ;

        # DELETE MESSAGES 
        DB::table('tbl_messages')->where('sender_id', $buyer_id)->delete();
        DB::table('tbl_messages')->where('receiver_id', $buyer_id)->delete();

        # QUTATION 
        $all_qu = DB::table('tbl_supplier_quotation')->where('customer_id', $buyer_id)->get() ;
        foreach($all_qu as $qutvalue){
          DB::table('tbl_quotation_reply')->where('message_id', $qutvalue->id)->delete() ;
        }

        DB::table('tbl_supplier_quotation')->where('customer_id', $buyer_id)->delete() ;

        DB::table('order')->where('customer_id', $buyer_id)->delete() ;
        DB::table('order_product')->where('customer_id', $buyer_id)->delete() ;

        DB::table('tbl_shipping_address')->where('express_id', $buyer_id)->delete() ;
      
        DB::table('express')->where('id', $buyer_id)->delete() ;

        return "success" ;
    }

}
