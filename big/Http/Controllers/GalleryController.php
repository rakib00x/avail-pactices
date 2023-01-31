<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;
use Image;


class GalleryController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->current_time = date("H:i:s");
        $this->random_number_one = rand(10000 , 99999).mt_rand(1000000000, 9999999999);
    }

    public function getAllImagesForMetaImage(Request $request)
    {
    	$media_result = DB::table('tbl_media')
    		->orderBy('id', 'desc')
    		->where('status', 1)
    		->where('supplier_id', Session::get('supplier_id'))
    		->get();
        return view('supplier.media.getAllImagesForMetaImage')->with('media_result', $media_result);
    }

    public function uploadSupplierMetaImage(Request $request)
    {

        ini_set('memory_limit','1020M');
        $image      = $request->file('file');

        $file   = $image->getClientOriginalName();
        $filename   = pathinfo($file, PATHINFO_FILENAME);
        $imageName  = rand(11111, 99999)."-".$filename.".webp";

        $image->move(public_path('images/'),$imageName);
        $image_name_with_path = public_path().'/images/'.$imageName ;

        $img = Image::make($image_name_with_path)->encode('webp');
        $img->resize(500, 500,function ($constraint) {
            $constraint->aspectRatio();
        })->save($image_name_with_path);

        $data                   = array() ;
        $data['supplier_id']    = Session::get('supplier_id') ;
        $data['image']          = $imageName ;
        $data['status']         = 0 ;
        $data['created_at']     = $this->rcdate ;

        DB::table('tbl_media')->insert($data) ;
    
        return response()->json(['success'=>$imageName]);
    }

    public function deleteMetaImages(Request $request)
    {
        $filename = $request->filename;
        
    	$file_value = DB::table('tbl_media')
    		->where('supplier_id', Session::get('supplier_id'))
    		->where('image', $filename)
    		->first();

        if ($file_value->status == 0) {
            $filename =  $request->get('filename');
            DB::table('tbl_media')
            ->where('supplier_id', Session::get('supplier_id'))
    		->where('image', $filename)
            ->delete() ;

            $path=public_path().'/images/'.$filename;
            if (file_exists($path)) {
                unlink($path);
            }
            return $filename; 
        }
    }

    public function supplierSaveImage(Request $request)
    {
    	$data 			= array();
        $data['status'] = 1 ;
       	$query =  DB::table('tbl_media')->where('supplier_id', Session::get('supplier_id'))->update($data) ;

        echo $query;
    }


    # GET SUPPLIER IMAGE FOR PRODUCT 
    public function getAllSupplierImageForProduct(Request $request)
    {
    	$media_result = DB::table('tbl_media')
    		->orderBy('id', 'desc')
    		->where('status', 1)
    		->where('supplier_id', Session::get('supplier_id'))
    		->paginate(24);
    	
        return view('supplier.media.getAllSupplierImageForProduct')->with('media_result', $media_result);
    }
    
     public function getAllproMobileMedia(Request $request)
     {
    	$media_result = DB::table('tbl_media')
    		->orderBy('id', 'desc')
    		->where('status', 1)
    		->where('supplier_id', Session::get('supplier_id'))
    		->paginate(24);
    	
        return view('supplier.media.getAllsupllierProductimageMobile')->with('media_result', $media_result);
    }

    public function getProductImagePagination(Request $request)
    {
        if($request->ajax())
        {
            $media_result = DB::table('tbl_media')
    		->orderBy('id', 'desc')
    		->where('status', 1)
    		->where('supplier_id', Session::get('supplier_id'))
    		->paginate(24);
    	
            return view('supplier.media.getAllSupplierImageForProduct')->with('media_result', $media_result);
        }
    }
    
    public function getAllSupplierSingleImage()
    {
        $media_result = DB::table('tbl_media')
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->where('supplier_id', Session::get('supplier_id'))
            ->get();

        return view('supplier.media.supplierSingleMedia')->with('media_result', $media_result);
    }

    public function supplierMediaImageSearch(Request $request)
    {
        $search_keyword = trim($request->search_keyword) ;

        if ($search_keyword != "") {
            $media_result = DB::table('tbl_media')
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('image', 'like', '%'.$search_keyword.'%')
            ->get();
        }else{
            $media_result = DB::table('tbl_media')
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->where('supplier_id', Session::get('supplier_id'))
            ->get();
        }

        return view('supplier.media.supplierSingleMedia')->with('media_result', $media_result);
    }


    public function getSupplierProductColorImage()
    {
        $media_result = DB::table('tbl_media')
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->where('supplier_id', Session::get('supplier_id'))
            ->paginate(24);
        
        return view('supplier.media.getSupplierProductColorImage')->with('media_result', $media_result);
    }

    public function getProductColorImagePagination(Request $request){
        if($request->ajax())
        {
            $media_result = DB::table('tbl_media')
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->where('supplier_id', Session::get('supplier_id'))
            ->paginate(24);
        
        return view('supplier.media.getSupplierProductColorImage')->with('media_result', $media_result);
        }
    }


    # SUPPLIER IMAGE LIST 

    public function supplierMedia()
    {
        $result = DB::table('tbl_media')
            ->where('supplier_id', Session::get('supplier_id'))
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->paginate(24);

        return view('supplier.media.supplierMedia')->with('result', $result) ;
    }

    public function getMediaSearchValue(Request $request)
    {
        $search_value = $request->search_value ;

        $result = DB::table('tbl_media')
            ->where('image', 'like', '%'.$search_value.'%')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 1)
            ->paginate(24);

        return view('supplier.media.getMediaPagnationResult')->with('result', $result) ;
    }

    // product search pagination
    public function getMediaPagnationResult(Request $request)
    {

        $search_value = $request->search_value ;
        if($request->ajax())
        {
            $result = DB::table('tbl_media')
            ->where('image', 'like', '%'.$search_value.'%')
            ->where('supplier_id', Session::get('supplier_id'))
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->paginate(24);

            return view('supplier.media.getMediaPagnationResult')->with('result', $result) ;
        }
    }


    public function getTrashMediaSearchValue(Request $request)
    {
        $search_value = $request->search_value ;

        $result = DB::table('tbl_media')
        ->where('image', 'like', '%'.$search_value.'%')
        ->where('supplier_id', Session::get('supplier_id'))
        ->where('status', 2)
        ->paginate(24);

    return view('supplier.media.getMediaTrashPagnationResult')->with('result', $result) ;
    }


    public function supplierMediaStatusChange(Request $request)
    {
        $image_id = $request->id ;

        $image_info = DB::table('tbl_media')->where('id', $image_id)->first() ;

        $product_image  = DB::table('tbl_product')
        ->where('supplier_id', Session::get('supplier_id'))
        ->get();

        foreach ($product_image as $product_images) {
            if ($product_images->products_image != "") {
               $product_image_name = explode("#", $product_images->products_image) ;
               foreach ($product_image_name as $image_name) {
                   if ($image_name != "" && $image_name == $image_info->image) {
                        echo "product_image_exit";
                        exit() ;
                   }
               }
            }
        }


        $image_check  = DB::table('tbl_product')
        ->where('meta_image', 'like', '%'.$image_info->image.'%')
        ->where('supplier_id', Session::get('supplier_id'))
        ->count();


        $image_check  = DB::table('tbl_product_color')
        ->where('color_image', 'like', '%'.$image_info->image.'%')
        ->where('supplier_id', Session::get('supplier_id'))
        ->count();


        if($image_check > 0){
            echo "product_image_exit";
            exit() ;
        }

        if ($image_info->select_status == 0) {
            $status = 1;
        }else{
            $status = 0;
        } 

        $data                   = array() ;
        $data['select_status']  = $status ;
        $data['updated_at']     = $this->rcdate ;
        DB::table('tbl_media')->where('id', $image_id)->update($data) ;

        echo $status ;
    }

    public function deleteSupplierMediaImages(Request $request)
    {

        $all_media = DB::table('tbl_media')
            ->where('select_status', 1)
            ->where('supplier_id', Session::get('supplier_id'))
            ->get();

        foreach ($all_media as $media_value) {

            $image_info = DB::table('tbl_media')->where('id', $media_value->id)->first() ;

            $product_image_check  = DB::table('tbl_product')
            ->where('supplier_id', Session::get('supplier_id'))
            ->get();

            foreach ($product_image_check as $product_images) {
                if ($product_images->products_image != "") {
                   $product_image_name = explode("#", $product_images->products_image) ;
                   foreach ($product_image_name as $image_name) {
                       if ($image_name != "" && $image_name == $image_info->image) {
                            echo "product_image_exit";
                            exit() ;
                       }
                   }
                }
            }

            $image_check  = DB::table('tbl_product')
            ->where('meta_image', 'like', '%'.$image_info->image.'%')
            ->where('supplier_id', Session::get('supplier_id'))
            ->count();


            $image_check_1  = DB::table('tbl_product_color')
            ->where('color_image', 'like', '%'.$image_info->image.'%')
            ->where('supplier_id', Session::get('supplier_id'))
            ->count();


            if($image_check > $image_check_1){
                echo "product_image_exit";
                exit() ;
            }

        }


        foreach ($all_media as $media_values) {
            $data                   = array() ;
            $data['status']         = 2 ;
            $data['select_status']  = 0 ;
            $data['updated_at']     = $this->rcdate ;
            DB::table('tbl_media')->where('id', $media_values->id)->update($data) ;
        }

        echo "success" ;
    }


    public function supplierMediaSelectReset(Request $request)
    {
        $all_media = DB::table('tbl_media')
            ->where('select_status', 1)
            ->where('supplier_id', Session::get('supplier_id'))
            ->get();


        foreach ($all_media as $media_values) {
            $data                   = array() ;
            $data['select_status']  = 0 ;
            $data['updated_at']     = $this->rcdate ;
            DB::table('tbl_media')->where('id', $media_values->id)->update($data) ;
        }


        echo "success" ;
    }



    public function supplierMediaTrash()
    {
        $result = DB::table('tbl_media')
            ->where('supplier_id', Session::get('supplier_id'))
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->paginate(24);

        return view('supplier.media.supplierMediaTrash')->with('result', $result) ;
    }

    public function getMediaTrashPagnationResult(Request $request)
    {
        $search_value = $request->search_value ;
        if($request->ajax())
        {
            $result = DB::table('tbl_media')
            ->where('image', 'like', '%'.$search_value.'%')
            ->where('supplier_id', Session::get('supplier_id'))
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->paginate(24);

            return view('supplier.media.getMediaTrashPagnationResult')->with('result', $result) ;
        }
    }

    public function supplierTrashImageRestore(Request $request)
    {

        $all_media = DB::table('tbl_media')->where('status', 2)->where('select_status', 1)->where('supplier_id', Session::get('supplier_id'))->get() ;

        foreach ($all_media as $value) {
            $data                   = array() ;
            $data['status']         = 1 ;
            $data['select_status']  = 0 ;
            DB::table('tbl_media')->where('id', $value->id)->update($data) ;
        }
        
        echo "success" ;
    }

    public function deleteSupplierAllTrashImage(Request $request)
    {
        $all_result = DB::table('tbl_media')
            ->where('supplier_id', Session::get('supplier_id'))
            ->where('status', 2)
            ->where('select_status', 1)
            ->get() ;

        foreach($all_result as $value){
            $imga_url = "public/images/".$value->image ;
            if ($value->image != "") {
                unlink($imga_url) ;
            }
            DB::table('tbl_media')->where('id', $value->id)->delete() ;
        }

        echo "success" ;
    }


    # ADMIN MEDIA 
    public function adminMedia()
    {
        $result = DB::table('tbl_media')
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->paginate(24);

        return view('admin.media.adminMedia')->with('result', $result) ;
    }

    # ADMIN MEDIA PAGINATION
    public function mediaPaginationForAdmin(Request $request)
    {

        $search_value = $request->search_value ;
        if($request->ajax())
        {
            $result = DB::table('tbl_media')
            ->where('image', 'like', '%'.$search_value.'%')
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->paginate(24);

            return view('admin.media.mediaPaginationForAdmin')->with('result', $result) ;
        }
    }

    # ADMIN MEDIA SEARCH
    public function getAdminMediaSearchValue(Request $request)
    {
        $search_value = $request->search_value ;

        $result = DB::table('tbl_media')
            ->where('image', 'like', '%'.$search_value.'%')
            ->where('status', 1)
            ->paginate(24);

        return view('admin.media.getAdminMediaSearchValue')->with('result', $result) ;
    }

    # CHANGE ADMIN GALLERY IMAGE 
    public function adminMediaStatusChange(Request $request)
    {
        $image_id = $request->id ;
        $image_info = DB::table('tbl_media')->where('id', $image_id)->first() ;
        $image_name = $image_info->image ;
        

        $image_count_1 = DB::table('tbl_primarycategory')
            ->where('category_icon', $image_name)
            ->count() ;

        $image_count_2 = DB::table('tbl_secondarycategory')
            ->where('secondary_category_icon', $image_name)
            ->count() ;

        $image_count_3 = DB::table('tbl_meta_tags')
            ->where('meta_image', $image_name)
            ->count() ;

        $image_count_4 = DB::table('tbl_shipping')
            ->where('logo', $image_name)
            ->count() ;

        $image_count_5 = DB::table('tbl_bank')
            ->where('bank_logo', $image_name)
            ->count() ;

        $image_count_6 = DB::table('tbl_payment_method')
            ->where('logo', $image_name)
            ->count() ;

        $image_count_7 = DB::table('tbl_popup_ads')
            ->where('ads_image', $image_name)
            ->count() ;

        $image_count_8 = DB::table('tbl_category_ads')
            ->where('ads_image', $image_name)
            ->count() ;

        $image_count_9 = DB::table('tbl_slider')
            ->where('slider_image', $image_name)
            ->count() ;

        $image_count_10 = DB::table('tbl_category_slider')
            ->where('slider_image', $image_name)
            ->count() ;


        $image_count_11 = DB::table('express')
            ->where('image', $image_name)
            ->count() ;

        if ($image_count_1 > 0 || $image_count_2 > 0 || $image_count_3 > 0 || $image_count_4 > 0 || $image_count_5 > 0 || $image_count_6 > 0 || $image_count_7 > 0 || $image_count_8 > 0 || $image_count_9 > 0 || $image_count_10 > 0 || $image_count_11 > 0) {
            echo "product_image_exit" ;
            exit() ;
        }



        $product_image  = DB::table('tbl_product')
        ->get();

        foreach ($product_image as $product_images) {
            if ($product_images->products_image != "") {
               $product_image_name = explode("#", $product_images->products_image) ;
               foreach ($product_image_name as $image_name) {
                   if ($image_name != "" && $image_name == $image_info->image) {
                        echo "product_image_exit";
                        exit() ;
                   }
               }
            }
        }


        $image_check  = DB::table('tbl_product')
        ->where('meta_image', 'like', '%'.$image_info->image.'%')
        ->count();


        $image_check_1  = DB::table('tbl_product_color')
        ->where('color_image', 'like', '%'.$image_info->image.'%')
        ->count();


        if($image_check > 0 || $image_check_1 > 0){
            echo "product_image_exit";
            exit() ;
        }

        if ($image_info->select_status == 0) {
            $status = 1;
        }else{
            $status = 0;
        }

        $data                   = array() ;
        $data['select_status']  = $status ;
        $data['updated_at']     = $this->rcdate ;
        DB::table('tbl_media')->where('id', $image_id)->update($data) ;

        echo $status ;
    }

    public function adminMediaSelectReset(Request $request)
    {
        $all_media = DB::table('tbl_media')
            ->where('select_status', 1)
            ->get();

        foreach ($all_media as $media_values) {
            $data                   = array() ;
            $data['select_status']  = 0 ;
            $data['updated_at']     = $this->rcdate ;
            DB::table('tbl_media')->where('id', $media_values->id)->update($data) ;
        }

        echo "success" ;
    }


    public function deleteAdminMediaImages(Request $request)
    {
        $all_media = DB::table('tbl_media')
            ->where('select_status', 1)
            ->get();
            

        foreach ($all_media as $media_value) {

            $image_id = $request->id ;
            $image_info = DB::table('tbl_media')->where('id', $media_value->id)->first() ;
            $image_name = $image_info->image ;
            

            $image_count_1 = DB::table('tbl_primarycategory')
                ->where('category_icon', $image_name)
                ->count() ;

            $image_count_2 = DB::table('tbl_secondarycategory')
                ->where('secondary_category_icon', $image_name)
                ->count() ;

            $image_count_3 = DB::table('tbl_meta_tags')
                ->where('meta_image', $image_name)
                ->count() ;

            $image_count_4 = DB::table('tbl_shipping')
                ->where('logo', $image_name)
                ->count() ;

            $image_count_5 = DB::table('tbl_bank')
                ->where('bank_logo', $image_name)
                ->count() ;

            $image_count_6 = DB::table('tbl_payment_method')
                ->where('logo', $image_name)
                ->count() ;

            $image_count_7 = DB::table('tbl_popup_ads')
                ->where('ads_image', $image_name)
                ->count() ;

            $image_count_8 = DB::table('tbl_category_ads')
                ->where('ads_image', $image_name)
                ->count() ;

            $image_count_9 = DB::table('tbl_slider')
                ->where('slider_image', $image_name)
                ->count() ;

            $image_count_10 = DB::table('tbl_category_slider')
                ->where('slider_image', $image_name)
                ->count() ;


            $image_count_11 = DB::table('express')
                ->where('image', $image_name)
                ->count() ;

            if ($image_count_1 > 0 || $image_count_2 > 0 || $image_count_3 > 0 || $image_count_4 > 0 || $image_count_5 > 0 || $image_count_6 > 0 || $image_count_7 > 0 || $image_count_8 > 0 || $image_count_9 > 0 || $image_count_10 > 0) {
                echo "product_image_exit" ;
                exit() ;
            }
        }


        $product_image  = DB::table('tbl_product')
        ->get();

        foreach ($product_image as $product_images) {
            if ($product_images->products_image != "") {
               $product_image_name = explode("#", $product_images->products_image) ;
               foreach ($product_image_name as $image_name) {
                   if ($image_name != "" && $image_name == $image_info->image) {
                        echo "product_image_exit";
                        exit() ;
                   }
               }
            }
        }


        $image_check  = DB::table('tbl_product')
        ->where('meta_image', 'like', '%'.$image_info->image.'%')
        ->count();


        $image_check_1  = DB::table('tbl_product_color')
        ->where('color_image', 'like', '%'.$image_info->image.'%')
        ->count();


        if($image_check > 0 || $image_check_1 > 0){
            echo "product_image_exit 222";
            exit() ;
        }

        foreach ($all_media as $media_values) {
            $data                   = array() ;
            $data['status']         = 2 ;
            $data['select_status']  = 0 ;
            $data['updated_at']     = $this->rcdate ;
            DB::table('tbl_media')->where('id', $media_values->id)->update($data) ;
        }

        echo "success" ;
    }

    # ADMIN MEIDA TRASH 
    public function adminMediaTrash()
    {
        $result = DB::table('tbl_media')
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->paginate(24);

        return view('admin.media.adminMediaTrash')->with('result', $result) ;
    }

    # ADMIN MEDIA IMAGE RESTORE 
    public function adminTrashImageRestore(Request $request)
    {
        $all_media = DB::table('tbl_media')
            ->where('status', 2)
            ->where('select_status', 1)
            ->get() ;

        foreach ($all_media as $value) {
            $data                   = array() ;
            $data['status']         = 1 ;
            $data['select_status']  = 0 ;
            DB::table('tbl_media')->where('id', $value->id)->update($data) ;
        }
        
        echo "success" ;
    }

    # DELETE ADMIN TRASH IMAGE DELETE 
    public function deleteAdminAllTrashImage(Request $request)
    {
        $all_result = DB::table('tbl_media')
            ->where('status', 2)
            ->where('select_status', 1)
            ->get() ;

        foreach($all_result as $value){
            $imga_url = "public/images/".$value->image ;
            if ($value->image != "") {
                unlink($imga_url) ;
            }
            DB::table('tbl_media')->where('id', $value->id)->delete() ;
        }

        echo "success" ;
    }

    public function getAdminMediaTrashPagnationResult(Request $request)
    {
        $search_value = $request->search_value ;
        if($request->ajax())
        {
            $result = DB::table('tbl_media')
            ->where('image', 'like', '%'.$search_value.'%')
            ->orderBy('id', 'desc')
            ->where('status', 2)
            ->paginate(24);

            return view('admin.media.getAdminMediaTrashPagnationResult')->with('result', $result) ;
        }
    }

    public function getAdminTrashMediaSearchValue(Request $request)
    {
        $search_value = $request->search_value ;
        $result = DB::table('tbl_media')
            ->where('image', 'like', '%'.$search_value.'%')
            ->where('status', 2)
            ->paginate(24);

        return view('admin.media.getAdminTrashMediaSearchValue')->with('result', $result) ;
    }


    # all banner 
    public function allbanner()
    {
        $result = DB::table('tbl_banner')
            ->get() ;

        return view('banner.allbanner')->with('result', $result);
    }

    # ADD BANNER IMAGE 
    public function addBannerImage()
    {
        return view('banner.addBannerImage') ;
    }

    # SAVE BANNER IMAGE INFO 
    public function savebannerimageinfo(Request $request)
    {
        $this->validate($request, [
            'image'              => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data                   = array() ;
        $data['status']         = 0 ;
        $data['created_at']     = $this->rcdate ;
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/Banner/') . $new_image_name);
            $data['image']  = $new_image_name;
        } 

        DB::table('tbl_banner')->insert($data) ;
    
        echo "success" ;
        exit() ;
    }

    # EDIT GALLERY 
    public function editbanner(Request $request)
    {
        $banner_id = $request->banner_id ;

        $value = DB::table('tbl_banner')
            ->where('id', $banner_id)
            ->first() ;

        return view('banner.editbanner')->with('value', $value) ;
    }

    # update banner info 
    public function updatebannerimageinfo(Request $request)
    {
        $this->validate($request, [
            'image'              => 'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        $primary_id = $request->primary_id ;

         $image = DB::table('tbl_banner')->where('id', $primary_id)->first() ;

        $data                   = array() ;
        $data['updated_at']     = $this->rcdate ;
        
        if ($request->hasFile('image')) {
             $image_path = public_path('images/Banner/' .$image->image);
             if ($image->image && file_exists($image_path)) {
                    unlink($image_path);
                }
             $image = $request->file('image');
             $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
             Image::make($image)->resize(1000,450)->save(base_path('public/images/Banner/') . $new_image_name);
            $data['image']  = $new_image_name;
        } 

       DB::table('tbl_banner')->where('id', $primary_id)->update($data) ;
        echo "success" ;
        
        exit() ;
    }

    # change banner status 
    public function changeBannerStatus(Request $request)
    {
        $banner_id = $request->banner_id ;

        $banner_info = DB::table('tbl_banner')->where('id', $banner_id)->first() ;
        $status = $banner_info->status ;

        if ($status == 1) {
            $status_main = 0;
            echo "failed" ;
        }else{
            $status_main = 1;
            echo "success" ;
        }

        $data = array() ;
        $data['status']         = $status_main ;
        $data['updated_at']     = $this->rcdate ;

        DB::table('tbl_banner')->where('id', $banner_id)->update($data);
    }

    # delete banner 
    public function deleteBannerInfo($id)
    {

        $banner_info = DB::table('tbl_banner')->where('id', $id)->first() ;
         $image_path = public_path('images/Banner/' .$banner_info->image);
             if ($banner_info->image && file_exists($image_path)) {
                    unlink($image_path);
                }

        DB::table('tbl_banner')->where('id', $id)->delete();
        Session::put('success', 'Banner Image Delete Successfully');
        return Redirect::to('allbanner');
    }

    public function deleteallmedia()
    {
        $result = DB::table('tbl_media')->get() ;
        foreach($result as $value)
        {

            $image = "public/images/".$value->image ;
            if(file_exists($image)){
                unlink($image);
            }

            DB::table('tbl_media')->where('id', $value->id)->delete() ;
        }

        echo "success" ;
    }
    
    public function upload_seller_meta(Request $request)
    {
        $check_count = DB::table('tbl_media')->where('supplier_id', Session::get('supplier_id'))->count();
        if($check_count > 5){

            return $check_count;
            exit();
        }
        $image      = $request->file('file');
        $imageName  = $image->getClientOriginalName();
        $image->move(public_path('images/'),$imageName);
        
        $image_name_with_path   = 'public/images/'.$imageName ;
        Image::make($image_name_with_path)->fit(1000)->save($image_name_with_path) ;

        $data                   = array() ;
        $data['supplier_id']    = Session::get('supplier_id') ;
        $data['image']          = $imageName ;
        $data['status']         = 0 ;
        $data['created_at']     = $this->rcdate ;

        DB::table('tbl_media')->insert($data) ;
    
        return response()->json(['success'=>$imageName]);
    }

    
    public function sellerSaveImage(Request $request)
    {
        $data 			= array();
        $data['status'] = 1 ;
       	$query          =  DB::table('tbl_media')->where('supplier_id', Session::get('supplier_id'))->update($data) ;

        $result = DB::table('tbl_media')->where('supplier_id', Session::get('supplier_id'))->limit(5)->get();
        return view('seller.gallery.sellerSaveImage', compact('result'));
    }
    
    public function imageresize($image){
        $image_name_with_path = 'public/images/siam/'.$image ;
        
        $img = Image::make($image_name_with_path);
        $img->fit(1000, function ($constraint) {
            $constraint->aspectRatio();
        })->save($image_name_with_path);
    }
    
    public function resize_imagejpg($file, $w, $h) {
       list($width, $height) = getimagesize($file);
       $src = imagecreatefromjpeg($file);
       $dst = imagecreatetruecolor($w, $h);
       imagecopyresampled($dst, $src, 0, 0, 0, 0, $w, $h, $width, $height);
       return $dst;
    }


    public function sellerupdateimageupload(Request $request)
    {
        ini_set('memory_limit','1020M');
        $update_images  = $request->update_images;
        $image_size     = $request->image_size;


        $now_image_size = count($request->file('images'));
        $total_image    = $image_size + $now_image_size;

        if($total_image > 5){
            return "invalid_image";
            exit();
        }

        if($files = $request->file('images')){
            foreach($files as $image){
                $file       = $image->getClientOriginalName();
                $filename   = pathinfo($file, PATHINFO_FILENAME);
                $imageName  = rand(11111, 99999)."-".$filename.".jpg";

                $image->move(public_path('images/'),$imageName);
                $image_name_with_path = public_path().'/images/'.$imageName ;

                $img = Image::make($image_name_with_path);
                $img->resize(1000, 1000,function ($constraint) {
                    $constraint->aspectRatio();
                })->save($image_name_with_path);

                $data                   = array() ;
                $data['supplier_id']    = Session::get('supplier_id') ;
                $data['image']          = $imageName ;
                $data['status']         = 0 ;
                $data['created_at']     = $this->rcdate ;
        
                DB::table('tbl_media')->insert($data) ;

            }
        } 

        $result = DB::table('tbl_media')->where('supplier_id', Session::get('supplier_id'))->get();
        return view('seller.gallery.sellerupdateimageupload', compact('result', 'update_images'));
    }


    public function sellerimageupload(Request $request)
    {
        ini_set('memory_limit','1020M');
        $image_size     = $request->image_size;

        $now_image_size = count($request->file('images'));
        $total_image    = $image_size + $now_image_size;

        if($total_image > 5){
            return "invalid_image";
            exit();
        }

        if($files = $request->file('images')){
            foreach($files as $image){
                $file       = $image->getClientOriginalName();
                $filename   = pathinfo($file, PATHINFO_FILENAME);
                $imageName  = rand(11111, 99999)."-".$filename.".webp";

                $image->move(public_path('images/'),$imageName);
                $image_name_with_path = public_path().'/images/'.$imageName ;

                $img = Image::make($image_name_with_path)->encode('webp', 75);
                $img->resize(1000, 1000,function ($constraint) {
                    $constraint->aspectRatio();
                })->save($image_name_with_path);

                $data                   = array() ;
                $data['supplier_id']    = Session::get('supplier_id') ;
                $data['image']          = $imageName ;
                $data['status']         = 0 ;
                $data['created_at']     = $this->rcdate ;
        
                DB::table('tbl_media')->insert($data) ;

            }
        } 

        $result = DB::table('tbl_media')->where('supplier_id', Session::get('supplier_id'))->get();
        return view('seller.gallery.sellerSaveImage', compact('result'));
    }
    
    public function removeSellerProductImage(Request $request)
    {
        $image_id = $request->id;
        $media_info = DB::table('tbl_media')->where('id', $image_id)->first();
        if($media_info){
            $image_link = "public/images/".$media_info->image;
            if(file_exists($image_link)){
                unlink($image_link);
            }
    
            DB::table('tbl_media')->where('id', $image_id)->delete();
        }
    }

}
