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
                    
                    <div class="col-xl-4 col-md-4 col-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-user text-primary font-medium-2"></i>
                                        </div>
                                    </div>
                                    <div class="total-amount">
                                        <h5 class="mb-0">
                                            <?php 
                                                $supplier_info = DB::table('express')
                                                    ->leftJoin('tbl_package', 'express.package_id', '=', 'tbl_package.id')
                                                    ->select('express.*', 'tbl_package.package_name')
                                                    ->where('express.id', Session::get('supplier_id'))
                                                    ->first() ;
                                                    
                                                echo $supplier_info->package_name;
                                            ?>
                                        </h5>
                                        <small class="text-muted">Active Pacakge</small>
                                    </div>
                                </div>
                                <div id="primary-line-chart"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-4 col-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-user text-primary font-medium-2"></i>
                                        </div>
                                    </div>
                                    <div class="total-amount">
                                        <h5 class="mb-0">
                                            <?php
                                                $total_product = DB::table('tbl_product')
                                                    ->where('supplier_id', $supplier_info->id)
                                                    ->count() ;
                                                echo $total_product ;
                                            ?>
                                        </h5>
                                        <small class="text-muted">Prouduct's</small>
                                    </div>
                                </div>
                                <div id="primary-line-chart"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-4 col-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-rgba-warning m-0 p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-dollar text-warning font-medium-2"></i>
                                        </div>
                                    </div>
                                    <div class="total-amount">
                                        <h5 class="mb-0">
                                            <?php
                                                $total_orders = DB::table('order')
                                                    ->where('supplier_id', $supplier_info->id)
                                                    ->count() ;
                                                echo $total_orders ;
                                            ?>
                                            
                                        </h5>
                                        <small class="text-muted">Total Orders</small>
                                    </div>
                                </div>
                                <div id="warning-line-chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-md-4 col-12">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-rgba-primary m-0 p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-user text-primary font-medium-2"></i>
                                        </div>
                                    </div>
                                    <div class="total-amount">
                                        <h5 class="mb-0">Last Product Upload Date And Time</h5>
                             @php
                             $lastUpdate = DB::table('tbl_product')->orderBy('id', 'desc')->first();
                             @endphp
                             {{$lastUpdate->created_at??''}}
                                     </div>
                                  </div>
                              </div>
                          </div>
                     </div>
                </div>
                <div class="row">
                    <!-- Task Card Starts -->
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-12">
                                <?php
                                    $package = DB::table('tbl_package')
                                        ->where('id', $supplier_info->package_id)
                                        ->first();
                                ?>
                                <?php if($package): ?>
                                <div class="card">
                                    
                                    <?php
                                        $package_info = DB::table('tbl_supplier_package_history')
                                            ->where('package_id', $package->id)
                                            ->where('supplier_id', $supplier_info->id)
                                            ->first() ;
                                        
                                    ?>
                                    <div class="card-body">
                                        <span class="has-text-centered">
                                            <h1 class="package-headline" style="font-size: 34px!important;font-weight: bold!important;color: #ff6a00; text-transform: uppercase;">{{ $package->package_name }}</h1>
                                            <?php
                            		            $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                            		        ?>
                                            
                                        </span>
                                        <hr style="border: 1px solid <?php echo $package->border_color; ?> !important;">
                                        <div class="package_item">
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
                                <?php endif; ?>
                                  
                            </div>
                        </div>
                    </div>
                    <!-- Daily Financials Card Starts -->
                    <div class="col-lg-6">
                        <div class="card ">
                            <div class="card-header">
                                <h4 class="card-title">
                                    Order Timeline
                                </h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <ul class="widget-timeline mb-0">
                                        <?php
                                            $last_3_orders = DB::table('order')
                                                ->where('supplier_id', $supplier_info->id)
                                                ->orderBy('id', 'desc')
                                                ->limit(3)
                                                ->get() ;
                                                
                                            foreach($last_3_orders as $ordervalue):
                                        ?>
                                        <li class="timeline-items timeline-icon-primary active">
                                            <div class="timeline-time"><?php echo date('F,Y', strtotime($ordervalue->created_at)); ?></div>
                                            <h6 class="timeline-title"><?php echo $ordervalue->invoice_number; ?>, orders, <?php echo $ordervalue->total_price; ?></h6>
                                        </li>
                                        <?php endforeach; ?>

                                    </ul>
                                </div>
                            </div>
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