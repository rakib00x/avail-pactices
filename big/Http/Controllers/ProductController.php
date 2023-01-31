<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Cache;

use DB;
use Session;
use Str;
use Input;
use Hash;
use Mail;
use Url;


class ProductController extends Controller
{
    private $rcdate;
    private $logged_id;
    private $current_time;

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

        $clientIP_s = $ip;

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


       $county_info = DB::table('tbl_countries')->where('stuas', 1)->first();
        $countryCode = $county_info->countryCode;
        

        $getCount    = DB::table('tbl_currency_status')->where('code', $county_info->countryCode)->count();

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

    public function productInformation()
    {
        $all_web_category = DB::table('tbl_tartiarycategory')
            ->leftJoin('tbl_primarycategory', 'tbl_tartiarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->leftJoin('tbl_secondarycategory', 'tbl_tartiarycategory.secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->select('tbl_tartiarycategory.*', 'tbl_primarycategory.category_name', 'tbl_secondarycategory.secondary_category_name')
            ->where('tbl_tartiarycategory.status', 1)
            ->get() ;

        $all_main_category = DB::table('tbl_supplier_primary_category')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_supplier_tags = DB::table('tbl_tags')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_product_brand = DB::table('tbl_brand')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_unit = DB::table('tbl_unit_price')
            ->where('status', 1)
            ->get() ;

        $all_shipping       = DB::table('tbl_shipping')->where('status', 1)->get() ;
        $all_payment_method = DB::table('tbl_payment_method')->where('status', 1)->get() ;

        $supplier_verify_count = DB::table('express')->where('profile_verify_status', 1)->where('id', Session::get('supplier_id'))->count();

        if ($supplier_verify_count == 0) {
            Session::put('failed', 'Sorry Your Account Not Verified Please Verify First. <a href="http://availtrade.com/supplierAccountSettings" style="color:blue;font-weight:bold">Verify Link</a>') ;
        }

    	$agent          = new Agent;
        $desktopResult  = $agent->isDesktop();
        if($desktopResult){
            return view('product.productInformation')->with('all_main_category', $all_main_category)->with('all_supplier_tags', $all_supplier_tags)->with('all_product_brand', $all_product_brand)->with('all_unit', $all_unit)->with('all_web_category', $all_web_category)->with('all_shipping', $all_shipping)->with('all_payment_method', $all_payment_method) ;
        }else{
            return view('product.mobileProductUpload')->with('all_main_category', $all_main_category)->with('all_supplier_tags', $all_supplier_tags)->with('all_product_brand', $all_product_brand)->with('all_unit', $all_unit)->with('all_web_category', $all_web_category)->with('all_shipping', $all_shipping)->with('all_payment_method', $all_payment_method) ;
        }
    	
    }

    public function getSupplierSecondaryCategoryP(Request $request)
    {
        $category_id = $request->main_category_id ;

        $all_secondary_category = DB::table('tbl_supplier_secondary_category')
                    ->where('supplier_id', Session::get('supplier_id'))
                    ->where('primary_category_id', $category_id)
                    ->where('status', 1)
                    ->get() ;

        echo "<option value=''>Select Secondary Category</option>";
        foreach ($all_secondary_category as $svalue) {
            echo '<option value="'. $svalue->id.'">'.$svalue->secondary_category_name.'</option>' ;
        }
    }

    public function insertProductInfo(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        
        $product_web_category       = trim($request->product_web_category) ;
        $product_name               = trim($request->product_name) ;
        $main_category_id           = trim($request->main_category_id) ;
        $secondary_category_id      = trim($request->secondary_category_id) ;
        $tertiary_category_id       = trim($request->tertiary_category_id) ;
        $brand_id                   = trim($request->brand_id) ;
        $unit                       = trim($request->unit) ;
        $tags                       = $request->producttags ;
        $product_image              = json_decode($request->productFinalImages) ;
        $video_link_type            = $request->video_link_type ;
        $video_link                 = $request->video_link ;
        $meta_title                 = $request->meta_title ;
        $meta_description           = $request->meta_description ;
        $product_description        = $request->product_description ;
        $shipping_status            = $request->shipping_status ;
        $shipping_method            = $request->shipping_method ;
        $payment_method_id          = $request->payment_method_id ;
        $meta_image                 = $request->meta_image ;
        $all_size_id                = $request->all_size_id ;
        $all_color_id               = $request->all_color_id ;
        $all_color_image            = $request->all_color_image ;
        $image__id                  = $request->image__id ;
        $custom_price_value         = $request->custom_price_value ;
        $image_per_qty_price        = $request->image_per_qty_price ;
        $custom_price_image         = $request->custom_price_image ;

        $currency_id        = $request->price_currency ;
        $unit_price         = $request->unit_price ;
        $discount           = $request->discount ;
        $discount_status    = $request->discount_status ;
        $package_template   = $request->package_template ;
        $package_price_image = $request->package_price_image ;
        $quantity_start     = $request->quantity_start ;
        $quantity_end       = $request->quantity_end ;
        $price              = $request->price ;
        $offer_start_date   = $request->offer_start_date ;
        $offer_end_date     = $request->offer_end_date ;
        $qty                = $request->qty ;
        $cond               = $request->cond ;
        
        # PACKAGE UPDATE CHECK 
        $package_check = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        if($package_check->package_id == 0){
            echo "package_not_active";
            exit() ;
        }
        
        $package_info               = DB::table('tbl_package')->where('id',$package_check->package_id)->first() ;
        $product_upload_quantity    = $package_info->product_limit;
        
        $total_product_count        = DB::table('tbl_product')->where('supplier_id', Session::get('supplier_id'))->count() ;
        
        if($product_upload_quantity == $total_product_count){
            echo "upload_limit";
            exit() ;
        }
        
        

        $check_product_name = DB::table('tbl_product')
            ->where('product_name', $product_name)
            ->where('supplier_id', Session::get('supplier_id'))
            ->count() ;

        if ($check_product_name > 0) {
            echo "duplicate_product" ;
            exit();
        }

        $check_tertiary_category = DB::table('tbl_supplier_secondary_category')
                    ->where('supplier_id', Session::get('supplier_id'))
                    ->where('primary_category_id', $main_category_id)
                    ->where('status', 1)
                    ->count();

        if ($check_tertiary_category > 0 && $secondary_category_id == "") {
            echo "select_tertiary_category" ;
            exit();
        }


        $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        $verify_status = $supplier_info->profile_verify_status ;

        if ($verify_status == 0) {
            echo "not_verify" ;
            exit();
        }



       
        if (count($product_image) != 0 ) {
            $images = implode("#", $product_image);
        }else{
            $images = "" ;
        }

        $web_category_info      = DB::table('tbl_tartiarycategory')->where('id', $product_web_category)->first() ;
        if ($shipping_method != "") {
            $all_shipping_method    = implode(",", $shipping_method) ;
        }else{
            $all_shipping_method    = "" ;
        }

        if ($payment_method_id != "") {
            $all_payment_method     = implode(",", $payment_method_id) ;
        }else{
            $all_payment_method     = "";
        }
        
        
        if ($package_template == 2) {
            # SINGLE PRICE SECTION

            if($unit_price != "" || $discount != "" || $package_template != ""){
                
            }else{
                echo "input_price_first" ;
                exit();
            }
        }elseif ($package_template == 1) {

            # PACKAGE PRICE SECTION

            if ($package_price_image != null || $quantity_start != null || $quantity_end != null || $price != null) {

            }else{
                echo "input_price_first" ;
                exit();
            }
        }elseif($package_template == 4){

            # custom price section 

            if (count($custom_price_image) > 0) {
            
            }else{
                echo "input_price_first" ;
                exit();
            }
            


        }
        
        
        $data                               = array() ;
        $data['supplier_id']                = Session::get('supplier_id') ;
        $data['w_category_id']              = $web_category_info->primary_category_id ;
        $data['w_secondary_category_id']    = $web_category_info->secondary_category_id ;
        $data['w_tertiary_categroy_id']     = $product_web_category ;
        $data['product_name']               = $product_name ;
        if ($main_category_id != "") {
            $data['main_category_id']           = $main_category_id ;
        }
        if ($secondary_category_id != "") {
            $data['secondary_category_id']      = $secondary_category_id ;
        }
        if ($tertiary_category_id != "") {
            $data['tertiary_category_id']       = $tertiary_category_id ;
        }
        if ($brand_id != "") {
            $data['brand_id']           = $brand_id ;
        }
        $data['unit']                       = $unit ;
        $data['product_tags']               = $tags ;
        $data['products_image']             = $images ;
        $data['video_link']                 = $video_link ;
        if ($video_link_type != "") {
            $data['link_type']              = $video_link_type ;
        }
        $data['meta_title']                 = $meta_title ;
        $data['meta_description']           = $meta_description ;
        $data['product_description']        = $product_description ;
        if ($shipping_status != "") {
            $data['shipping_status']        = $shipping_status ;
        }
        $data['shipping_method']            = $all_shipping_method ;
        $data['payment_method']             = $all_payment_method ;
        $data['meta_image']                 = $meta_image ;
        $data['status']                     = 1 ;
        $data['price_type']                 = $package_template ;
        $data['qty']                        = $qty ;
        $data['cond']                       = $cond ;
        $data['currency_id']                = $currency_id ;
        $data['slug']                       = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', 
            $product_name));
        $data['created_at']     = date('Y-m-d H:i:s') ;

        $query = DB::table('tbl_product')->insert($data) ;

        if ($query) {
            
            $product_last_row = DB::table('tbl_product')->orderBy('id', 'desc')->first() ;
            $product_id = $product_last_row->id ;

            if ($image__id != "") {

                if ($image__id == 1) {
                    foreach ($all_color_id as $cvalue) {
                        $cdata      = array() ;
                        $cdata['supplier_id']   = Session::get('supplier_id');
                        $cdata['product_id']    = $product_id;
                        $cdata['color_code']    = $cvalue;
                        $cdata['status']        = 1;
                        DB::table('tbl_product_color')->insert($cdata) ;
                    }
                }else{
                    foreach ($all_color_image as $civalue) {
                        $cdata      = array() ;
                        $cdata['supplier_id']   = Session::get('supplier_id');
                        $cdata['product_id']    = $product_id;
                        $cdata['color_image']   = $civalue;
                        $cdata['status']        = 1;
                        DB::table('tbl_product_color')->insert($cdata) ;
                    }
                }

            }

            if ($all_size_id != null) {
                foreach ($all_size_id as $svalue) {
                    $size_info__ = explode("/", $svalue) ;
                    $cdata                  = array() ;
                    $cdata['supplier_id']   = Session::get('supplier_id');
                    $cdata['product_id']    = $product_id;
                    $cdata['size_id']       = $size_info__[0];
                    $cdata['status']        = 1;
                    
                    DB::table('tbl_product_size')->insert($cdata) ;
                }
            }

            if ($package_template == 2) {

                # SINGLE PRICE SECTION

                if($unit_price != ""){
                    $data_price                     = array() ;
                    $data_price['supplier_id']      = Session::get('supplier_id') ;
                    $data_price['product_id']       = $product_id ;
                    $data_price['price_status']     = $package_template ;
                    $data_price['estimate_days']    = 0 ;
                    $data_price['start_quantity']   = 0 ;
                    $data_price['end_quantity']     = 0 ;
                    $data_price['product_price']    = $unit_price ;
                    $data_price['discount']         = $discount ;
                    $data_price['discount_type']    = $discount_status ;
                    $data_price['currency_id']      = $currency_id ;
                    $data_price['status']           = 1 ;
                    $data_price['created_at']       = date("Y-m-d H:i:s") ;
                    DB::table('tbl_product_price')->insert($data_price) ;

                    $offer_data             = array() ;
                    if ($offer_start_date != "") {
                        $offer_stdate          = explode("/", $offer_start_date) ;
                        $main_offer_start_date = $offer_stdate[2]."-".$offer_stdate[1]."-".$offer_stdate[0];
                        $offer_data['offer_start'] = $main_offer_start_date;
                    }else{
                        $offer_data['offer_start'] = null ;
                    }

                    if ($offer_end_date != "") {
                        $offer_etdate            = explode("/", $offer_end_date) ;
                        $main_offer_end_date     = $offer_etdate[2]."-".$offer_etdate[1]."-".$offer_etdate[0];
                        $offer_data['offer_end'] = $main_offer_end_date;
                    }else{
                        $offer_data['offer_end'] = null ;
                    }


                    $data = DB::table('tbl_product')->where('id', $product_id)->update($offer_data) ;
                }
            }elseif ($package_template == 1) {

                # PACKAGE PRICE SECTION

                if ($package_price_image != null) {

                    foreach ($package_price_image as $key=>$p_value) {
                        if ($image__id == 1) {
                            $color_code_info = DB::table('tbl_product_color')->where('color_code', $p_value)->first() ;
                            $color_id_for_price = $color_code_info->id ;
                        }else{
                            $color_code_info_is = DB::table('tbl_product_color')->where('color_image', $p_value)->first() ;
                            $color_id_for_price = $color_code_info_is->id ;
                        }
                        
                        if($quantity_start[$key]){
                            $start_quantity_s   = $quantity_start[$key] ;
                        }else{
                            $start_quantity_s = 0;
                        }
                        
                        if($quantity_end[$key]){
                            $end_quantity_s     = $quantity_end[$key] ;
                        }else{
                            $end_quantity_s = 0;
                        }
                        
                        if($price[$key]){
                            $end_price_s        = $price[$key]  ;
                        }else{
                            $end_price_s = 0;
                        }

                        
                        

                        $data_price                     = array() ;
                        $data_price['supplier_id']      = Session::get('supplier_id') ;
                        $data_price['product_id']       = $product_id ;
                        $data_price['price_status']     = $package_template ;
                        $data_price['color_id']         = $color_id_for_price ;
                        $data_price['start_quantity']   = $start_quantity_s ;
                        $data_price['end_quantity']     = $end_quantity_s ;
                        $data_price['product_price']    = $end_price_s ;
                        $data_price['discount']         = 0 ;
                        $data_price['discount_type']    = 0 ;
                        $data_price['currency_id']      = $currency_id ;
                        $data_price['status']           = 1 ;
                        $data_price['created_at']       = date("Y-m-d H:i:s") ;
                        DB::table('tbl_product_price')->insert($data_price) ;
                        
                    }
                    
                }
            }elseif($package_template == 4){

                # custom price section 

                if (count($custom_price_image) > 0) {
                    
                    foreach ($custom_price_image as $key => $img_price_value) {
                        
                        $data_price                     = array() ;
                        $data_price['supplier_id']      = Session::get('supplier_id') ;
                        $data_price['product_id']       = $product_id ;


                        if ($custom_price_value == 1) {
                            $size_id_for_price          = $img_price_value ;
                            $data_price['size_id']      = $size_id_for_price ;
                        }else{
                            if ($image__id == 1) {
                                $color_code_info = DB::table('tbl_product_color')
                                ->where('color_code', $img_price_value)
                                ->where('product_id', $product_id)
                                ->first() ;
                                $data_price['color_id']     = $color_code_info->id ;
                            }else{
                                $color_code_info_is = DB::table('tbl_product_color')
                                ->where('color_image', $img_price_value)
                                ->where('product_id', $product_id)
                                ->first() ;
    
                                $data_price['color_id']         = $color_code_info_is->id ;
                            }
                        }

                        
                        $data_price['price_status']     = $package_template ;
                        $data_price['estimate_days']    = 0 ;
                        $data_price['start_quantity']   = 0 ;
                        $data_price['end_quantity']     = 0 ;
                        $data_price['product_price']    = $image_per_qty_price[$key] ;
                        $data_price['discount']         = 0 ;
                        $data_price['currency_id']      = $currency_id ;
                        $data_price['status']           = 1 ;
                        $data_price['created_at']       = date("Y-m-d h:i:s") ;
                        DB::table('tbl_product_price')->insert($data_price) ;

                    }
                }

            }else{
                # PRODUCT PRICE Negotiated SECTOIN
                $data_price                     = array() ;
                $data_price['supplier_id']      = Session::get('supplier_id') ;
                $data_price['product_id']       = $product_id ;
                $data_price['price_status']     = $package_template ;
                $data_price['estimate_days']    = 0 ;
                $data_price['start_quantity']   = 0 ;
                $data_price['end_quantity']     = 0 ;
                $data_price['product_price']    = 0 ;
                $data_price['discount']         = 0 ;
                $data_price['discount_type']    = 0 ;
                $data_price['negotiate_price']  = 'negotiate' ;
                $data_price['status']           = 1 ;
                $data_price['created_at']       = date("Y-m-d H:i:s") ;
                DB::table('tbl_product_price')->insert($data_price) ;
            }

        }

        echo "success" ;
        exit() ;
    }

    public function changeProductStatus(Request $request)
    {
        $product_id = $request->product_id ;

        $status_check   = DB::table('tbl_product')->where('id', $product_id)->first() ;
        $status         = $status_check->status ;

        if ($status == 1) {
            $db_status = 2 ;
        }else{
            $db_status = 1 ;
        }

        $data           = array() ;
        $data['status'] = $db_status ;
        $query = DB::table('tbl_product')->where('id', $product_id)->update($data) ;
        if ($db_status == 1) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
        }
    }

    public function updateProductInformation($id)
    {
        $product_info = DB::table('tbl_product')->where('id', $id)->first() ;

        $all_web_category = DB::table('tbl_tartiarycategory')
            ->leftJoin('tbl_primarycategory', 'tbl_tartiarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->leftJoin('tbl_secondarycategory', 'tbl_tartiarycategory.secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->select('tbl_tartiarycategory.*', 'tbl_primarycategory.category_name', 'tbl_secondarycategory.secondary_category_name')
            ->where('tbl_tartiarycategory.status', 1)
            ->get() ;

        $all_main_category = DB::table('tbl_supplier_primary_category')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_supplier_tags = DB::table('tbl_tags')
            ->where('supplier_id', Session::get('supplier_id'))
            ->whereNotIn('id', [$product_info->product_tags])
            ->where('status', 1)
            ->get() ;

        $all_product_brand = DB::table('tbl_brand')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_unit = DB::table('tbl_unit_price')
            ->where('status', 1)
            ->get() ;

        $all_secondary_category = DB::table('tbl_supplier_secondary_category')
            ->where('primary_category_id', $product_info->main_category_id)
            ->where('status', 1)
            ->get() ;

        $all_shipping       = DB::table('tbl_shipping')
                ->where('status', 1)
                ->whereNotIn('id', [$product_info->shipping_method])
                ->get() ;

        $all_payment_method = DB::table('tbl_payment_method')
                ->where('status', 1)
                ->whereNotIn('id', [$product_info->payment_method])
                ->get() ;
                
                
         $agent          = new Agent;
        $desktopResult  = $agent->isDesktop();
        if($desktopResult){
            return view('product.updateProductInformation')->with('all_main_category', $all_main_category)->with('all_supplier_tags', $all_supplier_tags)->with('all_product_brand', $all_product_brand)->with('all_unit', $all_unit)->with('all_web_category', $all_web_category)->with('product_info',$product_info)->with('all_secondary_category', $all_secondary_category)->with('all_shipping', $all_shipping)->with('all_payment_method', $all_payment_method) ;
        }else{
           return view('product.mobileUpdateProduct')->with('all_main_category', $all_main_category)->with('all_supplier_tags', $all_supplier_tags)->with('all_product_brand', $all_product_brand)->with('all_unit', $all_unit)->with('all_web_category', $all_web_category)->with('product_info',$product_info)->with('all_secondary_category', $all_secondary_category)->with('all_shipping', $all_shipping)->with('all_payment_method', $all_payment_method) ;
        }

       
    }

    public function updateProductInfo(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        
        $product_web_category       = trim($request->product_web_category) ;
        $product_name               = trim($request->product_name) ;
        $main_category_id           = trim($request->main_category_id) ;
        $secondary_category_id      = trim($request->secondary_category_id) ;
        $tertiary_category_id       = trim($request->tertiary_category_id) ;
        $brand_id                   = trim($request->brand_id) ;
        $unit                       = trim($request->unit) ;
        $tags                       = $request->producttags ;
        $product_image              = json_decode($request->productFinalImages) ;
        $video_link_type            = $request->video_link_type ;
        $video_link                 = $request->video_link ;
        $meta_title                 = $request->meta_title ;
        $meta_description           = $request->meta_description ;
        $product_description        = $request->product_description ;
        $shipping_status            = $request->shipping_status ;
        $shipping_method            = $request->shipping_method ;
        $payment_method_id          = $request->payment_method_id ;
        $meta_image                 = $request->meta_image ;
        $all_size_id                = $request->all_size_id ;
        $all_color_id               = $request->all_color_id ;
        $all_color_image            = $request->all_color_image ;
        $image__id                  = $request->image__id ;
        $custom_price_value         = $request->custom_price_value ;
        $image_per_qty_price        = $request->image_per_qty_price ;
        $custom_price_image         = $request->custom_price_image ;

        $currency_id        = $request->price_currency ;
        $unit_price         = $request->unit_price ;
        $discount           = $request->discount ;
        $discount_status    = $request->discount_status ;
        $package_template   = $request->package_template ;
        $package_price_image = $request->package_price_image ;
        $quantity_start     = $request->quantity_start ;
        $quantity_end       = $request->quantity_end ;
        $price              = $request->price ;
        $offer_start_date   = $request->offer_start_date ;
        $offer_end_date     = $request->offer_end_date ;
        $qty                = $request->qty ;
        $cond               = $request->cond ;
        $product_id         = $request->product_id ;

        $check_product_name = DB::table('tbl_product')
            ->where('product_name', $product_name)
            ->where('supplier_id', Session::get('supplier_id'))
            ->whereNotIn('id', [$product_id])
            ->count() ;

        // if ($check_product_name > 0) {
        //     echo "duplicate_product" ;
        //     exit();
        // }


        $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        $verify_status = $supplier_info->profile_verify_status ;

        if ($verify_status == 0) {
            echo "not_verify" ;
            exit();
        }


       
        if (count($product_image) != 0 ) {
            $images = implode("#", $product_image);
        }else{
            $images = "" ;
        }


        $web_category_info      = DB::table('tbl_tartiarycategory')->where('id', $product_web_category)->first() ;
        if ($shipping_method != "") {
            $all_shipping_method    = implode(",", $shipping_method) ;
        }else{
            $all_shipping_method    = 0 ;
        }

        if ($payment_method_id != "") {
            $all_payment_method     = implode(",", $payment_method_id) ;
        }else{
            $all_payment_method     = "" ;
        }

        $data                               = array() ;
        $data['supplier_id']                = Session::get('supplier_id') ;
        $data['w_category_id']              = $web_category_info->primary_category_id ;
        $data['w_secondary_category_id']    = $web_category_info->secondary_category_id ;
        $data['w_tertiary_categroy_id']     = $product_web_category ;
        $data['product_name']               = $product_name ;
    
        if ($main_category_id != "") {
            $data['main_category_id']           = $main_category_id ;
        }

        if ($secondary_category_id != "") {
            $data['secondary_category_id']      = $secondary_category_id ;
        }

        if ($tertiary_category_id != "") {
            $data['tertiary_category_id']       = $tertiary_category_id ;
        }

        if ($brand_id != "") {
            $data['brand_id']           = $brand_id ;
        }
        
        $data['unit']                       = $unit ;
        $data['product_tags']               = $tags ;
        $data['products_image']             = $images ;
        $data['video_link']                 = $video_link ;

        if ($video_link_type != "") {
            $data['link_type']              = $video_link_type ;
        }

        $data['meta_title']                 = $meta_title ;
        $data['meta_description']           = $meta_description ;
        $data['product_description']        = $product_description ;
        if ($shipping_status != "") {
            $data['shipping_status']        = $shipping_status ;
        }

        $data['shipping_method']            = $all_shipping_method ;
        $data['payment_method']             = $all_payment_method ;

        $data['meta_image']                 = $meta_image ;
        $data['price_type']                 = $package_template ;
        $data['qty']                        = $qty ;
        $data['cond']                       = $cond ;
        $data['currency_id']                = $currency_id ;
        $data['slug']                       = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', 
            $product_name));
        $data['created_at']     = date('Y-m-d H:i:s') ;

        $query = DB::table('tbl_product')->where('id', $product_id)->update($data) ;


        if ($image__id != "") {

            if ($image__id == 1) {

                $delet_all_color = DB::table('tbl_product_color')
                    ->where('product_id', $product_id)
                    ->delete() ;

                foreach ($all_color_id as $cvalue) {
                    $cdata      = array() ;
                    $cdata['supplier_id']   = Session::get('supplier_id');
                    $cdata['product_id']    = $product_id;
                    $cdata['color_code']    = $cvalue;
                    $cdata['status']        = 1;
                    DB::table('tbl_product_color')->insert($cdata) ;
                }
            }else{
                $delet_all_color = DB::table('tbl_product_color')
                    ->where('product_id', $product_id)
                    ->delete() ;

                foreach ($all_color_image as $civalue) {
                    $cdata      = array() ;
                    $cdata['supplier_id']   = Session::get('supplier_id');
                    $cdata['product_id']    = $product_id;
                    $cdata['color_image']   = $civalue;
                    $cdata['status']        = 1;
                    DB::table('tbl_product_color')->insert($cdata) ;
                }
            }

        }

        if ($all_size_id != null) {
            foreach ($all_size_id as $siam_size_info) {
                $size_info___ = explode("/", $siam_size_info) ;
                $main_size_id[] = $size_info___[0] ;
            }
            DB::table('tbl_product_size')
                    ->where('product_id', $product_id)
                    ->delete() ;

            foreach ($all_size_id as $svalue) {
                $size_info__ = explode("/", $svalue) ;
                $cdata                  = array() ;
                $cdata['supplier_id']   = Session::get('supplier_id');
                $cdata['product_id']    = $product_id;
                $cdata['size_id']       = $size_info__[0];
                $cdata['status']        = 1;
                DB::table('tbl_product_size')->insert($cdata) ;
            }
        }else{
            DB::table('tbl_product_size')
            ->where('product_id', $product_id)
            ->delete() ;
        }

        if ($package_template == 2) {
            if($unit_price != "" || $discount != "" || $package_template != ""){

                $data_price                     = array() ;
                $data_price['supplier_id']      = Session::get('supplier_id') ;
                $data_price['product_id']       = $product_id ;
                $data_price['price_status']     = $package_template ;
                $data_price['estimate_days']    = 0 ;
                $data_price['start_quantity']   = 0 ;
                $data_price['end_quantity']     = 0 ;
                $data_price['product_price']    = $unit_price ;
                $data_price['discount']         = $discount ;
                $data_price['discount_type']    = $discount_status ;
                $data_price['currency_id']      = $currency_id ;
                $data_price['status']           = 1 ;
                $data_price['created_at']       = date("Y-m-d H:i:s") ;
                DB::table('tbl_product_price')->where('product_id', $product_id)->update($data_price) ;


                $offer_data             = array() ;
                if ($offer_start_date   != "") {

                    $offer_stdate = explode("/", $offer_start_date) ;
                    $main_offer_start_date = $offer_stdate[2]."-".$offer_stdate[1]."-".$offer_stdate[0];
                    $offer_data['offer_start'] = $main_offer_start_date;
                }else{
                    $offer_data['offer_start'] = null;
                }

                if ($offer_start_date   != "") {
                    $offer_etdate            = explode("/", $offer_end_date) ;
                    $main_offer_end_date     = $offer_etdate[2]."-".$offer_etdate[1]."-".$offer_etdate[0];
                    $offer_data['offer_end'] = $main_offer_end_date;
                }else{
                    $offer_data['offer_end'] = null;
                }

                $data = DB::table('tbl_product')->where('id', $product_id)->update($offer_data) ;
            }
        }elseif ($package_template == 1) {
            if ($package_price_image != null || $quantity_start != null || $quantity_end != null || $price != null) {
                DB::table('tbl_product_price')->where('product_id', $product_id)->delete();


                foreach ($package_price_image as $key=>$p_value) {
                    if ($image__id == 1) {
                        $color_code_info = DB::table('tbl_product_color')->where('color_code', $p_value)->where('product_id', $product_id)->first() ;
                        $color_id_for_price = $color_code_info->id ;
                    }else{
                        $color_code_info_is = DB::table('tbl_product_color')->where('color_image', $p_value)->where('product_id', $product_id)->first() ;
                        $color_id_for_price = $color_code_info_is->id ;
                    }
                    $data_price                     = array() ;
                    $data_price['supplier_id']      = Session::get('supplier_id') ;
                    $data_price['product_id']       = $product_id ;
                    $data_price['price_status']     = $package_template ;
                    $data_price['color_id']         = $color_id_for_price ;
                    $data_price['start_quantity']   = $quantity_start[$key] ;
                    $data_price['end_quantity']     = $quantity_end[$key] ;
                    $data_price['product_price']    = $price[$key] ;
                    $data_price['discount']         = 0 ;
                    $data_price['discount_type']    = 0 ;
                    $data_price['currency_id']      = $currency_id ;
                    $data_price['status']           = 1 ;
                    $data_price['created_at']       = date("Y-m-d H:i:s") ;
                    DB::table('tbl_product_price')->insert($data_price) ;
                }
                
            }
        }elseif($package_template == 4){


            if (count($custom_price_image) > 0) {

                DB::table('tbl_product_price')->where('product_id', $product_id)->delete();
                
                foreach ($custom_price_image as $key => $img_price_value) {

                    $data_price                     = array() ;
                    $data_price['supplier_id']      = Session::get('supplier_id') ;
                    $data_price['product_id']       = $product_id ;

                    if ($custom_price_value == 1) {
                        $size_id_for_price          = $img_price_value ;
                        $data_price['size_id']      = $size_id_for_price ;
                    }else{
                        if ($image__id == 1) {
                            $color_code_info = DB::table('tbl_product_color')
                            ->where('color_code', $img_price_value)
                            ->where('product_id', $product_id)
                            ->first() ;
                            $data_price['color_id']     = $color_code_info->id ;
                        }else{
                            $color_code_info_is = DB::table('tbl_product_color')
                            ->where('color_image', $img_price_value)
                            ->where('product_id', $product_id)
                            ->first() ;

                            $data_price['color_id']         = $color_code_info_is->id ;
                        }
                    }

                    
                    $data_price['price_status']     = $package_template ;
                    $data_price['estimate_days']    = 0 ;
                    $data_price['start_quantity']   = 0 ;
                    $data_price['end_quantity']     = 0 ;
                    $data_price['product_price']    = $image_per_qty_price[$key] ;
                    $data_price['discount']         = 0 ;
                    $data_price['currency_id']      = $currency_id ;
                    $data_price['status']           = 1 ;
                    $data_price['created_at']       = date("Y-m-d h:i:s") ;
                    DB::table('tbl_product_price')->insert($data_price) ;

                }
            }

        }else{
        
            DB::table('tbl_product_price')->where('product_id', $product_id)->delete() ;

            # PRODUCT PRICE Negotiated SECTOIN
            $data_price                     = array() ;
            $data_price['supplier_id']      = Session::get('supplier_id') ;
            $data_price['product_id']       = $product_id ;
            $data_price['price_status']     = $package_template ;
            $data_price['estimate_days']    = 0 ;
            $data_price['start_quantity']   = 0 ;
            $data_price['end_quantity']     = 0 ;
            $data_price['product_price']    = 0 ;
            $data_price['discount']         = 0 ;
            $data_price['discount_type']    = 0 ;
            $data_price['negotiate_price']  = 'negotiate' ;
            $data_price['status']           = 1 ;
            $data_price['created_at']       = date("Y-m-d H:i:s") ;
            DB::table('tbl_product_price')->insert($data_price) ;
            
        }


        echo "success" ;
        exit() ;
    }



    public function deleteProductInfo(Request $request)
    {

        $product_id = $request->product_id ;
        $product_info = DB::table('tbl_product')->where('id', $product_id)->first() ;

        if ($product_info->products_image != "") {
           $product_image_name = explode("#", $product_info->products_image) ;
           foreach ($product_image_name as $image_name) {
               if ($image_name != "") {

                    $product_image  = DB::table('tbl_product')
                        ->where('supplier_id', Session::get('supplier_id'))
                        ->whereNotIn('id', [$product_id])
                        ->get();

                    foreach ($product_image as $product_images) {
                        if ($product_images->products_image != "") {
                           $product_image_name2 = explode("#", $product_images->products_image) ;
                           foreach ($product_image_name2 as $image_name2) {
                               if ($image_name2 != "" && $image_name != $image_name2) {
                                   $prodcut_images[] = $image_name;
                               }
                           }
                        }
                    }

                    $image_check  = DB::table('tbl_product')
                        ->where('meta_image', 'like', '%'.$image_name.'%')
                        ->where('supplier_id', Session::get('supplier_id'))

                        ->count();
                    if ($image_check == 0) {
                        $prodcut_images[] = $image_name ;
                    }


                    $image_check_2  = DB::table('tbl_product_color')
                        ->where('color_image', 'like', '%'.$image_name.'%')
                        ->where('supplier_id', Session::get('supplier_id'))
                        ->count();

                    if ($image_check_2 == 0) {
                        $prodcut_images[] = $image_name ;
                    }


                    $image_check_3  = DB::table('tbl_slider')
                        ->where('slider_image', 'like', '%'.$image_name.'%')
                        ->where('supplier_id', Session::get('supplier_id'))
                        ->count();

                    if ($image_check_2 == 0) {
                        $prodcut_images[] = $image_name ;
                    }

               }
           }
        }

        $arr_main_unique  = array_unique($prodcut_images);

        foreach ($arr_main_unique as $image) {
            
            $imga_url = "public/images/".$image ;
            // if ($image != "") {
            //     unlink($imga_url) ;
            // }
            DB::table('tbl_media')->where('image', $image)->delete() ;
        }

        $query = DB::table('tbl_product')->where('id', $product_id)->delete() ;

        if ($query) {
            echo "success";
            exit() ;
        }else{
            echo "failed";
            exit() ;
        }
    }
    
    public function productpriceinformationchange()
    {
        $all_products = DB::table('tbl_product')->whereNotIn('price_type', [2])->get() ;
        foreach($all_products as $product){
            $product_id  = $product->id ;
            $price_type  = $product->price_type ;
            $currency_id = $product->currency_id ;

            $check_count        = DB::table('tbl_product_price')->where('product_id', $product_id)->get() ;
            $total_price_count  = count($check_count) ;

            if($total_price_count > 1){
                $main_price = $total_price_count - 1 ;
                DB::table('tbl_product_price')->where('product_id', $product_id)->limit($main_price)->orderBy('id', 'desc')->delete();
            }
            $price_info = DB::table('tbl_product_price')->where('product_id', $product_id)->first() ;
            if($price_info){
                $main_price = $price_info->product_price;
            }else{
                $main_price = 0;
            }

            $data_price                     = array() ;
            $data_price['supplier_id']      = $product->supplier_id ;
            $data_price['product_id']       = $product_id ;
            $data_price['color_id']         = "" ;
            $data_price['size_id']         = "" ;
            $data_price['price_status']     = 2 ;
            $data_price['estimate_days']    = 0 ;
            $data_price['start_quantity']   = 0 ;
            $data_price['end_quantity']     = 0 ;
            $data_price['product_price']    = $main_price ;
            $data_price['discount']         = 0 ;
            $data_price['discount_type']    = 1 ;
            $data_price['currency_id']      = 2 ;
            $data_price['status']           = 1 ;
            $data_price['created_at']       = date("Y-m-d H:i:s") ;

            if($total_price_count == 0){
                DB::table('tbl_product_price')->insert($data_price) ;
            }else{
                DB::table('tbl_product_price')->where('id', $price_info->id)->update($data_price) ;
            }

            $product_data = array();
            $product_data['price_type']     = 2 ;
            $product_data['currency_id']    = 2 ;

            DB::table('tbl_product')->where('id', $product_id)->update($product_data) ;
        }

        return "success" ;
    }

    # SELLER PRODUCT LIST 
    public function sellerproductlist()
    {
        return view('seller.product.sellerproductlist');
    }

    public function getSellerProductData(Request $request)
    {
        $supplier_id = Session::get('supplier_id');
        $result      = DB::table('tbl_product')->where('supplier_id',$supplier_id)->orderBy('id', 'desc')->get() ;

        return view('seller.product.getSellerProductData')->with('result',$result);
    }

    public function sellerproductInformation()
    {
        $all_web_category = DB::table('tbl_tartiarycategory')
        ->leftJoin('tbl_primarycategory', 'tbl_tartiarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
        ->leftJoin('tbl_secondarycategory', 'tbl_tartiarycategory.secondary_category_id', '=', 'tbl_secondarycategory.id')
        ->select('tbl_tartiarycategory.*', 'tbl_primarycategory.category_name', 'tbl_secondarycategory.secondary_category_name')
        ->where('tbl_tartiarycategory.status', 1)
        ->get() ;

        $all_primary_category = DB::table('tbl_primarycategory')->where('status', 1)->get();

        $all_main_category = DB::table('tbl_supplier_primary_category')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_supplier_tags = DB::table('tbl_tags')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_product_brand = DB::table('tbl_brand')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_unit = DB::table('tbl_unit_price')
            ->where('status', 1)
            ->get() ;

        $all_shipping       = DB::table('tbl_shipping')->where('status', 1)->get() ;
        $all_payment_method = DB::table('tbl_payment_method')->where('status', 1)->get() ;

        $supplier_verify_count = DB::table('express')->where('profile_verify_status', 1)->where('id', Session::get('supplier_id'))->count();

        if ($supplier_verify_count == 0) {
            Session::put('failed', 'Sorry Your Account Not Verified Please Verify First. <a href="http://availtrade.com/supplierAccountSettings" style="color:blue;font-weight:bold">Verify Link</a>') ;
        }
        
        if(Session::get('seller_type') == 1){

            DB::table('tbl_media')->where('supplier_id', Session::get('supplier_id'))->delete();
        }
        


        $agent          = new Agent;
        $desktopResult  = $agent->isDesktop();
        if($desktopResult){
            return view('seller.product.sellerproductInformation')->with('all_main_category', $all_main_category)->with('all_supplier_tags', $all_supplier_tags)->with('all_product_brand', $all_product_brand)->with('all_unit', $all_unit)->with('all_web_category', $all_web_category)->with('all_shipping', $all_shipping)->with('all_payment_method', $all_payment_method)->with('all_primary_category', $all_primary_category) ;
        }else{
            return view('seller.product.sellermobileProductUpload')->with('all_main_category', $all_main_category)->with('all_supplier_tags', $all_supplier_tags)->with('all_product_brand', $all_product_brand)->with('all_unit', $all_unit)->with('all_web_category', $all_web_category)->with('all_shipping', $all_shipping)->with('all_payment_method', $all_payment_method)->with('all_primary_category', $all_primary_category) ;
        }
    }

    public function getwebsecondarycategory(Request $request)
    {
        $secondary_category = DB::table('tbl_secondarycategory')->where('primary_category_id', $request->main_category_id)->where('status', 1)->get();

        echo "<option value=''>Select an option</option>";
        foreach($secondary_category as $secondary){
            echo "<option value='".$secondary->id."'>".$secondary->secondary_category_name."</option>";
        }
    }
    public function getwebtertiarycategory(Request $request)
    {
        $tertiary_category = DB::table('tbl_tartiarycategory')
        ->where('primary_category_id', $request->main_category_id)
        ->where('secondary_category_id', $request->secondary_category_id)
        ->where('status', 1)
        ->get();

        echo "<option value=''>Select an option</option>";
        foreach($tertiary_category as $tertiary){
            echo "<option value='".$tertiary->id."'>".$tertiary->tartiary_category_name."</option>";
        }
    
    }
    public function insertSellerProductInfo(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        
        $product_web_category       = trim($request->product_web_category) ;
        $product_name               = trim($request->product_name) ;
        $main_category_id           = trim($request->main_category_id) ;
        $secondary_category_id      = trim($request->secondary_category_id) ;
        $tertiary_category_id       = trim($request->tertiary_category_id) ;
        $brand_id                   = trim($request->brand_id) ;
        $unit                       = trim($request->unit) ;
        $tags                       = $request->producttags ;
        $product_image              = json_decode($request->productFinalImages) ;
        $video_link_type            = $request->video_link_type ;
        $video_link                 = $request->video_link ;
        $meta_title                 = $request->meta_title ;
        $meta_description           = $request->meta_description ;
        $product_description        = $request->product_description ;
        $shipping_status            = $request->shipping_status ;
        $shipping_method            = $request->shipping_method ;
        $payment_method_id          = $request->payment_method_id ;
        $meta_image                 = $request->meta_image ;
        $all_size_id                = $request->all_size_id ;
        $all_color_id               = $request->all_color_id ;
        $all_color_image            = $request->all_color_image ;
        $image__id                  = $request->image__id ;
        $custom_price_value         = $request->custom_price_value ;
        $image_per_qty_price        = $request->image_per_qty_price ;
        $custom_price_image         = $request->custom_price_image ;

        $currency_id        = $request->price_currency ;
        $unit_price         = $request->unit_price ;
        $discount           = $request->discount ;
        $discount_status    = $request->discount_status ;
        $package_template   = $request->package_template ;
        $package_price_image = $request->package_price_image ;
        $quantity_start     = $request->quantity_start ;
        $quantity_end       = $request->quantity_end ;
        $price              = $request->price ;
        $offer_start_date   = $request->offer_start_date ;
        $offer_end_date     = $request->offer_end_date ;
        $qty     = $request->qty ;
        $cond     = $request->cond ;
        


        $check_product_name = DB::table('tbl_product')
            ->where('product_name', $product_name)
            ->where('supplier_id', Session::get('supplier_id'))
            ->count() ;

        if ($check_product_name > 0) {
            echo "duplicate_product" ;
            exit();
        }


        $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        $verify_status = $supplier_info->profile_verify_status ;

        if ($verify_status == 0) {
            echo "not_verify" ;
            exit();
        }




        if (count($product_image) != 0 ) {
            $images = implode("#", $product_image);
        }else{
            $images = "" ;
        }

        $web_category_info      = DB::table('tbl_tartiarycategory')->where('id', $product_web_category)->first() ;
        if ($shipping_method != "") {
            $all_shipping_method    = implode(",", $shipping_method) ;
        }else{
            $all_shipping_method    = "" ;
        }

        if ($payment_method_id != "") {
            $all_payment_method     = implode(",", $payment_method_id) ;
        }else{
            $all_payment_method     = "";
        }
        

        if($unit_price != "" || $discount != "" || $package_template != ""){
                
        }else{
            echo "input_price_first" ;
            exit();
        }
        
        
        $data                               = array() ;
        $data['supplier_id']                = Session::get('supplier_id') ;
        $data['w_category_id']              = $product_web_category ;
        $data['w_secondary_category_id']    = $secondary_category_id ;
        $data['w_tertiary_categroy_id']     = $tertiary_category_id ;
        $data['product_name']               = $product_name ;

        if ($brand_id != "") {
            $data['brand_id']           = $brand_id ;
        }
        $data['unit']                       = $unit ;
        $data['product_tags']               = $tags ;
        $data['products_image']             = $images ;
        $data['video_link']                 = $video_link ;
        if ($video_link_type != "") {
            $data['link_type']              = $video_link_type ;
        }
        $data['meta_title']                 = $meta_title ;
        $data['meta_description']           = $meta_description ;
        $data['product_description']        = $product_description ;
        if ($shipping_status != "") {
            $data['shipping_status']        = $shipping_status ;
        }
        $data['shipping_method']            = $all_shipping_method ;
        $data['payment_method']             = $all_payment_method ;
        $data['meta_image']                 = $meta_image ;
        $data['status']                     = 1 ;
        $data['qty']                       = $qty ;
        $data['cond']                      = $cond ;
        $data['price_type']                 = $package_template ;
        $data['currency_id']                = $currency_id ;
        $data['slug']                       = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', 
            $product_name));
        $data['created_at']     = date('Y-m-d H:i:s') ;

        $query = DB::table('tbl_product')->insert($data) ;

        if ($query) {
            
            $product_last_row = DB::table('tbl_product')->orderBy('id', 'desc')->first() ;
            $product_id = $product_last_row->id ;

            if ($image__id != "") {

                if ($image__id == 1) {
                    foreach ($all_color_id as $cvalue) {
                        $cdata      = array() ;
                        $cdata['supplier_id']   = Session::get('supplier_id');
                        $cdata['product_id']    = $product_id;
                        $cdata['color_code']    = $cvalue;
                        $cdata['status']        = 1;
                        DB::table('tbl_product_color')->insert($cdata) ;
                    }
                }else{
                    foreach ($all_color_image as $civalue) {
                        $cdata      = array() ;
                        $cdata['supplier_id']   = Session::get('supplier_id');
                        $cdata['product_id']    = $product_id;
                        $cdata['color_image']   = $civalue;
                        $cdata['status']        = 1;
                        DB::table('tbl_product_color')->insert($cdata) ;
                    }
                }

            }

            if ($all_size_id != null) {
                foreach ($all_size_id as $svalue) {
                    $size_info__ = explode("/", $svalue) ;
                    $cdata                  = array() ;
                    $cdata['supplier_id']   = Session::get('supplier_id');
                    $cdata['product_id']    = $product_id;
                    $cdata['size_id']       = $size_info__[0];
                    $cdata['status']        = 1;
                    
                    DB::table('tbl_product_size')->insert($cdata) ;
                }
            }

            $data_price                     = array() ;
            $data_price['supplier_id']      = Session::get('supplier_id') ;
            $data_price['product_id']       = $product_id ;
            $data_price['price_status']     = $package_template ;
            $data_price['estimate_days']    = 0 ;
            $data_price['start_quantity']   = 0 ;
            $data_price['end_quantity']     = 0 ;
            $data_price['product_price']    = $unit_price ;
            $data_price['discount']         = $discount ;
            $data_price['discount_type']    = $discount_status ;
            $data_price['currency_id']      = $currency_id ;
            $data_price['status']           = 1 ;
            $data_price['created_at']       = date("Y-m-d H:i:s") ;
            DB::table('tbl_product_price')->insert($data_price) ;

            $offer_data             = array() ;
            if ($offer_start_date != "") {
                $offer_stdate          = explode("/", $offer_start_date) ;
                $main_offer_start_date = $offer_stdate[2]."-".$offer_stdate[1]."-".$offer_stdate[0];
                $offer_data['offer_start'] = $main_offer_start_date;
            }else{
                $offer_data['offer_start'] = null ;
            }

            if ($offer_end_date != "") {
                $offer_etdate            = explode("/", $offer_end_date) ;
                $main_offer_end_date     = $offer_etdate[2]."-".$offer_etdate[1]."-".$offer_etdate[0];
                $offer_data['offer_end'] = $main_offer_end_date;
            }else{
                $offer_data['offer_end'] = null ;
            }


            $data = DB::table('tbl_product')->where('id', $product_id)->update($offer_data) ;

        }

        echo "success" ;
        exit() ;
    }


    public function updateSellerProductInformation($id)
    {
        $product_info = DB::table('tbl_product')->where('id', $id)->first() ;

        $all_web_category = DB::table('tbl_tartiarycategory')
            ->leftJoin('tbl_primarycategory', 'tbl_tartiarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->leftJoin('tbl_secondarycategory', 'tbl_tartiarycategory.secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->select('tbl_tartiarycategory.*', 'tbl_primarycategory.category_name', 'tbl_secondarycategory.secondary_category_name')
            ->where('tbl_tartiarycategory.status', 1)
            ->get() ;
        
        $all_primary_category = DB::table('tbl_primarycategory')->where('status', 1)->get();
        $category_wise_secondary = DB::table('tbl_secondarycategory')->where('primary_category_id', $product_info->w_category_id)->get();
        $category_wise_tertiary = DB::table('tbl_tartiarycategory')->where('secondary_category_id', $product_info->w_secondary_category_id)->get();

        $all_main_category = DB::table('tbl_supplier_primary_category')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_supplier_tags = DB::table('tbl_tags')
            ->where('supplier_id', Session::get('supplier_id'))
            ->whereNotIn('id', [$product_info->product_tags])
            ->where('status', 1)
            ->get() ;

        $all_product_brand = DB::table('tbl_brand')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->get() ;

        $all_unit = DB::table('tbl_unit_price')
            ->where('status', 1)
            ->get() ;

        $all_secondary_category = DB::table('tbl_supplier_secondary_category')
            ->where('primary_category_id', $product_info->main_category_id)
            ->where('status', 1)
            ->get() ;

        $all_shipping       = DB::table('tbl_shipping')
                ->where('status', 1)
                ->whereNotIn('id', [$product_info->shipping_method])
                ->get() ;

        $all_payment_method = DB::table('tbl_payment_method')
                ->where('status', 1)
                ->whereNotIn('id', [$product_info->payment_method])
                ->get() ;
        
        if(Session::get('seller_type') == 1){
            DB::table('tbl_media')->where('supplier_id', Session::get('supplier_id'))->delete();
        }
                
                
         $agent          = new Agent;
        $desktopResult  = $agent->isDesktop();
        if($desktopResult){
            return view('seller.product.updateSellerProductInformation')->with('all_main_category', $all_main_category)->with('all_supplier_tags', $all_supplier_tags)->with('all_product_brand', $all_product_brand)->with('all_unit', $all_unit)->with('all_web_category', $all_web_category)->with('product_info',$product_info)->with('all_secondary_category', $all_secondary_category)->with('all_shipping', $all_shipping)->with('all_payment_method', $all_payment_method)->with('category_wise_secondary', $category_wise_secondary)->with('category_wise_tertiary', $category_wise_tertiary)->with('all_primary_category', $all_primary_category) ;
        }else{
           return view('seller.product.sellermobileUpdateProduct')->with('all_main_category', $all_main_category)->with('all_supplier_tags', $all_supplier_tags)->with('all_product_brand', $all_product_brand)->with('all_unit', $all_unit)->with('all_web_category', $all_web_category)->with('product_info',$product_info)->with('all_secondary_category', $all_secondary_category)->with('all_shipping', $all_shipping)->with('all_payment_method', $all_payment_method)->with('category_wise_secondary', $category_wise_secondary)->with('category_wise_tertiary', $category_wise_tertiary)->with('all_primary_category', $all_primary_category) ;
        }
    }

    public function sellerUpdateProductInfo(Request $request)
    {
        date_default_timezone_set('Asia/Dhaka');
        
        $product_web_category       = trim($request->product_web_category) ;
        $product_name               = trim($request->product_name) ;
        $main_category_id           = trim($request->main_category_id) ;
        $secondary_category_id      = trim($request->secondary_category_id) ;
        $tertiary_category_id       = trim($request->tertiary_category_id) ;
        $brand_id                   = trim($request->brand_id) ;
        $unit                       = trim($request->unit) ;
        $tags                       = $request->producttags ;
        $product_image              = json_decode($request->productFinalImages) ;
        $video_link_type            = $request->video_link_type ;
        $video_link                 = $request->video_link ;
        $meta_title                 = $request->meta_title ;
        $meta_description           = $request->meta_description ;
        $product_description        = $request->product_description ;
        $shipping_status            = $request->shipping_status ;
        $shipping_method            = $request->shipping_method ;
        $payment_method_id          = $request->payment_method_id ;
        $meta_image                 = $request->meta_image ;
        $all_size_id                = $request->all_size_id ;
        $all_color_id               = $request->all_color_id ;
        $all_color_image            = $request->all_color_image ;
        $image__id                  = $request->image__id ;
        $custom_price_value         = $request->custom_price_value ;
        $image_per_qty_price        = $request->image_per_qty_price ;
        $custom_price_image         = $request->custom_price_image ;

        $currency_id        = $request->price_currency ;
        $unit_price         = $request->unit_price ;
        $discount           = $request->discount ;
        $discount_status    = $request->discount_status ;
        $package_template   = $request->package_template ;
        $package_price_image = $request->package_price_image ;
        $quantity_start     = $request->quantity_start ;
        $quantity_end       = $request->quantity_end ;
        $price              = $request->price ;
        $offer_start_date   = $request->offer_start_date ;
        $offer_end_date     = $request->offer_end_date ;
        
        $qty   = $request->qty ;
        $cond    = $request->cond ;
        
        $product_id         = $request->product_id ;

        $check_product_name = DB::table('tbl_product')
            ->where('product_name', $product_name)
            ->where('supplier_id', Session::get('supplier_id'))
            ->whereNotIn('id', [$product_id])
            ->count() ;

        // if ($check_product_name > 0) {
        //     echo "duplicate_product" ;
        //     exit();
        // }


        $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        $verify_status = $supplier_info->profile_verify_status ;

        if ($verify_status == 0) {
            echo "not_verify" ;
            exit();
        }


       
        if (count($product_image) != 0 ) {
            $images = implode("#", $product_image);
        }else{
            $images = "" ;
        }


        $web_category_info      = DB::table('tbl_tartiarycategory')->where('id', $product_web_category)->first() ;
        if ($shipping_method != "") {
            $all_shipping_method    = implode(",", $shipping_method) ;
        }else{
            $all_shipping_method    = 0 ;
        }

        if ($payment_method_id != "") {
            $all_payment_method     = implode(",", $payment_method_id) ;
        }else{
            $all_payment_method     = "" ;
        }

        $data                               = array() ;
        $data['supplier_id']                = Session::get('supplier_id') ;
        $data['w_category_id']              = $product_web_category ;
        $data['w_secondary_category_id']    = $secondary_category_id ;
        $data['w_tertiary_categroy_id']     = $tertiary_category_id ;
        $data['product_name']               = $product_name ;


        if ($brand_id != "") {
            $data['brand_id']           = $brand_id ;
        }
        
        $data['unit']                       = $unit ;
        $data['product_tags']               = $tags ;
        $data['products_image']             = $images ;
        $data['video_link']                 = $video_link ;

        if ($video_link_type != "") {
            $data['link_type']              = $video_link_type ;
        }

        $data['meta_title']                 = $meta_title ;
        $data['meta_description']           = $meta_description ;
        $data['product_description']        = $product_description ;
        if ($shipping_status != "") {
            $data['shipping_status']        = $shipping_status ;
        }

        $data['shipping_method']            = $all_shipping_method ;
        $data['payment_method']             = $all_payment_method ;
        $data['qty']                        = $qty ;
        $data['cond']                       = $cond;

        $data['meta_image']                 = $meta_image ;
        $data['price_type']                 = $package_template ;
        $data['currency_id']                = $currency_id ;
        $data['slug']                       = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', 
            $product_name));
        $data['created_at']     = date('Y-m-d H:i:s') ;

        $query = DB::table('tbl_product')->where('id', $product_id)->update($data) ;


        if ($image__id != "") {

            if ($image__id == 1) {

                $delet_all_color = DB::table('tbl_product_color')
                    ->where('product_id', $product_id)
                    ->delete() ;

                foreach ($all_color_id as $cvalue) {
                    $cdata      = array() ;
                    $cdata['supplier_id']   = Session::get('supplier_id');
                    $cdata['product_id']    = $product_id;
                    $cdata['color_code']    = $cvalue;
                    $cdata['status']        = 1;
                    DB::table('tbl_product_color')->insert($cdata) ;
                }
            }else{
                $delet_all_color = DB::table('tbl_product_color')
                    ->where('product_id', $product_id)
                    ->delete() ;

                foreach ($all_color_image as $civalue) {
                    $cdata      = array() ;
                    $cdata['supplier_id']   = Session::get('supplier_id');
                    $cdata['product_id']    = $product_id;
                    $cdata['color_image']   = $civalue;
                    $cdata['status']        = 1;
                    DB::table('tbl_product_color')->insert($cdata) ;
                }
            }

        }

        if ($all_size_id != null) {
            foreach ($all_size_id as $siam_size_info) {
                $size_info___ = explode("/", $siam_size_info) ;
                $main_size_id[] = $size_info___[0] ;
            }
            DB::table('tbl_product_size')
                    ->where('product_id', $product_id)
                    ->delete() ;

            foreach ($all_size_id as $svalue) {
                $size_info__ = explode("/", $svalue) ;
                $cdata                  = array() ;
                $cdata['supplier_id']   = Session::get('supplier_id');
                $cdata['product_id']    = $product_id;
                $cdata['size_id']       = $size_info__[0];
                $cdata['status']        = 1;
                DB::table('tbl_product_size')->insert($cdata) ;
            }
        }else{
            DB::table('tbl_product_size')
            ->where('product_id', $product_id)
            ->delete() ;
        }

        if($unit_price != "" || $discount != "" || $package_template != ""){
            $data_price                     = array() ;
            $data_price['supplier_id']      = Session::get('supplier_id') ;
            $data_price['product_id']       = $product_id ;
            $data_price['price_status']     = $package_template ;
            $data_price['estimate_days']    = 0 ;
            $data_price['start_quantity']   = 0 ;
            $data_price['end_quantity']     = 0 ;
            $data_price['product_price']    = $unit_price ;
            $data_price['discount']         = $discount ;
            $data_price['discount_type']    = $discount_status ;
            $data_price['currency_id']      = $currency_id ;
            $data_price['status']           = 1 ;
            $data_price['created_at']       = date("Y-m-d H:i:s") ;
            DB::table('tbl_product_price')->where('product_id', $product_id)->update($data_price) ;


            $offer_data             = array() ;
            if ($offer_start_date   != "") {

                $offer_stdate = explode("/", $offer_start_date) ;
                $main_offer_start_date = $offer_stdate[2]."-".$offer_stdate[1]."-".$offer_stdate[0];
                $offer_data['offer_start'] = $main_offer_start_date;
            }else{
                $offer_data['offer_start'] = null;
            }

            if ($offer_start_date   != "") {
                $offer_etdate            = explode("/", $offer_end_date) ;
                $main_offer_end_date     = $offer_etdate[2]."-".$offer_etdate[1]."-".$offer_etdate[0];
                $offer_data['offer_end'] = $main_offer_end_date;
            }else{
                $offer_data['offer_end'] = null;
            }

            $data = DB::table('tbl_product')->where('id', $product_id)->update($offer_data) ;
        }


        return "success";
    }
    
    
    public function marketproductlist()
    {
        return view('marketing.product.productlist');
    }
    
    
    public function getMarketerProductData(Request $request)
    {
        // $result      = DB::table('tbl_product')->orderBy('id', 'desc')->get() ;
         $result      = DB::table('tbl_product')->get() ;

        return view('marketing.product.getAlldata')->with('result',$result);
    }
    
    public function updateMarketerProductInformation($id)
    {
        $product_info = DB::table('tbl_product')->where('id', $id)->first() ;

       return view('marketing.product.productUpade')->with('product_info',$product_info);
    }
    
    public function marketerUpdateProductInfo(Request $request)
    {
        
        
         $product_name               = trim($request->product_name) ;
        $meta_title                 = $request->meta_title ;
        $meta_description           = $request->meta_description ;
        $product_description        = $request->product_description ;
        $producttags              = $request->producttags ;
        
        $product_id              = $request->primary_id ;

        $data                               = array() ;
        
        $data['product_name']               = $product_name ;
        $data['meta_title']                 = $meta_title ;
        $data['meta_description']           = $meta_description ;
        $data['product_tags']               =  $producttags ;
        $data['product_description']        = $product_description ;
        
         $data['slug']                       = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', 
            $product_name));
            

        $query = DB::table('tbl_product')->where('id', $product_id)->update($data) ;

       return "success";
    }

}
