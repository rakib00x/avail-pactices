<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Cache;
use Jenssegers\Agent\Agent;
use DB;
use Session;
use Str;
use Input;
use Hash;
use Mail;
use Cookie;

class footerController extends Controller
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
        
        $url = "http://ip-api.com/json/".$clientIP_s;

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
        // $countryCode = $geo_object->countryCode;
        // $county_info = DB::table('tbl_countries')->where('countryCode', $countryCode)->first() ;
        $county_info = DB::table('tbl_countries')->first() ;

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
            // Session::put('countrycode', Cache::get('countryCode'));
        }else{
            Session::put('requestedCurrency', null);
            Session::put('requestedCurrency', $currency_id);
            // Session::put('countrycode', $countryCode);
        }
    }
    public function index(){
        $video 	= DB::table('videos')->get();
        $faq	= DB::table('faqs')->get();
        return view('frontEnd.footer.help-center',compact('video','faq'));
    }
    public function messageBox(){
        return view('frontEnd.footer.messagebox');
    }
    public function sitemap(){
        return response()->view('sitemap.index')->header('Content-Type', 'text/xml');
    }
    
    public function sitemapPro() {
        DB::table('tbl_product')
            ->inRandomOrder()
            ->where('status', 1)
            ->take(12)
            ->orderBy('id', 'desc')
            ->get();
		$products = DB::table('tbl_product')->orderBy("id", "desc")->take(1000)->select(["slug", "products_image", "updated_at"])->get();
		return response()->view('sitemap.products', [
		'products' => $products,
		])->header('Content-Type', 'text/xml');
	}

	public function sitemapCate() {
		$categories = DB::table('tbl_primarycategory')->orderBy("id", "desc")->get();

		return response()->view('sitemap.category', [
		'categories' => $categories,
		])->header('Content-Type', 'text/xml');
	}
	
	public function termsEmplo(){
	    if($this->agent->isDesktop()){
	    return view('marketing.terms');
	    }else{
	        return Redirect::to("m/employee/terms");
	    }
	}

      
   
    
}
