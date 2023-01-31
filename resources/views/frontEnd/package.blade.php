@extends('frontEnd.master')
@section('title','Package')
@section('css')
<style>
	#tab-content section {
      display: none;
    }
    
    #tab-content section.is-active {
      display: block;
    }
    
    .tabs.is-toggle a:hover {
        background-color: #f5f5f5;
        border-color: #b5b5b5;
        z-index: 2;
        color: black!important;
    }
    
    .package_item p{
        text-align: left!important;
        font-size: 21px;
        line-height: 2;
        font-weight: 750;
       
    }

</style>
@endsection
@section('content')
<div class="wrapper" style="background: #f4f4f4;">
    
    <?php
        $banner_info = DB::table('tbl_package_banner')->first() ;
        if($banner_info == true and file_exists($banner_info->image))
        {
            $banner_image = URL::to($banner_info->image);
        }else{
            $banner_image = URL::to('public/frontEnd/package/background.svg');
        }
        
    ?>

<div style="height: 680px !important;padding-top:80px;background: url({{ $banner_image }});background-repeat: no-repeat;background-size: 100% 50%;">
    <div class="container mt-5">
        
        <center>
            <h1 style="color: #1b1717;font-size:31px;">Package Pricing</h1>
            <br>
            <div class="mt-5">
                <div id="tabs" class="">
                    <?php foreach($package_category_list as $key=>$categoryprice): ?>
                        <button class="button is-info <?php if($key == 0){echo 'is-active'; }else{echo ''; } ?>" data-tab="{{ $categoryprice->id }}">{{ $categoryprice->category_name }}</button>
                    <?php endforeach; ?>
                </div>
            </div>
        </center>
        
        <section class="mb-2">
    		<?php 
		        if (Session::get('supplier_id') != null){
		            $main_login_id = Session::get('supplier_id');
		        }else{
		            $main_login_id = 0;
		        }
		    ?>
		    
		    <?php 
		        if (Session::get('customer_id') != null){
		            $customer_login_id = Session::get('customer_id');
		        }else{
		            $customer_login_id = 0;
		        }
		    ?>
            <div class="container mt-5 mb-4 is-gapless">
                <div id="tab-content">
                    <?php foreach($package_category_list as $key=>$categorypricei): ?>
                <section class="tab_body <?php if($key == 0){echo 'is-active'; }else{echo ''; } ?>" data-content="{{ $categorypricei->id }}">
                    <?php 
                        $all_package = DB::table('tbl_package')->where('category_id',  $categorypricei->id)->where('status', 1)->get() ;
                    ?>
                    <?php foreach($all_package as $package): ?>
                    
                    <div class="sonia box mb-4 mr-5 p-2 package" style="border: 2px solid <?php echo $package->border_color; ?>;border-radius: 0px !important;">
                        <span class="has-text-centered">
                            <h1 class="package-headline" style="font-size: 34px!important;font-weight: bold!important;color: #ff6a00; text-transform: uppercase;">{{ $package->package_name }}</h1>
                            <?php
            		            $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
            		        ?>
                            <h1 class="package-price"><span style="font-family:'SolaimanLipi'">{{ $main_currancy_status->symbol }}</span> 
                            <?php 
                            	$now_product_price_is   = $package->package_price * $main_currancy_status->rate ;
                            	if($package->discount_percentage > 0){
                            		$discount_amount = $now_product_price_is * $package->discount_percentage/100 ;
                            
                            	}else{
                            		$discount_amount = 0;
                            	}
                            
                              	echo $now_product_price_is-$discount_amount;  ?> / <?php if($categorypricei->duration_type == 1){echo "Month"; }else{echo "Yearly"; }
                             ?>
                            </h1>
                            @if($package->discount_percentage > 0)
                            <h1 class="package-original-amount"><del><?php $now_product_price_is   = $package->package_price * $main_currancy_status->rate ; echo $now_product_price_is; ?> </del></h1>
                            <h1 class="package-save">Save @php $package->discount_percentage @endphp% Off</h1>
                            @endif
                            <br>
                            <center><a href="#" class="choose-package" onclick="packageset(event, <?php echo $main_login_id; ?>, <?php echo $package->id; ?>)">Get Started</a></center>
                            <br>
                            @if($package->discount_percentage > 0)
                            <p class="pt-2 pb-2 package-renew">You pay @php $now_product_price_is-$discount_amount @endphp — Renews at  @php $now_product_price_ist @endphp </p>
                            @endif
                            
                        </span>
                        <hr style="border: 1px solid <?php echo $package->border_color; ?> !important;">
                        <div class="pl-5 package_item">
                            <p><i class="fa fa-<?php if($package->primary_category_limit != 0){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> {{ $package->primary_category_limit }} Primary Category</p>
                            <p><i class="fa fa-<?php if($package->seconday_category_limit != 0){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> {{ $package->seconday_category_limit }} Secondary Category</p>
                            <p><i class="fa fa-<?php if($package->product_limit != 0){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> {{ $package->product_limit }} Product Upload</p>
                            <p><i class="fa fa-<?php if($package->slider_update_status != 0){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> {{ $package->slider_update_status }} Sliders Item</p>
                            <p><i class="fa fa-<?php if($package->banner_update_status ==1){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> Custom Banner </p>
                            <p><i class="fa fa-<?php if($package->logo_update_status ==1){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i>  Custom Logo </p>
                            <p><i class="fa fa-<?php if($package->social_media_status ==1){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> Social Media </p>
                        </div>
                    </div>
                    <?php endforeach ?>
                </section>
                 <?php endforeach ; ?>
                </div>
            </div>
            
        </section>
    </div>
    

</div>
    
@endsection
@section('js')
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;
        case 'failed':
        toastr.error("{{ Session::get('message') }}");
        break;
    }
    @endif
</script>
<script>
    $(document).ready(function() {
      $('#tabs button').on('click', function() {
        var tab = $(this).data('tab');
    
        $('#tabs button').removeClass('is-active');
        $(this).addClass('is-active');
    
        $('#tab-content section').removeClass('is-active');
        $('section[data-content="' + tab + '"]').addClass('is-active');
      });
    });
    
    function packageset(event, supplier_id, package_id)
    {
        var customer_login_id = <?php echo $customer_login_id; ?>;
        if(customer_login_id == 0 && supplier_id == 0){
            $("#login_modal").modal('show');
        }else if(customer_login_id != 0 && supplier_id == 0){
            toastr.info('Sorry! This Section Only For Sellers.', "warning", { positionClass: 'toast-top-center', });
            return false ;
        }else{
            window.location.href = "https://www.availtrade.com/setpackage/"+package_id
        }
        
    }
    
</script>



@endsection
