@extends('marketing.employee-master')
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
                                <h4 class="card-title">Earn History</h4>
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
                                                <h3 class="mt-1 ml-50">{{ $data->balance }}</h3>
                                            </div>
                                        </div>
                                        <div class="sessions-analytics">
                                            <i class="bx bx-trending-up align-middle mr-25"></i>
                                            <span class="align-middle text-muted">Pay</span>
                                            <div class="d-flex">
                                                <div id="radial-warning-chart"></div>
                                                <h3 class="mt-1 ml-50">{{ $data->confirm_amount }}</h3>
                                            </div>
                                        </div>
                                        <div class="bounce-rate-analytics">
                                            <i class="bx bx-pie-chart-alt align-middle mr-25"></i>
                                            <span class="align-middle text-muted">Due</span>
                                            <div class="d-flex">
                                                <div id="radial-danger-chart"></div>
                                                <h3 class="mt-1 ml-50">{{ $data->peanding_amount }}</h3>
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
                                            <h2>{{ $data->shop_list }}</h2>
                                            <span class="text-muted">Client Add</span>
                                            <div id="success-line-chart"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>
                    
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
           {{-- <section class="invoice-list-wrapper">
                <!-- create invoice button-->
                <!-- Options and filter dropdown button-->
                <div class="table-responsive">
	<h1 class="pl-5">Hi ({{ $data->name }})</h1>
	<table class="table table-hover pl-5">
                      <thead>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th></th>
                      </thead>
                      <tbody>
                         <tr>
                           <td>{{ $data->name }}</td>
                           <td>{{ $data->email }}</td>
                           <td>{{ $data->mobile }}</td>
                            <td><a href="{{ route('auth.logout') }}">Logout</a></td>
                         </tr>
                      </tbody>
                   </table>
                   </div>
                </section>
             </div>
          </div>
       </div>--}}
@endsection