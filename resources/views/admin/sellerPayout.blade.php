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
                                       <h5>Seller Payments</h5><hr>
                                    <!-- datatable start -->
                                    <div class="table-responsive">
                                        <table id="users-list-datatable" class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Date</th>
                                                    <th>Seller</th>
                                                    <th>Amount</th>
                                                    <th>Payment Details</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>2020-12-09 03:37:42</td>
                                                    <td>HONDA (HONDA)</td>
                                                    <td>$149,791.49</td>
                                                    <td>Cash</td>
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
    </div>
    <!-- END: Content-->
@endsection