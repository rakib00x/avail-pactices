@extends('mobile.master-website')
@section('page_headline')
    @foreach($ptitle as $title)
        {{$title->product_name}}
    @endforeach
@endsection
@section('meta_info')
    <?php
        if($product->meta_description){
            $main_description = $product->meta_description ;
        }else{
            $main_description = strip_tags($product->product_description) ; 
        }
        
        if($product->meta_title){
            $main_title = $product->meta_title ;
        }else{
            $main_title = $product->product_name ;
        }
    ?>
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
    
    
    <?php $image_thubmnail  = explode("#", $product->products_image); ?>
    <meta name="description" content="<?php echo $main_description; ?>" />
    <meta property="fb:app_id" content="" />
    <meta property="fb:pages" content="" />
    <meta property='og:locale' content='en_US'/>
    <meta property="og:site_name" content="availtrade.com"/>
    <meta name="author" content="availtrade.com">
    <meta property="og:url" content="<?php echo url()->current(); ?>" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content='<?php echo $main_title; ?>'/>
    <meta property="og:image" content="{{ URL::to('public/images/'.$image_thubmnail[0]) }}"/>
    <meta property="og:description" content='<?php echo $main_description; ?>'/>
    <meta property="article:author" content="http://www.availtrade.com" />
    <link rel="canonical" href="<?php echo url()->current(); ?>">
    <link rel="amphtml" href="<?php echo url()->current(); ?>" />
    <!-- twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:url" content="<?php echo url()->current(); ?>" />
    <meta name="twitter:title" content='<?php echo $main_title; ?>' />
    <meta name="twitter:description" content='<?php echo $main_description; ?>' />
    <meta name="twitter:creator" content="" />
    <meta property="article:published_time" content="">
    <meta property="article:author" content="https://www.availtrade.com">
    <meta property="article:section" content="">

@endsection
@section('content')
    <?php 
        $base_url = env("APP_URL");
        $namazasd 	= DB::table('namazs')->where('status', 1)->get();
     ?>
     

    </div>
        
        <!-- Product Slides-->
        <div class="product-slides owl-carousel" style="padding-top:<?php if(count($namazasd) == 0){ echo "70px !important";}else{ echo "45px !important";} ?>;">
            <?php $proudct_image = explode("#", $product->products_image); ?>
            <?php foreach ($proudct_image as $productvalue): ?>
                <!-- Single Hero Slide-->
                <div class="single-product-slide" style="background-image: url('<?php echo $base_url."public/images/".$productvalue; ?>')" alt="{{ $product->product_name }}"></div>
            <?php endforeach ?>
        </div>
        <div class="product-description pb-1">
            <!-- Product Title & Meta Data-->
            <div class="product-title-meta-data bg-white mb-1 py-3">
                <div class="container d-flex justify-content-between">
                    
                    <div class="p-title-price">
                        <?php
                            $just_product_price__info = DB::table('tbl_product_price')
                                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name')
                                ->where('tbl_product_price.product_id', $product->id)
                                ->orderBy('tbl_product_price.product_price', 'asc')
                                ->first() ;

                            $just_product_price_max_info = DB::table('tbl_product_price')
                                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit' , 'tbl_unit_price.unit_name')
                                ->where('tbl_product_price.product_id', $product->id)
                                ->orderBy('tbl_product_price.product_price', 'desc')
                                ->first() ;

                        ?>
                        
                        <?php
                            $product_price_info2 = DB::table('tbl_product_price')
                                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                ->where('tbl_product_price.product_id', $product->id)
                                ->orderBy('tbl_product_price.product_price', 'asc')
                                ->first() ;
                                
                            $product_price_info3 = DB::table('tbl_product_price')
                                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                ->where('tbl_product_price.product_id', $product->id)
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
                                
                        <p class="mb-1"><strong>{{ $product->product_name }}</strong></p>

                        <h5 class="mb-1">
                            <?php if ($product_price_info2->product_price > 0): ?>
                            
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
        											if ($product_price_info2->discount_type == 1) {
        												$final_price = $product_price_info2->product_price - $product_price_info2->discount;
        
        											}else{
        												$total_disocunt = $product_price_info2->product_price * $product_price_info2->discount / 100 ;
        												$final_price = $product_price_info2->product_price - $total_disocunt;
        
        											}
        										}else{
        											$final_price = $product_price_info2->product_price;
    										    }
    										    
    										    if(Session::has('requestedCurrency')){
                                                    $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                    if($product_price_info2->product_price > 0)
                                                    {
                                                        $product_price_convert  = $final_price / $product_price_info2->currency_rate;
                                                        $now_product_price_is_without_discount   = $product_price_convert * $main_currancy_status->rate ;
                                                    }else{
                                                       $now_product_price_is_without_discount = $product_price_info2->product_price ; 
                                                    }
                                                    
                                                }else{
                                                    $now_product_price_is_without_discount   = $product_price_info->product_price;
                                                }
										else:
										    $now_product_price_is_without_discount = 0 ;
										endif ;
										
									@endphp
                            
                                
                                    {{ $currency_code2 }} <?php if($discount_count > 0){echo number_format($now_product_price_is_without_discount,2); }else{echo number_format($now_product_price_is2, 2); }  ?>
                                    <del><?php if($discount_count > 0){echo number_format($now_product_price_is2, 2); } ?></del>
                                    
                                
                                    <?php if($now_product_price_is2 != $now_product_price_is_max) :?>
                                        - <?php echo number_format($now_product_price_is_max, 2); ?> 
                                    <?php endif; ?>
                            <?php else: ?>
                                Negotiation
                                <?php $discount_count =0 ; ?>
                            <?php endif ?>
                        </h5>
                        @if($discount_count > 0)
                            <!-- Please use event time this format: YYYY/MM/DD hh:mm:ss-->
                            <ul class="sales-end-timer ps-0 d-flex align-items-center" data-countdown="<?php if($discount_count > 0){ echo $product->offer_end; } ?>">
                              <li><span class="days">0</span>d</li>
                              <li><span class="hours">0</span>h</li>
                              <li><span class="minutes">0</span>m</li>
                              <li><span class="seconds">0</span>s</li>
                            </ul>
                        @endif()
                        <p>Min. Order: <?php if($product_price_info2->start_quantity > 0){echo $product_price_info2->start_quantity;}else{echo "1"; } ?> {{ $product_price_info2->unit_name }}</p>
                        
                            <?php
                                $social_info =  Share::currentPage()
                                ->facebook('Extra linkedin summary can be passed here')
                                ->twitter('Extra linkedin summary can be passed here')
                                ->linkedin('Extra linkedin summary can be passed here')
                                ->telegram('Extra linkedin summary can be passed here')
                                ->whatsapp('Extra linkedin summary can be passed here') ;
                            ?><p>
                            {!! $social_info !!}
                    </div>
                    
                </div>
                <!-- Ratings-->
                <div class="product-ratings">
                    <?php
                    
                        $all_review = DB::table('tbl_reviews')
                                ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
                                ->join('express', 'tbl_reviews.buyer_id', '=', 'express.id')
                                ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name','express.storeName', 'express.first_name', 'express.last_name', 'express.type', 'express.email as customeremail','express.image')
                                ->where('tbl_reviews.product_id', $product->id)
                                ->orderBy('tbl_reviews.id', 'desc')
                                ->where('tbl_reviews.status', 1)
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
                    ?>
                    <div class="container d-flex align-items-center justify-content-between">
                        <div class="rating">
                            <?php if($avarage_star == 0): ?>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                            <?php elseif($avarage_star < 2): ?>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                            <?php elseif($avarage_star < 3): ?>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                            <?php elseif($avarage_star < 4): ?>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star"></i>
                                <i class="lni lni-star"></i>
                            <?php elseif($avarage_star < 5): ?>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star"></i>
                            <?php else: ?>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <i class="lni lni-star-filled"></i>
                                <span class="ps-1">3 ratings</span>
                            <?php endif ?>
                                <span class="ps-1"><?php echo count($all_review); ?> ratings</span>
                            </div>
                    </div>
                 </div>
                
            </div>

            <!-- Send Inquiry -->
            <div class="flash-sale-panel bg-white mb-1 py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <center>
                                
                                <button class="custom-send-inquiry" id="myBtn">Send Inquiry</button>
                            </center>
                        </div>
                        
                        <div class="col-6">
                            <center>
                                <a href="{{ URL::to('m/insertMoibleChatInfo/'.$product->id.'/'.$product->supplier_id) }}"><button class="custom-chat-now-button">Chat Now</button></a>
                            </center>
                        </div>
                        <div class="col-6 pt-1">
                            <center>
                                <button class="custom-send-inquiry" type="submit" onclick="startordernow(event)">Start Order</button>
                            </center>
                        </div>
                        <div class="col-6 pt-1">
                            <center>
                                	<?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null || Session::get('seller_id') != null){ ?>
                                <button class="custom-chat-now-button" id="myBtnModal">Show Number</button>
                                <?php }else{ ?>
                                 <button class="custom-chat-now-button" type="submit" onclick="startordernow(event)">Show Number</button>
                                <?php  }?>
                            </center>
                        </div>
                        
                    </div>


                </div>
            </div>
            <?php $color_count = DB::table('tbl_product_color')->where('product_id', $product->id)->count() ; ?>
            <?php if ($color_count > 0): ?>
            <!-- Selection Panel-->
            <div class="container">

                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6>Color</h6>
                </div>

                <div class="row g-1">
                    <div class="choose-color-wrapper">
                              <div class="choose-color-radio d-flex align-items-center">

                    <?php
                        $color_8_column = DB::table('tbl_product_color')
                            ->where('product_id', $product->id)
                            ->get() ;
                    ?>
                    <?php foreach ($color_8_column as $color_value): ?>

                        <?php if ($color_value->color_code != null): ?>
                                <!-- Single Radio Input-->
                                <div class="form-check mb-0">
                                  <input class="form-check-input" style="background-color:<?php echo $color_value->color_code; ?>" id="colorRadio<?php echo $color_value->id; ?>" type="radio" name="colorRadio" value="<?php echo $color_value->color_code; ?>" onclick="changemaincolorstatus(<?php echo $color_value->id; ?>)">
                                  <label class="form-check-label" for="colorRadio<?php echo $color_value->id; ?>"></label>
                                </div>
                              
                        <?php else: ?>
                            <div class="col-2 col-md-2 col-lg-4">
                                <div class="single-product-color">
                                    <img class="mb-1 color_image color_image_s_<?php echo $color_value->id; ?>"src="<?php echo $base_url."public/images/".$color_value->color_image; ?>" alt="" style="width:32px;cursor: pointer;" onclick="changecolorstatus(<?php echo $color_value->id; ?>)">
                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endforeach ?>
                    </div>
                </div>

            
                </div> 
            </div>
            <?php endif ?>
            <?php $size_count = DB::table('tbl_product_size')->where('product_id', $product->id)->count() ; ?>
            <?php if ($size_count > 0): ?>
                
            
            <div class="container mt-1">

                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6>Size</h6>
                </div>

                <div class="row g-1">
                    <?php
                        $size_8_column = DB::table('tbl_product_size')
                            ->join('tbl_size', 'tbl_product_size.size_id', '=', 'tbl_size.id')
                            ->select('tbl_product_size.*', 'tbl_size.size')
                            ->where('tbl_product_size.product_id', $product->id)
                            ->get() ;
                    ?>
                    <?php foreach ($size_8_column as $key => $sizevalue): ?>

                        <div class="col-3 col-md-2 col-lg-4">
                            <div class="single-product-color">
                                <input type="radio" id="size_id" name="size_id" value="{{ $sizevalue->size_id }}"> <span>{{ $sizevalue->size }}</span>
                            </div>
                        </div>

                    <?php endforeach ; ?>


                </div>

            </div>

            <?php endif ?>
        </div>

        <input type="hidden" name="color_id" class="color_id" value="0" >

        <div class="cart-form-wrapper bg-white mb-3 py-3">
            <div class="container">
                <form class="cart-form" action="#" method="">
                    <div class="order-plus-minus d-flex align-items-center">
                        <div class="quantity-button-handler">-</div>
                        <input class="form-control cart-quantity-input" type="text" step="1" name="quantity" value="1">
                        <div class="quantity-button-handler">+</div>
                    </div>
                    <button class="btn btn-danger ms-3" type="submit" id="addtocart">Add To Cart</button>
                </form>
            </div>
        </div>

        @php
            $supplir_info = DB::table('express')
                ->where('id', $product->supplier_id)
                ->first() ;
        @endphp
        @if($supplir_info->seller_type == 0)
        <div class="bg-white mb-3 py-3">
            <div class="container d-flex justify-content-between">
                
                <div class="p-title-price">

                    <h5 class="mb-1">{{ $supplir_info->storeName }}</h5>
                    <?php $supplier_chart = DB::table('tbl_countries')->where('id', $supplir_info->country)->first() ; ?>
                    <p><img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower($supplier_chart->countryCode).'.png'; ?>" width="24" height="18" alt=""> {{ $supplier_chart->countryCode }} <span style="background: #d1d1d1;color: #fff;border-radius: 5px;padding-left: 6px;padding-right: 6px;font-weight: bold;"><?php
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

                                ?> </span></p>
                    <p>{{ Str::limit($supplir_info->companyDetails, 100) }}</p>
                    {{--<div style="width:100%; <?php if($supplir_info->googleMapLocation != null){echo ""; }else{echo "display:none"; } ?>">
                        <iframe src="<?php echo $supplir_info->googleMapLocation; ?>" width="1000" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        
                    </div>--}}
                    <center><a class="custom-send-inquiry mb-2" href="{{ URL::to('m/'.strtolower($supplir_info->storeName)) }}" target="_parent" style="padding: 7px 30px;">Visit Store </a></center>
                </div>
                
            </div>
        </div>
        @endif
        
        <div class="cart-form-wrapper bg-white mb-3 py-3">
            <div class="container">
                
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
                <div style="width:100%; <?php if($supplir_info->googleMapLocation != null){echo ""; }else{echo "display:none"; } ?>">
                        <iframe src="<?php echo $supplir_info->googleMapLocation; ?>" width="370" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        
                    </div>
                
            </div>
        </div>
        
        <!-- Rating & Review Wrapper-->
        <div class="rating-and-review-wrapper bg-white py-3 mb-3">
          <div class="container">
            <h6>Ratings &amp; Reviews</h6>
            <div class="rating-review-content">
              <ul class="ps-0">
                <?php
                    $all_review_pa = DB::table('tbl_reviews')
                        ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
                        ->join('express', 'tbl_reviews.buyer_id', '=', 'express.id')
                        ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name','express.storeName', 'express.first_name', 'express.last_name', 'express.type', 'express.email as customeremail','express.image')
                        ->where('tbl_reviews.product_id', $product->id)
                        ->orderBy('tbl_reviews.id', 'desc')
                        ->where('tbl_reviews.status', 1)
                        ->limit(6)
                        ->get() ;
                ?>  
                 <?php foreach($all_review_pa as $reviewvalue): ?>
                 <?php $base_url = "https://availtrade.com/"; if($reviewvalue->image != "" || $reviewvalue->image != null){
                        if(strpos($reviewvalue->image, "https") !== false){
                           $image_url = $reviewvalue->image ;
                        } else{
                           $image_url = $base_url."public/images/".$reviewvalue->image;
                        }
                    }else{
                        $image_url = $base_url."public/images/Image 4.png";
                    } ?>
                    <li class="single-user-review d-flex">
                      <div class="user-thumbnail"><img src="<?php echo $image_url; ?>" alt=""></div>
                      <div class="rating-comment">
                          
                          <?php if($reviewvalue->review_star < 2): ?>
                                <div class="rating">
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star"></i>
                                    <i class="lni lni-star"></i>
                                    <i class="lni lni-star"></i>
                                    <i class="lni lni-star"></i>
                                </div>
                            <?php elseif($reviewvalue->review_star < 3): ?>
                                <div class="rating">
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star"></i>
                                    <i class="lni lni-star"></i>
                                    <i class="lni lni-star"></i>
                                </div>
                            <?php elseif($reviewvalue->review_star < 4): ?>
                                <div class="rating">
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star"></i>
                                    <i class="lni lni-star"></i>
                                </div>
                            <?php elseif($reviewvalue->review_star < 5): ?>
                                <div class="rating">
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star"></i>
                                </div>
                            <?php else: ?>
                                <div class="rating">
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                    <i class="lni lni-star-filled"></i>
                                </div>
                            <?php endif ?>

                        <p class="comment mb-0">{{ $reviewvalue->review_details }}</p><span class="name-date"></span> <?php echo date("d m y", strtotime($reviewvalue->created_at)); ?></span>
                      </div>
                    </li>
                <?php endforeach ?>
              </ul>
            </div>
          </div>
        </div>
        <?php if($main_login_id != $product->supplier_id): ?>
        <!-- Ratings Submit Form-->
        <div class="ratings-submit-form bg-white py-3">
          <div class="container">
            <h6>Submit A Review</h6>
            {!! Form::open(['id' =>'submitCustomerReview','method' => 'post','role' => 'form', 'files'=>'true']) !!}
              <div class="stars mb-3">
                <input class="star-1" type="radio" name="rating" value="1" id="star1">
                <label class="star-1" for="star1"></label>
                <input class="star-2" type="radio" name="rating" value="2" id="star2">
                <label class="star-2" for="star2"></label>
                <input class="star-3" type="radio" name="rating" value="3" id="star3">
                <label class="star-3" for="star3"></label>
                <input class="star-4" type="radio" name="rating" value="4" id="star4">
                <label class="star-4" for="star4"></label>
                <input class="star-5" type="radio" value="5" name="rating" id="star5">
                <label class="star-5" for="star5"></label><span></span>
              </div>
              <textarea class="form-control mb-3" name="review_message" cols="30" rows="10" data-max-length="200" placeholder="Write your review..."></textarea>
              <button class="btn btn-sm btn-primary" type="submit">Save Review</button>
            {!! Form::close() !!}
          </div>
        </div>
        <?php endif; ?>


        <div class="container mt-4">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6>Hot Selling</h6>
            </div>
            <div class="row g-3">

                <?php
                    $like_product = DB::table('tbl_product')
                        ->where('w_category_id', $product->w_category_id)
                        ->inRandomOrder()
                        ->limit(9)
                        ->where('status', 1)
                        ->get() ;
                ?>

                <?php

                    foreach($like_product as $likeproduct) :
                        $all_id[] = $likeproduct->id ;
                    ?>
                     <?php $just_for_image = explode("#", $likeproduct->products_image); ?>

                    <!-- Single Top Product Card-->
                    <div class="col-4 col-md-4 col-lg-3">
                        <div class="card top-product-card">
                            <div class="card-body mb-0 pb-0 mt-0 pt-3">
                                <a class="product-thumbnail d-block single-product-hot-selling" href="{{ URL::to('m/product/'.$likeproduct->slug) }}">
                                    <img class="mb-1" src="<?php echo $base_url."public/images/".$just_for_image[0]; ?>" alt="{{ $likeproduct->product_name }}" style="width: 62px!important;height: 62px!important;">
                                </a>
                                <?php
                                    $product_price_info = DB::table('tbl_product_price')
                                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                    ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                    ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                    ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                    ->where('tbl_product_price.product_id', $likeproduct->id)
                                    ->orderBy('tbl_product_price.product_price', 'asc')
                                    ->first() ;
                            
                                    $just_product_price__info = DB::table('tbl_product_price')
                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name')
                                        ->where('tbl_product_price.product_id', $likeproduct->id)
                                        ->orderBy('tbl_product_price.product_price', 'asc')
                                        ->first() ;

                                    $just_product_price_max_info = DB::table('tbl_product_price')
                                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit' , 'tbl_unit_price.unit_name')
                                        ->where('tbl_product_price.product_id', $likeproduct->id)
                                        ->orderBy('tbl_product_price.product_price', 'desc')
                                        ->first() ;

                                ?>
                                <br>

                                    <p class="mb-0" style="font-size: 12px;">
                                        <?php 
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
                                        </p>
                                
                                <p class="mb-0"><?php if($product_price_info->start_quantity > 0){echo $product_price_info->start_quantity;}else{echo "1"; } ?> {{ $product_price_info->unit_name }}</p>
                                <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $likeproduct->visitor_count }}</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach ; ?>

            </div>
        </div>

        <div class="container mt-4 pb-4">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6>Recommended from other supplier</h6>
            </div>
            <div class="row g-3">

                <?php
                $supplier_product = DB::table('tbl_product')
                    ->where('supplier_id', $product->supplier_id)
                    ->inRandomOrder()
                    ->limit(10)
                    ->where('status', 1)
                    ->get() ;
                ?>
                <?php foreach ($supplier_product as $supplier_value): ?>
                    <?php $supplier_product_image = explode("#", $supplier_value->products_image); ?>
                    <!-- Single Top Product Card-->
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card top-product-card">
                            <div class="card-body">
                                <a class="product-thumbnail d-block single-product-recommended" href="{{ URL::to('m/product/'.$supplier_value->slug) }}">
                                    <img class="mb-1" src="<?php echo $base_url."public/images/".$supplier_product_image[0]; ?>" alt="{{ $supplier_value->product_name }}">
                                </a>
                                <a class="product-title d-block" href="{{ URL::to('m/product/'.$supplier_value->slug) }}"><?php echo substr($supplier_value->product_name,0, 15); ?></a>
                                <?php
                                $just_product_price__info = DB::table('tbl_product_price')
                                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                    ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                    ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                    ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_currency_status.rate as currency_rate')
                                    ->where('tbl_product_price.product_id', $supplier_value->id)
                                    ->orderBy('tbl_product_price.product_price', 'asc')
                                    ->first() ;

                                $just_product_price_max_info = DB::table('tbl_product_price')
                                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                    ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                    ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                    ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit' , 'tbl_unit_price.unit_name')
                                    ->where('tbl_product_price.product_id', $supplier_value->id)
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

                            <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $supplier_value->visitor_count }}</p>

                            </div>
                        </div>
                    </div>

                <?php endforeach ?>


            </div>
        </div>
         <!-- The Modal -->
<div id="myModal" class="modal">
                  <?php
                    $unit = DB::table('tbl_unit_price')->first() ;
                ?>
  <!-- Modal content -->
  <div class="modal-content">

  </div>

</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{ $supplir_info->storeName }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          
        <?php
            $unit = DB::table('tbl_unit_price')->first() ;
        ?>
        {!! Form::open(['url' =>'m/sentQuery','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
          <div class="form-group">
            <label for="exampleInputEmail1">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" aria-describedby="emailHelp" placeholder="Enter Subject">
            
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Message</label>
            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
            
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Quantity</label>
            <input type="text" class="form-control" id="start_quantity" name="start_quantity" placeholder="quantity">
          </div>
          <div class="form-group">
            
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
            <select class="form-control" id="pcs" name="unit_name">
              <option value="{{ $unit->unit_name }}">{{ $unit->unit_name }}</option>
            </select>
          </div>
          <input type="hidden" name="product_slug" value="<?php echo $product->slug; ?>">
          <button type="submit" class="btn btn-primary">Submit</button>
        {!! Form::close() !!}

      </div>

    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="staticNumberdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticNumberdrop" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">{{ $supplir_info->mobile }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      </div>
  </div>
</div>

@endsection

@section('css')
<link rel="stylesheet" href="{{ URL::to('public/mobile/productdetails.css') }}">
@endsection

@section('js')
<script>
    $("#mobile_currency").change(function(){
        var mobile_currency = $(this).val() ;
        var main_link       = "<?php echo env('APP_URL'); ?>m/mobilechangeCurrency/"+mobile_currency;
        window.location     = main_link;
    });
</script>
<script >

    function changecolorstatus(color_id){
        $('.color_image').removeClass('active') ;
        $('.color_image_s_'+color_id).addClass('active') ;
        $('.color_id').val(color_id) ;
    }
    
    function changemaincolorstatus(color_id){
        console.log(color_id);
        $('.color_id').val(color_id) ;
    }
    
    

    $("#addtocart").click(function(e){
        e.preventDefault() ;

        var product_id          = <?php echo $product->id ; ?> ;
        var color_id            = $(".color_id").val() ;
        var size_id             = $("#size_id:checked").val() ;
        var quantity            = $("[name=quantity]").val() ;
        var product_color_is    = <?php echo $color_count; ?> ;
        var product_size_is     = <?php echo $size_count ;?> ;
        var session_id          = <?php if(Session::get('supplier_id') == null && Session::get('buyer_id') == null){ echo 0 ;}else{echo 1 ;} ?>;
        if(session_id == 0)
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
            'url':"{{ url('m/addtocart') }}",
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
                    toastr.success('Thanks !! Product Cart Successfully', 'Cart Success!!', { positionClass: 'toast-top-center', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 3000);
                }

            }
        });
    })
    
    function startordernow(event){
        event.preventDefault() ;
        
        var product_id          = <?php echo $product->id ; ?> ;
        var color_id            = $(".color_id").val() ;
        var size_id             = $("#size_id:checked").val() ;
        var quantity            = $("[name=quantity]").val() ;
        var product_color_is    = <?php echo $color_count; ?> ;
        var product_size_is     = <?php echo $size_count ;?> ;
        var session_id          = <?php if(Session::get('supplier_id') == null && Session::get('buyer_id') == null){ echo 0 ;}else{echo 1 ;} ?>;
        if(session_id == 0)
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
            'url':"{{ url('m/addtocart') }}",
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
                    setTimeout(function(){
                        location.href ='<?php echo env('APP_URL'); ?>m/cart' ;
                    }, 1000);
                }

            }
        });
    }
    

    $(function(){
	    $("#submitCustomerReview").on('submit',function(e){
    		e.preventDefault() ;
    
    		var rating      = $("[name=rating]:checked").val() ;
            var review      = $("[name=review_message]").val() ;
            
            var main_login_id = <?php echo $main_login_id ; ?> ;
    
            if(rating == ""){
                toastr.info('Oh shit!! Please Select Review Star', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
    
            if (review == "") {
                toastr.info('Oh shit!! Please Input Review Details', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
            
            if(main_login_id == 0){
                $siam_link      = "<?php echo env('APP_URL'); ?>m/signin";
                window.location = $siam_link;
                return false ;
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
            	data:{product_id:<?php echo $product->id ; ?>, rating:rating, review:review, main_login_id:<?php echo $main_login_id ; ?>},
            	success:function(data)
            	{
            		if(data == "success"){
            		    $('#submitCustomerReview')[0].reset();
            		    toastr.success('Thanks !! Review Submit Successfully Send', 'Review Success', { positionClass: 'toast-top-center toast-bottom-full-width', });
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
	    $("#submitMyMessage").on('submit',function(e){
    		e.preventDefault() ;
    
    		var product_id      = $("[name=rating]:checked").val() ;
            var supplier_id      = $("[name=review_message]").val() ;
            var subject       = $("[name=subject]").val() ;
            var message       = $("[name=message]").val() ;
            var quantity       = $("[name=quantity]").val() ;
            var pcs       = $("[name=pcs]").val() ;
            
            var main_login_id = <?php echo $main_login_id ; ?> ;
    
            if(subject == ""){
                toastr.info('Oh shit!! Please input Subject', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
    
            if (message == "") {
                toastr.info('Oh shit!! Please Input Message Details', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
            
            if(main_login_id == 0){
                $siam_link      = "<?php echo env('APP_URL'); ?>m/signin";
                window.location = $siam_link;
                return false ;
            }
        
            $.ajaxSetup({
            	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
        
            $.ajax({
            	'url':"{{ url('/sentQuery') }}",
            	'type':'post',
            	'dataType':'text',
            	data:{product_id:<?php echo $product->id ; ?>, rating:rating, review:review, main_login_id:<?php echo $main_login_id ; ?>},
            	success:function(data)
            	{
            		if(data == "success"){
            		    $('#submitCustomerReview')[0].reset();
            		    toastr.success('Thanks !! Review Submit Successfully Send', 'Review Success', { positionClass: 'toast-top-center toast-bottom-full-width', });
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
// 	 $("#sendSupplierQuotationlogin").submit(function(e){
//         e.preventDefault() ;
//         var senderid = <?php echo $main_login_id; ?>;
//         if(senderid == 0){
//             $("#login_modal").modal('show');
//             return false ;
//         }
//     });


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
<script>

    $("#myBtn").click(function(e){
        e.preventDefault() ;
        $("#staticBackdrop").modal('show');
    })
    
</script>

<script>

    $("#myBtnModal").click(function(e){
        e.preventDefault() ;
        $("#staticNumberdrop").modal('show');
    })
    
</script>

@endsection
