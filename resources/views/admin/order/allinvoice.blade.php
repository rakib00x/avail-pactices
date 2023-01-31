@extends('admin.masterAdmin')
@section('title','Suppliers Orders List')
@section('content')
 <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- invoice list -->
                <section class="invoice-list-wrapper">
                    <!-- Options and filter dropdown button-->
                    <div class="table-responsive">
                        <table class="table invoice-data-table dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <span class="align-middle">Invoice#</span>
                                    </th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Customer</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($result as $value): ?>
                                   
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <a href="#">INV-{{ $value->invoice_number }}</a>
                                        </td>


                                        <td><span class="invoice-amount">${{ number_format($value->total_price, 2) }}</span></td>
                                        <td><small class="text-muted">{{ $value->created_at }}</small></td>
                                        <td><span class="invoice-customer">{{ $value->storeName }}</span></td>
                                        <td><span class="invoice-customer">{{ $value->first_name." ".$value->last_name }}</span></td>
                                        <td>
                                            <?php if ($value->status == 0): ?>
                                                <span class="badge badge-light-danger badge-pill">Pending</span>
                                            <?php else: ?>
                                                <span class="badge badge-light-success badge-pill">Completed</span>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            <div class="invoice-action">
                                                <a href="{{ URL::to('invoicedetails/'.$value->invoice_number) }}" class="invoice-action-view mr-1">
                                                    <i class="bx bx-show-alt"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
        setTimeout(function(){
            location.reload();
        }, 3000);
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