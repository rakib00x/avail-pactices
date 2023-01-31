@extends('frontEnd.master')
@section('title')
@foreach ($result as $cat)
{{ $cat->category_name }}
@endforeach
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/secondery.css') }}">
@endsection
@endsection
@section('content')

<main class="main">
	<div class="container mt-2">
		<div class="row">
			<div class="col-lg-3 mb-2" id="desktop_menu_s" >
				<div class="side-menu-wrapper" style="height: 463px;overflow-x: scroll;overflow-x: hidden!important;">
					<h2 class="side-menu-title"><?php echo $cat->secondary_category_name ; ?></h2><br>
					<ul class="menuk">
						@foreach($result as $subcat)
						<li>
							<div class="row">
								<div class="col-md-10 col-10">
									<a target="_blank" style="padding-left: 10px;" href="{{ URL::to('/secondaryCategory/'.$subcat->secondary_category_slug)}}"> {{ $subcat->secondary_category_name }}</a>
								</div>
								<?php 
									$tartiarycategory  = DB::table('tbl_tartiarycategory')
									->where('tbl_tartiarycategory.status', 1)
									->where('tbl_tartiarycategory.secondary_category_id', $subcat->id)
									->get();
								?>
								<?php if (count($tartiarycategory) > 0): ?>
									<div class="col-md-2 col-2">
									<i class="fa fa-angle-right float-right" style="padding-right: 7px;"></i>
								</div>
								<?php endif ?>
								

							</div>
							<?php if (count($tartiarycategory) > 0): ?>
							<div class="megadrop">
								<div class="row">
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-12 col-12"><br>
												<h5> <a href="#">&nbsp; {{$subcat->secondary_category_name}} </a></h5>
												@foreach($tartiarycategory as $tarcat)
												<ul>
													<li style="font-size:15px;margin-left:7px;padding: 3px 0px;"><a href="#">&nbsp;{{$tarcat->tartiary_category_name }}</a>
													</li>
												</ul>
												@endforeach
											</div>
										</div>		
									</div>
								</div>
							</div>
						<?php endif ?>
						</li>
						@endforeach
					</ul>

				</div>
			</div>
			<div class="col-lg-9 mb-2 col-12">
				<div id="categorySliderControl" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner">
						@foreach($slider as $key=>$value)
						<div class="carousel-item <?php if($key == 0){echo "active"; } ?>">
							<img class="d-block w-100 slider_image" src="{{ URL::to('public/images/'.$value->slider_image)}}" alt="First slide">
						</div>
						@endforeach
					</div>
					<a class="carousel-control-prev" href="#categorySliderControl" role="button" data-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="sr-only">Previous</span>
					</a>
					<a class="carousel-control-next" href="#categorySliderControl" role="button" data-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>

				<div class="row mt-1 pb-1">
				@foreach($icon_result as $subcati)
				<div class="col-lg-2 col-3">
					<a href="{{ URL::to('/secondaryCategory/'.$subcati->secondary_category_slug)}}"><img src="{{ URL::to('public/images/'.$subcati->secondary_category_icon)}}" class="img-fluid img-thumbnail m-1 category_icon"></a>
				</div>
				@endforeach

			</div>
		
		</div>
		
	</div>
</div>
</div>


<div class="products-section section-bg-gray">
	<div class="container">
		<h2 class="section-title">Featured Products</h2>
		<div class="products-slider owl-carousel owl-theme dots-top">

			<?php foreach ($feature_product as $fpvalue) { ?>

				<div class="product-default inner-quickview inner-icon">

					<figure>
						<a target="_blank" href="{{ URL::to('product/'.$fpvalue->slug)}}">
							<?php $image_explode = explode("#", $fpvalue->products_image); ?>
							<img src="{{ URL::to('public/images/'.$image_explode[0])}}" height="150" width="150">
						</a>

						@if ($fpvalue->price_type == "2")
							<div class="label-group">
								@php
								date_default_timezone_set('Asia/Dhaka') ;
								$today_date = date("Y-m-d H:i:s") ;

								$discount_count_2 = DB::table('tbl_product')
									->where('offer_start', '<=', $today_date)
									->where('offer_end', '>=', $today_date)
									->where('id', $fpvalue->id)
									->count() ;
									
								if($discount_count_2 > 0):
								@endphp
									@php
										$price_info_discount = DB::table('tbl_product_price')
										->where('product_id', $fpvalue->id)
										->where('supplier_id', $fpvalue->supplier_id)
										->first() ;
									@endphp
									<div class="product-label label-sale"> 
										@php
										if ($price_info_discount->discount_type == 1) {
											echo $price_info_discount->discount." Flat ";
										}else{
											echo $price_info_discount->discount."%"; 
										}
										
									@endphp Off</div>
								@php
								endif ;
								@endphp
								
							</div>
						@endif
						

						<div class="btn-icon-group">
							<button class="btn-icon btn-add-cart" data-toggle="modal" data-target="#addCartModal"><i class="icon-shopping-cart"></i></button>
						</div>
					</figure>
					<div class="product-details">
						<h3 class="product-title">
							<a href="{{ URL::to('product/'.$fpvalue->slug)}}"><?php echo $fpvalue->product_name; ?></a>
						</h3>

	
						<div class="price-box">

							@if ($fpvalue->price_type == "4" || $fpvalue->price_type == "1")

									@php
										$product_price_section_2 = DB::table('tbl_product_price')
										->where('product_id', $fpvalue->id)
										->where('supplier_id', $fpvalue->supplier_id)
										->where('status', 1)
										->count() ;
									@endphp
									<?php if($product_price_section_2 > 0): ?>
										<span class="product-price">
											@php
												$small_price_1 = DB::table('tbl_product_price')
													->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
													->select('tbl_product_price.*', 'tbl_currency_status.symbol', 'tbl_currency_status.rate')
													->where('tbl_product_price.product_id', $fpvalue->id)
													->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
													->where('tbl_product_price.status', 1)
													->orderBy('product_price','asc')
													->first();

												$bigger_price_2 = DB::table('tbl_product_price')
													->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
													->select('tbl_product_price.*', 'tbl_currency_status.symbol', 'tbl_currency_status.rate')
													->where('tbl_product_price.product_id', $fpvalue->id)
													->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
													->where('tbl_product_price.status', 1)
													->orderBy('product_price','desc')
													->first();
											@endphp
											<?php
												$recent_rate 		= $bigger_price_2->rate;
												$requestedCurrency 	= Session::get('requestedCurrency');

												if($requestedCurrency == NULL){
													echo $bigger_price_2->symbol;
													echo $small_price_1->product_price;
												}else{
													$currencyQuery = DB::table('tbl_currency_status')->where('id',$requestedCurrency)->first();
													$requestedCurrencyRate = $currencyQuery->rate;
													$requestedCurrencySymbol = $currencyQuery->symbol;
													$first_price_convert = ($small_price_1->product_price/$recent_rate);
													$second_price_convert = ($bigger_price_2->product_price/$recent_rate);
													echo $requestedCurrencySymbol."".number_format($first_price_convert*$requestedCurrencyRate,2)."-".number_format($second_price_convert*$requestedCurrencyRate,2);
												}
											?>
										</span>
									<?php endif ?>
								@else
									@php
										$product_price_section2 = DB::table('tbl_product_price')
										->where('product_id', $fpvalue->id)
										->where('supplier_id', $fpvalue->supplier_id)
										->where('status', 1)
										->count() ;
									@endphp
									<?php if($product_price_section2 > 0): ?>
										<?php
											$price_value2 = DB::table('tbl_product_price')
											->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
											->select('tbl_product_price.*', 'tbl_currency_status.symbol', 'tbl_currency_status.rate')
											->where('tbl_product_price.product_id', $fpvalue->id)
											->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
											->where('tbl_product_price.status', 1)
											->where('tbl_product_price.price_status', 2)
											->first() ;
										?>

										@php
										date_default_timezone_set('Asia/Dhaka') ;
										$today_date = date("Y-m-d H:i:s") ;

										$discount_count_2 = DB::table('tbl_product')
											->where('offer_start', '<=', $today_date)
											->where('offer_end', '>=', $today_date)
											->where('id', $fpvalue->id)
											->count() ;

										if($discount_count_2 > 0):
										@endphp
										<?php if($price_value2->discount > 0): ?>
											<span class="old-price"><?php echo $price_value2->symbol ; ?>
												<?php echo $price_value2->product_price; ?>
											</span>
										<?php endif ?>
										@php
										endif ;
										@endphp


										<span class="product-price"><?php //echo $price_value->symbol; ?>
										<?php
											if($discount_count_2 > 0){
												if ($price_value2->discount_type == 1) {
													$final_price = $price_value2->product_price - $price_value2->discount;
												}else{
													$total_disocunt = $price_value2->product_price * $price_value2->discount / 100 ;
													$final_price = $price_value2->product_price - $total_disocunt;

												}
											}else{
												$final_price = $price_value2->product_price;
											}

											$recent_price = $price_value2->product_price;
											$recent_rate = $price_value2->rate;
											$requestedCurrency = Session::get('requestedCurrency');

											if($requestedCurrency == NULL){
												echo $price_value2->symbol;
												echo $final_price;
											}else{
												$currencyQuery = DB::table('tbl_currency_status')->where('id',$requestedCurrency)->first();
												$requestedCurrencyRate = $currencyQuery->rate;
												$requestedCurrencySymbol = $currencyQuery->symbol;
												$dollar = ($final_price/$recent_rate);
												echo $requestedCurrencySymbol."".number_format($dollar*$requestedCurrencyRate,2);
											}
										?>
										</span>
									<?php endif ?>
								@endif


						</div>

							
					</div>
				</div>
				
			<?php } ?>

		</div>
	</div>
</div>


<div class="grid-col-sizer w-25"></div>
</div><!-- End .banners-grid -->
</div><!-- End .container -->

<div class="products-section section-bg-white">
	<div class="container">

		<h2 class="section-title"><?php echo $cat->category_name; ?></h2>
		<div class="row" id="load_data">


		</div>	
		<input type="hidden" name="category_slug" class="category_slug" value="<?php echo $cat->catgeory_slug; ?>">
		<div class="row">
			
			<div id="load_data_message" class="mb-3 col-md-12">
    
  			</div>
		</div>

	</div>

	<div class="grid-col-sizer w-25"></div>
</div><!-- End .banners-grid -->
</div><!-- End .container -->

</main><!-- End .main -->
@endsection

@section('mobile_menu')
<div class="mobile-menu-container">
	<div class="mobile-menu-wrapper">
		<span class="mobile-menu-close"><i class="icon-cancel"></i></span>
		<nav class="mobile-nav">
			<ul class="mobile-menu mb-3">
				<li class="active"><a href="{{ URL::to('') }}">Home</a></li>
				@foreach($result as $value)
				<li>
					<a href="{{ URL::to('secondaryCategory/'.$value->secondary_category_slug)}}">{{$value->secondary_category_name}}</a>
					<?php 
						$all_tertirary = DB::table('tbl_tartiarycategory')->where('secondary_category_id', $value->id)->get();
					 ?>
					<?php if (count($all_tertirary) > 0): ?>
						<ul>
							<?php foreach ($all_tertirary as $ctvalue): ?>
								<li><a href="#">{{ $ctvalue->tartiary_category_name }}</a></li>
							<?php endforeach ?>
						</ul>
					<?php endif; ?>
				</li>
				@endforeach
		</nav><!-- End .mobile-nav -->

	</div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->
@endsection
@section('js')
<script>
  $(document).ready(function(){
  	
   var limit = 12;
   var start = 0;
   var action = 'inactive';

   function loadData(limit, start)
   {

	var category_slug = $(".category_slug").val() ;
   	$.ajaxSetup({
	    headers: {
	      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	 });

    $.ajax({
     url:"{{ url('/getMoreProduct') }}",
     method:"POST",
     data:{limit:limit, start:start, category_slug:category_slug},
     cache:false,
     success:function(data)
     {
      $('#load_data').append(data);
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
    if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
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