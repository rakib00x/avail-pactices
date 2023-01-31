@extends('admin.masterAdmin')
@section('title','Seller Payouts')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body"><br>
            <div class="row">
                <div class="col-md-2 col-12"></div>
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Create New Seller Package</h4>
                        </div><hr>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form form-horizontal">
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>Package Name</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="first-name" class="form-control" name="fname" placeholder=" Enter Package Name">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Amount</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="email" id="email-id" class="form-control" name="" placeholder="Enter Amount">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Product Upload</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="number" id="contact-info" class="form-control" name="" placeholder=" Enter Product Upload Number">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Digital Product Upload</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="" class="form-control" name="password" placeholder="Enter Digital Product Upload Number">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Duration</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="password" class="form-control" name="" placeholder="Vaildity in Number of days">
                                            </div>
                                            <div class="col-md-3">
                                                <label>Package Logo</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="file" id="password" class="form-control" name="password" placeholder="Enter Digital Product Upload Number">
                                            </div>
                                            <div class="col-sm-11 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                <button type="reset" class="btn btn-light-secondary mr-1 mb-1">Reset</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12"></div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection