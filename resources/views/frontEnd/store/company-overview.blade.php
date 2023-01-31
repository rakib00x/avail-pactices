@extends('frontEnd.master')
@section('title','Company Overview')
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
        $store_info = DB::table('express')
            ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
            ->select('express.*', 'tbl_countries.countryCode')
            ->where('express.id', $supplier_id)
            ->first() ;

        $banner_info = DB::table('tbl_supplier_header_banner')
            ->where('supplier_id', $supplier_id)
            ->first() ;

        ?>
        
        
        <?php $default_banner = DB::table('tbl_default_setting')->first(); ?>
        
        @include('frontEnd.store.masterStore')

        <div class="columns is-gapless">
            <!-- Left Sidebar -->
            <div class="column is-full">
                <!-- 1st sidebar -->
                <div class="box pl-5 pt-5 pr-5">
                    <div class="columns">
                        <div style="width: 100%;border-left: 1px solid #dbe3ef;border-right: 1px solid #dbe3ef;border-bottom: 1px solid #dbe3ef;">
                            <div class="store-contact-bar">
                                <h1 style="font-size: 22px;color: #000;padding: 7px;">Company Overview</h1>
                            </div>
                            <div class="columns">
                                <div class="column is-auto">
                                    <p class="p-5">
                                        <?php echo $store_query->companyDetails; ?>
                                    </p>
                                    <table class="table is-bordered pricing__table is-fullwidth">
                        <thead>
                            <tr>
                            <th> Company Name</th>
                             <td> <?php echo $store_query->companyName; ?></td>
                           </tr>
                           <tr>
                           
                            <th>Country</th>
                             <td><img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower($store_info->countryCode).'.png'; ?>" alt="" style="width:55px;height:40px;"></td>
                           </tr>
                           <tr>
                            <th>Year Established</th>
                             <td> <?php
                                 $year = date("Y", strtotime($store_query->created_at)) ;
                              echo $year; ?></td>
                           </tr>
                           <tr>
                            <th> Main Product</th>
                             <td> <?php echo $store_query->mainProduct; ?></td>
                           </tr>
                            <tr>
                            <th>Company Address</th>
                             <td> <?php echo $store_query->companyAddress; ?></td>
                           </tr>
                           <tr>
                            <th>Employee Number</th>
                             <td> <?php echo $store_query->companyEmployeeNumber; ?></td>
                           </tr>
                           <tr>
                            <th>Email</th>
                             <td> <?php echo $store_query->email; ?></td>
                           </tr>
                           
                        </thead>
                    </table>
                    <div style="width:100%; <?php if($store_query->googleMapLocation != null){echo ""; }else{echo "display:none"; } ?>">
                        <iframe src="<?php echo $store_query->googleMapLocation; ?>" width="1000" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        
                    </div>
                    <div class="box  has-text-centered">
                     <a href="<?php $store = strtolower($store_query->storeName); ?> {{ URL::to('store/'.$store) }}" target="_parent" class="button is-primary">Visit Store</a>
                    </div>
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
    <script src="{{ URL::to('public/frontEnd/assets/js/storeMiniSlider.js') }}"></script>
    <script src="{{ URL::to('public/frontEnd/assets/js/supplierSlider.js') }}"></script>

    <script>
        $(function() {
            $('#store-slider').miniSlider();
            $('#supplier-slider').supplierMiniSlider();
        });
    </script>

    <script>
        var viewstyle = 'g' ;

        function showlistview(){
            var pricefilter = $("#pricefilter").val() ;
            viewstyle = "l" ;
            var storename = "<?php echo $store_name; ?>";
            var main_link = "http://"+storename+".availtrade.com/homefilter";
            var gridlink = main_link+"/"+pricefilter+"/"+viewstyle;
            window.location = gridlink;
        }

        function showgridview(){
            var pricefilter = $("#pricefilter").val() ;
            viewstyle = "g" ;
            var storename = "<?php echo $store_name; ?>";
            var main_link = "http://"+storename+".availtrade.com/homefilter";
            var gridlink = main_link+"/"+pricefilter+"/"+viewstyle;
            window.location = gridlink;
        }

        $("#pricefilter").change(function(){
            var pricefilter = $(this).val() ;
            var storename = "<?php echo $store_name; ?>";
            var main_link = "http://"+storename+".availtrade.com/homefilter";
            var gridlink = main_link+"/"+pricefilter+"/"+viewstyle;
            window.location = gridlink;
        });


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
