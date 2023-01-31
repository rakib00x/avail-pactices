<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;

class employeeSectionController extends Controller
{
    public function __construct(){
    date_default_timezone_set('Asia/Dhaka');
    $this->rcdate           = date('Y-m-d');
    $this->logged_id        = Session::get('admin_id');
    $this->current_time     = date('H:i:s');
  }

/*start District */

  public function district(){
    return view('admin.employee.district.index');
  }
  public function insertDistric(Request $request){
     $request->validate([
             'name'=>'required'
        ]);
        $name = $request->name;

    $data_count = DB::table('districts')
    ->where('name', $name)
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }
    $data              = array();
    $data['name'] = $name;
    $query = DB::table('districts')->insert($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }

  }
  public function fectchDistrict(Request $request){
    $result = DB::table('districts')->orderBy('id', 'asc')->get() ;
    return view('admin.employee.district.getAllDistrict')->with('result', $result) ;
  }
    public function editDistrict(Request $request)
  {
    $id = $request->id ;
    $value   = DB::table('districts')->where('id', $id)->first() ;
    return view('admin.employee.district.updateDistrict')->with('value', $value);
  }
  public function updateDistrict(Request $request){

    $request->validate([
             'name'=>'required'
        ]);
       $name = $request->name;
       $id     = $request->id;

    $data              = array();
    $data['name'] = $name;
    $data['id']    = $id ;
    $query = DB::table('districts')->where('id', $id)->update($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }



  }
  public function deleteDistrict(Request $request){
    $id = $request->id ;
    $query = DB::table('districts')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }

  }
  public function changeDistrictStatus(Request $request)
  {
    $id = $request->id;

    $status_check   = DB::table('districts')->where('id', $id)->first() ;
    $status         = $status_check->status;

    if ($status == 1) {
      $db_status = 2 ;
    }else{
      $db_status = 1 ;
    }

    $data           = array() ;
    $data['status'] = $db_status ;
    $query = DB::table('districts')->where('id', $id)->update($data) ;
    if ($db_status == 1) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
    }

  }
  /*end District */
  /*Strat thana */
  public function thana(){
    $dataDistrict = DB::table('districts')->orderBy('id', 'asc')->get() ;
    return view('admin.employee.thana.index',compact('dataDistrict'));
  }
  public function insertThana(Request $request){
    $request->validate([
             'name'=>'required',
             'district_id'=>'required'
        ]);
        $name = $request->name;
        $district_id = $request->district_id;

    $data_count = DB::table('thanas')
    ->where('name', $name)
    ->count() ;

    if ($data_count > 0) {
      echo "duplicate_found";
      exit() ;
    }
    $data              = array();
    $data['name'] = $name;
    $data['district_id'] = $district_id;
    $query = DB::table('thanas')->insert($data) ;
    if ($query) {
      echo "success" ;
    }else{
      echo "failed" ;
    }
  }
   public function fectchThana(Request $request){
    $result = DB::table('thanas')->orderBy('id', 'asc')->get() ;
    return view('admin.employee.thana.getAllThanan')->with('result', $result);
  }
  public function editThana(Request $request){
     $id = $request->id ;
    $value   = DB::table('thanas')->where('id', $id)->first() ;
    return view('admin.employee.thana.editThana')->with('value', $value); 

  
  }
  public function updateThana(Request $request){
    $request->validate([
             'name'=>'required',
             'district_id' =>'required'
        ]);
       $name = $request->name;
       $id     = $request->id;
       $district_id   = $request->district_id;
     
    $data              = array();
    $data['name'] = $name;
    $data['district_id']    = $district_id ;
    
    //  dd($data);
    $query = DB::table('thanas')->where('id', $id)->update($data) ;
    if ($query) {
      echo "success";
    }else{
      echo "failed";
    }



  }
  public function deleteThana(Request $request){
    $id = $request->id ;
    $query = DB::table('thanas')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }

  }
  public function changeThanaStatus(Request $request){
    $id = $request->id;
    $status_check   = DB::table('thanas')->where('id', $id)->first() ;
    $status         = $status_check->status;

    if ($status == 1) {
      $db_status = 2 ;
    }else{
      $db_status = 1 ;
    }

    $data           = array() ;
    $data['status'] = $db_status ;
    $query = DB::table('thanas')->where('id', $id)->update($data) ;
    if ($db_status == 1) {
      echo "success" ;
      exit() ;
    }else{
      echo "failed" ;
    }

  }

  public function getThana(Request $request){
    $district_id = $request->district_id ;

        $district = DB::table('thanas')
                    ->where('district_id', $district_id)
                    ->get() ;

        echo "<option value=''>Select Thana</option>";
        foreach ($district as $value) {
            echo '<option value="'. $value->id.'">'.$value->name.'</option>' ;
        }
  }

  public function employeeList(){
    $result = DB::table('marketings')->orderBy('id', 'desc')->get() ;
    return view('admin.employee.list',compact('result'));
  }
  public function loginWithEmployee($id)
    {
      $query = DB::table('marketings')->where('id', $id)->first() ;
      Session::put('email', $query->email);
      Session::put('LoggedUser', $query->id);
      Session::put('LoggedInfo', $query->name);
      return Redirect::to('marketing/dasboard') ;
    }
  
   public function Deleteemployee(Request $request){
       
    $id = $request->id ;
      $image = DB::table('marketings')->where('id', $id)->first();
      
      $image_path = public_path('images/marketing/' .$image->photo);
        if ($image->photo && file_exists($image_path)) {
                    unlink($image_path);
                }
    $query = DB::table('marketings')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }

  }
  
  public function viewEmployeeSupplier(Request $request){
      $id = $request->id;
      $result = DB::table('express')->where('marketing_id', $id)->get();
      return view('admin.employee.employeeSupplier')->with('result' ,$result) ;
      
  }
  public function paymeentEmployee(){
      $result = DB::table('marketings')->orderBy('id', 'asc')->get() ;
      return view('admin.employee.paymeentEmployee')->with('result',$result) ;
      
  }
  public function listEmpllist(){
    $result = DB::table('marketings')->orderBy('id', 'asc')->get() ;
    
    dd($result);
    exit();
      return view('admin.employee.getEmployee')->with('result',$result) ;
      
  }
  public function payEmployee(Request $request){
        $id = $request->id;
        
         $supplier = DB::table('express')->where('marketing_id', $id)->get();
         
          $price_pro = 0;
         foreach($supplier as $value1){
           $supplierss = DB::table('tbl_product')->where('supplier_id', $value1->id)->count();
          if($supplierss > 10){
            $price_pro += $supplierss * 2;  
          }else{
             $price_pro = 0; 
          }
          
          
         }
            
       

      
      $value = DB::table('marketings')->where('id', $id)->first();
      return view('admin.employee.paymeent')->with('value' ,$value)->with('price_pro' ,$price_pro);
      
  }
  
  public function updateEmployee(Request $request){
       $shop_list = $request->shop_list;
       $peanding_amount     = $request->peanding_amount;
       $confirm_amount     = $request->confirm_amount;
       $balance     = $request->balance;
       $rate     = $request->rate;
       $id   = $request->id;
       
      
       
       
     
    $data              = array();
    $data['shop_list'] = $shop_list;
    $data['peanding_amount'] = $peanding_amount;
    $data['confirm_amount'] = $confirm_amount;
    $data['balance'] = $balance;
    $data['rate'] = $rate;
    $data['id']    = $id ;
    
    $query = DB::table('marketings')->where('id', $id)->update($data) ;
    if ($query) {
      echo "success";
    }else{
      echo "failed";
    }

      
  }
  
}




