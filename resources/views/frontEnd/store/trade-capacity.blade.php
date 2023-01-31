@extends('frontEnd.master')
@section('title','Result Gird')
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
                                <h1 style="font-size: 22px;color: #000;padding: 7px;">Trade Capacity</h1>
                            </div>
                            <div class="columns">
                                <div class="column is-auto">
                                    <p class="p-5">
                                        ZOUPING BEAUTEX CO., LTD. belongs to BEAUTEX GROUP LIMITED,which is a leading supplier in the line of Garment Accessory & Tailoring Material in China. We have lace fabric,mesh fabric,motorcycle seat cover ,knitted fabic,denim fabric business.Our factories cover areas of more than 20,000 square meters with over 500 staff members. We have set up well-organized online sales system to control quality and ensure the delivery time. With more than 10 years' development, we have become one of the most potential developed companies among specialized textile enterprises in China. World-class machinery and finishing equipment keep our production line in a high edge. We can produce all kinds of fabrics more than 6 million meters per month. As a professional fabric manufacturer, we have a group of creative designers and a strong QC team. Therefore, we can not only offer various designs to fit customers' requests, but also can strictly control the quality and progress of the production from raw material to final program. Our factories are specialized in producing Warp Mesh Fabric, Lace Fabric, Knitted Fabric,Denim Fabric etc. Our products are widely used in fields of garments, bags, shoes, motorcycle covers,hats, shirts, dresses, skirt, underwear, panties, stockings, blouses, bedding sheets, curtains, toys, furniture, plastics, raincoats, lanterns, handkerchiefs, flags,jeans, banner advertising and travel supply. With a wide range, good quality, reasonable prices and stylish designs, our products are extensively used in textile industry and other industries. We have insisted on the principle of "Superior quality, honest management, and professional service". We are definite about our development aim and perfect our management, strictly controlling quality and honestly co-operating with our clients. We are devoted to making our factory become an international famous enterprise. We enjoy working together with customers and continuously striving for excellence to develop the textile industry and realize the dreams of glory!
                                    </p>
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
