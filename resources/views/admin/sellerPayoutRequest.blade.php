@extends('admin.masterAdmin')
@section('title','Seller Payouts')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- users list start -->
            <section class="users-list-wrapper">
                <div class="users-list-table">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <h5>Seller Withdraw Request</h5><hr>
                                <!-- datatable start -->
                                <div class="table-responsive">
                                    <table id="users-list-datatable" class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>Date</th>
                                                <th>Seller</th>
                                                <th>Total Amount to Pay</th>
                                                <th>Requested Amount</th>
                                                <th>Message</th>
                                                <th>Status</th>
                                                <th>Options</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>2020-12-09 03:37:42</td>
                                                <td>HONDA (HONDA)</td>
                                                <td>$149,791.49</td>
                                                <td>$0.00</td>
                                                <td>please send this amount.</td>
                                                <td><span class="badge badge-light-success">Paid</span></td>
                                                <td>
                                                    <div class="invoice-action">
                                                        <a href="" data-toggle="modal" data-target="#default">
                                                            <i class="bx bx-money"></i>
                                                        </a>
                                                        <a href="" data-toggle="modal" data-target="#default1">
                                                            <i class="bx bx-message"></i>
                                                        </a>
                                                        <a href="{{URL::to('/sellerPaymentShow')}}" class="invoice-action-view mr-1">
                                                            <i class="bx bx-history"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- datatable ends -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- users list ends -->
        </div>
    </div>

    <!-- Pay to seller Modal Form -->
    <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel1">Pay to seller</h3>
                    <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form form-horizontal">
                        <div class="form-body">
                            <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-striped table-dark mb-0">
                                        <thead>
                                            <tr>
                                                <th>Due to seller</th>
                                                <th>$0.00</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-bold-500">Requested Amount is   </td>
                                                <td>$850,000.00</td>
                                            </tr>
                                        </tbody>
                                    </table><hr>
                                </div>
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Cancle</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Message  Modal Form -->
<div class="modal fade text-left" id="default1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel1">Seller Message</h3>
                <button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
                    <i class="bx bx-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="form form-horizontal">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label>Message</label>
                            </div>
                            <div class="col-md-9 form-group">
                                <textarea type="text" id="first-name" class="form-control" name="fname" placeholder="Seller Message"></textarea>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Cancle</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- END: Content-->
@endsection