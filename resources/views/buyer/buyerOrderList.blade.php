@extends('buyer.masterBuyer')
@section('title','Buyer Orders List')
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- invoice list -->
            <section class="invoice-list-wrapper">
                <!-- create invoice button-->
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
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Date</th>
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
                                        <a href="app-invoice.html">INV-{{ $value->invoice_number }}</a>
                                    </td>
                                    <td><span class="invoice-amount">{{ $value->total_quantity }}</span></td>
                                    <td><span class="invoice-amount">${{ $value->total_price }}</span></td>
                                    <td><small class="text-muted">{{ date("d-m-Y", strtotime($value->created_at)) }}</small></td>
                                    <td>
                                        @if($value->status == 0)
                                            <span class="badge badge-warning">Pendnig</span>
                                        @else
                                            <span class="badge badge-success">Confirmed</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="invoice-action">
                                            <a href="{{ URL::to('buyerOrderDetails/'.$value->invoice_number) }}" class="invoice-action-view mr-1">
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