@extends('frontEnd.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/packgges.css') }}">
@endsection
@section('content')
   
    <section class="hero">
      <div class="hero-body price_section">
         
        <section class="section">
        	<div class="container">
        		<h1 class="title is-1 has-text-centered has-text-weight-bold">
        			Pricing Table with Bulma
        		</h1>
        		
                <div class="tabs is-toggle is-fullwidth" id="tabs">
                  <ul>
                    <?php foreach($package_category_list as $key=>$categoryprice): ?>
                    <li class="<?php if($key == 0){echo 'is-active'; }else{echo ''; } ?>" data-tab="{{ $categoryprice->id }}">
                      <a>
                        <span class="icon is-small"><i class="fa fa-image"></i></span>
                        <span>{{ $categoryprice->category_name }}</span>
                      </a>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                </div>
                <div id="tab-content">
                <?php foreach($package_category_list as $key=>$categorypricei): ?>
                  <p class="<?php if($key == 0){echo 'is-active'; }else{echo ''; } ?>" data-content="{{ $categorypricei->id }}">
                        <?php 
                            $all_package = DB::table('tbl_package')->where('category_id',  $categorypricei->id)->where('status', 1)->get() ;
                        ?>
                        <div class="spacer"></div>
        		    
                		<div class="columns">
                		    <?php foreach($all_package as $package): ?>
                		        <?php
                		            $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                		        ?>
                    			<div class="column is-one-third has-text-centered has-background-white">
                    				<h2 class="title is-3 plan_title has-text-weight-bold">{{ $package->package_name }}</h2>
                    				<p class="has-text-weight-light plan_subtitle">This is the basic plan</p>
                    				<div class="price">
                    					<h2 class="title is-2 has-text-weight-bold">{{ $main_currancy_status->symbol }}  
                    					   <?php $now_product_price_is   = $package->package_price * $main_currancy_status->rate ; echo $now_product_price_is; ?> 
                    					<span class="has-text-weight-light">/month</span></h2>
                    				</div>
                    				<div class="spacer"></div>
                    				<div class="features">
                    				    
                    					<p>Feature One</p>
                    					<p>Feature Two</p>
                    					<p>Feature Three</p>
                    					<p class="unavailable">Feature Four</p>
                    					<p class="unavailable">Feature Five</p>
                    					<p class="unavailable">Feature Six</p>
                    					<p class="unavailable">Feature Seven</p>
                    					<p class="unavailable">Feature Eight</p>
                    					<p class="unavailable">Feature Nine</p>
                    					<p class="unavailable">Feature Ten</p>
                    				</div>
                    				<div class="spacer"></div>
                    				<a href="{{ URL::to('setpackage/'.$package->id) }}" class="button is-primary">Get Started Now</a>
                    			</div>
                			<?php endforeach; ?>
                        </div>
                    </p>
                  <?php endforeach ; ?>
                </div>

        	
        	</div>
        </section>
        
      </div>
    </section>
@endsection
@section('js')
<script>
    $(document).ready(function() {
      $('#tabs li').on('click', function() {
        var tab = $(this).data('tab');
    
        $('#tabs li').removeClass('is-active');
        $(this).addClass('is-active');
    
        $('#tab-content p').removeClass('is-active');
        $('p[data-content="' + tab + '"]').addClass('is-active');
      });
    });
</script>
@endsection