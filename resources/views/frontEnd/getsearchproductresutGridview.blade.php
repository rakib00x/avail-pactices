@foreach($productSearch as $searchvalue)
<div class="column is-one-quarter mt-4 ml-2 m-0 pt-0 box" style="width: 24% !important;">
    <a href="{{ URL::to('product/'.$searchvalue->slug)}}" title="" style="color:black">
        <?php $second_image_explode_3 = explode("#", $searchvalue->products_image); ?>
        <img src="{{ URL::to('public/images/'.$second_image_explode_3[0]) }}" alt="" style="width: 100%;height:255px;margin-top: 10px;">

        <h2 style="font-size: 16px;font-weight: normal;">{{ Str::limit($searchvalue->product_name, 20) }}</h2>
        
        <?php
            $min_price = DB::table('tbl_product_price')
                ->where('product_id', $searchvalue->id)
                ->min('product_price') ;

            $max_price = DB::table('tbl_product_price')
                ->where('product_id', $searchvalue->id)
                ->min('product_price') ;
         ?>
         
         <?php
            $product_price_info2 = DB::table('tbl_product_price')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                ->where('tbl_product_price.product_id', $searchvalue->id)
                ->orderBy('tbl_product_price.product_price', 'asc')
                ->first() ;
                
            $product_price_info3 = DB::table('tbl_product_price')
                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                ->where('tbl_product_price.product_id', $searchvalue->id)
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

        <h2 style="font-family:'SolaimanLipi';"><b><?php echo $currency_code2." ".number_format($now_product_price_is2, 2) ; ?><?php if ($now_product_price_is2 != $now_product_price_is_max){echo "-". number_format($now_product_price_is_max,2); } ?> / {{ $product_price_info2->unit_name }}</b></h2>

        <p style="border-bottom: 1px solid #dae2ed; padding-top: 10px; padding-bottom: 10px;">
        <?php if ($product_price_info2->price_status == 1): ?>
             @php
                echo $product_price_info2->start_quantity ;
            @endphp
        <?php else: ?>
        1
        <?php endif ?>
        {{ $product_price_info2->unit_name }}(Min. Order)
        </p>
        
    </a>

    <nav class="mt-1 pt-1 mb-2">
        @php
                $supplier_info = DB::table('express')
                    ->join('tbl_countries', 'express.country', '=', 'tbl_countries.id')
                    ->select('express.*', 'tbl_countries.countryCode')
                    ->where('express.id', $searchvalue->supplier_id)
                    ->first();

             @endphp
        <label><p>{{ $supplier_info->storeName  }}</p></label>
        <label><span><img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower($supplier_info->countryCode).'.png'; ?>" alt="" style="width:25px;height:20px;"></span> {{ $supplier_info->countryCode }} <span><?php
									$created_at = date("d M Y", strtotime($supplier_info->created_at)) ;
									$today_date = date("d M Y");
									$datetime1 = new DateTime("$created_at");
									$datetime2 = new DateTime($today_date);
									$interval = $datetime1->diff($datetime2);
									
									if($interval->format('%y') == 0){
									    echo $interval->format('%m M, %d D');
									}else{
									    echo $interval->format('%y Y, %m M');
									}
 								?></span></label>
        <label><img src="images/verified.png" alt=""><img src="images/assurance.png" alt=""><img src="images/assurance.png" alt=""><img src="images/crown.jpg" alt=""><img src="images/crown.jpg" alt=""><img src="images/crown.jpg" alt=""></label>
    </nav>

    <nav>
        <label><a class="product-contact-supplier" href="#" onclick="sendquotationinfo(<?php echo $searchvalue->supplier_id; ?>, '<?php echo $supplier_info->storeName;  ?>', '<?php echo $searchvalue->id;  ?>')">Contact Supplier</a></label>
        <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
        <label><a href="#"><img src="images/chat.png" alt=""></a></label>
    </nav>
    <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $searchvalue->visitor_count }}</p>
</div>
@endforeach