<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;

class ReviewController extends Controller
{
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate           = date('Y-m-d');
        $this->logged_id        = Session::get('admin_id');
        $this->current_time     = date('H:i:s');
        $this->current_date_time = date("Y-m-d H:i:s") ;
        $this->random_number_one = rand(10000 , 99999).mt_rand(1000000000, 9999999999);
    }

    # INSERT CUSTOMER REVIEW 
    public function insertReviewInfo(Request $request)
    {
        $product_id = $request->product_id ;
        $rating     = $request->rating ;
        $review     = $request->review ;
        $main_login_id     = $request->main_login_id ;


        if ($rating == 1) {
            $review_percentage = 20 ;
        }elseif($rating == 2){
            $review_percentage = 40;
        }elseif($rating == 3){
            $review_percentage = 60 ;
        }elseif ($rating == 4) {
            $review_percentage = 80 ;
        }else{
            $review_percentage = 100 ;
        }
        
        # PRODUCT INFORMATION
        $product_info = DB::table('tbl_product')->where('id', $product_id)->first() ;

        $data = array() ;
        $data['product_id']         = $product_id ;
        $data['supplier_id']        = $product_info->supplier_id ;
        $data['buyer_id']           = $main_login_id ;
        $data['review_star']        = $rating ;
        $data['review_percentage']  = $review_percentage ;
        $data['review_details']     = $review ;
        $data['status']             = 0;
        $data['created_at']         = $this->rcdate ;

        DB::table('tbl_reviews')->insert($data) ;
        echo "success" ;
    }

    # SUPPLIER ALL REVIEW 
    public function supplierAllReview()
    {
        $result = DB::table('tbl_reviews')
            ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
            ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name', 'tbl_product.slug')
            ->where('tbl_product.supplier_id', Session::get('supplier_id'))
            ->orderBy('tbl_reviews.id', 'desc')
            ->get() ;

        return view('supplier.review.supplierAllReview')->with('result', $result) ;
    }

    # SUPPLIER REIVEW STATUS CHANGE SUCCESSFULLY
    public function changeSupplierReviewStatus(Request $request)
    {

        $review_id = $request->review_id ;
        $review_info = DB::table('tbl_reviews')->where('id', $review_id)->first() ;
        $main_status = $review_info->status ;
        if ($main_status == 0) {
            $status = 1 ;
        }else{
            $status = 0 ;
        }

        $data = array() ;
        $data['status']     = $status ;
        $data['updated_at'] = $this->rcdate ;

        DB::table('tbl_reviews')->where('id', $review_id)->update($data);
        echo "success" ;
    }

    # REVIEW DETAIL S
    public function getSupplierReviewDetails(Request $request)
    {
        $id = $request->id ;

        $review_info = DB::table('tbl_reviews')
            ->join('express', 'tbl_reviews.buyer_id', '=', 'express.id')
            ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
            ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name','express.storeName', 'express.first_name', 'express.last_name', 'express.type', 'express.email as customeremail')
            ->where('tbl_product.supplier_id', Session::get('supplier_id'))
            ->where('tbl_reviews.id', $id)
            ->first() ;

        return view('supplier.review.getSupplierReviewDetails')->with('review_info', $review_info) ;
    }

    # REVIEW DELETE BY SUPPLIER 
    public function deleteSupplierReview(Request $request)
    {
        $id = $request->id ;
        DB::table('tbl_reviews')->where('id', $id)->delete() ;
        echo "success" ;
    }


    # ALL REVIEW SHOW FOR ADMIN
    public function allReviews()
    {
        $result = DB::table('tbl_reviews')
            ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_product.supplier_id', '=', 'express.id')
            ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name', 'tbl_product.slug', 'express.first_name', 'express.last_name', 'express.storeName')
            ->orderBy('id', 'desc')
            ->get() ;

        return view('admin.review.allReviews')->with('result', $result) ;
    }

    public function getAdminReviewDetails(Request $request)
    {
        $review_info = DB::table('tbl_reviews')
            ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
            ->join('express', 'tbl_product.supplier_id', '=', 'express.id')
            ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name', 'express.first_name', 'express.last_name', 'express.storeName')
            ->where('tbl_reviews.id', $request->id)
            ->first() ;

        return view('admin.review.getAdminReviewDetails')->with('review_info', $review_info) ;
    }
    
    # GET REVIEW MORE 
    public function getmorereviewdata(Request $request)
    {
        $lenthcount = $request->lenthcount ;
        $product_id = $request->product_id ;
        
        $all_review_pa = DB::table('tbl_reviews')
        ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
        ->join('express', 'tbl_reviews.buyer_id', '=', 'express.id')
        ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name','express.storeName', 'express.first_name', 'express.last_name', 'express.type', 'express.email as customeremail','express.image')
        ->where('tbl_reviews.product_id', $product_id)
        ->orderBy('tbl_reviews.id', 'desc')
        ->where('tbl_reviews.status', 1)
        ->offset($lenthcount)
        ->limit(6)
        ->get() ;
        
        return view('frontEnd.getmorereviewdata')->with('all_review_pa', $all_review_pa);
    }

    
    # SUPPLIER ALL REVIEW 
    public function sellerAllReview()
    {
        $result = DB::table('tbl_reviews')
            ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
            ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name', 'tbl_product.slug')
            ->where('tbl_product.supplier_id', Session::get('supplier_id'))
            ->orderBy('tbl_reviews.id', 'desc')
            ->get() ;

        return view('seller.review.sellerAllReview')->with('result', $result) ;
    }
}
