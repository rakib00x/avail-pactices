<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;
use Cookie;


class AdminHomeController extends Controller
{
    public function __construct(){
		date_default_timezone_set('Asia/Dhaka');
		$this->rcdate           = date('Y-m-d');
		$this->logged_id        = Session::get('admin_id');
		$this->current_time     = date('H:i:s');
	}

	public function adminHomeCategoryList()
	{
		$result = DB::table('tbl_home_category')
		    ->join('tbl_primarycategory', 'tbl_home_category.category_id', '=', 'tbl_primarycategory.id')
		    ->select('tbl_home_category.*', 'tbl_primarycategory.category_name')
			->orderBy('tbl_home_category.home_descending', 'asc')
			->get() ;
		return view('admin.homeDecoration.adminHomeCategoryList')->with('result' ,$result) ;
	}

	public function addAdminHomeCategorys()
	{
		$result = DB::table('tbl_primarycategory')
			->where('status', 1)
			->get() ;

		return view('admin.homeDecoration.addAdminHomeCategorys')->with('result', $result) ;
	}

	public function insertHomeCategoryInfo(Request $request)
	{
		$this->validate($request, [
			'category_id' 		=> 'required',
			'catgory_name' 		=> 'required',
		]);

		$category_id 		= $request->category_id ;
		$catgory_name 		= $request->catgory_name ;

		$check_duplicate  = DB::table('tbl_home_category')->where('category_id', $category_id)->count(); 
		if ($check_duplicate > 0) {
			$notification = array(
	            'message'    => 'Sorry Category Already Added.', 
	            'alert-type' => 'warning',
	        );

	        return Redirect::to('addAdminHomeCategorys')->with($notification) ;
	        exit() ;
		}
		
		$category_info = DB::table('tbl_primarycategory')->where('id', $category_id)->first() ;
		$decrition_info = DB::table('tbl_home_category')->orderBy('home_descending', 'desc')->first() ;
		if($decrition_info){
		    $home_descending = $decrition_info->home_descending + 1 ;
		}else{
		    $home_descending = 1 ;
		}

		$data 						= array() ;
		$data['category_id'] 		= $category_id ;
		$data['h_category_name'] 	= $catgory_name ;
		$data['home_descending'] 	= $home_descending ;
		$data['status'] 			= 2 ;
		$data['created_at'] 		= $this->rcdate ;

		DB::table('tbl_home_category')->insert($data);

		$notification = array(
            'message'    => 'Category Add Successfully.', 
            'alert-type' => 'info',
        );
		return Redirect::to('adminHomeCategoryList')->with($notification) ;
	}

	public function changeAdminHomeCategoryStatus(Request $request)
	{
		$category_id 	= $request->category_id;
		$category_info 	= DB::table('tbl_home_category')->where('id', $category_id)->first() ;
		$db_status 		= $category_info->status ;

		if ($db_status == 2) {
			$check_count = DB::table('tbl_home_category')->where('status', 1)->count();
			if ($check_count > 0) {
				$last_row_id = DB::table('tbl_home_category')->where('status', 1)->orderBy('home_descending', 'desc')->first() ;
				$home_descending = $last_row_id->home_descending + 1 ;
			}else{
				$home_descending = 1 ;
			}
			$status = 1 ;
		}else{
			$status = 2;
			$home_descending = 0;
		}
		$data 						=  array() ;
		$data['status'] 			= $status ;
		$data['home_descending'] 	= $home_descending ;
		$data['updated_at'] 		= $this->rcdate ;
		DB::table('tbl_home_category')->where('id', $category_id)->update($data) ;

		if ($db_status == 2) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
			exit() ;
		}
 	}

 	public function eidtAdminHomeCategory($id)
 	{
 		$result = DB::table('tbl_primarycategory')
			->where('status', 1)
			->get() ;

 		$values = DB::table('tbl_home_category')->where('id', $id)->first() ;

 		return view('admin.homeDecoration.eidtAdminHomeCategory')->with('value',$values)->with('result', $result) ;
 	}

 	public function updateHomeCategoryInfo(Request $request)
 	{
 		$this->validate($request, [
			'category_id' 		=> 'required',
			'catgory_name' 		=> 'required',
		]);

		$category_id 		= $request->category_id ;
		$catgory_name 		= $request->catgory_name ;
		$primary_id 		= $request->primary_id ;

		$check_duplicate  = DB::table('tbl_home_category')
		->whereNotIn('id', [$primary_id])
		->where('category_id', $category_id)
		->count(); 
		if ($check_duplicate > 0) {
			$notification = array(
	            'message'    => 'Sorry Category Already Added.', 
	            'alert-type' => 'warning',
	        );

	        return Redirect::to('eidtAdminHomeCategory/'.$primary_id)->with($notification) ;
	        exit() ;
		}

		$category_info = DB::table('tbl_primarycategory')->where('id', $category_id)->first() ;

		$data 						= array() ;
		$data['category_id'] 		= $category_id ;
		$data['h_category_name'] 	= $catgory_name ;
		$data['updated_at'] 		= $this->rcdate ;

		DB::table('tbl_home_category')->where('id', $primary_id)->update($data);

		$notification = array(
            'message'    => 'Category Update Successfully.', 
            'alert-type' => 'info',
        );
		return Redirect::to('adminHomeCategoryList/')->with($notification) ;
 	}

 	public function adminHomeCategoryDelete(Request $request)
 	{
 		$id = $request->id ;
 		DB::table('tbl_home_category')->where('id', $id)->delete() ;
 		echo "success" ;
 	}



	public function adminHomeCategoryDecoration()
	{
		$result = DB::table('tbl_home_category')
			->where('status', 1)
			->orderBy('home_descending', 'asc')
			->get() ;

		return view('admin.homeDecoration.adminHomeCategoryDecoration')->with('result' ,$result) ;
	}


	public function updateHomeCategoryDecoration(Request $request)
	{
		$category_id = $request->primary_category_id ;

		foreach ($category_id as $key=>$value) {
			$data 						= array() ;
			$data['home_descending'] 	= $key ;
			DB::table('tbl_home_category')->where('id', $value)->update($data) ;
		}

		$notification = array(
            'message'    => 'Decoration Successfully Completed.', 
            'alert-type' => 'info',
        );

        return Redirect::to('adminHomeCategoryList')->with($notification) ;
	}

	# UPDATE HOME TOP SIX CATEGORY 
	public function updateHomeTopCategoryList()
	{
		$result = DB::table('tbl_primarycategory')
			->where('status', 1)
			->get() ;

		$top_value = DB::table('tbl_home_top_category')
			->first() ;

		return view('admin.homeDecoration.updateHomeTopCategoryList')->with('result' ,$result)->with('top_value' ,$top_value) ;
	}

	# UPDATE HOME TOP SIX CATEGORY INFO 
	public function updateHomeTopCategoryInfo(Request $request)
	{
		$first_category_id 	= $request->first_category_id;
		$second_category_id = $request->second_category_id;
		$third_category_id 	= $request->third_category_id;
		$four_category_id 	= $request->four_category_id;
		$five_category_id 	= $request->five_category_id;
		$six_category_id 	= $request->six_category_id;
		
        $top_value = DB::table('tbl_home_top_category')
			->first() ;
		if($top_value){
		    $data = array();
    		$data['first_category_id'] 	= $first_category_id ;
    		$data['second_category_id'] = $second_category_id ;
    		$data['third_category_id'] 	= $third_category_id ;
    		$data['four_category_id'] 	= $four_category_id ;
    		$data['five_category_id'] 	= $five_category_id ;
    		$data['six_category_id'] 	= $six_category_id ;
    
    		DB::table('tbl_home_top_category')->update($data) ;
		}else{
		    $data = array();
    		$data['first_category_id'] 	= $first_category_id ;
    		$data['second_category_id'] = $second_category_id ;
    		$data['third_category_id'] 	= $third_category_id ;
    		$data['four_category_id'] 	= $four_category_id ;
    		$data['five_category_id'] 	= $five_category_id ;
    		$data['six_category_id'] 	= $six_category_id ;
    
    		DB::table('tbl_home_top_category')->insert($data) ;
		}
		

		$notification = array(
            'message'    => 'Home Top Category Successfully Completed.', 
            'alert-type' => 'success',
        );

        return Redirect::to('updateHomeTopCategoryList')->with($notification) ;
	}

	# ADMIN HOME THREE PRODUCT 
	public function sidebarThreeProduct()
	{
		$result = DB::table('tbl_product')
			->orderBy('product_name', 'asc')
			->where('status', 1)
			->get() ;

		$all_three_product = DB::table('tbl_home_three_product')
			->first() ;

		return view('admin.homeDecoration.sidebarThreeProduct')->with('result' ,$result)->with('all_three_product' ,$all_three_product) ;
	}

	# UPDATE HOME THREE PRODUCT 
	public function updateHomeThreeProductInfo(Request $request)
	{
	    $all_three_product = DB::table('tbl_home_three_product')
			->first() ;
	    if($all_three_product){
	        $data = array() ;
    		$data['product_id'] = $request->product_id ;
    		$data['second_product_id'] = $request->second_product_id ;
    		$data['third_product_id'] = $request->third_product_id ;
    		DB::table('tbl_home_three_product')->update($data) ;
	    }else{
	        $data = array() ;
    		$data['product_id'] = $request->product_id ;
    		$data['second_product_id'] = $request->second_product_id ;
    		$data['third_product_id'] = $request->third_product_id ;
    		DB::table('tbl_home_three_product')->insert($data) ;
	    }
		

		$notification = array(
            'message'    => 'Home Sibebar Three Product Update Successfully Completed.', 
            'alert-type' => 'success',
        );

        return Redirect::to('sidebarThreeProduct')->with($notification) ;
	}

	# UPDATE HOME SECONDARY CATEGORY 
	public function updateHomeSecondaryCategoryList()
	{
		$result = DB::table('tbl_secondarycategory')
			->where('status', 1)
			->get() ;

		$category_value = DB::table('tbl_home_secondary_category')
			->first() ;

		return view('admin.homeDecoration.updateHomeSecondaryCategoryList')->with('result' ,$result)->with('top_value' ,$category_value) ;
	}

	# UPDATE HOME SECONDARY CATEGORY 
	public function updateHomeSecondaryCategoryInfo(Request $request)
	{
		$secondary_category_1 	= $request->secondary_category_1;
		$secondary_category_2 	= $request->secondary_category_2;
		$secondary_category_3 	= $request->secondary_category_3;
		$secondary_category_4 	= $request->secondary_category_4;
		$secondary_category_5 	= $request->secondary_category_5;
		$secondary_category_6 	= $request->secondary_category_6;
		$secondary_category_7 	= $request->secondary_category_7;
		$secondary_category_8 	= $request->secondary_category_8;
		
		$category_value = DB::table('tbl_home_secondary_category')
			->first() ;
        if($category_value){
            $data = array();
		    $data['secondary_category_1'] 	= $secondary_category_1 ;
    		$data['secondary_category_2'] 	= $secondary_category_2 ;
    		$data['secondary_category_3'] 	= $secondary_category_3 ;
    		$data['secondary_category_4'] 	= $secondary_category_4 ;
    		$data['secondary_category_5'] 	= $secondary_category_5 ;
    		$data['secondary_category_6'] 	= $secondary_category_6 ;
    		$data['secondary_category_7'] 	= $secondary_category_7 ;
    		$data['secondary_category_8'] 	= $secondary_category_8 ;
    		DB::table('tbl_home_secondary_category')->update($data) ;
        }else{
            $data = array();
    		$data['secondary_category_1'] 	= $secondary_category_1 ;
    		$data['secondary_category_2'] 	= $secondary_category_2 ;
    		$data['secondary_category_3'] 	= $secondary_category_3 ;
    		$data['secondary_category_4'] 	= $secondary_category_4 ;
    		$data['secondary_category_5'] 	= $secondary_category_5 ;
    		$data['secondary_category_6'] 	= $secondary_category_6 ;
    		$data['secondary_category_7'] 	= $secondary_category_7 ;
    		$data['secondary_category_8'] 	= $secondary_category_8 ;
    		DB::table('tbl_home_secondary_category')->insert($data) ;
        }
		

		$notification = array(
            'message'    => 'Home Secondary Category Successfully Completed.', 
            'alert-type' => 'success',
        );

        return Redirect::to('updateHomeSecondaryCategoryList')->with($notification) ;
	}

	# ALL COUNTRY 
	public function adminHomeCountryList()
	{
		$all_country = DB::table('tbl_countries')
			->get() ;

		$home_country = DB::table('tbl_home_country')->first() ;
		return view('admin.homeDecoration.adminHomeCountryList')->with('all_country' ,$all_country)->with('home_country' ,$home_country) ;
	}

	# UPDATE ALL HOME COUNTRY 
	public function updateHomeCountryInfo(Request $request)
	{

		$home_country 	 = DB::table('tbl_home_country')->first() ;
		$home_country_id = implode(',', $request->home_country_id);

		$data = array() ;
		$data['home_country_id'] = $home_country_id ;

		if ($home_country) {
			DB::table('tbl_home_country')->update($data) ;
		}else{
			DB::table('tbl_home_country')->insert($data) ;
		}


		$notification = array(
            'message'    => 'Home Country Update Successfully Completed.', 
            'alert-type' => 'success',
        );

        return Redirect::to('adminHomeCountryList')->with($notification) ;
	}

	  # ADMIN SIDEBAR CATEGOR YSECTION 
	public function adminSidebarCategoryList()
	{
		$result = DB::table('tbl_primarycategory')
			->where('sidebar_active', '>', 0)
			->orderBy('sidebar_decoration', 'asc')
			->get() ;

		$all_catgeorys = DB::table('tbl_primarycategory')
			->where('status', 1)
			->where('supplier_id', 0)
			->get() ;

		return view('admin.homeDecoration.adminSidebarCategoryList')->with('result', $result)->with('all_catgeorys', $all_catgeorys) ;
	}

	# update admin sidebar info 
	public function insertSidebarCategoryinfo(Request $request)
	{
		$category_id = $request->category_id ;
		$check_duplicate = DB::table('tbl_primarycategory')
			->where('sidebar_active', '>', 0)
			->where('id', $category_id)
			->count() ;

		if ($check_duplicate > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$check_count = DB::table('tbl_primarycategory')
			->where('sidebar_active', '>', 0)
			->count() ;
		if ($check_count > 0) {
			$last_des = DB::table('tbl_primarycategory')
				->where('sidebar_active', '>', 0)
				->orderBy('sidebar_decoration', 'desc')
				->first() ;
			$sidebar_decoration = $last_des->sidebar_decoration + 1 ;
		}else{
			$sidebar_decoration = 1 ;
		}

		$data = array() ;
		$data['sidebar_active'] = 2 ;
		$data['sidebar_decoration'] = $sidebar_decoration ;
		DB::table('tbl_primarycategory')->where('id', $category_id)->update($data) ;
		echo "success" ;
	}

	public function changeAdminHomeSidebarCategoryStatus(Request $request)
	{
		$category_id 	= $request->category_id;
		$category_info 	= DB::table('tbl_primarycategory')->where('id', $category_id)->first() ;
		$db_status 		= $category_info->sidebar_active ;


		if ($db_status == 2 || $db_status == 0) {
			$total_row_count = DB::table('tbl_primarycategory')->where('id', $category_id)->where('sidebar_active', 1)->count() ;
			if ($total_row_count > 6) {
				echo "time_over";
				exit() ;
			}
			$status = 1 ;
		}else{
			$status = 2;
		}
		$data 						=  array() ;
		$data['sidebar_active'] 			= $status ;
		DB::table('tbl_primarycategory')->where('id', $category_id)->update($data) ;

		if ($db_status == 2) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
			exit() ;
		}
	}

	# change posisaction in sidebar 
	public function adminHomeSidebarCategoryDecoration()
	{
		$result = DB::table('tbl_primarycategory')
			->where('sidebar_active', 1)
			->orderBy('sidebar_decoration', 'asc')
			->get() ;
		
		return view('admin.homeDecoration.adminHomeSidebarCategoryDecoration')->with('result', $result);
	}


	public function updateHomeSidebarCategoryDecoration(Request $request)
	{
		$primary_category_id = $request->primary_category_id ;

		foreach ($primary_category_id as $key=>$value) {
			$data 							= array() ;
			$data['sidebar_decoration'] 	= $key ;
			DB::table('tbl_primarycategory')->where('id', $value)->update($data) ;
		}

		$notification = array(
            'message'    => 'Decoration Successfully Completed.', 
            'alert-type' => 'info',
        );

        return Redirect::to('adminHomeSidebarCategoryDecoration')->with($notification) ;

	}

	# admin home sidebar second 
	public function adminSidebarSecondaryCategory($id)
	{
		$result = DB::table('tbl_secondarycategory')
			->where('status', 1)
			->where('primary_category_id', $id)
			->get() ;

		$upper_side_list = DB::table('tbl_secondarycategory')
			->where('sidebar_active', '>', 0)
			->orderBy('sidebar_decoration', 'asc')
			->where('primary_category_id', $id)
			->where('type', 1)
			->get() ;

		$bottom_side_list = DB::table('tbl_secondarycategory')
			->where('sidebar_active', '>', 0)
			->orderBy('sidebar_decoration', 'asc')
			->where('primary_category_id', $id)
			->where('type', 2)
			->get() ;



		return view('admin.homeDecoration.adminSidebarSecondaryCategory')->with('result', $result)->with('upper_side_list', $upper_side_list)->with('bottom_side_list', $bottom_side_list);
	}

	# insert admin home category 
	public function insertuppercategoryInfo(Request $request)
	{
		$category_id = $request->category_id_siam ;
		$check_duplicate = DB::table('tbl_secondarycategory')
			->where('sidebar_active', '>', 0)
			->where('id', $category_id)
			->count() ;

		if ($check_duplicate > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$check_count = DB::table('tbl_secondarycategory')
			->where('sidebar_active', '>', 0)
			->where('type', 1)
			->count() ;
		if ($check_count > 0) {
			$last_des = DB::table('tbl_secondarycategory')
				->where('sidebar_active', '>', 0)
				->orderBy('sidebar_decoration', 'desc')
				->where('type', 1)
				->first() ;


			$sidebar_decoration = $last_des->sidebar_decoration + 1 ;
		}else{
			$sidebar_decoration = 1 ;
		}

		$data = array() ;
		$data['sidebar_active'] 	= 2 ;
		$data['sidebar_decoration'] = $sidebar_decoration ;
		$data['type'] 				= 1 ;
		DB::table('tbl_secondarycategory')->where('id', $category_id)->update($data) ;
		echo "success" ;
	}


	# ADMIN HOME CATEGORY STATUS 
	public function changeSidebarSecondaryCategoryStatus(Request $request)
	{
		$category_id 	= $request->category_id;
		$category_info 	= DB::table('tbl_secondarycategory')->where('id', $category_id)->first() ;
		$db_status 		= $category_info->sidebar_active ;


		if ($db_status == 2 || $db_status == 0) {
			$total_row_count = DB::table('tbl_secondarycategory')->where('id', $category_id)->where('sidebar_active', 1)->where('type', 1)->count() ;
			if ($total_row_count > 2) {
				echo "time_over";
				exit() ;
			}
			$status = 1 ;
		}else{
			$status = 2;
		}

		$data 						=  array() ;
		$data['sidebar_active'] 	= $status ;
		DB::table('tbl_secondarycategory')->where('id', $category_id)->update($data) ;

		if ($db_status == 2) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
			exit() ;
		}
	}

	public function deleteHomeSecondayCategoryUpper(Request $request)
	{
		$category_id = $request->category_id ;

		$data = array() ;
		$data['sidebar_active'] = 0 ;
		$data['sidebar_decoration'] = 0 ;
		$data['type'] = 0 ;

		DB::table('tbl_secondarycategory')->where('id', $category_id)->update($data);

		echo "success" ;
	}

	public function insertBottomcategoryInfo(Request $request)
	{
		$category_id = $request->category_id_s ;
		$check_duplicate = DB::table('tbl_secondarycategory')
			->where('sidebar_active', '>', 0)
			->where('id', $category_id)
			->count() ;

		if ($check_duplicate > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$check_count = DB::table('tbl_secondarycategory')
			->where('sidebar_active', '>', 0)
			->where('type', 2)
			->count() ;
		if ($check_count > 0) {
			$last_des = DB::table('tbl_secondarycategory')
				->where('sidebar_active', '>', 0)
				->orderBy('sidebar_decoration', 'desc')
				->where('type', 2)
				->first() ;
			$sidebar_decoration = $last_des->sidebar_decoration + 1 ;
		}else{
			$sidebar_decoration = 1 ;
		}

		$data = array() ;
		$data['sidebar_active'] 	= 2 ;
		$data['sidebar_decoration'] = $sidebar_decoration ;
		$data['type'] 				= 2 ;
		DB::table('tbl_secondarycategory')->where('id', $category_id)->update($data) ;
		echo "success" ;
	}

	public function changesidebarsecondarylowercategorystatus(Request $request)
	{
		$category_id 	= $request->category_id;

		$category_info 	= DB::table('tbl_secondarycategory')->where('id', $category_id)->first() ;
		$db_status 		= $category_info->sidebar_active ;

		if ($db_status == 2 || $db_status == 0) {
			$total_row_count = DB::table('tbl_secondarycategory')->where('id', $category_id)->where('sidebar_active', 1)->where('type', 2)->count() ;
			if ($total_row_count > 2) {
				echo "time_over";
				exit() ;
			}
			$status = 1 ;
		}else{
			$status = 2;
		}

		$data 						=  array() ;
		$data['sidebar_active'] 	= $status ;
		DB::table('tbl_secondarycategory')->where('id', $category_id)->update($data) ;

		if ($db_status == 2) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}
			
	}

	public function updatebottomcategorylistinfo(Request $request)
	{
		$primary_category_id 	= $request->primary_category_id ;
		$main_category_id 		= $request->main_category_id ;
		foreach($primary_category_id as $key => $value){
			$data 						= array() ;
			$data['sidebar_decoration'] = $key ;
			DB::table('tbl_secondarycategory')->where('id', $value)->update($data) ;
		}

		$notification = array(
            'message'    => 'Bottom Category Decoration Successfully.', 
            'alert-type' => 'success',
        );

        return Redirect::to('adminSidebarSecondaryCategory/'.$main_category_id)->with($notification) ;
	}	

	public function updateuppercategorylistinfo(Request $request)
	{
		$primary_category_id 	= $request->primary_category_id ;
		$main_category_id 		= $request->main_category_id ;
		foreach($primary_category_id as $key => $value){
			$data 						= array() ;
			$data['sidebar_decoration'] = $key ;
			DB::table('tbl_secondarycategory')->where('id', $value)->update($data) ;
		}

		$notification = array(
            'message'    => 'Upper Category Decoration Successfully.', 
            'alert-type' => 'success',
        );

        return Redirect::to('adminSidebarSecondaryCategory/'.$main_category_id)->with($notification) ;
	}

	# ADMIN HOME TERTIARY CATEGORY LIST 
	public function adminSidebarTertiaryCategoryList()
	{
		$result = DB::table('tbl_secondarycategory')
			->where('sidebar_active', '>', 0)
			->get() ;

		return view('admin.homeDecoration.adminSidebarTertiaryCategoryList')->with('result', $result) ;
	}

	# GET TERTIARY CATEGORY FINO 
	public function gettertiarycategorybysecondarycategory(Request $request)
	{
		$category_id = $request->category_id ;

        $another_result = DB::table('tbl_tartiarycategory')
	        ->where('secondary_category_id', $category_id)
	        ->get();

	     echo "<option value=''>Select Tertiary Category</option>";
	     foreach($another_result as $trvalue){
	     	echo '<option value='.$trvalue->id.'>'.$trvalue->tartiary_category_name.'</option>' ;
	     }
	}


	# INSERT TERTIARY CATEGORY INFO 
	public function insertSidebarTertiaryCategory(Request $request)
	{
		$category_id 			= $request->category_id ;
		$tertiary_category_id  = $request->tertiary_category_id ;

		$check_count = DB::table('tbl_tartiarycategory')
			->where('sidebar_active', '>', 0)
			->where('secondary_category_id', $category_id)
			->count() ;
		if ($check_count > 0) {
			$last_des = DB::table('tbl_tartiarycategory')
				->where('sidebar_active', '>', 0)
				->orderBy('sidebar_decoration', 'desc')
				->where('secondary_category_id', $category_id)
				->first() ;
			$sidebar_decoration = $last_des->sidebar_decoration + 1 ;
		}else{
			$sidebar_decoration = 1 ;
		}

		$data = array() ;
		$data['sidebar_active'] 	= 2 ;
		$data['sidebar_decoration'] = $sidebar_decoration ;

		DB::table('tbl_tartiarycategory')->where('id', $tertiary_category_id)->update($data) ;
		echo "success" ;
	}

	# ADMIN HOME TERTIARY CATGEORY 
	public function changeAdminSidebarTertiaryCategoryStatus(Request $request)
	{
		$category_id = $request->category_id ;
	
		$category_info 	= DB::table('tbl_tartiarycategory')->where('id', $category_id)->first() ;
		$db_status 		= $category_info->sidebar_active ;

		if ($db_status == 2 || $db_status == 0) {
			$total_row_count = DB::table('tbl_tartiarycategory')->where('id', $category_id)->where('sidebar_active', 1)->count() ;
			if ($total_row_count > 6) {
				echo "time_over";
				exit() ;
			}
			$status = 1 ;
		}else{
			$status = 2;
		}

		$data 						=  array() ;
		$data['sidebar_active'] 	= $status ;
		DB::table('tbl_tartiarycategory')->where('id', $category_id)->update($data) ;

		if ($db_status == 2) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}
	}

	# admin tertiary category 
	public function adminsidebartertiarycategorydecration($id)
	{
		$result = DB::table('tbl_tartiarycategory')
			->where('secondary_category_id', $id)
			->orderBy('sidebar_decoration', 'asc')
			->where('status', 1)
			->where('sidebar_active', 1)
			->get() ;

		$value_info = DB::table('tbl_secondarycategory')
			->where('id', $id)
			->first() ;


		return view('admin.homeDecoration.adminsidebartertiarycategorydecration')->with('result', $result)->with('value_info', $value_info) ;
	}

	# admin home category decration
	public function updateTertiaryCategoryDecoration(Request $request)
	{
		$primary_category_id = $request->primary_category_id ;
		$secondary_category_id = $request->secondary_category_id ;

		foreach ($primary_category_id as $key=>$value) {
			$data 							= array() ;
			$data['sidebar_decoration'] 	= $key ;
			DB::table('tbl_tartiarycategory')->where('id', $value)->update($data) ;
		}

		$notification = array(
            'message'    => 'Decoration Successfully Completed.', 
            'alert-type' => 'info',
        );

        return Redirect::to('adminsidebartertiarycategorydecration/'.$secondary_category_id)->with($notification) ;
	}

	# DELETE HOME CATEGORY DECRATION 
	public function deletetertiarycategorystatus(Request $request)
	{
		$id = $request->id ;

		$data = array() ;
		$data['sidebar_active'] = 0 ;
		$data['sidebar_decoration'] = 0 ;

		DB::table('tbl_tartiarycategory')->where('id', $id)->update($data);

		echo "success" ;
	}


	# delete admin home sidebar catgeory 
	public function deletesidebarprimarycategory(Request $request)
	{
		$id 	= $request->id ;
		$data 	= array() ;
		$data['sidebar_active'] 	= 0 ;
		$data['sidebar_decoration'] = 0 ;
		DB::table('tbl_primarycategory')->where('id', $id)->update($data) ;		

		$data2 = array() ;
		$data2['sidebar_active'] 	= 0 ;
		$data2['sidebar_decoration'] = 0 ;
		$data2['type'] 				= 0 ;
		DB::table('tbl_secondarycategory')->where('primary_category_id', $id)->update($data2) ;
		
		$data3 = array() ;
		$data3['sidebar_active'] = 0 ;
		$data3['sidebar_decoration'] = 0 ;

		DB::table('tbl_tartiarycategory')->where('primary_category_id', $id)->update($data3);

		echo "success" ;
	}



}
