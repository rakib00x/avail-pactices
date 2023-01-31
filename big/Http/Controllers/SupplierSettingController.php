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


class SupplierSettingController extends Controller
{
    public function __construct(){
		date_default_timezone_set('Asia/Dhaka');
		$this->rcdate       = date('Y-m-d');
		$this->loged_id     = Session::get('admin_id');
		$this->current_time = date("H:i:s");
	}

	public function supplierHeaderSetup()
	{
		return view('supplier.sitesettings.supplierHeader') ;
	}
	
	public function defaultSiteSettings()
	{
		$default_setting = DB::table('tbl_default_setting')->first() ;

		return view('admin.defaultSiteSettings')->with('default_setting', $default_setting) ;
	}

	public function updatedefaultlogobyadmin(Request $request)
	{

		$image 			    = $request->file('logo') ;
		$default_banner     = $request->file('default_banner') ;
		$login_background   = $request->file('login_background'); 
		
	
		
		if($image == "" && $default_banner == "" && $login_background == ""){
		    Session::put('failed', 'Sorry! Not Data Found For Update');
		    return Redirect::to('defaultSiteSettings') ;
		    exit() ;
		}
		
		$default_setting = DB::table('tbl_default_setting')->where('id', 1)->first() ;
		

		$data = array();
		
		if ($image) {
		  //  $logo_def = public_path('pulic/images/defult/' .$default_setting->logo);
		    
    //         if ($default_setting->logo && file_exists($logo_def)) {
    //             unlink($logo_def);
    //         }
			$image      = $request->file('logo');
	        $imageName  = $image->getClientOriginalName();
	        $image->move(public_path('images/defult/'),$imageName);
	        $data['logo'] = $imageName ;
		}

		if ($default_banner) {
		  //  $default_bann = public_path('public/images/defult/' .$default_setting->default_banner);
		    
    //         if ($default_setting->default_banner && file_exists($default_bann)) {
    //             unlink($default_bann);
    //         }
		    
		   	$image2      		= $request->file('default_banner');
	        $default_banner3  	= $image2->getClientOriginalName();
	        $image2->move(public_path('images/defult/'),$default_banner3);
	       	$data['banner_image'] = $default_banner3 ;
		}
        if ($login_background) {
            // $login_bann = public_path('public/images/defult/' .$default_setting->login_background);
            // if ($default_setting->login_background && file_exists($login_bann)) {
            //     unlink($login_bann);
            // }
            
           	$image2      		= $request->file('login_background');
	        $login_background  	= $image2->getClientOriginalName();
	        $image2->move(public_path('images/defult/'),$login_background);
	       	$data['login_background'] = $login_background ;
		}
		
	
         
            
            
		
		if ($default_setting) {
		    
			DB::table('tbl_default_setting')->update($data) ;
		}else{
			DB::table('tbl_default_setting')->insert($data) ;
		}
	   	
  

		Session::put('success', 'Setting Update Successfully');
		return Redirect::to('defaultSiteSettings') ;
	}

}
