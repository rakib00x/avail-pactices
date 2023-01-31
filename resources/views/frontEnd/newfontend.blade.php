@extends('frontEnd.master')
@section('title','Home')
<?php
    $meta_info 	= DB::table('tbl_meta_tags')->first();
	$settings 	= DB::table('tbl_logo_settings')->where('status', 1)->first();
?>
@section('css')
  <style>
     .colordd{
   background-color: #FFF;
  }
  </style>
@endsection
@section('meta_info')

    <meta name="title" content="{{ $meta_info->meta_title }}">
    <meta name="description" content="{{ $meta_info->meta_details }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $meta_info->meta_title }}">
    <meta property="og:description" content="{{ $meta_info->meta_details }}">
    <meta property="og:image" content="{{ URL::to('public/images/'.$settings->logo) }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $meta_info->meta_title }}">
    <meta property="twitter:description" content="{{ $meta_info->meta_details }}">
    <meta property="twitter:image" content="{{ URL::to('public/images/'.$settings->logo) }}">

@endsection


@section('content')
	<div class="container mt-5 " style="background-color: #FFF;">
		<div class="columns is-gapless">
			<div class="column is-one-fifth pr-5">

                <!-- My Market -->
				<div class="sidebar-navbar" style="background-color: #FFF;">
					<h2 class="ml-2" style="border-bottom: 2px solid #f3f3f3; padding: 10px 0px; margin-bottom: 10px; margin-right: 15px;"><strong>MY MARKETS</strong></h2>

					<ul>

						@foreach($primarycategory as $value)
						<a href="{{ URL::to('category/'.$value->catgeory_slug) }}/heightolow" title="{{ $value->category_name }}" style="color:black ;">
							<li id="dropdown" class="evanyou">
								<img src="{{URL::to('public/images/mainCtegory/'.$value->category_icon)}}" alt="{{ $value->category_name }}"/> <span  style="line-height: 1.6 !important;"><?php $catname = $value->category_name; $strlen = strlen($catname); if($strlen == 24 || $strlen < 24){ echo $catname; }else{ echo substr($catname,0,24); } ?></span>
								<img src="{{ URL::to('public/images/right-arrow.png') }}" class="is-pulled-right" style="width: 10px !important; height: 10px; margin-top: 16px; margin-right: 20px;" alt="availtrade"/>
								<div class="sidebar-navbar-mega-dropdown" style="width:750px!important;">
									<div class="is-flex">
										<?php
											$secondaryCategory = DB::table('tbl_secondarycategory')
												->where('sidebar_active', 1)
												->orderBy('sidebar_decoration', 'asc')
												->where('status', 1)
												->where('type', 1)
												->where('primary_category_id', $value->id)
												->get();
										 ?>
										@foreach($secondaryCategory as $subcat)
											<div  class="categh">
												<a href="{{ URL::to('seccategory/'.$subcat->secondary_category_slug.'/heightolow') }}" title="" target="_blank" style="color:black;" rel="noopener"><p><strong>{{$subcat->secondary_category_name}}</strong></p></a>
												<ul>
													<?php
														$tartiarycategory =  DB::table('tbl_tartiarycategory')
															->where('primary_category_id', $value->id)
															->where('secondary_category_id', $subcat->id)
															->orderBy('sidebar_decoration', 'asc')
															->where('status', 1)
															->where('sidebar_active', 1)
															->limit(6)
															->get() ;
													?>
													@foreach($tartiarycategory as $tarcat)
														<li><a href="{{ URL::to('tercategory/'.$tarcat->tartiary_category_slug.'/heightolow') }}">{{$tarcat->tartiary_category_name}}</a></li>
													@endforeach
												</ul>
											</div>
										@endforeach
									</div>

									<div class="is-flex">
										<?php
											$secondaryCategory2 = DB::table('tbl_secondarycategory')
												->where('sidebar_active', 1)
												->orderBy('sidebar_decoration', 'asc')
												->where('status', 1)
												->where('type', 2)
												->where('primary_category_id', $value->id)
												->get() ;
										 ?>
										@foreach($secondaryCategory2 as $subcat2)
											<div class="categh">
												<a href="{{ URL::to('seccategory/'.$subcat2->secondary_category_slug.'/heightolow') }}" class="cclorr" title="" target="_blank"  rel="noopener"><p><strong>{{ $subcat2->secondary_category_name }}</strong></p></a>
												<ul>
													<?php
													$tartiarycategory2 =  DB::table('tbl_tartiarycategory')
															->where('primary_category_id', $value->id)
															->where('secondary_category_id', $subcat2->id)
															->orderBy('sidebar_decoration', 'asc')
															->where('status', 1)
															->where('sidebar_active', 1)
															->limit(6)
															->get() ;
													?>
													@foreach($tartiarycategory2 as $tarcat2)
														<li><a href="{{ URL::to('tercategory/'.$tarcat2->tartiary_category_slug.'/heightolow') }}" target="_blank" rel="noopener">{{ $tarcat2->tartiary_category_name }}</a></li>
													@endforeach
												</ul>
											</div>
										@endforeach
									</div>
								</div>
							</li>
						</a>
						@endforeach
						<li>
							<a href="{{URL::to('/all-categories')}}" style="color:black;" title="All Categories"><img src="{{ URL::to('public/images/Image 15.png') }}" alt="availtrade-category"/> All Categories</a>
						</li>
					</ul>
				</div>
			</div>

            <!-- Slider -->
			<div class="column is-two-quarters m-4">
                <div id="main-inner">
					<div id="slider">
                        @foreach($slider as $value)
                            <img src="{{ URL::to('public/images/homeSlider/'.$value->slider_image)}}" style="min-height: 423px!important;max-height: 423px!important;" alt="availtrade" />
                        @endforeach
                    </div>
                </div>
			</div>

			<div class="column is-one-fifth m-4">
				<div >
					<div style="background-color: #371777; padding: 10px; color: #FFF; text-align: center; font-size: 20px;">
						Everything in one place
					</div>
					<?php

						$random_first_category = DB::table('tbl_primarycategory')
							->join('tbl_product', 'tbl_product.w_category_id', '=', 'tbl_primarycategory.id')
							->select('tbl_primarycategory.*', 'tbl_product.product_name')
							->inRandomOrder()
							->limit(1)
							->where('tbl_primarycategory.status', 1)
							->first() ;
					 ?>
					 <?php if ($random_first_category): ?>
							<?php
								$three_product_first = DB::table('tbl_product')
									->join('express', 'tbl_product.supplier_id', '=', 'express.id')
									->leftJoin('tbl_secondarycategory', 'tbl_product.w_secondary_category_id', '=', 'tbl_secondarycategory.id')
									->select('tbl_product.*','express.storeName', 'tbl_secondarycategory.secondary_category_slug')
									->where('tbl_product.w_category_id', $random_first_category->id)
									->inRandomOrder()
									->limit(3)
									->where('tbl_product.status', 1)
									->get() ;

								foreach ($three_product_first as $key => $threevalue):
							 ?>
							<div class="procatees">
								<p class="is-size-5"><?php echo Str::limit($threevalue->product_name,20); ?></p>
								<a href="{{ URL::to('seccategory/'.$threevalue->secondary_category_slug.'/heightolow') }}" class="button is-small is-info is-rounded mt-2" style="background-color: #371777;" title="availtrade" >Source now</a>
								<?php $first_image_explode_3 = explode("#", $threevalue->products_image); ?>
								<a href="{{ URL::to('seccategory/'.$threevalue->secondary_category_slug.'/heightolow') }}"><img src="{{ URL::to('public/images/'.$first_image_explode_3[0]) }}" class="is-pulled-right three-image" alt="{{ $threevalue->product_name }}" /></a>
							</div>
							<hr id="dfs" class="divider"/>
							<?php endforeach ?>

					 <?php endif ?>


				</div>
			</div>
		</div>
	</div>

    <!-- thik slider er porei je ongso -->
	<div class="container is-gapless mt-5">
		<div class="columns">

			<?php 
				$top_secondarycategory_info = DB::table('tbl_secondarycategory')
					->inRandomOrder()
					->limit(3)
					->where('status', 1)
					->get() ;

				$secondary_category_ids = array() ;
				foreach ($top_secondarycategory_info as $seccatvalue):
			?>
					<div class="column" >
						<div class="p-5" style="background-color: #FFF;">
							<h2><b>
								<?php
									echo $seccatvalue->secondary_category_name;
									$secondary_category_ids = $seccatvalue->id ;
								 ?>
							</b></h2>
							<div class="columns">
								<?php
									$first_category_product =  DB::table('tbl_product')
								        ->inRandomOrder()
								        ->where('status', 1)
								        ->take(3)
								        ->where('w_secondary_category_id', $seccatvalue->id)
								        ->get();
								    foreach($first_category_product as $firstCatPro):
								 ?>
									<a href="{{ URL::to('product/'.$firstCatPro->slug)}}" title="{{ $firstCatPro->product_name }}" class="four_ancor">
										<div class="column">
											<?php $first_image_explode = explode("#", $firstCatPro->products_image); ?>
											<img class="top_catgeory_image" src="{{ URL::to('public/images/'.$first_image_explode[0]) }}" alt="{{  $firstCatPro->product_name }}"/>
											<p class="has-text-centered"><b>

												<?php
												
												    $product_price_info = DB::table('tbl_product_price')
                                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                                        ->where('tbl_product_price.product_id', $firstCatPro->id)
                                                        ->orderBy('tbl_product_price.product_price', 'asc')
                                                        ->first() ;

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
                                                                    
												?>

											</b></p>
										</div>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
		</div>
		<div class="columns">
				<?php if (count($top_secondarycategory_info) == 3): ?>

					<?php 
					$top_secondarycategory_info2 = DB::table('tbl_secondarycategory')
						->inRandomOrder()
						->limit(3)
						->whereNotIn('id', [$secondary_category_ids])
						->where('status', 1)
						->get() ;
					foreach ($top_secondarycategory_info2 as $key => $topseccatgeory2):
					 ?>
					<div class="column" >
					<div class="p-5" style="background-color: #FFF;">
						<h2><b><?php
									echo $topseccatgeory2->secondary_category_name ;
								?></b></h2>
						<div class="columns">
							<?php
								$four_category_product =  DB::table('tbl_product')
							        ->inRandomOrder()
							        ->where('status', 1)
							        ->take(3)
							        ->where('w_secondary_category_id', $topseccatgeory2->id)
							        ->get();
							    foreach($four_category_product as $fourCatPro):
							?>
							<a href="{{ URL::to('product/'.$fourCatPro->slug)}}" title="{{ $fourCatPro->product_name }}" class="four_ancor">
								<div class="column">
									<?php $four_image_explode = explode("#", $fourCatPro->products_image); ?>
									<img class="top_catgeory_image" src="{{ URL::to('public/images/'.$four_image_explode[0]) }}" alt="{{ $fourCatPro->product_name }}" />
									<p class="has-text-centered"><b>
									    
									    <?php
												
										    $product_four_price_info = DB::table('tbl_product_price')
                                                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                                ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                                ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                                ->where('tbl_product_price.product_id', $fourCatPro->id)
                                                ->orderBy('tbl_product_price.product_price', 'asc')
                                                ->first() ;

											if($product_four_price_info->product_price > 0){
                                                if(Session::has('requestedCurrency')){
                                                    $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                    $product_price_convert = $product_four_price_info->product_price / $product_four_price_info->currency_rate;
                                                    $now_product_price_is = $product_price_convert * $main_currancy_status->rate ;
                                                    $currency_code = $main_currancy_status->symbol;
                                                }else{
                                                    $currency_code = $product_four_price_info->code;
                                                    $now_product_price_is = $product_four_price_info->product_price;
                                                }
                                                
                                                echo $currency_code." ".number_format($now_product_price_is, 2);
                                            }else{
                                                echo ucwords($product_four_price_info->negotiate_price);
                                            }
                                                            
										?>
									    
									</b></p>
								</div>
							</a>
							<?php endforeach ?>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
			<?php endif ?>
		</div>
		<!-- Start of Fetching Secondary Categories Products Here -->
{{--	<div class="columns">

			<div class="column">
				<div class="p-5" style="background-color: #FFF;">
					<div class="columns">


						<?php 
							$tertiarycategoryresult = DB::table('tbl_tartiarycategory')
								->where('status', 1)
								->inRandomOrder()
								->limit(2)
								->get() ;
							foreach ($tertiarycategoryresult as $key => $tercategoryval):
						 ?>
						<div class="column">
							<div style="background-color: #f3f3f3; padding: 20px; margin-top: 20px;">
								<?php

									echo $tercategoryval->tartiary_category_name ;

								 ?>
								<p class="has-text-centered"><strong></strong></p>
								<div class="columns mt-2">
									<?php
										$secondary_category_product =  DB::table('tbl_product')
									        ->inRandomOrder()
									        ->where('status', 1)
									        ->take(3)
									        ->where('w_tertiary_categroy_id', $tercategoryval->id)
									        ->get();
									    foreach($secondary_category_product as $catproduct1): ?>
									<a href="{{ URL::to('product/'.$catproduct1->slug)}}" title="{{ $catproduct1->product_name }}" class="four_ancor">
										<div class="column">
											<?php $catproduct1img = explode("#", $catproduct1->products_image); ?>
											<img class="top_catgeory_image" src="{{ URL::to('public/images/'.$catproduct1img[0]) }}" alt="{{ $catproduct1->product_name }}" />
										</div>
									</a>
									<?php endforeach ?>
								</div>
							</div>
						</div>
						<?php endforeach ?>

					</div>

					<div class="columns">

						<?php 
							$tertiarycategoryresult2 = DB::table('tbl_tartiarycategory')
								->where('status', 1)
								->inRandomOrder()
								->limit(2)
								->get() ;
							foreach ($tertiarycategoryresult2 as $key => $tercategoryval2):
						?>
						<div class="column">
							<div style="background-color: #f3f3f3; padding: 20px; margin-top: 20px;">
								<?php

									echo $tercategoryval2->tartiary_category_name ;

								 ?>
								<p class="has-text-centered"><strong></strong></p>
								<div class="columns mt-2">
									<?php
										$secondary_category_product_3 =  DB::table('tbl_product')
									        ->inRandomOrder()
									        ->where('status', 1)
									        ->take(3)
									        ->where('w_tertiary_categroy_id', $tercategoryval2->id)
									        ->get();
									    foreach($secondary_category_product_3 as $catproduct3): ?>
									<a href="{{ URL::to('product/'.$catproduct3->slug)}}" title="{{ $catproduct3->product_name }}" class="four_ancor">
										<div class="column">
											<?php $catproduct3img = explode("#", $catproduct3->products_image); ?>
											<img class="top_catgeory_image" src="{{ URL::to('public/images/'.$catproduct3img[0]) }}" alt="{{ $catproduct3->product_name }}" />
										</div>
									</a>
									<?php endforeach ?>
								</div>
							</div>
						</div>
						<?php endforeach ?>


					</div>
				</div>
			</div>

			<div class="column">

				<div class="p-5" style="background-color: #FFF;">
					<div class="columns">
						<?php 

							$tertiarycategoryresult3 = DB::table('tbl_tartiarycategory')
								->where('status', 1)
								->inRandomOrder()
								->limit(2)
								->get() ;
							foreach ($tertiarycategoryresult3 as $key => $tercategoryval3):
						?>

						<div class="column">
							<div style="background-color: #f3f3f3; padding: 20px; margin-top: 20px;">
								<?php

									echo $tercategoryval3->tartiary_category_name ;

								 ?>
								<p class="has-text-centered"><strong></strong></p>
								<div class="columns mt-2">
									<?php
										$secondary_category_product_5 =  DB::table('tbl_product')
									        ->inRandomOrder()
									        ->where('status', 1)
									        ->take(3)
									        ->where('w_tertiary_categroy_id', $tercategoryval3->id)
									        ->get();
									    foreach($secondary_category_product_5 as $catproduct5): ?>
									<a href="{{ URL::to('product/'.$catproduct5->slug)}}" title="{{ $catproduct5->product_name }}" class="four_ancor">
										<div class="column">
											<?php $catproduct5img = explode("#", $catproduct5->products_image); ?>
											<img class="top_catgeory_image" src="{{ URL::to('public/images/'.$catproduct5img[0]) }}" alt="{{$catproduct5->product_name}}" />
										</div>
									</a>
									<?php endforeach ?>
								</div>
							</div>
						</div>
						<?php endforeach ?>

					</div>

					<div class="columns">

						<?php 

							$tertiarycategoryresult4 = DB::table('tbl_tartiarycategory')
								->where('status', 1)
								->inRandomOrder()
								->limit(2)
								->get() ;
							foreach ($tertiarycategoryresult4 as $key => $tercategoryval4):
						?>
						<div class="column">
							<div style="background-color: #f3f3f3; padding: 20px; margin-top: 20px;">
								<?php
									echo $tercategoryval4->tartiary_category_name ;

								 ?>
								<p class="has-text-centered"><strong></strong></p>
								<div class="columns mt-2">
									<?php
										$secondary_category_product_7 =  DB::table('tbl_product')
									        ->inRandomOrder()
									        ->where('status', 1)
									        ->take(3)
									        ->where('w_tertiary_categroy_id', $tercategoryval4->id)
									        ->get();
									    foreach($secondary_category_product_7 as $catproduct7): ?>
									<a href="{{ URL::to('product/'.$catproduct7->slug)}}" title="{{ $catproduct7->product_name }}" class="four_ancor">
										<div class="column">
											<?php $catproduct7img = explode("#", $catproduct7->products_image); ?>
											<img class="top_catgeory_image" src="{{ URL::to('public/images/'.$catproduct7img[0]) }}" alt="{{ $catproduct7->product_name }}" />
										</div>
									</a>
									<?php endforeach ?>
								</div>
							</div>
						</div>
						<?php endforeach ?>

					</div>

				</div>
			</div>

		</div>--}}
		<!-- End of Fetching Secondary Categories Products Here -->
	</div>

    <div class="container mt-5">

        <?php foreach ($home_category_product as $key => $catvalue): ?>

            <div class="columns is-full">
                <div class="column is-one-fifth">
                    <p class="mt-2 is-size-5 mr-0 pr-0"><b>{{ $catvalue->h_category_name }}</b></p>
                </div>
                <div class="column is-three-quarters">
                    <p><hr style="background-color: #2ed915;height: 6px;"/></p>
                </div>
            </div>

            <div class="columns is-gapless is-full">

                @php
                    $product1_cat = DB::table('tbl_product')
                        ->where('w_category_id', $catvalue->category_id)
                        ->where('status', 1)
                        ->inRandomOrder()
                        ->limit(1)
                        ->first();
                @endphp

                <div class="column is-one-quarter">
                    <?php if($product1_cat): ?> 
                        <?php $product1_image2 = explode("#", $product1_cat->products_image); ?>
                          
                        <div style='padding: 17px; background-image: url("{{ URL::to('/public/images/'.$product1_image2[0])}}"); background-size: cover;  background-repeat: no-repeat;height:313px'>
                            <div style="display: inline-block; margin-top: 10px;">
                                <?php if($product1_cat): ?> 
                                <?php $product1_image = explode("#", $product1_cat->products_image); ?>
                                
                                    <a href="{{ URL::to('category/'.$catvalue->catgeory_slug) }}/heightolow" title="{{ $product1_cat->slug }}" class="button mt-5 is-pulled-left is-rounded">source now</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?> 
                        <div style="padding: 17px; background-color: <?php echo $catvalue->section_color_code; ?>; background-size: cover;  background-repeat: no-repeat;">
                            <div style="display: inline-block; margin-top: 10px;">
                                <?php if($product1_cat): ?> 
                                <?php $product1_image = explode("#", $product1_cat->products_image); ?>
                                    <a href="{{ URL::to('category/'.$catvalue->catgeory_slug) }}/heightolow" title="{{ $product1_cat->slug }}" class="button mt-5 is-pulled-left is-rounded" >source now</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>  
                </div>

                @php
                    $category_product = DB::table('tbl_product')
                        ->where('w_category_id', $catvalue->category_id)
                        ->where('status', 1)
                        ->inRandomOrder()
                        ->limit(8)
                        ->get();

                @endphp

                <div class="column is-auto mb-0 p-0">
                    <div class="clors">
                        <div class="columns is-gapless is-multiline" >

                            @foreach($category_product as $catproduct)

                            <div class="column is-one-quarter m-0 p-0">
                            	<a class="prodhf" href="{{ URL::to('product/'.$catproduct->slug)}}" title="{{ Str::limit($catproduct->product_name,20) }}">
                            		<div class="promaxs">
	                                    <p><strong>{{ Str::limit($catproduct->product_name,20) }}</strong></p>
	                                    <div class="columns">
	                                        <div  class="column">
	                                            <div class="content" style="width: 85px !important;">
	                                                <?php
                                                        echo substr(strip_tags($catproduct->product_description), 0, 14);
                                                    ?>
                                                   {{-- {!! strip_tags(Illuminate\Support\Str::limit($catproduct->product_description, 20))  !!} --}}
	                                            </div>
	                                        </div>
	                                        
	                                        <div class="column">
                                               <?php
                                                if (strpos($catproduct->products_image, '#') !== false) {
                                                    $category_product_image = explode("#", $catproduct->products_image);
                                                    $image_name = $category_product_image[0] ;
                                                }else{
                                                    $image_name = $catproduct->products_image;
                                                }
                                               ?>
                                               <img src="{{ URL::to('public/images/'.$image_name) }}" alt="{{ $catproduct->product_name }}" class="imagsds"  alt="availtrade-product"/>
                                            </div>
	                                        
	                                    </div>
	                                </div>
                            	</a>
                            </div>
                            @endforeach

                        </div>

                    </div>
                </div>

            </div>
        <?php endforeach ?>

    </div>

    <div class="container mt-5">

        <div class="columns is-full">
            <div class="column is-one-fifth">
                <p class="mt-2 is-size-5 mr-0 pr-0"><b>JUST FOR YOU</b></p>
            </div>
            <div class="column is-three-quarters">
                <p><hr class="divgs"/></p>
            </div>
        </div>

        <div class="columns">
            <div class="column mr-0 pr-0">
                <p class="padghs">

                    <?php
                    $just_for_you = DB::table('tbl_product')
                        ->inRandomOrder()
                        ->where('tbl_product.status', 1)
                        ->limit(15)
                        ->get() ;

                    foreach($just_for_you as $justvalue) :
                    $all_id[] = $justvalue->id ;
                    ?>

	                    <div style="background-color: #FFF; border: 2px solid #f3f3f3; float: left; margin-left: 7px;" class="box">
	                    	<a href="{{ URL::to('product/'.$justvalue->slug)}}" title="" style="color:black!important">
		                        <?php $justvalueimage = explode("#", $justvalue->products_image); ?>
		                        <img src="{{ URL::to('public/images/'.$justvalueimage[0]) }}" class="imagejust" style="width:225px; height:225px;" alt="{{ $justvalue->product_name }}" />
				                <p>{{ Str::limit($justvalue->product_name, 20) }}</p>
				                <p>
				                    
				                    <b><?php
				                        $product_price_info2 = DB::table('tbl_product_price')
                                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                            ->where('tbl_product_price.product_id', $justvalue->id)
                                            ->orderBy('tbl_product_price.product_price', 'asc')
                                            ->first() ;
    
    									if($product_price_info2->product_price > 0){
                                            if(Session::has('requestedCurrency')){
                                                $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                $product_price_convert2 = $product_price_info2->product_price / $product_price_info2->currency_rate;
                                                $now_product_price_is2 = $product_price_convert2 * $main_currancy_status2->rate ;
                                                $currency_code2 = $main_currancy_status2->symbol;
                                            }else{
                                                $currency_code2 = $product_price_info2->code;
                                                $now_product_price_is2 = $product_price_info2->product_price;
                                            }
                                            
                                            echo $currency_code2." ".number_format($now_product_price_is2, 2);
                                        }else{
                                            echo ucwords($product_price_info2->negotiate_price);
                                        }
				                    ?></b><br>
                                                    
				                    <!-- Price section -->
				                    @php

				                        $minimum_order = DB::table('tbl_product_price')
				                                    ->where('product_id', $justvalue->id)
				                                    ->orderBy('tbl_product_price.start_quantity', 'asc')
				                                    ->first() ;
				                    @endphp
				                   

				                    <?php if ($minimum_order->price_status == 1): ?>
				                    @php
				                        echo $minimum_order->start_quantity ;
				                    @endphp
				                    <?php else: ?>
				                    1
				                    <?php endif ?> {{ $product_price_info2->unit_name }} (Min. Order)
				                </p>
			                </a>
                            <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $justvalue->visitor_count }}</p>
			            </div>

            		<?php endforeach; ?>

                </p>
            </div>
        </div>

    </div>


    <div class="container mt-5">

        <div class="columns is-full">
            <div class="column is-two-fifths mr-0 pr-0">
                <p class="mt-2 is-size-5 mr-0 pr-0"><b>CHOOSE YOUR SUPPLIERS BY REGIONS</b></p>
            </div>
            <div class="column is-three-fifths">
                <p><hr style="background-color: #2ed915;height:6px;";/></p>
            </div>
        </div>

        <div class="columns">
            <div class="column mr-0 pr-0">

                <div class="flags">
                    <ul>
                        <?php
                        $country_info = DB::table('tbl_home_country')->first();
                        ?>
                        <?php if ($country_info): ?>

	                        <?php if($country_info->home_country_id != ""): ?>
	                        @php
	                            $home_country_id = explode(",", $country_info->home_country_id);
	                        @endphp
	                        <?php foreach ($home_country_id as $key => $countryValue): ?>
	                        <?php
	                        $country = DB::table('tbl_countries')->where('id', $countryValue)->first();

	                        ?>
	                        <li>
	                            <a href="{{ URL::to('country/'.strtolower($country->countryCode)) }}" style="margin-right: 1px!important;">
	                                <img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower($country->countryCode).'.png'; ?>" style="width:90px!important; height:75px!important;margin-right:2px!important;" alt="availtrade">
	                            </a>
	                        </li>
	                        <?php endforeach ?>
	                        <?php endif ; ?>
	                    <?php endif ?>


                    </ul>
                </div>

            </div>
        </div>

    </div>

    @endsection

    @section('css')
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/slider.css') }}">
    @endsection

    @section('js')
    <script src="{{ URL::to('public/frontEnd/assets/js/miniSlider.js') }}"></script>
    <script>
        $(function() {
            $('#slider').miniSlider();
        });
    </script>
    @endsection


