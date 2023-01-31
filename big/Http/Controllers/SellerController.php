<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use Image;
use DB;
use Session;
use Mail ;
use DateTime ;

class SellerController extends Controller{


    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->loged_id     = Session::get('buyer_id');
        $this->current_time = date("H:i:s");
    }

    public function sellerDashboard(){
      return view('seller.dashboard');
     }
     
    public function sellerAccountSetting(){
        $values         = DB::table('express')->where('id', Session::get('buyer_id'))->first();
        $all_countries  = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get() ;
        return view('buyer.buyerAccountSettings')->with('values', $values)->with('all_countries', $all_countries);
    }
    
    
    public function sellerOrderList(){

        $result = DB::table('order')
            ->where('customer_id', Session::get('seller_id'))
            ->orderBy('id', 'desc')
            ->get() ;

        return view('buyer.buyerOrderList')->with('result', $result);
    }
    
    
    
    public function sellerOrderDetails($invoice)
    {
        $result = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->leftJoin('tbl_product_color', 'order_product.color_id', '=', 'tbl_product_color.id')
            ->leftJoin('tbl_size', 'order_product.size_id', '=', 'tbl_size.id')
            ->join('express', 'order_product.customer_id', '=', 'express.id')
            ->select('order_product.*', 'tbl_size.size', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_product.product_name', 'tbl_product.products_image', 'express.first_name', 'express.last_name', 'express.email', 'express.mobile')
            ->where('order_product.customer_id', Session::get('seller_id'))
            ->where('order_product.invoice_number', $invoice)
            ->get() ;

        return view('buyer.buyerOrderDetails')->with('result', $result);
    }
    

    
    public function sellerShippingAddress(){

        $result  = DB::table('express')->where('express.id', Session::get('seller_id'))
            ->join('tbl_countries', 'tbl_countries.id', '=', 'express.country')
            ->select('express.*', 'tbl_countries.countryName')
            ->first();

        $value = DB::table('tbl_countries')->first() ;
        $all_countries  = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get() ;

        return view('buyer.buyerShippingAddress')->with('value', $value)->with('result', $result)->with('all_countries', $all_countries);
    } 

   //update
    public function sellerShippingAddressUpdate(Request $request){
        $first_name   = $request->first_name ;
        $last_name    = $request->last_name ;
        $address     = $request->address ;
        $mobile    = $request->mobile ;
        $zipPostalCode  = $request->zipPostalCode ;
        $country   = $request->country ;
        $city  = $request->city ;
        $primary_id = $request->primary_id ;

        $data               = array() ;
        $data['first_name']   = $first_name ;
        $data['last_name']    = $last_name ;
        $data['address']     = $address ;
        $data['mobile']    = $mobile ;
        $data['zipPostalCode']  = $zipPostalCode ;
        $data['country']   = $country ;
        $data['city']  = $city ;
        $data['created_at'] = $this->rcdate ;

        $query = DB::table('express')->where('id', $primary_id)->update($data) ;

        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }

    public function updateSellerGeneralInfo(Request $request){

        $first_name = $request->first_name ;
        $last_name  = $request->last_name ;

        $data = array() ;
        // if($image){
        //     $image_name        = Str::random(10).time();
        //     $ext               = strtolower($image->getClientOriginalExtension());
        //     $image_full_name   = $image_name.'.'.$ext;
        //     $upload_path       = "public/images/";
        //     $image_url         = $upload_path.$image_full_name;
        //     $success           = $image->move($upload_path,$image_full_name);
        //     $data['image']     = $image_full_name;
        // }

        $data['first_name'] = $first_name ;
        $data['last_name']  = $last_name ;
        $data['created_at'] = $this->rcdate ;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(550,450)->save(base_path('public/images/buyerPic/') . $new_image_name);
            $data['image']  = $new_image_name;
        } 

        $query = DB::table('express')->where('id', Session::get('buyer_id'))->update($data) ;

        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }


    public function SellerPasswordChange(Request $request)
    {
        $old_password       = $request->old_password ;
        $password           = $request->password ;
        $confrim_password   = $request->confrim_password ;

        $salt      = 'a123A321';
        $old_pass = sha1($old_password.$salt);

        $count = DB::table('express')->where('password', $old_pass)->where('id', Session::get('buyer_id'))->count();
        if ($count == 0) {
            echo "password_not_match" ;
            exit() ;
        }

        $data = array() ;
        $data['password'] =sha1($password.$salt) ;
        DB::table('express')->where('id', Session::get('buyer_id'))->update($data) ;

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
            ->whereNotIn('id', [Session::get('buyer_id')])
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
        DB::table('express')->where('id', Session::get('buyer_id'))->update($data) ;

        echo "success" ;
        exit() ;
    }
    
    # BUYER QUOTATION LIST 
    public function sellerQuotationlist()
    {   
        $data               = array() ;
        $data['status']     = 1 ;
        $data['updated_at'] = date("Y-m-d H:i:s") ;
        DB::table('tbl_quotation_reply')->where('receiver_id', Session::get('buyer_id'))->update($data);
    
        $result = DB::table('tbl_supplier_quotation')
            ->leftJoin('tbl_product', 'tbl_supplier_quotation.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_supplier_quotation.supplier_id', '=', 'express.id')
            ->select('tbl_supplier_quotation.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName', 'tbl_product.product_name', 'tbl_product.slug')
            ->where('tbl_supplier_quotation.customer_id', Session::get('buyer_id'))
            ->get() ;
            
        return view('buyer.buyerQuotationlist')->with('result', $result) ;
    }
    
    # GET SUPPLIER QUTATION DETAILS
    public function geSellertQuotationDetails(Request $request)
    {
        $quation_id = $request->quation_id;
        
        $qutation_value = DB::table('tbl_supplier_quotation')
            ->leftJoin('tbl_product', 'tbl_supplier_quotation.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_supplier_quotation.customer_id', '=', 'express.id')
            ->select('tbl_supplier_quotation.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName', 'tbl_product.product_name', 'tbl_product.slug')
            ->where('tbl_supplier_quotation.customer_id', Session::get('buyer_id'))
            ->where('tbl_supplier_quotation.id', $quation_id)
            ->first() ;
            
        $get_quotation_reply = DB::table('tbl_quotation_reply')
            ->where('message_id', $quation_id)
            ->orderBy('created_at', 'asc')
            ->get();
        
        return view('buyer.geBuyertQuotationDetails')->with('qutation_value', $qutation_value)->with('get_quotation_reply', $get_quotation_reply);
        
    }
    
        # SEND QUOTATION REPLY 
    public function sellerSendQuotationReply(Request $request)
    {
        $quation_id = $request->quation_id;
        $replyMessage = $request->replyMessage;
        
        $quotation_info = DB::table('tbl_supplier_quotation')
            ->where('id', $quation_id)
            ->first() ;
        
        $data = array() ;
        $data['message_id'] = $quation_id;
        $data['sender_id'] = Session::get('buyer_id');
        $data['receiver_id'] = $quotation_info->supplier_id;
        $data['reply_message'] = $replyMessage;
        $data['status'] = 0;
        
        DB::table('tbl_quotation_reply')->insert($data) ;
        
        $get_quotation_reply = DB::table('tbl_quotation_reply')
            ->where('message_id', $quation_id)
            ->orderBy('created_at', 'asc')
            ->get();
            
        
        return view('buyer.buyerQuotationReplyData')->with('get_quotation_reply', $get_quotation_reply);
    }
    
        # SAVE CUSTOMER ADDRESS 
    public function customerAddNewAddress(Request $request)
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

    public function changeExpressShippingStatus(Request $request)
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


    

}
