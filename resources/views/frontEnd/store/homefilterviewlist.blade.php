@extends('frontEnd.master')
<?php 
    $store_info = DB::table('express')
        ->join('tbl_countries', 'express.country', '=', 'tbl_countries.id')
        ->select('express.*', 'tbl_countries.countryCode')
        ->where('express.id', $supplier_id)
        ->first() ;

    $banner_info = DB::table('tbl_supplier_header_banner')
        ->where('supplier_id', $supplier_id)
        ->first() ;
        
    $default_banner = DB::table('tbl_default_setting')->first();
    
    $meta_info 	= DB::table('tbl_meta_tags')->first();
	$settings 	= DB::table('tbl_logo_settings')->where('status', 1)->first();
	
	if($banner_info){
	    if($banner_info->header_image){
	        $supplier_main_logo = $banner_info->header_image;
	    }else{
	        $supplier_main_logo = $default_banner->logo;
	    }
	}else{
	    $supplier_main_logo = $default_banner->logo;
	}
?>
@section('title')
{{ $store_info->storeName }}
@endsection

@section('meta_info')

    <meta name="title" content="{{ $store_info->storeName }}">
    <meta name="description" content="{{ $store_info->companyDetails }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ URL::full() }}">
    <meta property="og:title" content="{{ $store_info->storeName }}">
    <meta property="og:description" content="{{ $store_info->companyDetails }}">
    <meta property="og:image" content="{{ URL::to('public/images/'.$supplier_main_logo) }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ URL::full() }}">
    <meta property="twitter:title" content="{{ $store_info->storeName }}">
    <meta property="twitter:description" content="{{ $store_info->companyDetails }}">
    <meta property="twitter:image" content="{{ URL::to('public/images/'.$supplier_main_logo) }}">

@endsection

@section('content')
    <style>
        .active{
            background-color: green;
            color: white;
        }
        .active:hover{
            color: white!important;
        }
    </style>
    <div class="container mt-2 mb-2">

        <?php 
	        if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){
	            if(Session::get('supplier_id') != null){
	                $main_login_id = Session::get('supplier_id');
	            }else{
	                $main_login_id = Session::get('buyer_id');
	            }
	        }else{
	            $main_login_id = 0;
	        }
	    ?>

        @include('frontEnd.store.masterStore')


        <!-- Store Slider -->
        <?php $all_slider_count = DB::table('tbl_slider')->where('supplier_id', $supplier_id)->where('status', 1)->count(); ?>
        <div class="columns m-0 p-0 mb-4 pb-2" style="<?php if($all_slider_count == 0){ echo 'display:none;'; } ?>">
            <div class="column m-0 p-0">

                <div id="supplier-main-inner">
                    <div id="supplier-slider">
                        <?php $all_slider = DB::table('tbl_slider')->where('supplier_id', $supplier_id)->where('status', 1)->get(); ?>
                        <?php foreach ($all_slider as $key => $slidervalue): ?>
                            <a href="#" title=""><img src="{{ URL::to('public/images/'.$slidervalue->slider_image) }}" class="supplier-img-size"/></a>
                        <?php endforeach ; ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="columns is-gapless">
            <!-- Left Sidebar -->
            <div class="column is-one-fifth mr-3">
                <!-- 1st sidebar -->
                <div class="box pl-5 pt-5 pr-5">
                    <div class="columns">
                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">Choose your product</h2>

                            <div id="store-main-inner">
                                <div id="store-slider">
                                     <?php $product_ads = DB::table('tbl_product_ads')->inRandomOrder()->where('status', 1)->get() ; foreach ($product_ads as $key => $slidervalue): ?>
                                    <a href="{{ $slidervalue->ads_link }}" title="" target="_new"><img src="{{ URL::to('public/images/adminssAds/'.$slidervalue->ads_image) }}" class="store-img-size"/></a>
                                    <?php endforeach ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                                <!-- 2nd sidebar -->
                <div class="box pl-5 pt-5 pr-5">
                    <div class="columns">
                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">Recommended Product</h2>

                            <?php 

                                $all_supplier_category = DB::table('tbl_supplier_primary_category')
                                    ->where('supplier_id', $supplier_id)
                                    ->where('status', 1)
                                    ->get() ;


                                $categoryvalue = array() ;
                                foreach ($all_supplier_category as $key => $catvalue) {
                                    $categoryvalue[] = $catvalue->id ;
                                }

                                $categorywiseproduct = DB::table('tbl_product')
                                    ->inRandomOrder()
                                    ->where('tbl_product.status', 1)
                                    ->where('supplier_id', $supplier_id)
                                    ->whereIn('main_category_id', $categoryvalue)
                                    ->limit(3) 
                                    ->get();

                                foreach($categorywiseproduct as $catgeoryproduct) :

                            ?>
                            <?php $justvalueimages = explode("#", $catgeoryproduct->products_image); ?>
                
                            <div class="mb-1">
                                <div class="columns">
                                    <div class="column">
                                        <a href="{{ URL::to('product/'.$catgeoryproduct->slug)}}" title=""><img src="{{ URL::to('public/images/'.$justvalueimages[0]) }}" alt="{{ $catgeoryproduct->product_name }}" class="store-recommended-img-size" /></a>
                                    </div>
                                    <div class="column ml-0 pl-0">
                                        <a href="{{ URL::to('product/'.$catgeoryproduct->slug)}}" style="color:black">
                                            <p>{{ Str::limit($catgeoryproduct->product_name, 20) }}</p>
                                            <p style="font-family:'SolaimanLipi';">
                                                @php
                                                    $price_count2 = DB::table('tbl_product_price')
                                                        ->where('product_id', $catgeoryproduct->id)
                                                        ->count() ;
    
                                                    $price_infow = DB::table('tbl_product_price')
                                                                ->where('product_id', $catgeoryproduct->id)
                                                                ->first() ;
    
                                                    $minimum_order2 = DB::table('tbl_product_price')
                                                                ->where('product_id', $catgeoryproduct->id)
                                                                ->orderBy('tbl_product_price.start_quantity', 'asc')
                                                                ->first() ;
                                                @endphp
                                                
                                                <?php
                                                    $product_price_info2 = DB::table('tbl_product_price')
                                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                                        ->where('tbl_product_price.product_id', $catgeoryproduct->id)
                                                        ->orderBy('tbl_product_price.product_price', 'asc')
                                                        ->first() ;
                                                        
                                                    $product_price_info3 = DB::table('tbl_product_price')
                                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                                        ->where('tbl_product_price.product_id', $catgeoryproduct->id)
                                                        ->orderBy('tbl_product_price.product_price', 'desc')
                                                        ->first() ;
                                                	if($product_price_info2->product_price > 0){
                                                        if(Session::has('requestedCurrency')){
                                                            $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                            $product_price_convert2 = $product_price_info2->product_price / $product_price_info2->currency_rate;
                                                            $now_product_price_is2 = $product_price_convert2 * $main_currancy_status2->rate ;
                                                            $currency_code2         = $main_currancy_status2->symbol;
                                                            
                                                            $product_price_convert_max = $product_price_info3->product_price / $product_price_info2->currency_rate;
                                                            $now_product_price_is_max = $product_price_convert_max * $main_currancy_status2->rate ;
                                
                                                        }else{
                                                            
                                                            $currency_code2             = $product_price_info2->code;
                                                            $now_product_price_is2      = $product_price_info2->product_price;
                                                            $now_product_price_is_max   = $product_price_info3->product_price;
                                                        }
                                
                                
                                                    }
                                                ?>
                                                
                                                <?php if ($price_count2 == 1): ?>
    
                                                <b>
                                                    <?php if ($price_infow->price_status == 3): ?>
                                                        Negotiate
                                                    <?php else: ?>
                                                        <?php echo $currency_code2 ; ?> <?php echo number_format($now_product_price_is2, 2) ; ?>
                                                    <?php endif ?>
                                                </b><br/>
                                                <?php else: ?>
                                                @php
                                                    $max_price2 = DB::table('tbl_product_price')
                                                        ->where('product_id', $catgeoryproduct->id)
                                                        ->max('product_price') ;
    
                                                    $min_price2 = DB::table('tbl_product_price')
                                                        ->where('product_id', $catgeoryproduct->id)
                                                        ->min('product_price') ;
                                                @endphp
                                                <b><?php echo $currency_code2 ; ?> {{ number_format($now_product_price_is2, 2) }} - {{ $now_product_price_is_max }}</b><br/>
                                                <?php endif ?>
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>


                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Sidebar ( Main Content-bar ) -->
            <div class="column auto ml-0 pt-0">

                <div class="columns ml-0 mt-0 mr-0 mb-0 pt-0">
                    <div class="column mr-0 pr-0 mt-0 pt-0">
                        <table>
                            <tr>
                                <td>
                                    <a onclick="showlistview()"  class="button active listview viewstyle" type="submit">
                                    <i class="fas fa-th-list"></i></a>
                                    
                                </td>
                                <td style="padding:0px 5px;">
                                     <a onclick="showgridview()" class="button gridview viewstyle" type="submit">
                                        <i class="fas fa-th-large"></i></button>
                                    </a>
                                    
                                </td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="column mr-0 pr-0 mt-0 pt-0" style="margin-left: 757px;">
                        <table>
                            <tr>
                                <td>
                                    <select name="" style="padding: 8px 10px;font-size: 18px;font-weight: bold;" id="pricefilter">
                                        <option value="heightolow" <?php if($slug == "heightolow"){echo "selected"; }else{echo ""; } ?>>High To Low</option>
                                        <option value="lowtohigh" <?php if($slug == "lowtohigh"){echo "selected"; }else{echo ""; } ?>>Low to High</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Start of Products -->
                <span id="product_data">

                    <?php 
                        foreach($just_for_you as $justvalue) :
                    ?>

                    <!-- Start of Products -->
                    <div class="columns ml-2 mt-0 mb-5 mr-0 box mb-2">
                            <div class="column is-one-quarter mb-0 pb-0">
                                <a href="{{ URL::to('product/'.$justvalue->slug)}}" title="">
                                     <?php $justvalueimage = explode("#", $justvalue->products_image); ?>
                                    <img src="{{ URL::to('public/images/'.$justvalueimage[0]) }}" alt="{{ $justvalue->product_name }}" style="width: 100%;height:255px;" >
                                </a>
                            </div>
                            <div class="column auto mt-0 pt-0">
                                @php
                                        $price_count = DB::table('tbl_product_price')
                                            ->where('product_id', $justvalue->id)
                                            ->count() ;

                                        $price_info = DB::table('tbl_product_price')
                                                    ->where('product_id', $justvalue->id)
                                                    ->first() ;

                                        $minimum_order = DB::table('tbl_product_price')
                                                    ->where('product_id', $justvalue->id)
                                                    ->orderBy('tbl_product_price.start_quantity', 'asc')
                                                    ->first() ;
                                    @endphp
                                   
                                <a href="#" title="" style="color:black!important">
                                <h2 style="font-size: 20px;font-weight: bold;">{{ Str::limit($justvalue->product_name, 20) }}</h2>

                                <p style="border-bottom: 1px solid #dae2ed; padding-top: 10px; padding-bottom: 10px;"><?php if ($minimum_order->price_status == 1): ?>
                                    @php
                                        echo $minimum_order->start_quantity ;
                                    @endphp
                                    <?php else: ?>
                                    1
                                    <?php endif ?>  Qty (Min. Order)</p>
                                <nav class="mt-1 pt-1 mb-2">
                                    @php
                                        $supplier_info = DB::table('express')
                                            ->join('tbl_countries', 'express.country', '=', 'tbl_countries.id')
                                            ->select('express.*', 'tbl_countries.countryCode')
                                            ->where('express.id', $justvalue->supplier_id)
                                            ->first();
    
                                    @endphp
                                    <label><p>{{ $supplier_info->storeName  }}</p></label>
                                
                                    <label><span><img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower($supplier_info->countryCode).'.png'; ?>" alt="" style="width:25px;height:20px;"></span> {{ $supplier_info->countryCode }} <span><?php
    									$created_at = date("d M Y", strtotime($supplier_info->created_at)) ;
    									$today_date = date("d M Y");
    									$datetime1 = new DateTime("$created_at");
    									$datetime2 = new DateTime($today_date);
    									$interval = $datetime1->diff($datetime2);
    									
    									if($interval->format('%y') == 0){
    									    echo $interval->format('%m M, %d D');
    									}else{
    									    echo $interval->format('%y Y, %m M');
    									}
     								?></span></label>
                                    <label><img src="images/verified.png" alt=""><img src="images/assurance.png" alt=""><img src="images/assurance.png" alt=""><img src="images/crown.jpg" alt=""><img src="images/crown.jpg" alt=""><img src="images/crown.jpg" alt=""></label>
                                </nav>
                                <table class="mb-2">
                                    <tr>
                                        <td><p></p></td>
                                        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                        <td><p></p></td>
                                    </tr>
                                </table>
                                </a>
                                <nav>
                                    <label><a class="product-contact-supplier" href="#" onclick="sendquotationinfo(<?php echo $store_info->id; ?>, '<?php echo $store_info->storeName;  ?>')">Contact Supplier</a></label>
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                     <?php 
            				        if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){
            				            if(Session::get('supplier_id') != null){
            				                $main_login_id = Session::get('supplier_id');
            				            }else{
            				                $main_login_id = Session::get('buyer_id');
            				            }
            				        }else{
            				            $main_login_id = 0;
            				        }
            				    ?>
            				    <?php if($main_login_id == 0): ?>
                                    <label><a href="#n" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><img src="{{ URL::to('public/frontEnd/images/chat.png') }}" alt=""> Chat Now</a></label>
                                    <?php else: ?>
                                     <label><a href="#" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><img src="{{ URL::to('public/frontEnd/images/chat.png') }}" alt=""> Chat Now</a></label>
                                     <?php endif; ?>
                                </nav>
                            </div>
                            <div class="column is-3 mt-0 pt-0">
                                <?php
                                    $product_price_info2 = DB::table('tbl_product_price')
                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                        ->where('tbl_product_price.product_id', $justvalue->id)
                                        ->orderBy('tbl_product_price.product_price', 'asc')
                                        ->first() ;
                                        
                                    $product_price_info3 = DB::table('tbl_product_price')
                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                        ->where('tbl_product_price.product_id', $justvalue->id)
                                        ->orderBy('tbl_product_price.product_price', 'desc')
                                        ->first() ;
                                	if($product_price_info2->product_price > 0){
                                        if(Session::has('requestedCurrency')){
                                            $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                            $product_price_convert2 = $product_price_info2->product_price / $product_price_info2->currency_rate;
                                            $now_product_price_is2 = $product_price_convert2 * $main_currancy_status2->rate ;
                                            $currency_code2         = $main_currancy_status2->symbol;
                                            
                                            $product_price_convert_max = $product_price_info3->product_price / $product_price_info2->currency_rate;
                                            $now_product_price_is_max = $product_price_convert_max * $main_currancy_status2->rate ;

                                        }else{
                                            
                                            $currency_code2             = $product_price_info2->code;
                                            $now_product_price_is2      = $product_price_info2->product_price;
                                            $now_product_price_is_max   = $product_price_info3->product_price;
                                        }
         

                                    }
                                ?>
                                <h2 style="text-align: right;font-size: 18px;font-weight: bold;font-family:'SolaimanLipi';"> <?php if ($price_count == 1): ?>
                                        
                                    <b>
                                        <?php if ($price_info->price_status == 3): ?>
                                            Negotiate
                                        <?php else: ?>
                                            <?php echo $currency_code2." ".number_format($now_product_price_is2, 2) ; ?>
                                        <?php endif ?>
                                    </b>
                                    <?php else: ?>
                                    @php
                                        $max_price = DB::table('tbl_product_price')
                                            ->where('product_id', $justvalue->id)
                                            ->max('product_price') ;

                                        $min_price = DB::table('tbl_product_price')
                                            ->where('product_id', $justvalue->id)
                                            ->min('product_price') ;
                                    @endphp
                                    <b><?php echo $currency_code2; ?> {{ number_format($now_product_price_is2, 2) }} - {{ number_format($now_product_price_is_max, 2) }}</b>
                                    <?php endif ?><span style="font-size: 12px;color: #888888;">/ {{ $product_price_info2->unit_name }} </span></h2>
                            </div>
                    </div>
                    <?php endforeach ?>

                </span>
                
                <div class="columns is-full mb-5">
                    <div class="column">
                        
                        {{ $just_for_you->links('frontEnd.store.customPaginate') }}
                        
                    </div>
                </div>
                

            </div>

        </div>
    </div>

@endsection

@section('store_social_network')
    <div class="container">
        <div class="columns">
            <?php $social_icon = DB::table('tbl_social_media')->where('supplier_id', $supplier_id)->first() ; ?>
            <div class="column is-half is-offset-two-fifths">
                <ul class="store_social">
                    <li><a href="<?php if($social_icon){echo $social_icon->facebook;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/fb.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->twitter;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/003-twitter.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->linkedin;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/002-linkedin.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->google;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/004-search.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->pinterest;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/001-pinterest.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->instagram;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/005-instagram.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->youtube;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/006-youtube.png') }}"></a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection


@section('css')
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/storeSlider.css') }}">
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/supplierSlider.css') }}">

    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/store.css') }}">
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/store_nested_menu.css') }}">
    <style>
    
        .store_social ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .store_social li {
            float: left;
        }

        .store_social li a {
            display: block;
            color: #000;
            text-align: center;
            padding: 10px 10px;
            text-decoration: none;
        }
        
        #social-links ul li{
            float: left;
            padding: 7px;
        }


        #social-links{
            margin-left: 445px;
            margin-bottom: 119px;
        }
        
        #social-links ul li a{
            font-size: 40px;
        }
        
        #social-links .fa-facebook{
               color: #0d6efd;
         }
         #social-links .fa-twitter{
               color: deepskyblue;
         }
         #social-links .fa-linkedin{
               color: #0e76a8;
         }
         #social-links .fa-whatsapp{
              color: #25D366
         }
         #social-links .fa-reddit{
              color: #FF4500;;
         }
         #social-links .fa-telegram{
              color: #0088cc;
         }
    </style>
@endsection

@section('js')
    <script src="{{ URL::to('public/frontEnd/assets/js/storeMiniSlider.js') }}"></script>
    <script src="{{ URL::to('public/frontEnd/assets/js/supplierSlider.js') }}"></script>

    <script>
        $(function() {
            $('#store-slider').miniSlider();
        });
    </script>
    <script>
        $(function() {
            $('#supplier-slider').supplierMiniSlider();
        });
    </script>

    <script>
        var viewstyle = "<?php echo $type; ?>" ; ;
        
        function showlistview(){
            var pricefilter = $("#pricefilter").val() ;
            viewstyle = "l" ;
            var storename = "<?php echo strtolower($storeName); ?>";
            var main_link = "<?php echo env('APP_URL'); ?>homefilter";
            var gridlink = main_link+"/"+storename+"/"+pricefilter+"/"+viewstyle;
            window.location = gridlink;
        }

        function showgridview(){
            var pricefilter = $("#pricefilter").val() ;
            viewstyle = "g" ;
            var storename = "<?php echo strtolower($storeName); ?>";
            var main_link = "<?php echo env('APP_URL'); ?>homefilter";
            var gridlink = main_link+"/"+storename+"/"+pricefilter+"/"+viewstyle;
            window.location = gridlink;
        }

        $("#pricefilter").change(function(){
            var pricefilter = $(this).val() ;
            var storename = "<?php echo strtolower($storeName); ?>";
            var main_link = "<?php echo env('APP_URL'); ?>homefilter";
            var gridlink = main_link+"/"+storename+"/"+pricefilter+"/"+viewstyle;
            window.location = gridlink;
        });


    </script>
@endsection
