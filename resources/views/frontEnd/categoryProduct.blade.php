@extends('frontEnd.master')
@section('title','Category Product')
@section('content')
<main class="main">
	<div style="margin-right: 30px;margin-left: 30px;" class="category-banner-container bg-gray">
		<div style="border: 2px solid red;" class="home-slider owl-carousel owl-theme owl-carousel-lazy" data-owl-options="{
		'dots': false,
		'nav': true,
		'loop': true,
		'autoplay' : true,
		'autoplayTimeout':3000,
		'autoplayHoverPause':true,
		'autoplaySpeed':5000  
	}">

	@foreach($slider as $value)
	<div class="home-slide home-slide2 banner banner-md-vw banner-sm-vw">
		<img class="owl-lazy slide-bg" src="{{ URL::to('public/images/categorySlider/'.$value->slider_image)}}" data-src="{{ URL::to('public/images/categorySlider/'.$value->slider_image)}}" alt="slider image">
	</div>
	@endforeach


</div>
</div>


<div style="background-color: #f1ebeb;margin-top: 10px;margin-right: 30px;margin-left: 30px;">
<div class="container " >
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<ol class="breadcrumb">
			<li class=""><a href="index.html"></a></li>
			<li class=""><a href="#"></a></li>
			<li class="" aria-current="page"></li>
		</ol>
	</nav>

	<nav class="toolbox">
		<div class="toolbox-left">
			<div class="toolbox-item toolbox-sort">
				<label>Sort By:</label>

				<div class="select-custom">
					<select name="orderby" class="form-control">
						<option value="menu_order" selected="selected">Default sorting</option>
						<option value="popularity">Sort by popularity</option>
						<option value="rating">Sort by average rating</option>
						<option value="date">Sort by newness</option>
						<option value="price">Sort by price: low to high</option>
						<option value="price-desc">Sort by price: high to low</option>
					</select>
				</div><!-- End .select-custom -->
			</div><!-- End .toolbox-item -->
		</div><!-- End .toolbox-left -->

		<div class="toolbox-right">
			<div class="toolbox-item toolbox-show">
				<label>Show:</label>

				<div class="select-custom">
					<select name="count" class="form-control">
						<option value="12">12</option>
						<option value="24">24</option>
						<option value="36">36</option>
					</select>
				</div><!-- End .select-custom -->
			</div><!-- End .toolbox-item -->

			<div class="toolbox-item layout-modes">
				<a href="category.html" class="layout-btn btn-grid active" title="Grid">
					<i class="icon-mode-grid"></i>
				</a>
				<a href="category-list.html" class="layout-btn btn-list" title="List">
					<i class="icon-mode-list"></i>
				</a>
			</div><!-- End .layout-modes -->
		</div><!-- End .toolbox-right -->
	</nav>

	<div class="row row-xl-tight">
		@foreach ($feature_product as $fpvalue)
		<div class="col-6 col-sm-4 col-md-3 col-xl-7col">
			<div class="product-default inner-quickview inner-icon">
				<figure>
					<a href="{{ URL::to('product/'.$fpvalue->slug)}}">
						<?php $image_explode = explode("#", $fpvalue->products_image); ?>
						<img src="{{ URL::to('public/images/'.$image_explode[0])}}">
					</a>
					<a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View">Quick View</a> 
				</figure>

				<div class="product-details">
					<div class="category-wrap">
						<div class="category-list">
							<a href="category.html" class="product-category">category</a>
						</div>
						<a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>
					</div>
					<h3 class="product-title">
						<a href="{{ URL::to('product/'.$fpvalue->slug)}}">{{Str::limit($fpvalue->product_name,10)}}</a>
					</h3>
											<?php if ($fpvalue->price_type == 3): ?>
							<div class="price-box">
								<span class="product-price"><small style="font-size: 15px; color: #777;">Price: &nbsp;&nbsp;&nbsp;</small> Negotiate</span>
							</div>
							<?php elseif ($fpvalue->price_type == 2): ?>
								<?php 
								$price_info = DB::table('tbl_product_price')
								->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
								->select('tbl_product_price.*', 'tbl_currency_status.symbol')
								->where('tbl_product_price.product_id', $fpvalue->id)
								->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
								->where('tbl_product_price.status', 1)
								->first() ;
								?>
								<div class="price-box">
									<span class="product-price"><?php echo $price_info->symbol ; ?> <?php echo $price_info->product_price; ?></span>
								</div>
								<?php else: ?>
									<div class="price-box">
									<?php 
										$product_price_count = DB::table('tbl_product_price')
											->where('product_id', $fpvalue->id)
											->where('supplier_id', $fpvalue->supplier_id)
											->where('price_status', 2)
											->where('status', 1)
											->count() ;
									?>
									<?php if($product_price_count > 0): ?>
										<?php 
											$price_value = DB::table('tbl_product_price')
												->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
												->select('tbl_product_price.*', 'tbl_currency_status.symbol')
												->where('tbl_product_price.product_id', $fpvalue->id)
												->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
												->where('tbl_product_price.status', 1)
												->where('tbl_product_price.price_status', 2)
												->first() ;
										 ?>

									<?php if($price_value->discount > 0): ?>
										<span class="old-price"><?php echo $price_value->symbol ; ?> <?php echo $price_value->product_price ; ?></span>
									<?php endif ?>
									<span class="product-price"><?php echo $price_value->symbol ; ?> 
									<?php 
										if ($price_value->discount_type == 1) {
										 	echo $price_value->product_price - $price_value->discount ;
										}else{
										 	$total_disocunt = $price_value->product_price * $price_value->discount / 100 ;
										 	echo $price_value->product_price - $total_disocunt ;
										}
									?>
									</span>
								<?php endif ?>
									</div>
								<?php endif ; ?>
				</div><!-- End .product-details -->

			</div>
		</div><!-- End .col-xl-7col -->
		@endforeach

		@foreach ($feature_product as $fpvalue)
		<div class="col-6 col-sm-4 col-md-3 col-xl-7col">
			<div class="product-default inner-quickview inner-icon">
				<figure>
					<a href="{{ URL::to('product/'.$fpvalue->slug)}}">
						<?php $image_explode = explode("#", $fpvalue->products_image); ?>
						<img src="{{ URL::to('/public/images/'.$image_explode[0])}}">
					</a>
					<a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View">Quick View</a> 
				</figure>

				<div class="product-details">
					<div class="category-wrap">
						<div class="category-list">
							<a href="category.html" class="product-category">category</a>
						</div>
						<a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>
					</div>
					<h3 class="product-title">
						<a href="{{ URL::to('product/'.$fpvalue->slug)}}">{{Str::limit($fpvalue->product_name,10)}}</a>
					</h3>
											<?php if ($fpvalue->price_type == 3): ?>
							<div class="price-box">
								<span class="product-price"><small style="font-size: 15px; color: #777;">Price: &nbsp;&nbsp;&nbsp;</small> Negotiate</span>
							</div>
							<?php elseif ($fpvalue->price_type == 2): ?>
								<?php 
								$price_info = DB::table('tbl_product_price')
								->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
								->select('tbl_product_price.*', 'tbl_currency_status.symbol')
								->where('tbl_product_price.product_id', $fpvalue->id)
								->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
								->where('tbl_product_price.status', 1)
								->first() ;
								?>
								<div class="price-box">
									<span class="product-price"><?php echo $price_info->symbol ; ?> <?php echo $price_info->product_price; ?></span>
								</div>
								<?php else: ?>
									<div class="price-box">
									<?php 
										$product_price_count = DB::table('tbl_product_price')
											->where('product_id', $fpvalue->id)
											->where('supplier_id', $fpvalue->supplier_id)
											->where('price_status', 2)
											->where('status', 1)
											->count() ;
									?>
									<?php if($product_price_count > 0): ?>
										<?php 
											$price_value = DB::table('tbl_product_price')
												->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
												->select('tbl_product_price.*', 'tbl_currency_status.symbol')
												->where('tbl_product_price.product_id', $fpvalue->id)
												->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
												->where('tbl_product_price.status', 1)
												->where('tbl_product_price.price_status', 2)
												->first() ;
										 ?>

									<?php if($price_value->discount > 0): ?>
										<span class="old-price"><?php echo $price_value->symbol ; ?> <?php echo $price_value->product_price ; ?></span>
									<?php endif ?>
									<span class="product-price"><?php echo $price_value->symbol ; ?> 
									<?php 
										if ($price_value->discount_type == 1) {
										 	echo $price_value->product_price - $price_value->discount ;
										}else{
										 	$total_disocunt = $price_value->product_price * $price_value->discount / 100 ;
										 	echo $price_value->product_price - $total_disocunt ;
										}
									?>
									</span>
								<?php endif ?>
									</div>
								<?php endif ; ?>
				</div><!-- End .product-details -->

			</div>
		</div><!-- End .col-xl-7col -->
		@endforeach

		@foreach ($feature_product as $fpvalue)
		<div class="col-6 col-sm-4 col-md-3 col-xl-7col">
			<div class="product-default inner-quickview inner-icon">
				<figure>
					<a href="{{ URL::to('product/'.$fpvalue->slug)}}">
						<?php $image_explode = explode("#", $fpvalue->products_image); ?>
						<img src="{{ URL::to('/public/images/'.$image_explode[0])}}">
					</a>
					<a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View">Quick View</a> 
				</figure>

				<div class="product-details">
					<div class="category-wrap">
						<div class="category-list">
							<a href="category.html" class="product-category">category</a>
						</div>
						<a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>
					</div>
					<h3 class="product-title">
						<a href="{{ URL::to('product/'.$fpvalue->slug)}}">{{Str::limit($fpvalue->product_name,10)}}</a>
					</h3>
											<?php if ($fpvalue->price_type == 3): ?>
							<div class="price-box">
								<span class="product-price"><small style="font-size: 15px; color: #777;">Price: &nbsp;&nbsp;&nbsp;</small> Negotiate</span>
							</div>
							<?php elseif ($fpvalue->price_type == 2): ?>
								<?php 
								$price_info = DB::table('tbl_product_price')
								->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
								->select('tbl_product_price.*', 'tbl_currency_status.symbol')
								->where('tbl_product_price.product_id', $fpvalue->id)
								->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
								->where('tbl_product_price.status', 1)
								->first() ;
								?>
								<div class="price-box">
									<span class="product-price"><?php echo $price_info->symbol ; ?> <?php echo $price_info->product_price; ?></span>
								</div>
								<?php else: ?>
									<div class="price-box">
									<?php 
										$product_price_count = DB::table('tbl_product_price')
											->where('product_id', $fpvalue->id)
											->where('supplier_id', $fpvalue->supplier_id)
											->where('price_status', 2)
											->where('status', 1)
											->count() ;
									?>
									<?php if($product_price_count > 0): ?>
										<?php 
											$price_value = DB::table('tbl_product_price')
												->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
												->select('tbl_product_price.*', 'tbl_currency_status.symbol')
												->where('tbl_product_price.product_id', $fpvalue->id)
												->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
												->where('tbl_product_price.status', 1)
												->where('tbl_product_price.price_status', 2)
												->first() ;
										 ?>

									<?php if($price_value->discount > 0): ?>
										<span class="old-price"><?php echo $price_value->symbol ; ?> <?php echo $price_value->product_price ; ?></span>
									<?php endif ?>
									<span class="product-price"><?php echo $price_value->symbol ; ?> 
									<?php 
										if ($price_value->discount_type == 1) {
										 	echo $price_value->product_price - $price_value->discount ;
										}else{
										 	$total_disocunt = $price_value->product_price * $price_value->discount / 100 ;
										 	echo $price_value->product_price - $total_disocunt ;
										}
									?>
									</span>
								<?php endif ?>
									</div>
								<?php endif ; ?>
				</div><!-- End .product-details -->

			</div>
		</div><!-- End .col-xl-7col -->
		@endforeach

		@foreach ($feature_product as $fpvalue)
		<div class="col-6 col-sm-4 col-md-3 col-xl-7col">
			<div class="product-default inner-quickview inner-icon">
				<figure>
					<a href="{{ URL::to('product/'.$fpvalue->slug)}}">
						<?php $image_explode = explode("#", $fpvalue->products_image); ?>
						<img src="{{ URL::to('/public/images/'.$image_explode[0])}}">
					</a>
					<a href="ajax/product-quick-view.html" class="btn-quickview" title="Quick View">Quick View</a> 
				</figure>

				<div class="product-details">
					<div class="category-wrap">
						<div class="category-list">
							<a href="category.html" class="product-category">category</a>
						</div>
						<a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>
					</div>
					<h3 class="product-title">
						<a href="{{ URL::to('product/'.$fpvalue->slug)}}">{{Str::limit($fpvalue->product_name,10)}}</a>
					</h3>
											<?php if ($fpvalue->price_type == 3): ?>
							<div class="price-box">
								<span class="product-price"><small style="font-size: 15px; color: #777;">Price: &nbsp;&nbsp;&nbsp;</small> Negotiate</span>
							</div>
							<?php elseif ($fpvalue->price_type == 2): ?>
								<?php 
								$price_info = DB::table('tbl_product_price')
								->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
								->select('tbl_product_price.*', 'tbl_currency_status.symbol')
								->where('tbl_product_price.product_id', $fpvalue->id)
								->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
								->where('tbl_product_price.status', 1)
								->first() ;
								?>
								<div class="price-box">
									<span class="product-price"><?php echo $price_info->symbol ; ?> <?php echo $price_info->product_price; ?></span>
								</div>
								<?php else: ?>
									<div class="price-box">
									<?php 
										$product_price_count = DB::table('tbl_product_price')
											->where('product_id', $fpvalue->id)
											->where('supplier_id', $fpvalue->supplier_id)
											->where('price_status', 2)
											->where('status', 1)
											->count() ;
									?>
									<?php if($product_price_count > 0): ?>
										<?php 
											$price_value = DB::table('tbl_product_price')
												->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
												->select('tbl_product_price.*', 'tbl_currency_status.symbol')
												->where('tbl_product_price.product_id', $fpvalue->id)
												->where('tbl_product_price.supplier_id', $fpvalue->supplier_id)
												->where('tbl_product_price.status', 1)
												->where('tbl_product_price.price_status', 2)
												->first() ;
										 ?>

									<?php if($price_value->discount > 0): ?>
										<span class="old-price"><?php echo $price_value->symbol ; ?> <?php echo $price_value->product_price ; ?></span>
									<?php endif ?>
									<span class="product-price"><?php echo $price_value->symbol ; ?> 
									<?php 
										if ($price_value->discount_type == 1) {
										 	echo $price_value->product_price - $price_value->discount ;
										}else{
										 	$total_disocunt = $price_value->product_price * $price_value->discount / 100 ;
										 	echo $price_value->product_price - $total_disocunt ;
										}
									?>
									</span>
								<?php endif ?>
									</div>
								<?php endif ; ?>
				</div><!-- End .product-details -->

			</div>
		</div><!-- End .col-xl-7col -->
		@endforeach

	</div><!-- End .row -->

	<nav class="toolbox toolbox-pagination">
		<ul class="pagination toolbox-item">
			<li class="page-item disabled">
				<a class="page-link page-link-btn" href="#"><i class="icon-angle-left"></i></a>
			</li>
			<li class="page-item active">
				<a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
			</li>
			<li class="page-item"><a class="page-link" href="#">2</a></li>
			<li class="page-item"><a class="page-link" href="#">3</a></li>
			<li class="page-item"><a class="page-link" href="#">4</a></li>
			<li class="page-item"><a class="page-link" href="#">5</a></li>
			<li class="page-item"><span class="page-link">...</span></li>
			<li class="page-item">
				<a class="page-link page-link-btn" href="#"><i class="icon-angle-right"></i></a>
			</li>
		</ul>
	</nav>
</div>
</div>

</main>
@endsection