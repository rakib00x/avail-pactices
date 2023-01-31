@extends('frontEnd.master')
@section('title')
Cart Page
@endsection
@section('content')



	<div class="wrapper">
		    <div class="container">
        <!-- start of the four box -->
        <div class="columns is-gapless">
            <div class="column is-three-quarters mr-3 mb-3">

                 @if (!empty(Session::get('success')))
                <article class="message is-danger">
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

                <div class="columns p-4">
                    <div class="column box p-5">
                        <table width="100%">
                            <tr>
                                <td style="width: 200px;">Shipping address</td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <?php 
            	        if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){
            	            if(Session::get('supplier_id') != null){
            	                $main_login_id = Session::get('supplier_id');
            	            }else{
            	                $main_login_id = Session::get('buyer_id');
            	            }
            	        }else{
            	            $main_login_id = 0;
            	        }
            	    ?>
                                @php
                                    $user = DB::table('express')->where('id',$main_login_id)->first();

                                    $address_info = DB::table('tbl_shipping_address')
                                        ->join('tbl_countries', 'tbl_shipping_address.country_id', '=', 'tbl_countries.id')
                                        ->select('tbl_shipping_address.*', 'tbl_countries.countryName')
                                        ->where('tbl_shipping_address.express_id', $main_login_id)
                                        ->where('tbl_shipping_address.status', 1)
                                        ->first() ;
                                @endphp
                                @if($address_info)
                                <td>
                                    <p><?php echo $address_info->contact_name;?>, <?php echo $address_info->address;?>,<?php echo $address_info->state_name;?></p>
                                    <p><?php echo $address_info->city_name;?>, <?php echo $address_info->zip_code;?>, <?php echo $address_info->countryName;?></p>
                                </td>
                                @endif
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td><a href="#" onclick="changeAddress(event)">Change Address</a>  <a href="#" onclick="showChangeModal(event)">Add an address</a></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="columns p-4">
                

                    <?php  foreach ($result as $key => $value): ?>
                    <div class="column box">
                        <label class="pl-3" style="font-size:18px;font-weight: 500;">Order {{ $key+1 }}</label>
                        <a herf="#" onclick="chatshowpage({{ $value->product_id }},{{ $value->supplier_id }},<?php echo $main_login_id; ?>)"><span style="float: right;">Live Messages</span></a>
                        <br>
                        <p class="pl-3" style="font-size:16px;font-weight: 500;">{{ $value->storeName }}</p>

                        <label class="pl-3"></label>
                        <hr width="100%">

                        <?php
                            $all_product = DB::table('cart')
                                ->join('tbl_product', 'cart.product_id', '=', 'tbl_product.id')
                                ->leftJoin('tbl_product_color', 'cart.color_id', '=', 'tbl_product_color.id')
                                ->leftJoin('tbl_size', 'cart.size_id', '=', 'tbl_size.id')
                                ->select('cart.*', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.slug', 'tbl_product_color.color_code', 'tbl_product_color.color_image', 'tbl_size.size')
                                ->where('cart.supplier_id', $value->supplier_id)
                                ->where('cart.customer_id', $value->customer_id)
                                ->where('cart.status', 1)
                                ->get() ;
                            foreach($all_product as $product):
                         ?>
                        <div class="cart">
                            <div class="cart-container">
                                <div class="cart-img">
                                    <?php $first_image_explode = explode("#", $product->products_image); ?>
                                    <img src="{{ URL::to('public/images/'.$first_image_explode[0]) }}" alt="" style="width:60px;height:60px;">
                                </div>
                                <div class="cart-text">
                                    <a href="{{ URL::to('product/'.$product->slug)}}">{{ Str::limit($product->product_name,30) }}</a>
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
                                    <p> {{ cartPrice($product->id) }} x {{ $product->quantity }}</p>
                                </div>

                                <div class="cart-result">
                                    <p><?php 
                                        $main_currancy_status 	= DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;

                                        if($product->sale_price > 0){
                                            $cart_single_price = cartBasePrice($product->id);
                                            $total_amount = $cart_single_price * $product->quantity ;
                                            echo $main_currancy_status->symbol." ".number_format($total_amount,2) ;
                                        }else{
                                            echo ucwords($product->sale_price);
                                        }
                                     ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>

                    </div>
                    <?php endforeach ?>

                </div>
            </div>

            <div class="column is-auto mr-3 mb-5">
                <div class="box">
                    <h1 class="pl-5 pt-3" style="font-size: 20px;font-weight: bold;">Summary</h1>
                    <div class="pl-5 pr-5 mb-5">
                        <table width="100%">
                            <tr>
                                <td>{{ $order_count }} order(s) to pay:</td>
                                <td style="text-align: right;">{{ $main_currancy_status->symbol }} {{ number_format($total_order_price ,2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>

                                <td colspan="2">
                                    <a href="#" onclick="submitorder(event)" title="Place Order">
                                        <input class="placeorder" type="submit" value="Place Order">
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            </div>

        </div>
        <!-- end of the four box -->
    </div>
	</div>
	<!-- end of Supplier's popular products -->

    
    <!-- start of sending message to supplier -->
    <div id="change" style="width: 600px !important;" class="container modal">
        <div class="columns is-gapless">
            <div class="column is-full" style="background: #fff; height: 595px;">
                <div class="login-box">
                    <center><h1 style="font-size: 30px;">Add Shipping Address</h1></center>

                    {!! Form::open(['url' =>'customerAddNewAddress','method' => 'post','role' => 'form', 'files' => true]) !!}
                    
                        <table width="100%">
                            <tr>
                                <td>
                                    <label>Country: </label><br>
                                    <?php 
                                        $all_coutnry_info = DB::table('tbl_countries')
                                            ->orderBy('countryName', 'asc')
                                            ->get() ;
                                    ?>
                                    <select class="reg-input" id="country" name="country" required="">
                                        <option value="">Select Country</option>
                                        <?php foreach ($all_coutnry_info as $coutnry): ?>
                                            <option value="{{ $coutnry->id }}" <?php if($coutnry->countryCode == Session::get('countrycode')){echo "selected"; } ?> style="font-size:24px;">{{ $coutnry->countryName }}</option>
                                        <?php endforeach ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Address: </label><br>
                                    <input class="login-text" type="text" name="address" placeholder="address"  required="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>State/Province </label><br>
                                    <input class="login-text" type="text" name="state" placeholder="State/Province" required="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>City </label><br>
                                    <input class="login-text" type="text" name="city" placeholder="City"  required="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Zip Code </label><br>
                                    <input class="login-text" type="text" name="zip_code" placeholder="Zip Code" required="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Contact Name </label><br>
                                    <input class="login-text" type="text" name="contact_name" placeholder="contact_name"  required="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Phone Number</label>
                                    <input class="login-text" type="text" name="phone_number" placeholder="phone number with country code">
                                </td>
                            </tr>
                            
                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                            </tr>

                            <input type="hidden" name="express_id" value="{{ $main_login_id }}">
                            <tr>
                                <td>
                                    <button class="signin" type="submit" >Submit</button>
                                </td>
                                
                            </tr>
                            
                        </table>
                    {!! Form::close() !!}
                

                </div>
            </div>
        </div>
    </div>


    <!-- start of sending message to supplier -->
    <div id="all_address" style="width: 600px !important;" class="container modal">
        <div class="columns is-gapless">
            <div class="column is-full" style="background: #fff; height: 595px;">
                <div class="login-box">
                    <center><h1 style="font-size: 30px;">Add Shipping Address</h1></center>
                    @php
                        $user = DB::table('express')->where('id',$main_login_id)->first();

                        $address_info = DB::table('tbl_shipping_address')
                            ->join('tbl_countries', 'tbl_shipping_address.country_id', '=', 'tbl_countries.id')
                            ->select('tbl_shipping_address.*', 'tbl_countries.countryName')
                            ->where('tbl_shipping_address.express_id', $main_login_id)
                            ->get() ;
                    @endphp

                    
                    <table class="table is-bordered" width="100%">
                        @foreach($address_info as $saddress)
                            <tr>
                                <td style="cursor:pointer;" onclick="setDefaultAddressInCustomer(event, {{ $saddress->id }}, {{ $main_login_id }})">
                                    <p><?php echo $saddress->contact_name;?>, <?php echo $saddress->address;?>,<?php echo $saddress->state_name;?></p>
                                    <p><?php echo $saddress->city_name;?>, <?php echo $saddress->zip_code;?>, <?php echo $saddress->countryName;?></p>
                                </td>
                            </tr>
                        @endforeach
                    </table>


                </div>
            </div>
        </div>
    </div>
	


@endsection
@section('js')



<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}","success", { positionClass: 'toast-top-center', });
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
<script>
    function chatshowpage(product_id,receiver_id, senderid){
        
        
        if(senderid == 0){
            $("#login_modal").modal('show');
            return false ;
        }
        
        $(".chat-popup").show();
        $('.chat-btn').hide();

        $(".sonia").css({backgroundColor: 'white'});
        var supplier_name = '<?php echo $value->storeName; ?>';
       
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
<script>
    function showChangeModal(event)
    {
        event.preventDefault() ;
        $("#change").modal('show');
        return false ;
    }


    function changeAddress(event)
    {
        event.preventDefault() ;
        $("#all_address").modal('show');
        return false ;
    }

    function setDefaultAddressInCustomer(event, address_id, express_id){
        event.preventDefault() ;


        $.ajaxSetup({
        	headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changeExpressShippingStatus') }}",
            'type':'post',
            'dataType':'text',
            data:{address_id:address_id, express_id:express_id},
            success:function(data)
            {
                toastr.success('Address Change Successfully', "success", { positionClass: 'toast-top-center', });
                setTimeout(() => {
                    location.reload() ;
                }, 3000);
            }
        });

    }

    function submitorder(event) {
        event.preventDefault() ;


        $.ajaxSetup({
        	headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/submitorder') }}",
            'type':'post',
            'dataType':'text',
            success:function(data)
            {
                if(data == "shipping_not"){
                    toastr.warning('Please! Select an shipping address', "warning", { positionClass: 'toast-top-center', });
                    return false ;
                }else{
                    toastr.success('Order Place successfully please wait for seller response', "success", { positionClass: 'toast-top-center', });
                    setTimeout(() => {
                        location.reload() ;
                    }, 3000);
                }

            }
        });
    }

</script>


@endsection

