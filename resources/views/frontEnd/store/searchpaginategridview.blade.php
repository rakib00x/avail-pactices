<?php 
    foreach($just_for_you as $justvalue) :
 ?>

<div class="column is-one-quarter mt-4 ml-2 m-0 pt-0 box" style="width: 24% !important;">


    <a href="{{ URL::to('product/'.$justvalue->slug)}}" title="" style="color:black">
        <?php $justvalueimage = explode("#", $justvalue->products_image); ?>
        <img src="{{ URL::to('public/images/'.$justvalueimage[0]) }}" alt="" style="width: 100%;height:255px;margin-top: 10px;">
        <h2 style="font-size: 16px;font-weight: normal;">{{ Str::limit($justvalue->product_name, 20) }}</h2>
        <p style="text-align:left;font-family:'SolaimanLipi';">
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
							<?php echo $currency_code2." ".number_format($now_product_price_is2, 2) ; ?>
						<?php endif ?>
					</b><br/>
				<?php else: ?>
					@php
						$minimum_order = DB::table('tbl_product_price')
                            ->where('product_id', $justvalue->id)
                            ->orderBy('tbl_product_price.start_quantity', 'asc')
                            ->first() ;
					@endphp
					<b><?php echo $currency_code2; ?> {{ number_format($now_product_price_is2, 2) }} - {{ number_format($now_product_price_is_max, 2) }}</b><br/>
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


    <nav class="mt-2">
        <label><a class="product-contact-supplier" href="#" onclick="sendquotationinfo(<?php echo $store_info->id; ?>, '<?php echo $store_info->storeName;  ?>')">Contact Supplier</a></label>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <label><a href="#"><img src="images/chat.png" alt=""></a></label>
    </nav>
    <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $justvalue->visitor_count }}</p>
</div>
<?php endforeach ?>