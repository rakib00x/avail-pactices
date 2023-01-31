<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use App\Http\Requests;
use DB;
use Intervention\Image\ImageManagerStatic as Image;
use Session;

class CartController extends Controller
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

        $result = DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->groupBy('cart.supplier_id')
            ->where('cart.customer_id', $customer_id)
            ->get() ;


        return view('frontEnd.order.cartdata')->with('result', $result) ;
    }
    public function startOrder(Request $request){
        
        $product_id  = $request->prod_id ;
        $quantity    = $request->quantit ;
        $size_id     = $request->siz_id ;
        $color_id    = $request->col_id ;
    

        if ($siz_id != "") {
            $main_size = $siz_id ;
        }else{
            $main_size = 0;
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
            ->where('size_id', $main_size)
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
                ->where('size_id', $main_size)
                ->where('color_id', $color_id)
                ->first() ;

            $quantity = $request->quantit + 1 ;

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
            $data['size_id']            = $main_size;
            $data['quantity']           = $quantity ;
            $data['sale_price']         = $product_price ;
            $data['single_discount']    = $discount__amount ;
            $data['total_price']        = $product_price * $quantity ;
            $data['total_discount']     = $discount__amount * $quantity ;
            $data['created_at']         = date('Y-m-d H:i:s') ;
            DB::table('cart')->insert($data) ;
        }

        return Redirect::to('cart') ;
    }
        
    

    public function getcartdata($value='')
    {

        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        $result = DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->groupBy('cart.supplier_id')
            ->where('cart.customer_id', $customer_id)
            ->get() ;

        return view('frontEnd.order.cartdata')->with('result', $result) ;
    }

    # SHOW CART PAGE 
    public function cart()
    {
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        if ($customer_id) {
            $data2 = array() ;
            $data2['status'] = 0 ;
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


        return view('frontEnd.order.cart')->with('result', $result)->with('total_product', $total_product);

    }

    # CLEAR ALL CART DATA 
    public function clearcartdata()
    {
        DB::table('cart')
            ->where('customer_id', Session::get('user_id'))
            ->delete() ;

        Session::put('success', 'Cart all data clear successfully');
        return Redirect::to('cart') ;

    }


    # REMOVE PRODUCT FROM CART 
    public function removeproductfromcart($id)
    {

        DB::table('cart')
        ->where('id', $id)
        ->delete() ;

        Session::put('success', 'Product remove successfully');
        return Redirect::to('cart') ;
    }

    # UPDATE CART DATA 
    public function updatecartdata(Request $request)
    {
        $quantity   = $request->quantity ;
        $primary_id = $request->primary_id ;

        foreach($quantity as $key => $value){
           $cart_id = $primary_id[$key] ;

           $cart_info = DB::table('cart')
                ->where('id', $cart_id)
                ->first() ;

            $total_quantity = $value ;
            $total_price    = $cart_info->sale_price * $total_quantity  ;

            $data                   = array() ;
            $data['quantity']       = $total_quantity ;
            $data['total_price']    = $total_price ;
            $data['updated_at']     = date("Y-m-d H:i:s") ;

            DB::table('cart')->where('id', $cart_id)->update($data) ;
        }

        Session::put('success', 'Cart update successfully');
        return Redirect::to('cart') ;
    }

    public function updatecartmaininfo(Request $request)
    {

        $cart_id = $request->opts ;
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        if (isset($cart_id)) {
            foreach($cart_id as $value){
                $data = array() ;
                $data['status'] = 1;
                DB::table('cart')->where('id', $value)->update($data) ;
            }

            $data2 = array() ;
            $data2['status'] = 0 ;
            DB::table('cart')->whereNotIn('id', $cart_id)->where('customer_id', $customer_id)->update($data2);
        }else{
            $data2 = array() ;
            $data2['status'] = 0 ;
            DB::table('cart')->where('customer_id', $customer_id)->update($data2);
        }
        

        $total_amount = DB::table('cart')->where('customer_id', $customer_id)->where('status', 1)->sum('total_price');
        echo $total_amount ;
    }

    public function cartIncreementupdate(Request $request)
    {   
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        $cart_id     = $request->cart_id ;
        $quantity    = $request->quantity ;
        $cart_info = DB::table('cart')->where('id', $cart_id)->first(); 
        $final_quantity = $cart_info->quantity+1 ;
        $total_price = $final_quantity * $cart_info->sale_price ;

        $data2 = array() ;
        $data2['quantity']      = $final_quantity;
        $data2['total_price']   = $total_price ;
        DB::table('cart')->where('id', $cart_id)->update($data2);

       $total_amount = DB::table('cart')->where('customer_id', $customer_id)->where('status', 1)->sum('total_price');
        echo $total_amount ;
    }    

    public function cartdecreamentupdate(Request $request)
    {   
        $cart_id     = $request->cart_id ;
        $quantity    = $request->quantity ;
        $cart_info = DB::table('cart')->where('id', $cart_id)->first(); 
        $final_quantity_s = $cart_info->quantity-1 ;
        if ($final_quantity_s < 2) {
            $final_quantity = 1 ;
        }else{
            $final_quantity = $final_quantity_s ;
        }
        
        $total_price = $final_quantity * $cart_info->sale_price ;

        $data2 = array() ;
        $data2['quantity']      = $final_quantity;
        $data2['total_price']   = $total_price ;
        DB::table('cart')->where('id', $cart_id)->update($data2);

       $total_amount = DB::table('cart')->where('customer_id', Session::get('buyer_id'))->where('status', 1)->sum('total_price');
        echo $total_amount ;
    }

    public function order()
    {
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        $result = DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->groupBy('cart.supplier_id')
            ->where('cart.customer_id', $customer_id)
            ->where('cart.status', 1)
            ->get() ;

        if ($result) {
            if (count($result) == 0) {
                Session::put('errors', 'Please select at list single item');
                return Redirect::to('cart') ;
            }
        }

        $total_order_price = DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->groupBy('cart.supplier_id')
            ->where('cart.customer_id', $customer_id)
            ->where('cart.status', 1)
            ->sum('total_price') ;

        $order_count = DB::table('cart')
            ->groupBy('supplier_id')
            ->where('cart.status', 1)
            ->count() ;


        return view('frontEnd.order.order')->with('total_order_price', $total_order_price)->with('result', $result)->with('order_count', $order_count);
    }

    public function submitorder()
    {
        if (Session::get('buyer_id') == null) {
            $customer_id = Session::get('supplier_id') ;
        }else{
            $customer_id = Session::get('buyer_id') ;
        }

        $has_active_address = DB::table('tbl_shipping_address')->where('status', 1)->first() ;
        if(!$has_active_address){
            return "shipping_not";
            exit() ;
        }

        $cart_result = DB::table('cart')
            ->where('status', 1)
            ->where('customer_id', $customer_id)
            ->groupBy('supplier_id')
            ->get() ;

        foreach ($cart_result as $key => $cartvalue) {
            $result = DB::table('cart')
                ->join('express', 'cart.supplier_id', '=', 'express.id')
                ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
                ->where('cart.customer_id', $customer_id)
                ->where('cart.supplier_id', $cartvalue->supplier_id)
                ->where('cart.status', 1)
                ->get() ;

            $total_order_price = DB::table('cart')
                ->join('express', 'cart.supplier_id', '=', 'express.id')
                ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
                ->groupBy('cart.supplier_id')
                ->where('cart.customer_id', $customer_id)
                ->where('cart.supplier_id', $cartvalue->supplier_id)
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
            $data['supplier_id']    = $cartvalue->supplier_id ;
            $data['customer_id']    = $customer_id ;
            $data['address_id']     = $has_active_address->id ;
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
        }
  

        DB::table('cart')
            ->join('express', 'cart.supplier_id', '=', 'express.id')
            ->select('cart.*', 'express.storeName', 'express.first_name', 'express.last_name')
            ->where('cart.customer_id', $customer_id)
            ->where('cart.status', 1)
            ->delete() ;

        return "success";
        exit() ;
    } 


    # INVOICE DELETE 
    public function supplierinvoice($invoice)
    {
        $result = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->leftJoin('tbl_product_color', 'order_product.color_id', '=', 'tbl_product_color.id')
            ->leftJoin('tbl_size', 'order_product.size_id', '=', 'tbl_size.id')
            ->join('express', 'order_product.customer_id', '=', 'express.id')
            ->select('order_product.*', 'tbl_size.size', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_product.product_name', 'tbl_product.slug', 'tbl_product.products_image', 'express.first_name', 'express.last_name', 'express.email', 'express.mobile')
            ->where('order_product.supplier_id', Session::get('supplier_id'))
            ->where('order_product.invoice_number', $invoice)
            ->get() ;
        
        $main_invoice_info = DB::table('order')
            ->leftJoin('tbl_shipping_address', 'order.address_id', '=', 'tbl_shipping_address.id')
            ->select('tbl_shipping_address.*', 'order.address_id', 'order.invoice_number')
            ->where('order.invoice_number', $invoice)
            ->first();


        return view('supplier.order.supplierinvoice')->with('result', $result)->with('main_invoice_info', $main_invoice_info);
    } 

    # EDIT INVOICE 
    public function editinvoice($invoice)
    {
        $result = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->leftJoin('tbl_product_color', 'order_product.color_id', '=', 'tbl_product_color.id')
            ->leftJoin('tbl_size', 'order_product.size_id', '=', 'tbl_size.id')
            ->join('express', 'order_product.customer_id', '=', 'express.id')
            ->select('order_product.*', 'tbl_size.size', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_product.product_name', 'express.first_name', 'tbl_product.products_image', 'express.last_name', 'express.email', 'express.mobile')
            ->where('order_product.supplier_id', Session::get('supplier_id'))
            ->where('order_product.invoice_number', $invoice)
            ->get() ;

        return view('supplier.order.editinvoice')->with('result', $result);
    }

    # REMOVE ITEM FORM ORDER ITEM 
    public function deleteorderitem($id)
    {
        $order_product_info = DB::table('order_product')
            ->where('id', $id)
            ->first() ;
        $order_info         = DB::table('order')->where('invoice_number', $order_product_info->invoice_number)->first() ;

        if ($order_info->total_quantity == $order_product_info->quantity) {
            DB::table('order')->where('invoice_number', $order_product_info->invoice_number)->delete() ;

            DB::table('order_product')
            ->where('id', $id)
            ->delete() ;
            return Redirect::to('supplierOrdersList/') ;
        }else{
            $db_order_quantity  = $order_info->total_quantity - $order_product_info->quantity ;
            $db_total_price     = $order_info->total_price - $order_product_info->total_price;
            $db_total_discount  = $order_info->total_discount - $order_product_info->total_discount;

            $data = array() ;
            $data['total_quantity']     = $db_order_quantity ;
            $data['total_price']        = $db_total_price ;
            $data['total_discount']     = $db_total_discount ;

            DB::table('order')->where('invoice_number', $order_product_info->invoice_number)->update($data) ;

            DB::table('order_product')
            ->where('id', $id)
            ->delete() ;

            return Redirect::to('editinvoice/'.$order_info->invoice_number) ;
        }

    }


    # REMOVE ITEM FORM ORDER ITEM 
    public function deletesellerorderitem($id)
    {
        $order_product_info = DB::table('order_product')
            ->where('id', $id)
            ->first() ;
        $order_info         = DB::table('order')->where('invoice_number', $order_product_info->invoice_number)->first() ;

        if ($order_info->total_quantity == $order_product_info->quantity) {
            DB::table('order')->where('invoice_number', $order_product_info->invoice_number)->delete() ;

            DB::table('order_product')
            ->where('id', $id)
            ->delete() ;
            return Redirect::to('sellerOrdersList/') ;
        }else{
            $db_order_quantity  = $order_info->total_quantity - $order_product_info->quantity ;
            $db_total_price     = $order_info->total_price - $order_product_info->total_price;
            $db_total_discount  = $order_info->total_discount - $order_product_info->total_discount;

            $data = array() ;
            $data['total_quantity']     = $db_order_quantity ;
            $data['total_price']        = $db_total_price ;
            $data['total_discount']     = $db_total_discount ;

            DB::table('order')->where('invoice_number', $order_product_info->invoice_number)->update($data) ;

            DB::table('order_product')
            ->where('id', $id)
            ->delete() ;

            return Redirect::to('editsellerinvoice/'.$order_info->invoice_number) ;
        }

    }

    # UPDATE SUPPLIER INVOICE
    public function updateinvoiceupdate(Request $request)
    {
        $sale_price     = $request->sale_price ;
        $quantity       = $request->quantity ;
        $primary_id     = $request->primary_id ;
        $invoice_number = $request->invoice_number ;


        $total_price = 0 ;
        $total_quantity = 0 ;
        foreach($primary_id as $key=> $value){
            $total_quantity += $quantity[$key];
            $total_price    +=  $quantity[$key] * $sale_price[$key];

            $data = array() ;
            $data['sale_price']   = $sale_price[$key] ;
            $data['quantity']     = $quantity[$key] ;
            $data['total_price']  = $quantity[$key] * $sale_price[$key] ;
            $data['status']       = 1 ;
            $data['updated_at']   = date("Y-m-d H:i:s") ;

            DB::table('order_product')->where('id', $value)->update($data) ;
        }

        $data2                      = array() ;
        $data2['total_quantity']    = $total_quantity ;
        $data2['total_price']       = $total_price ;
        $data2['status']            = 1 ;
        $data2['updated_at']        = date("Y-m-d H:i:s") ;
        DB::table('order')->where('invoice_number', $invoice_number)->update($data2) ;

        $notification = array(
            'message'       => 'Order Information Update Successfully',
            'alert-type'    => 'success'
        );

        return Redirect::to('supplierOrdersList/')->with($notification) ;

    }


    # UPDATE SUPPLIER INVOICE
    public function updatesellerinvoiceupdate(Request $request)
    {
        $sale_price     = $request->sale_price ;
        $quantity       = $request->quantity ;
        $primary_id     = $request->primary_id ;
        $invoice_number = $request->invoice_number ;


        $total_price = 0 ;
        $total_quantity = 0 ;
        foreach($primary_id as $key=> $value){
            $total_quantity += $quantity[$key];
            $total_price    +=  $quantity[$key] * $sale_price[$key];

            $data = array() ;
            $data['sale_price']   = $sale_price[$key] ;
            $data['quantity']     = $quantity[$key] ;
            $data['total_price']  = $quantity[$key] * $sale_price[$key] ;
            $data['status']       = 1 ;
            $data['updated_at']   = date("Y-m-d H:i:s") ;

            DB::table('order_product')->where('id', $value)->update($data) ;
        }

        $data2                      = array() ;
        $data2['total_quantity']    = $total_quantity ;
        $data2['total_price']       = $total_price ;
        $data2['status']            = 1 ;
        $data2['updated_at']        = date("Y-m-d H:i:s") ;
        DB::table('order')->where('invoice_number', $invoice_number)->update($data2) ;

        $notification = array(
            'message'       => 'Order Information Update Successfully',
            'alert-type'    => 'success'
        );

        return Redirect::to('sellerOrdersList/')->with($notification) ;

    }

    # CART INFO 
    public function allinvoice()
    {

        $result = DB::table('order')
            ->join('express as supplier', 'order.supplier_id', '=', 'supplier.id')
            ->join('express', 'order.customer_id', '=', 'express.id')
            ->select('order.*', 'express.first_name', 'express.last_name', 'express.email', 'express.mobile', 'supplier.storeName', 'supplier.email as supplieremail')
            ->where('order.status', 1)
            ->get() ;

        return view('admin.order.allinvoice')->with('result', $result) ;
    }

    # invoice details 
    public function invoicedetails($invoice)
    {
         $result = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->leftJoin('tbl_product_color', 'order_product.color_id', '=', 'tbl_product_color.id')
            ->leftJoin('tbl_size', 'order_product.size_id', '=', 'tbl_size.id')
            ->join('express', 'order_product.customer_id', '=', 'express.id')
            ->select('order_product.*', 'tbl_size.size', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_product.product_name', 'tbl_product.products_image', 'express.first_name', 'express.last_name', 'express.email', 'express.mobile')
            ->where('order_product.invoice_number', $invoice)
            ->get() ;

        return view('admin.order.invoicedetails')->with('result', $result);
    }
    
    # ORDER CONFIRM 
    public function supplierOrderConfirm($invoice){
        

        $data = array() ;
        $data['status']       = 1 ;
        $data['updated_at']   = date("Y-m-d H:i:s") ;

        DB::table('order_product')->where('invoice_number', $invoice)->update($data) ;

        $data2                      = array() ;
        $data2['status']            = 1 ;
        $data2['updated_at']        = date("Y-m-d H:i:s") ;
        DB::table('order')->where('invoice_number', $invoice)->update($data2) ;
        
        $notification = array(
            'message'       => 'Order Confirm Successfully',
            'alert-type'    => 'success'
        );

        return back()->with($notification) ;
    }

    # SELLER SECTION 
    public function sellerinvoice($invoice)
    {
        $result = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->leftJoin('tbl_product_color', 'order_product.color_id', '=', 'tbl_product_color.id')
            ->leftJoin('tbl_size', 'order_product.size_id', '=', 'tbl_size.id')
            ->join('express', 'order_product.customer_id', '=', 'express.id')
            ->select('order_product.*', 'tbl_size.size', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_product.product_name', 'tbl_product.slug', 'tbl_product.products_image', 'express.first_name', 'express.last_name', 'express.email', 'express.mobile')
            ->where('order_product.supplier_id', Session::get('supplier_id'))
            ->where('order_product.invoice_number', $invoice)
            ->get() ;
        
        $main_invoice_info = DB::table('order')
            ->leftJoin('tbl_shipping_address', 'order.address_id', '=', 'tbl_shipping_address.id')
            ->select('tbl_shipping_address.*', 'order.address_id', 'order.invoice_number')
            ->where('order.invoice_number', $invoice)
            ->first();


        return view('seller.order.sellerinvoice')->with('result', $result)->with('main_invoice_info', $main_invoice_info);
    }

    public function editsellerinvoice($invoice)
    {
        $result = DB::table('order_product')
            ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
            ->leftJoin('tbl_product_color', 'order_product.color_id', '=', 'tbl_product_color.id')
            ->leftJoin('tbl_size', 'order_product.size_id', '=', 'tbl_size.id')
            ->join('express', 'order_product.customer_id', '=', 'express.id')
            ->select('order_product.*', 'tbl_size.size', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_product.product_name', 'express.first_name', 'tbl_product.products_image', 'express.last_name', 'express.email', 'express.mobile')
            ->where('order_product.supplier_id', Session::get('supplier_id'))
            ->where('order_product.invoice_number', $invoice)
            ->get() ;

        return view('seller.order.editsellerinvoice')->with('result', $result);
    }
    



}
