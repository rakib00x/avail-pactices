@extends('admin.masterAdmin')
@section('title','Seller Payouts')
@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
           
            <div class="content-body">
                <!-- users list start -->
                <section class="users-list-wrapper">
                  
                        <div class="card">
                            <div class="card-content">

                                <div class="card-body">
                                    <a role="button" aria-pressed="true" class="float-right btn btn-primary btn-md" href="{{URL::to('/addSellerPackage')}}">+ Add New Package</a><br><br>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <img class="img-fluid" src="public/app-assets/images/slider/10.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title" style="text-align: center">Bronze</h4>
                                        <h2 class="card-title"style="text-align: center">$100.00</h2>
                                        <p class="card-text"style="text-align: center">Product Upload: 20</p>
                                        <p class="card-text"style="text-align: center">Digital Product Upload: 20</p>
                                        <p class="card-text"style="text-align: center">Package Duration: 30 Days</p>
                                    </div>
                                </div>
                               <div class="card-footer d-flex justify-content-between">
                                    <button class="btn btn-light-success"><a href="{{URL::to('/updateSellerPackage')}}">Edit</a></button>
                                    <button  class="btn btn-light-danger">
                                   <a href="" onclick="return confirm('Are you Sure to Delete it ?')"> Delete</a></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    
                                    <img class="img-fluid" src="public/app-assets/images/slider/10.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title" style="text-align: center">Bronze</h4>
                                        <h2 class="card-title"style="text-align: center">$100.00</h2>
                                        <p class="card-text"style="text-align: center">Product Upload: 20</p>
                                        <p class="card-text"style="text-align: center">Digital Product Upload: 20</p>
                                        <p class="card-text"style="text-align: center">Package Duration: 30 Days</p>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <button class="btn btn-light-success"><a href="{{URL::to('/updateSellerPackage')}}">Edit</a></button>
                                    <button  class="btn btn-light-danger">
                                   <a href="" onclick="return confirm('Are you Sure to Delete it ?')"> Delete</a></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    
                                    <img class="img-fluid" src="public/app-assets/images/slider/10.png" alt="Card image cap">
                                    <div class="card-body">
                                        <h4 class="card-title" style="text-align: center">Bronze</h4>
                                        <h2 class="card-title"style="text-align: center">$100.00</h2>
                                        <p class="card-text"style="text-align: center">Product Upload: 20</p>
                                        <p class="card-text"style="text-align: center">Digital Product Upload: 20</p>
                                        <p class="card-text"style="text-align: center">Package Duration: 30 Days</p>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <button class="btn btn-light-success"><a href="{{URL::to('/updateSellerPackage')}}">Edit</a></button>
                                    <button  class="btn btn-light-danger">
                                   <a href="" onclick="return confirm('Are you Sure to Delete it ?')"> Delete</a></button>
                                </div>
                            </div>
                        </div>
                        </div>
                </section>
                <!-- users list ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection