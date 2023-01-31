<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use Image;
use DB;
use Session;

class CategoryController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->loged_id     = Session::get('admin_id');
        $this->current_time = date("H:i:s");
    }

    public function mainCategoryList()
    {
    	$result = DB::table('tbl_primarycategory')->orderBy('category_name', 'asc')->get() ;

    	return view('categorys.mainCategoryList')->with('result', $result) ;
    }

    public function addPrimaryCategory()
    {
    	$media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->get() ;
    	return view('categorys.addPrimaryCategory')->with('media_result',$media_result) ;
    }


    public function getAllImages(Request $request)
    {
        $media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->paginate(24);
        return view('categorys.paginations')->with('media_result', $media_result);
    }

    public function dropzone()
    {
        return view('categorys.dropzone') ;
    }

    public function fileStore(Request $request)
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

    public function fileDestroy(Request $request)
    {
        $file_value = DB::table('tbl_media')->where('image', $filename)->first();
        if ($file_value->status == 0) {
            $filename =  $request->get('filename');
            DB::table('tbl_media')->where('image', $filename)->delete() ;
            $path=public_path().'/images/'.$filename;
            if (file_exists($path)) {
                unlink($path);
            }
            return $filename; 
        }
         
    }

    public function adminSaveImage(Request $request)
    {
        $data = array();
        $data['status'] = 1 ;

       $query =  DB::table('tbl_media')->where('supplier_id', 0)->update($data) ;
        echo $query;
    }

    public function getSearchValue(Request $request)
    {
        $search_keyword = $request->search_keyword ;
        if($search_keyword != ""){
            $media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->where('image', 'like', '%'.$search_keyword.'%')->paginate(24);
        }else{
            $media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->paginate(24);
        }
        
        return view('categorys.paginations')->with('media_result', $media_result);
    }
    
    public function getadminmediaimagepaginate(Request $request)
    {
        $search_keyword = $request->search_keyword ;
        
        if($request->ajax())
        {
            if($search_keyword != ""){
                $media_result = DB::table('tbl_media')->orderBy('id', 'desc')->where('status', 1)->where('image', 'like', '%'.$search_keyword.'%')->paginate(24);
            }else{
                $media_result = DB::table('tbl_media')
                ->orderBy('id', 'desc')
                ->where('status', 1)
                ->paginate(24);
            }
            
        
            return view('categorys.paginations')->with('media_result', $media_result);
        }
    }



    public function insertPrimaryCategoryInfo(Request $request)
    {
        
        $category_name = $request->category_name ;
        $category_icon = $request->category_icon ;

        if ($category_name == "" || $category_icon == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_primarycategory')
            ->where('category_name', $category_name)
            ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                   = array() ;
        $data['category_name']  = $category_name ;
        $data['catgeory_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        // $data['category_icon']  = $category_icon ;
        $data['status']         = 1 ;
        $data['created_at']     = $this->rcdate ;
        
        if ($request->hasFile('category_icon')) {
            $image = $request->file('category_icon');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(450,450)->save(base_path('public/images/mainCtegory/') . $new_image_name);
            $data['category_icon']  = $new_image_name;
        } 

       $query = DB::table('tbl_primarycategory')->insert($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function getAllPrimaryCategory(Request $request)
    {
        $result = DB::table('tbl_primarycategory')->orderBy('category_name', 'asc')->get() ;

        return view('categorys.mainCategoryData')->with('result', $result) ;
    }

    public function changeCategoryStatus(Request $request)
    {
        $category_id = $request->category_id ;

        $status_check   = DB::table('tbl_primarycategory')->where('id', $category_id)->first() ;
        $status         = $status_check->status ;

        if ($status == 1) {
            $db_status = 2 ;
        }else{
            $db_status = 1 ;
        }

        $data           = array() ;
        $data['status'] = $db_status ;
        $query = DB::table('tbl_primarycategory')->where('id', $category_id)->update($data) ;
        if ($db_status == 1) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
        }
        
    }

    public function editMainCategory(Request $request)
    {
        $id = $request->id ;
        $value   = DB::table('tbl_primarycategory')->where('id', $id)->first() ;

        return view('categorys.editMainCategory')->with('value', $value) ;
    }

    public function updatePrimaryCategoryInfo(Request $request)
    {
         $request->validate([
            'category_name' => 'required',
            'category_icon' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        $category_name  = $request->category_name ;
        $category_icon  = $request->category_icon ;
        $primary_id     = $request->primary_id ;
        
        $image = DB::table('tbl_primarycategory')->where('id', $primary_id)->first() ;

        if ($category_name == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $category_count = DB::table('tbl_primarycategory')
            ->where('category_name', $category_name)
            ->whereNotIn('id', [$primary_id])
            ->count() ;

        if ($category_count > 0) {
            echo "duplicate_found";
            exit() ;
        }

        $data                   = array() ;
        $data['category_name']  = $category_name ;
        $data['catgeory_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        
        if ($request->hasFile('category_icon')) {
            $image_path = public_path('images/mainCtegory/' .$image->category_icon);
         if ($image->category_icon && file_exists($image_path)) {
                    unlink($image_path);
                }
            
            $image = $request->file('category_icon');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(450,450)->save(base_path('public/images/mainCtegory/') . $new_image_name);
            $data['category_icon']  = $new_image_name;
        } 
        
        
        $data['created_at']     = $this->rcdate ;

       $query = DB::table('tbl_primarycategory')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function primaryCategoryDelete(Request $request)
    {
        $id = $request->id ;
        $nameimage = DB::table('tbl_primarycategory')->where('id', $id)->first() ;
        
        $count = DB::table('tbl_secondarycategory')->where('primary_category_id', $id)->count() ;
        if ($count > 0) {
            echo "cused" ;
            exit() ;
        }
        
        $image_path = public_path('images/mainCtegory/' .$nameimage->category_icon);
        if ($nameimage->category_icon && file_exists($image_path)) {
                    unlink($image_path);
                }

        $query = DB::table('tbl_primarycategory')->where('id', $id)->delete() ;
        if ($query) {
            echo "success" ;
            exit();
        }else{
            echo "failed" ;
            exit() ;
        }
    }



    #======================== SECONDARY CATEGORY SECTION ==============================#
    public function secondaryCategoryList()
    {
        
        $all_primarycategory = DB::table('tbl_primarycategory')->where('status', 1)->get() ;

        return view('categorys.secondaryCategoryList')->with('all_primarycategory', $all_primarycategory) ;

    }

    public function getAllSecondaryCategoryData(Request $request)
    {
        $result = DB::table('tbl_secondarycategory')
            ->join('tbl_primarycategory', 'tbl_secondarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->select('tbl_secondarycategory.*', 'tbl_primarycategory.category_name')
            ->orderBy('tbl_secondarycategory.id', 'desc')
            ->get() ;

        return view('categorys.getAllSecondaryCategoryData')->with('result', $result) ;
    }


    public function insertSecondaryCategoryInfo(Request $request)
    {
        $request->validate([
            'primary_category_id' => 'required',
            'category_name' => 'required',
            'category_icon' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $primary_category_id    = $request->primary_category_id ;
        $category_name          = $request->category_name ;
        $category_icon          = $request->category_icon ;
        
        
        $count = DB::table('tbl_secondarycategory')
            ->where('primary_category_id', $primary_category_id)
            ->where('secondary_category_name', $category_name)
            ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                               = array() ;
        $data['primary_category_id']        = $primary_category_id ;
        $data['secondary_category_name']    = $category_name ;
        $data['secondary_category_slug']    = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        $data['secondary_category_icon']    = $category_icon ;
        $data['status']                     = 1 ;
        $data['created_at']                 = $this->rcdate ;
        if ($request->hasFile('category_icon')) {
            $image = $request->file('category_icon');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(450,450)->save(base_path('public/images/secCetegroy/') . $new_image_name);
            $data['secondary_category_icon']  = $new_image_name;
        } 
    

       $query = DB::table('tbl_secondarycategory')->insert($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }


    public function changeSecondaryCategoryStatus(Request $request)
    {
        $category_id = $request->category_id ;

        $status_check   = DB::table('tbl_secondarycategory')->where('id', $category_id)->first() ;
        $status         = $status_check->status ;

        if ($status == 1) {
            $db_status = 2 ;
        }else{
            $db_status = 1 ;
        }

        $data           = array() ;
        $data['status'] = $db_status ;
        $query = DB::table('tbl_secondarycategory')->where('id', $category_id)->update($data) ;
        if ($db_status == 1) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
        }
    }

    public function editSecondaryCategory(Request $request)
    {
        $id = $request->id ;
        $value   = DB::table('tbl_secondarycategory')->where('id', $id)->first() ;
        $all_primarycategory = DB::table('tbl_primarycategory')->where('status', 1)->get() ;

        return view('categorys.editSecondaryCategory')->with('value', $value)->with('all_primarycategory', $all_primarycategory) ;
    }

    public function updateSecondaryCategoryInfo(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
            'category_icon' => 'mimes:jpeg,png,jpg,gif,svg',
        ]);
        $primary_category_id    = $request->primary_category_id ;
        $category_name          = $request->category_name ;
        $category_icon          = $request->category_icon ;
        $primary_id             = $request->primary_id ;

   $image = DB::table('tbl_secondarycategory')->where('id', $primary_id)->first() ;
   
        if ($category_name == "" || $primary_category_id == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_secondarycategory')
            ->where('primary_category_id', $primary_category_id)
            ->where('secondary_category_name', $category_name)
            ->whereNotIn('id', [$primary_id])
            ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                               = array() ;
        $data['primary_category_id']        = $primary_category_id ;
        $data['secondary_category_name']    = $category_name ;
        $data['secondary_category_slug']    = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        
        // if($category_icon){
        //     $data['secondary_category_icon']    = $category_icon ;
        // }
        $data['created_at']                 = $this->rcdate ;
        
        if ($request->hasFile('category_icon')) {
            $image_path = public_path('images/secCetegroy/' .$image->secondary_category_icon);
        if ($image->secondary_category_icon && file_exists($image_path)) {
                    unlink($image_path);
                }
            
            $image = $request->file('category_icon');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/secCetegroy/') . $new_image_name);
            $data['secondary_category_icon']  = $new_image_name;
        } 

       $query = DB::table('tbl_secondarycategory')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function secondaryCategoryDelete(Request $request)
    {
        $id = $request->id ;
        
        $image = DB::table('tbl_secondarycategory')->where('id', $id)->first() ;
         $image_path = public_path('images/secCetegroy/' .$image->secondary_category_icon);
        if ($image->secondary_category_icon && file_exists($image_path)) {
                    unlink($image_path);
                }
                
        $count = DB::table('tbl_tartiarycategory')->where('secondary_category_id', $id)->count() ;
        if ($count > 0) {
            echo "cused" ;
            exit() ;
        }

        $query = DB::table('tbl_secondarycategory')->where('id', $id)->delete() ;

        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }


    #========================== TERTIARY CATEGORY SECTION  ========================#
    public function tertiaryCategoryList()
    {
        $all_primarycategory = DB::table('tbl_primarycategory')->where('status', 1)->get() ;

        return view('categorys.tertiaryCategoryList')->with('all_primarycategory', $all_primarycategory) ;
    }

    public function getAllTertiaryCategoryData(Request $request)
    {
        $result = DB::table('tbl_tartiarycategory')
            ->join('tbl_primarycategory', 'tbl_tartiarycategory.primary_category_id', '=', 'tbl_primarycategory.id')
            ->join('tbl_secondarycategory', 'tbl_tartiarycategory.secondary_category_id', '=', 'tbl_secondarycategory.id')
            ->select('tbl_tartiarycategory.*', 'tbl_primarycategory.category_name', 'tbl_secondarycategory.secondary_category_name')
            ->orderBy('tbl_tartiarycategory.id', 'desc')
            ->get() ;

        return view('categorys.getAllTertiaryCategoryData')->with('result', $result) ;
    }

    public function getSecondaryCategoryByPrimaryCategory(Request $request)
    {
        $all_secondarycategory = DB::table('tbl_secondarycategory')
            ->where('primary_category_id', $request->primary_category_id)
            ->where('status', 1)
            ->get() ;

        return view('categorys.getSecondaryCategoryByPrimaryCategory')->with('all_secondarycategory', $all_secondarycategory) ;
    }

    public function insertTertiaryCategoryInfo(Request $request)
    {
        $primary_category_id        = $request->primary_category_id ;
        $secondary_category_id      = $request->secondary_category_id ;
        $category_name              = $request->category_name ;

        if ($category_name == "" || $secondary_category_id == ""|| $primary_category_id == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_tartiarycategory')
            ->where('primary_category_id', $primary_category_id)
            ->where('secondary_category_id', $secondary_category_id)
            ->where('tartiary_category_name', $category_name)
            ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                               = array() ;
        $data['primary_category_id']        = $primary_category_id ;
        $data['secondary_category_id']      = $secondary_category_id ;
        $data['tartiary_category_name']     = $category_name ;
        $data['tartiary_category_slug']     = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        $data['status']                     = 1 ;
        $data['created_at']                 = $this->rcdate ;

       $query = DB::table('tbl_tartiarycategory')->insert($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function changeTertiaryCategoryStatus(Request $request)
    {
        $category_id = $request->category_id ;

        $status_check   = DB::table('tbl_tartiarycategory')->where('id', $category_id)->first() ;
        $status         = $status_check->status ;

        if ($status == 1) {
            $db_status = 2 ;
        }else{
            $db_status = 1 ;
        }

        $data           = array() ;
        $data['status'] = $db_status ;
        $query = DB::table('tbl_tartiarycategory')->where('id', $category_id)->update($data) ;
        if ($db_status == 1) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
        }
    }


    public function editTertiaryCategory(Request $request)
    {
        $id = $request->id ;
        
        $value = DB::table('tbl_tartiarycategory')->where('id', $id)->first() ;


        $all_secondarycategory  = DB::table('tbl_secondarycategory')->where('primary_category_id', $value->primary_category_id)->where('status', 1)->get() ;

        $all_primarycategory = DB::table('tbl_primarycategory')->where('status', 1)->get() ;

        return view('categorys.editTertiaryCategory')->with('value', $value)->with('all_primarycategory', $all_primarycategory)->with('all_secondarycategory', $all_secondarycategory) ;
    }

    public function updateTertiaryCategoryInfo(Request $request)
    {
        $primary_category_id        = $request->primary_category_id ;
        $secondary_category_id      = $request->secondary_category_id ;
        $category_name              = $request->category_name ;
        $primary_id                 = $request->primary_id ;

        if ($category_name == "" || $secondary_category_id == ""|| $primary_category_id == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_tartiarycategory')
            ->where('primary_category_id', $primary_category_id)
            ->where('secondary_category_id', $secondary_category_id)
            ->where('tartiary_category_name', $category_name)
            ->whereNotIn('id', [$primary_id])
            ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                               = array() ;
        $data['primary_category_id']        = $primary_category_id ;
        $data['secondary_category_id']      = $secondary_category_id ;
        $data['tartiary_category_name']     = $category_name ;
        $data['tartiary_category_slug']     = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        $data['updated_at']                 = $this->rcdate ;

       $query = DB::table('tbl_tartiarycategory')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function tertiaryCategoryDelete(Request $request)
    {
        $id = $request->id ;

        $query = DB::table('tbl_tartiarycategory')->where('id', $id)->delete() ;

        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }

    #==================== SUPPLIER CATEGORY SECTION =====================#

    // supplier primary category

    public function supplierCategory()
    {
        $result = DB::table('tbl_supplier_primary_category')
            ->where('supplier_id', Session::get('supplier_id'))
            ->get() ;

        $secondary_result = DB::table('tbl_supplier_secondary_category')
            ->where('supplier_id', Session::get('supplier_id'))
            ->get() ;

        return view('categorys.supplier.supplierCategory')->with('result', $result)->with('secondary_result', $secondary_result) ;
    }

    public function supplierMainCategoryList()
    {
        return view('categorys.supplier.supplierMainCategoryList') ;
    }

    public function getSupplierMainCategory(Request $request)
    {
        $result = DB::table('tbl_supplier_primary_category')
            ->where('supplier_id', Session::get('supplier_id'))
            ->get() ;

        return view('categorys.supplier.getSupplierMainCategory')->with('result', $result) ;
    }

    public function insertSupplierPrimaryCategoryInfo(Request $request)
    {
        $category_name  = $request->category_name ;
        $supplier_id    = Session::get('supplier_id');
        
        $package_check = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        if($package_check->package_id == 0){
            echo "package_not_active";
            exit() ;
        }
        
        $package_info               = DB::table('tbl_package')->where('id',$package_check->package_id)->first() ;
        $primary_category_limit    = $package_info->primary_category_limit;
        
        # SUPPLIER SLIDER COUNT 
        $slider_count = DB::table('tbl_supplier_primary_category')->where('supplier_id', $supplier_id)->count() ;
    
        if($slider_count == $primary_category_limit){
            echo "limit_over";
            exit() ;
        }
        

        if ($category_name == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_supplier_primary_category')
            ->where('category_name', $category_name)
            ->where('supplier_id', Session::get('supplier_id'))
            ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                   = array() ;
        $data['supplier_id']    = Session::get('supplier_id') ;
        $data['category_name']  = $category_name ;
        $data['catgeory_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        $data['status']         = 1 ;
        $data['created_at']     = $this->rcdate ;

       $query = DB::table('tbl_supplier_primary_category')->insert($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function changeSupplierCategoryStatus(Request $request)
    {
        $category_id = $request->category_id ;

        $status_check   = DB::table('tbl_supplier_primary_category')->where('id', $category_id)->first() ;
        $status         = $status_check->status ;

        if ($status == 1) {
            $db_status = 2 ;
        }else{
            $db_status = 1 ;
        }

        $data           = array() ;
        $data['status'] = $db_status ;
        $query = DB::table('tbl_supplier_primary_category')->where('id', $category_id)->update($data) ;
        if ($db_status == 1) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }

    public function getSupplierCategoryById(Request $request)
    {
        $category_id = trim($request->id);
        $primary_query = DB::table('tbl_supplier_primary_category')->where('id', $category_id)->first() ;

        return view('categorys.supplier.getSupplierCategoryById')->with('primary_query', $primary_query);
    }

    public function updateSupplierPrimaryCategoryInfo(Request $request)
    {
        $category_name  = $request->category_name ;
        $primary_id     = $request->primary_id ;

        if ($category_name == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $category_count = DB::table('tbl_supplier_primary_category')
            ->where('category_name', $category_name)
            ->whereNotIn('id', [$primary_id])
            ->count() ;

        if ($category_count > 0) {
            echo "duplicate_found";
            exit() ;
        }

        $data                   = array() ;
        $data['category_name']  = $category_name ;
        $data['catgeory_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        $data['updated_at']     = $this->rcdate ;

       $query = DB::table('tbl_supplier_primary_category')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function supplierPrimaryCategoryDelete(Request $request)
    {
        $id = $request->id ;

        $count = DB::table('tbl_supplier_secondary_category')->where('primary_category_id', $id)->count() ;
        if ($count > 0) {
            echo "cused" ;
            exit() ;
        }

        $query = DB::table('tbl_supplier_primary_category')->where('id', $id)->delete() ;
        if ($query) {
            echo "success" ;
            exit();
        }else{
            echo "failed" ;
            exit() ;
        }
    }

    #====================== SUPPLIER SECONDARY CATEGORY =======================#
    public function supplierSecondaryCategoryList()
    {
        
    $result = DB::table('tbl_supplier_secondary_category')->where('supplier_id', Session::get('supplier_id'))->get() ;

        return view('categorys.supplier.supplierSecondaryCategoryList')->with('result', $result) ;
    }


    public function getSupplierSecondaryCategory(Request $request)
{

            $secondary_all = DB::table('tbl_supplier_secondary_category')
            ->join('tbl_supplier_primary_category', 'tbl_supplier_secondary_category.primary_category_id', '=', 'tbl_supplier_primary_category.id')
            ->select('tbl_supplier_secondary_category.*', 'tbl_supplier_primary_category.category_name')
            ->where('tbl_supplier_secondary_category.supplier_id', Session::get('supplier_id'))
            ->get() ;

        return view('categorys.supplier.getSupplierSecondaryCategory')->with('secondary_all', $secondary_all) ;
    }

    public function getSupplierSecondaryWhenCategory(Request $request)
    {

            $secondary_all = DB::table('tbl_supplier_secondary_category')
            ->join('tbl_supplier_primary_category', 'tbl_supplier_secondary_category.primary_category_id', '=', 'tbl_supplier_primary_category.id')
            ->select('tbl_supplier_secondary_category.*', 'tbl_supplier_primary_category.category_name')
            ->where('tbl_supplier_secondary_category.supplier_id', Session::get('supplier_id'))
            ->get() ;


        return view('categorys.supplier.getSupplierSecondaryCategory')->with('secondary_all', $secondary_all) ;
    }

    public function insertSupplierSecondaryCategoryInfo(Request $request)
    {
        $main_category_id        = $request->main_category_id ;
        $category_name           = $request->secondary_category_name ;
        $supplier_id            = Session::get('supplier_id') ;

        if ($category_name == ""|| $main_category_id == "") {
            echo "invalid_input" ;
            exit() ;
        }
        
        $package_check = DB::table('express')->where('id', Session::get('supplier_id'))->first() ;
        if($package_check->package_id == 0){
            echo "package_not_active";
            exit() ;
        }
        
        $package_info              = DB::table('tbl_package')->where('id',$package_check->package_id)->first() ;
        $seconday_category_limit    = $package_info->seconday_category_limit;
        
        # SUPPLIER SLIDER COUNT 
        $slider_count = DB::table('tbl_supplier_secondary_category')
            ->where('primary_category_id', $main_category_id)
            ->where('supplier_id', $supplier_id)
            ->count() ;
    
        if($slider_count == $seconday_category_limit){
            echo "limit_over";
            exit() ;
        }

        $count = DB::table('tbl_supplier_secondary_category')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('secondary_category_name', $category_name)
            ->where('primary_category_id', $main_category_id)
            ->count();
        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                               = array() ;
        $data['supplier_id']                = Session::get('supplier_id') ;
        $data['primary_category_id']        = $main_category_id ;
        $data['secondary_category_name']    = $category_name ;
        $data['secondary_category_slug']    = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        $data['status']                     = 1 ;
        $data['created_at']                 = $this->rcdate ;

       $query = DB::table('tbl_supplier_secondary_category')->insert($data) ;
        if ($query) {
            echo "success" ;
        }else{
            echo "failed" ;
        }
    }

    public function getSuppllierAllMainCategory(Request $request)
    {
        $maincategory = DB::table('tbl_supplier_primary_category')->where('supplier_id', Session::get('supplier_id'))->get() ;

        echo '<option value="">Select Main Category</option>' ;
        foreach ($maincategory as $catvalue) {
            echo '<option value="'.$catvalue->id.'">'.$catvalue->category_name.'</option>';
        }
    }

    public function changeSupplierSecodnaryCategoryStatus(Request $request)
    {
        $category_id = $request->category_id ;

        $status_check   = DB::table('tbl_supplier_secondary_category')->where('id', $category_id)->first() ;
        $status         = $status_check->status ;

        if ($status == 1) {
            $db_status = 2 ;
        }else{
            $db_status = 1 ;
        }

        $data           = array() ;
        $data['status'] = $db_status ;
        $query = DB::table('tbl_supplier_secondary_category')->where('id', $category_id)->update($data) ;
        if ($db_status == 1) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }

    public function secondarycategoryeditfrom(Request $request)
    {
        $id = $request->id;

        $priamry_all = DB::table('tbl_supplier_primary_category')->where('supplier_id', Session::get('supplier_id'))->get() ;

        $secondary_value = DB::table('tbl_supplier_secondary_category')
            ->where('tbl_supplier_secondary_category.supplier_id', Session::get('supplier_id'))
            ->where('tbl_supplier_secondary_category.id', $id)
            ->first() ;

        return view('categorys.supplier.secondarycategoryeditfrom')->with('priamry_all', $priamry_all)->with('secondary_value', $secondary_value) ;
    }

    public function updateSupplierSecodnaryCategoryInfo(Request $request)
    {
        $main_category_id        = $request->main_category_id ;
        $category_name           = $request->category_name ;
        $primary_id           = $request->primary_id ;

        if ($category_name == ""|| $main_category_id == "") {
            echo "invalid_input" ;
            exit() ;
        }

        $count = DB::table('tbl_supplier_secondary_category')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('secondary_category_name', $category_name)
            ->where('primary_category_id', $main_category_id)
            ->whereNotIn('id', [$primary_id])
            ->count();

        if ($count > 0) {
            echo "duplicate_found" ;
            exit() ;
        }

        $data                               = array() ;
        $data['primary_category_id']        = $main_category_id ;
        $data['secondary_category_name']    = $category_name ;
        $data['secondary_category_slug']    = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', $category_name)) ;
        $data['updated_at']                 = $this->rcdate ;

       $query = DB::table('tbl_supplier_secondary_category')->where('id', $primary_id)->update($data) ;
        if ($query) {
            echo "success" ;
            exit() ;
        }else{
            echo "failed" ;
            exit() ;
        }
    }

    public function deleteSecondaryCategory(Request $request)
    {
        $id = $request->id ;
        $query = DB::table('tbl_supplier_secondary_category')->where('id', $id)->delete() ;
        if ($query) {
            echo "success" ;
            exit();
        }else{
            echo "failed" ;
            exit() ;
        }
    }  
}
