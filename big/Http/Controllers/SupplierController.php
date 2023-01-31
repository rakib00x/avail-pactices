<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Cache;
use Cookie;
use Image;
use DB;
use Session;
use Mail ;
use DateTime ;



class SupplierController extends Controller{

    public function __construct(){
        
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->loged_id     = Session::get('admin_id');
        $this->current_time = date("H:i:s");
        
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
        $countryCode = $county_info->countryCode;
       $getCount    = DB::table('tbl_currency_status')->where('code', $county_info->countryCode)->count();
        if($getCount == 0){
            $getCurrencyd = DB::table('tbl_currency_status')->where('default_status', 1)->first();
            $currency_id = $getCurrencyd->id;
            $countryCode = $getCurrencyd->code ;
        }else{
            $getCurrency = DB::table('tbl_currency_status')->where('code', $county_info->countryCode)->first();
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


    public function supplierDashboard(){
        $supplier_id = Session::get('supplier_id');
        $supplier_info = DB::table('express')->where('id', $supplier_id)->first() ;

        if($supplier_info->package_status == 0){
            return Redirect::to('package') ;
        }

        return view('supplier.supplierDashboard');
    }
    
    public function supplierProductsList(){
        
        return view('supplier.supplierProductsList');
    }

    public function getSupplierProductData(Request $request)
    {
        $supplier_id = Session::get('supplier_id');
        $result      = DB::table('tbl_product')->where('supplier_id',$supplier_id)->orderBy('id', 'desc')->get() ;

        return view('product.productDataList')->with('result',$result);
    }
    public function supplierProductAdd(){
        return view('supplier.supplierProductAdd');
    }
    public function supplierProductEdit(){
        return view('supplier.supplierProductEdit');
    }

    public function supplierOrdersList(){

        $result = DB::table('order')
            ->join('express', 'order.customer_id', '=', 'express.id')
            ->select('order.*', 'express.first_name', 'express.last_name')
            ->groupBy('order.invoice_number')
            ->where('order.supplier_id', Session::get('supplier_id'))
            ->get();

        return view('supplier.supplierOrdersList')->with('result', $result);
    }
    
    public function supplieOrderBuyList(){

        $result = DB::table('order')
            ->where('customer_id', Session::get('supplier_id'))
            ->orderBy('id', 'desc')
            ->get() ;

        return view('supplier.order.buyOrderlist')->with('result', $result);
    }
    
    public function supplieOrderBuyDetails($invoice)
    {
        $result = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->leftJoin('tbl_product_color', 'order_product.color_id', '=', 'tbl_product_color.id')
            ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
            ->leftJoin('tbl_size', 'order_product.size_id', '=', 'tbl_size.id')
            ->join('express', 'order_product.customer_id', '=', 'express.id')
            ->select('order_product.*', 'tbl_size.size', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_product.product_name', 'tbl_product.currency_id', 'tbl_product.slug', 'tbl_product.products_image', 'express.first_name', 'express.last_name', 'express.email', 'express.mobile' , 'tbl_currency_status.code','tbl_currency_status.rate as currency_rate')
            ->where('order_product.customer_id', Session::get('supplier_id'))
            ->where('order_product.invoice_number', $invoice)
            ->get() ;

        return view('supplier.order.buyOrderDetails')->with('result', $result);
    }
    
    // supplier account settings
    public function supplierAccountSettings(){
        $values         = DB::table('express')->where('id', Session::get('supplier_id'))->first();
        $all_countries  = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get();
        return view('supplier.supplierAccountSettings')->with('values', $values)->with('all_countries', $all_countries);
    }

    public function getAllSupplierImages(Request $request)
    {
        $media_result = DB::table('tbl_media')->where('supplier_id', Session::get('supplier_id'))->orderBy('id', 'desc')->get();
        return view('categorys.paginations')->with('media_result', $media_result);
    }

    public function supplierFileStore(Request $request)
    {
        $image      = $request->file('file');
        $imageName  = $image->getClientOriginalName();
        $image->move(public_path('images'),$imageName);

        $data                   = array() ;
        $data['supplier_id']    = Session::get('supplier_id');
        $data['image']          = $imageName ;
        $data['status']         = 0 ;
        $data['created_at']     = $this->rcdate ;

        DB::table('tbl_media')->insert($data) ;

        return response()->json(['success'=>$imageName]);
    }

    # UPDATE SUPPLIER GENERAL INFO
    public function updateSupplierGeneralInfo(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3048',
        ]);
        $images         = $request->image ;
        $first_name     = $request->first_name ;
        $last_name      = $request->last_name ;
        $email          = $request->email;
        $designation    = $request->designation;
        $address        = $request->address;
        $zipPostalCode  = $request->zipPostalCode;
        $stateName      = $request->stateName;
        $city           = $request->city;
        

        $user_info   = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        $social_link = $user_info->social_link ;

        if (!$social_link) {
            $count = DB::table('express')
                ->whereNotIn('id', [Session::get('supplier_id')])
                ->where('email', $email)
                ->count();

            if ($count > 0) {

                $notification = array(
                    'message'       => 'Sorry !! Invalid Email '.$email,
                    'alert-type'    => 'failed'
                );

                return Redirect::to('supplierAccountSettings')->with($notification);
            }
        }

        if ($user_info->email == $email) {
            $data                   = array();
            // if ($images) {
            //     $data['image']      = $images ;
            // }
            $data['first_name']     = $first_name ;
            $data['last_name']      = $last_name ;
            $data['email']          = $email ;
            $data['designation']    = $designation ;
            $data['address']        = $address ;
            $data['zipPostalCode']  = $zipPostalCode ;
            $data['stateName']      = $stateName ;
            $data['city']           = $city ;
            if ($request->hasFile('image')) {
                 $image_path = public_path('images/spplierPro/' .$user_info->image);
                if ($user_info->image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(450,450)->save(base_path('public/images/spplierPro/') . $new_image_name);
            $data['image']  = $new_image_name;
        } 

            DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;

            $notification = array(
                'message'       => 'General Info Updated Successfully.',
                'alert-type'    => 'success'
            );
            return Redirect::to('supplierAccountSettings')->with($notification);
        }else{
            $data               = array();
            // if ($images) {
            //     $data['image']      = $images ;
            // }
            $data['first_name']     = $first_name ;
            $data['last_name']      = $last_name ;
            $data['email']          = $email ;
            $data['designation']    = $designation ;
            $data['address']        = $address ;
            $data['zipPostalCode']  = $zipPostalCode ;
            $data['stateName']      = $stateName ;
            $data['city']           = $city ;
            $data['verify_status']      = 0 ;
            
            if ($request->hasFile('image')) {
                 $image_path = public_path('images/spplierPro/' .$user_info->image);
                if ($user_info->image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(450,450)->save(base_path('public/images/spplierPro/') . $new_image_name);
            $data['image']  = $new_image_name;
          }

            $email_code = encrypt($email);
            $site_url = url('/verify/'.$email_code) ;
            $to_name = $first_name." ".$last_name;
            $to_email = $email;
            DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;

            $data = array('name' =>"Avail Trade", 'body' => "Your Verification Url Is : ". $site_url);
                Mail::send('emails.mail', $data, function($message) use ($to_name, $to_email) {

                $message->to($to_email, $to_name)->subject('Verification Mail');
                $message->from('avialtradebd@gmail.com',"avialtradebd");
            });

            Session::put('email', null);
            Session::put('supplier_id', null);
            Session::put('type', null);
            Session::put('success', 'General Info Updated Successfully. Please Verify Your Email First');
            $notification = array(
                'message'       => 'General Info Updated Successfully. Please Verify Your Email First',
                'alert-type'    => 'info'
            );

            return Redirect::to('login')->with($notification);
        }

    }

    public function supplierPasswordChange(Request $request)
    {
        $old_password       = $request->old_password ;
        $password           = $request->password ;
        $confrim_password   = $request->confrim_password ;

        $salt      = 'a123A321';
        $old_pass = sha1($old_password.$salt);

        $count = DB::table('express')->where('password', $old_pass)->where('id', Session::get('supplier_id'))->count();
        if ($count == 0) {
            echo "password_not_match" ;
            exit() ;
        }

        $data = array() ;
        $data['password'] =sha1($password.$salt) ;
        DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;

        echo "success" ;
        exit() ;
    }

    public function updateSupplierBasicInfo(Request $request)
    {
        $storeName  = $request->storeName ;
        $mobile     = $request->mobile ;
        $weburl     = $request->weburl ;

        $dob         = date("Y-m-d", strtotime($request->dob)) ;

        $interval = date_diff(date_create(), date_create($dob));

        if ($interval->format("%Y") < 18) {
            echo "not_adult";
            exit() ;
        }

        if ($dob > $this->rcdate) {
            echo "invalid_dob";
            exit() ;
        }


        if ($mobile != "") {
            $count = DB::table('express')
                ->whereNotIn('id', [Session::get('supplier_id')])
                ->where('mobile', $mobile)
                ->count();
            if ($count > 0) {
                echo "duplicate_found" ;
                exit() ;
            }
        }

        $data                   = array() ;
        $data['mobile']         = $mobile ;
        $data['companyWebsite'] = $weburl ;
        $data['dob']            = $dob ;
        $data['storeName']      = $storeName ;
        DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;
        echo "success" ;
        exit();
    }
     // Supplier Social Media  .............................................................

    public function supplierSoicalMedia(){

        $supplier_id = Session::get('supplier_id');
        $social = DB::table('tbl_social_media')->where('supplier_id',$supplier_id)->first();
        $social_count = DB::table('tbl_social_media')->where('supplier_id', $supplier_id)->count() ;

        return view('supplier.supplierSoicalMedia')->with('social',$social)->with('social_count', $social_count);
  }


  public function supplierSoicalMediaUpdate(Request $request)
  {

    $primary_id                   = $request->primary_id;

    $data = array();
    $data['supplier_id']          = Session::get('supplier_id');
    $data['facebook']             = $request->facebook;
    $data['twitter']              = $request->twitter;
    $data['google']               = $request->google;
    $data['youtube']              = $request->youtube;
    $data['instagram']            = $request->instagram;
    $data['linkedin']             = $request->linkedin;
    $data['pinterest']            = $request->pinterest;

    $social_count = DB::table('tbl_social_media')->where('supplier_id', Session::get('supplier_id'))->count() ;
    if ($social_count > 0) {
        $query = DB::table('tbl_social_media')->where('id',$primary_id)->update($data);
    }else{
        $query = DB::table('tbl_social_media')->insert($data) ;
    }


   $notification = array(
        'message'       => 'Thanks !! Records Update Successfully Compeleted',
        'alert-type'    => 'success'
    );

    return Redirect::to('supplierSoicalMedia')->with($notification);
  }


  public function insertAddSupplierDocuments(Request $request)
  {
      
      
        $personal_licence   = $request->file('personal_licence') ;
        $business_licence   = $request->file('business_licence') ;
        $other_documents    = $request->file('other_documents') ;

        $data = array() ;

        if ($request->hasFile('personal_licence')) {
            $image = $request->file('personal_licence');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,600)->save(base_path('public/images/verification/') . $new_image_name);
            $data['temp_compny_license']  = $new_image_name;
            $data['b_verify_status']    = 1;
        }
      if ($request->hasFile('business_licence')) {
            $image = $request->file('business_licence');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(900,550)->save(base_path('public/images/verification/') . $new_image_name);
            $data['temp_legal_document']  = $new_image_name;
            $data['b_verify_status']    = 1;
        }

         if ($request->hasFile('other_documents')) {
            $image = $request->file('other_documents');
            $new_image = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,600)->save(base_path('public/images/verification/') . $new_image);
            $data['others_document']  = $new_image;
        }

        $data['profile_verify_status'] = 0 ;

        $query = DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;
        echo $query ;
    }


    public function updateSupplierCompanyInformation(Request $request)
    {
        $companyTelephone   = $request->companyTelephone;
        $companyName        = $request->companyName;
        $companyAddress     = $request->companyAddress;
        $companyDetails     = $request->companyDetails;
        $company_profile     = $request->company_profile;
        $googleMapLocation   = $request->googleMapLocation;

        $data                           = array() ;
        $data['companyTelephone']       = $companyTelephone ;
        $data['companyName']            = $companyName ;
        $data['companyAddress']         = $companyAddress ;
        $data['companyDetails']         = $companyDetails ;
        $data['company_profile']        = $company_profile ;
        $data['googleMapLocation']      = $googleMapLocation ;


        $query = DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;
        echo $query ;
    }

    public function changeAdminSupplierStatus(Request $request)
    {
        $supplier_info = DB::table('express')->where('id', $request->supplier_id)->first() ;
        $temp_legal_document = $supplier_info->temp_legal_document ;
        $temp_compny_license = $supplier_info->temp_compny_license ;

        $profile_verify_status = $request->profile_verify_status ;
        $data = array() ;
        $data['profile_verify_status']  = $profile_verify_status ;
        if ($profile_verify_status == 1) {
            if ($temp_compny_license != "") {
                $data['companyLicenseCopy']     = $temp_compny_license ;
                $data['temp_compny_license']    = "" ;
            }

            if ($temp_legal_document != "") {
                $data['legalDocument']          = $temp_legal_document ;
                $data['temp_legal_document']    = "" ;
            }
        }


        DB::table('express')->where('id', $request->supplier_id)->update($data) ;
        echo "success" ;
    }
    
    public function siam($supplier_id,$slug)
    {
        //echo "this is the supplier id: ".$supplier_id." ".$slug; 
        return view('frontEnd.store.siam')->with('supplier_id',$supplier_id);
    }
    
    # SUPPLIER INFO 
    public function supplierQuotationList()
    {

        $data               = array() ;
        $data['status']     = 1 ;
        $data['updated_at'] = date("Y-m-d H:i:s") ;
        DB::table('tbl_supplier_quotation')->where('supplier_id', Session::get('supplier_id'))->update($data);
        
        $data2               = array() ;
        $data2['status']     = 1 ;
        $data2['updated_at'] = date("Y-m-d H:i:s") ;
        DB::table('tbl_quotation_reply')->where('receiver_id', Session::get('supplier_id'))->update($data2);

        $result = DB::table('tbl_supplier_quotation')
            ->leftJoin('tbl_product', 'tbl_supplier_quotation.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_supplier_quotation.customer_id', '=', 'express.id')
            ->select('tbl_supplier_quotation.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName', 'tbl_product.slug', 'tbl_product.product_name')
            ->where('tbl_supplier_quotation.supplier_id', Session::get('supplier_id'))
            ->get() ;

        return view('supplier.supplierQuotationList')->with('result', $result) ;
        
    }
    
    # GET SUPPLIER QUTATION DETAILS
    public function getQuotationDetails(Request $request)
    {
        $quation_id = $request->quation_id;
        $data = array();
        $data['receiver_status'] = 1;
        $data['updated_at'] = date("Y-m-d H:i:s") ;
        
        DB::table('tbl_quotation_reply')->where('message_id', $quation_id)->where('receiver_id', Session::get('supplier_id'))->update($data) ;
        
        
        $qutation_value = DB::table('tbl_supplier_quotation')
            ->leftJoin('tbl_product', 'tbl_supplier_quotation.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_supplier_quotation.customer_id', '=', 'express.id')
            ->select('tbl_supplier_quotation.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName', 'tbl_product.product_name', 'tbl_product.slug')
            ->where('tbl_supplier_quotation.supplier_id', Session::get('supplier_id'))
            ->where('tbl_supplier_quotation.id', $quation_id)
            ->first() ;
            
        $get_quotation_reply = DB::table('tbl_quotation_reply')
            ->where('message_id', $quation_id)
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('supplier.getQuotationDetails')->with('qutation_value', $qutation_value)->with('get_quotation_reply', $get_quotation_reply);
        
    }
    
    # SEND QUOTATION REPLY 
    public function supplierSendQuotationReply(Request $request)
    {
        $quation_id = $request->quation_id;
        $replyMessage = $request->replyMessage;
        
        $quotation_info = DB::table('tbl_supplier_quotation')
            ->where('id', $quation_id)
            ->first() ;
        
        $data = array() ;
        $data['message_id'] = $quation_id;
        $data['sender_id'] = Session::get('supplier_id');
        $data['receiver_id'] = $quotation_info->customer_id;
        $data['reply_message'] = $replyMessage;
        $data['status'] = 1;
        
        DB::table('tbl_quotation_reply')->insert($data) ;
        
        $get_quotation_reply = DB::table('tbl_quotation_reply')
            ->where('message_id', $quation_id)
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('supplier.getQuotationReplyData')->with('get_quotation_reply', $get_quotation_reply);
    }
    
    
    # GET SUPPLIER MESSAGE 
    
    # BUYER QUOTATION LIST 
    public function supplierQuotationInbox()
    {
        $data               = array() ;
        $data['status']     = 1 ;
        $data['updated_at'] = date("Y-m-d H:i:s") ;
        DB::table('tbl_quotation_reply')->where('receiver_id', Session::get('supplier_id'))->update($data);
    
        $result = DB::table('tbl_supplier_quotation')
            ->leftJoin('tbl_product', 'tbl_supplier_quotation.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_supplier_quotation.supplier_id', '=', 'express.id')
            ->select('tbl_supplier_quotation.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName', 'tbl_product.product_name', 'tbl_product.slug')
            ->where('tbl_supplier_quotation.customer_id', Session::get('supplier_id'))
            ->get() ;
            
        return view('supplier.supplierQuotationInbox')->with('result', $result) ;
    }
    
    # GET SUPPLIER QUTATION DETAILS
    public function getSupplerInobxQuotationDetails(Request $request)
    {
        $quation_id = $request->quation_id;
        
        $data = array();
        $data['receiver_status'] = 1;
        $data['updated_at'] = date("Y-m-d H:i:s") ;
        
        DB::table('tbl_quotation_reply')->where('message_id', $quation_id)->where('receiver_id', Session::get('supplier_id'))->update($data) ;
        
        $qutation_value = DB::table('tbl_supplier_quotation')
            ->leftJoin('tbl_product', 'tbl_supplier_quotation.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_supplier_quotation.customer_id', '=', 'express.id')
            ->select('tbl_supplier_quotation.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName', 'tbl_product.product_name', 'tbl_product.slug')
            ->where('tbl_supplier_quotation.customer_id', Session::get('supplier_id'))
            ->where('tbl_supplier_quotation.id', $quation_id)
            ->first() ;
            
        $get_quotation_reply = DB::table('tbl_quotation_reply')
            ->where('message_id', $quation_id)
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('supplier.getSupplerInobxQuotationDetails')->with('qutation_value', $qutation_value)->with('get_quotation_reply', $get_quotation_reply);
        
    }
    
    # SEND QUOTATION REPLY 
    public function supplierInboxChatMessagesSend(Request $request)
    {
        $quation_id     = $request->quation_id;
        $replyMessage   = $request->replyMessage;
        
        $quotation_info = DB::table('tbl_supplier_quotation')
            ->where('id', $quation_id)
            ->first() ;
        
        $data = array() ;
        $data['message_id'] = $quation_id;
        $data['sender_id'] = Session::get('supplier_id');
        $data['receiver_id'] = $quotation_info->supplier_id;
        $data['reply_message'] = $replyMessage;
        $data['status'] = 0;
        
        DB::table('tbl_quotation_reply')->insert($data) ;
        
        $get_quotation_reply = DB::table('tbl_quotation_reply')
            ->where('message_id', $quation_id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        
        return view('supplier.supplierInboxQuotationReplyData')->with('get_quotation_reply', $get_quotation_reply);
    }
    
    public function getunreadquotationmessage(Request $request)
    {
        $quation_id = $request->receiver_id;

        
        $get_quotation_reply = DB::table('tbl_quotation_reply')
            ->where('message_id', $quation_id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        
        return view('supplier.supplierInboxQuotationReplyData')->with('get_quotation_reply', $get_quotation_reply);
    }
    
    public function getunreadsupplierinboxquotationmessage(Request $request)
    {
        $quation_id = $request->receiver_id;

        $data               = array() ;
        $data['status']     = 1 ;
        $data['updated_at'] = date("Y-m-d H:i:s") ;
        DB::table('tbl_quotation_reply')->where('receiver_id', Session::get('supplier_id'))->update($data);
        
        $get_quotation_reply = DB::table('tbl_quotation_reply')
            ->where('message_id', $quation_id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        
        return view('supplier.supplierInboxQuotationReplyData')->with('get_quotation_reply', $get_quotation_reply);
    }
    
    public function getunreadsupplierinboxquotationmessagecount(Request $request)
    {
        $quation_id = $request->receiver_id;

        
        $get_quotation_reply = DB::table('tbl_quotation_reply')
            ->where('message_id', $quation_id)
            ->orderBy('created_at', 'asc')
            ->where('status', 0)
            ->count();
        if($get_quotation_reply > 0){
            echo "load" ;
            exit() ;
        }else{
            echo "not_load";
            exit() ;
        } 
  
    }
    
    # PACKAGE SECTION 
    public function adminpackagependingsellers()
    {
        $result = DB::table('express')
            ->join('tbl_package', 'express.package_id', '=', 'tbl_package.id')
            ->select('express.*', 'tbl_package.package_name', 'tbl_package.package_price')
            ->where('express.package_id', '>', 0)
            ->where('express.package_status', 0)
            ->get() ;
            
        return view('admin.package.adminpackagependingsellers')->with('result', $result) ;
    }
    
    # CHANGE SUPPLIER PACKAGE STATUS 
    public function changesupplierpackagestatus($suplier_id, $type)
    {
        if($type == 1)
        {
            $data = array();
            $data['package_status'] = 1;

            DB::table('express')->where('id', $suplier_id)->update($data) ;

            $package_info = DB::table('tbl_supplier_package_history')->where('supplier_id', $suplier_id)->first() ;
            
            
            $pckage_duration = intVal($package_info->package_duration);
            $endddate =  date('Y-m-d', strtotime("+$pckage_duration months"));
            $package_expire_date = date('Y-m-d', strtotime('-1 day', strtotime($endddate)));
            
            $package_data               = array();
            $package_data['status']     = 1;
            $package_data['start_date'] = date("Y-m-d");
            $package_data['end_date']   = $package_expire_date;
            
            DB::table('tbl_supplier_package_history')->where('supplier_id', $suplier_id)->where('id', $package_info->id)->update($package_data) ;
            
            $payment_data               = array() ;
            $payment_data['status']     = 1 ;
            $payment_data['upated_at']  = date("Y-m-d H:i:s") ;
            
            DB::table('tbl_supplier_pacakge_payment_history')->where('supplier_id', $suplier_id)->where('package_main_id', $package_info->id)->update($payment_data);
            
            
            $notification = array(
                'message'       => 'Supplier Status Active Successfully',
                'alert-type'    => 'success'
            );
        }else{
            $data = array();
            $data['package_id']     = 0;
            $data['package_status'] = 0;
            
            DB::table('express')->where('id', $suplier_id)->update($data) ;
            DB::table('tbl_supplier_package_history')->where('supplier_id', $suplier_id)->delete() ;
            
            DB::table('tbl_supplier_pacakge_payment_history')->where('supplier_id', $suplier_id)->delete() ;
            
            $notification = array(
                'message'       => 'Supplier Status Reject Successfully',
                'alert-type'    => 'failed'
            );

        }
        
        return back()->with($notification);
    }
    
    
    # get package details 
    public function showpackagedetails(Request $request)
    {
        $customer_id = $request->customer_id;
        
        $supplier_info = DB::table('express')
            ->join('tbl_package', 'express.package_id', '=', 'tbl_package.id')
            ->select('express.*', 'tbl_package.package_name')
            ->where('express.id', $customer_id)
            ->first() ;
            
        $pckage_info = DB::table('tbl_supplier_package_history')
            ->where('supplier_id', $supplier_info->id)
            ->where('package_id',$supplier_info->package_id)
            ->first() ;
        
        $price_history = DB::table('tbl_supplier_pacakge_payment_history')
            ->where('tbl_supplier_pacakge_payment_history.package_main_id', $pckage_info->id)
            ->where('tbl_supplier_pacakge_payment_history.supplier_id', $supplier_info->id)
            ->where('tbl_supplier_pacakge_payment_history.package_id', $supplier_info->package_id)
            ->first() ;
            
        
            
            
        return view('admin.package.showpackagedetails')->with('supplier_info', $supplier_info)->with('pckage_info', $pckage_info)->with('price_history', $price_history);
    }
    
    public function supplierProductsDeleteAll(Request $request)
    {

        $product_id = $request->product_id ;
        $query= DB::table("products")->whereIn('id',explode(",",$product_id))->delete();
        if ($query) {
            echo "success";
            exit() ;
        }else{
            echo "failed";
            exit() ;
        }
    }
    
    public function deleteSupplierAllInfo(Request $request)
    {
        $id = $request->supplier_id ;

        DB::table('tbl_supplier_primary_category')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_supplier_secondary_category')->where('supplier_id', $id)->delete() ; 

        $all_media = DB::table('tbl_media')->where('supplier_id', $id)->get() ; 
        foreach($all_media as $media_value){
            $imge_link = "public/images/".$media_value->image ;
            if($media_value->image){
                if(file_exists($imge_link)){
                    unlink($imge_link) ;
                }
            }
            DB::table('tbl_media')->where('id', $media_value->id)->delete();
        }

        $all_send_quote = DB::table('tbl_supplier_quotation')->where('customer_id', $id)->get() ;
        foreach($all_send_quote as $sendquote){
            DB::table('tbl_quotation_reply')->where('message_id', $sendquote->id)->delete() ;
        }

        $all_receive_quote = DB::table('tbl_supplier_quotation')->where('supplier_id', $id)->get() ;
        foreach($all_receive_quote as $receivequote){
            DB::table('tbl_quotation_reply')->where('message_id', $receivequote->id)->delete() ;
        }

        DB::table('tbl_reviews')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_reviews')->where('buyer_id', $id)->delete() ; 

        DB::table('tbl_supplier_header_banner')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_supplier_header_settings')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_supplier_pacakge_payment_history')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_supplier_package_history')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_social_media')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_supplier_terms_conditions')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_support_ticket')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_menu')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_sub_menu')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_sub_sub_menu')->where('supplier_id', $id)->delete() ; 

        DB::table('tbl_size')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_product_price')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_product_color')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_product_size')->where('supplier_id', $id)->delete() ; 
        DB::table('tbl_product')->where('supplier_id', $id)->delete() ; 
        DB::table('order_product')->where('customer_id', $id)->delete() ; 
        DB::table('order_product')->where('supplier_id', $id)->delete() ; 
        DB::table('order')->where('supplier_id', $id)->delete() ; 
        DB::table('order')->where('customer_id', $id)->delete() ; 

        DB::table('tbl_shipping_address')->where('express_id', $id)->delete() ; 
        DB::table('tbl_slider')->where('supplier_id', $id)->delete() ; 

        DB::table('tbl_brand')->where('supplier_id', $id)->delete() ;
        DB::table('tbl_color')->where('supplier_id', $id)->delete() ;

        DB::table('tbl_messages')->where('sender_id', $id)->delete() ;
        DB::table('tbl_messages')->where('receiver_id', $id)->delete() ;

        DB::table('express')->where('id', $id)->delete() ;

        return "success" ;
  }


    # SELLER SECTION START HERE 
    public function sellerDashboard()
    {
         $total_product = DB::table('tbl_product')
                        ->where('supplier_id', Session::get('supplier_id'))
                        ->count() ;
        $total_orders = DB::table('order')->where('supplier_id', Session::get('supplier_id'))->count() ;
        
        return view('seller.dashboard',compact('total_product','total_orders')) ;
    }

    public function selleracountsettings()
    {
        $supplier_id = Session::get('supplier_id');

        $values         = DB::table('express')->where('id', $supplier_id)->first();
        $all_countries  = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get() ;

        return view('seller.selleracountsettings')->with('values', $values)->with('all_countries', $all_countries);
    }

    public function updateSellerGeneralInfo(Request $request)
    {
        $first_name = $request->first_name ;
        $last_name  = $request->last_name ;
        $image      = $request->image ;

        $data = array() ;
        $data['first_name'] = $first_name ;
        $data['last_name']  = $last_name ;
        $data['created_at'] = $this->rcdate ;
        
        if ($image) {
            $image          = $request->file('image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('images/spplierPro'), $new_image_name);
            $image_info = "public/images/spplierPro/".$new_image_name;
            Image::make($image_info)->resize(550,450)->save();
            $data['image']  = $new_image_name;
        } 

        $query = DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;

        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }

    public function sellerPasswordChange(Request $request)
    {
        $old_password       = $request->old_password ;
        $password           = $request->password ;
        $confrim_password   = $request->confrim_password ;

        $salt      = 'a123A321';
        $old_pass = sha1($old_password.$salt);

        $count = DB::table('express')->where('password', $old_pass)->where('id', Session::get('supplier_id'))->count();
        if ($count == 0) {
            echo "password_not_match" ;
            exit() ;
        }

        $data = array() ;
        $data['password'] =sha1($password.$salt) ;
        DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;

        echo "success" ;
        exit() ;
    }

    public function updateSellerBasicInfo(Request $request)
    {
        $dob        = date("Y-m-d", strtotime($request->dob)) ;
        $adult_check = date('Y-m-d') ;

        $date1 = new DateTime($dob);
        $date2 = new DateTime($adult_check);
        $diff  = $date1->diff($date2);

        if ($diff->y < 18) {
            echo "not_adult";
            exit() ;
        }

        $country_id = $request->country_id ;
        $mobile     = $request->mobile ;
        $weburl     = $request->weburl ;

        if ($mobile != "") {
            $count = DB::table('express')
            ->whereNotIn('id', [Session::get('supplier_id')])
            ->where('mobile', $mobile)
            ->count();
            if ($count > 0) {
                echo "duplicate_found" ;
                exit() ;
            }

        }
        
        $data                   = array() ;
        $data['mobile']         = $mobile ;
        $data['companyWebsite'] = $weburl ;
        $data['dob']            = $dob ;
        $data['country']        = $country_id ;
        DB::table('express')->where('id', Session::get('supplier_id'))->update($data) ;

        echo "success" ;
        exit() ;
    }
        

    public function sellerOrdersList(){

        $result = DB::table('order')
            ->join('express', 'order.customer_id', '=', 'express.id')
            ->select('order.*', 'express.first_name', 'express.last_name')
            ->groupBy('order.invoice_number')
            ->where('order.supplier_id', Session::get('supplier_id'))
            ->get();

        return view('seller.order.sellerOrdersList')->with('result', $result);
    }

    public function sellerOrderBuyList(){

        $result = DB::table('order')
            ->where('customer_id', Session::get('supplier_id'))
            ->orderBy('id', 'desc')
            ->get() ;

        return view('seller.order.sellerOrderBuyList')->with('result', $result);
    }

    public function sellerOrderBuyDetails($invoice)
    {
        $result = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->leftJoin('tbl_product_color', 'order_product.color_id', '=', 'tbl_product_color.id')
            ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
            ->leftJoin('tbl_size', 'order_product.size_id', '=', 'tbl_size.id')
            ->join('express', 'order_product.customer_id', '=', 'express.id')
            ->select('order_product.*', 'tbl_size.size', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_product.product_name', 'tbl_product.currency_id', 'tbl_product.slug', 'tbl_product.products_image', 'express.first_name', 'express.last_name', 'express.email', 'express.mobile' , 'tbl_currency_status.code','tbl_currency_status.rate as currency_rate')
            ->where('order_product.customer_id', Session::get('supplier_id'))
            ->where('order_product.invoice_number', $invoice)
            ->get() ;

        return view('seller.order.sellerOrderBuyDetails')->with('result', $result);
    }

    public function sellerQuotationList()
    {
        $data               = array() ;
        $data['status']     = 1 ;
        $data['updated_at'] = date("Y-m-d H:i:s") ;
        DB::table('tbl_supplier_quotation')->where('supplier_id', Session::get('supplier_id'))->update($data);
        
        $data2               = array() ;
        $data2['status']     = 1 ;
        $data2['updated_at'] = date("Y-m-d H:i:s") ;
        DB::table('tbl_quotation_reply')->where('receiver_id', Session::get('supplier_id'))->update($data2);

        $result = DB::table('tbl_supplier_quotation')
            ->leftJoin('tbl_product', 'tbl_supplier_quotation.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_supplier_quotation.customer_id', '=', 'express.id')
            ->select('tbl_supplier_quotation.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName', 'tbl_product.slug', 'tbl_product.product_name')
            ->where('tbl_supplier_quotation.supplier_id', Session::get('supplier_id'))
            ->get() ;

        return view('seller.sellerQuotationList')->with('result', $result) ;
    }

    public function sellerQuotationInbox()
    {
        $data               = array() ;
        $data['status']     = 1 ;
        $data['updated_at'] = date("Y-m-d H:i:s") ;
        DB::table('tbl_quotation_reply')->where('receiver_id', Session::get('supplier_id'))->update($data);
    
        $result = DB::table('tbl_supplier_quotation')
            ->leftJoin('tbl_product', 'tbl_supplier_quotation.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_supplier_quotation.supplier_id', '=', 'express.id')
            ->select('tbl_supplier_quotation.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName', 'tbl_product.product_name', 'tbl_product.slug')
            ->where('tbl_supplier_quotation.customer_id', Session::get('supplier_id'))
            ->get() ;
            
        return view('seller.sellerQuotationInbox')->with('result', $result) ;
    }
    
}
