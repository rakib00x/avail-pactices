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
    <div class="container mt-2 mb-2">
        <div class="columns mb-0">
            <div class="column mb-0">
                <?php if ($banner_info): ?>
                <div id="store-banner" style="
                <?php if($banner_info->header_image !=""): ?>
                    background: url({{ URL::to('public/images/'.$banner_info->header_image) }})
                <?php else: ?>
                    background: url({{ URL::to('public/images/'.$default_banner->banner_image) }})
                <?php endif ?>
                    ;
                    background-size: 1400px 220px;;
                    background-repeat: no-repeat;
                    ">
                    <div class="store_left">
                        <?php if($store_info->image !=""): ?>
                        <img class="store_company_logo" src="{{ URL::to('public/images/'.$store_info->image) }}" alt="">
                        <?php else: ?>
                        <img class="store_company_logo" src="{{ URL::to('public/images/'.$default_banner->logo) }}" alt="">
                        <?php endif ?>

                    </div>

                    <div class="store_right mt-5">
                        <div class="store_contact_supplier mt-5">
                            <p><a href="#" onclick="sendquotationinfo(<?php echo $store_info->id; ?>, '<?php echo $store_info->storeName;  ?>')"><span>Contact Supplier</span></a></p>
                        </div>
                        <div class="store_chat_now mt-3">
                            <?php if($main_login_id == 0): ?>
        				        <p><a href="#" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
        				    <?php else: ?>
        				        <p><a href="#" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
        				    <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php else: ?>


                <div id="store-banner" style="background: url({{ URL::to('public/images/'.$default_banner->banner_image) }}); width:1400px; height:220px;">
                    <div class="store_left">
                        <img class="store_company_logo" src="{{ URL::to('public/images/'.$default_banner->logo) }}" alt="">
                    </div>
                    <div class="store_middle">
                        <h1 class="store_company">{{ $store_info->storeName }}</h1>
                        <p><label><span></span> {{ $store_info->countryCode }} <span>
                                <?php
									$created_at = date("d M Y", strtotime($store_info->created_at)) ;
									$today_date = date("d M Y");
									$datetime1 = new DateTime("$created_at");
									$datetime2 = new DateTime($today_date);
									$interval = $datetime1->diff($datetime2);
									
									if($interval->format('%y') == 0){
									    echo $interval->format('%m M, %d D');
									}else{
									    echo $interval->format('%y Y, %m M');
									}
 								?>
                            </span></label></p>
                    </div>
                    <div class="store_right mt-5">
                        <div class="store_contact_supplier mt-5">
                            <p><a href="#" onclick="sendquotationinfo(<?php echo $store_info->id; ?>, '<?php echo $store_info->storeName;  ?>')"><span>Contact Supplier</span></a></p>
                        </div>
                        <div class="store_chat_now mt-3">
                            <?php if($main_login_id == 0): ?>
        				        <p><a href="#" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
        				    <?php else: ?>
        				        <p><a href="#" onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
        				    <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>

            </div>
        </div>

        <!-- Store Menu Bar -->
        <div class="column m-0 p-0">
            <div class="column m-0 p-0 mb-3">
                <div id="store-navbar" class="navbar-menu">
                    <div class="navbar-start">
                        <a href="<?php echo "http://".$store_name.".availtrade.com"; ?>" class="navbar-item not-nested">Home</a>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link not-nested">Products</a>
                            <div class="navbar-dropdown">

                                <?php
                                $supplier_catgeory = DB::table('tbl_supplier_primary_category')->where('status', 1)->where('supplier_id', $supplier_id)->get() ;
                                foreach ($supplier_catgeory as $key => $categoryvalues):
                                ?>
                                <?php

                                $get_secondary_category = DB::table('tbl_supplier_secondary_category')
                                    ->where('primary_category_id', $categoryvalues->id)
                                    ->where('supplier_id', $supplier_id)
                                    ->where('status', 1)
                                    ->get() ;

                                ?>

                                <div class="nested dropdown">
                                    <a href="<?php echo "http://".$store_name.".availtrade.com/stp-category/".$categoryvalues->catgeory_slug.'/g'.'/heightolow'; ?>" class="navbar-item">
                                        <?php if(count($get_secondary_category) > 0): ?>
                                        <span class="icon-text "><span>{{ $categoryvalues->category_name }}</span>
                                            <span class="icon"><i class="fas fa-chevron-right"></i></span></span>
                                        <?php else: ?>
                                        <span class="icon-text "><span>{{ $categoryvalues->category_name }}</span></span>
                                        <?php endif; ?>
                                    </a>
                                    <?php if(count($get_secondary_category) > 0): ?>
                                    <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                        <div class="dropdown-content">
                                            <?php foreach ($get_secondary_category as $key => $secondarycategoryvalue): ?>
                                            <a href="<?php echo "http://".$store_name.".availtrade.com/sps-category/".$secondarycategoryvalue->secondary_category_slug.'/g'.'/heightolow'; ?>" class="dropdown-item">{{ $secondarycategoryvalue->secondary_category_name }}</a>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach ?>

                            </div>
                        </div>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link not-nested">Prifle</a>
                            <div class="navbar-dropdown">

                                <div class="nested dropdown">
                                    <a href="{{ URL::to('company-overview') }}" class="navbar-item"><span class="icon-text"><span>Company Overview</span></span></a>
                                </div>
                                <div class="nested dropdown">
                                    <a href="{{ URL::to('company-capacity') }}" class="navbar-item"><span class="icon-text"><span>Production Capacity</span></span></a>
                                </div>
                                <div class="nested dropdown">
                                    <a href="{{ URL::to('trade-capacity') }}" class="navbar-item"><span class="icon-text"><span>Trade Capacity</span></span></a>
                                </div>

                            </div>
                        </div>
                        <a href="{{ URL::to('store-contact') }}" class="navbar-item not-nested">Contact</a>
                        <?php
                            $check_count = DB::table('tbl_supplier_terms_conditions')->where('status', 1)->where('supplier_id', $store_info->id)->count() ;
                            if($check_count > 0):
                        ?>
                        <a href="{{ URL::to('terms-condition') }}" class="navbar-item not-nested">Terms & Conditions</a>
                        <?php endif; ?>
                    </div>
                    <div class="navbar-end">
                        <div class="navbar-item">
                            {!! Form::open(['url' =>'ssearch','method' => 'get','role' => 'form', 'files'=>true]) !!}
                                <div class="field is-grouped">
                                    <p class="control">
                                        <input class="input" type="text" name="keywrods" placeholder="Search in this store" >
                                    </p>
                                    <input type="hidden" name="filter" value="lowtoheigh">
                                    <input type="hidden" name="type" value="g">
                                    <p class="control">
                                        <input type="submit" class="button is-primary" value="Search">
                                    </p>
                                    
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="columns is-gapless">
            <!-- Left Sidebar -->
            <div class="column is-full">
                <!-- 1st sidebar -->
                <div class="box pl-5 pt-5 pr-5">
                    <div class="columns">
                        <div style="width: 100%;border-left: 1px solid #dbe3ef;border-right: 1px solid #dbe3ef;border-bottom: 1px solid #dbe3ef;">
                            <div class="store-contact-bar">
                                <h1 style="font-size: 22px;color: #000;padding: 7px;">Terms And Conditions</h1>
                            </div>
                            <div class="columns">
                                <div class="column  mt-5 pt-5 mb-5 pb-5">
                                    
                                    
                                     <?php foreach ($result as $key => $value): ?>
                                         <div class="box" style="padding:10px;">
                                            <div class="content">
                                                <h4><strong>{{ $value->conditions_name }}</strong> &nbsp;&nbsp;&nbsp; {{ $value->created_at }}</h4>
                                                <?php echo $value->conditions_details; ?>
                                            </div>
                                        </div>
                                        <hr>
                                    <?php endforeach ?>
                                    
                                </div>
                            </div>
                        </div>
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

        .store-contact-bar {
            width: 100%;
            height: 55px;
            background: #fff;
            border-top: 4px solid #644c40;
            border-bottom: 1px solid #dbe3ef;
        }

    </style>
@endsection

@section('js')

    <script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}", "Warning", { positionClass: 'toast-top-center', });
        break;
        case 'failed':
        toastr.error("{{ Session::get('message') }}", "Failed", { positionClass: 'toast-top-center', });
        break;
    }
    @endif
</script>
@endsection

@section('store_background')

    <?php

    if($banner_info){
        // 0 = color, 1 = image
        if($banner_info->background_image !=""){
            $store_background = 1;
        }else{
            $store_background = 0;
        }
    }else{
        $store_background = 0;
    }
    $store_background = '1';
    if($store_background == 1){ ?>
    style="background: url('https://www.availtrade.com//public/images/'.$banner_info->background_image);background-repeat: no-repeat;background-size: 100% 100%;"
    <?php }else{ ?>
    style="background: pink;"
    <?php } ?>

@endsection
