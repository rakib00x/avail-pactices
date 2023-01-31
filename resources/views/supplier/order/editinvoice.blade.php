@extends('supplier.masterSupplier')
@section('content')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/pages/app-invoice.css') }}">
@endpush
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">

            <!-- app invoice View Page -->
            <section class="invoice-edit-wrapper">
                <div class="row">
                    <!-- invoice view page -->
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body pb-0 mx-25">
                                    <?php foreach ($result as $key => $values): ?>
                                        
                                    <?php endforeach ?>
                                    <!-- header section -->
                                    <div class="row mx-0">

                                        <div class="col-xl-4 col-md-12 d-flex align-items-center pl-0">
                                            <h6 class="invoice-number mr-75">Invoice#</h6>
                                            <input type="text" class="form-control pt-25 w-50" value="{{ $values->invoice_number }}" readonly="">
                                        </div>
                                        <div class="col-xl-8 col-md-12 px-0 pt-xl-0 pt-1">
                                            <div class="invoice-date-picker d-flex align-items-center justify-content-xl-end flex-wrap">
                                                <div class="d-flex align-items-center">
                                                    <small class="text-muted mr-75">Date Issue: </small>
                                                    <fieldset class="d-flex">
                                                        <input type="text" class="form-control pickadate mr-2 mb-50 mb-sm-0" value='{{ date("d-m-Y", strtotime($values->created_at)) }}' readonly="">
                                                    </fieldset>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <small class="text-muted mr-75">Confirm Date: </small>
                                                    <fieldset class="d-flex justify-content-end">
                                                        <input type="text" class="form-control mb-50 mb-sm-0" value='<?php if($values->updated_at){echo date("d-m-Y", strtotime($values->updated_at)) ; }?>' name="updated_at" readonly="">
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    </div>
                                    <hr>

                                    <!-- invoice address and contact -->
                                    <div class="row invoice-info">
                                        <div class="col-lg-1">
                                            
                                        </div>
                                        <div class="col-lg-6 col-md-12 mt-25 pl-10">
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
                                <div class="card-body pt-50">
                                    {!! Form::open(['url' =>'updateinvoiceupdate','method' => 'post','role' => 'form', 'class' => 'form invoice-item-repeater', 'files'=>'true']) !!}
                                        <!-- product details table-->
                                        <div class="invoice-product-details ">
                                            
                                                <div data-repeater-list="group-a">
                                                    <div data-repeater-item>
                                                        <div class="row mb-50">
                                                            <div class="col-2 col-md-2 invoice-item-title">Item</div>
                                                            <div class="col-2 col-md-2 invoice-item-title" style="display:none;">Color</div>
                                                            <div class="col-2 col-md-2 invoice-item-title" style="display:none;">Size</div>
                                                            <div class="col-2 invoice-item-title">Price</div>
                                                            <div class="col-2 invoice-item-title">Qty</div>
                                                            <div class="col-2 col-md-2 invoice-item-title">Total Price</div>
                                                        </div>
                                                        <?php $total__amount = 0 ; foreach ($result as $key => $value): ?>
                                                            <?php $total__amount += $value->total_price; ?>
                                                            <div class="invoice-item d-flex border rounded mb-1">
                                                                <div class="invoice-item-filed row pt-1 px-1">
                                                                    <div class="col-12 col-md-2 form-group">
                                                                        <input type="text" class="form-control invoice-item-desc" value="{{ $value->product_name }}" readonly="">
                                                                    </div>

                                                                    <div class="col-12 col-md-2 form-group" style="display:none;">
                                                                        <input type="text" class="form-control invoice-item-desc" value="{{ $value->color_code }}" readonly="">
                                                                    </div>

                                                                    <div class="col-12 col-md-2 form-group" style="display:none;">
                                                                        <input type="text" class="form-control invoice-item-desc" value="{{ $value->size }}" readonly="">
                                                                    </div>
                                                                    <div class="col-md-2 col-12 form-group">
                                                                        <input type="text" class="form-control sale_price_<?php echo $value->id ; ?>" name="sale_price[]" value="{{ $value->sale_price }}" onchange="changeproductpirce(<?php echo $value->id; ?>)">
                                                                    </div>
                                                                    <div class="col-md-2 col-12 form-group">
                                                                        <input type="text" class="form-control product_quantity_<?php echo $value->id ; ?>" name="quantity[]" value="{{ intval($value->quantity) }}" onchange="changeproductpirce(<?php echo $value->id; ?>)">
                                                                        <input type="hidden" name="primary_id[]" value="{{ $value->id }}">
                                                                    </div>

                                                                    <div class="col-md-2 col-12 form-group">
                                                                        <strong class="text-white align-right total_price_<?php echo $value->id ; ?>" style="float:right">{{ $value->total_price }}</strong>
                                                                        <input type="hidden" class="total_value_section_<?php echo $value->id ?> total_value_collection" name="total_price_section[]" value="{{ $value->total_price }}"  readonly="">
                                                                    </div>
                                                                </div>
                                                                <div class="invoice-icon d-flex flex-column justify-content-between border-left p-25">
                                                                    
                                                                    <span class="cursor-pointer" >
                                                                        <a href="{{ URL::to('deleteorderitem/'.$value->id) }}" title="" onclick="return confirm('Are you sure to remove this item');">
                                                                            <i class="bx bx-x"></i>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        <?php endforeach ?>

                                                    </div>
                                                </div>
                                            
                                        </div>
                                        <!-- invoice subtotal -->
                                        <hr>
                                        <input type="hidden" name="invoice_number" value="{{ $value->invoice_number }}">
                                        <div class="invoice-subtotal pt-50">
                                            <div class="row">
                                                <div class="col-md-5 col-12">
                                                    <div class="form-group">

                                                    </div>
                                                </div>
                                                <div class="col-lg-5 col-md-7 offset-lg-2 col-12">
                                                    <ul class="list-group list-group-flush">

                                                        <li class="list-group-item d-flex justify-content-between border-0 pb-0">
                                                            <span class="invoice-subtotal-title">Subtotal</span>
                                                            <h6 class="invoice-subtotal-value mb-0">{{ number_format($total__amount, 2) }}</h6>
                                                        </li>

                                                        <li class="list-group-item border-0 pb-0">
                                                            <button class="btn btn-primary btn-block subtotal-preview-btn">UPDATE</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    {!! Form::close() !!}
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
@section('js')
<script>
    function changeproductpirce(order_id){
        var sale_price_         = parseFloat($(".sale_price_"+order_id).val()) ;
        var product_quantity_   = parseFloat($(".product_quantity_"+order_id).val()) ;
        var total_price_        = parseFloat($(".total_value_section_"+order_id).val()) ;
        
        var total_price_final  = product_quantity_ * sale_price_ ;
        $(".total_price_"+order_id).empty().append(total_price_final.toFixed(2)) ;
        $(".total_value_section_"+order_id).val(total_price_final.toFixed(2)) ;

        var arr = $('.total_value_collection').map(function () {
            return parseFloat(this.value); // $(this).val()
        }).get();

        // Getting sum of numbers
        var sum = arr.reduce(function(a, b){
            return a + b;
        },0);


        $(".invoice-subtotal-value").empty().append(sum.toFixed(2)) ;
    }
</script>
@endsection 
