<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;

class TermsConditionController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate       = date('Y-m-d');
        $this->loged_id     = Session::get('admin_id');
        $this->current_time = date("H:i:s");
        $this->date_time = date("Y-m-d H:i:s");
    }

    # supplier terms and conditions 
    public function suppliertermsconditions()
    {
        $result = DB::table('tbl_supplier_terms_conditions')->where('supplier_id', Session::get('supplier_id'))->orderBy('id', 'desc')->get() ;
        return view('supplier.terms.suppliertermsconditions')->with('result', $result) ;
    }

    # INSERT TERMS AND CONDITIONS 
    public function insertSupplierTermsconditions(Request $request)
    {
        $conditions_name    = trim($request->conditions_name) ;
        $conditions_details = trim($request->conditions_details) ;

        $data                       = array() ;
        $data['supplier_id']        = Session::get('supplier_id') ;
        $data['conditions_name']    = $conditions_name ;
        $data['conditions_details'] = $conditions_details ;
        $data['status']             = 2 ;
        $data['created_at']         = $this->date_time ;

        DB::table('tbl_supplier_terms_conditions')->insert($data);
        echo "success" ;

    }

    # CHANGE CONDITIONS STATUS 
    public function changesupplierconditions(Request $request)
    {
        $terms_id = $request->terms_id ;
        $terms_info = DB::table('tbl_supplier_terms_conditions')->where('id', $terms_id)->first() ;

        if($terms_info->status == 1)
        {
            $status = 2;
        }else{
            $status = 1 ;
        }

        $data = array() ;
        $data['status'] = $status;
        DB::table('tbl_supplier_terms_conditions')->where('id', $terms_id)->update($data) ;

        echo "success";
    }

    # EDIT SUPPLIER CONDITIONS 
    public function editSupplierConditions(Request $request)
    {
        $condition_id = $request->condition_id ;

        $value = DB::table('tbl_supplier_terms_conditions')
            ->where('id', $condition_id)
            ->first() ;

        return view('supplier.terms.editSupplierConditions')->with('value', $value) ;
    }

    # UPDATE SUPPLIER TERMS AND CONDITIONS
    public function updateSupplierTermsconditions(Request $request)
    {
        $conditions_name    = trim($request->conditions_name) ;
        $conditions_details = trim($request->conditions_details) ;
        $primary_id         = trim($request->primary_id) ;

        $data                       = array() ;
        $data['conditions_name']    = $conditions_name ;
        $data['conditions_details'] = $conditions_details ;
        $data['updated_at']         = $this->date_time ;

        DB::table('tbl_supplier_terms_conditions')->where('id', $primary_id)->update($data);
        echo "success" ;
    }

    # DELETE TERMS AND CONDITIONS 
    public function deleteTermsAndCoditions($terms_id)
    {
        DB::table('tbl_supplier_terms_conditions')->where('id', $terms_id)->delete() ;
        Session::put('success','Conditions Delete Successfully');
        return back() ;
    }
}
