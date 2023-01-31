<?php foreach ($all_product as $key => $justvalue): ?>
    <div class="sonia box mr-2 p-2" style="border-bottom-left-radius: 6px !important;max-width: 225px;max-height: 400px;">
        <a href="{{ URL::to('product/'.$justvalue->slug)}}" title="" style="color:black!important">
            <?php $first_image_explode = explode("#", $justvalue->products_image); ?>
            <img style="width:209px !important;height:209px;;border-top-left-radius: 6px;border-top-right-radius: 6px;" src="{{ URL::to('public/images/'.$first_image_explode[0]) }}" alt="{{ $justvalue->product_name }}" />
            <p class="pt-2 pb-2">{{ Str::limit($justvalue->product_name, 20) }}</p>
            <p class="pt-2 pb-2" style="text-align:left;font-family:'SolaimanLipi';">
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
				 <?php endif ?> Pieces (Min. Order)
            </p>
        </a>
        <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $justvalue->visitor_count }}</p>
    </div>
<?php endforeach ?>

<?php if(count($all_product) == 0): ?>
    <center><h2 style="font-size:20px; font-weight:bold; color:red">Product not available</h2></center>
<?php endif ?>