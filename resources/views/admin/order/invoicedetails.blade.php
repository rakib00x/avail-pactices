@extends('admin.masterAdmin')
@section('content')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/pages/app-invoice.css') }}">
@endpush
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">

            <!-- app invoice View Page -->
            <section class="invoice-view-wrapper">
                <div class="row">
                    <!-- invoice view page -->
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card invoice-print-area">
                            <div class="card-content">
                                <div class="card-body pb-0 mx-25">
                                    <?php foreach ($result as $key => $values): ?>
                                        
                                    <?php endforeach ?>
                                    <!-- header section -->
                                    <div class="row">
                                        <div class="col-xl-4 col-md-12">
                                            <span class="invoice-number mr-50">Invoice#</span>
                                            <span>{{ $values->invoice_number }}</span>
                                        </div>
                                        <div class="col-xl-8 col-md-12">
                                            <div class="d-flex align-items-center justify-content-xl-end flex-wrap">
                                                <div class="mr-3">
                                                    <small class="text-muted">Order Date:</small>
                                                    <span>{{ date("d-m-Y", strtotime($values->created_at)) }}</span>
                                                </div>
    
                                            </div>
                                        </div>
                                    </div>
                                    <!-- logo and title -->
<!--                                     <div class="row my-3">
                                        <div class="col-6">
                                            <h4 class="text-primary">Invoice</h4>
                                            <span>Software Development</span>
                                        </div>
                                        <div class="col-6 d-flex justify-content-end">
                                            <img src="app-assets/images/pages/pixinvent-logo.png" alt="logo" height="46" width="164">
                                        </div>
                                    </div> -->
                                    <hr>
                                    <!-- invoice address and contact -->
                                    <div class="row invoice-info">
                                        <div class="col-6 mt-1">
                                            <h6 class="invoice-from">Bill From</h6>
                                            <?php $supplier_info = DB::table('express')->where('id', $values->supplier_id)->first() ; ?>
                                            <div class="mb-1">
                                                <span>{{ $supplier_info->first_name." ".$supplier_info->last_name }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span>{{ $supplier_info->companyAddress }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span>{{ $supplier_info->email }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span>{{ $supplier_info->mobile }}</span>
                                            </div>
                                        </div>
                                        <div class="col-6 mt-1">
                                            <h6 class="invoice-to">Bill To</h6>
                                            <div class="mb-1">
                                                <span>{{ $values->first_name }} {{ $values->last_name }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span></span>
                                            </div>
                                            <div class="mb-1">
                                                <span>{{ $values->email }}</span>
                                            </div>
                                            <div class="mb-1">
                                                <span>{{ $values->mobile }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                </div>
                                <!-- product details table-->
                                <div class="invoice-product-details table-responsive mx-md-25">
                                    <table class="table table-borderless mb-0">
                                        <thead>
                                            <tr class="border-0">
                                                <th scope="col">Item</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Color</th>
                                                <th scope="col">Size</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col" class="text-right">Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $total__amount = 0 ; foreach ($result as $key => $value): ?>
                                                <?php $total__amount += $value->total_price; ?>
                                               <tr>
                                                    <td>{{ $value->product_name }}</td>
                                                    <?php $image_explode = explode("#", $value->products_image); ?>
                                                    <td><img src="{{ URL::to('public/images/'.$image_explode[0])}}" height="50" width="60">
                                                    <td>{{ $value->color_code }}</td>
                                                    <td>{{ $value->size }}</td>
                                                    <td>{{ $value->sale_price }}</td>
                                                    <td>{{ $value->quantity }}</td>
                                                    <td class="text-primary text-right font-weight-bold">{{ $value->total_price }}</td>
                                                </tr> 
                                            <?php endforeach ?>
                                            
                                        </tbody>
                                    </table>
                                </div>

                                <!-- invoice subtotal -->
                                <div class="card-body pt-0 mx-25">
                                    <hr>
                                    <div class="row">
                                        <div class="col-4 col-sm-6 mt-75">
                                            <p>Thanks for your business.</p>
                                        </div>
                                        <div class="col-8 col-sm-6 d-flex justify-content-end mt-75">
                                            <div class="invoice-subtotal">
                                                <div class="invoice-calc d-flex justify-content-between">
                                                    <span class="invoice-title">Subtotal</span>
                                                    <span class="invoice-value">{{ number_format($total__amount, 2) }}</span>
                                                </div>
                                            </div>
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

@endsection
