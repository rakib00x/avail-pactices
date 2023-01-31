<?php 
    foreach($just_for_you as $justvalue) :
?>

<!-- Start of Products -->
<div class="columns ml-2 mt-0 mb-5 mr-0 box mb-2">
        <div class="column is-one-quarter mb-0 pb-0">
            <a href="{{ URL::to('product/'.$justvalue->slug)}}" title="">
                 <?php $justvalueimage = explode("#", $justvalue->products_image); ?>
                <img src="{{ URL::to('public/images/'.$justvalueimage[0]) }}" alt="" style="width: 100%;height:255px;" >
            </a>
        </div>
        <div class="column auto mt-0 pt-0">
            @php
                    $price_count = DB::table('tbl_product_price')
                        ->where('product_id', $justvalue->id)
                        ->count() ;

                    $price_info = DB::table('tbl_product_price')
                                ->where('product_id', $justvalue->id)
                                ->first() ;

                    $minimum_order = DB::table('tbl_product_price')
                                ->where('product_id', $justvalue->id)
                                ->orderBy('tbl_product_price.start_quantity', 'asc')
                                ->first() ;
                @endphp
               
            <a href="#" title="" style="color:black!important">
            <h2 style="font-size: 20px;font-weight: bold;">{{ Str::limit($justvalue->product_name, 20) }}</h2>

            <p style="border-bottom: 1px solid #dae2ed; padding-top: 10px; padding-bottom: 10px;"><?php if ($minimum_order->price_status == 1): ?>
                @php
                    echo $minimum_order->start_quantity ;
                @endphp
                <?php else: ?>
                1
                <?php endif ?>  Qty (Min. Order)</p>
            <nav class="mt-1 pt-1 mb-2">
                @php
                    $supplier_info = DB::table('express')
                        ->join('tbl_countries', 'express.country', '=', 'tbl_countries.id')
                        ->select('express.*', 'tbl_countries.countryCode')
                        ->where('express.id', $justvalue->supplier_id)
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
            <table class="mb-2">
                <tr>
                    <td><p>US $110,000+in 67 Transaction(s)</p></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><p>75 <img src="{{ URL::to('public/frontEnd/images/star.jpg') }}"> (25)</p></td>
                </tr>
            </table>
            </a>
            <nav>
                <label><a class="product-contact-supplier" href="#">Contact Supplier</a></label>
                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                <label><a href="#"><img src="{{ URL::to('public/frontEnd/images/chat.png') }}" alt=""> Chat Now</a></label>
            </nav>
        </div>
        <div class="column is-3 mt-0 pt-0">
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
            <h2 style="text-align: right;font-size: 18px;font-weight: bold;font-family:'SolaimanLipi';"> <?php if ($price_count == 1): ?>
                    
                <b>
                    <?php if ($price_info->price_status == 3): ?>
                        Negotiate
                    <?php else: ?>
                        @if($product_price_info2)
                        <?php echo $currency_code2." ".number_format($now_product_price_is2, 2) ; ?>
                        @endif
                    <?php endif ?>
                </b>
                <?php else: ?>
                @php
                    $max_price = DB::table('tbl_product_price')
                        ->where('product_id', $justvalue->id)
                        ->max('product_price') ;

                    $min_price = DB::table('tbl_product_price')
                        ->where('product_id', $justvalue->id)
                        ->min('product_price') ;
                @endphp
                @if($product_price_info2)
                <b><?php echo $currency_code2; ?> {{ number_format($now_product_price_is2, 2) }} - {{ number_format($now_product_price_is_max, 2) }}</b>
                @endif
                <?php endif ?><span style="font-size: 12px;color: #888888;">/ {{ $product_price_info2->unit_name }} </span></h2>
        </div>
</div>

<?php endforeach ?>