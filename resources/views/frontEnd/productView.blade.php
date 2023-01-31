@extends('frontEnd.promaster')
@section('title')
@foreach($ptitle as $title)
{{$title->product_name}}
@endforeach
@endsection

@section('meta_info')
<meta name="keywords" content="{{ $product->product_tags }}">
 <meta name="description" content="{{ $product->meta_description }}">
<meta name="google-site-verification" content="k0EeY83SLz-MJ7Qhk_rszBYI1Ip9xLZ1MG6R26DEvow" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<meta property="og:url" content="{{ url()->full() }}" />

<meta property="og:title" content="{{ $product->meta_title}} - Availtrade" />
<meta property="og:type" content="product" />
<?php $image_thubmnail 	= explode("#", $product->products_image); ?>
<meta property="og:image" content="{{ URL::to('public/images/'.$image_thubmnail[0]) }}"/>
<meta property="og:description" content="{{ $product->meta_description }}-Availtrade.com" />
<meta property="og:site_name" content="availtrade.com" />
<meta property="og:type" content="product">
 
    
@endsection

@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/products.css') }}">

@endsection

@section('content')
	<div class="wrapper-index">
		<div class="container" style="background: #fff;padding: 10px;">

			<div class="columns is-gapless" style="min-height: 715px;">

				<div class="column is-one-third mr-4">
					<div class="columns">
						<div class="column is-full" style="height: 450px">
							<?php $image_explode 	= explode("#", $product->products_image); ?>
							    <img class="xzoom5" width="470" height="450" src="{{ URL::to('public/images/'.$image_explode[0]) }}" xoriginal="{{ URL::to('public/images/'.$image_explode[0]) }}" class="first-slider" alt="{{ $product->product_name }}">
						</div>
					</div>
                    <div class="columns mt-5">
                        <div class="column is-full pt-5">
                            <center>
                                <p class="title is-6" style="color: #666666;"><i class="fas fa-search-plus"></i>
                                    <a class="fancybox" href="{{ URL::to('public/images/'.$image_explode[0]) }}" data-fancybox alt="{{ $product->product_name }}">
                                        View larger image
                                    </a>
                                </p>
                            </center>
                        </div>
                    </div>
					<div class="columns">
						<div class="column is-full">
							<div class="columns is-gapless">
								<?php foreach ($image_explode as $value_ss): ?>
									<div class="column">
										<img src="{{ URL::to('public/images/'.$value_ss) }}" class="is-64x64 p-0 m-0 img-border" alt="availtrade" style="width:73px;height:73px">
									</div>
								<?php endforeach ?>
							</div>
						</div>
					</div>

					<div class="columns" style="padding-left: 10px;">
					   <?php
                            $social_info =  Share::currentPage()
                            ->facebook('Extra linkedin summary can be passed here')
                            ->twitter('Extra linkedin summary can be passed here')
                            ->linkedin('Extra linkedin summary can be passed here')
                            ->telegram('Extra linkedin summary can be passed here')
                            ->whatsapp('Extra linkedin summary can be passed here') ;
                        ?>

                        {!! $social_info !!} 
                    </div>

				</div>

				<div class="column is-two-fifths mr-4" style="background: #fff;height: 200px;">

					<div class="columns is-gapless">
						<div class="column">
						    <div class="content">
						        <h1 style="font-size: 30px;margin-top:20px;">{{ $product->product_name }}</h1>
						    </div>
						</div>
					</div>
					<?php 
				        if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){
				            if(Session::get('supplier_id') != null){
				                $main_login_id = Session::get('supplier_id');
				            }else{
				                $main_login_id = Session::get('buyer_id');
				            }
				        }else{
				            $main_login_id = 0;
				        }
				    ?>
					
                    <?php
					    $product_price_info = DB::table('tbl_product_price')
                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                            ->where('tbl_product_price.product_id', $product->id)
                            ->orderBy('tbl_product_price.product_price', 'asc')
                            ->first() ;

                        if(Session::has('requestedCurrency')){
                            $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                            if($product_price_info->product_price > 0)
                            {
                                $product_price_convert  = $product_price_info->product_price / $product_price_info->currency_rate;
                                $now_product_price_is   = $product_price_convert * $main_currancy_status->rate ;
                            }else{
                               $now_product_price_is = $product_price_info->product_price ; 
                            }
                            
                            $currency_code = $main_currancy_status->symbol;
                        }else{
                            $currency_code          = $product_price_info->code;
                            $now_product_price_is   = $product_price_info->product_price;
                        }
                                        
					?>
					<?php
						$count = DB::table('tbl_product_price')
							->where('product_id', $product->id)
							->count() ;

						$unit = DB::table('tbl_unit_price')->where('id', $product->unit)->first() ;

						if ($count == 1): $color_image_price = 0; ?>
						<div class="columns is-gapless" style="border-bottom: 9px solid #2ed915;border-top: 9px solid #2ed915;padding: 15px;">
                
							<?php if ($product_price_info->product_price > 0): ?>
							
							    	@php
										date_default_timezone_set('Asia/Dhaka') ;
										$today_date = date("Y-m-d H:i:s") ;

										$discount_count = DB::table('tbl_product')
											->where('offer_start', '<=', $today_date)
                      						->where('offer_end', '>=', $today_date)
                      						->where('id', $product->id)
											->count() ;
										if($discount_count > 0):
												if($discount_count > 0){
        											if ($product_price_info->discount_type == 1) {
        												$final_price = $product_price_info->product_price - $product_price_info->discount;
        
        											}else{
        												$total_disocunt = $product_price_info->product_price * $product_price_info->discount / 100 ;
        												$final_price = $product_price_info->product_price - $total_disocunt;
        
        											}
        										}else{
        											$final_price = $product_price_info->product_price;
    										    }
    										    
    										    if(Session::has('requestedCurrency')){
                                                    $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                    if($product_price_info->product_price > 0)
                                                    {
                                                        $product_price_convert  = $final_price / $product_price_info->currency_rate;
                                                        $now_product_price_is_without_discount   = $product_price_convert * $main_currancy_status->rate ;
                                                    }else{
                                                       $now_product_price_is_without_discount = $product_price_info->product_price ; 
                                                    }
                                                    
                                                }else{
                                                    $now_product_price_is_without_discount   = $product_price_info->product_price;
                                                }
										else:
										    $now_product_price_is_without_discount = 0 ;
										endif ;
										

									@endphp
							
								<div class="column">
									<span><p style="font-weight: bold;font-family:'SolaimanLipi';font-size:30px;"><span style="font-size:20px;"><?php echo $currency_code; ?></span> <span style="color:#83badb;"> <?php if($discount_count > 0){echo number_format($now_product_price_is_without_discount,2); }else{echo number_format($now_product_price_is, 2); }  ?> <del><?php if($discount_count > 0){echo number_format($now_product_price_is, 2); } ?></del></span> <span style="font-size:20px;float:right;display:<?php if($product->qty==0){echo 'none';}else{ echo " ";}?>;">(  {{$product->qty}}  {{ $unit->unit_name  }} -Min Order )</span></p> <?php if($product->price_type == '2'): ?>
								@php
									if($discount_count > 0):
										@endphp
											<div id="countdowntimer"><span id="given_date"> </span></div>
										@php
									endif ;
								@endphp
							<?php endif; ?></span>
								</div>
							<?php else: ?>
								<div class="column">
									<span><p style="font-weight: bold;font-family:'SolaimanLipi';"><b>Negotiate</b></p></span>
								</div>
							<?php endif ?>

    					</div>
    					
    					<div class="column is-pulled-right">
    					    <button class="button is-primary" onclick="chatshowpage({{ $product->id }}, {{ $product->supplier_id }},<?php echo $main_login_id; ?>)" style="margin-top: -18px;">
                                <span class="icon">
                                  <i class="fas fa-sms"></i>
                                </span>
                                <span>Chat</span>
                              </button>
    					</div>
    					
    					<p style="color:#28a794;font-size:30px;"><?php if($product->cond==1){echo "NEW Product";}elseif($product->cond==2){echo "USED Product";}else{ echo " ";}?></p>
    					
					   
				     	
    					<br>
    					<?php else: ?>
    						<?php
    							$all_price = DB::table('tbl_product_price')
                                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                    ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                    ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                    ->leftjoin('tbl_product_size', 'tbl_product_price.size_id', '=', 'tbl_product_size.id')
								    ->leftjoin('tbl_product_color', 'tbl_product_price.color_id', '=', 'tbl_product_color.id')
								    ->leftjoin('tbl_size', 'tbl_product_size.size_id', '=', 'tbl_size.id')
                                    ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate', 'tbl_currency_status.symbol','tbl_size.size', 'tbl_product_size.size_id as main_size_id', 'tbl_product_color.color_image', 'tbl_product_color.color_code')
                                    ->where('tbl_product_price.product_id', $product->id)
    								->get() ;
    							
    							$color_image_price = 0;
    						?>
                            
    						<div class="columns is-multiline" style="border-bottom: 1px solid #bbb;border-top: 1px solid #bbb;padding: 5px;">
    						    <div class="column is-full">
            					    <button class="button is-primary is-pulled-right" onclick="chatshowpage({{ $product->id }}, {{ $product->supplier_id }},<?php echo $main_login_id; ?>)">
                                        <span class="icon">
                                          <i class="fas fa-sms"></i>
                                        </span>
                                        <span>Chat</span>
                                      </button>
            					</div>
        					    <br>
        					    
        					  
					
    							<?php foreach ($all_price as $key => $price_value_2): ?>
    							    <?php 
    							        $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                        $product_price_convert2 = $price_value_2->product_price / $price_value_2->currency_rate;
                                        $now_product_price_is2 = $product_price_convert2 * $main_currancy_status2->rate ;
                                        $currency_code2 = $main_currancy_status2->symbol;
    							    
    							    ?>
    								<div class="column is-half">
    								    <table>
        									<tr>
        										<td style="padding-right: 20px;">
        										        
        											<?php if($price_value_2->color_id != null): ?>
        											    
        												<?php $color_image_price = 1; if ($price_value_2->color_code != null): ?>
                    										<div class="form-check mb-0">
                                                              <input class="form-check-input" style="width: 30px;height: 30px;background-color:<?php echo $price_value_2->color_code; ?>;" id="colorRadio<?php echo $price_value_2->id; ?>" type="radio" name="colorRadio" value="<?php echo $price_value_2->color_code; ?>" onclick="changecolorstatus(<?php echo $price_value_2->id; ?>)">
                                                              <label class="form-check-label" for="colorRadio<?php echo $price_value_2->id; ?>"></label>
                                                            </div>
                    									<?php else: ?>
                    											<img src="{{ URL::to('public/images/'.$price_value_2->color_image)}}" alt="availtrade" class="img-border color_image color_image_s_<?php echo $price_value_2->id; ?>" style="width:32px;height: 39px;cursor: pointer;margin-left: 25px;margin-top: 22px" onclick="changecolorstatus(<?php echo $price_value_2->id; ?>)">
                    									<?php endif; ?>
        											<?php else: ?>
        											    <?php $color_image_price = 2; ?>
        												<input type="radio" name="size_id" id="size_id" value="<?php echo $price_value_2->main_size_id; ?>"> <labele>{{ $price_value_2->size }}</labele>
        											<?php endif; ?>
        											
        
        										</td>
        										<td>
        										    <?php if($price_value_2->price_status != 4): ?>
        										    {{ $price_value_2->start_quantity }} - {{ $price_value_2->end_quantity }} {{ $unit->unit_name  }}
        										    <br>
        										    <?php endif; ?>
        										    
        										    <span style="color: #f75952;font-weight:bold;font-family:'SolaimanLipi';">{{ $currency_code2 }} {{ number_format($now_product_price_is2, 2) }}</span>
        										</td>
        									</tr>

        								</table>
    								</div>
    							<?php endforeach ?>
    							

    						</div>
    					<?php endif; ?>

					
					<div class="columns">
						<div class="column"></div>
					</div>
					
					<?php $color_count = DB::table('tbl_product_color')->where('product_id', $product->id)->count() ;
					if ($color_count > 0 && $color_image_price != 1): ?>
						<div class="columns">
							<div class="column is-one-fifth" style="margin-left: -13px;"><p>Color:</p></div>

							<div class="column auto">

								<div class="columns">
									<?php
										$color_8_column = DB::table('tbl_product_color')
											->where('product_id', $product->id)
											->take(11)
											->get() ;
									?>
									<?php foreach ($color_8_column as $color_value): ?>
										<?php if ($color_value->color_code != null): ?>
										<div class="form-check mb-0">
                                          <input class="form-check-input" style="background-color:<?php echo $color_value->color_code; ?>;width: 23px;height: 23px; id="colorRadio<?php echo $color_value->id; ?>" type="radio" name="colorRadio" value="<?php echo $color_value->color_code; ?>" onclick="changecolorstatus(<?php echo $color_value->id; ?>)" checked>
                                          <label class="form-check-label" for="colorRadio<?php echo $color_value->id; ?>"></label>
                                        </div>
										<?php else: ?>
											<img src="{{ URL::to('public/images/'.$color_value->color_image)}}" alt="availtrade" class="img-border color_image color_image_s_<?php echo $color_value->id; ?>" style="width:32px;cursor: pointer;margin-left: 10px;margin-top: 10px" onclick="changecolorstatus(<?php echo $color_value->id; ?>)">
										<?php endif; ?>

									<?php endforeach ?>
								</div>
								<?php if ($color_count > 8 && $color_count < 16): ?>
									<?php
										$color_16_column = DB::table('tbl_product_color')
											->where('product_id', $product->id)
											->skip(11)
											->take(8)
											->get() ;
									?>
									<?php foreach ($color_16_column as $color_16_value): ?>
										<?php if ($color_16_value->color_code != null): ?>
										<div class="form-check mb-0">
                                          <input class="form-check-input" style="background-color:<?php echo $color_16_value->color_code; ?>;width: 23px;height: 23px; id="colorRadio<?php echo $color_16_value->id; ?>" type="radio" name="colorRadio" value="<?php echo $color_16_value->color_code; ?>" onclick="changecolorstatus(<?php echo $color_16_value->id; ?>)" checked>
                                          <label class="form-check-label" for="colorRadio<?php echo $color_16_value->id; ?>"></label>
                                        </div>
										<?php else: ?>
											<img src="{{ URL::to('public/images/'.$color_16_value->color_image)}}" alt="availtrade" class="img-border color_image color_image_s_<?php echo $color_16_value->id; ?>" style="width:32px;cursor: pointer;margin-left: 10px;margin-top: 10px" onclick="changecolorstatus(<?php echo $color_16_value->id; ?>)">
										<?php endif; ?>

									<?php endforeach ?>
								<?php endif ?>
							</div>

						</div>
					<?php endif ?>
					<input type="hidden" name="color_id" class="color_id" value="0" >
					<?php $size_count = DB::table('tbl_product_size')->where('product_id', $product->id)->count() ;
					if ($size_count > 0 && $color_image_price != 2): ?>
					<div class="columns">
						<div class="column is-one-fifth"><p>Sizes:</p></div>
						<div class="column auto">
							<div class="columns is-multiline">
								<?php
									$size_8_column = DB::table('tbl_product_size')
										->join('tbl_size', 'tbl_product_size.size_id', '=', 'tbl_size.id')
										->select('tbl_product_size.*', 'tbl_size.size')
										->where('tbl_product_size.product_id', $product->id)
										->take(6)
										->get() ;
								?>
							    
								<?php foreach ($size_8_column as $key => $sizevalue): ?>
    								<div class="form-check mb-0" style="margin-left:<?php if($key == 0){echo '-27px'; }else{echo '0px';} ?>;margin-top: 10px">
    								    <input type="radio" name="size_id" id="size_id" id="size_id<?php echo $sizevalue->id; ?>" value="<?php echo $sizevalue->size_id; ?>"> 
    								    <labele class="form-check-label" for="size_id<?php echo $sizevalue->id; ?>">{{ $sizevalue->size }}</labele>
                                    </div>
								<?php endforeach ?>

							</div>
						</div>
					</div>
					<?php endif ?>
					
					<div class="columns" style="display:<?php if($product_price_info->start_quantity == 0){echo "none"; }else{echo " "; }?>">
						<div class="column is-one-fifth"><p>Quantity:</p></div>
						<div class="column auto">
							<div class="columns">
								<div class="column">
								    <div class="cart-inde">
                                        <div class="field has-addons">
                                            <span class="control"><a class="button decreament minus" ><span style="font-size: 20px;padding-bottom: 4px; margin: 0px;" >-</span></a></span>
                                            <span class="control"><input class="input idinput quantity" name="quantity" id="quantity_<?php echo $product->id ; ?>" value="<?php if($product_price_info->start_quantity == 0){echo "1"; }else{echo $product_price_info->start_quantity; }?>" type="text" min="<?php if($product_price_info->start_quantity == 0){echo "1"; }else{echo $product_price_info->start_quantity; }?>" min_price="<?php echo $now_product_price_is; ?>"></span>
                                            <span class="control">
                                                <a class="button increament plus" onclick="cartIncreement(<?php echo $product->id ; ?>)">
                                                    <span style="font-size: 20px;padding-bottom: 4px; margin: 0px;">+</span>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
					<div style="padding-top:9rem;">
					      <hr style="background-color: #2ed915;height: 6px;">
					</div>
                 
                    
                    <div style="style="border-bottom: 1px solid #FF0000;border-top: 1px solid #FF0000;">
                    <div class="columns">
                        
						<div class="column is-one-fifth" style="margin-left: 3px;"><p>Payments:</p></div>
						<div class="column auto">
							<div class="columns">
								
							<?php $payment_0 = 0; if($product->payment_method != ""): ?>
    							<?php $payment_0 = 0; $payment_method_id = explode(",", $product->payment_method);
    								foreach ($payment_method_id as $key => $payment_value) { ?>
    								<?php if ($payment_value != ""): ?>
    								    <?php $payment_0 += 1;  ?>
    									<?php
    										$payment_method_info = DB::table('tbl_payment_method')
    											->where('id', $payment_value)
    											->first() ;
    									?>
    									<img src="{{URL::to('public/images/paymeentLogo/'.$payment_method_info->logo)}}" alt="availtrade" class="color_image " style="width:32px;cursor: pointer;margin-left: <?php if($key == 0){echo "-4px";}else{echo "10px"; } ?>;margin-top: 10px;height: 28px;">
    								<?php endif ?>
    							<?php }?>
    						
    						<?php endif; ?>
    						
    						<?php if($payment_0 > 8): ?>
    						<div class="dropdown is-up" style="margin-left:10px;margin-top:10px;">
                              <div class="dropdown-trigger">
                                <button class="button" aria-haspopup="true" aria-controls="dropdown-menu7">
                                  <span>+</span>
                                </button>
                              </div>
                              <div class="dropdown-menu" id="dropdown-menu7" role="menu">
                                <div class="dropdown-content">
                                    
                                  <?php if($product->payment_method != ""): ?>
        							<?php $payment_method_id = explode(",", $product->payment_method);
        								foreach ($payment_method_id as $key => $payment_value) { ?>
        								<?php if ($payment_value != ""): ?>
        									<?php
        										$payment_method_info = DB::table('tbl_payment_method')
        											->where('id', $payment_value)
        											->first() ;
        									?>
        									<img src="{{URL::to('public/images/adminShipping/'.$payment_method_info->logo)}}" alt="availtrade" class="color_image " style="width:32px;cursor: pointer;margin-left: <?php if($key == 0){echo "-4px";}else{echo "10px"; } ?>;margin-top: 10px">
        								<?php endif ?>
        							<?php }?>
    						    <?php endif; ?>
                                </div>
                              </div>
                            </div>
                            <?php endif; ?>
                            

							</div>
						</div>
						</div>

					</div>
					
					<div class="columns">
						<div class="column is-one-fifth" style="margin-left: 3px;"><p>Shipping:</p></div>

						<div class="column auto">
						    
							<div class="columns">
								
    							<?php $shipping_0 = 0; if($product->shipping_method != ""): ?>
        							<?php 
        							    $shipping_method_id = explode(",", $product->shipping_method);
        							    $shipping_0 = 0;
        								foreach ($shipping_method_id as $key => $shipping_value) { ?>
        								<?php if ($shipping_value != ""): ?>
        								
        									<?php
        									    $shipping_0 += 1;
        										$shipping_method_info = DB::table('tbl_shipping')
        											->where('id', $shipping_value)
        											->first() ;
        									?>
        									<?php if($shipping_method_info): ?>
        									    <img src="{{URL::to('public/images/adminShipping/'.$shipping_method_info->logo)}}" alt="availtrade" class="color_image " style="width:54px;cursor: pointer;margin-left: <?php if($key == 0){echo "-4px";}else{echo "10px"; } ?>;margin-top: 11px;height: 28px;">
        									<?php endif; ?>
        								<?php endif ?>
        							<?php }?>
        						<?php endif; ?>
    						<?php if($shipping_0 > 8): ?>
    						<div class="dropdown is-up" style="margin-left:10px;margin-top:10px;">
    						    
                              <div class="dropdown-trigger">
                                
                                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu7">
                                      <span>+</span>
                                    </button>
                                
                                
                              </div>
                              
                              <div class="dropdown-menu" id="dropdown-menu7" role="menu">
                                <div class="dropdown-content">
                                    
                                    <?php if($product->shipping_method != ""): ?>
            							<?php $shipping_method_id = explode(",", $product->shipping_method);
            								foreach ($shipping_method_id as $key => $shipping_value) { ?>
            								<?php if ($shipping_value != ""): ?>
            									<?php
            										$shipping_method_info = DB::table('tbl_shipping')
            											->where('id', $shipping_value)
            											->first() ;
            									?>
            									<?php if($shipping_method_info): ?>
            									    <img src="{{URL::to('public/images/'.$shipping_method_info->logo)}}" alt="availtrade" class="color_image " style="width:32px;cursor: pointer;margin-left: <?php if($key == 0){echo "-4px";}else{echo "10px"; } ?>;margin-top: 10px">
            									<?php endif; ?>
            								<?php endif ?>
            							<?php }?>
            						<?php endif; ?>
    						    
                                </div>
                              </div>

							</div>
							<?php endif; ?>
						</div>

					</div>


				</div>
				
				</div>
                @php
					$supplir_info = DB::table('express')
					    ->leftJoin('tbl_countries', 'express.country', '=', 'tbl_countries.id')
					    ->select('express.*', 'tbl_countries.countryCode')
						->where('express.id', $product->supplier_id)
						->first() ;
				@endphp
				<div class="column is-one-quarter mr-0 ml-0">
					<div class="columns">
						<div class="column">
							<div class="box" style="padding-left: 30px !important;width: 343px !important;">
								<table width="95%">
								    <?php if($product_price_info->start_quantity > 0): ?>
									<tr>
										<td>
										    <span id="quantity_section_change"><?php if($product_price_info->start_quantity == 0){echo "1"; }else{echo $product_price_info->start_quantity; } ?> </span>
										    <?php echo $product_price_info->unit_name; ?></td>
										<td style="text-align:right"><b><span style="font-size:22px;font-family:'SolaimanLipi';"><?php echo $currency_code; ?></span> 
										<span class="min_price_section">
										    <?php if($product_price_info->start_quantity == 0){echo number_format($now_product_price_is*1, 2); }else{echo number_format($now_product_price_is*$product_price_info->start_quantity, 2); } ?> 
										</span>
										
										</b></td>
									</tr>

									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2" style="width: 100%;border-bottom: 2px dotted #000;padding-top: 12px;"></td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td>Total</td>
										<td style="text-align:right"><b><span style="font-size:22px;font-family:'SolaimanLipi';"><?php echo $currency_code; ?></span> 
										<span class="min_price_section">
										    <?php if($product_price_info->start_quantity == 0){echo number_format($now_product_price_is*1, 2); }else{echo number_format($now_product_price_is*$product_price_info->start_quantity, 2); } ?> 
										</span>
										</b></td>
									</tr>
									<?php endif; ?>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									
									<tr>
										<td colspan="2">
										    <a href="#" title="">
											<button style="width: 100%;" class="button is-danger is-rounded" id="startOrder">Start Order</button>
											</a>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2">
										    <?php $storeNameSiam = "$supplir_info->storeName";  ?>
											<a onclick="sendquotationinfo(<?php echo $product->supplier_id; ?>, '<?php echo $supplir_info->storeName;  ?>', '<?php echo $product->id;  ?>')" style="width: 100%;" class="button is-success is-rounded is-outlined">Contact Supplier</a>
										</td>
									</tr>
									<tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<tr>
										<td colspan="2">
											<center><i class="fas fa-cart-plus"></i> <a href="#" id="addtocart">Add to Cart</a></center>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					
					
                    @if($supplir_info->seller_type == 0)
					<div class="columns is-one-quarter mr-0 ml-0 box" style="padding: 10px !important;width: 343px !important;">
							<div class="column is-full">
								<center><img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower($supplir_info->countryCode).'.png'; ?>" alt="" style="width:25px;height:20px;"></span> Supplier</center>
								<a href="<?php $store = strtolower($supplir_info->storeName); ?> {{ URL::to('store/'.$store) }}" target="_parent"><p style="font-weight: bold;font-style: oblique;">{{ $supplir_info->storeName }}</p></a>
								<p>Manufacturer,Trading Company</p>
								<p><?php
									$created_at = date("d M Y", strtotime($supplir_info->created_at)) ;
									$today_date = date("d M Y");
									$datetime1 = new DateTime("$created_at");
									$datetime2 = new DateTime($today_date);
									$interval = $datetime1->diff($datetime2);
									
									if($interval->format('%y') == 0){
									    echo $interval->format('%m M, %d D');
									}else{
									    echo $interval->format('%y Y, %m M');
									}
 								?></p>
								<p style="color: dimgray;"><?php echo $supplir_info->companyDetails; ?></p>
							</div>
					</div>
					@endif
					<?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null || Session::get('seller_id') != null){ ?>
					   <div class="columns is-one-quarter mr-0 ml-0 box" style="padding: 10px !important;width: 343px !important;">
							<div class="column is-full">
							    <button style="width: 100%;" class="button is-info is-rounded is-outlined" id="myBtn">Show Number</button>
							    
							    </div>
						 </div>
						
						<style>
/* The Close Button */
.close {
  color: #aaa;
  float: right;
  margin-left:10px;
  margin-top:-3px;
  font-size: 27px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
} 
						</style>
						<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-cont">
    <span class="close">&times;</span>
    <p style="">{{$supplir_info->mobile}}</p>
  </div>

</div>
						
 <?php }else{ ?> 
						 
						 <div class="columns is-one-quarter mr-0 ml-0 box" style="padding: 10px !important;width: 343px !important;">
							<div class="column is-full">
							    <button style="width: 100%;" class="button is-info is-rounded is-outlined" onclick="myFunction()">Show Number</button>
							    
							    </div>
						 </div>
						 
						 <?php } ?>
					
					
					
					
					<?php if($product->product_tags): ?>
    					<div class="columns is-one-quarter mr-0 ml-0 box" style="padding: 10px !important;width: 343px !important;margin-top:10px;">
    						<div class="column is-full">
    							<p style="color: dimgray;"><?php echo $product->product_tags; ?></p>
    						</div>
    					</div>
					<?php endif; ?>

				</div>

			</div>
		</div>

        <!-- start of product description -->
        <div class="container">
            <h2 style="font-size: 20px;font-weight: bold;" class="mb-2">You may also like</h2>
            <div class="columns is-full">
                <div class="column is-full">
                    <div class="columns is-gapless mr-0" style="width: 100% !important;overflow-x: hidden;overflow-scrolling: touch;">
                        <?php
                        $like_product = DB::table('tbl_product')
                            ->where('w_category_id', $product->w_category_id)
                            ->inRandomOrder()
                            ->limit(8)
                            ->where('status', 1)
                            ->get() ;

                        ?>
                        <?php foreach ($like_product as $like_value): ?>
                        
                        <a href="{{ URL::to('product/'.$like_value->slug)}}" title="{{ $like_value->product_name }}" class="four_ancor">

                        <div class="column mr-2 box" style="padding: 0px !important;width: 226px !important;">
                            <div style="background: #fff;padding: 15px;width: 228px;border-radius: 4px;">
                                <?php $third_image_explode = explode("#", $like_value->products_image); ?>
                                <img src="{{ URL::to('public/images/'.$third_image_explode[0]) }}" style="width:226px; height:226px;" alt="{{ $like_value->product_name }}">
                                <p style="font-size: 13px">{{ Str::limit($like_value->product_name, 20) }}</p>
                                <p style="font-size: 16px; font-weight: bold;font-family:'SolaimanLipi';">

                                <!-- Price section -->
                                @php
                                    $price_count = DB::table('tbl_product_price')
                                        ->where('product_id', $like_value->id)
                                        ->count() ;

                                    $price_info = DB::table('tbl_product_price')
                                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                                            ->select('tbl_product_price.*', 'tbl_currency_status.symbol')
                                            ->where('tbl_product_price.product_id', $like_value->id)
                                            ->first() ;

                                    $minimum_order = DB::table('tbl_product_price')
                                                ->where('product_id', $like_value->id)
                                                ->orderBy('tbl_product_price.start_quantity', 'asc')
                                                ->first() ;
                                @endphp
                                
                                <?php
                                    $product_price_info2 = DB::table('tbl_product_price')
                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                        ->where('tbl_product_price.product_id', $like_value->id)
                                        ->orderBy('tbl_product_price.product_price', 'asc')
                                        ->first() ;
                                        
                                    $product_price_info3 = DB::table('tbl_product_price')
                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                        ->where('tbl_product_price.product_id', $like_value->id)
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
                                
                                <?php if ($price_count == 1): ?>
                                <b>
                                    <?php if ($price_info->price_status == 3): ?>
                                    Negotiate
                                    <?php else: ?>
                                    {{ $currency_code2 }} <?php echo number_format($now_product_price_is2, 2) ; ?>
                                    <?php endif ?>
                                </b><br/>
                                <?php else: ?>
                                @php
                                    $max_price = DB::table('tbl_product_price')
                                        ->where('product_id', $like_value->id)
                                        ->max('product_price') ;

                                    $min_price = DB::table('tbl_product_price')
                                        ->where('product_id', $like_value->id)
                                        ->min('product_price') ;
                                @endphp
                                 <b>{{ $currency_code2 }} {{ number_format($now_product_price_is2, 2) }} - {{ number_format($now_product_price_is_max, 2) }}</b><br/>
                                <?php endif ?>

                            </p>
                            <p><?php if ($minimum_order->price_status == 1): ?>
                                @php
                                    echo $minimum_order->start_quantity ;
                                @endphp
                                <?php else: ?> 1 <?php endif ?> {{ $product_price_info2->unit_name }} (MQQ)</p>
                            </div>
                        </div>
                        </a>
                        <?php endforeach ?>

                    </div>
                </div>
            </div>

            <div class="columns is-gapless pb-0 mb-0">
                <div class="column is-full">
                    <div class="tabs is-boxed">
                        <ul>
                            <li id="product-details">
                                <a>
                                    <span class="icon is-small"></span>
                                    <span>Product Details</span>
                                </a>
                            </li>
                            <li id="company-profile">
                                <a>
                                    <span class="icon is-small"></span>
                                    <span>Company Profile</span>
                                </a>
                            </li>
                            
                            <li id="product-review">
                                <a>
                                    <span class="icon is-small"></span>
                                    <span>Review</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="columns is-gapless pr-4">
                <div class="column is-three-quarters" id="product-details-container" style="background: #fff; height: auto;display: none;">
                    <!-- Product description goes here -->
                    <div style="padding: 15px;">
                        
                        @if($product->video_link)
                        <div class="embed-responsive embed-responsive-16by9">
                            
                            @if($product->link_type == 2)
                            <?php
                                $output = parse_url("{{ $product->video_link }}");
                                // The part you want
                                $url= $output['path'];
                                $parts = explode('/',$url);
                                $parts = explode('_',$parts[2]);
                            ?>
                          <iframe frameborder="0" class="embed-responsive-item" src="//www.dailymotion.com/embed/video/{{ $parts[0] }}" allowfullscreen></iframe>
                          @else
                            <?php 
                                $url2 = $product->video_link;
                                parse_str( parse_url( $url2, PHP_URL_QUERY ), $my_array_of_vars2 );
                                $video_id = $my_array_of_vars2['v'];   
                            ?>
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{ $video_id }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                          @endif
                          
                        </div>
                        @endif
                        
                        <?php echo $product->product_description; ?>
                    </div>
                </div>
                <div class="column is-three-quarters" id="company-profile-container" style="background: #fff; height: auto;">
                    <!-- Product description goes here -->
                     <?php echo $supplir_info->company_profile; ?> 
                    <table class="table is-bordered pricing__table is-fullwidth">
                        <thead>
                            <tr>
                            <th> Company Name</th>
                             <td> <?php echo $supplir_info->companyName; ?></td>
                           </tr>
                           <tr>
                            <th>Country</th>
                             <td><img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower($supplir_info->countryCode).'.png'; ?>" alt="country-flag" style="width:55px;height:40px;"></td>
                           </tr>
                           <tr>
                            <th>Year Established</th>
                             <td> <?php
                                 $year = date("Y", strtotime($supplir_info->created_at)) ;
                              echo $year; ?></td>
                           </tr>
                           <tr>
                            <th> Main Product</th>
                             <td> <?php echo $supplir_info->mainProduct; ?></td>
                           </tr>
                            <tr>
                            <th>Company Address</th>
                             <td> <?php echo $supplir_info->companyAddress; ?></td>
                           </tr>
                           <tr>
                            <th>Employee Number</th>
                             <td> <?php echo $supplir_info->companyEmployeeNumber; ?></td>
                           </tr>
                           <tr>
                            <th>Email</th>
                             <td> <?php echo $supplir_info->email; ?></td>
                           </tr>
                           
                        </thead>
                        
                    </table>
                    <div style="width:100%; <?php if($supplir_info->googleMapLocation != null){echo ""; }else{echo "display:none"; } ?>">
                        <iframe src="<?php echo $supplir_info->googleMapLocation; ?>" width="1000" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        
                    </div>
                    <div class="box  has-text-centered">
                     <a href="<?php $store = strtolower($supplir_info->storeName); ?> {{ URL::to('store/'.$store) }}" target="_parent" class="button is-primary">Visit Store</a>
                    </div>
                    
                </div>
                
                <div class="column is-three-quarters" id="product-review-container" style="background: #fff; height: auto;">
                    <!-- Product description goes here -->
                    
                    <div class="columns">
                        
                        <div class="column is-full">
                            <?php
                                $all_review = DB::table('tbl_reviews')
                                    ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
                                    ->join('express', 'tbl_reviews.buyer_id', '=', 'express.id')
                                    ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name','express.storeName', 'express.first_name', 'express.last_name', 'express.type', 'express.email as customeremail','express.image')
                                    ->where('tbl_reviews.product_id', $product->id)
                                    ->orderBy('tbl_reviews.id', 'desc')
                                    ->where('tbl_reviews.status', 1)
                                    ->get() ;
                                    
                                $all_review_pa = DB::table('tbl_reviews')
                                    ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
                                    ->join('express', 'tbl_reviews.buyer_id', '=', 'express.id')
                                    ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name','express.storeName', 'express.first_name', 'express.last_name', 'express.type', 'express.email as customeremail','express.image')
                                    ->where('tbl_reviews.product_id', $product->id)
                                    ->orderBy('tbl_reviews.id', 'desc')
                                    ->where('tbl_reviews.status', 1)
                                    ->limit(6)
                                    ->get() ;
                                    
                                $one_star = DB::table('tbl_reviews')
                                    ->where('product_id', $product->id)
                                    ->where('review_star', 1)
                                    ->where('tbl_reviews.status', 1)
                                    ->count() ;
                                    
                                $two_star = DB::table('tbl_reviews')
                                    ->where('product_id', $product->id)
                                    ->where('review_star', 2)
                                    ->where('tbl_reviews.status', 1)
                                    ->count() ;
                                    
                                $three_star = DB::table('tbl_reviews')
                                    ->where('product_id', $product->id)
                                    ->where('review_star', 3)
                                    ->where('tbl_reviews.status', 1)
                                    ->count() ;
                                    
                                $four_star = DB::table('tbl_reviews')
                                    ->where('product_id', $product->id)
                                    ->where('review_star', 4)
                                    ->where('tbl_reviews.status', 1)
                                    ->count() ;
                                
                                $five_star = DB::table('tbl_reviews')
                                    ->where('product_id', $product->id)
                                    ->where('review_star', 5)
                                    ->where('tbl_reviews.status', 1)
                                    ->count() ;
                                if(count($all_review) > 0){
                                    $avarage_star = (5*$five_star + 4*$four_star + 3*$three_star + 2*$two_star + 1*$one_star) / ($five_star+$four_star+$three_star+$two_star+$one_star) ;
                                }else{
                                    $avarage_star = 0 ;
                                }
                                
                                
                                if($five_star > 0){
                                  $five_star_percenage    = 100*$five_star/count($all_review);  
                                }else{
                                    $five_star_percenage    = 0;
                                }
                                
                                if($four_star > 0){
                                    $four_star_percenage    = 100*$four_star/count($all_review);
                                }else{
                                    $four_star_percenage    = 0;
                                }
                                
                                if($four_star > 0){
                                    $three_star_percenage   = 100*$three_star/count($all_review);
                                }else{
                                    $three_star_percenage    = 0;
                                }
                                
                                if($four_star > 0){
                                    $two_star_percenage     = 100*$two_star/count($all_review);
                                }else{
                                    $two_star_percenage    = 0;
                                }
                                
                                if($four_star > 0){
                                    $one_star_percenage     = 100*$one_star/count($all_review);
                                }else{
                                    $one_star_percenage    = 0;
                                }

                            ?>
                            <div class="content">
                                <div class="ratting" style="padding:20px;">
                                    <center>
                                        <span class="heading">User Rating</span>
                                        
                                         <?php if($avarage_star == 0): ?>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                         <?php elseif($avarage_star < 2): ?>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                        <?php elseif($avarage_star < 3): ?>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                        <?php elseif($avarage_star < 4): ?>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star"></span>
                                            <span class="fas fa-star"></span>
                                        <?php elseif($avarage_star < 5): ?>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star"></span>
                                        <?php else: ?>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                            <span class="fas fa-star checked"></span>
                                        <?php endif ?>
                                        
                                        
                                        <p>{{ number_format($avarage_star,1) }} average based on {{ count($all_review) }} reviews.</p>
                                    </center>
                                    
                                    <hr style="border:3px solid #f1f1f1">
                                    
                                    <div class="columns" style="width: 1020px !important;">
                                        <div class="column" style="height:auto;width:500px !important;">
                                            <div class="row" style="padding:20px;">
                                      <div class="side">
                                        <div>5 star</div>
                                      </div>
                                      <div class="middle">
                                        <div class="bar-container" >
                                          <div class="bar-5" style="width:<?php echo intval($five_star_percenage); ?>%!important"></div>
                                        </div>
                                      </div>
                                      <div class="side right" style="text-align: left !important;padding-left:15px !important;">
                                        <div>{{ $five_star }}</div>
                                      </div>
                                      <div class="side">
                                        <div>4 star</div>
                                      </div>
                                      <div class="middle">
                                        <div class="bar-container">
                                          <div class="bar-4" style="width:<?php echo intval($four_star_percenage); ?>%!important"></div>
                                        </div>
                                      </div>
                                      <div class="side right" style="text-align: left !important;padding-left:15px !important;">
                                        <div>{{ $four_star }}</div>
                                      </div>
                                      <div class="side">
                                        <div>3 star</div>
                                      </div>
                                      <div class="middle">
                                        <div class="bar-container">
                                          <div class="bar-3" style="width:<?php echo intval($three_star_percenage); ?>%!important"></div>
                                        </div>
                                      </div>
                                      <div class="side right" style="text-align: left !important;padding-left:15px !important;">
                                        <div>{{ $three_star }}</div>
                                      </div>
                                      <div class="side">
                                        <div>2 star</div>
                                      </div>
                                      <div class="middle">
                                        <div class="bar-container">
                                          <div class="bar-2" style="width:<?php echo intval($two_star_percenage); ?>%!important"></div>
                                        </div>
                                      </div>
                                      <div class="side right" style="text-align: left !important;padding-left:15px !important;">
                                        <div>{{ $two_star }}</div>
                                      </div>
                                      <div class="side">
                                        <div>1 star</div>
                                      </div>
                                      <div class="middle">
                                        <div class="bar-container">
                                          <div class="bar-1" style="width:<?php echo intval($one_star_percenage); ?>%!important"></div>
                                        </div>
                                      </div>
                                      <div class="side right" style="text-align: left !important;padding-left:15px !important;">
                                        <div>{{ $one_star }}</div>
                                      </div>
                                    </div>
                                        </div>
                                        <div class="column" style="height:auto;width:500px !important;">
                                            									<div>
                                        <br>
                                        {!! Form::open(['id' =>'submitCustomerReview','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <table width="70%" border="0">
                                            
                                            <tr>
                                                <td style="text-align: left;padding-top:10px;border-bottom: none !important;width:110px !important;"><b>* Rating :</b>&nbsp;&nbsp;&nbsp;</td>
                                                <td style="border-bottom: none !important;float: left;margin-top:-5px !important;">
                                                    <div class="content">
                                                        <fieldset class="rating">
                                                            <input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
                                                            <input type="radio" id="star4half" name="rating" value="4" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                                                            <input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
                                                            <input type="radio" id="star3half" name="rating" value="3" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                                                            <input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
                                                            <input type="radio" id="star2half" name="rating" value="2" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                                                            <input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
                                                            <input type="radio" id="star1half" name="rating" value="1" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                                                            <input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>
                                                            <input type="radio" id="starhalf" name="rating" value="1" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
                                                        </fieldset>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: none !important;"><b>*Review :</b>&nbsp;&nbsp;&nbsp;</td>
                                                <td style="border-bottom: none !important;">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="border-bottom: none !important;">
                                                    <textarea class="textarea" placeholder="e.g. Hello world" name="review_message" required="" max="200"></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td ></td>
                                                <td style="text-align: right" colspan="2">
                                                    <button class="button is-danger">Send</button>
                                                </td>
                                            </tr>
                                        </table>
                                        {!! Form::close() !!}
                                    </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                
                                <table class="table mb-0 mt-4 reviewtable">
                                    <?php foreach($all_review_pa as $reviewvalue): ?>
                                    <tr>
                                        <td>
                                            <?php $base_url = "https://availtrade.com/"; if($reviewvalue->image != "" || $reviewvalue->image != null){
                                                    if(strpos($reviewvalue->image, "https") !== false){
                                                       $image_url = $reviewvalue->image ;
                                                    } else{
                                                       $image_url = $base_url."public/images/".$reviewvalue->image;
                                                    }
                                                }else{
                                                    $image_url = $base_url."public/images/Image 4.png";
                                                } ?>
                                            <img src="{{ $image_url }}" style="width:40px;height:40px;border-radius:50%;float:left;margin-top:5px;" alt="review">
                                            <div style="margin-left:50px">
                                                
                                                <?php if($reviewvalue->review_star < 2): ?>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star"></span>
                                                    <span class="fas fa-star"></span>
                                                    <span class="fas fa-star"></span>
                                                    <span class="fas fa-star"></span>
                                                <?php elseif($reviewvalue->review_star < 3): ?>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star"></span>
                                                    <span class="fas fa-star"></span>
                                                    <span class="fas fa-star"></span>
                                                <?php elseif($reviewvalue->review_star < 4): ?>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star"></span>
                                                    <span class="fas fa-star"></span>
                                                <?php elseif($reviewvalue->review_star < 5): ?>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star"></span>
                                                <?php else: ?>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                    <span class="fas fa-star checked"></span>
                                                <?php endif ?>
                                                
                                                <p class="text-justify">{{ $reviewvalue->review_details }}</p>  
                                                <span><?php echo date("d F y", strtotime($reviewvalue->created_at)); ?></span>
                                            </div>
                                        </td
                                       
                                    </tr>
                                    <?php endforeach?>
                                    

                                </table>
                                <?php if(count($all_review) > 6): ?>
                                    <center><button id="more_review_button" class="button is-success" onclick="loadmorereview()">Load more</button></center>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    
                    <?php if($main_login_id): ?>
                        <?php if($main_login_id != $product->supplier_id): ?>
                        <?php endif; ?>
                    <?php endif; ?>
                        <!-- start of sending message to supplier -->
                    
                    <!-- end of sending message to supplier -->
                    
                    
                    
                </div>
            </div>
        </div>
        <!-- end of product description -->

        <!-- start of sending message to supplier -->
        <div class="container mt-5 mb-5">
            <div class="columns is-gapless pr-4">
                <div class="column is-three-quarters box" style="background: #fff; height: 532px;">
                    <div class="p-5">
                        <h2>Send your message to this supplier</h2>
                        <?php if(Session::get('success') != null) { ?>
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                            <strong><?php echo Session::get('success') ;  ?></strong>
                            <?php Session::put('success',null) ;  ?>
                        </div>
                        <?php } ?>
                        <?php
                        if(Session::get('failed') != null) { ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                            <strong><?php echo Session::get('failed') ; ?></strong>
                            <?php echo Session::put('failed',null) ; ?>
                        </div>
                        <?php } ?>
                        <br>
                        <?php if($main_login_id == 0): ?>
                           {!! Form::open(['id' =>'sendSupplierQuotationlogin','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                        <?php else: ?>
                            {!! Form::open(['url' =>'sendSupplierQuotation','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                        <?php endif; ?>
                        
                        <table width="70%">
                            <tr>
                                <td style="text-align: right">To:&nbsp;&nbsp;&nbsp;</td>
                                <td>{{ $supplir_info->storeName }}</td>
                            </tr>
                            <tr>
                                <td style="text-align: right">*Subject:&nbsp;&nbsp;&nbsp;</td>
                                <td colspan="3">
                                    <input class="input" type="text" name="subject"  placeholder="Subject" required="">
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align: right">*Message:&nbsp;&nbsp;&nbsp;</td>
                                <td colspan="3">
                                    <textarea class="textarea" placeholder="e.g. Hello world" name="message" required=""></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align: right">Quantity:&nbsp;&nbsp;&nbsp;</td>
                                <td><input class="input" type="number" name="start_quantity" min="1" placeholder="Text input"></td>
                                <td>&nbsp;&nbsp;&nbsp;
                                    <div class="select is-link">
                                        <select name="unit_name">
                                            <option value="{{ $unit->unit_name }}">{{ $unit->unit_name }}</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align: right"></td>
                                <td colspan="3">
                                    <label class="checkbox">
                                        <input type="checkbox"  required="">
                                        Recommend matching suppliers if this supplier doesn’t contact me on Message Center within 24 hours.
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right"></td>
                                <td colspan="3">
                                    <label class="checkbox">
                                        <input type="checkbox"  checked required="">
                                        agree to share my Business Card to the supplier.
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td style="text-align: right"></td>
                                <td colspan="3">
                                    <button class="button is-danger">Send</button>
                                </td>
                            </tr>
                        </table>

                        <input type="hidden" name="product_slug" value="<?php echo $product->slug; ?>">
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- end of sending message to supplier -->

        <!-- start of Supplier's popular products -->
        <div class="container mt-5 mb-5">
            <h2 style="font-size: 20px;font-weight: bold;" class="mb-2">Supplier's popular products</h2>
              <div class="columns is-full">
                <div class="column is-full">
                    <div class="columns is-gapless mr-0" style="width: 100% !important;overflow-x: hidden;overflow-scrolling: touch;">
                <?php
                $supplier_product = DB::table('tbl_product')
                    ->where('supplier_id', $product->supplier_id)
                    ->inRandomOrder()
                    ->limit(8)
                    ->where('status', 1)
                    ->get() ;
                ?>
                <?php foreach ($supplier_product as $supplier_value): ?>

                <a href="{{ URL::to('product/'.$supplier_value->slug)}}" title="{{ $supplier_value->product_name }}" class="four_ancor">
                    <div class="column mr-2 box" style="padding: 0px !important;width: 226px !important;">
                        <div style="background: #fff;padding: 15px;width: 228px;border-radius: 4px;">
                            <?php $third_image_explode_s = explode("#", $supplier_value->products_image); ?>
                            <img src="{{ URL::to('public/images/'.$third_image_explode_s[0]) }}" alt="{{ $supplier_value->product_name }}" style="width:226px; height:226px;" >
                            <p style="font-size: 13px">{{ Str::limit($supplier_value->product_name, 20) }}</p>
                            <p style="font-size: 16px; font-weight: bold;font-family:'SolaimanLipi';">

                                <!-- Price section -->
                                @php
                                    $price_count = DB::table('tbl_product_price')
                                        ->where('product_id', $supplier_value->id)
                                        ->count() ;

                                    $price_info = DB::table('tbl_product_price')
                                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                                            ->select('tbl_product_price.*', 'tbl_currency_status.symbol')
                                            ->where('tbl_product_price.product_id', $supplier_value->id)
                                            ->first() ;

                                    $minimum_order = DB::table('tbl_product_price')
                                                ->where('product_id', $supplier_value->id)
                                                ->orderBy('tbl_product_price.start_quantity', 'asc')
                                                ->first() ;
                                @endphp
                                
                                <?php
                                    $product_price_info2 = DB::table('tbl_product_price')
                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                        ->where('tbl_product_price.product_id', $supplier_value->id)
                                        ->orderBy('tbl_product_price.product_price', 'asc')
                                        ->first() ;
                                        
                                    $product_price_info3 = DB::table('tbl_product_price')
                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                        ->where('tbl_product_price.product_id', $supplier_value->id)
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
                                
                                <?php if ($price_count == 1): ?>
                                <b>
                                    <?php if ($price_info->price_status == 3): ?>
                                    Negotiate
                                    <?php else: ?>
                                    {{ $currency_code2 }} <?php echo number_format($now_product_price_is2, 2) ; ?>
                                    <?php endif ?>
                                </b><br/>
                                <?php else: ?>
                                @php
                                    $max_price = DB::table('tbl_product_price')
                                        ->where('product_id', $supplier_value->id)
                                        ->max('product_price') ;

                                    $min_price = DB::table('tbl_product_price')
                                        ->where('product_id', $supplier_value->id)
                                        ->min('product_price') ;
                                @endphp
                                 <b>{{ $currency_code2 }} {{ number_format($now_product_price_is2, 2) }} - {{ number_format($now_product_price_is_max, 2) }}</b><br/>
                                <?php endif ?>

                            </p>
                            <p><?php if ($minimum_order->price_status == 1): ?>
                                @php
                                    echo $minimum_order->start_quantity ;
                                @endphp
                                <?php else: ?> 1 <?php endif ?> {{ $product_price_info2->unit_name }} (MQQ)</p>
                        </div>
                    </div>
                </a>
                <?php endforeach ?>
            </div>
        </div>
        <!-- end of Supplier's popular products -->
	</div>

@endsection

@section('js')


<script>

    function chatshowpage(product_id, receiver_id, senderid){
        
        if(receiver_id == senderid){
            toastr.info('Oh shit!! You Can Not Chat This Person', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
        
        if(senderid == 0){
            $("#login_modal").modal('show');
            return false ;
        }
        
        $(".chat-popup").show();
        $('.chat-btn').hide();

        $(".sonia").css({backgroundColor: 'white'});
        var supplier_name = '<?php echo $supplir_info->first_name." ".$supplir_info->last_name; ?>';
       
        $('.supplier-name-holder').empty();
        $('.supplier-name-holder').text(supplier_name);
           
        $('#receiver_id_by_ajax').empty();
        $('#receiver_id_by_ajax').val(receiver_id);
        
        $.ajaxSetup({
        	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
        	'url':"{{ url('/insertProductChatInfo') }}",
        	'type':'post',
        	'dataType':'text',
        	data:{product_id:product_id, receiver_id:receiver_id, sender_id:senderid},
        	success:function(data)
        	{
        	    if(data != 2){
        	        $(".chat-members").append(data);
        	    }else{
        	        $(".sonia").css({backgroundColor: 'white'});
        	        $(".member_with_"+receiver_id).css({backgroundColor: '#ffefb3'}) ;
        	    }

        		$.ajax({
                	'url':"{{ url('/loadMessages') }}",
                	'type':'post',
                	'dataType':'text',
                	data:{receiver_id:receiver_id},
                	success:function(data)
                	{
                        $("#loadChat").empty();
                        $("#loadChat").html(data);
                        $(".chat-window .chat-details").animate({ scrollTop: 9999999 }, 'slow');
                	}
                });
        		
        	}
        });


    }
    
	function changecolorstatus(color_id){
		$('.color_image').removeClass('active') ;
		$('.color_image_s_'+color_id).addClass('active') ;
		$('.color_id').val(color_id) ;
	}


	$(function(){
		$('#given_date').countdowntimer({
			startDate : "<?php echo date("Y-m-d h:i:s"); ?>",
			dateAndTime : "<?php echo $product->offer_end; ?>",
			size : "lg"
		});
	});
	
	$(function(){
	    $("#submitCustomerReview").on('submit',function(e){
    		e.preventDefault() ;
    
    		var rating      = $("[name=rating]:checked").val() ;
            var review      = $("[name=review_message]").val() ;
            var main_login_id = <?php echo $main_login_id ; ?> ;
            
            

            if(main_login_id == 0){
                $("#login_modal").modal('show');
                return false ;
            }
            
    
            if(rating == ""){
                toastr.info('Oh shit!! Please Select Review Star', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
    
            if (review == "") {
                toastr.info('Oh shit!! Please Input Review Details', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
        
            $.ajaxSetup({
            	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        
            $.ajax({
            	'url':"{{ url('/insertReviewInfo') }}",
            	'type':'post',
            	'dataType':'text',
            	data:{product_id:<?php echo $product->id ; ?>, rating:rating, review:review, main_login_id:main_login_id},
            	success:function(data)
            	{
            		if(data == "success"){
            		    $('#submitCustomerReview')[0].reset();
            		    toastr.success('Thanks !! Review Submit Successfully Send.', 'Review Success', { positionClass: 'toast-top-center toast-bottom-full-width', });
            			setTimeout(function(){
            				location.reload() ;
        		        }, 3000);
                        return false;
            		}else{
            			toastr.error('Review Already Exist', 'Oh shit!!', { positionClass: 'toast-top-center', });
            			return false ;
            		}
            	}
            });
            
    
    	});
    })

    

	$(function(){
	    $(".contactSupplier").on('click',function(){

            //$(".chat-popup").show();
            var product_id 		= "{{ $product->id }}";
            var supplier_id 	= "{{ $product->supplier_id }}";
            var product_name 	= "{{ $product->product_name }}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/add-chat-person-and-message') }}",
                'type':'post',
                'dataType':'text',
                data:{product_id:product_id,supplier_id:supplier_id,product_name:product_name},
                success:function(data)
                {
                    if(data == "1"){
                        $(".chat-popup").show();
                        $(".getSupplier[supplier="+supplier_id+"]").trigger("click");
                    }
                }
            });

        });
    })
    

    $("#addtocart").click(function(e){
    	e.preventDefault() ;

    	var product_id 			= <?php echo $product->id ; ?> ;
    	var color_id			= $(".color_id").val() ;
    	var size_id 			= $("#size_id:checked").val() ;
    	var quantity 			= $("[name=quantity]").val() ;
    	var product_color_is 	= <?php echo $color_count; ?> ;
    	var product_size_is 	= <?php echo $size_count ;?> ;
    	var main_login_id 			= <?php echo $main_login_id ; ?> ;
    	
    	
    	if(main_login_id == 0)
    	{
    		toastr.error('Please Login First', 'Access Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

    	if(quantity < 1){
    		toastr.error('Please Input quantity first', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}


    	if(product_size_is > 0 && size_id == undefined)
    	{
    		toastr.error('Please Select product size', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

    	if(product_color_is > 0 && color_id == 0)
    	{
    		toastr.error('Please Select product Color', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

    	if(quantity == ""){
    		toastr.error('Please Input quantity first', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/addtocart') }}",
            'type':'post',
            'dataType':'text',
            data:{product_id:product_id,quantity:quantity, size_id:size_id, color_id:color_id},
            success:function(data)
            {
            	if(data == 'invalid_login'){
            		toastr.error('Please Login First', 'Access Failed !!', { positionClass: 'toast-top-center', });
            		return false ;
            	}else if(data == "supplier_not_buy"){
            		toastr.error('Sorry You Can Not Buy Your Own Product', 'Cart Failed !!', { positionClass: 'toast-top-center', });
            		return false ;
            	}else{
            		$('.cart-area').empty().html(data) ;
            		toastr.success('Thanks !! Product Cart Successfully', 'Cart Success!!', { positionClass: 'toast-top-center', });
	                setTimeout(function(){
        				location.reload() ;
			        }, 3000);
            	}

            }
        });
    })
    
    $("#buyNow").click(function(e){
    	e.preventDefault() ;
    	var prod_id 			= <?php echo $product->id ; ?> ;
    	var col_id			= $(".color_id").val() ;
    	var siz_id 			= $("#size_id:checked").val() ;
    	var quantit 			= $("[name=quantity]").val() ;
    	var product_color 	= <?php echo $color_count; ?> ;
    	var product_size 	= <?php echo $size_count ;?> ;
    	var main_login_id 			= <?php echo $main_login_id ; ?> ;
    	
    	
    	if(main_login_id == 0)
    	{
    		toastr.error('Please Login First', 'Access Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

    	if(quantit < 1){
    		toastr.error('Please Input quantity first', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}
    	
    	if(product_size > 0 && size_id == undefined)
    	{
    		toastr.error('Please Select product size', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

    	if(product_color > 0 && color_id == 0)
    	{
    		toastr.error('Please Select product Color', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

    	if(quantit == ""){
    		toastr.error('Please Input quantity first', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}
    	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/startOrder') }}",
            'type':'post',
            'dataType':'text',
            data:{prod_id:prod_id,quantit:quantit, siz_id:siz_id, col_id:col_id},
            success:function(data)
            {
            	if(data == 'invalid_login'){
            		toastr.error('Please Login First', 'Access Failed !!', { positionClass: 'toast-top-center', });
            		return false ;
            	}else if(data == "supplier_not_buy"){
            		toastr.error('Sorry You Can Not Buy Your Own Product', 'Cart Failed !!', { positionClass: 'toast-top-center', });
            		return false ;
            	}else{
            		$('.cart-area').empty().html(data) ;
            		toastr.success('Thanks !! Product Cart Successfully', 'Cart Success!!', { positionClass: 'toast-top-center', });
	                setTimeout(function(){
        				location.reload() ;
			        }, 3000);
            	}

            }
        });
    	
    	
    })
</script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}", "Warning", { positionClass: 'toast-top-center', });
        break;
        case 'failed':
        toastr.error("{{ Session::get('message') }}", "Failed", { positionClass: 'toast-top-center', });
        break;
    }
    @endif
</script>
<script async src="{{ URL::to('public/anytoshare/anytoshare.js') }}"></script>
<script>

    // Get all dropdowns on the page that aren't hoverable.
    const dropdowns = document.querySelectorAll('.dropdown:not(.is-hoverable)');
    
    if (dropdowns.length > 0) {
      // For each dropdown, add event handler to open on click.
      dropdowns.forEach(function(el) {
        el.addEventListener('click', function(e) {
          e.stopPropagation();
          el.classList.toggle('is-active');
        });
      });
    
      // If user clicks outside dropdown, close it.
      document.addEventListener('click', function(e) {
        closeDropdowns();
      });
    }
    
    /*
     * Close dropdowns by removing `is-active` class.
     */
    function closeDropdowns() {
      dropdowns.forEach(function(el) {
        el.classList.remove('is-active');
      });
    }
    
    // Close dropdowns if ESC pressed
    document.addEventListener('keydown', function (event) {
      let e = event || window.event;
      if (e.key === 'Esc' || e.key === 'Escape') {
        closeDropdowns();
      }
    });
$(document).ready(function(){
    
    // Gets the span width of the filled-ratings span
    // this will be the same for each rating
    var star_rating_width = $('.fill-ratings span').width();
    // Sets the container of the ratings to span width
    // thus the percentages in mobile will never be wrong
    $('.star-ratings').width(star_rating_width);
    
    
    var input = $('.quantity'),
    minValue =  parseInt(input.attr('min')),
    minPriceValue =  parseInt(input.attr('min_price'))
        
    
    $('.plus').on('click', function () {
        var inputValue = input.val();
        input.val(parseInt(inputValue) + 1);
        var inputValue2 = input.val();
        $("#quantity_section_change").empty().append(inputValue2);
        var total_price_ = inputValue2*minPriceValue ;
        $(".min_price_section").empty().append(total_price_.toFixed(2));
    });
    
    $('.minus').on('click', function () {
        var inputValue = input.val();
    	if (inputValue > minValue) {
          input.val(parseInt(inputValue) - 1);
          var inputValue2 = input.val();
          $("#quantity_section_change").empty().append(inputValue2);
          var total_price_ = inputValue2*minPriceValue ;
          $(".min_price_section").empty().append(total_price_.toFixed(2));
        }
    });


    $("#product-details").addClass("is-active");
    $("#product-details-container").show();

    $("#company-profile").removeClass("is-active");
    $("#company-profile-container").hide();
    
    $("#roduct-review").removeClass("is-active");
    $("#product-review-container").hide();

    $("#product-details").on('click',function(e){
        e.preventDefault();

        $("#company-profile").removeClass("is-active");
        $("#company-profile-container").hide();
        
        $("#product-review").removeClass("is-active");
        $("#product-review-container").hide();

        $(this).addClass("is-active");
        $("#product-details-container").show();
    });

    $("#company-profile").on('click',function(e){
        e.preventDefault();

        $("#product-details").removeClass("is-active");
        $("#product-details-container").hide();
        
        $("#product-review").removeClass("is-active");
        $("#product-review-container").hide();

        $(this).addClass("is-active");
        $("#company-profile-container").show();
    });
    
    $("#product-review").on('click',function(e){
        e.preventDefault();

        $("#product-details").removeClass("is-active");
        $("#product-details-container").hide();
        
        $("#company-profile").removeClass("is-active");
        $("#company-profile-container").hide();

        $(this).addClass("is-active");
        $("#product-review-container").show();
    });

})

function loadmorereview()
{

    var lenthcount = $('.reviewtable tr').length;
    $("#more_review_button").addClass('is-loading');
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        'url':"{{ url('/getmorereviewdata') }}",
        'type':'post',
        'dataType':'text',
        data:{lenthcount:lenthcount, product_id:<?php echo $product->id; ?>},
        success:function(data)
        {
            $('#more_review_button').removeClass('is-loading');
            $(".reviewtable").append(data) ;	

        }
    });
}

    $("#sendSupplierQuotationlogin").submit(function(e){
        e.preventDefault() ;
        var senderid = <?php echo $main_login_id; ?>;
        if(senderid == 0){
            $("#login_modal").modal('show');
            return false ;
        }
    });

$("#startOrder").click(function(e){
    e.preventDefault() ;

        var product_id 			= <?php echo $product->id ; ?> ;
    	var color_id			= $(".color_id").val() ;
    	var size_id 			= $("#size_id:checked").val() ;
    	var quantity 			= $("[name=quantity]").val() ;
    	var product_color_is 	= <?php echo $color_count; ?> ;
    	var product_size_is 	= <?php echo $size_count ;?> ;
    	var main_login_id 	    = <?php echo $main_login_id; ?>;
    	

    	if(main_login_id == 0)
    	{
    		toastr.error('Please Login First', 'Access Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

    	if(quantity < 1){
    		toastr.error('Please Input quantity first', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}


    	if(product_size_is > 0 && size_id == undefined)
    	{
    		toastr.error('Please Select product size', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

    	if(product_color_is > 0 && color_id == 0)
    	{
    		toastr.error('Please Select product Color', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

    	if(quantity == ""){
    		toastr.error('Please Input quantity first', 'Cart Failed !!', { positionClass: 'toast-top-center', });
	        return false ;
    	}

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/addtocart') }}",
            'type':'post',
            'dataType':'text',
            data:{product_id:product_id,quantity:quantity, size_id:size_id, color_id:color_id},
            success:function(data)
            {
            	if(data == 'invalid_login'){
            		toastr.error('Please Login First', 'Access Failed !!', { positionClass: 'toast-top-center', });
            		return false ;
            	}else if(data == "supplier_not_buy"){
            		toastr.error('Sorry You Can Not Buy Your Own Product', 'Cart Failed !!', { positionClass: 'toast-top-center', });
            		return false ;
            	}else{
            		$('.cart-area').empty().html(data) ;
                    
                    var main_url = '{{ env("APP_URL") }}' ;
        			location.href= main_url+"cart";

            	}

            }
        });
    });
    
    
function myFunction()
    {
        var login_id = '<?php echo $main_login_id;  ?>';
        if(login_id == 0){
            $("#login_modal").modal('show');
            return false ;
        }
        
 
    }


</script>



@endsection
