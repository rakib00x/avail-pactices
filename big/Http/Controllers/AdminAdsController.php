<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
// use Intervention\Image\Facades\Image;
use Image;
use App\Http\Requests;
use DB;
use Session;

class AdminAdsController extends Controller{
  public function __construct(){
    date_default_timezone_set('Asia/Dhaka');
    $this->rcdate           = date('Y-m-d');
    $this->logged_id        = Session::get('admin_id');
    $this->current_time     = date('H:i:s');
  }

// home page ads
  public function adminHomeAds(){
    $all_primarycategory = DB::table('tbl_primarycategory')->where('supplier_id',0)->where('status', 1)->get() ;

    $result = DB::table('tbl_category_ads')->orderBy('ads_title', 'asc')->get();
    return view('admin.ads.homePageAds.adsList')->with('all_primarycategory', $all_primarycategory)->with('result', $result) ;
  }

  public function insertAdminHomeAds(Request $request){
      $request->validate([
            'ads_title' => 'required',
            'ads_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
      
    $ads_title = $request->ads_title;
    $ads_link = $request->ads_link;
    $ads_image = $request->ads_image;
    $primary_category_id    = $request->primary_category_id ;
    $image_keyword = $request->image_keyword;

    $data_count = DB::table('tbl_category_ads')
    ->where('ads_title', $ads_title)
    ->where('primary_category_id', $primary_category_id)
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }

    if ($ads_title == "" || $ads_image == "" || $primary_category_id == "") {
      echo "invalid_input" ;
      exit() ;
    }

    $data              = array();
    $data['ads_title'] = $ads_title;
    $data['ads_link']  = $ads_link;
    $data['type']  = 1;
    $data['ads_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $ads_title)) ;
    // $data['ads_image'] = $ads_image;
    $data['image_keyword'] = $image_keyword;
    $data['status']    = 1 ;
    $data['primary_category_id']    = $primary_category_id ;
    $data['created_at']  = $this->rcdate ;
    $data['updated_at']  = $this->rcdate ;
     if ($request->hasFile('ads_image')) {
            $image = $request->file('ads_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/adminAds/') . $new_image_name);
            $data['ads_image']  = $new_image_name;
        } 

    $query = DB::table('tbl_category_ads')->insert($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function getAllAdminHomeAds(Request $request)
  {
    $result = DB::table('tbl_category_ads')->where('type',1)->orderBy('ads_title', 'asc')->get() ;
    return view('admin.ads.homePageAds.adsData')->with('result', $result) ;
  }

  public function changeAdminHomeAdsStatus(Request $request)
  {
    $ads_id = $request->ads_id;

    $status_check   = DB::table('tbl_category_ads')->where('id', $ads_id)->first() ;
    $status         = $status_check->status;

    if ($status == 1) {
      $db_status = 2 ;
    }else{
      $db_status = 1 ;
    }

    $data           = array() ;
    $data['status'] = $db_status ;
    $query = DB::table('tbl_category_ads')->where('id', $ads_id)->update($data) ;
    if ($db_status == 1) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
    }

  }

  public function editAdminHomeAds(Request $request)
  {
    $id = $request->id ;
    $value   = DB::table('tbl_category_ads')->where('id', $id)->first() ;
    $all_primarycategory = DB::table('tbl_primarycategory')->where('supplier_id',0)->where('status', 1)->get() ;


    return view('admin.ads.homePageAds.editAds')->with('value', $value)->with('all_primarycategory', $all_primarycategory) ;
  }

  public function updateAdminHomeAds(Request $request){
      $request->validate([
            'ads_title' => 'required',
        ]);
        
    $ads_title = $request->ads_title;
    $ads_link = $request->ads_link;
    $ads_image = $request->ads_image;
    $image_keyword = $request->image_keyword;
    $primary_category_id = $request->primary_category_id;

    $primary_id     = $request->primary_id ;
    $image = DB::table('tbl_category_ads')->where('id', $primary_id)->first() ;

    if ($ads_title == "" || $primary_category_id == "") {
      echo "invalid_input" ;
      exit() ;
    }

    $data_count = DB::table('tbl_category_ads')
    ->where('ads_title', $ads_title)
    ->where('primary_category_id', $primary_category_id)
    ->whereNotIn('id', [$primary_id])
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }


    $data              = array();
    $data['ads_title'] = $ads_title;
    $data['primary_category_id']    = $primary_category_id ;
    $data['ads_link']  = $ads_link;
    $data['ads_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $ads_title)) ;
    $data['image_keyword'] = $image_keyword;
    $data['created_at']  = $this->rcdate ;
    $data['updated_at']  = $this->rcdate ;
    
    if ($request->hasFile('ads_image')) {
        $image_path = public_path('images/adminAds/' .$image->ads_image);
        if ($image->ads_image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('ads_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/adminAds/') . $new_image_name);
            $data['ads_image']  = $new_image_name;
        }
    
    $query = DB::table('tbl_category_ads')->where('id', $primary_id)->update($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

  public function deleteAdminHomeAds(Request $request)
  {
    $id = $request->id ;
    $image = DB::table('tbl_category_ads')->where('id', $id)->first() ;
    $image_path = public_path('images/adminAds/' .$image->ads_image);
        if ($image->ads_image && file_exists($image_path)) {
                    unlink($image_path);
                }
    $query = DB::table('tbl_category_ads')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }
  }


// categories page ads
  public function adminAds(){
    $all_primarycategory = DB::table('tbl_primarycategory')->where('supplier_id',0)->where('status', 1)->get() ;

    $result = DB::table('tbl_category_ads')->orderBy('ads_title', 'asc')->get();
    return view('admin.ads.categoriesPageAds.adsList')->with('all_primarycategory', $all_primarycategory)->with('result', $result) ;
  }
//insert
  public function insertAdminAds(Request $request){
      $request->validate([
          'primary_category_id' => 'required',
            'ads_title' => 'required',
            'ads_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
    $ads_title = $request->ads_title;
    $ads_link = $request->ads_link;
    $ads_image = $request->ads_image;
    $primary_category_id    = $request->primary_category_id ;
    $image_keyword = $request->image_keyword;

    $data_count = DB::table('tbl_category_ads')
    ->where('ads_title', $ads_title)
    ->where('primary_category_id', $primary_category_id)
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }

    if ($ads_title == "" || $ads_image == "" ) {
      echo "invalid_input" ;
      exit() ;
    }

    $data              = array();
    $data['ads_title'] = $ads_title;
    $data['ads_link']  = $ads_link;
    $data['type']  = 2;
    $data['ads_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $ads_title)) ;
    // $data['ads_image'] = $ads_image;
    $data['image_keyword'] = $image_keyword;
    $data['status']    = 1 ;
    $data['primary_category_id']    = $primary_category_id ;
    $data['created_at']  = $this->rcdate ;
    $data['updated_at']  = $this->rcdate ;
    
     if ($request->hasFile('ads_image')) {
            $image = $request->file('ads_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/categoryAds/') . $new_image_name);
            $data['ads_image']  = $new_image_name;
        } 


    $query = DB::table('tbl_category_ads')->insert($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }
// get all categories ads data
  public function getAllAdminAds(Request $request)
  {
    $result = DB::table('tbl_category_ads')->where('type',2)->orderBy('ads_title', 'asc')->get() ;
    return view('admin.ads.categoriesPageAds.adsData')->with('result', $result) ;
  }

// status change
  public function changeAdminAdsStatus(Request $request)
  {
    $ads_id = $request->ads_id;

    $status_check   = DB::table('tbl_category_ads')->where('id', $ads_id)->first() ;
    $status         = $status_check->status;

    if ($status == 1) {
      $db_status = 2 ;
    }else{
      $db_status = 1 ;
    }

    $data           = array() ;
    $data['status'] = $db_status ;
    $query = DB::table('tbl_category_ads')->where('id', $ads_id)->update($data) ;
    if ($db_status == 1) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
    }

  }
// edit 
  public function editAdminAds(Request $request)
  {
    $id = $request->id ;
    $value   = DB::table('tbl_category_ads')->where('id', $id)->first() ;
    $all_primarycategory = DB::table('tbl_primarycategory')->where('supplier_id',0)->where('status', 1)->get() ;


    return view('admin.ads.categoriesPageAds.editAds')->with('value', $value)->with('all_primarycategory', $all_primarycategory) ;
  }
//update
  public function updateAdminAds(Request $request){
      $request->validate([
            'ads_title' => 'required',
        ]);
    $ads_title = $request->ads_title;
    $ads_link = $request->ads_link;
    $ads_image = $request->ads_image;
    $image_keyword = $request->image_keyword;
    $primary_category_id = $request->primary_category_id;

    $primary_id     = $request->primary_id ;
    
    $image = DB::table('tbl_category_ads')->where('id', $primary_id)->first() ;

    if ($ads_title == "" || $primary_category_id == "") {
      echo "invalid_input" ;
      exit() ;
    }

    $data_count = DB::table('tbl_category_ads')
    ->where('ads_title', $ads_title)
    ->where('primary_category_id', $primary_category_id)
    ->whereNotIn('id', [$primary_id])
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }


    $data              = array();
    $data['ads_title'] = $ads_title;
    $data['primary_category_id']    = $primary_category_id ;
    $data['ads_link']  = $ads_link;
    $data['ads_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $ads_title)) ;
    $data['ads_image'] = $ads_image;
    $data['image_keyword'] = $image_keyword;
    $data['created_at']  = $this->rcdate ;
    $data['updated_at']  = $this->rcdate ;
    
     if ($request->hasFile('ads_image')) {
          $image_path = public_path('images/categoryAds/' .$image->ads_image);
         if ($image->ads_image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('ads_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/categoryAds/') . $new_image_name);
            $data['ads_image']  = $new_image_name;
        } 

    $query = DB::table('tbl_category_ads')->where('id', $primary_id)->update($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }

//delete
  public function deleteAdminAds(Request $request)
  {
    $id = $request->id ;
     $image = DB::table('tbl_category_ads')->where('id', $id)->first() ;
      $image_path = public_path('images/categoryAds/' .$image->ads_image);
         if ($image->ads_image && file_exists($image_path)) {
                    unlink($image_path);
                }
    $query = DB::table('tbl_category_ads')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }
  }


# ADMIN POPUP ADS 
  public function adminHomePopupAds()
  {
    return view('admin.ads.adminHomePopupAds');
  }

  public function getAllHomePopupAds()
  {
    $result = DB::table('tbl_popup_ads')->get() ;
    return view('admin.ads.getAllHomePopupAds')->with('result' ,$result) ;
  }

  public function insertPopupAdsInfo(Request $request)
  {
      
    $ads_heading    = $request->ads_heading ;
    $ads_paragraph  = $request->ads_paragraph ;
    $ads_image      = $request->ads_image ;
    $ads_link       = $request->ads_link ;
    $link_title     = $request->link_title ;
    

    $data                   = array() ;
    $data['ads_heading']    = $ads_heading ;
    $data['ads_paragraph']  = $ads_paragraph ;
    // $data['ads_image']      = $ads_image ;
    $data['ads_link']       = $ads_link ;
    $data['link_title']     = $link_title ;
    $data['status']         = 0 ;
    $data['created_at']     = $this->rcdate ;
    
    if ($request->hasFile('ads_image')) {
            $image = $request->file('ads_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/popupAds/') . $new_image_name);
            $data['ads_image']  = $new_image_name;
        } 

    $query = DB::table('tbl_popup_ads')->insert($data) ;
    if ($query) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
      exit() ;
    }
  }

  public function changePopupAdsStatus(Request $request)
  {
    $ads_info  = DB::table('tbl_popup_ads')->where('id', $request->ads_id)->first() ;
    $status = $ads_info->status ;

    if ($status == 2 || $status == 0) {
      $ads_count  = DB::table('tbl_popup_ads')->where('status', 1)->whereNotIn('id', [$request->ads_id])->count();
      if ($ads_count > 0) {
        echo "active_duplicate_count" ;
        exit() ;
      }
    }

    if ($status != 1) {
      $status_change = 1 ;
    }else{
      $status_change = 2 ;
    }

    $data               = array();
    $data['status']     = $status_change ;
    $data['updated_at'] = $this->rcdate ;

    DB::table('tbl_popup_ads')->where('id', $ads_info->id)->update($data) ;

    if ($status != 1) {
      echo "success";
      exit() ;
    }else{
      echo "failed";
      exit() ;
    }
  }

  // edit 
  public function editPopupAds(Request $request)
  {
    $id = $request->id ;
    $value   = DB::table('tbl_popup_ads')->where('id', $id)->first() ;
    return view('admin.ads.editHomePopupAds')->with('value', $value);
  }
//update
  public function updatePopupAds(Request $request){
     $request->validate([
            'ads_heading' => 'required',
        ]); 
      
      
    $ads_heading    = $request->ads_heading ;
    $ads_paragraph  = $request->ads_paragraph ;
    $ads_image      = $request->ads_image ;
    $ads_link       = $request->ads_link ;
    $link_title     = $request->link_title ;
    $primary_id     = $request->primary_id ;
    

$image = DB::table('tbl_popup_ads')->where('id', $primary_id)->first() ;

    $data                   = array() ;
    $data['ads_heading']    = $ads_heading ;
    $data['ads_paragraph']  = $ads_paragraph ;
    // $data['ads_image']      = $ads_image ;
    $data['ads_link']       = $ads_link ;
    $data['link_title']     = $link_title ;
    $data['created_at']     = $this->rcdate ;
    
    if ($request->hasFile('ads_image')) {
        $image_path = public_path('images/popupAds/' .$image->ads_image);
        if ($image->ads_image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('ads_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/popupAds/') . $new_image_name);
            $data['ads_image']  = $new_image_name;
        } 
    

    $query = DB::table('tbl_popup_ads')->where('id', $primary_id)->update($data) ;
    if ($query) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
      exit() ;
    }
  }

  //delete
  public function deletePopupAds(Request $request)
  {
    $id = $request->id ;
    $image = DB::table('tbl_popup_ads')->where('id', $id)->first() ;
    
    $image_path = public_path('images/popupAds/' .$image->ads_image);
        if ($image->ads_image && file_exists($image_path)) {
                    unlink($image_path);
                }
    $query = DB::table('tbl_popup_ads')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }
  }

  # ADMIN ADS SECTION 
  public function adminadslist()
  {
    return view('admin.ads.adminadslist') ;
  }

  # get admin all product ads 
  public function getalladminAdsList(Request $request)
  {
    $result = DB::table('tbl_product_ads')
      ->get() ;
      
      $today_date = date('Y-m-d');
			foreach ($result as $value){
				if($value->end_date <= $today_date){
					$data = array();
					$data['status'] = 0;
					DB::table('tbl_product_ads')->where('id', $value->id)->update($data);
				}else{
				    $data = array();
					$data['status'] = 1;
					DB::table('tbl_product_ads')->where('id', $value->id)->update($data);
				}
			}

    return view('admin.ads.getalladminads')->with('result', $result) ;
  }

  # INSERT ADMIN PRODUCT ADS 
  public function insertAdminListAds(Request $request)
  {
      $request->validate([
            'title' => 'required'
        ]);
       $title      = $request->title ;
      $ads_image      = $request->ads_image ;
      $ads_link       = $request->ads_link ;
      $start_date       = $request->start_date ;
      $end_date       = $request->end_date ;


      $duplicate_check = DB::table('tbl_product_ads')
        ->where('ads_link', $ads_link)
        ->count() ;

      if ($duplicate_check > 0) {
        echo "duplicate_found" ;
        exit() ;
      }

      $data                   = array() ;
      $data['title']      = $title ;
      $data['ads_image']      = $ads_image ;
      $data['ads_link']       = $ads_link ;
      $data['start_date']       = $start_date ;
      $data['end_date']       = $end_date ;
      $data['status']         = 1 ;
      $data['created_at']     = $this->rcdate ;
       if ($request->hasFile('ads_image')) {
            $image = $request->file('ads_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/adminssAds/') . $new_image_name);
            $data['ads_image']  = $new_image_name;
        } 
      $query = DB::table('tbl_product_ads')->insert($data) ;

      if ($query) {
        echo "success" ;
        exit() ;
      }else{
        echo "failed" ;
        exit() ;
      }
  }

  public function changeAdminAdsStatuslist(Request $request)
  {
    $ads_info  = DB::table('tbl_product_ads')->where('id', $request->ads_id)->first() ;
    $status = $ads_info->status ;
   
    if ($status != 1) {
      $status_change = 1 ;
    }else{
      $status_change = 2 ;
    }

    $data               = array();
    $data['status']     = $status_change ;
    $data['updated_at'] = $this->rcdate ;

    DB::table('tbl_product_ads')->where('id', $ads_info->id)->update($data) ;

    if ($status != 1) {
      echo "success";
      exit() ;
    }else{
      echo "failed";
      exit() ;
    }
  }

  # EDIT ADS INFO 
  public function editAdminListads(Request $request)
  {
      $ads_info  = DB::table('tbl_product_ads')->where('id', $request->id)->first() ;

       return view('admin.ads.editAdminAdsList')->with('ads_info', $ads_info);
  }

  # UPDATE PRODUCT ADS INFO 
  public function updateproductadsinfo(Request $request)
  {
      $request->validate([
            'title' => 'required',
        ]);
      $title     = $request->title ;
      $ads_image      = $request->ads_image ;
      $ads_link       = $request->ads_link ;
      $start_date       = $request->start_date ;
     $end_date       = $request->end_date ;
      $primary_id     = $request->primary_id ;
      
       $image = DB::table('tbl_product_ads')->where('id', $primary_id)->first() ;

      $duplicate_check = DB::table('tbl_product_ads')
        ->where('ads_link', $ads_link)
        ->whereNotIn('id', [$primary_id])
        ->count() ;

      if ($duplicate_check > 0) {
        echo "duplicate_found" ;
        exit() ;
      }


      $data                   = array() ;
      $data['title']      = $title ;
    //   $data['ads_image']      = $ads_image ;
      $data['ads_link']       = $ads_link ;
      $data['start_date']       = $start_date ;
      $data['end_date']       = $end_date ;
      $data['updated_at']     = $this->rcdate ;
       if ($request->hasFile('ads_image')) {
           $image_path = public_path('images/adminssAds/' .$image->ads_image);
        if ($image->ads_image && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('ads_image');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/adminssAds/') . $new_image_name);
            $data['ads_image']  = $new_image_name;
        } 
      
      $query = DB::table('tbl_product_ads')->where('id', $primary_id)->update($data) ;

      if ($query) {
        echo "success" ;
        exit() ;
      }else{
        echo "failed" ;
        exit() ;
      }
  }

  # DELETE PRODUCT ADS INFO 
  public function deleteAdminAdsList(Request $request)
  {
       $image = DB::table('tbl_product_ads')->where('id', $request->id)->first() ;
       $image_path = public_path('images/adminssAds/' .$image->ads_image);
        if ($image->ads_image && file_exists($image_path)) {
                    unlink($image_path);
                }
      $query = DB::table('tbl_product_ads')->where('id', $request->id)->delete() ;

      if ($query) {
        echo "success" ;
        exit() ;
      }else{
        echo "failed" ;
        exit() ;
      }
  }


}
