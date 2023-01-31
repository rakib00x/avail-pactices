<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use ImageOptimizer;
use DB;
use Session;
use Image;

class MobileBankController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->loged_id     = Session::get('admin_id');
        $this->current_time = date("H:i:s");
        $this->date_time    = date('Y-m-d H:i:s') ;
    }

    # MOBILE BANK LIST 
    public function mobilebanklist()
    {
        return view('admin.mobile_bank.mobilebanklist');
    }

    public function getallmobilebank()
    {
        $result = DB::table('tbl_mobile_bank')
            ->get();

        return view('admin.mobile_bank.getallmobilebank')->with('result', $result) ;
    }

    # INSERT MOBILE BANK INFORMATION 
    public function insertMobileBankInfo(Request $request)
    {
         $request->validate([
            'bank_name' => 'required',
            'counter_number' => 'required',
            'payment_number' => 'required',
            'bank_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]); 
        
        $bank_name      = $request->bank_name ;
        $counter_number = $request->counter_number ;
        $payment_number = $request->payment_number ;
        $bank_logo      = $request->bank_logo ;

        if($bank_name == "" || $counter_number == "" || $payment_number == ""){
            echo "all_filed_are_required";
            exit() ;
        }

        $check_count = DB::table('tbl_mobile_bank')
            ->where('bank_name', $bank_name)
            ->count() ;

        if($check_count > 0)
        {
            echo "duplicate_found" ;
            exit();
        }

        $data = array() ;
        $data['bank_name']      = $bank_name;
        $data['counter_number'] = $counter_number;
        $data['payment_number'] = $payment_number;
        // $data['bank_logo']      = $bank_logo;
        $data['status']         = 1;
        $data['created_at']     = $this->date_time;
        
        
        if ($request->hasFile('bank_logo')) {
            $image = $request->file('bank_logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(1000,450)->save(base_path('public/images/mobileBank/') . $new_image_name);
            $data['bank_logo']  = $new_image_name;
        } 
        

        $query = DB::table('tbl_mobile_bank')->insert($data);
        if($query){
            echo "success";
            exit() ;
        }else{
            echo "failed";
            exit() ;
        }
    }

    # CHANGE MOBILE BANK STATUS 
    public function changemobilebankstatus(Request $request)
    {
        $bank_id = $request->bank_id;

        $info = DB::table('tbl_mobile_bank')
            ->where('id', $bank_id)
            ->first() ;

        $main_status = $info->status ;
        if($main_status == 1){
            $status = 2;
        }else{
            $status = 1;
        }

        $data = array();
        $data['status'] = $status ;
        $data['updated_at'] = $this->date_time ;

        DB::table('tbl_mobile_bank')->where('id', $bank_id)->update($data) ;
        if($status == 1){
            echo "success";
            exit() ;
        }else{
            echo "failed";
            exit() ;
        }
        
    }

    # MOBILE BANK EDIT FORM 
    public function editmobileBank(Request $request)
    {
        $bank_id = $request->id ;
        $bank_info = DB::table('tbl_mobile_bank')
            ->where('id', $bank_id)
            ->first() ;

        return view('admin.mobile_bank.editmobileBank')->with('bank_info', $bank_info) ;
    }

    # UPDATE MOBILE BANK INFORMATION 
    public function updateMobileBankInfo(Request $request)
    {
        $request->validate([
            'bank_name' => 'required',
            'counter_number' => 'required',
            'payment_number' => 'required',
        ]);
        $bank_name      = $request->bank_name ;
        $counter_number = $request->counter_number ;
        $payment_number = $request->payment_number ;
        $bank_logo      = $request->slected_category_icon ;
        $primary_id     = $request->primary_id ;
        
        $image = DB::table('tbl_mobile_bank')->where('id', $primary_id)->first() ;

        if($bank_name == "" || $counter_number == "" || $payment_number == ""){
            echo "all_filed_are_required";
            exit() ;
        }

        $check_count = DB::table('tbl_mobile_bank')
            ->where('bank_name', $bank_name)
            ->whereNotIn('id', [$primary_id])
            ->count() ;

        if($check_count > 0)
        {
            echo "duplicate_found" ;
            exit();
        }

        $data = array() ;
        $data['bank_name']      = $bank_name;
        $data['counter_number'] = $counter_number;
        $data['payment_number'] = $payment_number;
        // if($bank_logo){
        //     $data['bank_logo']      = $bank_logo;
        // }
        $data['updated_at']     = $this->date_time;
        
        if ($request->hasFile('bank_logo')) {
            $image_path = public_path('images/mobileBank/' .$image->bank_logo);
        if ($image->bank_logo && file_exists($image_path)) {
                    unlink($image_path);
                }
            $image = $request->file('bank_logo');
            $new_image_name = rand() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(500,500)->save(base_path('public/images/mobileBank/') . $new_image_name);
            $data['bank_logo']  = $new_image_name;
        } 
        

        $query = DB::table('tbl_mobile_bank')->where('id', $primary_id)->update($data);
        if($query){
            echo "success";
            exit() ;
        }else{
            echo "failed";
            exit() ;
        }
    }
  public function bankMobileDelete(Request $request){
       $id = $request->id ;
    $image = DB::table('tbl_mobile_bank')->where('id', $id)->first() ;
      $image_path = public_path('images/mobileBank/' .$image->bank_logo);
        if ($image->bank_logo && file_exists($image_path)) {
                    unlink($image_path);
        }
    $query = DB::table('tbl_mobile_bank')->where('id', $id)->delete() ;
    if ($query) {
      echo "success" ;
      exit();
    }else{
      echo "failed" ;
      exit() ;
    }
  }

}
