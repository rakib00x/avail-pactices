<?php foreach($just_for_you as $justvalue) : ?>
    <?php $just_for_image = explode("#", $justvalue->products_image); ?>
    <!-- Single Top Product Card-->
    <div class="col-6 col-md-4 col-lg-3">
        <div class="card top-product-card">
            <div class="card-body mb-0 pb-0 mt-0 pt-3">
                <a class="product-thumbnail d-block single-product-recommended" href="<?php echo "http://m.availtrade.com/product/".$justvalue->slug ; ?>">
                    <img class="mb-2" src="{{ URL::to('public/images/'.$just_for_image[0]) }}" alt="" style="width: 155px;height: 155px;">
                </a>
                <a class="product-title d-block" href="<?php echo "http://m.availtrade.com/product/".$justvalue->slug ; ?>"><?php echo substr($justvalue->product_name,0, 15); ?></a>
                <?php
                    $product_price_info = DB::table('tbl_product_price')
                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                        ->where('product_id', $justvalue->product_id)
                        ->orderBy('product_price', 'asc')
                        ->first() ;

                    $product_price_max_info = DB::table('tbl_product_price')
                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                        ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                        ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                        ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit' , 'tbl_unit_price.unit_name','tbl_currency_status.rate as currency_rate')
                        ->where('product_id', $justvalue->product_id)
                        ->orderBy('product_price', 'desc')
                        ->first() ;

                ?>
                
                <p class="mb-0"><?php 
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
                    
                ?></p>
                <p class="text-right mb-0" style="float:right"><i class="fas fa-eye"></i> {{ $justvalue->visitor_count }}</p>
            </div>
        </div>
    </div>
<?php endforeach ; ?>