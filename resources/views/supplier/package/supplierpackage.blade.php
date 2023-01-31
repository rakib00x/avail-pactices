@extends('supplier.masterSupplier')

@section('content')

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">

                <div class="row">
                    <!-- Task Card Starts -->
                    <div class="col-lg-12">

                        
                        
                        <center>  
                            <ul class="nav nav-pills mb-3 ml-5 pl-5" id="pills-tab" role="tablist">
                                <?php foreach($package_category_list as $key=>$package_category): ?>
                                    <li class="nav-item button-spacer" role="presentation">
                                        <button class="page_link_siam nav-link btn-primary <?php if($key == 0){echo 'active'; }else{echo '';} ?> text-white" id="pills-<?php echo $package_category->id; ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo $package_category->id; ?>" type="button" role="tab" aria-controls="pills-home" aria-selected="true" onclick="myfunction(event, <?php echo $package_category->id; ?>)">{{ $package_category->category_name }}</button>
                                     </li>
                                <?php endforeach ; ?>
                            </ul>
                        </center>
                        
                        <div class="tab-content" id="pills-tabContent">
                            <?php foreach($package_category_list as $key=>$packagedata): ?>    
                            <div class="tabl_item_siam tab-pane fade show <?php if($key == 0){echo 'active'; }else{echo '';} ?>" id="pills-<?php echo $packagedata->id; ?>" role="tabpanel" aria-labelledby="pills-<?php echo $packagedata->id; ?>-tab">
                                <div class="container">
                                      <div class="row g-3">
                                        <?php $all_package = DB::table('tbl_package')->where('category_id',  $packagedata->id)->where('status', 1)->get(); ?>
                                          
                                         <?php foreach($all_package as $package): ?>
                                        <!-- Single Blog Catagory-->
                                        <div class="col-xl-4 col-md-4 col-lg-4 col-12">
                                          <div class="card blog-catagory-card" style="border: 2px solid <?php echo $package->border_color; ?>!important;border-radius: 0px !important;">
                                              
                                            <span class="text-center">
                                                <h1 class="package-title" style="text-transform: uppercase;">{{ $package->package_name }}</h1>
                                                <?php
                            		                $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                		        ?>
                                                <h4 class="package-price"><span style="font-family:'SolaimanLipi'">{{ $main_currancy_status->symbol }}</span> 
                                                <?php 
                                                	$now_product_price_is   = $package->package_price * $main_currancy_status->rate ;
                                                	if($package->discount_percentage > 0){
                                                		$discount_amount = $now_product_price_is * $package->discount_percentage/100 ;
                                                
                                                	}else{
                                                		$discount_amount = 0;
                                                	}
                                                
                                                  	echo number_format($now_product_price_is-$discount_amount, 2);  ?> / <?php if($packagedata->duration_type == 1){echo "Month"; }else{echo "Yearly"; }
                                                 ?>
                                                </h4>
                                                
                                                @if($package->discount_percentage > 0)
                                                <h4 class="package-original-amount"><del><?php $now_product_price_is = $package->package_price * $main_currancy_status->rate ; echo number_format($now_product_price_is,2); ?> </del></h4>
                                                <h4 class="package-save">Save @php echo $package->discount_percentage @endphp % Off</h4>
                                                @endif
                                                <br>
                                                @if($supplier_info->package_id == $package->id)
                                                <center><a href="#" class="btn btn-primary" >Active</a></center>
                                                @else
                                                <center><a href="{{ URL::to('spu/'.$package->id) }}" class="btn btn-success " >Get Started</a></center>
                                                @endif
                                                <br>
                                                @if($package->discount_percentage > 0)
                                                <p class="pt-2 pb-2 package-renew">You pay  @php echo number_format($now_product_price_is-$discount_amount, 2) @endphp — Renews at  @php echo number_format($now_product_price_is, 2) @endphp </p>
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
                                        </div>
                                        
                                        <?php endforeach ?>
        
                                      </div>
                                </div>
                            </div>
                            <?php endforeach;  ?>
    
                        </div>
                        
                        
                    </div>

                </div>
            </section>
            <!-- Dashboard Analytics end -->

        </div>
    </div>
</div>
<!-- END: Content-->

@endsection
@section('js')
<script>
    function myfunction(event, category_id){
        event.preventDefault() ;
        $(".page_link_siam").removeClass('active');
        $(".page_link_siam").attr('aria-selected', 'false');
        
        $(".tabl_item_siam").removeClass('active');
        
        $("#pills-"+category_id+"-tab").addClass('active');
        $("#pills-"+category_id).addClass('active');
    }
</script>
@endsection
