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
                            @php
                             $supplier_cate = DB::table('tbl_supplier_primary_category')->where('supplier_id', $supplierSearch->id)->limit(5)->get();
                            @endphp
                            <td>:</td>
                            <td>@foreach($supplier_cate as $suplier_cat)
                                                    {{$suplier_cat->category_name}},
                                @endforeach</td>
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
                            <td><a class="contact-supplier" onclick="sendquotationinfo(<?php echo $supplierSearch->id; ?>, '<?php echo $supplierSearch->storeName;  ?>')"><i class="far fa-envelope"></i> Contact Supplier</a> &nbsp;&nbsp;&nbsp; <img src="{{ URL::to('public/frontEnd/images/chat.png') }}" alt=""><a style="font-size: 16px;" onclick="chatshowpage({{ $supplierSearch->id }},<?php echo $main_login_id; ?>)"> Chat Now</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    
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