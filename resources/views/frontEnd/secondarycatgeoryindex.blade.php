@extends('frontEnd.master')
@section('title')
    <?php echo $secondary_category_info->secondary_category_name; ?>
@endsection
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection 
<?php
    $meta_info 	= DB::table('tbl_meta_tags')->first();
	$settings 	= DB::table('tbl_logo_settings')->where('status', 1)->first();
?>
@section('meta_info')

    <meta name="title" content="{{ $secondary_category_info->secondary_category_name }}">
    <meta name="description" content="{{ $meta_info->meta_details }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $secondary_category_info->secondary_category_name }}">
    <meta property="og:description" content="{{ $meta_info->meta_details }}">
    <meta property="og:image" content="{{ URL::to('public/images/'.$secondary_category_info->secondary_category_icon) }}"/>
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $secondary_category_info->secondary_category_name }}">
    <meta property="twitter:description" content="{{ $meta_info->meta_details }}">
    <meta property="twitter:image" content="{{ URL::to('public/images/'.$secondary_category_info->secondary_category_icon) }}">

@endsection

@section('content')
    <div class="container mt-5 mb-5 is-gapless">
        <div class="columns">
            <div class="column is-one-fifth mt-4">
                <ul class="menu-list">
                    <?php foreach ($tertiary_category as $key => $tervalue): ?>
                        <li><a href="{{ URL::to('tercategory/'.$tervalue->tartiary_category_slug.'/heightolow') }}" target="_blank">{{ $tervalue->tartiary_category_name }}</a></li>
                    <?php endforeach ?>
                </ul>

            </div>



            <div class="column is-auto">
                
                <div class="columns">
                    <div class="column is-full mb-0 pb-0">
                        <div class="columns">
                            <div class="column">
                               <h1 class="pl-0" style="font-size: 20px;font-weight: bold;">Recommended For You</h1>
                            </div>

                            <div class="column" style="margin-left: 302px;">
                                <table>
                                    <tr>
                                        <td>
                                            <select name="" style="padding: 8px 10px;font-size: 18px;font-weight: bold;" id="pricefilter">
                                                <option value="heightolow" <?php if($pricefilter == "heightolow"){echo "selected"; }else{echo ""; } ?>>High to Low Price</option>
                                                <option value="lowtohigh" <?php if($pricefilter == "lowtohigh"){echo "selected"; }else{echo ""; } ?>>Low to High Price</option>
                                            </select>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    

                        <span id="get_content">

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
                        					<b><?php echo $currency_code2; ?>{{ number_format($now_product_price_is2, 2) }} - {{ number_format($now_product_price_is_max, 2) }}</b><br/>
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

                        </span>

                    </div>
                </div>
                

                <div class="columns is-full mb-5">
                    <div class="column">
                        
                        {{ $all_product->links('frontEnd.store.customPaginate') }}
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    
    $("#pricefilter").change(function(){
        var pricefilter = $(this).val() ;
        var main_link   = "<?php echo env('APP_URL'); ?>";
        var gridlink    = main_link+"seccategory/<?php echo $category_slug; ?>"+"/"+pricefilter;
        window.location = gridlink;
    });
    
    
    $(document).ready(function(){

        $(document).on('click', '#prevpage', function(event){
            event.preventDefault(); 
        
            var page             = parseInt($("#next_page").attr('href'))-1;
            $("#next_page").attr("href", page);
            var pricefilter      = $("#pricefilter").val() ;
            var category_slug    = "<?php echo $category_slug; ?>" ;
            var last_pagenumber  = {{ $all_product->lastPage() }} ;


            if (0 < page || page == 1) {
                $(this).attr("href", page);
                $('.pagination-link').removeClass('is-current');
                $('.main_class_'+page).addClass('is-current');
                fetch_data(page, pricefilter, category_slug);
            }else{
                return false ;
            }
            
        });


        $(document).on('click', '#next_page', function(event){
            event.preventDefault(); 
            var page             = parseInt($(this).attr('href'))+1;
            var pricefilter      = $("#pricefilter").val() ;
            var category_slug    = "<?php echo $category_slug; ?>" ;
            var last_pagenumber  = {{ $all_product->lastPage() }} ;


            if (last_pagenumber > page || last_pagenumber == page) {
                $(this).attr("href", page);
                $('.pagination-link').removeClass('is-current');
                $('.main_class_'+page).addClass('is-current');
                fetch_data(page, pricefilter, category_slug);
            }else{
                return false ;
            }
            
        });


        $(document).on('click', '.custom_paginate', function(event){
            event.preventDefault(); 
            var page = $(this).attr('href').split('page=')[1];
            var pricefilter      = $("#pricefilter").val() ;
            var category_slug    = "<?php echo $category_slug; ?>" ;
            $("#next_page").attr("href", page);
            $('.pagination-link').removeClass('is-current');
            $('.main_class_'+page).addClass('is-current');

            fetch_data(page, pricefilter, category_slug);
        });

        function fetch_data(page,pricefilter, category_slug)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"{{ url('/getsecondarycategoryproductforpagination') }}",
                method:"POST",
                data:{page:page,pricefilter:pricefilter, category_slug:category_slug},
                success:function(data)
                {
                    $('#get_content').empty().html(data).show(3000);
                }
            });
        }
    });

</script>
@endsection


