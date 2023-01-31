@extends('frontEnd.master')
@section('title')
Cart Page
@endsection
@section('content')
@php
    $main_currancy_status 	= DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
@endphp
<div class="wrapper">
            <div class="container">
        <!-- start of the four box -->
        <div class="columns is-gapless">

            <div class="column is-three-quarters mr-3 mb-3">
                @if (!empty(Session::get('success')))
                <article class="message is-success">
                  <div class="message-header">
                    <p><?php
                    $message2 = Session::get('success');
                    if($message2){
                            echo '<strong>'.$message2.'</strong>';
                            Session::put('success',null);
                        }
                    ?></p>
                  </div>
                </article>
                @endif               

                @if (!empty(Session::get('errors')))
                <article class="message is-danger">
                  <div class="message-header">
                    <p><?php
                    $message3 = Session::get('errors');
                    if($message3){
                            echo '<strong>'.$message3.'</strong>';
                            Session::put('errors',null);
                        }
                    ?></p>
                  </div>
                </article>
                @endif
                <div class="columns p-4">
                    <div class="column box">
                        <input type="checkbox" id="checkall" name="select_all_item"> <label>Select all items ({{ $total_product }})</label>
                    </div>
                </div>
                <?php foreach ($result as $value): ?>
                <div class="columns p-4">
                    <div class="column box">

                        <input type="checkbox" class="check-common check-company-<?php echo $value->id; ?>" sonia="supplier" supllierid="{{ $value->id }}" name="select_all_item"><label class="pl-3">{{ $value->storeName }}</label>
                        <a href="#" onclick="supplierChatPageShow({{ $value->customer_id }}, {{ $value->supplier_id }}, '{{ $value->storeName }}')"><span style="float: right;">Live Messages</span></a>
                        <hr width="100%">

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
                        <div class="cart">
                            <div class="cart-container">
                                <div class="cart-checkbox">
                                    <input type="checkbox" class="checked_value check-common check-me-<?php echo $value->id; ?>" name="select_all_item" onclick="changeclickstatus(<?php echo $product->id; ?>)" value="<?php echo $product->id; ?>">
                                </div>
                                <div class="cart-img">
                                    <?php $first_image_explode = explode("#", $product->products_image); ?>
                                    <img src="{{ URL::to('public/images/'.$first_image_explode[0]) }}" alt="" style="width:60px;height:60px;">
                                </div>
                                <div class="cart-text">
                                    <a href="{{ URL::to('product/'.$product->slug)}}">{{ $product->product_name }}</a>
                                </div>
                                <div class="cart-close">
                                    <a href="{{ URL::to('removeproductfromcart/'.$value->id) }}" title="Remove" onclick="return confirm('Are you want to remove this product ??')"><span style="float: right;">X</span></a>
                                </div>
                            </div>
                            <div class="cart-increase-decrease">
                                <div class="cart-color">
                                    <?php if ($product->color_id > 0): ?>
                                        <p>COLOR : <?php if ($product->color_code != null): ?>
                                            <span style="background:#{{ $product->color_code }}" style="width20px;hight:20px;"></span>
                                        <?php else: ?></p>
                                            <img src="{{ URL::to('public/images/'.$product->color_image) }}" alt="" width="20px" height="20px">
                                        <?php endif ?></p>
                                    <?php endif ?>
                                    
                                </div>

                                <div class="cart-size">
                                    <?php if ($product->size_id > 0): ?>
                                        <p>SIZE : {{ $product->size }}</p>
                                    <?php endif ?>
                                </div>
                                <div class="cart-price">
                                    <p>{{ cartPrice($product->id) }}</p>
                                    <input type="hidden" id="single_price_<?php echo $product->id; ?>" value="{{ cartBasePrice($product->id) }}">
                                </div>
                                <div class="cart-inde">
                                    <div class="field has-addons">
                                        <span class="control"><a class="button decreament" onclick="cartdecreament(<?php echo $product->id ; ?>)"><span style="font-size: 20px;padding-bottom: 4px; margin: 0px;" >-</span></a></span>
                                        <span class="control"><input class="input idinput" id="quantity_<?php echo $product->id ; ?>" value="<?php echo intval($product->quantity); ?>" type="text" onkeyup="changevalue(<?php echo $product->id ; ?>)"></span>
                                        <span class="control">
                                            <a class="button increament" onclick="cartIncreement(<?php echo $product->id ; ?>)">
                                                <span style="font-size: 20px;padding-bottom: 4px; margin: 0px;">+</span>
                                            </a>
                                        </span>
                                    </div>
                                </div>
                                <div class="cart-result">
                                    <p><span id="total_price_<?php echo $product->id; ?>">
                                    <?php
                                    
                                        if($product->sale_price > 0){
                                            $cart_single_price = cartBasePrice($product->id);
                                            $total_amount = $cart_single_price * $product->quantity ;
                                            echo $main_currancy_status->symbol." ".number_format($total_amount,2) ;
                                        }else{
                                            echo ucwords($product->sale_price);
                                        }
                                     ?>
                                </span></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>

                    </div>
                </div>
                <?php endforeach ?>

            </div>

            <div class="column is-auto mr-3 mb-5">
                <div class="box">
                    <h1 class="pl-5 pt-3" style="font-size: 20px;font-weight: bold;">Summary</h1>
                    <div class="pl-5 pr-5 mb-5">
                        <table width="100%">
                            <tr>
                                <td>Product Price</td>
                                <td style="text-align: right;">{{ $main_currancy_status->symbol }} <span class="total_price_main">0.00</span></td>
                            </tr>
                            <tr>
                                <td>Store Coupon</td>
                                <td style="text-align: right;">-{{ $main_currancy_status->symbol }} 0</td>
                            </tr>
                            <tr>
                                <td colspan="2"><hr></td>
                            </tr>
                            <tr>
                                <td>Subtotal:</td>
                                <td style="text-align: right;"><b>{{ $main_currancy_status->symbol }} <span class="total_price_main">0.00</span></b></td>
                            </tr>
                            <tr>
                                <td><p>(Excluding shipping fee and tax) </p></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="{{ URL::to('order') }}" title=""><input  class="placeorder" type="submit" id="data_info_id" value="Place Order"></a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php if(count($result) > 0){ 
                $supplier_name_info = $value->first_name." ".$value->last_name; 
            }else{ $supplier_name_info = "" ;} ?>
            

        </div>
        <!-- end of the four box -->
    </div>
    </div>
    <!-- end of Supplier's popular products -->
@endsection
@section('js')
<script>
    function chatshowpage(product_id,receiver_id, senderid){
        
        
        if(senderid == 0){
            $("#login_modal").modal('show');
            return false ;
        }
        
        $(".chat-popup").show();
        $('.chat-btn').hide();

        $(".sonia").css({backgroundColor: 'white'});
        var supplier_name = '<?php echo $supplier_name_info; ?>';
       
        $('.supplier-name-holder').empty();
        $('.supplier-name-holder').text(supplier_name);
           
        $('#receiver_id_by_ajax').empty();
        $('#receiver_id_by_ajax').val(receiver_id);
        
        $.ajaxSetup({
        	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
        	'url':"{{ url('/insertProductChatInfo') }}",
        	'type':'post',
        	'dataType':'text',
        	data:{product_id:product_id,receiver_id:receiver_id, sender_id:senderid},
        	success:function(data)
        	{
        	    if(data != 2){
        	        $(".chat-members").append(data);
        	    }else{
        	        $(".sonia").css({backgroundColor: 'white'});
        	        $(".member_with_"+receiver_id).css({backgroundColor: '#ffefb3'}) ;
        	    }

        		$.ajax({
                	'url':"{{ url('/loadMessages') }}",
                	'type':'post',
                	'dataType':'text',
                	data:{receiver_id:receiver_id},
                	success:function(data)
                	{
                        $("#loadChat").empty();
                        $("#loadChat").html(data);
                        $(".chat-window .chat-details").animate({ scrollTop: 9999999 }, 'slow');
                	}
                });
        		
        	}
        });


    }
</script>
    <script type='text/javascript'>
        $(document).ready(function(){

            // Check or Uncheck All checkboxes
            $("#checkall").change(function(){
                var checked = $(this).is(':checked');
                if(checked){
                    $(".check-common").each(function(){
                        $(this).prop("checked",true);
                    });

                    let opts = $(".checked_value:checked").map((i, el) => el.value).get();
        
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        'url':"{{ url('/updatecartmaininfo') }}",
                        'type':'post',
                        'dataType':'text',
                        data:{opts:opts},
                        success:function(data)
                        {
                            $('.total_price_main').empty().append(data) ;
                            var total_amount = "Place Order ("+data+")" ;
                            $('#data_info_id').append(total_amount) ;
                        }
                    });
                }else{
                    $(".check-common").each(function(){
                        $(this).prop("checked",false);
                    });

                    let opts = $(".checked_value:checked").map((i, el) => el.value).get();
        
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        'url':"{{ url('/updatecartmaininfo') }}",
                        'type':'post',
                        'dataType':'text',
                        data:{opts:opts},
                        success:function(data)
                        {
                            $('.total_price_main').empty().append(data) ;
                            var total_amount = "Place Order ("+data+")" ;
                            $('#data_info_id').append(total_amount) ;
                        }
                    });
                }
            });

            //Changing state of CheckAll checkbox
            $(".check-common").click(function(){

                if($(".check-common").length == $(".check-common:checked").length) {
                    $("#checkall").prop("checked", true);
                } else {
                    $("#checkall").prop("checked", false);
                }

            });

            // Check or Uncheck All checkboxes
            $('body').on("click","[sonia='supplier']",function() {

                var supllierid = $(this).attr("supllierid");

                $(".check-company-"+supllierid).change(function(){
                    var checked = $(this).is(':checked');
                    if(checked){
                        $(".check-me-"+supllierid).each(function(){
                            $(this).prop("checked",true);
                        });

                        let opts = $(".checked_value:checked").map((i, el) => el.value).get(); 

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/updatecartmaininfo') }}",
                            'type':'post',
                            'dataType':'text',
                            data:{opts:opts},
                            success:function(data)
                            {
                                $('.total_price_main').empty().append(data) ;
                                var total_amount = "Place Order ("+data+")" ;
                                $('#data_info_id').append(total_amount) ;
                            }
                        });
                    }else{
                        $(".check-me-"+supllierid).each(function(){
                            $(this).prop("checked",false);
                        });

                        let opts = $(".checked_value:checked").map((i, el) => el.value).get();
                    
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/updatecartmaininfo') }}",
                            'type':'post',
                            'dataType':'text',
                            data:{opts:opts},
                            success:function(data)
                            {
                                $('.total_price_main').empty().append(data) ;
                                var total_amount = "Place Order ("+data+")" ;
                                $('#data_info_id').append(total_amount) ;
                            }
                        });
                    }
                });

                $(".check-me-"+supllierid).click(function(){

                    if($(".check-me-"+supllierid).length == $(".check-me-"+supllierid+":checked").length) {
                        $(".check-company-"+supllierid).prop("checked", true);
                        let opts = $(".checked_value:checked").map((i, el) => el.value).get();

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/updatecartmaininfo') }}",
                            'type':'post',
                            'dataType':'text',
                            data:{opts:opts},
                            success:function(data)
                            {
                                $('.total_price_main').empty().append(data) ;
                                var total_amount = "Place Order ("+data+")" ;
                                $('#data_info_id').append(total_amount) ;
                            }
                        });
                    } else {
                        $(".check-company-"+supllierid).prop("checked", false);

                        let opts = $(".checked_value:checked").map((i, el) => el.value).get();
            
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/updatecartmaininfo') }}",
                            'type':'post',
                            'dataType':'text',
                            data:{opts:opts},
                            success:function(data)
                            {
                                $('.total_price_main').empty().append(data) ;
                                var total_amount = "Place Order ("+data+")" ;
                                $('#data_info_id').append(total_amount) ;
                            }
                        });
                    }

                });

                $(".check-common").click(function(){

                    if($(".check-common").length == $(".check-common:checked").length) {
                        $("#checkall").prop("checked", true);

                        let opts = $(".checked_value:checked").map((i, el) => el.value).get();

                        console.log(opts) ;
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/updatecartmaininfo') }}",
                            'type':'post',
                            'dataType':'text',
                            data:{opts:opts},
                            success:function(data)
                            {
                                $('.total_price_main').empty().append(data) ;
                                var total_amount = "Place Order ("+data+")" ;
                                $('#data_info_id').append(total_amount) ;
                            }
                        });
                    } else {
                        $("#checkall").prop("checked", false);
                        let opts = $(".checked_value:checked").map((i, el) => el.value).get();
            
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/updatecartmaininfo') }}",
                            'type':'post',
                            'dataType':'text',
                            data:{opts:opts},
                            success:function(data)
                            {
                                $('.total_price_main').empty().append(data) ;
                                var total_amount = "Place Order ("+data+")" ;
                                $('#data_info_id').append(total_amount) ;
                            }
                        });
                    }

                });

            });



            // $(':checkbox').change(e => {

            //     let opts = $(".checked_value:checked").map((i, el) => el.value).get();

            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });

            //     $.ajax({
            //         'url':"{{ url('/updatecartmaininfo') }}",
            //         'type':'post',
            //         'dataType':'text',
            //         data:{opts:opts},
            //         success:function(data)
            //         {
            //             $('.total_price_main').empty().append(data) ;
            //             var total_amount = "Place Order ("+data+")" ;
            //             $('#data_info_id').append(total_amount) ;
            //         }
            //     });

            // });

        });

        function changeclickstatus(id) {
            let opts = $(".checked_value:checked").map((i, el) => el.value).get();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/updatecartmaininfo') }}",
                'type':'post',
                'dataType':'text',
                data:{opts:opts},
                success:function(data)
                {
                    $('.total_price_main').empty().append(data) ;
                    var total_amount = "Place Order ("+data+")" ;
                    $('#data_info_id').append(total_amount) ;
                }
            });
        }

        function cartIncreement(cart_id) {

                var quantity     = $("#quantity_"+cart_id).val() ;
                var single_price = $("#single_price_"+cart_id).val() ;
                $(this).prop('desabled', true);
                var final_total_quantity = parseFloat(quantity) + 1 ;
                var final_total_amount = final_total_quantity * parseFloat(single_price) ;

                $('#quantity_'+cart_id).val(parseInt(quantity) + 1) ;
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
                        $('.total_price_main').empty().append(data) ;

                    }
                });
            }

        function cartdecreament(cart_id) {

            var quantity     = $("#quantity_"+cart_id).val() ;
            var single_price = $("#single_price_"+cart_id).val() ;
            $(this).prop('desabled', true);
            var final_total_quantity1 = parseFloat(quantity) - 1 ;
            
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
                    $('.total_price_main').empty().append(data) ;

                }
            });
        }
    </script>
@endsection
