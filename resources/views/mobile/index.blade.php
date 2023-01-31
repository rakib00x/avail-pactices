@extends('mobile/master-website')
@section('page_heading', 'Home')
<?php
    $meta_info 	= DB::table('tbl_meta_tags')->first();
	$settings 	= DB::table('tbl_logo_settings')->where('status', 1)->first();
	$currency  	= DB::table('tbl_currency_status')->where('status',1)->get();
?>
@section('meta_info')
    <meta name="description" content="<?php echo $meta_info->meta_details; ?>" />
    <meta property="fb:app_id" content="" />
    <meta property="fb:pages" content="" />
    <meta property='og:locale' content='en_US'/>
    <meta property="og:site_name" content="availtrade.com"/>
    <meta name="author" content="availtrade.com">
    <meta property="og:url" content="{{ URL::to('/') }}" />
    <meta property="og:type" content="article"/>
    <meta property="og:title" content='<?php echo $meta_info->meta_title; ?>' />
    <meta property="og:image" content="{{ URL::to('public/images') }}/{{ $meta_info->meta_image }}"/>
    <meta property="og:description" content="<?php echo $meta_info->meta_details; ?>"/>
    <meta property="article:author" content="http://www.availtrade.com" />
    <link rel="canonical" href="{{ URL::to('/') }}">
    <link rel="amphtml" href="{{ URL::to('/') }}" />

    <!-- twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="Availtrade" />
    <meta name="twitter:url" content="{{ URL::to('/') }}" />
    <meta name="twitter:title" content='<?php echo $meta_info->meta_title; ?>' />
    <meta name="twitter:description" content="<?php echo $meta_info->meta_details; ?>" />
    <meta name="twitter:creator" content="" />
    <meta property="article:published_time" content="">
    <meta property="article:author" content="https://www.availtrade.com">
    <meta property="article:section" content="">
    
@endsection
@section('content')
    <?php 
        $base_url = "http://localhost/availtrades/";
        $settings   = DB::table('tbl_logo_settings')->where('status', 1)->first();
        // Currency Auto Conversion End
           $namazasd 	= DB::table('namazs')->where('status', 1)->get();
          
     ?>

   </div>

    <div class="container " style="padding-top: 43px !important;">
        <!-- all category -->
        <div class="row">
            <div class="col-12 <?php if(count($namazasd) == 0){ echo "mt-4";}else{ echo "mt-2";} ?>">
                <div class="scrolling-wrapper row flex-row flex-nowrap">
                    <div class="col-auto"><a href="{{ URL::to('all-categories') }}"><span class="badge badge-success">All</span></a></div>
                    <?php foreach ($primarycategory as $key => $prvalue): ?>
                        <div class="col-auto"><a href="{{ URL::to('m/category/'.$prvalue->catgeory_slug) }}/heightolow"><span class="badge badge-success">{{ $prvalue->category_name }}</span></a></div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
            
    </div>
        <div id="mycarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-indicators">
             @foreach($slider as $key => $value)
                <button type="button" data-bs-target="#mycarousel" data-bs-slide-to="{{ $key }}" class="{$key == 0 ? 'active' : '' }}" aria-label="Slide {{ $key }}" style="width: 13px;height: 13px;border-radius: 50%;"></button>
            @endforeach

          </div>
          <div class="carousel-inner">
                @foreach($slider as $key => $value)
                <div class="carousel-item {{$key == 0 ? 'active' : '' }}">
                    <img src="{{asset('public/images/homeSlider/')}}/{{$value->slider_image??''}}" class="d-block w-100"  alt="..."> 
                </div>
                @endforeach
          </div>
        </div>

        <!-- Flash Sale Slide-->
        <div class="flash-sale-wrapper">
            <div class="container">
                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6 class="me-1 d-flex align-items-center pt-3">Top-Ranking</h6>
                </div>
                <!-- Flash Sale Slide-->
                <div class="flash-sale-slide owl-carousel">
                    <?php foreach ($feature_product as $key => $featurvalue): ?>
                        <!-- Single Flash Sale Card-->
                        <?php $featurvalueproduct = explode("#", $featurvalue->products_image); ?>
                        <div class="card flash-sale-card">
                            <div class="card-body">
                                <a href="{{ URL::to('m/product/'.$featurvalue->slug) }}"><img src="<?php echo $base_url."public/images/".$featurvalueproduct[0]; ?>" alt="{{ $featurvalue->product_name }}" style="width: 138px;height: 104px;"><span class="product-title">{{ $featurvalue->product_name }}</span></a>
                            </div>
                        </div>
                    <?php endforeach ?>

                </div>
            </div>
            <div class="container">
                <!--.text-center.mt-3-->
                <!--a.btn.btn-warning.btn-sm(href="flash-sale.html") View All-->
            </div>
        </div>

        <!-- Weekly Deals -->
        <div class="container  pt-2 pb-2">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6>Weekly Deals</h6>
            </div>
            <div class="row g-3">
                <?php foreach ($weaklydeal as $key => $weakvalue): ?>
                    <?php
                        $product_price_info = DB::table('tbl_product_price')
                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                            ->where('product_id', $weakvalue->product_id)
                            ->orderBy('product_price', 'asc')
                            ->first() ;

                        $product_price_max_info = DB::table('tbl_product_price')
                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit' , 'tbl_unit_price.unit_name','tbl_currency_status.rate as currency_rate')
                            ->where('product_id', $weakvalue->product_id)
                            ->orderBy('product_price', 'desc')
                            ->first() ;

                    ?>
                    <!-- Single Top Product Card-->
                    <div class="col-4 col-md-4 col-lg-3">
                        <div class="card top-product-card">
                            <?php $weakvalue_image = explode("#", $product_price_info->products_image); ?>
                            <div class="card-body" style="padding: 10px 7px;">
                                <a class="product-thumbnail d-block single-product-hot-selling" href="{{ URL::to('m/product/'.$product_price_info->slug) }}">
                                    <img class="mb-1" src="<?php echo $base_url."public/images/".$weakvalue_image[0]; ?>" alt="{{ $product_price_info->product_name }}" style="width: 100px; height:100px;">
                                </a>
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
                                
                                <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $weakvalue->visitor_count }}</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
                

            </div>
        </div>

        <!-- New Arrivals -->
        <div class="container mt-4 pt-0 pb-2">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6>New Arrivals</h6>
            </div>
            <div class="row g-3">


                 <?php foreach ($new_products as $key => $new_value): ?>
                    <?php
                        $new_product_price__info = DB::table('tbl_product_price')
                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_currency_status.rate as currency_rate')
                            ->where('tbl_product_price.product_id', $new_value->id)
                            ->orderBy('tbl_product_price.product_price', 'asc')
                            ->first() ;

                        $new_product_price_max_info = DB::table('tbl_product_price')
                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit' , 'tbl_unit_price.unit_name')
                            ->where('product_id', $new_value->id)
                            ->orderBy('product_price', 'desc')
                            ->first() ;


                    ?>
                    <!-- Single Top Product Card-->
                    <div class="col-4 col-md-4 col-lg-3">
                        <div class="card top-product-card">
                            <?php $new_image = explode("#", $new_product_price__info->products_image); ?>
                            <div class="card-body" style="padding: 10px 7px;">
                                <a class="product-thumbnail d-block single-product-hot-selling" href="{{ URL::to('m/product/'.$new_value->slug) }}">
                                    <img class="mb-1" src="<?php echo $base_url."public/images/".$new_image[0]; ?>" alt="{{ $new_product_price__info->product_name }}" style="width: 100px; height:100px;">
                                </a>
                                <p class="mb-0">
                                    
                                    <?php
                                        if($new_product_price__info->product_price > 0){
                                            if(Session::has('requestedCurrency')){
                                                $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                $product_price_convert2 = $new_product_price__info->product_price / $new_product_price__info->currency_rate;
                                                $now_product_price_is2 = $product_price_convert2 * $main_currancy_status2->rate ;
                                                $currency_code2 = $main_currancy_status2->symbol;
                                            }else{
                                                $currency_code2 = $new_product_price__info->code;
                                                $now_product_price_is2 = $new_product_price__info->product_price;
                                            }
                                            
                                            echo $currency_code2." ".number_format($now_product_price_is2, 2);
                                        }else{
                                            echo ucwords($new_product_price__info->negotiate_price);
                                        }
                                    
                                    ?>
                                    
                                </p>
                                <p class="mb-0"><?php if($new_product_price__info->start_quantity > 0){echo $new_product_price__info->start_quantity;}else{echo "1"; } ?> {{ $new_product_price__info->unit_name }}</p>
                                <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $new_value->visitor_count }}</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>
        </div>

        <!-- Just for you -->
        <div class="container mt-4 pt-0 mb-4">

            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6>Just for You</h6>
            </div>
            <div class="row g-3 pb-0" id="get_data" style="margin-bottom:65px;">
                    
                        <?php
                            $just_for_you = DB::table('tbl_product')
                                ->where('tbl_product.status', 1)->inRandomOrder()
                                ->paginate(10) ;
        
                            foreach($just_for_you as $justvalue) :
                            $all_id[] = $justvalue->id ;
                        ?>
                        <?php $just_for_image = explode("#", $justvalue->products_image); ?>
                        <!-- Single Top Product Card-->
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="card top-product-card">
                                <div class="card-body mb-0 pb-0 mt-0 pt-3">
                                    <a class="product-thumbnail d-block single-product-recommended" href="{{ URL::to('m/product/'.$justvalue->slug) }}">
                                        <img class="mb-2" src="<?php echo $base_url."public/images/".$just_for_image[0]; ?>" alt="{{ $justvalue->product_name }}" style="height:150px;">
                                    </a>
                                    <a class="product-title d-block" href="{{ URL::to('m/product/'.$justvalue->slug) }}"><?php echo substr($justvalue->product_name,0, 15); ?></a>
                                    <?php
                                        $just_product_price__info = DB::table('tbl_product_price')
                                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_currency_status.rate as currency_rate')
                                            ->where('tbl_product_price.product_id', $justvalue->id)
                                            ->orderBy('tbl_product_price.product_price', 'asc')
                                            ->first() ;
        
                                        $just_product_price_max_info = DB::table('tbl_product_price')
                                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit' , 'tbl_unit_price.unit_name')
                                            ->where('tbl_product_price.product_id', $justvalue->id)
                                            ->orderBy('tbl_product_price.product_price', 'desc')
                                            ->first() ;
        
                                    ?>
                                        <p class="mb-0" style="height: 39px">
                                            <?php
                                                if($just_product_price__info->product_price > 0){
                                                    if(Session::has('requestedCurrency')){
                                                        $main_currancy_status3 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                        $product_price_convert = $just_product_price__info->product_price / $just_product_price__info->currency_rate;
                                                        $now_product_price_is = $product_price_convert * $main_currancy_status3->rate ;
                                                        $currency_code = $main_currancy_status3->symbol;
                                                    }else{
                                                        $currency_code = $just_product_price__info->code;
                                                        $now_product_price_is = $just_product_price__info->product_price;
                                                    }
                                                    
                                                    echo $currency_code." ".number_format($now_product_price_is, 2);
                                                }else{
                                                    echo ucwords($just_product_price__info->negotiate_price);
                                                }
                                            ?>
                                        </p>
        
                                    <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $justvalue->visitor_count }}</p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ; ?>

            </div>
            
            <div id="load_data_message"></div>
        </div>
@endsection
@section('page_headline')
Home
@endsection
@section('js')
<script src="{{ URL::to('public/mobile/js/jquery.min.js') }}"></script>
<script>
    $("#mobile_currency").change(function(){
        var mobile_currency = $(this).val() ;
        var main_link       = "<?php echo env('APP_URL'); ?>m/mobilechangeCurrency/"+mobile_currency;
        window.location     = main_link;
    });
</script>
<script>
    $(document).ready(function(){

       var limit = 16;
       var start = 16;
       var action = 'inactive';
    
       function loadData(limit, start)
       {


        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
    

        $.ajax({
         url:"<?php echo env('APP_URL').'m/getmobileindexproduct'; ?>",
         method:"POST",
         data:{limit:limit, start:start},
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

<script>
$('.carousel').carousel();
</script>
@endsection