
@extends('frontEnd.master')
@section('title','Category Page')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/all-categories.css') }}">
@endsection
@section('content')
        <div class="headerDown">
            <b>Products by Category</b>
        </div>

        <?php         
            $all_categorys = DB::table('tbl_primarycategory')
                ->where('status', 1)
                ->get() ;

        ?>

        <div class="main-nav">
            <nav id="nav">
                <ul class="clearfix">
                    <?php foreach ($all_categorys as $value): ?>
                        <li>
                            <a href="#{{ $value->catgeory_slug.'_'.$value->id }}"><img src="{{URL::to('public/images/mainCtegory/'.$value->category_icon)}}" style="width: 33px;height: 26px;position:absolute"/> 
                            <span style="position: relative;margin-left: 40px;">{{ substr($value->category_name, 0, 20) }} </span>
                            </a></li>
                    <?php endforeach ?>
                    
                </ul>
            </nav>
        </div>

        <section id="top" class="container">
            <section class="sectionContainter">
                <?php foreach ($all_categorys as $categoyrvalue): ?>
                    <a href="{{ URL::to('category/'.$categoyrvalue->catgeory_slug.'/heightolow') }}"><h1 class="head"><img src="{{URL::to('public/images/mainCtegory/'.$categoyrvalue->category_icon)}}" style="width: 33px;height: 26px;" /> {{ $categoyrvalue->category_name }}</h1></a>
                    <section class="section"  id="{{ $categoyrvalue->catgeory_slug.'_'.$categoyrvalue->id }}">
                        @php   
                            $seconday_category = DB::table('tbl_secondarycategory')
                                ->where('primary_category_id', $categoyrvalue->id)
                                ->where('status', 1)
                                ->get() ;
                        @endphp
                        <?php foreach ($seconday_category as $scvalue): ?>
                            @php
                                $product_count = DB::table('tbl_product')
                                    ->where('w_secondary_category_id', $scvalue->id)
                                    ->count() ;
                            @endphp
                            <div class="productContainer">
                                @php
                                        $get_tertiary_category = DB::table('tbl_tartiarycategory')
                                            ->where('primary_category_id', $categoyrvalue->id)
                                            ->where('secondary_category_id', $scvalue->id)
                                            ->where('status', 1)
                                            ->get() ;

                                        $get_tertiary_categorys = DB::table('tbl_tartiarycategory')
                                            ->where('primary_category_id', $categoyrvalue->id)
                                            ->where('secondary_category_id', $scvalue->id)
                                            ->where('status', 1)
                                            ->limit(10)
                                            ->get() ;
                                    @endphp
                                <a href="{{ URL::to('seccategory/'.$scvalue->secondary_category_slug.'/heightolow') }}"><h4><span>{{ $scvalue->secondary_category_name }} </span> ({{ $product_count }})</h4></a>
                                <div class="poroduct">

                                    <ul>
                                        <?php foreach ($get_tertiary_categorys as $tervalue): ?>
                                            <li><a href="{{ URL::to('tercategory/'.$tervalue->tartiary_category_slug.'/heightolow') }}">{{ $tervalue->tartiary_category_name }}</a></li>
                                        <?php endforeach ?>
                                    </ul>
                                    <?php if (count($get_tertiary_category) > 10): ?>
                                        @php
                                            $tertiary_catgery_2 = DB::table('tbl_tartiarycategory')
                                                ->where('primary_category_id', $categoyrvalue->id)
                                                ->where('secondary_category_id', $scvalue->id)
                                                ->where('status', 1)
                                                ->skip(10)
                                                ->limit(10)
                                                ->get() ;
                                        @endphp
                                        <br><br>
                                        <ul>
                                            <?php foreach ($tertiary_catgery_2 as $tersvalue): ?>
                                                <li><a href="{{ URL::to('tercategory/'.$tersvalue->tartiary_category_slug.'/heightolow') }}">{{ $tersvalue->tartiary_category_name }}</a></li>
                                            <?php endforeach ?>
                                            
                                        </ul>
                                    <?php endif ?>
                                    
                                </div>
                            </div>
                        <?php endforeach ?>


                    </section>
                <?php endforeach ?>
                
            </section>
            <section class="rightSection">
                <h1>Buying on Alibaba.com</h1>
                <div class="rigntSectionIn">
                    <div>
                        <p class="darkness">At Alibaba.com we have a huge range of free buyer tools and services to help make sourcing the right products easy for you!</p>

                        <ul class="ulNone">
                            <li class="li greedBlue " >Buyer Services</li>
                            <li class="li greedBlue " >Safe Trading Center</li>
                            <li class="li greedBlue " >Buyer Success Stories</li>
                            <li class="li greedBlue " >Buyer Community</li>
                        </ul>

                    </div>
                </div>


                <h1>Ad from aliexpress</h1>
                <div class="rigntSectionIn">
                    <div>
                         <a href="https://s.click.aliexpress.com/e/_9HX6nf?bz=280*480" target="_parent"><img
                         width="280" height="480" 
                         src="//ae01.alicdn.com/kf/H52075e829fce4925819f4f936d88d7a7y.png" /></a>

                        <!--<ul class="ulPadding">-->
                        <!--    <li class="li  " >Buyer Services</li>-->
                        <!--    <li class="li  " >Safe Trading Center</li>-->
                        <!--    <li class="li  " >Buyer Success Stories</li>-->
                        <!--    <li class="li  " >Buyer Community</li>-->
                        <!--</ul>-->

                    </div>
                </div>

                <h1>Buying Tools</h1>
                <div class="rigntSectionIn">
                    <div>
                        <p><b class="greedBlue"><i style="padding-right: 10px;" class="fas fa-envelope"></i> MessageCenter</b></p>
                        <p style="padding-left: 30px; margin-top: -15px;">Manage inquiries from buyers</p>

                        <p><b class="greedBlue"><i style="padding-right: 10px;" class="fab fa-github-alt"></i> TradeManager</b></p>
                        <p style="padding-left: 30px; margin-top: -15px;">Chat with buyers in real time</p>

                        <p><b class="greedBlue"><i style="padding-right: 10px;" class="fas fa-bell"></i>Trade Alert</b></p>
                        <p style="padding-left: 30px; margin-top: -15px;">Stay ahead with trade updates</p>

                        <b class="greedBlue"><i style="padding-right: 10px;" class="fas fa-newspaper"></i>Buying Requests</b></p>
                        <p style="padding-left: 30px; margin-top: -15px;">Tell suppliers your sourcing needs</p>

                        <b class="greedBlue"><i style="padding-right: 10px;" class="fas fa-star"></i>Favorites</b></p>
                        <p style="padding-left: 30px; margin-top: -15px;">Bookmark products and suppliers</p>
                    </div>
                </div>

                <h1>Safe Buying Guide</h1>
                <div class="rigntSectionIn">
                    <div>
                        <p class="darkness li">How to check your supplier before ordering?</p>
                        <ul class="ulPadding">
                            <li class="li">I am new trader, what should I do?</li>
                            <li class="li">Benefits of inspection for overseas buyers.</li>
                            <li class="li">How to find a good supplier?</li>
                            <li class="li">Ways to self-check your Chinese suppliers.</li>
                        </ul>
                    </div>
                </div>
            </section>
        </section>

        <a href="#top" id="scrollTop">
            <span>^</span>
            <span>Top</span>
        </a>
        @endsection
        @section('js')
<script src="{{ URL::to('public/allcategories/jquery.scroller.js') }}"></script>
<script src="{{ URL::to('public/allcategories/index.js') }}"></script>
<script type="text/javascript">
   		$(document).ready(function(){
   			
   			var height = $(window).height(); 
			if (height < 900) {
                $('body').css('zoom','80%'); / Webkit browsers /
                $('body').css('zoom','0.8'); / Other non-webkit browsers /
                $('body').css('-moz-transform',scale(0.8, 0.8)); / Moz-browsers /
			}
		});
</script>
<script type="text/javascript">

        
 </script>
    @endsection
