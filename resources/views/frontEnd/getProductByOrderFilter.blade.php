                        @foreach($productSearch as $searchvalue)
                        <!-- Start of Products -->
                        <div class="columns ml-5 mt-0 mr-0 box mb-2">
                            <div class="column is-one-quarter mb-0 pb-0">
                                <?php $second_image_explode_3 = explode("#", $searchvalue->products_image); ?>
                                <img src="{{ URL::to('public/images/'.$second_image_explode_3[0]) }}" alt="" style="width: 100%;height:255px;" >
                            </div>
                            <div class="column auto mt-0 pt-0">
                                <h2 style="font-size: 20px;font-weight: bold;">{{ $searchvalue->product_name  }}</h2>
                                <?php $minimum_quantity = DB::table('tbl_product_price')->where('product_id', $searchvalue->id)->min('start_quantity'); ?>
                                <p style="border-bottom: 1px solid #dae2ed; padding-top: 10px; padding-bottom: 10px;"><?php if ($minimum_quantity == 0){echo "1"; }else{echo $minimum_quantity; } ?>Qty (Min. Order)</p>
                                <nav class="mt-1 pt-1 mb-2">
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
                                    <label><span><img src="images/assurance.png" alt=""></span> @php echo $supplier_info->countryCode; @endphp<span>10 YRS</span></label>
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

                                <nav>
                                    <label><a class="product-contact-supplier" href="#">Contact Supplier</a></label>
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <label><a href="#"><img src="{{ URL::to('public/frontEnd/images/chat.png') }}" alt=""> Chat Now</a></label>
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
                                <h2 style="text-align: right;font-size: 18px;font-weight: bold;">$<?php echo number_format($min_price, 2); ?><?php if ($min_price != $max_price){echo "-". number_format($max_price); } ?><span style="font-size: 12px;color: #888888;">/ Set</span></h2>
                            </div>
                        </div>
                        @endforeach