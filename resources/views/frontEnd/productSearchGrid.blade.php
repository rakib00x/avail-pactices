@extends('frontEnd.master')
@section('title')
    @if(Session::get('keywords') != "")
    <?php echo Session::get('keywords'); ?>
    @else
        Search Result
    @endif
@endsection
<?php
    $meta_info 	= DB::table('tbl_meta_tags')->first();
	$settings 	= DB::table('tbl_logo_settings')->where('status', 1)->first();
?>
@section('meta_info')

    <meta name="title" content="{{ $meta_info->meta_title }}">
    <meta name="description" content="{{ $meta_info->meta_details }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ URL::full() }}">
    <meta property="og:title" content="{{ $meta_info->meta_title }}">
    <meta property="og:description" content="{{ $meta_info->meta_details }}">
    <meta property="og:image" content="{{ URL::to('public/images/'.$settings->logo) }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ URL::full() }}">
    <meta property="twitter:title" content="{{ $meta_info->meta_title }}">
    <meta property="twitter:description" content="{{ $meta_info->meta_details }}">
    <meta property="twitter:image" content="{{ URL::to('public/images/'.$settings->logo) }}">

@endsection

@section('content')
<style>
    .active{
        background-color: green;
        color: white;
    }

    .active:hover{
        color: white!important;
    }
</style>
    <div class="container mt-5">
            <div class="columns">
                <div class="column">
                    <?php if ($serach_banner): ?>
                        <img src="{{ URL::to('public/images') }}/{{ $serach_banner->image }}" alt="" style="height:136px!important;width:100%">
                    <?php endif ?>
                </div>
            </div>
            <div class="columns is-gapless">
                <div class="column is-one-fifth box mr-3">
                    <div class="columns pl-5 pt-5 pr-5">
                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">CATEGORIES</h2>
                            @foreach($all_catgeorys as $category)
                                <p><a href="{{ URL::to('category/'.$category->catgeory_slug) }}/heightolow" title="{{ $category->category_name }}" style="color:black ;">{{ $category->category_name }}</a></p>
                            @endforeach
                        </div>
                    </div>
                    <div class="columns pl-5 pr-5">
                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">Supplier Types</h2>
                            <ul>
                                <li><input type="checkbox"> <img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/> Trade Assurance</li>
                                <li><input type="checkbox"> <img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/> Trade Assurance</li>
                                <li><input type="checkbox"> <img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/> Trade Assurance</li>
                            </ul>
                        </div>
                    </div>

                    <div class="columns pl-5 pr-5">
                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">Product Types</h2>
                            <ul>
                                <li><input type="checkbox"> Ready to Ship</li>
                                <li><input type="checkbox"> paid Samples</li>
                            </ul>
                        </div>
                    </div>
                    <div class="columns pl-5">

                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">Min. Order</h2>
                            <nav>
                                <label><input type="text" name="min_order"></label>
                                <label><button onclick="min_order_product_filter(event)"><i class="fas fa-search-plus"></i></button></label>
                            </nav>
                        </div>
                    </div>
                    <div class="columns pl-5 pr-5">
                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">Price</h2>
                            <nav>
                                <label><input name="minmaxinput" class="mininput" type="text" placeholder="min"></label>
                                <label>-</label>
                                <label><input name="minmaxinput" class="maxinput" type="text" placeholder="max"></label>
                                <label><button onclick="min_max_between_product_filter(event)"><i class="fas fa-search-plus"></i></button></label>
                            </nav>
                        </div>
                    </div>
                    <div class="columns pl-5 pr-5">
                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">Supplier Country/Region</h2>
                            <nav>
                                <label><input type="text"   placeholder="search"></label>
                                <label><button><i class="fas fa-search-plus"></i></button></label>
                            </nav>
                            <p>Sugessions</p>
                            <ul class="markets">
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> France</li>
                            </ul>
                        </div>
                    </div>

                    <div class="columns pl-5 pr-5">
                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">Past Export Country/Reg</h2>
                            <nav>
                                <label><input type="text" placeholder="search"></label>
                                <label><button><i class="fas fa-search-plus"></i></button></label>
                            </nav>
                            <p>Sugessions</p>
                            <div class="markets">
                                <ul>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> ISO(4458)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> ISO(4458)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> ISO(4458)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> ISO(4458)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> ISO(4458)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> ISO(4458)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> ISO(4458)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> ISO(4458)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                    <li><input type="checkbox"> <img src="images/assurance.png" alt=""> BSCI(628)</li>
                                </ul>
                                <p>*Certification Disclaimer: Any assessment, certification, inspection and/or related examination related to any authenticity of certificates are provided or conducted by independent third parties with no involvement from Alibaba.com.</p>
                                <p>Learn More</p>
                            </div>
                        </div>
                    </div>

                    <div class="columns pl-5 pb-5 pr-5">
                        <div class="column">
                            <h2 style="font-size: 16px;font-weight: bold;padding-bottom: 7px;">Product Certification</h2>
                            <nav>
                                <label><input type="text" placeholder="search"></label>
                                <label><button><i class="fas fa-search-plus"></i></button></label>
                            </nav>
                            <p>Sugessions</p>
                            <ul class="markets">
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CE(2159)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> SAA(198)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CCC(147)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CB(146)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CE(2159)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> SAA(198)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CCC(147)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CB(146)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CE(2159)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> SAA(198)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CCC(147)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CB(146)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CE(2159)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> SAA(198)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CCC(147)</li>
                                <li><input type="checkbox"> <img src="images/assurance.png" alt=""> CB(146)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="column auto">

                    <div class="columns ml-5 mt-0 mr-0 box" style="background: #ffffff;">

                        <?php foreach ($category_wise_product as $key => $catprovalue): ?>
                            <div class="column mr-0 pr-0">
                                <?php $second_image_explode_c = explode("#", $catprovalue->products_image); ?>
                                <a href="{{ URL::to('product/'.$catprovalue->slug)}}" title="" style="color:black">
                                    <img src="{{ URL::to('public/images/'.$second_image_explode_c[0]) }}" alt="{{ $catprovalue->product_name }}" style="width:85px; height:85px; ">
                                    <p>{{ Str::limit($catprovalue->product_name, 10) }}</p>
                                </a>
                            </div>
                        <?php endforeach ?>

                    </div>

                    <div class="columns ml-3 mt-0 mr-0">

                        <div class="column mr-0 pr-0">


                            <table>
                                <tr>
                                    <td>
                                        {!! Form::open(['url' =>'search','method' => 'get','role' => 'form', 'files'=>'true']) !!}

                                            <input class="input" type="hidden" name="search_type" value="<?php if(Session::has('search_type')){ if(Session::get('search_type') == "product"){echo "product"; }else{echo "supplier"; } } ?>">
                                            <input class="input" type="hidden" name="keywords" placeholder="What are you looking for..." value="<?php if(Session::has('keywords')){echo Session::get('keywords'); } ?>">
                                            <input type="hidden" name="viewType" value="L">
                                            <button class="button <?php if($type=="L"){echo "active";}else{echo ""; } ?>" type="submit">
                                                <i class="fas fa-th-list"></i></button>
                                        {!! Form::close() !!}
                                    </td>

                                    <td style="padding:0px 5px;">
                                        {!! Form::open(['url' =>'search','method' => 'get','role' => 'form', 'files'=>'true']) !!}
                                            <input class="input" type="hidden" name="search_type" value="<?php if(Session::has('search_type')){ if(Session::get('search_type') == "product"){echo "product"; }else{echo "supplier"; } } ?>">
                                            <input class="input" type="hidden" name="keywords" placeholder="What are you looking for..." value="<?php if(Session::has('keywords')){echo Session::get('keywords'); } ?>">
                                            <input type="hidden" name="viewType" value="G">
                                            <button class="button <?php if($type=="G"){echo "active";}else{echo ""; } ?>" type="submit" >
                                                    <i class="fas fa-th-large"></i></button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            </table>


                        </div>


                    </div>


                     <!-- Start of Products -->
                    <div class="columns is-full ml-5 mt-0 mr-0 is-multiline mb-5" id="product_data">

                        @foreach($productSearch as $searchvalue)
                        <div class="column is-one-quarter mt-4 ml-2 m-0 pt-0 box" style="width: 24% !important;">
                            <a href="{{ URL::to('product/'.$searchvalue->slug)}}" title="" style="color:black">
                                <?php $second_image_explode_3 = explode("#", $searchvalue->products_image); ?>
                                <img src="{{ URL::to('public/images/'.$second_image_explode_3[0]) }}" alt="{{ $searchvalue->product_name }}" style="width: 100%;height:255px;margin-top: 10px;">

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

                                    }else{
                                        $currency_code2             = $product_price_info2->code;
                                        $now_product_price_is2      = $product_price_info2->product_price;
                                        $now_product_price_is_max   = $product_price_info3->product_price;
                                    }
                                ?>
                                
                                <?php if($now_product_price_is2 > 0): ?>
                                <h2 style="font-family:'SolaimanLipi';"><b><?php echo $currency_code2." ".number_format($now_product_price_is2, 2) ; ?><?php if ($now_product_price_is2 != $now_product_price_is_max){echo "-". number_format($now_product_price_is_max,2); } ?> / {{ $product_price_info2->unit_name }}</b></h2>
                                <?php else: ?>
                                <h2 style="font-family:'SolaimanLipi';"><b>Negotiation / {{ $product_price_info2->unit_name }}</b></h2>
                                <?php endif; ?>
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

                    
                    </div>
                    <div class="columns is-full mb-5">
                        <div class="column" style="margin-left: 24px;">
                            
                            {{ $productSearch->appends(['search_type' => Session::get('search_type'), 'keywrods' => $search , 'viewType' => Session::get('viewtype')])->render('frontEnd.store.customPaginate') }}
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>

@endsection
@section('js')
<script>
    function min_order_product_filter(event){
        event.preventDefault() ;

        let min_order = $("[name=min_order]").val() ;

        console.log(min_order) ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/getProductByOrderFilter') }}",
            'type':'post',
            'dataType':'text',
            data:{min_order:min_order},
            success:function(data){
                $("#product_data").empty().html(data) ;

            }
        });
    }



    function min_max_between_product_filter(event){
        event.preventDefault() ;

        let mininput = $(".mininput").val() ;
        let maxinput = $(".maxinput").val() ;
        let search_keywords = $("[name=keywords]").val() ;
        let type            = "{{ $type }}";


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/getProductByMinMaxFilter') }}",
            'type':'post',
            'dataType':'text',
            data:{mininput:mininput, maxinput:maxinput, search_keywords:search_keywords, type:type},
            success:function(data){
                $("#product_data").empty().html(data) ;

            }
        });
    }


    $(document).ready(function(){

        $(document).on('click', '#prevpage', function(event){
            event.preventDefault(); 
        
            var page             = parseInt($("#next_page").attr('href'))-1;
            $("#next_page").attr("href", page);

            var viewType         = "G" ;
            var search_type         = "product" ;
            var keywords         = $("[name=keywords]").val() ;

            var last_pagenumber  = {{ $productSearch->lastPage() }} ;


            if (0 < page || page == 1) {
                $(this).attr("href", page);
                $('.pagination-link').removeClass('is-current');
                $('.main_class_'+page).addClass('is-current');
                fetch_data(page, viewType, search_type, keywords);
            }else{
                return false ;
            }
            
        });


        $(document).on('click', '#next_page', function(event){
            event.preventDefault(); 
            var page             = parseInt($(this).attr('href'))+1;

            var viewType         = "G" ;
            var search_type         = "product" ;
            var keywords         = $("[name=keywords]").val() ;

            var last_pagenumber  = {{ $productSearch->lastPage() }} ;

            if (last_pagenumber > page || last_pagenumber == page) {
                $(this).attr("href", page);
                $('.pagination-link').removeClass('is-current');
                $('.main_class_'+page).addClass('is-current');
                fetch_data(page, viewType, search_type, keywords);
            }else{
                return false ;
            }
        });

        $(document).on('click', '.custom_paginate', function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];

            var viewType         = "G" ;
            var search_type      = "product" ;
            var keywords         = $("[name=keywords]").val() ;

            $("#next_page").attr("href", page);
            $('.pagination-link').removeClass('is-current');
            $('.main_class_'+page).addClass('is-current');

            fetch_data(page, viewType, search_type, keywords);
        });

        function fetch_data(page,viewType, search_type, keywords)
        {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"{{ url('/getsearchproductresutlistview') }}",
                method:"POST",
                data:{page:page,viewType:viewType, search_type:search_type, keywords:keywords},
                success:function(data)
                {
                    $('#product_data').empty().html(data).show(3000);
                }
            });
        }
    });
</script>
@endsection
