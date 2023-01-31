@extends('seller.seller-master')
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- invoice list -->
            <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">
                <div class="row">
                    <!-- Website Analytics Starts-->
                    <div class="col-md-6 col-sm-12">
                        <div class="card">
                            
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Product</h4>
                                <i class="bx bx-dots-vertical-rounded font-medium-3 cursor-pointer"></i>
                            </div>
                            <div class="card-content">
                                <div class="card-body pb-1">
                                    <div class="d-flex justify-content-around align-items-center flex-wrap">
                                        <div class="user-analytics">
                                            <i class="bx bx-user mr-25 align-middle"></i>
                                            <span class="align-middle text-muted">Total</span>
                                            <div class="d-flex">
                                                <div id="radial-success-chart"></div>
                                                <h3 class="mt-1 ml-50">{{$total_product}} Product</h3>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    <div id="analytics-bar-chart"></div>
                                </div>
                            </div>
                            
                        </div>
                         
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
                                           {{  $total_orders }}
                                         
                                            
                                        </h5>
                                        <small class="text-muted">Total Orders</small>
                                    </div>
                                </div>
                                <div id="warning-line-chart"></div>
                            </div>
                        </div>
                    

                    </div>
                     
                    
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
@endsection