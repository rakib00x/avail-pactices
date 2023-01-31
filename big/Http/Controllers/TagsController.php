<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Str;
use Input;

class TagsController extends Controller{
	public function __construct(){
		date_default_timezone_set('Asia/Dhaka');
		$this->rcdate       = date('Y-m-d');
		$this->loged_id     = Session::get('admin_id');
		$this->current_time = date("H:i:s");
	}
	
	public function tagsList(){
		$result = DB::table('tbl_tags')->orderBy('tags_name', 'asc')->get() ;
		return view('product.tags.tagList')->with('result', $result) ;
	}

	public function insertTagsInfo(Request $request){
		$tags_name = $request->tags_name;
		$supplier_id = Session::get('supplier_id');

		$data_check = DB::table('tbl_tags')
		->where('tags_name', $tags_name)
		->where('supplier_id', $supplier_id)
		->count() ;

		if ($data_check > 0) {
			echo "duplicate_found";
			exit() ;
		}

		if ($tags_name == "") {
			echo "invalid_input" ;
			exit() ;
		}

		$data                = array();
		$data['tags_name']  = $tags_name ;
		$data['supplier_id']  = $supplier_id ;
		$data['tags_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $tags_name)) ;
		$data['status']      = 1 ;
		$data['created_at']  = $this->rcdate ;

		$query = DB::table('tbl_tags')->insert($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function getAllTags(Request $request){
		$supplier = Session::get('supplier_id');
		$result = DB::table('tbl_tags')->where('supplier_id',$supplier)->orderBy('tags_name', 'asc')->get() ;

		return view('product.tags.tagData')->with('result', $result) ;
	}

	public function changeTagsStatus(Request $request){
		$tags_id = $request->tags_id;

		$status_check   = DB::table('tbl_tags')->where('id', $tags_id)->first() ;
		$status         = $status_check->status ;

		if ($status == 1) {
			$db_status = 2 ;
		}else{
			$db_status = 1 ;
		}

		$data           = array() ;
		$data['status'] = $db_status ;
		$query = DB::table('tbl_tags')->where('id', $tags_id)->update($data) ;
		if ($db_status == 1) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}
	}

	public function editTags(Request $request){
		$id = $request->id ;
		$value   = DB::table('tbl_tags')->where('id', $id)->first();
		return view('product.tags.editTag')->with('value', $value);
	}

	public function updateTagsInfo(Request $request){
		$tags_name  = $request->tags_name;
		$primary_id     = $request->primary_id ;

		if ($tags_name == "" ){
			echo "invalid_input" ;
			exit() ;
		}

		$data_count = DB::table('tbl_tags')
		->where('tags_name', $tags_name)
		->whereNotIn('id', [$primary_id])
		->count() ;

		if ($data_count > 0) {
			echo "duplicate_found";
			exit() ;
		}

		$data               = array();
		$data['tags_name']  = $tags_name ;
		$data['tags_slug']  = strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $tags_name)) ;
		$data['created_at'] = $this->rcdate ;

		$query = DB::table('tbl_tags')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}

	public function tagsDelete(Request $request){
		$id = $request->id ;
		$query = DB::table('tbl_tags')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}
}
