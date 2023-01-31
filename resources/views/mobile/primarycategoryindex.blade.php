@extends('mobile.master-website')
@section('content')
    <?php 
        $base_url = "https://availtrade.com/";
     ?>

        

        <div class="pt-5">
            <div class="container">
              <!-- Hero Slides-->
                <div class="hero-slides owl-carousel">
                    @foreach($category_slider as $svalue)
                    <!-- Single Hero Slide-->
                    <div class="single-hero-slide" style="background-image: url('<?php echo $base_url."public/images/".$svalue->slider_image; ?>');background-size: 100% 100%;width: 100%;height: 260px;">
                    </div>
                     @endforeach
                </div>
            </div>
        </div>

              <!-- Product Catagories-->
      <div class="product-catagories-wrapper py-3">
        <div class="container">
          <div class="section-heading">
            <h6>Sub Category</h6>
          </div>

            <div class="product-catagories">
                <div class="row g-3">
                    <?php foreach ($all_catgeory_1 as $key => $secondarycategoryvlaue): ?>
                            <!-- Single Catagory-->
                        <div class="col-4" ><a class="shadow-sm" style="min-height:45px !important;" href="{{ URL::to('m/seccategory/'.$secondarycategoryvlaue->secondary_category_slug.'/heightolow') }}">{!! Str::limit( $secondarycategoryvlaue->secondary_category_name, 20)!!}</a></div>
                        <!-- Single Catagory-->
                    <?php endforeach ?>
                    
                </div>
            </div>

        </div>
      </div>

        <!-- Top Products-->
        <div class="top-products-area py-3">
            <div class="container">
                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6>Recommended for you</h6>
                    <!-- Select Product Catagory-->
                    <div class="select-product-catagory">
                        <select class="form-select" id="pricefilter" name="pricefilter" aria-label="Default select example">
                            <option selected>Short by</option>
                            <option value="heightolow" <?php if($pricefilter == "heightolow"){echo "selected"; }else{echo ""; } ?>>High to Low Price</option>
                            <option value="lowtohigh" <?php if($pricefilter == "lowtohigh"){echo "selected"; }else{echo ""; } ?>>Low to High Price</option>
                        </select>
                    </div>
                </div>
                <div class="row g-3" id="get_data">

                    <?php

                    foreach($all_product as $justvalue) :
                        $all_id[] = $justvalue->id ;
                    ?>
                     <?php $just_for_image = explode("#", $justvalue->products_image); ?>

                    <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body mb-0 pb-0 mt-0 pt-3">
                            <a class="product-thumbnail d-block single-product-recommended" href="{{ URL::to('m/product/'.$justvalue->slug) }}">
                                <img class="mb-2" src="<?php echo $base_url."public/images/".$just_for_image[0]; ?>" alt="{{ $justvalue->product_name }}" style="width: 155px;height: 155px;">
                            </a>
                            <a class="product-title d-block" href="{{ URL::to('m/product/'.$justvalue->slug) }}"><?php echo substr($justvalue->product_name,0, 15); ?></a>
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
                            <p class="mb-0"><?php if($product_price_info->start_quantity > 0){echo $product_price_info->start_quantity;}else{echo "1"; } ?> {{ $product_price_info->unit_name }}</p>
                                
                            <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $justvalue->visitor_count }}</p>
                            
                        </div>
                    </div>
                </div>
                <?php endforeach ; ?>
                </div>
                <div id="load_data_message"></div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<style>
    .single-product-recommended img {
        border: 1px solid #ddd !important;
        width: 142px !important;
        height: 142px !important;
        padding: 5px;
    }
</style>
@endsection

@section('page_headline')
{{ $category_info->category_name }}
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
    var main_link   = "{{ URL::to('m/category') }}"+"/<?php echo $category_slug; ?>"+"/"+pricefilter;
    window.location = main_link;
});

  $(document).ready(function(){

   var limit = 12;
   var start = 12;
   var action = 'inactive';

   function loadData(limit, start)
   {


    var pricefilter      = $("#pricefilter").val() ;
    var category_slug    = "<?php echo $category_slug; ?>" ;
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
     });

    $.ajax({
     url:"{{ route('main_category_paginate') }}",
     method:"POST",
     data:{limit:limit, start:start, category_slug:category_slug, pricefilter:pricefilter},
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
