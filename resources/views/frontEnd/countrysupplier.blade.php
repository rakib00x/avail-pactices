@extends('frontEnd.master')
@section('title','')
<?php
    $meta_info  = DB::table('tbl_meta_tags')->first();
    $settings   = DB::table('tbl_logo_settings')->where('status', 1)->first();
   
?>
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
    <div class="wrapper">

        <div class="container">
            <div class="columns is-gapless">
                <div class="column is-full">

                </div>
            </div>

            <!-- main wrapper -->
            <div class="columns is-gapless" style="min-height: 715px;">

                <!-- left sidebar -->
                <div class="column is-one-fifth mr-4" style="height: auto;">

                    <div class="columns">
                        <div class="column">
                            <h2 class="left-sidebar-categoris">Categories</h2>
                            <ul>
                                @foreach($all_catgeorys as $category)
                                <li><a href="{{ URL::to('category/'.$category->catgeory_slug) }}/heightolow">{{ $category->category_name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="columns">
                        <div class="column">
                            <h2 class="left-sidebar-categoris">Sub Category</h2>
                             <?php
							$secondary = DB::table('tbl_secondarycategory')
								->where('sidebar_active', 1)
								->orderBy('sidebar_decoration', 'asc')
								->where('status', 1)
								->get();
							?>
                            <ul class="markets">
                                @foreach($secondary as $subCat)
                                <li><a href="{{ URL::to('seccategory/'.$subCat->secondary_category_slug.'/heightolow') }}"> {{$subCat->secondary_category_name}}</a></li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </div>

                

                    <!--<div class="columns">-->
                    <!--    <div class="column">-->
                    <!--        <img src="images/rfq.jpg" alt="">-->
                    <!--    </div>-->
                    <!--</div>-->

                </div>

                <!-- main content area -->
                <div class="column auto mr-4" style="height: auto;">

                    <div class="columns">
                        <div class="column">
                            <table>
                                <tr>
                                    <td><p>Total In Country =</p></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <!--<td><input type="text"><input type="submit"></td>-->
                                    <!--<td>&nbsp;&nbsp;</td>-->
                                    <td><p><?php echo count($supplier_search); ?> Supplier(s)</p></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="columns mb-0 pb-0">
                        <div class="column">
                            <div class="tabs is-boxed" style="border-bottom: 1px solid #d4dae3;">
                                <ul>
                                    <li style="background: #f5f7fa;border: 1px solid #d4dae3;">
                                        <a>
                                            <span style="color: #666666;">Products</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div style="border: 1px solid #d4dae3;border-top: none;padding-bottom: 15px; padding: 10px" class="mt-0 pt-0">
                        <div class="columns">
                            <div class="column">
                                <div class="tab is-boxed">
                                    <nav>
                                        <label class="checkbox"><input type="checkbox"> <img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/> Trade Assurance</label>
                                        <label>&nbsp;&nbsp;</label>
                                        <label class="checkbox"><input type="checkbox"> <img src="{{ URL::to('public/frontEnd/images/verified.png') }}"/> Supplier</label>
                                        <label>&nbsp;&nbsp;</label>
                                        <label>Sort By:</label>
                                        <div class="select is-small">
                                            <select>
                                                <option value="1" selected>Best Match</option>
                                                <option value="2">Responsive Rate</option>
                                            </select>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="product_data">
                        @foreach($supplier_search as $supplierSearch)
                        <div class="columns pl-3 pr-3 pb-0 mb-0">
                            <div class="column mt-4 p-3 box supplier-hover">
                                @php
                                 $created_at = date("d M Y", strtotime($supplierSearch->created_at)) ;
                                 $today_date = date("d M Y");
									$datetime1 = new DateTime("$created_at");
									$datetime2 = new DateTime($today_date);
									$interval = $datetime1->diff($datetime2);
									$still = $interval->format('%y');
                                @endphp
                                <nav class="mb-4">
                                    <label><span class="yrs">{{ $still }} <sup>YRS</sup></span></label>
                                    <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                    <label><span class="supplier"><a class="supplier-title" href="<?php $store = strtolower($supplierSearch->storeName); ?> {{ URL::to('store/'.$store) }}">{{ $supplierSearch->storeName }}</a></span></label>
                                    <label style="float: right;"><img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/> Favorites</label>
                                </nav>
                                <!--<nav class="mb-2">-->
                                <!--    <label><img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/> Gold Supplier</label>-->
                                <!--    <label><img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/> Trade Assurance</label>-->
                                <!--    <label><img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/> Contact Details </label>-->
                                <!--    <label><img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/> Video </label>-->
                                <!--</nav>-->
                                <div class="columns">
                                    <div class="column is-one-quarter mr-0 pr-0">
                                        <?php
                                        $supplier_product  = DB::table('tbl_product')
                                            ->inRandomOrder()
                                            ->where('supplier_id', $supplierSearch->id)
                                            ->where('status', 1)
                                            ->take(1)
                                            ->orderBy('id', 'desc')
                                            ->first();
                                        ?>
                                            <div class="main-inner-supplier-search">
                                                <div class="slider-supplier-search">
                                                    <div class="supplier-main-inner">
                                                        <div class="supplier-slider">
                                                            <?php if($supplier_product): ?>
                                                                <?php 
                                                                    $second_image_explode = explode("#", $supplier_product->products_image);
                                                                    foreach ($second_image_explode as $key => $productimageslider){ ?>
                                                                    <a href="#" title=""><img src="{{ URL::to('public/images') }}/{{ $productimageslider }}" class="supplier-img-size"/></a>
                                                                <?php } ?>
                                                            <?php endif; ?>
                                                            
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="column">
                                        <table style="font-size: 15px;">
                                            <tr>
                                                <td>Supplier iis</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td><img src="{{ URL::to('public/frontEnd/images/assurance.png') }}"/><img src="images/assurance.png"/></td>
                                            </tr>
                                            <tr>
                                                <td>Main Products</td>
                                                <td>:</td>
                                                @php
                                                 $supplier_cate = DB::table('tbl_supplier_primary_category')->where('supplier_id', $supplierSearch->id)->limit(5)->get();
                                                @endphp
                                                <td>@foreach($supplier_cate as $suplier_cat)
                                                    {{$suplier_cat->category_name}},
                                                   @endforeach
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Country/Region</td>
                                                <td>&nbsp;:&nbsp;</td>
                                                <td>{{ $supplierSearch->countryName }}</td>
                                            </tr>
                                            <!--<tr>-->
                                            <!--    <td>Total Revenue</td>-->
                                            <!--    <td>&nbsp;:&nbsp;</td>-->
                                            <!--    <td>US$2.5 Million - US$5 Million</td>-->
                                            <!--</tr>-->
                                            <!--<tr>-->
                                            <!--    <td>Top 3 Markets:</td>-->
                                            <!--    <td>&nbsp;:&nbsp;</td>-->
                                            <!--    <td>North America 20%, Southern Europe 20%, Western Europe 20%</td>-->
                                            <!--</tr>-->
                                            <!--<tr>-->
                                            <!--    <td colspan="3">72 Transactions(6 months)</td>-->
                                            <!--</tr>-->
                                            <!--<tr>-->
                                            <!--    <td colspan="3">$260,000+</td>-->
                                            <!--</tr>-->
                                            <tr>
                                                <td>&nbsp;&nbsp;</td>
                                                <td>&nbsp;&nbsp;</td>
                                                <td>
                                                    <a class="contact-supplier"  onclick="sendquotationinfo(<?php echo $supplierSearch->id; ?>, '<?php echo $supplierSearch->storeName;  ?>')"><i class="far fa-envelope"></i> Contact Supplier</a> &nbsp;&nbsp;&nbsp; <img src="{{ URL::to('public/frontEnd/images/chat.png') }}" alt="">
                                                <a style="font-size: 16px;"  onclick="chatshowpage({{ $supplierSearch->id }},<?php echo $main_login_id; ?>, '{{ $supplierSearch->first_name." ".$supplierSearch->last_name }}')"> Chat Now</a></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </span>


                    <div class="columns is-full mb-5 mt-5">
                        <div class="column">
                            
                            {{ $supplier_search->links('frontEnd.custompagination') }}
                            
                        </div>
                    </div>



                </div>

                <!-- right sidebar -->
                <!--<div class="column is-one-fifth" style="height: auto;">-->
                <!--    <div style="border: 1px solid #d4dae3; padding: 8px;">-->
                        <!--<h2 style="font-size: 20px">Premium Related Products</h2>-->
                        <!--<div class="columns">-->
                        <!--    <div class="column">-->
                        <!--        <img src="{{ URL::to('public/frontEnd/images/related_product_one.jpg') }}" alt="">-->
                        <!--        <p>Outdoor Swimming Pool Bestway 56403 2.6m</p>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <!--<div class="columns">-->
                        <!--    <div class="column">-->
                        <!--        <img src="{{ URL::to('public/frontEnd/images/related_product_two.jpg') }}" alt="">-->
                        <!--        <p>Pool BESTWAY 56416 Above Ground Round Steel</p>-->
                        <!--    </div>-->
                        <!--</div>-->
                <!--    </div>-->
                <!--</div>-->

            </div>
        </div>
    </div>

@endsection
@section('js')
<script>
    function chatshowpage(receiver_id, senderid, supplier_name){
        
        if(receiver_id == senderid){
            toastr.info('Oh shit!! You Can Not Chat This Person', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
        
        if(senderid == 0){
            $("#login_modal").modal('show');
            return false ;
        }
        
        $(".chat-popup").show();
        $('.chat-btn').hide();

        $(".sonia").css({backgroundColor: 'white'});
        var supplier_name = '+supplier_name+';
       
        $('.supplier-name-holder').empty();
        $('.supplier-name-holder').text(supplier_name);
           
        $('#receiver_id_by_ajax').empty();
        $('#receiver_id_by_ajax').val(receiver_id);
        
        $.ajaxSetup({
        	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
        	'url':"{{ url('/insertProductChatInfo') }}",
        	'type':'post',
        	'dataType':'text',
        	data:{receiver_id:receiver_id, sender_id:senderid},
        	success:function(data)
        	{
        	    if(data != 2){
        	        $(".chat-members").append(data);
        	    }else{
        	        $(".sonia").css({backgroundColor: 'white'});
        	        $(".member_with_"+receiver_id).css({backgroundColor: '#ffefb3'}) ;
        	    }

        		$.ajax({
                	'url':"{{ url('/loadMessages') }}",
                	'type':'post',
                	'dataType':'text',
                	data:{receiver_id:receiver_id},
                	success:function(data)
                	{
                        $("#loadChat").empty();
                        $("#loadChat").html(data);
                        $(".chat-window .chat-details").animate({ scrollTop: 9999999 }, 'slow');
                	}
                });
        		
        	}
        });


    }
</script>
<script>
    function min_order_product_filter(event){
        event.preventDefault() ;

        let min_order = $("[name=min_order]").val() ;

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

        let mininput        = $("[name=mininput]").val() ;
        let maxinput        = $("[name=maxinput]").val() ;
        let search_keywords = $("[name=keywords]").val() ;

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
            var search_type         = "supplier" ;
            var keywords         = $("[name=keywords]").val() ;

            var last_pagenumber  = {{ $supplier_search->lastPage() }} ;


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
            var search_type         = "supplier" ;
            var keywords         = $("[name=keywords]").val() ;

            var last_pagenumber  = {{ $supplier_search->lastPage() }} ;

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
            var search_type      = "supplier" ;
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
    <script src="{{ URL::to('public/frontEnd/assets/js/supplierSearchSlider.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.js"></script>

  <script type="text/javascript">
    $( document ).ready(function(){
      $('.supplier-slider').slick({
        dots: false,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 5000,
      });
    })
  </script>
@endsection

@section('css')
    <style type="text/css">
        .slick-next::before, .slick-prev::before {
            font-size: 20px;
            line-height: 1;
            opacity: .75;
            color: #ff7519!important;
        }

        .slick-next::after, .slick-prev::after {
            font-size: 20px;
            line-height: 1;
            opacity: .75;
            color: #ff7519!important;
        }

        .slick-prev {
            left: -16px;
            overflow: hidden;
            z-index: 1000;
            color: black;
        }

    </style>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick-theme.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/supplierSearchSlider.css') }}">
@endsection
