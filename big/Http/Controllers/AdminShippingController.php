<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use Image;
use DB;
use Session;

class AdminShippingController extends Controller{

	public function __construct(){
		date_default_timezone_set('Asia/Dhaka');
		$this->rcdate           = date('Y-m-d');
		$this->logged_id        = Session::get('admin_id');
		$this->current_time     = date('H:i:s');
	}

//supplier shipping method
	public function shippingList()
	{
		$result = DB::table('tbl_shipping')->orderBy('shippingCompanyName', 'asc')->get() ;
		return view('admin.shipping.shippingList')->with('result', $result) ;
	}

	public function shippingAllImages(Request $request)
	{
		$media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->get();
		return view('admin.shipping.paginations')->with('media_result', $media_result);
	}

	public function shippingfileStore(Request $request)
	{
		$image      = $request->file('file');
		$imageName  = $image->getClientOriginalName();
		$image->move(public_path('images'),$imageName);

		$data                   = array() ;
		$data['supplier_id']    = 0 ;
		$data['image']          = $imageName ;
		$data['status']         = 0 ;
		$data['created_at']     = $this->rcdate ;

		DB::table('tbl_media')->insert($data) ;

		return response()->json(['success'=>$imageName]);
	}

	public function shippingfileDestroy(Request $request)
	{
		$file_value = DB::table('tbl_media')->where('image', $filename)->first();
		if ($file_value->status == 0) {
			$filename =  $request->get('filename');
			DB::table('tbl_media')->where('image', $filename)->delete() ;
			$path=public_path().'/images'.$filename;
			if (file_exists($path)) {
				unlink($path);
			}
			return $filename; 
		}

	}

	public function shippingSaveImage(Request $request)
	{
		$supplier_id 	= $request->supplier_id;
		$data 			= array();
		$data['status'] = 1 ;

		$query =  DB::table('tbl_media')->where('supplier_id', $supplier_id)->update($data) ;

		echo $query;
	}

	public function shippingSearchValue(Request $request)
	{
		$search_keyword = $request->search_keyword ;

		$media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->where('image', 'like', '% '.$search_keyword.' %')->get();
		return view('admin.shipping.paginations')->with('media_result', $media_result);
	}

	public function insertShippingInfo(Request $request)
	{
	    
	    $request->validate([
	        'shippingCompanyName' => 'required',
            'logo' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);
		$shippingCompanyName = $request->shippingCompanyName;
		$logo = $request->logo;
		$supplier_id = Session::get('supplier_id');
	

		$data_count = DB::table('tbl_shipping')
		->where('shippingCompanyName', $shippingCompanyName)
		->where('supplier_id', $supplier_id)
		->count() ;

		if ($data_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		if ($shippingCompanyName == "" || $logo == "") {
			echo "invalid_input" ;
			exit() ;
		}

		$data                = array();
		$data['shippingCompanyName']  = $shippingCompanyName ;
		$data['slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $shippingCompanyName)) ;
		$data['supplier_id'] = $supplier_id ;
		$data['status']      = 1 ;
		$data['created_at']  = $this->rcdate ;
		
		if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/adminShipping/') . $new_image_name);
            $data['logo']  = $new_image_name;
        } 
    
		$query = DB::table('tbl_shipping')->insert($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function getAllShipping(Request $request)
	{
		$result = DB::table('tbl_shipping')->orderBy('shippingCompanyName', 'asc')->get() ;
		return view('admin.shipping.shippingData')->with('result', $result) ;
	}

	public function changeShippingStatus(Request $request)
	{
		$shipping_id = $request->shipping_id ;

		$status_check   = DB::table('tbl_shipping')->where('id', $shipping_id)->first() ;
		$status         = $status_check->status ;

		if ($status == 1) {
			$db_status = 2 ;
		}else{
			$db_status = 1 ;
		}

		$data           = array() ;
		$data['status'] = $db_status ;
		$query = DB::table('tbl_shipping')->where('id', $shipping_id)->update($data) ;
		if ($db_status == 1) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}

	}

	public function editShipping(Request $request)
	{
		$id = $request->id ;
		$value   = DB::table('tbl_shipping')->where('id', $id)->first() ;

		return view('admin.shipping.editShipping')->with('value', $value) ;
	}

	public function updateShippingInfo(Request $request)
	{
	    $request->validate([
	        'shippingCompanyName' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
	    
	    
		$shippingCompanyName    = $request->shippingCompanyName ;
		$logo                   = $request->logo ;
		$primary_id             = $request->primary_id ;
		
		$image = DB::table('tbl_shipping')->where('id', $request->primary_id)->first() ;

		if ($shippingCompanyName == "") {
			echo "invalid_input" ;
			exit() ;
		}

		$data_count = DB::table('tbl_shipping')
		->where('shippingCompanyName', $shippingCompanyName)
		->whereNotIn('id', [$primary_id])
		->count() ;

		if ($data_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$data                   = array() ;
		$data['shippingCompanyName']  = $shippingCompanyName ;
		$data['slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $shippingCompanyName)) ;
		$data['created_at']     = $this->rcdate ;
		
		if($request->hasFile('logo')){
         $image_path = public_path('images/adminShipping/' .$image->logo);
        if ($image->logo && file_exists($image_path)) {
                    unlink($image_path);
                }
             $image = $request->file('logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(450,450)->save(base_path('public/images/adminShipping/') . $new_image_name);
            $data['logo']  = $new_image_name;
           
        }
	

		$query = DB::table('tbl_shipping')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function shippingDelete(Request $request)
	{
		$id = $request->id ;
		
		$image = DB::table('tbl_shipping')->where('id', $id)->first() ;
		$image_path = public_path('images/adminShipping/' .$image->logo);
        if ($image->logo && file_exists($image_path)) {
                    unlink($image_path);
                }
		$query = DB::table('tbl_shipping')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}

	//Admin Unit Price
	public function unitPriceList(){
		$result = DB::table('tbl_unit_price')->orderBy('unit_name', 'asc')->get() ;
		return view('admin.unitPrice.unitPrice')->with('result', $result) ;
	}
	public function insertUnitPrice(Request $request){
		$unit_name = $request->unit_name;		
		$data_check = DB::table('tbl_unit_price')
		->where('unit_name', $unit_name)
		->count() ;

		if ($data_check > 0) {
			echo "duplicate_found";
			exit() ;
		}

		if ($unit_name == "") {
			echo "invalid_input" ;
			exit() ;
		}

		$data                = array();
		$data['unit_name']  = $unit_name ;
		$data['status']      = 1 ;
		$data['created_at']  = $this->rcdate ;

		$query = DB::table('tbl_unit_price')->insert($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function getAllUnitPrice(Request $request)
	{
		$result = DB::table('tbl_unit_price')->orderBy('unit_name', 'asc')->get() ;
		return view('admin.unitPrice.unitPriceData')->with('result', $result) ;
	}

	public function changeUnitPriceStatus(Request $request)
	{
		$unit_id = $request->unit_id ;
		$status_check   = DB::table('tbl_unit_price')->where('id', $unit_id)->first() ;
		$status         = $status_check->status ;

		if ($status == 1) {
			$db_status = 2 ;
		}else{
			$db_status = 1 ;
		}

		$data           = array() ;
		$data['status'] = $db_status ;
		$query = DB::table('tbl_unit_price')->where('id', $unit_id)->update($data) ;
		if ($db_status == 1) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}
	}

	public function editUnitPrice(Request $request)
	{
		$id = $request->id ;
		$value   = DB::table('tbl_unit_price')->where('id', $id)->first() ;
		return view('admin.unitPrice.editUnitPrice')->with('value', $value) ;
	}

	public function updateUnitPrice(Request $request)
	{
		$unit_name  = $request->unit_name ;
		$primary_id     = $request->primary_id ;

		if ($unit_name == "" ) {
			echo "invalid_input" ;
			exit() ;
		}

		$data_count = DB::table('tbl_unit_price')
		->where('unit_name', $unit_name)
		->whereNotIn('id', [$primary_id])
		->count() ;

		if ($data_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$data               = array() ;
		$data['unit_name']  = $unit_name ;
		$data['created_at']     = $this->rcdate ;

		$query = DB::table('tbl_unit_price')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function unitPriceDelete(Request $request){
		$id = $request->id ;
		$query = DB::table('tbl_unit_price')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}

	//admin payment method
	public function PaymentMethodList()
	{
		$result = DB::table('tbl_payment_method')->orderBy('id', 'desc')->get() ;
		return view('admin.paymentMethod.PaymentMethodList')->with('result', $result) ;
	}

	public function PaymentMethodAllImages(Request $request)
	{
		$media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->get();
		return view('admin.paymentMethod.paginations')->with('media_result', $media_result);
	}

	public function PaymentMethodfileStore(Request $request)
	{
	    
	    
		$image      = $request->file('file');
		$imageName  = $image->getClientOriginalName();
		$image->move(public_path('images'),$imageName);

		$data                   = array() ;
		$data['supplier_id']    = 0 ;
		$data['image']          = $imageName ;
		$data['status']         = 0 ;
		$data['created_at']     = $this->rcdate ;

		DB::table('tbl_media')->insert($data) ;

		return response()->json(['success'=>$imageName]);
	}

	public function PaymentMethodfileDestroy(Request $request)
	{
		$file_value = DB::table('tbl_media')->where('image', $filename)->first();
		if ($file_value->status == 0) {
			$filename =  $request->get('filename');
			DB::table('tbl_media')->where('image', $filename)->delete() ;
			$path=public_path().'/images'.$filename;
			if (file_exists($path)) {
				unlink($path);
			}
			return $filename; 
		}

	}

	public function PaymentMethodSaveImage(Request $request)
	{
		$supplier_id = $request->supplier_id;
		$data = array();
		$data['status'] = 1 ;

		$query =  DB::table('tbl_media')->where('supplier_id', $supplier_id)->update($data) ;

		echo $query;
	}

	public function PaymentMethodSearchValue(Request $request)
	{
		$search_keyword = $request->search_keyword ;

		$media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->where('image', 'like', '% '.$search_keyword.' %')->get();
		return view('admin.paymentMethod.paginations')->with('media_result', $media_result);
	}

	public function insertPaymentMethodInfo(Request $request)
	{
	    $request->validate([
            'paymentMethodName' => 'required',
            'logo'              => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
		$paymentMethodName = $request->paymentMethodName;
		$logo = $request->logo;
		
		$data_check = DB::table('tbl_payment_method')
		->where('paymentMethodName', $paymentMethodName)
		->count() ;

		if ($data_check > 0) {
			echo "duplicate_found";
			exit() ;
		}

		if ($paymentMethodName == "" || $logo == "") {
			echo "invalid_input" ;
			exit() ;
		}
		
	
		$data                = array();
		$data['paymentMethodName']  = $paymentMethodName ;
		$data['paymentMethodName_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $paymentMethodName)) ;
		$data['status']      = 1 ;
		$data['created_at']  = $this->rcdate ;
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/paymeentLogo/') . $new_image_name);
            $data['logo']  = $new_image_name;
        } 

		$query = DB::table('tbl_payment_method')->insert($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function getAllPaymentMethod(Request $request)
	{
		$result = DB::table('tbl_payment_method')->orderBy('id', 'desc')->get() ;

		return view('admin.paymentMethod.PaymentMethodData')->with('result', $result) ;
	}

	public function changePaymentMethodStatus(Request $request)
	{
		$paymentMethodName_id = $request->paymentMethodName_id ;

		$status_check   = DB::table('tbl_payment_method')->where('id', $paymentMethodName_id)->first() ;
		$status         = $status_check->status ;

		if ($status == 1) {
			$db_status = 2 ;
		}else{
			$db_status = 1 ;
		}

		$data           = array() ;
		$data['status'] = $db_status ;
		$query = DB::table('tbl_payment_method')->where('id', $paymentMethodName_id)->update($data) ;
		if ($db_status == 1) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}

	}

	public function editPaymentMethod(Request $request)
	{
		$id = $request->id ;
		$value   = DB::table('tbl_payment_method')->where('id', $id)->first() ;

		return view('admin.paymentMethod.editPaymentMethod')->with('value', $value) ;
	}

	public function updatePaymentMethodInfo(Request $request)
	{
	    $request->validate([
            'paymentMethodName' => 'required',
            'logo'              => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
	    
		$paymentMethodName  = $request->paymentMethodName ;
		$logo = $request->logo ;
		$primary_id     = $request->primary_id ;
		
		$image = DB::table('tbl_payment_method')->where('id', $primary_id)->first() ;

		if ($paymentMethodName == "" || $logo == "") {
			echo "invalid_input" ;
			exit() ;
		}

		$data_count = DB::table('tbl_payment_method')
		->where('paymentMethodName', $paymentMethodName)
		->whereNotIn('id', [$primary_id])
		->count() ;

		if ($data_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$data                   = array() ;
		$data['paymentMethodName']  = $paymentMethodName ;
		$data['paymentMethodName_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $paymentMethodName)) ;
// 		$data['logo']  = $logo ;
		$data['created_at']     = $this->rcdate ;
		
		if ($request->hasFile('logo')) {
		    $image_path = public_path('images/paymeentLogo/' .$image->logo);
          if ($image->logo && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/paymeentLogo/') . $new_image_name);
            $data['logo']  = $new_image_name;
        } 

		$query = DB::table('tbl_payment_method')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function PaymentMethodDelete(Request $request)
	{
		$id = $request->id ;
		$image = DB::table('tbl_payment_method')->where('id', $id)->first() ;
		$image_path = public_path('images/paymeentLogo/' .$image->logo);
        if ($image->logo && file_exists($image_path)) {
                    unlink($image_path);
                }
		
		$query = DB::table('tbl_payment_method')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}
}
