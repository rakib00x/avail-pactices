<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Session;

class MobileCartController extends Controller
{
    // basic function
    private $rcdate;
    private $logged_id;
    private $current_time;
    private $date_time;

    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate           = date('Y-m-d');
        $this->logged_id        = Session::get('admin_id');
        $this->current_time     = date('H:i:s');
        $this->date_time     = date('Y-m-d H:i:s');
    }


    # CART SECTION 
    public function addtocart(Request $request)
    {
        $product_id  = $request->product_id ;
        $quantity    = $request->quantity ;
        $size_id     = $request->size_id ;
        $color_id    = $request->color_id ;

        if ($size_id != "") {
            $main_size_id = $size_id ;
        }else{
            $main_size_id = 0;
        }

        if (Session::get('buyer_id') == null && Session::get('supplier_id') == null) {
            echo "invalid_login" ;
            exit() ;
        }

        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        $auth_number = Session::get('auth_number') ;
        $track_no    = Session::get('track_no') ;

        $check__product_count = DB::table('cart')
            ->where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->where('size_id', $main_size_id)
            ->where('color_id', $color_id)
            ->count();

        $product_info = DB::table('tbl_product')
            ->where('id', $product_id)
            ->first() ;

        if ($product_info->supplier_id == $customer_id) {
            echo "supplier_not_buy";
            return false ;
        }


        $product_price_info = DB::table('tbl_product_price')
            ->where('product_id',$product_id)
            ->orderBy('id','desc')
            ->first() ;

        if ($check__product_count > 0) {

            $check__product_info = DB::table('cart')
                ->where('product_id', $product_id)
                ->where('customer_id', $customer_id)
                ->where('size_id', $main_size_id)
                ->where('color_id', $color_id)
                ->first() ;

            $quantity = $request->quantity + 1 ;

            $data = array() ;
            $data['quantity']       = $quantity ;
            $data['total_price']    = $check__product_info->sale_price * $quantity ;
            $data['updated_at']     = date('Y-m-d H:i:s') ;

            DB::table('cart')
            ->where('product_id', $product_id)
            ->where('customer_id', $customer_id)
            ->where('size_id', $main_size_id)
            ->where('color_id', $color_id)
            ->update($data) ;

        }else{

            $discount_count = DB::table('tbl_product')
                ->where('offer_start', '<=', $this->date_time)
                ->where('offer_end', '>=', $this->date_time)
                ->where('id', $product_id)
                ->count() ;

            if ($discount_count){
                if ($product_price_info->discount_type == 1) {
                    $product_price = $product_price_info->product_price - $product_price_info->discount ;
                    $discount__amount = $product_price_info->discount ;
                }else{
                    $discount__amount = $product_price_info->product_price * $product_price_info->discount /100 ;
                    $product_price = $product_price_info->product_price - $discount__amount ;
                }
               
            }else{
                $discount__amount   = 0 ;
                $product_price      = $product_price_info->product_price ;
            }

            $data = array() ;
            $data['auth_number']        = $auth_number ;
            $data['tracking_number']    = $track_no ;
            $data['customer_id']        = $customer_id ;
            $data['supplier_id']        = $product_info->supplier_id ;
            $data['product_id']         = $product_id ;
            $data['color_id']           = $color_id ;
            $data['size_id']            = $main_size_id ;
            $data['quantity']           = $quantity ;
            $data['sale_price']         = $product_price ;
            $data['single_discount']    = $discount__amount ;
            $data['total_price']        = $product_price * $quantity ;
            $data['total_discount']     = $discount__amount * $quantity ;
            $data['created_at']         = date('Y-m-d H:i:s') ;
            DB::table('cart')->insert($data) ;
        }


        echo "success" ;
    }

    # CART PAGE 
    public function cart()
    {
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        if ($customer_id) {
            $data2 = array() ;
            $data2['status'] = 1 ;
            DB::table('cart')->where('customer_id', $customer_id)->update($data2);
        }

        $result = DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->groupBy('cart.supplier_id')
            ->where('cart.customer_id', $customer_id)
            ->get() ;


        $total_product = DB::table('cart')
            ->where('cart.customer_id', $customer_id)
            ->count();


        return view('mobile.cart')->with('result', $result)->with('total_product', $total_product);
    }

    public function mobilecartupdate(Request $request)
    {
        $cart_id     = $request->cart_id ;
        $quantity    = $request->quantity ;

        $cart_info = DB::table('cart')->where('id', $cart_id)->first(); 
        
        
        $total_price = $quantity * $cart_info->sale_price ;

        $data2 = array() ;
        $data2['quantity']      = $quantity;
        $data2['total_price']   = $total_price ;
        DB::table('cart')->where('id', $cart_id)->update($data2);

        echo "success" ;
        exit() ;
    }

    public function checkout($supplier_id = null)
    {

        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

       if ($supplier_id) {
           $total_amount = DB::table('cart')
            ->where('supplier_id', $supplier_id)
            ->where('customer_id', $customer_id)
            ->sum('total_price') ;

            $total_discount = DB::table('cart')
            ->where('supplier_id', $supplier_id)
            ->where('customer_id', $customer_id)
            ->sum('total_discount') ;

            $customer_info = DB::table('express')
                ->where('id', $customer_id)
                ->first() ;

            return view('mobile.checkout')->with('total_amount', $total_amount)->with('total_discount', $total_discount)->with('customer_info', $customer_info)->with('supplier_id', $supplier_id);
       }else{
        $total_amount   = 0; 
        $total_discount = 0; 

        $customer_info  = DB::table('express')
                ->where('id', $customer_id)
                ->first() ;

            return view('mobile.checkout')->with('total_amount', $total_amount)->with('total_discount', $total_discount)->with('customer_info', $customer_info)->with('supplier_id', 0);
       }
    }

    public function mobileorderplace($supplier_id)
    {
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }


        $result = DB::table('cart')
                ->join('express', 'cart.supplier_id', '=', 'express.id')
                ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
                ->where('cart.customer_id', $customer_id)
                ->where('cart.supplier_id', $supplier_id)
                ->where('cart.status', 1)
                ->get() ;

        $total_order_price = DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->groupBy('cart.supplier_id')
            ->where('cart.customer_id', $customer_id)
            ->where('cart.supplier_id', $supplier_id)
            ->where('cart.status', 1)
            ->sum('total_price') ;

        $total_quantity = 0 ;
        $total_discount = 0 ;
        foreach($result as $value)
        {
            $total_quantity += $value->quantity ;
            $total_discount += $value->total_discount ;
        }

        $invoice = rand(999999, 111111) ;

        $data = array() ;
        $data['invoice_number'] = $invoice ;
        $data['supplier_id']    = $supplier_id ;
        $data['customer_id']    = $customer_id ;
        $data['total_quantity'] = $total_quantity ;
        $data['total_price']    = $total_order_price ;
        $data['total_discount'] = $total_discount ;
        $data['status']         = 0 ;
        $data['created_at']     = date("Y-m-d H:i:s") ;

        DB::table('order')->insert($data) ;

        foreach($result as $value2)
        {
            $data2 = array() ;
            $data2['invoice_number'] = $invoice ;
            $data2['auth_number'] = $value2->auth_number ;
            $data2['tracking_number'] = $value2->tracking_number ;
            $data2['customer_id'] = $value2->customer_id ;
            $data2['supplier_id'] = $value2->supplier_id ;
            $data2['product_id'] = $value2->product_id ;
            $data2['color_id'] = $value2->color_id ;
            $data2['size_id'] = $value2->size_id ;
            $data2['quantity'] = $value2->quantity ;
            $data2['sale_price'] = $value2->sale_price ;
            $data2['single_discount'] = $value2->single_discount ;
            $data2['total_price'] = $value2->total_price ;
            $data2['total_discount'] = $value2->total_discount ;
            $data2['status'] = 0 ;
            $data2['created_at'] = date("Y-m-d H:i:s") ;

            DB::table('order_product')->insert($data2) ;
        }


        DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->where('cart.customer_id', $customer_id)
            ->where('cart.status', 1)
            ->delete() ;

        return Redirect::to('m/ordersuccess') ;
    }

    public function ordersuccess()
    {
        return view('mobile.ordersuccess') ;
    }
    
    public function removemobilecart($id)
    {
        DB::table('cart')
        ->where('id', $id)
        ->delete() ;

        Session::put('success', 'Product remove successfully');
        return back() ;
    }

}
