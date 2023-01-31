@extends('frontEnd.master')
@section('title')
{{$category_info->category_name}}
@endsection
<?php
    $meta_info 	= DB::table('tbl_meta_tags')->first();
	$settings 	= DB::table('tbl_logo_settings')->where('status', 1)->first();
?>
@section('meta_info')

    <meta name="title" content="{{ $meta_info->meta_title }}">
    <meta name="description" content="{{ $meta_info->meta_details }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $meta_info->meta_title }}">
    <meta property="og:description" content="{{ $meta_info->meta_details }}">
    <meta property="og:image" content="{{ URL::to('public/images/'.$settings->logo) }}"/>
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $meta_info->meta_title }}">
    <meta property="twitter:description" content="{{ $meta_info->meta_details }}">
    <meta property="twitter:image" content="{{ URL::to('public/images/'.$settings->logo) }}">

@endsection
@section('content')

	<div class="wrapper">
        <div class="container">

            <div class="columns is-gapless">
                <div class="column is-one-fifth pr-5">
                    
                    <div class="category-sidebar-navbar" style="background-color: #FFF;">
                        <h2 class="ml-2" style="border-bottom: 2px solid #f3f3f3; padding: 10px 0px; margin-bottom: 10px; margin-right: 15px;"><strong>CATEGORIES</strong></h2>
                        <ul class="primarycategory">
                            <?php foreach($all_catgeory_2 as $seconaryvalue): ?>
                            <a href="{{ URL::to('seccategory/'.$seconaryvalue->secondary_category_slug.'/heightolow') }}" title="{{ $seconaryvalue->secondary_category_name }}" style="color:black ;">
                                <li id="dropdown" style="display: block;width: 100%;clear: both;padding: 0px!important; line-height: 0px!important;">
                                    <img src="{{ URL::to('public/images/secCetegroy/'.$seconaryvalue->secondary_category_icon) }}" alt="{{ $seconaryvalue->secondary_category_name }}"/>
                                    <span  style="line-height: 2.6 !important;"><?php $catname = $seconaryvalue->secondary_category_name; $strlen = strlen($catname); if($strlen == 24 || $strlen < 24){ echo $catname; }else{ echo substr($catname,0,24); } ?></span>
                                    <img src="{{ URL::to('public/images/right-arrow.png') }}" class="is-pulled-right" style="width: 10px !important; height: 10px; margin-top: 16px; margin-right: 20px;" alt="availtrade"/>
                                    
                                    <div class="category-sidebar-navbar-mega-dropdown" style="height:288px">
                                        <div class="is-flex mb-3">
                                            <?php 

                                                $all_tertirary_categorys = DB::table('tbl_tartiarycategory')
                                                    ->where('primary_category_id', $category_info->id)
                                                    ->where('secondary_category_id', $seconaryvalue->id)
                                                    ->where('status', 1)
                                                    ->count() ;

                                             ?>
                                            <?php if ($all_tertirary_categorys > 9): ?>
                                                <?php 

                                                    $all_tertirary_categorys_1 = DB::table('tbl_tartiarycategory')
                                                        ->where('primary_category_id', $category_info->id)
                                                        ->where('secondary_category_id', $seconaryvalue->id)
                                                        ->where('status', 1)
                                                        ->limit(10)
                                                        ->get() ;

                                                 ?>
                                                 <div style="width: 25%;">
                                                    <ul>
                                                        <?php foreach ($all_tertirary_categorys_1 as $key => $valuecat1): ?>
                                                            <li><a href="{{ URL::to('tercategory/'.$valuecat1->tartiary_category_slug) }}">{{ $valuecat1->tartiary_category_name }}</a></li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </div>
                                             <?php endif ?>
                                            <?php if ($all_tertirary_categorys > 10): ?>
                                                <div style="width: 25%;">
                                                    <?php 

                                                    $all_tertirary_categorys_2 = DB::table('tbl_tartiarycategory')
                                                        ->where('primary_category_id', $category_info->id)
                                                        ->where('secondary_category_id', $seconaryvalue->id)
                                                        ->where('status', 1)
                                                        ->offset(10)
                                                        ->limit(10)
                                                        ->get() ;

                                                 ?>
                                                    <ul>
                                                        <?php foreach ($all_tertirary_categorys_2 as $key => $valuecat2): ?>
                                                            <li><a href="{{ URL::to('tercategory/'.$valuecat2->tartiary_category_slug.'/heightolow') }}">{{ $valuecat2->tartiary_category_name }}</a></li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </div>
                                            <?php endif ?>

                                            <?php if ($all_tertirary_categorys > 20): ?>
                                                <div style="width: 25%;">
                                                    <?php 

                                                    $all_tertirary_categorys_3 = DB::table('tbl_tartiarycategory')
                                                        ->where('primary_category_id', $category_info->id)
                                                        ->where('secondary_category_id', $seconaryvalue->id)
                                                        ->where('status', 1)
                                                        ->offset(20)
                                                        ->limit(10)
                                                        ->get() ;

                                                 ?>
                                                    <ul>
                                                        <?php foreach ($all_tertirary_categorys_3 as $key => $valuecat3): ?>
                                                            <li><a href="{{ URL::to('tercategory/'.$valuecat3->tartiary_category_slug) }}">{{ $valuecat3->tartiary_category_name }}</a></li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </div>
                                            <?php endif ?>                                        

                                            <?php if ($all_tertirary_categorys > 30): ?>
                                                <div style="width: 25%;">
                                                    <?php 

                                                    $all_tertirary_categorys_4 = DB::table('tbl_tartiarycategory')
                                                        ->where('primary_category_id', $category_info->id)
                                                        ->where('secondary_category_id', $seconaryvalue->id)
                                                        ->where('status', 1)
                                                        ->offset(30)
                                                        ->limit(10)
                                                        ->get() ;

                                                 ?>
                                                    <ul>
                                                        <?php foreach ($all_tertirary_categorys_4 as $key => $valuecat4): ?>
                                                            <li><a href="{{ URL::to('tercategory/'.$valuecat4->tartiary_category_slug) }}">{{ $valuecat4->tartiary_category_name }}</a></li>
                                                        <?php endforeach ?>
                                                    </ul>
                                                </div>
                                            <?php endif ?>

                                        </div>
                                    </div>
                                </li>
                            </a>
                        <?php endforeach; ?>
                            <li>
                                <a href="{{URL::to('/all-categories')}}" style="color:black;" title="All Categories"><img src="{{ URL::to('public/images/Image 15.png') }}" alt="availtrade"/> All Categories</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="column is-two-quarters m-0">

                    <!-- Slider -->
                    <div class="columns is-full">
                        <div class="column is-full">
                            <div id="category-main-inner">
                                <div id="category-slider">
                                    <?php foreach ($category_slider as $key => $slidervalue): ?>
                                        <a href="{{ $slidervalue->slider_link }}" title=""><img src="{{ URL::to('public/images/categorySlider/'.$slidervalue->slider_image) }}" class="category-img-size" alt="availtrade"/></a>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns ml-0 mt-0 mr-0 box p-0" style="background: #ffffff;">
                        <?php foreach ($all_catgeory_3 as  $cat3value): ?>
                            
                            <div class="column mr-0 pr-0">
                                <a href="{{ URL::to('seccategory/'.$cat3value->secondary_category_slug.'/heightolow') }}" style="color:black">
                                    <img src="{{ URL::to('public/images/secCetegroy/'.$cat3value->secondary_category_icon) }}" alt="{{ $cat3value->secondary_category_name }}" style="height: 98px;border-radius: 50%;">
                                    <p>{{ $cat3value->secondary_category_name }}</p>
                                </a>
                                
                            </div>
                        <?php endforeach ?>
                        
                    </div>

                </div>
            </div>



    </div>

    <div class="container mt-5 is-gapless">
        
        <div class="columns mt-5">
            <div class="column mt-5">
                <h1 class="pl-0 pt-3 pb-2" style="font-size: 20px;font-weight: bold;">Recommended For You</h1>
            </div>
            <div class="column mt-5" style="margin-left: 940px;">
                <table>
                    <tr>
                        <td>
                            <select name="" style="padding: 8px 10px;font-size: 18px;font-weight: bold;" id="pricefilter">
                                <option value="heightolow" <?php if($pricefilter == "heightolow"){echo "selected"; }else{echo ""; } ?>>High to Low Price</option>
                                <option value="lowtohigh" <?php if($pricefilter == "lowtohigh"){echo "selected"; }else{echo ""; } ?>>Low to High Price</option>
                            </select>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        
        <span id="get_content">
            <div class="columns">
                <div class="column is-full mb-0">
                    <?php foreach ($all_product as $justvalue): ?>
                    	<div class="sonia box mr-2 p-2" style="border-bottom-left-radius: 6px !important;max-width: 225px;max-height: 400px;">
                            <a href="{{ URL::to('product/'.$justvalue->slug)}}" title="" style="color:black!important">
                    		<?php $product1_image = explode("#", $justvalue->products_image); ?>
            	            <img style="width:209px !important;height: 209px;border-top-left-radius: 6px;border-top-right-radius: 6px;" src="{{ URL::to('public/images/'.$product1_image[0]) }}" alt="{{ $justvalue->product_name }}" style="width:175px; height:175px;" />
            	            <p class="pt-2 pb-2" style="height:62px;">{{ Str::limit($justvalue->product_name, 40) }}</p>
                			<p style="text-align:left">
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
            					<!-- Price section -->
            					@php
            						$price_count = DB::table('tbl_product_price')
            							->where('product_id', $justvalue->id)
            							->count() ;
            
            					@endphp
            					<?php if ($price_count == 1): ?>
            						<b>
            							<?php if ($product_price_info2->price_status == 3): ?>
            								Negotiate
            							<?php else: ?>
            								<?php echo $currency_code2."".number_format($now_product_price_is2, 2) ; ?>
            							<?php endif ?>
            						</b><br/>
            					<?php else: ?>
            						@php
            							$minimum_order = DB::table('tbl_product_price')
		                                    ->where('product_id', $justvalue->id)
		                                    ->orderBy('tbl_product_price.start_quantity', 'asc')
		                                    ->first() ;
            						@endphp
            						<b><?php echo $currency_code2; ?>{{ number_format($now_product_price_is2, 2) }} - {{ number_format($now_product_price_is_max, 2) }}</b><br/>
            					<?php endif ?>
            
            					<?php if ($product_price_info2->price_status == 1): ?>
            					 	@php
            					 		echo $product_price_info2->start_quantity ;
            					 	@endphp
            					 <?php else: ?>
            					 	1
            					 <?php endif ?> {{ $product_price_info2->unit_name }}  (Min. Order)
            				</p>
                        </a>
                        <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $justvalue->visitor_count }}</p>
                    </div>
                    <?php endforeach ?>
                    
                    <?php if(count($all_product) == 0): ?>
                        <center><h2 style="font-size:20px; font-weight:bold; color:red">Product not available</h2></center>
                    <?php endif ?>
                    
                    
                </div>
            </div>
        </span>
        
        
        
        <div class="columns is-full mb-5">
            <div class="column">
                
                {{ $all_product->links('frontEnd.store.customPaginate') }}
                
            </div>
        </div>

    </div>
    

@endsection

@section('css')
<link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/categorySlider.css') }}">
<style>
    .active{
        background-color: green;
        color: white;
    }
    .active:hover{
        color: white!important;
    }
</style>
@endsection

@section('js')
<script src="{{ URL::to('public/frontEnd/assets/js/categoryMiniSlider.js') }}"></script>
<script>
    $(function() {
        $('#category-slider').miniSlider();
    });
</script>


<script>
    
    $("#pricefilter").change(function(){
        var pricefilter = $(this).val() ;
        var main_link   = "<?php echo env('APP_URL'); ?>";
        var gridlink    = main_link+"category/<?php echo $category_slug; ?>"+"/"+pricefilter;
        window.location = gridlink;
    });
    
    
    $(document).ready(function(){

        $(document).on('click', '#prevpage', function(event){
            event.preventDefault(); 
        
            var page             = parseInt($("#next_page").attr('href'))-1;
            $("#next_page").attr("href", page);
            var pricefilter      = $("#pricefilter").val() ;
            var category_slug    = "<?php echo $category_slug; ?>" ;
            var last_pagenumber  = {{ $all_product->lastPage() }} ;


            if (0 < page || page == 1) {
                $(this).attr("href", page);
                $('.pagination-link').removeClass('is-current');
                $('.main_class_'+page).addClass('is-current');
                fetch_data(page, pricefilter, category_slug);
            }else{
                return false ;
            }
            
        });


        $(document).on('click', '#next_page', function(event){
            event.preventDefault(); 
            var page             = parseInt($(this).attr('href'))+1;
            var pricefilter      = $("#pricefilter").val() ;
            var category_slug    = "<?php echo $category_slug; ?>" ;
            var last_pagenumber  = {{ $all_product->lastPage() }} ;


            if (last_pagenumber > page || last_pagenumber == page) {
                $(this).attr("href", page);
                $('.pagination-link').removeClass('is-current');
                $('.main_class_'+page).addClass('is-current');
                fetch_data(page, pricefilter, category_slug);
            }else{
                return false ;
            }
            
        });


        $(document).on('click', '.custom_paginate', function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            var pricefilter      = $("#pricefilter").val() ;
            var category_slug    = "<?php echo $category_slug; ?>" ;
            $("#next_page").attr("href", page);
            $('.pagination-link').removeClass('is-current');
            $('.main_class_'+page).addClass('is-current');

            fetch_data(page, pricefilter, category_slug);
        });

        function fetch_data(page,pricefilter, category_slug)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"{{ url('/getmaincategoryproductforpagination') }}",
                method:"POST",
                data:{page:page,pricefilter:pricefilter, category_slug:category_slug},
                success:function(data)
                {
                    $('#get_content').empty().html(data).show(3000);
                }
            });
        }
    });

</script>


@endsection
