
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
@foreach($productSearch as $searchvalue)
    <!-- Start of Products -->
    <div class="columns ml-5 mt-0 mb-5 mr-0 box mb-2">
        
        <div class="column is-one-quarter mb-0 pb-0">
            <a href="{{ URL::to('product/'.$searchvalue->slug)}}" title="">
                <?php $second_image_explode_3 = explode("#", $searchvalue->products_image); ?>
                <img src="{{ URL::to('public/images/'.$second_image_explode_3[0]) }}" alt="" style="width: 100%;height:255px;" >
            </a>
        </div>
        <div class="column auto mt-0 pt-0">
            <a href="{{ URL::to('product/'.$searchvalue->slug)}}" title="" style="color:black!important">
            <h2 style="font-size: 20px;font-weight: bold;">{{ $searchvalue->product_name  }} {{ $searchvalue->w_category_id }}</h2>
            <?php $minimum_quantity = DB::table('tbl_product_price')->where('product_id', $searchvalue->id)->min('start_quantity'); ?>
            <p style="border-bottom: 1px solid #dae2ed; padding-top: 10px; padding-bottom: 10px;"><?php if ($minimum_quantity == 0){echo "1"; }else{echo $minimum_quantity; } ?>Qty (Min. Order)</p>
            <nav class="mt-1 pt-1 mb-2" >
                <label><p>
                    @php
                        $supplier_info = DB::table('express')
                            ->join('tbl_countries', 'express.country', '=', 'tbl_countries.id')
                            ->select('express.*', 'tbl_countries.countryCode')
                            ->where('express.id', $searchvalue->supplier_id)
                            ->first(); 
                        echo $supplier_info->storeName ;
                     @endphp
                 </p></label>
            
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
                    <?php
                    $product_review_person = DB::table('tbl_reviews')->where('product_id',$searchvalue->id)->where('status', 1)->count() ;
                    $a  = DB::table('tbl_reviews')
                        ->where('status', 1)
                        ->where('product_id',$searchvalue->id)
                        ->where('review_star', 1)
                        ->count() ;
                    $b  = DB::table('tbl_reviews')
                        ->where('status', 1)
                        ->where('product_id',$searchvalue->id)
                        ->where('review_star', 2)
                        ->count() ;
                    $c  = DB::table('tbl_reviews')
                        ->where('status', 1)
                        ->where('product_id',$searchvalue->id)
                        ->where('review_star', 3)
                        ->count() ;
                    $d  = DB::table('tbl_reviews')
                        ->where('status', 1)
                        ->where('product_id',$searchvalue->id)
                        ->where('review_star', 4)
                        ->count() ;

                    $e  = DB::table('tbl_reviews')
                        ->where('status', 1)
                        ->where('product_id',$searchvalue->id)
                        ->where('review_star', 5)
                        ->count() ;

                    if ($product_review_person > 0) {
                        $total_percentage = ($product_review_person*5) * ($a+$b+$c+$d+$e) ;
                    }else{
                        $total_percentage = 0 ;
                    }
                 ?>
                    <td><p>US $110,000+in 67 Transaction(s)</p></td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td><p><?php echo $total_percentage ; ?> <img src="{{ URL::to('public/frontEnd/images/star.jpg') }}"> (<?php echo $product_review_person ; ?>)</p></td>
                </tr>
            </table>
            </a>

            <nav class="mt-5 pt-5">
                <label><a class="product-contact-supplier" href="#" onclick="sendquotationinfo(<?php echo $searchvalue->supplier_id; ?>, '<?php echo $supplier_info->storeName;  ?>', '<?php echo $searchvalue->id;  ?>')"> Contact Supplier</a></label>
                <label>&nbsp;</label>
                <label></label>
            </nav>

        </div>
        <div class="column is-3 mt-0 pt-0">
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

                }else{
                    $currency_code2             = $product_price_info2->code;
                    $now_product_price_is2      = $product_price_info2->product_price;
                    $now_product_price_is_max   = $product_price_info3->product_price;
                }
            ?>
           <?php if($product_price_info2): ?>
                <?php if($now_product_price_is2 > 0): ?>
                    <h2 style="text-align: right;font-size: 18px;font-weight: bold;font-family:'SolaimanLipi';"><?php echo $currency_code2." ".number_format($now_product_price_is2, 2) ; ?><?php if ($now_product_price_is2 != $now_product_price_is_max){echo "-". number_format($now_product_price_is_max,2); } ?><span style="font-size: 12px;color: #888888;">/ {{ $product_price_info2->unit_name }}</span></h2>
                <?php else: ?>
                    <h2 style="text-align: right;font-size: 18px;font-weight: bold;font-family:'SolaimanLipi';">Negotiation<span style="font-size: 12px;color: #888888;">/ {{ $product_price_info2->unit_name }}</span></h2>
                <?php endif; ?>
            <?php endif; ?>
            
            <p style="padding-top:176px;float:right !important;"><a href="#" onclick="chatshowpage({{ $searchvalue->id }}, {{ $searchvalue->supplier_id }},<?php echo $main_login_id; ?>, '<?php echo $supplier_info->storeName;  ?>')"><img src="{{ URL::to('public/frontEnd/images/chat.png') }}" alt=""> Chat Now</a></p>
            
        </div>
        
    </div>
      
    @endforeach