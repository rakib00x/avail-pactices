@extends('mobile.master-website')
@section('content')
<?php 
        $base_url = "https://availtrade.com/";
     ?>
        
        
        <!-- Blog Wrapper-->
        <div class="blog-wrapper py-3" style="padding-top: 77px!important;">
            <div class="container">
                
                <center><h6 class="mb-3 package-pricing">Package Pricing</h6></center>
                 
                 
                <center>  
                <ul class="nav nav-pills mb-3 ml-5 pl-5" id="pills-tab" role="tablist">
                    <?php foreach($package_category_list as $key=>$package_category): ?>
                        <li class="nav-item button-spacer" role="presentation">
                            <button class="nav-link btn-primary <?php if($key == 0){echo 'active'; }else{echo '';} ?>" id="pills-<?php echo $package_category->id; ?>-tab" data-bs-toggle="pill" data-bs-target="#pills-<?php echo $package_category->id; ?>" type="button" role="tab" aria-controls="pills-home" aria-selected="true">{{ $package_category->category_name }}</button>
                         </li>
                    <?php endforeach ; ?>
                </ul>
                </center>
                
                
                <div class="tab-content" id="pills-tabContent">
                    <?php foreach($package_category_list as $key=>$packagedata): ?>    
                    <div class="tab-pane fade show <?php if($key == 0){echo 'active'; }else{echo '';} ?>" id="pills-<?php echo $packagedata->id; ?>" role="tabpanel" aria-labelledby="pills-<?php echo $packagedata->id; ?>-tab">
                        <div class="container">
                              <div class="row g-3">
                                  
                                 
                                <?php $all_package = DB::table('tbl_package')->where('category_id',  $packagedata->id)->where('status', 1)->get(); ?>
                                  
                                 <?php foreach($all_package as $package): ?>
                                <!-- Single Blog Catagory-->
                                <div class="col-12">
                                  <div class="card blog-catagory-card" style="border: 2px solid <?php echo $package->border_color; ?>!important;border-radius: 0px !important;">
                                      
                                    <span class="text-center">
                                        <h1 class="package-title" style="text-transform: uppercase;">{{ $package->package_name }}</h1>
                                        <?php
                        		            $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                        		        ?>
                                        <h1 class="package-price"><span style="font-family:'SolaimanLipi'">{{ $main_currancy_status->symbol }}</span> <?php $now_product_price_is   = $package->package_price * $main_currancy_status->rate ; echo $now_product_price_is; ?> / <?php if($packagedata->duration_type == 1){echo "Month"; }else{echo "Yearly"; } ?></h1>
                                        <h1 class="package-del"><del><?php $now_product_price_is   = $package->package_price * $main_currancy_status->rate ; echo $now_product_price_is; ?> </del></h1>
                                        <h1 class="package-save">Save 52% on 1st Year</h1>
                                        <br>
                                        <center><a href="{{ URL::to('setpackage/'.$package->id) }}" class="package-get-started" onclick="return confirm('Are you sure to active this ?')">Get Started</a></center>
                                        <br>
                                        <p class="package-yearly">You pay $21.88 — Renews at $42.88/year</p>
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
        <style>
            .package_item p{
                text-align: left!important;
                font-size: 17px;
                line-height: 0.8;
                font-weight: 750;
                margin-left: 20px;
            }
        </style>

    </div>
@endsection

@section('css')
<style>

.package-pricing {
    font-size: 27px;
}

.button-spacer {
    margin-left: 7px;
}

.package-title {
    color: #ff6a00;
    font-size: 32px;
    font-weight: bold;
    text-align: center;
    margin-top: 12px !important;
    padding: 0px;
    margin: 0px;
}

.package-price {
    color: #000000;
    font-size: 20px;
    font-weight: bold;
    text-align: center;
    padding: 0px;
    margin: 0px;
}

.package-del {
    color: #9b9b9b;
    font-size: 14px;
    font-family: "Helvetica Neue",Helvetica,Arial;
    font-weight: bold;
    text-align: center;
    padding: 0px;
    margin: 0px;
}

.package-save {
    color: #e43723;
    font-size: 14px;
    font-family: "Helvetica Neue",Helvetica,Arial;
    font-weight: bold;
    text-align: center;
    padding: 0px;
    margin: 0px;
}

.package-get-started {
    background-color: #ff6000;
    border-radius: 8px;
    color: #ffffff;
    font-size: 24px;
    font-family: "Helvetica Neue",Helvetica,Arial;
    font-weight: bold;
    text-align: center;
    padding: 8px 0px;
    margin-top: 0px !important;
    margin-bottom: 0px !important;
    margin-left: 25px !important;
    margin-right: 25px !important;
}

.package-yearly {
    color: #9b9b9b;
    font-size: 14px;
    font-weight: bold;
    text-align: center;
    padding: 0px;
    margin-top: 0px;
    margin-bottom: 0px !important;
}

</style>
@endsection

@section('page_headline')
    Package
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

@endsection
