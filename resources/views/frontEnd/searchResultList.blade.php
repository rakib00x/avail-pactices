<?php foreach ($productSearch as $product): ?>

    <div class="product product-list-wrapper row" style="margin-bottom:20px;">
        <figure class="product-image-container col-lg-2 col-md-2 col-sm-12">

            <a target="_blank" href="{{ URL::to('product/'.$product->slug)}}" rel="noopener">
                <?php $image_explode = explode("#", $product->products_image); ?>
                <img src="{{ URL::to('public/images/'.$image_explode[0])}}" height="150" width="150" alt="{{$product->slug}}">
            </a>

            @if ($product->price_type == "2")
                @php
                date_default_timezone_set('Asia/Dhaka') ;
                $today_date = date("Y-m-d H:i:s") ;

                $discount_count_2 = DB::table('tbl_product')
                    ->where('offer_start', '<=', $today_date)
                    ->where('offer_end', '>=', $today_date)
                    ->where('id', $product->id)
                    ->count() ;
                    
                if($discount_count_2 > 0):
                @endphp
                    @php
                        $price_info_discount = DB::table('tbl_product_price')
                        ->where('product_id', $product->id)
                        ->where('supplier_id', $product->supplier_id)
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
                        
            @endif
        </figure>
        <div class="product-details col-lg-10 col-md-10 col-sm-12">
            <h2 class="product-title">
                <a href="{{ URL::to('product/'.$product->slug)}}">{{ Str::limit($product->product_name , 100)}}</a>
            </h2>
            <div class="price-box">
                <?php $supplier_info = DB::table('express')->where('id', $product->supplier_id)->first(); ?>
                <?php $country = DB::table('tbl_countries')->where('id', $supplier_info->country)->first() ;
                            $country_code = strtolower($country->countryCode);
                         ?>

                <div class="row">
                    <div class="col-md-8">
                        <table class="price_table">
                            <tr>
                                <td><a href="{{ url('supplier/supplierWeb/'.strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-',$supplier_info->storeName))) }}" title=""><?php echo $supplier_info->storeName; ?></a> <img style="display:inline-block!important" src="https://www.countryflags.io/<?php echo $country_code; ?>/flat/64.png" height="20" width="20"> <?php echo $country->countryName; ?> <?php if($supplier_info->profile_verify_status == 1){echo "<span style='color:green'>Verified</span>"; }else{echo "";} ?></td>
                            </tr>
                            <tr>
                                <td class="btn_siam"> <a href="#" title="" class="contact_supplierbtn">Contact Supplier</a></td>
                                <td><a href="#" class="btn_chat" title="Chat Now!">Chat Now!</a></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <table class="price_table" style="width: 100%;">
                            <tr>
                                <td style="text-align:right">
                            @if ($product->price_type == "4" || $product->price_type == "1")

                                    @php
                                        $product_price_section_2 = DB::table('tbl_product_price')
                                        ->where('product_id', $product->id)
                                        ->where('supplier_id', $product->supplier_id)
                                        ->where('status', 1)
                                        ->count() ;
                                    @endphp
                                    <?php if($product_price_section_2 > 0): ?>
                                        <span class="product-price">
                                            @php
                                                $small_price_1 = DB::table('tbl_product_price')
                                                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                                                    ->select('tbl_product_price.*', 'tbl_currency_status.symbol', 'tbl_currency_status.rate')
                                                    ->where('tbl_product_price.product_id', $product->id)
                                                    ->where('tbl_product_price.supplier_id', $product->supplier_id)
                                                    ->where('tbl_product_price.status', 1)
                                                    ->orderBy('product_price','asc')
                                                    ->first();

                                                $bigger_price_2 = DB::table('tbl_product_price')
                                                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                                                    ->select('tbl_product_price.*', 'tbl_currency_status.symbol', 'tbl_currency_status.rate')
                                                    ->where('tbl_product_price.product_id', $product->id)
                                                    ->where('tbl_product_price.supplier_id', $product->supplier_id)
                                                    ->where('tbl_product_price.status', 1)
                                                    ->orderBy('product_price','desc')
                                                    ->first();
                                            @endphp
                                            <?php
                                                $recent_rate        = $bigger_price_2->rate;
                                                $requestedCurrency  = Session::get('requestedCurrency');

                                                if($requestedCurrency == NULL){
                                                    echo $bigger_price_2->symbol;
                                                    echo $small_price_1->product_price."-".$bigger_price_2->product_price;
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
                                        ->where('product_id', $product->id)
                                        ->where('supplier_id', $product->supplier_id)
                                        ->where('status', 1)
                                        ->count() ;
                                    @endphp
                                    <?php if($product_price_section2 > 0): ?>
                                        <?php
                                            $price_value2 = DB::table('tbl_product_price')
                                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                                            ->select('tbl_product_price.*', 'tbl_currency_status.symbol', 'tbl_currency_status.rate')
                                            ->where('tbl_product_price.product_id', $product->id)
                                            ->where('tbl_product_price.supplier_id', $product->supplier_id)
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
                                            ->where('id', $product->id)
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



                            </td>
                            </tr>
                        </table>
                    </div>
                </div>

            </div><!-- End .price-box -->

        </div><!-- End .product-details -->
    </div><!-- End .product -->

<?php endforeach ?>


<ul class="pagination">
    {!! $productSearch->links() !!}
</ul>
