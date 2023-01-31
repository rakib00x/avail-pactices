<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;


class OtherController extends Controller
{
    public function __construct(){
    date_default_timezone_set('Asia/Dhaka');
    $this->rcdate           = date('Y-m-d');
    $this->logged_id        = Session::get('admin_id');
    $this->current_time     = date('H:i:s');
  }
  public function index(){
      return view('admin.footer.namaz');
  }
  
  public function Infofetch(){
      $namaz = DB::table('namazs')->get();
      return view('admin.footer.namazlist',compact('namaz'));
  }
   public function namazedit(Request $request){
       $id = $request->id ;
		$value   = DB::table('namazs')->where('id', $id)->first() ;
      return view('admin.footer.editnamaz',compact('value'));
  }
  
  public function changeNamazStatus(Request $request){
      	$namaz_id = $request->namaz_id;
		$status_check   = DB::table('namazs')->where('id', $namaz_id)->first() ;
		$status         = $status_check->status ;

		if ($status == 1) {
			$db_status = 2 ;
		}else{
			$db_status = 1 ;
		}

		$data           = array() ;
		$data['status'] = $db_status ;
		$query = DB::table('namazs')->where('id', $namaz_id)->update($data) ;
		if ($db_status == 1) {
			echo "success" ;
			exit() ;
		}else{
			echo "failed" ;
		}
      
  }
  public function insertNamazInfo(Request $request){
       $name = $request->name;
    
     $data              = array();
     $data['name']  = $name;
     $query = DB::table('namazs')->insert($data) ;
     if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
    
  }
  public function updateNamaz(Request $request)
	{
		$name  = $request->name ;
		
		$primary_id     = $request->primary_id ;
		$data               = array() ;
		$data['name']  = $name ;
       
		$query = DB::table('namazs')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}
	public function deleteNamaz(Request $request){
		$id = $request->id ;
		$query = DB::table('namazs')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}
  
  
   public function videoindex(){
      
      return view('admin.footer.help-center');
  }
   public function fetchvideo(){
      $help = DB::table('videos')->get();
      return view('admin.footer.helplist',compact('help'));
  }
  public function editvideo(Request $request){
       $id = $request->id ;
		$value   = DB::table('videos')->where('id', $id)->first() ;
      return view('admin.footer.editvideo',compact('value'));
  }
  
  public function insertvideoInfo(Request $request){
      $name = $request->name;
    $link = $request->link;
    
     $data              = array();
     $data['name']  = $name;
     $data['link']  =$link;
     $query = DB::table('videos')->insert($data) ;
     if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
    
  }
  public function updatevideo(Request $request)
	{
		$name  = $request->name ;
		$link  = $request->link ;
		$primary_id     = $request->p_id ;
		$data               = array() ;
		$data['name']  = $name ;
		$data['link']  = $link;
       
		$query = DB::table('videos')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}
	
 public function deleteVideo(Request $request){
		$id = $request->id ;
		$query = DB::table('videos')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}
  
  public function faqindex(){
      
      return view('admin.footer.faq-center');
  }
  public function fetchfaq(){
      $faq = DB::table('faqs')->get();
      return view('admin.footer.faqlist',compact('faq'));
  }
  public function editfaq(Request $request){
       $id = $request->id ;
		$value   = DB::table('faqs')->where('id', $id)->first() ;
      return view('admin.footer.editfaq',compact('value'));
  }
  
   public function insertfaqInfo(Request $request){
      $qun = $request->qun;
    $ans = $request->ans;
    
     $data              = array();
     $data['qun']  = $qun;
     $data['ans']  =$ans;
     $query = DB::table('faqs')->insert($data) ;
     if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
    
  }
  public function updateFaq(Request $request)
	{
		$qun  = $request->qun ;
		$ans  = $request->ans ;
		$primary_id     = $request->primary_id ;
		$data               = array() ;
		$data['qun']  = $qun ;
		$data['ans']  = $ans;
       
		$query = DB::table('faqs')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
	}
	public function deleteFaq(Request $request){
		$id = $request->id ;
		$query = DB::table('faqs')->where('id', $id)->delete() ;
		if ($query) {
			echo "success" ;
			exit();
		}else{
			echo "failed" ;
			exit() ;
		}
	}
	
	public function termsindex(Request $request){
	    $value   = DB::table('tbl_terms')->first() ;
      return view('admin.footer.termscondition.terms',compact('value'));
  }
  
  public function updatetrem(Request $request){
		$descp  = $request->descp ;
		$primary_id     = $request->primary_id ;
		$data               = array() ;
		$data['descp']  = $descp;
       
		$query = DB::table('tbl_terms')->where('id', $primary_id)->update($data) ;
		if ($query) {
			echo "success" ;
		}else{
			echo "failed" ;
		}
    
  }
  
  
  
}
