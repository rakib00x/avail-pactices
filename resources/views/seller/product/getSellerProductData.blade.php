<div class="table-responsive">
   {{-- <button style="margin-bottom: 10px" class="btn btn-primary delete_all" data-url="{{ url('supplierProductsDeleteAll') }}">Delete All Selected</button>--}}
    <table class="table zero-configuration">
        <thead>
            <tr>
                <th>SN</th>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <?php $i=1;?>
        <tbody>
            @foreach($result as $value)
            <tr>
                <td>{{$i++}}</td>
                <?php $image_explode = explode("#", $value->products_image); ?>
                <td><img src="{{ URL::to('public/images/'.$image_explode[0])}}" height="50" width="60">
                </td>
                <td><a href="{{ URL::to('product/'.$value->slug)}}" title="" target="_new">{{ Str::limit($value->product_name, 20) }}</a>
                </td>
                <td>@if ($value->price_type == 3)<p>Negotiate</p>
                    @elseif ($value->price_type == 2)
                    <?php 
                    $price_info = DB::table('tbl_product_price')
                    ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                    ->select('tbl_product_price.*', 'tbl_currency_status.symbol')
                    ->where('tbl_product_price.product_id', $value->id)
                    ->where('tbl_product_price.supplier_id', $value->supplier_id)
                    ->where('tbl_product_price.status', 1)
                    ->first() ;
                    ?>
                        @if($price_info)
                        <span><P style="font-size:12px;">{{$price_info->symbol}}&nbsp;{{$price_info->product_price}}</P></span>
                        @endif
                    @else
                    <?php 
                        $small_price = DB::table('tbl_product_price')
                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                        ->select('tbl_product_price.*', 'tbl_currency_status.symbol')
                        ->where('tbl_product_price.product_id', $value->id)
                        ->where('tbl_product_price.supplier_id', $value->supplier_id)
                        ->min('tbl_product_price.product_price') ;

                    $max_price = DB::table('tbl_product_price')
                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                        ->select('tbl_product_price.*', 'tbl_currency_status.symbol')
                        ->where('tbl_product_price.product_id', $value->id)
                        ->where('tbl_product_price.supplier_id', $value->supplier_id)
                        ->max('tbl_product_price.product_price') ;

                    $price_info_s = DB::table('tbl_product_price')
                        ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=', 'tbl_currency_status.id')
                        ->select('tbl_product_price.*', 'tbl_currency_status.symbol')
                        ->where('tbl_product_price.product_id', $value->id)
                        ->where('tbl_product_price.supplier_id', $value->supplier_id)
                        ->first() ;
                    ?>
                    @if($price_info_s)
                    <span><P style="font-size:12px;">{{$price_info_s->symbol}} {{ $small_price."-".$max_price }}</P></span>
                    @endif
                @endif</td>

                <td>
                    <div class="custom-control custom-switch custom-control-inline mb-1">
                        <input type="checkbox" class="custom-control-input changeProductStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getProductID="{{$value->id}}" id="customSwitch{{$value->id}}">
                        <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                    </div>
                </td>

                <td>
                    <div class="invoice-action">
                        <a href="{{ URL::to('/updateSellerProductInformation/'.$value->id) }}" class="invoice-action-edit cursor-pointer">
                            <i class="bx bx-edit"></i>
                        </a>
                        <a class="invoice-action-view mr-1" onclick="deleteProductInfo(<?php echo $value->id; ?>)" >
                            <i class="bx bx-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach

        </tbody>

    </table>
</div>

<script src="{{ URL::to('public/app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/pages/app-invoice.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/datatables/datatable.js')}}"></script>