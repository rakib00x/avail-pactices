@extends('seller.seller-master')
@section('title','Buy Orders List')
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
                        @php
                            $main_currancy_status 	= DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                        @endphp
                        <tbody>
                            <?php foreach ($result as $value): ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <a href="app-invoice.html">INV-{{ $value->invoice_number }}</a>
                                    </td>
                                    <td><span class="invoice-amount">{{ $value->total_quantity }}</span></td>
                                    <td><span class="invoice-amount">
                                        <?php
                                            $result3 = DB::table('order_product')
                                                ->join('tbl_product', 'order_product.product_id', '=', 'tbl_product.id')
                                                ->leftJoin('tbl_product_color', 'order_product.color_id', '=', 'tbl_product_color.id')
                                                ->join('tbl_currency_status', 'tbl_product.currency_id', '=', 'tbl_currency_status.id')
                                                ->leftJoin('tbl_size', 'order_product.size_id', '=', 'tbl_size.id')
                                                ->join('express', 'order_product.customer_id', '=', 'express.id')
                                                ->select('order_product.*', 'tbl_size.size', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_product.product_name', 'tbl_product.currency_id', 'tbl_product.slug', 'tbl_product.products_image', 'express.first_name', 'express.last_name', 'express.email', 'express.mobile' , 'tbl_currency_status.code','tbl_currency_status.rate as currency_rate')
                                                ->where('order_product.customer_id', Session::get('supplier_id'))
                                                ->where('order_product.invoice_number', $value->invoice_number)
                                                ->get() ;
                                            $total__amount = 0; 
                                            foreach($result3 as $o_value){
                                                if(Session::has('requestedCurrency')){
                                                    $main_currancy_status   = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                    $product_price_convert  = $o_value->sale_price / $o_value->currency_rate;
                                                    $now_product_price_is   = $product_price_convert * $main_currancy_status->rate ;
                                                    $currency_code          = $main_currancy_status->symbol;
                                                }else{
                                                    $currency_code          = $o_value->code;
                                                    $now_product_price_is   = $o_value->sale_price;
                                                }
                                                
                                                
                                                
                                                $total_price = $o_value->quantity * $now_product_price_is; 
                                                $total__amount += $total_price; 
                                            }

                                            
                                            echo $currency_code." ".number_format($total__amount, 2);
                                        ?>
                                        
                                    </span></td>
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
                                            <a href="{{ URL::to('sellerOrderBuyDetails/'.$value->invoice_number) }}" class="invoice-action-view mr-1">
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