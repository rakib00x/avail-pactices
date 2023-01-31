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

<style>
    .header-area-second{
        margin-top: 26px!important;
    }
</style>
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
    
         <!-- Product Catagories-->
        <div class="product-catagories-wrapper py-3" style="padding-top: 30px!important;">
            <div class="container">
    
                <div class="product-catagories">
                    <div class="row g-3">
                        <?php foreach ($allsecondarycategorys as $key => $tertiarycategoryvlaue): ?>
                                <!-- Single Catagory-->
                            <div class="col-4"><a  style="height: 50px;" class="shadow-sm" href="{{ URL::to('m/'.strtolower($store_info->storeName).'/mssecondarycategory/'.$tertiarycategoryvlaue->secondary_category_slug.'/lowtoheigh') }}" >{{ Str::limit($tertiarycategoryvlaue->secondary_category_name, 22) }} </a></div>
                            <!-- Single Catagory-->
                        <?php endforeach ?>
                        
                    </div>
                </div>
    
            </div>
        </div>

        
        <!-- Just for you -->
        <div class="container">

            <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6>Recommended for you</h6>
                    <!-- Select Product Catagory-->
                    <div class="select-product-catagory">
                        <select class="form-select" id="pricefilter" name="pricefilter" aria-label="Default select example">
                            <option value="heightolow" <?php if($pricefilter == "heightolow"){echo "selected"; }else{echo ""; } ?>>High to Low Price</option>
                                <option value="lowtoheigh" <?php if($pricefilter == "lowtoheigh"){echo "selected"; }else{echo ""; } ?>>Low to High Price</option>
                        </select>
                    </div>
                </div>
            <div class="row g-3" id="get_data">
                <?php foreach($just_for_you as $justvalue) :
                ?>
                <?php $just_for_image = explode("#", $justvalue->products_image); ?>
                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body mb-0 pb-0 mt-0 pt-3">
                            <a class="product-thumbnail d-block single-product-recommended" href="<?php echo env('APP_URL').'m/product/'.$justvalue->slug ; ?>">
                                <img class="mb-2" src="{{ URL::to('public/images/'.$just_for_image[0]) }}" alt="{{ $justvalue->product_name }}" style="width: 155px;height: 155px;">
                            </a>
                            <a class="product-title d-block" href="<?php echo env('APP_URL').'m/product/'.$justvalue->slug ; ?>"><?php echo substr($justvalue->product_name,0, 15); ?></a>
                            <?php
                                $product_price_info = DB::table('tbl_product_price')
                                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                    ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                    ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                    ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                    ->where('product_id', $justvalue->product_id)
                                    ->orderBy('product_price', 'asc')
                                    ->first() ;
        
                                $product_price_max_info = DB::table('tbl_product_price')
                                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                    ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                    ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                    ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit' , 'tbl_unit_price.unit_name','tbl_currency_status.rate as currency_rate')
                                    ->where('product_id', $justvalue->product_id)
                                    ->orderBy('product_price', 'desc')
                                    ->first() ;
        
                            ?>
                            
                            <p class="mb-0"><?php 
                                if($product_price_info->product_price > 0){
                                    if(Session::has('requestedCurrency')){
                                        $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                        $product_price_convert = $product_price_info->product_price / $product_price_info->currency_rate;
                                        $now_product_price_is = $product_price_convert * $main_currancy_status->rate ;
                                        $currency_code = $main_currancy_status->symbol;
                                    }else{
                                        $currency_code = $product_price_info->code;
                                        $now_product_price_is = $product_price_info->product_price;
                                    }
                                    
                                    echo $currency_code." ".number_format($now_product_price_is, 2);
                                }else{
                                    echo ucwords($product_price_info->negotiate_price);
                                }
                                
                            ?></p>
                            <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $justvalue->visitor_count }}</p>
                        </div>
                    </div>
                </div>
            <?php endforeach ; ?>

            </div>
            <div id="load_data_message"></div>
        </div>
        
@endsection

    <!-- Modal -->
    <div class="modal fade" id="suppliersearch" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <div class="top-search-form" >
              {!! Form::open(['url' =>'mssearch','method' => 'get','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                <input class="form-control" type="text" name="keywords" placeholder="Enter your keyword" style="max-width: 326px!important;background-color: #ffbebe!important;color: white!important;">
                <input name="filter" value="lowtoheigh" type="hidden" />
                <button type="submit" style="color: white!important;"><i class="fa fa-search"></i></button>
              {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
        
@section('page_headline')
    <?php
        if($supplier_info->companyName != ""){
            echo $supplier_info->companyName;
        }else{
            if (strpos($supplier_info->storeName, '-') !== false) {
                $explode_info = explode("-", $supplier_info->storeName);
                $main_info = implode(' ', $explode_info);
                echo $main_info ;
            }else{
                echo $supplier_info->storeName;
            }
        }
    ?>
@endsection
@section('js')
    <script>
        $("#mobile_currency").change(function(){
            var mobile_currency = $(this).val() ;
            var main_link       = "<?php echo env('APP_URL'); ?>m/mobilechangeCurrency/"+mobile_currency;
            window.location     = main_link;
        });
    </script>
    <script>
        $("#pricefilter").change(function(){
            var pricefilter = $(this).val() ;
            var categoryslug = "<?php echo $categoryslug; ?>" ;
            var store_id = "<?php echo $supplier_info->id; ?>";
            
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
             });
        
            $.ajax({
             url:"<?php echo env('APP_URL').'m/'.strtolower($supplier_info->storeName).'/getsupplierprimarycategryfilter'; ?>",
             method:"POST",
             data:{store_id:store_id, pricefilter:pricefilter, categoryslug:categoryslug},
             cache:false,
             success:function(data)
             {
                $('#get_data').empty().html(data);
           }
         });
            
        });
        
         $(document).ready(function(){

           var limit = 12;
           var start = 12;
           var action = 'inactive';
        
           function loadData(limit, start)
           {
    
            var pricefilter      = $("#pricefilter :selected").val() ;
            var store_id    = "<?php echo $supplier_info->id; ?>" ;
            var categoryslug = "<?php echo $categoryslug; ?>" ;
            
            $.ajaxSetup({
                headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
             });
        
            $.ajax({
             url:"<?php echo env('APP_URL').'m/'.strtolower($supplier_info->storeName).'/getmoiblesupplierprimarycategoryproductpanigate'; ?>",
             method:"POST",
             data:{limit:limit, start:start, store_id:store_id, pricefilter:pricefilter, categoryslug:categoryslug},
             cache:false,
             success:function(data)
             {
              $('#get_data').append(data);
              if(data == '')
              {
               $('#load_data_message').html("<div style='width: 100%;background:#fff;border-radius: 8px;padding:1px;margin-top: 10px;'><p style='text-align: center;font-weight: bold;'>End</p></div>'");
               action = 'active';
             }
             else
             {
               $('#load_data_message').html("<div style='width: 100%;background:#fff;border-radius: 8px;padding:1px;margin-top: 10px;'><p style='text-align: center;font-weight: bold;'>Loading</p></div>'");
               action = "inactive";
             }
        
           }
         });
          }
        
          if(action == 'inactive')
          {
            action = 'active';
            loadData(limit, start);
          }
          $(window).scroll(function(){
            if($(window).scrollTop() + $(window).height() > $("#get_data").height() && action == 'inactive')
            {
             action = 'active';
             start = start + limit;
             setTimeout(function(){
              loadData(limit, start);
            }, 1000);
           }
         });
        });
    </script>
@endsection

