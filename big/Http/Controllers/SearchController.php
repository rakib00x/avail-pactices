<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;

use DB;
use Session;
use Str;
use Input;
use Hash;
use Mail;

class SearchController extends Controller
{
    
    public function __construct(){
        date_default_timezone_set('Asia/Dhaka');
        $this->rcdate           = date('Y-m-d');
        $this->logged_id        = Session::get('admin_id');
        $this->current_time     = date('H:i:s');
        $this->current_date_time = date("Y-m-d H:i:s") ;
        $this->random_number_one = rand(10000 , 99999).mt_rand(1000000000, 9999999999);
        
        $this->agent = new Agent() ;
        $clientIP = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $clientIP = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $clientIP = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $clientIP = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $clientIP = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $clientIP = $_SERVER['REMOTE_ADDR'];
        else
        $clientIP = 'UNKNOWN';    

        $explode = explode(",",$clientIP);
        $ip = $explode[0];
        
        $clientIP_s = \Request::ip();
        
        $url = "http://ip-api.com/json/".$clientIP_s ;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        
        $resp = curl_exec($curl);
        curl_close($curl);
            
        $json_object = json_encode($resp);
        $decode = json_decode($json_object);
        $geo_object = json_decode($decode);
        $countryCode = $geo_object->countryCode;
        $county_info = DB::table('tbl_countries')->where('countryCode', $countryCode)->first() ;

        $getCount    = DB::table('tbl_currency_status')->where('code',$county_info->currencyCode)->count();

        if($getCount == 0){
            $currency_id = 1;
        }else{
            $getCurrency = DB::table('tbl_currency_status')->where('code', $county_info->currencyCode)->first();
            $currency_id = $getCurrency->id;
        }
        
        if(Cache::get('cookie_currency') != null && Cache::get('cookie_browser') == $this->agent->browser() && Cache::get('cookie_device')  == $this->agent->device()){
            Session::put('requestedCurrency', null);
            Session::put('requestedCurrency', Cache::get('cookie_currency'));
            Session::put('countrycode', Cache::get('countryCode'));
        }else{
            Session::put('requestedCurrency', null);
            Session::put('requestedCurrency', $currency_id);
            Session::put('countrycode', $countryCode);
        }
        
    }
    
    
    // product search
    public function productSearch(Request $request)
    {
        $search         = $request->keywords;
        $search_type    = $request->search_type;
        $page           = $request->page ;
        if($page > 0){
            if(!Session::has('keywords')){
                Session::put('keywords',$search);
            }else{
                if($search != ""){
                    if($search == Session::get('keywords')){
                        $search = Session::get('keywords');
                    }else{
                        Session::put('keywords', $search);
                    }
                }else{
                   $search = Session::get('keywords'); 
                }
                
            }
        }else{

            Session::put('keywords',$search);
            $search = $search ;
        }   
        
        
        Session::put('search_type',$search_type);
        Session::put('viewtype',$request->viewType);
        
        if($this->agent->isDesktop()){

        if ($search_type == "product") {
            
            $productSearch = DB::table('tbl_product')
                ->leftJoin('express', 'tbl_product.supplier_id', '=', 'express.id')
                ->select('tbl_product.*')
                ->where('tbl_product.status', 1)
                ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
                ->paginate(12);


            $productSearchAll = DB::table('tbl_product')
                ->leftJoin('express', 'tbl_product.supplier_id', '=', 'express.id')
                ->select('tbl_product.*')
                ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
                ->where('tbl_product.status', 1)
                ->get();

            $main_category_id = array() ;
            foreach($productSearchAll as $product)
            {
                $main_category_id[] = $product->w_category_id ;
            }

            if ($main_category_id) {

                $al_category_id = array_unique($main_category_id) ;
                $all_catgeorys = DB::table('tbl_primarycategory')
                    ->whereIn('id', $al_category_id)
                    ->where('status', 1)
                    ->get();


                $category_wise_product = DB::table('tbl_product')
                    ->whereIn('w_category_id', $main_category_id)
                    ->where('status', 1)
                    ->inRandomOrder()
                    ->limit(8)
                    ->get() ;

            }else{
                $all_catgeorys = DB::table('tbl_primarycategory')
                    ->where('status', 1)
                    ->get();

                $category_wise_product = DB::table('tbl_product')
                    ->where('status', 1)
                    ->inRandomOrder()
                    ->limit(8)
                    ->get() ;
            }

            $serach_banner = DB::table('tbl_banner')
                ->where('status', 1)
                ->inRandomOrder()
                ->first() ;


            if ($request->viewType == "L") {
                return view('frontEnd.productSearch')->with('search', $search)->with('productSearch',$productSearch)->with('all_catgeorys', $all_catgeorys)->with('serach_banner', $serach_banner)->with('category_wise_product', $category_wise_product)->with('type', "L");
            }else{
                return view('frontEnd.productSearchGrid')->with('search', $search)->with('productSearch',$productSearch)->with('all_catgeorys', $all_catgeorys)->with('serach_banner', $serach_banner)->with('category_wise_product', $category_wise_product)->with('type', "G");
            }

        }else{

            $supplier_search = DB::table('express')
                ->join('tbl_countries', 'express.country', '=', 'tbl_countries.id')
                ->select('express.*', 'tbl_countries.countryName')
                ->where('express.storeName', 'LIKE', '%'.$search.'%')
                ->where('express.status', 1)
                ->paginate(12);

            $supplier__product = DB::table('tbl_product')
                ->join('express', 'tbl_product.supplier_id', '=', 'express.id')
                ->select('tbl_product.*', 'express.first_name', 'express.last_name')
                ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
                ->where('express.status', 1)
                ->get() ;


            $main_category_id = array() ;
            foreach($supplier__product as $product)
            {
                $main_category_id[] = $product->w_category_id ;
            }

            if ($main_category_id) {
                $al_category_id = array_unique($main_category_id) ;
                $all_catgeorys = DB::table('tbl_primarycategory')
                    ->whereIn('id', $al_category_id)
                    ->where('status', 1)
                    ->get();


                $category_wise_product = DB::table('tbl_product')
                    ->whereIn('w_category_id', [$main_category_id])
                    ->where('status', 1)
                    ->inRandomOrder()
                    ->limit(8)
                    ->get() ;

            }else{
                $all_catgeorys = DB::table('tbl_primarycategory')
                    ->where('status', 1)
                    ->get();

                $category_wise_product = DB::table('tbl_product')
                    ->where('status', 1)
                    ->inRandomOrder()
                    ->limit(8)
                    ->get() ;
            }


            $serach_banner = DB::table('tbl_banner')
                ->where('status', 1)
                ->inRandomOrder()
                ->first() ;

            return view('frontEnd.supplierSearch')->with('search', $search)->with('supplier_search',$supplier_search)->with('serach_banner',$serach_banner)->with('all_catgeorys', $all_catgeorys)->with('category_wise_product', $category_wise_product);
        }
        }else{
            $mobile_home_url = env("APP_URL")."m/search?search_keyword=".$search;
            return Redirect::to($mobile_home_url);
        }


    }

    // product search by ajax on page load
    public function productSearchByAjax(Request $request)
    {
        $search         = $request->keywords;
        $search_type    = $request->search_type;
        $show_type      = $request->show_type;

        Session::put('keywords',$search);
        Session::put('search_type',$search_type);

        if ($search_type == "product"){
            $productSearch = DB::table('tbl_product')
            ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
            ->where('tbl_product.status', 1)
            ->paginate(12);



            if ($show_type == 1) {
                return view('frontEnd.searchResult')->with('productSearch',$productSearch);
                return false;
            }else{
                return view('frontEnd.searchResultList')->with('productSearch',$productSearch);
                return false;
            }
        }else{
            $productSearch = DB::table('tbl_product')
                ->join('tbl_product_price','tbl_product_price.product_id','=','tbl_product.id')
                ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
                ->where('tbl_product.status', 1)
                ->paginate(12);


            if ($show_type == 1) {
                return view('frontEnd.searchResultSupplier')->with('productSearch',$productSearch);
                return false;
            }else{
                return view('frontEnd.searchResultSupplierList')->with('productSearch',$productSearch);
                return false;
            }

        }

    }

    // product search pagination
    public function productSearchPagination(Request $request)
    {

        if($request->ajax())
        {
            $search         = $request->keywords;
            $search_type    = $request->search_type;
            $show_type      = $request->show_type;

            Session::put('keywords',$search);
            Session::put('search_type',$search_type);


        if ($search_type == "product"){
            $productSearch = DB::table('tbl_product')
                ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
                ->where('tbl_product.status', 1)
                ->paginate(12);

                if ($show_type == 1) {
                    return view('frontEnd.searchResult')->with('productSearch',$productSearch);
                    return false;
                }else{
                    return view('frontEnd.searchResultList')->with('productSearch',$productSearch);
                    return false;
                }
            }else{
                $productSearch = DB::table('tbl_product')
                    ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
                    ->where('tbl_product.status', 1)
                    ->paginate(12);

                if ($show_type == 1) {
                    return view('frontEnd.searchResultSupplier')->with('productSearch',$productSearch);
                    return false;
                }else{
                    return view('frontEnd.searchResultSupplierList')->with('productSearch',$productSearch);
                    return false;
                }

            }
        }

    }

    # SEARCH PRODUCT SHOW DEFRANTLY
    public function searchProductShowType(Request $request)
    {
        $search         = $request->keywords;
        $search_type    = $request->search_type;
        $show_type      = $request->show_type;

        Session::put('keywords',$search);
        Session::put('search_type',$search_type);

        if ($search_type == "product"){
            $productSearch = DB::table('tbl_product')
                ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
                ->where('tbl_product.status', 1)
                ->paginate(12);

            if ($show_type == 1) {
                return view('frontEnd.searchResult')->with('productSearch',$productSearch);
                return false;
            }else{
                return view('frontEnd.searchResultList')->with('productSearch',$productSearch);
                return false;
            }
        }else{
            $productSearch = DB::table('tbl_product')
                ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
                ->where('tbl_product.status', 1)
                ->paginate(12);

            if ($show_type == 1) {
                return view('frontEnd.searchResultSupplier')->with('productSearch',$productSearch);
                return false;
            }else{
                return view('frontEnd.searchResultSupplierList')->with('productSearch',$productSearch);
                return false;
            }

        }
    }


    # product filtering
    public function getProductByOrderFilter(Request $request)
    {
        $min_order = $request->min_order ;

        $productSearch = DB::table('tbl_product_price')
            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
            ->select('tbl_product.*', 'tbl_product_price.product_id', 'tbl_product_price.start_quantity')
            ->where('tbl_product_price.start_quantity', '<', $min_order)
            ->where('tbl_product.product_name', 'LIKE', '%'.Session::get('keywords').'%')
            ->where('tbl_product.status', 1)
            ->paginate(12);

        return view('frontEnd.getProductByOrderFilter')->with('search', Session::get('keywords'))->with('productSearch',$productSearch);
    }

    # product filtering
    public function getProductByMinMaxFilter(Request $request)
    {
        $mininput           = $request->mininput ;
        $maxinput           = $request->maxinput ;
        $search_keywords    = $request->search_keywords ;
    
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
        $productSearch = DB::table('tbl_product_price')
                    ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                    ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                    ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                    ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                    ->where('tbl_product.status', 1)
                    ->where('tbl_product.product_name', 'LIKE', '%'.$search_keywords.'%')
                    ->havingRaw('price_with_tax >= ?', [$mininput])
                    ->havingRaw('price_with_tax <= ?', [$maxinput])
                    ->orderBy('price_with_tax', 'asc')
                    ->groupBy('tbl_product_price.product_id')
                    ->groupBy('tbl_product.id')
                    ->paginate(12) ;
        

        if ($request->type == "L") {
           return view('frontEnd.getsearchproductresutlistview')->with('search', Session::get('keywords'))->with('productSearch',$productSearch);
        }else{
            return view('frontEnd.getsearchproductresutGridview')->with('search', Session::get('keywords'))->with('productSearch',$productSearch);
        }

    }
    
    public function getsearchproductresutlistview(Request $request)
    {
        $page           = $request->page ;

        $search         = $request->keywords;
        $search_type    = $request->search_type;

        Session::put('keywords',$search);
        Session::put('search_type',$search_type);
        Session::put('viewtype',$request->viewType);



        if($request->ajax())
        {
            if ($search_type == "product") {
                $productSearch = DB::table('tbl_product')
                    ->leftJoin('express', 'tbl_product.supplier_id', '=', 'express.id')
                    ->select('tbl_product.*')
                    ->where('tbl_product.product_name', 'LIKE', '%'.$search.'%')
                    ->where('tbl_product.status', 1)
                    ->paginate(12);


                if ($request->viewType == "L") {
                    return view('frontEnd.getsearchproductresutlistview')->with('search', $search)->with('productSearch',$productSearch)->with('type', "L");
                }else{
                    return view('frontEnd.getsearchproductresutGridview')->with('search', $search)->with('productSearch',$productSearch)->with('type', "G");
                }

            }else{

                $supplier_search = DB::table('express')
                    ->join('tbl_countries', 'express.country', '=', 'tbl_countries.id')
                    ->select('express.*', 'tbl_countries.countryName')
                    ->where('express.storeName', 'LIKE', '%'.$search.'%')
                    ->paginate(12);


                return view('frontEnd.getsearchSupplierResutListview')->with('search', $search)->with('supplier_search',$supplier_search);
            }

        }  
    }
    
    # SUPPLIER SEARCH 
    public function ssearch(Request $request)
    {
        $keywrods       = $request->keywrods ;
        $store_name     = $request->store ;
        $pricefilter    = $request->filter ;
        $type           = $request->type;
        
        
        $store_query = DB::table('express')->where('storeName',$store_name)->first();
        $supplier_id = $store_query->id;
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
        

            
        if($pricefilter == "heightolow"){
            
            
            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_product.product_name', 'LIKE', '%'.$keywrods.'%')
                ->orderBy('price_with_tax', 'desc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(16)->onEachSide(2) ;
                
        }else{

            $just_for_you = DB::table('tbl_product_price')
                ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                ->where('tbl_product.status', 1)
                ->where('tbl_product.supplier_id', $supplier_id)
                ->where('tbl_product.product_name', 'LIKE', '%'.$keywrods.'%')
                ->orderBy('price_with_tax', 'asc')
                ->groupBy('tbl_product_price.product_id')
                ->groupBy('tbl_product.id')
                ->paginate(16)->onEachSide(2);
            
        }

        if($type == "g"){
            return view('frontEnd.store.search')->with('supplier_id',$supplier_id)->with('storeName', $store_query->storeName)->with('store_name', $store_query->storeName)->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('type', $type)->with('keywords', $keywrods);
        }else{
            return view('frontEnd.store.searchlistview')->with('supplier_id',$supplier_id)->with('storeName', $store_query->storeName)->with('store_name', $store_query->storeName)->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('type', $type)->with('keywords', $keywrods);
        }
    }
    
    # SUPPLIER SEARCH 
    public function getsupplierSearchPaginateData(Request $request)
    {
        $keywrods       = $request->keywords ;
        $pricefilter    = $request->viewType ;
        $store_name     = $request->supplier_id;
        $type           = $request->search_type;
        
        
        $store_query = DB::table('express')->where('id',$store_name)->first();
        $supplier_id = $store_query->id;
        
        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
        $current_rate_is = $main_currancy_status2->rate ;
        
        if($request->ajax())
        {
            
            if($pricefilter == "heightolow"){
                
                
                $just_for_you = DB::table('tbl_product_price')
                    ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                    ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                    ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                    ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                    ->where('tbl_product.status', 1)
                    ->where('tbl_product.supplier_id', $supplier_id)
                    ->where('tbl_product.product_name', 'LIKE', '%'.$keywrods.'%')
                    ->orderBy('price_with_tax', 'desc')
                    ->groupBy('tbl_product_price.product_id')
                    ->groupBy('tbl_product.id')
                    ->paginate(16) ;
                    
            }else{
    
                $just_for_you = DB::table('tbl_product_price')
                    ->join('tbl_product', 'tbl_product.id', '=', 'tbl_product_price.product_id')
                    ->join('tbl_supplier_primary_category', 'tbl_product.main_category_id', '=', 'tbl_supplier_primary_category.id')
                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                    ->select('tbl_product.*', 'tbl_product_price.product_price', 'tbl_product_price.product_id', 'tbl_supplier_primary_category.catgeory_slug', 'tbl_currency_status.rate')
                    ->selectRaw('tbl_product_price.product_price  / tbl_currency_status.rate * ? as price_with_tax', [$current_rate_is])
                    ->where('tbl_product.status', 1)
                    ->where('tbl_product.supplier_id', $supplier_id)
                    ->where('tbl_product.product_name', 'LIKE', '%'.$keywrods.'%')
                    ->orderBy('price_with_tax', 'asc')
                    ->groupBy('tbl_product_price.product_id')
                    ->groupBy('tbl_product.id')
                    ->paginate(16) ;
                
            }
    
            if($type == "g"){
                return view('frontEnd.store.searchpaginategridview')->with('supplier_id',$supplier_id)->with('storeName', $store_query->storeName)->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('type', $type)->with('keywords', $keywrods);
            }else{
                return view('frontEnd.store.searchpaginatehlistview')->with('supplier_id',$supplier_id)->with('storeName', $store_query->storeName)->with('just_for_you', $just_for_you)->with('pricefilter', $pricefilter)->with('type', $type)->with('keywords', $keywrods);
            }
        }
    }
    
}
