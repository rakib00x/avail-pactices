@extends('buyer.masterBuyer')
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
                                    <div class="avatar bg-rgba-warning m-0 p-25 mr-75 mr-xl-2">
                                        <div class="avatar-content">
                                            <i class="bx bx-dollar text-warning font-medium-2"></i>
                                        </div>
                                    </div>
                                   
                                    <div class="total-amount">
                                        <h5 class="mb-0">
                                            <?php
                                                $total_orders = DB::table('order')
                                                    ->where('customer_id', Session::get('buyer_id'))
                                                    ->count() ;
                                                echo $total_orders ;
                                            ?>
                                            
                                        </h5>
                                         <a href="{{URL::to('buyerOrderList')}}">
                                        <small class="text-muted">Total Orders</small>
                                         </a>
                                    </div>
                                   
                                </div>
                                <div id="warning-line-chart"></div>
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

@section('js')
    <script>
        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            switch(type){
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;

                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;

                case 'failed':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
</script>
@endsection