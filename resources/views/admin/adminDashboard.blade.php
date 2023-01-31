@extends('admin.masterAdmin')
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
                    <!-- Website Analytics Starts-->
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Website User</h4>
                                <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-1">
                                    <div class="d-flex justify-content-around align-items-center flex-wrap">
                                        <div class="user-analytics">
                                          
                                           
                                           
                                            <i class="bx bx-user mr-25 align-middle"></i>
                                            <span class="align-middle text-muted">Supplier</span>
                                            <div class="d-flex">
                                                <div id="radial-success-chart"></div>
                                                <h3 class="mt-1 ml-50">
                                                 <?php 
                                                $supplier_count =DB::table('express')->where('type', 2)->count() ;
                                                    
                                                echo $supplier_count;
                                            ?>
                                                
                                                
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="sessions-analytics">
                                            <i class="bx bx-trending-up align-middle mr-25"></i>
                                            <span class="align-middle text-muted">Buyer</span>
                                            <div class="d-flex">
                                                <div id="radial-warning-chart"></div>
                                                <h3 class="mt-1 ml-50">
                                                    <?php 
                                                $buyer_count =DB::table('express')->where('type', 3)->count() ;
                                                    
                                                echo $buyer_count;
                                            ?></h3>
                                            </div>
                                        </div>
                                        <div class="bounce-rate-analytics">
                                            <i class="bx bx-pie-chart-alt align-middle mr-25"></i>
                                            <span class="align-middle text-muted">Total Employee</span>
                                            <div class="d-flex">
                                                <div id="radial-danger-chart"></div>
                                                <h3 class="mt-1 ml-50">
                                                    <?php 
                                                     $employe_count =DB::table('marketings')->count() ;
                                                      echo $employe_count;
                                                     
                                                    ?>
                                                    </h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="analytics-bar-chart"></div>
                                </div>
                            </div>
                        </div>
                        
                        

                    </div>
                    <div class="col-xl-3 col-md-6 col-sm-12 dashboard-referral-impression">
                        <div class="row">
                            <!-- Referral Chart Starts-->
                            <div class="col-xl-12 col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body text-center pb-0">
                                            <h2>
                                            <?php 
                                                 $total_product =DB::table('tbl_product')->count() ;
                                                  echo $total_product;
                                                     
                                            ?>
                                                    </h2>
                                            <span class="text-muted">Total Product</span>
                                            <div id="success-line-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <div class="col-xl-3 col-md-12 col-sm-12">
                        <div class="row">
                            <!-- Conversion Chart Starts-->
                            
                            <div class="col-xl-12 col-md-6 col-12">
                                <div class="row">
                                    <div class="col-12">
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
                                                   $total_order =DB::table('order')->count() ;
                                                  echo $total_order;
                                                     
                                            ?></h5>
                                                        <small class="text-muted">Order</small>
                                                    </div>
                                                </div>
                                                <div id="warning-line-chart"></div>
                                            </div>
                                        </div>
                                    </div>
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