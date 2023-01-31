@extends('mobile.master-website')
@section('page_heading')
{{ $supplier_info->storeName }}
@endsection
@section('meta_info')
    <meta name="description" content="{{ $supplier_info->companyDetails }}" />
    <meta property="fb:app_id" content="" />
    <meta property="fb:pages" content="" />
    <meta property='og:locale' content='en_US'/>
    <meta property="og:site_name" content="availtrade.com"/>
    <meta name="author" content="availtrade.com">
    <meta property="og:url" content="{{ URL::to('/') }}" />
    <meta property="og:type" content="article"/>
    <meta property="og:title" content='{{ $supplier_info->storeName }}' />
    <meta property="og:image" content="{{ URL::to('public/images') }}/{{ $supplier_info->image }}"/>
    <meta property="og:description" content="{{ $supplier_info->companyDetails }}"/>
    <meta property="article:author" content="http://www.availtrade.com" />
    <link rel="canonical" href="{{ URL::to('/') }}">
    <link rel="amphtml" href="{{ URL::to('/') }}" />
    <!-- twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="Availtrade" />
    <meta name="twitter:url" content="{{ URL::to('/') }}" />
    <meta name="twitter:title" content='{{ $supplier_info->storeName }}' />
    <meta name="twitter:description" content="{{ $supplier_info->companyDetails }}" />
    <meta name="twitter:creator" content="" />
    <meta property="article:published_time" content="">
    <meta property="article:author" content="https://www.availtrade.com">
    <meta property="article:section" content="">
    
@endsection
@section('content')
    <?php $default_banner = DB::table('tbl_default_setting')->first(); ?>

    <?php
        $banner_info = DB::table('tbl_supplier_header_banner')
            ->where('supplier_id', $supplier_info->id)
            ->first() ;
            
        $store_info = DB::table('express')
                ->where('id', $supplier_info->id)
                ->first() ;

    ?>


        <!-- Product Slides-->

        <div class="product-description pb-3">
@php 
 $all_sli = DB::table('tbl_slider')->where('supplier_id', $supplier_info->id)->where('status', 1)->get(); 
@endphp


            <div class="mb-0 mt-1 pt-5">

                <div class="container d-flex justify-content-between" style="margin-top:16px;">
                    @if(count($all_sli) > 0)
                    
            <div id="mycarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
              @foreach($all_slider as $key => $value)
                <button type="button" data-bs-target="#mycarousel" data-bs-slide-to="{{ $key }}" class="{$key == 0 ? 'active' : '' }}" aria-label="Slide {{ $key }}" style="width: 13px;height: 13px;border-radius: 50%;"></button>
            @endforeach

          </div>
          <div class="carousel-inner">
                @foreach($all_slider as $key => $value)
                <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                    <img src="{{asset('public/images/supplierSlider/')}}/{{$value->slider_image??''}}" class="d-block w-100"  alt="..."> 
                </div>
                @endforeach
          </div>
        </div>
        @else
                    
                    <div class="p-title-price pb-2" style="background: url('{{ URL::to("public/images/defult/")}}/<?php if($banner_info){ if($banner_info->header_image != ""){echo $banner_info->header_image;}else{ echo $default_banner->banner_image; } $banner_info->header_image; }else{echo $default_banner->banner_image; } ?>'); background-size: 100% 100%;width: 100%;height: 145px;">
                        <h5 class="mb-1" style="margin-top: 24px;">
                            <?php if ($store_info->image): ?>
                           	<img  src="{{ URL::to('public/images/spplierPro/'.$store_info->image) }}" width="60" alt="">
							<?php else: ?>
							<img class="store_company_logo" src="{{ URL::to('public/images/defult/'.$default_banner->logo) }}" width="60" alt="">
							<?php endif ?>
                            
                        </h5>
                        <p><img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower($supplier_info->countryCode).'.png'; ?>" width="24" height="18" alt=""> &nbsp;&nbsp;<span style="background: #d1d1d1;color: #fff;border-radius: 5px;padding-left: 6px;padding-right: 6px;font-weight: bold;"><?php
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

 								?></span></p>
                    </div>
                    @endif
                </div>
                
                <div class="container d-flex justify-content-between ml-2 pl-0 pb-0 pt-0">
                    <div class="bg-white" style="width: 100%;padding:2px 0px;margin-top:5px">
                        <table>
                            <tr>
                                <!--<td><a class="btn btn-danger btn-sm" href="#" data-bs-toggle="modal" data-bs-target="#suppliersearch"><i class="lni lni-search-alt"></i></a></td>-->
                                <!--<td>&nbsp;</td>-->
                                <td><a class="btn btn-success btn-sm" href="{{ URL::to('m/'.strtolower($supplier_info->storeName)) }}">Home</a></td>
                                <td>&nbsp;</td>
                                <td><a class="btn btn-primary btn-sm" href="{{ URL::to('m/'.strtolower($supplier_info->storeName).'/smcatgeorys') }}">Products</a></td>
                                <td>&nbsp;</td>
                                <td><a class="btn btn-warning btn-sm" href="{{ URL::to('m/'.strtolower($supplier_info->storeName).'/companyoverview') }}">Profile</a></td>
                            </tr>
                        </table>
                    </div>
                    
                </div>

            </div>

            
        </div>

        
        <!-- Just for you -->
        <div class="container" style="margin-top:30px!important">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6>All Categorys</h6>
            </div>
             <ul class="page-nav ps-0">
                 
                 
                <?php foreach ($all_primary_category as $key => $value): ?>
                    <li><a href="{{ URL::to('m/'.strtolower($store_info->storeName).'/mscategory/'.$value->catgeory_slug.'/lowtoheigh') }}">{{ $value->category_name }} <i class="lni lni-chevron-right"></i></a></li>
                <?php endforeach ?>
            </ul>
        </div>
        
@endsection

        
@section('page_headline')
    All Categorys
@endsection


