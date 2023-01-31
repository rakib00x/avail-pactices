<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use DB;
use Session;

class PrivacyController extends Controller{

    public function index(){
    	$social = DB::table('tbl_social_media')->first();
    	$privacy = DB::table('tbl_privacy')->orderBy('id', 'desc')->get();
		return view('frontEnd.privacyPolicy')->with('social', $social)->with('privacy', $privacy);
    }

    public function privacyPolicy(){
	return view('admin.privacyPolicy.privacyPolicy');
    }
    public function privacyPolicyList()
	{
		$result = DB::table('tbl_privacy')->get() ;
		return view('admin.privacyPolicy.privacyPolicyList')->with('result', $result) ;
	}


	public function insertPrivacyPolicyInfo(Request $request)
	{
		$meta_title = $request->meta_title;
		$meta_discription = $request->meta_discription;
		
		$data_check = DB::table('tbl_privacy')
		->where('meta_title', $meta_title)
		->count() ;

		if ($data_check > 0) {
			echo "duplicate_found";
			exit() ;
		}

		if ($meta_title == "") {
			echo "invalid_input" ;
			exit() ;
		}

		$data                = array();
		$data['meta_title']  = $meta_title ;
		$data['meta_discription']  = $meta_discription ;
		$data['created_at']  = date('Y-m-d') ;


		$query = DB::table('tbl_privacy')->insert($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function getAllPrivacyPolicy(Request $request)
	{
		$result = DB::table('tbl_privacy')->get() ;

		return view('admin.privacyPolicy.privacyPolicyData')->with('result', $result) ;
	}
	public function editPrivacyPolicy(Request $request)
	{
		$id = $request->id ;
		$value   = DB::table('tbl_privacy')->where('id', $id)->first() ;

		return view('admin.privacyPolicy.editPrivacyPolicy')->with('value', $value) ;
	}

	public function updatePrivacyPolicyInfo(Request $request)
	{
		$meta_title  = $request->meta_title ;
		$meta_discription  = $request->meta_discription ;
		$primary_id     = $request->primary_id ;

		if ($meta_title == "" ) {
			echo "invalid_input" ;
			exit() ;
		}

		$data_count = DB::table('tbl_privacy')
		->where('meta_title', $meta_title)
		->whereNotIn('id', [$primary_id])
		->count() ;

		if ($data_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$data                   = array() ;
		$data['meta_title']  = $meta_title ;
		$data['meta_discription']  = $meta_discription ;

		$query = DB::table('tbl_privacy')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function privacyPolicyDelete(Request $request)
	{
		$id = $request->id ;
		$query = DB::table('tbl_privacy')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}
}
