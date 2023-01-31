@extends('mobile.master-website')
@section('content')
<?php 
    $base_url = "https://availtrade.com/";
?>

        
        <div class="container" style="padding-top: 53px!important;">
            <!-- Cart Wrapper-->
            <div class="cart-wrapper-area py-3">
                <?php foreach ($result as $value): ?>
                    <div class="cart-table card mb-3">
                        <div class="table-responsive card-body">
                            <h6>{{ $value->storeName }}</h6>

                            <table class="table mb-0">
                                <tbody>
                                    <?php
                                        $all_product = DB::table('cart')
                                            ->join('tbl_product', 'cart.product_id', '=', 'tbl_product.id')
                                            ->leftJoin('tbl_product_color', 'cart.color_id', '=', 'tbl_product_color.id')
                                            ->leftJoin('tbl_size', 'cart.size_id', '=', 'tbl_size.id')
                                            ->select('cart.*', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.slug', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_size.size')
                                            ->where('cart.supplier_id', $value->supplier_id)
                                            ->where('cart.customer_id', $value->customer_id)
                                            ->get() ;
                                        foreach($all_product as $product):
                                    ?>
                                    <tr>
                                        <th scope="row"><a class="remove-product" href="{{ URL::to('m/removemobilecart/'.$product->id) }}"><i class="lni lni-close"></i></a></th>
                                        <?php $first_image_explode = explode("#", $product->products_image); ?>
                                        <td>
                                            <?php if ($product->color_id > 0): ?>
                                                <?php if ($product->color_code != null): ?>
                                                    <span style="background:#{{ $product->color_code }}" style="width20px;hight:20px;"></span>
                                                <?php else: ?>
                                                    <img src="<?php echo $base_url."/public/images/".$product->color_image; ?>" alt="">
                                                <?php endif ?></p>
                                            <?php else: ?>
                                                <img src="<?php echo $base_url."/public/images/".$first_image_explode[0]; ?>" alt="">
                                            <?php endif ?>
                                        </td>
                                        <?php 
                                            $product_price_info = DB::table('tbl_product_price')
                                                ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                                ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                                ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                                ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                                ->where('tbl_product_price.product_id', $product->product_id)
                                                ->orderBy('tbl_product_price.product_price', 'asc')
                                                ->first() ;
                                                
                                            if($product->sale_price > 0){
                                                if(Session::has('requestedCurrency')){
                                                    $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                    $product_price_convert = $product->sale_price / $product_price_info->currency_rate;
                                                    $now_product_price_is = $product_price_convert * $main_currancy_status->rate ;
                                                    
                                                    $total_product_price_convert = $product->total_price / $product_price_info->currency_rate;
                                                    $now_total_product_price_is = $total_product_price_convert / $main_currancy_status->rate;
                                                    
                                                    $currency_code = $main_currancy_status->symbol;
                                                    
                                                }else{
                                                    $currency_code              = $product_price_info->code;
                                                    $now_product_price_is       = $product->sale_price;
                                                    $now_total_product_price_is = $product->total_price;

                                                }
                                                
                                            }else{
                                                 ucwords($product_price_info->negotiate_price);
                                            }
                                        ?>
                                        <td><a href="{{ URL::to('product/'.$product->slug) }}">
                                            {{ Str::limit($product->product_name, 20) }}
                                            
                                            <span>{{ $currency_code }} {{ number_format($now_product_price_is, 2) }} </span>
                                                <?php if ($product->size_id > 0): ?>
                                                    <p class="mb-0">SIZE : {{ $product->size }}</p>
                                                <?php endif ?>
                                                <input type="hidden" id="single_price_<?php echo $product->id; ?>" value="<?php echo $now_product_price_is; ?>">
                                            </a>
                                            
                                             <form class="cart-form mt-2" action="#" method="">
                                                <div class="order-plus-minus d-flex align-items-center">
                                                    <div class="quantity-button-handler" onclick="cartdecreament(<?php echo $product->id ; ?>)">-</div>
                                                    <input class="form-control cart-quantity-input" id="quantity_<?php echo $product->id ; ?>" type="text" step="1" name="quantity" value="{{ intVal($product->quantity) }}">
                                                    <div class="quantity-button-handler" onclick="cartIncreement(<?php echo $product->id ; ?>)">+</div>
                                                </div>
                                            </form>
                                                                    
                                        </td>
                                        <td>
                                            <p style="color: #000;font-size: 9.5px;">{{ $currency_code }} <span id="total_price_<?php echo $product->id; ?>">{{ number_format($now_product_price_is*intVal($product->quantity), 2) }}</span></p>
                                        </td>
                                        
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <a class="btn btn-warning" style="float: right !important;" href="{{ URL::to('m/checkout/'.$product->supplier_id) }}">Proceed with this supplier</a>
                        </div>
                    </div>
                <?php endforeach; ?>


            </div>
        </div>
    </div>
@endsection

@section('page_headline')
    Cart
@endsection

@section('js')

<script>
    $("#mobile_currency").change(function(){
	        
        var mobile_currency = $(this).val() ;
        var main_link       = "http://m.availtrade.com/mobilechangeCurrency"+"/"+mobile_currency;
        window.location     = main_link;
    });
</script>

<script type="text/javascript">
    $("[name=supplier_data]").keyup(function(){
        var supplier_info    = $(this).attr("data") ;
        var cart_id          = $(this).attr("rowid") ;
        var mobile_quantity  = $("#rowvalue_"+cart_id).val() ;

        if (mobile_quantity > 0) {
            var quantity = mobile_quantity ;
        }else{
            var quantity = 1 ;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/mobilecartupdate') }}",
            'type':'post',
            'dataType':'text',
            data:{cart_id:cart_id, quantity:quantity},
            success:function(data)
            {

            }
        });
    })
    
    function cartIncreement(cart_id) {

        var quantity     = $("#quantity_"+cart_id).val() ;
        var single_price = $("#single_price_"+cart_id).val() ;
        
        
        $(this).prop('desabled', true);
        var final_total_quantity = parseFloat(quantity) ;
        var final_total_amount = final_total_quantity * parseFloat(single_price) ;

        $('#quantity_'+cart_id).val(parseInt(quantity) ) ;
        $('#total_price_'+cart_id).empty().append(final_total_amount.toFixed(2)) ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/cartIncreementupdate') }}",
            'type':'post',
            'dataType':'text',
            data:{cart_id:cart_id, quantity:quantity},
            success:function(data)
            {
                $(this).prop('desabled', false);
     

            }
        });
    }

    function cartdecreament(cart_id) {

        var quantity     = $("#quantity_"+cart_id).val() ;
        var single_price = $("#single_price_"+cart_id).val() ;
        $(this).prop('desabled', true);
        
        var final_total_quantity1 = parseFloat(quantity) ;
        if (final_total_quantity1 < 2) {
            var final_total_quantity = 1;
        }else{
            var final_total_quantity = final_total_quantity1;
        }

        var final_total_amount = final_total_quantity * parseFloat(single_price) ;
        $('#quantity_'+cart_id).val(parseInt(final_total_quantity)) ;
        $('#total_price_'+cart_id).empty().append(final_total_amount.toFixed(2)) ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/cartdecreamentupdate') }}",
            'type':'post',
            'dataType':'text',
            data:{cart_id:cart_id, quantity:quantity},
            success:function(data)
            {
                $(this).prop('desabled', false);
            }
        });
    }
</script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
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
