<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;
use Image ;

class PackageController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->loged_id     = Session::get('admin_id');
        $this->current_time = date("H:i:s");
        $this->date_time    = date('Y-m-d H:i:s') ;
    }

    # MANAGE ALL PACKAGE LIST 
    public function adminpackagecategorylist()
    {
        $result = DB::table('tbl_package_category')->get() ;
        return view('admin.package.adminpackagecategorylist')->with('result', $result) ;
    }

    # ADD PACKAGE CATEGORY 
    public function addAdminPackageCategory()
    {

        return view('admin.package.addAdminPackageCategory') ;
    }

    # INSERT SUPPLIER PACKAGE CATEGORY 
    public function insertpackagecategory(Request $request)
    {
        $this->validate($request, [
            'package_name' => 'required',
            'duration_type' => 'required',
        ]);

        $package_name = trim($request->package_name) ;
        $duration_type = trim($request->duration_type) ;
        # CHECK DUPLICATE PACKAGE CATEGORY 
        $duplicate_count = DB::table('tbl_package_category')
            ->where('category_name', $package_name)
            ->count() ;

        if($duplicate_count > 0)
        {
            Session::put('failed', 'Sorry! Category Already Exist');
            return Redirect::to('addAdminPackageCategory');
            exit() ;
        }

        $data                   = array() ;
        $data['category_name']  = $package_name ;
        $data['duration_type']  = $duration_type ;
        $data['status']         = 2;    
        $data['created_at']     = $this->date_time;
        DB::table('tbl_package_category')->insert($data);

        Session::put('success', 'Thanks! Package Category Add Successfully.');
        return Redirect::to('addAdminPackageCategory');
    }

    # CHANGE PACKAGE CATEGORY STATUS 
    public function changepackagecategorystatus(Request $request)
    {
        $packagecategoryid = $request->packagecategoryid ;
        $category_status = DB::table('tbl_package_category')->where('id', $packagecategoryid)->first() ;
        $main_status = $category_status->status ;

        if($main_status == 2){
            $status = 1 ;
        }else{
            $status = 2 ;
        }

        $data = array() ;
        $data['status'] = $status ;
        $data['updated_at'] = $this->date_time;

        DB::table('tbl_package_category')->where('id', $packagecategoryid)->update($data) ;
        echo "success" ;

    }

    # EDIT PACKAGE STATUS 
    public function editpackagecategory($id)
    {
        $value = DB::table('tbl_package_category')->where('id', $id)->first() ;

        return view('admin.package.editpackagecategory')->with('value', $value) ;
    }

    # UPDATE PACKAGE CATEGORY  
    public function updatepackagecategory(Request $request)
    {
        $this->validate($request, [
            'package_name'  => 'required',
            'duration_type' => 'required',
        ]);

        $package_name   = trim($request->package_name) ;
        $duration_type  = trim($request->duration_type) ;
        $primary_id     = trim($request->primary_id) ;

        # CHECK DUPLICATE PACKAGE CATEGORY 
        $duplicate_count = DB::table('tbl_package_category')
            ->where('category_name', $package_name)
            ->whereNotIn('id', [$primary_id])
            ->count() ;

        if($duplicate_count > 0)
        {
            Session::put('failed', 'Sorry! Category Already Exist');
            return back();
            exit() ;
        }

        $data                   = array() ;
        $data['category_name']  = $package_name ;
        $data['duration_type']  = $duration_type ; 
        $data['updated_at']     = $this->date_time;
        DB::table('tbl_package_category')->where('id', $primary_id)->update($data);

        Session::put('success', 'Thanks! Package Category Update Successfully.');
        return back();
    }

    # DELETE SUPPLIER PACKAGE CATEGORY 
    public function deleteadminpackagecategory($id)
    {
        $check_count = DB::table('tbl_package')
            ->where('category_id', $id)
            ->count() ;

        if($check_count > 0)
        {
            Session::put('failed','Sorry! Category Already Have Package.');
            return back() ;
            exit() ;
        }

        DB::table('tbl_package_category')->where('id', $id)->delete() ;

        Session::put('success','Thanks! Package Delete Successfully');
        return back() ;
    }

    # ADMIN SUPPLIER PACKAGE LIST
    public function adminsupplierpackage()
    {
        $result = DB::table('tbl_package')
            ->join('tbl_package_category', 'tbl_package.category_id', '=', 'tbl_package_category.id')
            ->select('tbl_package.*', 'tbl_package_category.category_name')
            ->get();

        return view('admin.package.adminsupplierpackage')->with('result', $result) ;
    }

    # ADMIN SUPPLIER PACKAGE 
    public function addAdminPackage()
    {
        $result = DB::table('tbl_package_category')
            ->where('status', 1)
            ->get();

        return view('admin.package.addAdminPackage')->with('result', $result) ;
    }

    # INSERT ADMIN PACKAGE 
    public function insertadminpackage(Request $request)
    {
        $this->validate($request, [
            'category_id'               => 'required' ,
            'package_name'              => 'required' ,
            'package_duration'          => 'required' ,
            'package_price'             => 'required' ,
            'discount_percentage'       => 'required' ,
            'product_limit'             => 'required' ,
            'banner_update_status'      => 'required' ,
            'logo_update_status'        => 'required' ,
            'primary_category_limit'    => 'required' ,
            'seconday_category_limit'   => 'required' ,
            'slider_update_status'      => 'required' ,
            'social_media_status'       => 'required' ,
            'border_color'       => 'required' ,
        ]);

        $category_id                = trim($request->category_id) ;
        $package_name               = trim($request->package_name) ;
        $package_duration           = trim($request->package_duration) ;
        $package_price              = trim($request->package_price) ;
        $discount_percentage        = trim($request->discount_percentage) ;
        $product_limit              = trim($request->product_limit) ;
        $banner_update_status       = trim($request->banner_update_status) ;
        $logo_update_status         = trim($request->logo_update_status) ;
        $primary_category_limit     = trim($request->primary_category_limit) ;
        $seconday_category_limit    = trim($request->seconday_category_limit) ;
        $slider_update_status       = trim($request->slider_update_status) ;
        $social_media_status        = trim($request->social_media_status) ;
        $border_color        = trim($request->border_color) ;

        # DUPLICATE CHECK 
        $duplicate_count = DB::table('tbl_package')
            ->where('category_id', $category_id)
            ->where('package_name', $package_name)
            ->count() ;
        if ($duplicate_count > 0) {
            Session::put('failed', 'Sorry! Package name already exist.');
            return back() ;
            exit() ;
        }

        $data = array();
        $data['category_id']                = $category_id ;
        $data['package_name']               = $package_name ;
        $data['package_duration']           = $package_duration ;
        $data['package_price']              = $package_price ;
        $data['discount_percentage']        = $discount_percentage ;
        $data['product_limit']              = $product_limit ;
        $data['banner_update_status']       = $banner_update_status ;
        $data['logo_update_status']         = $logo_update_status ;
        $data['primary_category_limit']     = $primary_category_limit ;
        $data['seconday_category_limit']    = $seconday_category_limit ;
        $data['slider_update_status']       = $slider_update_status ;
        $data['social_media_status']        = $social_media_status ;
        $data['border_color']               = $border_color ;

        $data['status']             = 2 ;
        $data['created_at']         = $this->date_time ;

        DB::table('tbl_package')->insert($data);

        Session::put('success', 'Package Add Successfully') ;
        return back() ;
    }

    # EDIT ADMIN PACKAGE 
    public function editadminpackage($id)
    {
        $package_info = DB::table('tbl_package')->where('id', $id)->first() ;
        $all_category = DB::table('tbl_package_category')
            ->get() ;
        return view('admin.package.editadminpackage')->with('all_category', $all_category)->with('package_info', $package_info) ;
    }

    # UPDATE PACKAGE INFO 
    public function updateadminpackage(Request $request)
    {
        $this->validate($request, [
            'category_id'               => 'required' ,
            'package_name'              => 'required' ,
            'package_duration'          => 'required' ,
            'package_price'             => 'required' ,
            'discount_percentage'       => 'required' ,
            'product_limit'             => 'required' ,
            'banner_update_status'      => 'required' ,
            'logo_update_status'        => 'required' ,
            'primary_category_limit'    => 'required' ,
            'seconday_category_limit'   => 'required' ,
            'slider_update_status'      => 'required' ,
            'social_media_status'       => 'required' ,
            'border_color'              => 'required' ,
            'pacakge_logo'              => 'mimes:jpeg,jpg,png|max:100' ,
        ]);

        $category_id                = trim($request->category_id) ;
        $package_name               = trim($request->package_name) ;
        $package_duration           = trim($request->package_duration) ;
        $package_price              = trim($request->package_price) ;
        $discount_percentage        = trim($request->discount_percentage) ;
        $product_limit              = trim($request->product_limit) ;
        $banner_update_status       = trim($request->banner_update_status) ;
        $logo_update_status         = trim($request->logo_update_status) ;
        $primary_category_limit     = trim($request->primary_category_limit) ;
        $seconday_category_limit    = trim($request->seconday_category_limit) ;
        $slider_update_status       = trim($request->slider_update_status) ;
        $social_media_status        = trim($request->social_media_status) ;
        $border_color               = trim($request->border_color) ;
        $primary_id                 = $request->primary_id ;

        $package_info = DB::table('tbl_package')->where('id', $primary_id)->first() ;

        # DUPLICATE CHECK 
        $duplicate_count = DB::table('tbl_package')
            ->where('category_id', $category_id)
            ->where('package_name', $package_name)
            ->whereNotIn('id', [$primary_id])
            ->count() ;

        if ($duplicate_count > 0) {
            Session::put('failed', 'Sorry! Package name already exist.');
            return back() ;
            exit() ;
        }

        $data = array();
        $data['category_id']                = $category_id ;
        $data['package_name']               = $package_name ;
        $data['package_duration']           = $package_duration ;
        $data['package_price']              = $package_price ;
        $data['discount_percentage']        = $discount_percentage ;
        $data['product_limit']              = $product_limit ;
        $data['banner_update_status']       = $banner_update_status ;
        $data['logo_update_status']         = $logo_update_status ;
        $data['primary_category_limit']     = $primary_category_limit ;
        $data['seconday_category_limit']    = $seconday_category_limit ;
        $data['slider_update_status']       = $slider_update_status ;
        $data['social_media_status']        = $social_media_status ;
        $data['border_color']               = $border_color ;


        $data['updated_at']                 = $this->date_time ;
        DB::table('tbl_package')->where('id', $primary_id)->update($data);

        Session::put('success', 'Package Update Successfully') ;
        return Redirect::to('adminsupplierpackage') ;
    }

    # CHANGE PACKAGE STATUS 
    public function changepackagestatus(Request $request)
    {
        $pcakgeid = $request->packageid ;
        $package_info = DB::table('tbl_package')->where('id', $pcakgeid)->first() ;
        $main_status = $package_info->status ;

        if($main_status == 1)
        {
            $status = 2 ;
        }else{
            $status = 1;
        }

        $data = array();
        $data['status'] = $status ;
        $data['updated_at'] = $this->date_time ;

        DB::table('tbl_package')->where('id', $pcakgeid)->update($data) ;

        echo "success";
        exit() ;
    }

    # DELETE ADMIN PACKAGE 
    public function deleteaadminpackage($id)
    {
        # CHECK PACKAGE USE OR NOT 
        $check_count = DB::table('express')
            ->where('package_id', $id)
            ->count() ;

        if($check_count > 0)
        {
            Session::put('failed', 'Sorry! Package Have a active Seller');
            return back() ;
        }
        $package_info = DB::table('tbl_package')->where('id', $id)->first() ;
        if (file_exists($package_info->image)) {
            unlink($package_info->image) ;
        }

        DB::table('tbl_package')->where('id', $id)->delete() ;

        Session::put('success', 'Package Delete Successfully');
        return back() ;
    }
    
    # UPDATE PACKAGE BANNER 
    public function adminpackagebanner()
    {
        $banner_info = DB::table('tbl_package_banner')->first() ;
        return view('admin.package.adminpackagebanner')->with('banner_info', $banner_info) ;
    }

    public function updatepackagebanner(Request $request)
    {
        $this->validate($request, [
            'image'              => 'mimes:jpeg,jpg,png,svg' ,
        ]);
        $image  = $request->image ;


        $data   = array() ;
        if($image){
            $image_name        = Str::random(20);
            $ext               = strtolower($image->getClientOriginalExtension());
            $image_full_name   ='package-'.$image_name.'.'.$ext;
            $upload_path       = "public/images/";
            $image_url         = $upload_path.$image_full_name;
            $success           = $image->move($upload_path,$image_full_name);
            $data['image']     = $image_url;

           Image::make($image_url)->resize(1000, 450)->save($image_url) ;
        }

        $banner_info = DB::table('tbl_package_banner')->first() ;
        if($banner_info){
            DB::table('tbl_package_banner')->update($data) ;
        }else{
            DB::table('tbl_package_banner')->insert($data) ;
        }

        Session::put('success','Package Update Successfully');
        return back() ;
    }
    
    # SUPPLIER PACKAGE 
    public function supplierpackage()
    {
        $package_category_list  = DB::table('tbl_package_category')->where('status', 1)->get() ;
        $supplier_info          = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        return view('supplier.package.supplierpackage')->with('package_category_list', $package_category_list)->with('supplier_info', $supplier_info);   
    }
    
    # SUPPLIER PACKAGE UPDATE IFORMATOIN 
    public function supplierpackageupdate($id)
    {
        $package_info = DB::table('tbl_package')
            ->join('tbl_package_category', 'tbl_package.category_id', '=', 'tbl_package_category.id')
            ->select('tbl_package.*', 'tbl_package_category.duration_type')
            ->where('tbl_package.id', $id)
            ->first() ;
            
        $all_bank = DB::table('tbl_bank')->where('status', 1)->get() ;
        
        return view('supplier.package.supplierpackageupdate')->with('package', $package_info)->with('all_bank', $all_bank) ;
    }
    
    public function insertsupplierpackageupdateinformation(Request $request)
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
        
        $check_count = DB::table('tbL_package_update_history')
        ->where('status', 0)
        ->where('supplier_id', Session::get('supplier_id'))
        ->count() ;
        if($check_count > 0)
        {
            echo "package_exist";
            exit() ;
        }
        
        
        $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        
        $package_info = DB::table('tbl_package')->where('id', $package_id)->first() ;

        
        $payment_data                       = array();
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
        
        DB::table('tbL_package_update_history')->insert($payment_data) ;
        
        echo "success";
        exit() ;
    }
    
    # ADMIN ALL PENDING PACKAGE INFORMATION 
    public function adminsupplierpackageupdate()
    {
        $result = DB::table('tbL_package_update_history')
            ->join('express', 'tbL_package_update_history.supplier_id', '=', 'express.id')
            ->join('tbl_package', 'tbL_package_update_history.package_id', '=', 'tbl_package.id')
            ->select('tbL_package_update_history.*', 'express.storeName', 'express.email', 'tbl_package.package_name')
            ->orderBy('tbL_package_update_history.id', 'desc')
            ->where('tbL_package_update_history.status', 0)
            ->get() ;
            
        return view('admin.package.adminsupplierpackageupdate')->with('result', $result) ;
    }
    
    # SHOW SINGLE PENDING PACKAGE 
    public function showpackageupdatedetails(Request $request)
    {
        $primary_id = $request->primary_id ;
        
        $pacakge_value = DB::table('tbL_package_update_history')
            ->join('express', 'tbL_package_update_history.supplier_id', '=', 'express.id')
            ->join('tbl_package', 'tbL_package_update_history.package_id', '=', 'tbl_package.id')
            ->select('tbL_package_update_history.*', 'express.storeName', 'express.email', 'tbl_package.package_name', 'tbl_package.package_duration')
            ->where('tbL_package_update_history.id', $primary_id)
            ->first() ;
            
        return view('admin.package.showpackageupdatedetails')->with('pacakge_value', $pacakge_value) ;
    }
    
    # APPROVE SUPPLIER PACAKGE UDPATE INFORMATION 
    public function changesupplierpackageupdatestatus($primary_id, $type)
    {
        if($type == 2){
            $data = array();
            $data['status'] = 2;
            DB::table('tbL_package_update_history')->where('id', $primary_id)->update($data) ;
        }else{
            
            $update_info    = DB::table('tbL_package_update_history')->where('id', $primary_id)->first() ;
            $supplier_id    = $update_info->supplier_id ;
            $package_id     = $update_info->package_id ;
            
            $supplier_info = DB::table('express')->where('id', $supplier_id)->first() ;
        
            $package_info = DB::table('tbl_package')->where('id', $package_id)->first() ;
    
    
            $data = array();
            $data['package_id'] = $package_id;
            $data['updated_at'] = date('Y-m-d');
            DB::table('express')->where('id', $supplier_id)->update($data) ;
            
            $update_package_old             = array();
            $update_package_old['status']   = 2;
            DB::table('tbl_supplier_package_history')->where('supplier_id', $supplier_id)->update($update_package_old) ;
            
            
            
            $pacakge_data                           = array();
            $package_data['supplier_id']            = $supplier_id;
            $package_data['package_id']             = $package_id;
            $package_data['package_duration']       = $package_info->package_duration;
            $package_data['currency_id']            = $update_info->currency_id;
            $package_data['package_price']          = $package_info->package_price ;
            $package_data['discount_percentage']    = $package_info->discount_percentage;
            $package_data['status']                 = 1;
            
            DB::table('tbl_supplier_package_history')->insert($package_data);
            
            $last_package_info = DB::table('tbl_supplier_package_history')->orderBy('id', 'desc')->first() ;
            $main_package_id = $last_package_info->id ;
            
            $payment_data                       = array();
            $payment_data['package_main_id']    = $main_package_id;
            $payment_data['supplier_id']        = $supplier_id;
            $payment_data['package_id']         = $package_id;
            $payment_data['bank_id']            = $update_info->bank_id;
            $payment_data['branch_name']        = $update_info->branch_name;
            $payment_data['account_number']     = $update_info->account_number;
            $payment_data['package_amount']     = $package_info->package_price;
            $payment_data['discount_percentage'] =  $package_info->discount_percentage;
            $payment_data['final_amount']       =   $package_info->package_price-$package_info->discount_percentage;
            $payment_data['transaction_id']     =   $update_info->transaction_id;
            $payment_data['method_type']        =   $update_info->method_type;
            $payment_data['status']             = 1;
            $payment_data['receipt_copy'] = $update_info->receipt_copy;
            
            $payment_data['created_at'] = date("Y-m-d H:i:s") ;
            
            DB::table('tbl_supplier_pacakge_payment_history')->insert($payment_data) ;
            
            $data = array();
            $data['status'] = 1;
            DB::table('tbL_package_update_history')->where('id', $primary_id)->update($data) ;

        }  

        Session::put('success', 'Package Update Successfully');
        return back() ;
    }
    
    

}
