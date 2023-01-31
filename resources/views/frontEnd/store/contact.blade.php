@extends('frontEnd.master')
<?php 
    $store_info = DB::table('express')
        ->join('tbl_countries', 'express.country', '=', 'tbl_countries.id')
        ->select('express.*', 'tbl_countries.countryCode')
        ->where('express.id', $supplier_id)
        ->first() ;

    $banner_info = DB::table('tbl_supplier_header_banner')
        ->where('supplier_id', $supplier_id)
        ->first() ;
        
    $default_banner = DB::table('tbl_default_setting')->first();
    
    $meta_info 	= DB::table('tbl_meta_tags')->first();
	$settings 	= DB::table('tbl_logo_settings')->where('status', 1)->first();
	
	if($banner_info){
	    if($banner_info->header_image){
	        $supplier_main_logo = $banner_info->header_image;
	    }else{
	        $supplier_main_logo = $default_banner->logo;
	    }
	}else{
	    $supplier_main_logo = $default_banner->logo;
	}
?>
@section('title')
{{ $store_info->storeName }}
@endsection

@section('meta_info')

    <meta name="title" content="{{ $store_info->storeName }}">
    <meta name="description" content="{{ $store_info->companyDetails }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ URL::full() }}">
    <meta property="og:title" content="{{ $store_info->storeName }}">
    <meta property="og:description" content="{{ $store_info->companyDetails }}">
    <meta property="og:image" content="{{ URL::to('public/images/'.$supplier_main_logo) }}">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ URL::full() }}">
    <meta property="twitter:title" content="{{ $store_info->storeName }}">
    <meta property="twitter:description" content="{{ $store_info->companyDetails }}">
    <meta property="twitter:image" content="{{ URL::to('public/images/'.$supplier_main_logo) }}">

@endsection
@section('content')
    <style>
        .active{
            background-color: green;
            color: white;
        }
        .active:hover{
            color: white!important;
        }
    </style>
    
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
    <div class="container mt-2 mb-2">

        @include('frontEnd.store.masterStore')


        <div class="columns is-gapless">
            <!-- Left Sidebar -->
            <div class="column is-full">
                <!-- 1st sidebar -->
                <div class="box pl-5 pt-5 pr-5">
                    <div class="columns">
                        <div style="width: 100%;border-left: 1px solid #dbe3ef;border-right: 1px solid #dbe3ef;border-bottom: 1px solid #dbe3ef;">
                            <div class="store-contact-bar">
                                <h1 style="font-size: 22px;color: #000;padding: 7px;">Contact Information</h1>
                            </div>
                            <div class="columns">
                                <div class="column is-two-fifths mt-5 pt-5 mb-5 pb-5">
                                    <center>
                                        <?php if($store_query->image != null): ?>
                                        <img width="140" height="140" src="{{ URL::to('public/images/spplierPro/'.$store_query->image) }}" alt="">
                                        <?php else: ?>
                                        <img width="140" height="140" src="{{ URL::to('public/images/defult/'.$default_banner->logo) }}" alt="">
                                        
                                        <?php endif; ?>
                                        <h1 style="font-size: 25px;"><?php echo $store_query->storeName; ?></h1>
                                        <p>Sales Man</p>
                                        <?php if($main_login_id == 0): ?>
                    				        <p><a href="https://www.availtrade.com/login" ><span>Chat Now</span></a></p>
                    				    <?php else: ?>
                    				        <p><a href="#"  onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
                    				    <?php endif; ?>
                                    </center>
                                </div>
                                <div class="column is-auto mt-5 pt-5 mb-5 pb-5">
                                    <table>
                                        <tr>
                                            <td style="text-align: right;">Telephone</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td><a href="#"><?php $store_query->companyTelephone; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right;">Mobile Phone</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td><a href="#"><?php $store_query->mobile; ?></a></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right;">Zip</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td><?php $store_query->zipPostalCode; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right;">Country/Region</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td><?php echo $store_query->countryName; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right;">Province/State</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td><?php echo $store_query->stateName; ?></td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right;">City</td>
                                            <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                            <td><?php echo $store_query->city; ?></td>
                                        </tr>
                                    </table>
                                    <br>
                                    <table>
                                        <tr>
                                            <td>
                                                <div class="store_contact_supplier">
                                                    <p><a href="#" onclick="sendquotationinfo(<?php echo $store_info->id; ?>, '<?php echo $store_info->storeName;  ?>')"><span>Contact Supplier</span></a></p>
                                                </div>
                                            </td>
                                            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td>
                                                <div class="store_chat_now">
                                                    <?php if($main_login_id == 0): ?>
                                				        <p><a href="https://www.availtrade.com/login" ><span>Chat Now</span></a></p>
                                				    <?php else: ?>
                                				        <p><a href="#"  onclick="supplierChatPageShow({{ $main_login_id }}, {{ $store_info->id }}, '{{ $store_info->first_name." ".$store_info->last_name }}')"><span>Chat Now</span></a></p>
                                				    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns mt-5">
                        <div style="width: 100%;border-left: 1px solid #dbe3ef;border-right: 1px solid #dbe3ef;border-bottom: 1px solid #dbe3ef;">
                            <div class="store-contact-bar">
                                <h1 style="font-size: 22px;color: #000;padding: 7px;">Company Contact Information</h1>
                            </div>
                            <div class="columns">
                                <div class="column is-auto mt-5 pt-5 mb-5 pb-5">
                                    <center>
                                        <table>
                                            <tr>
                                                <td style="text-align: right;">Company Name</td>
                                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                                <td><a href="#"><?php echo $store_query->companyName; ?>.</a></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;">Operational Address</td>
                                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                                <td><a href="#"><?php echo $store_query->companyAddress; ?></a></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;">Website</td>
                                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                                <td><?php echo $store_query->companyWebsite; ?></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right;">Website on alibaba.com</td>
                                                <td>&nbsp;&nbsp;:&nbsp;&nbsp;</td>
                                                <td><a href="{{ URL::to('/') }}">{{ URL::to('/') }}</a></td>
                                            </tr>
                                        </table>
                                        <br/>
                                        <div style="width:100%; <?php if($store_query->googleMapLocation != null){echo ""; }else{echo "display:none"; } ?>">
                                            <iframe src="<?php echo $store_query->googleMapLocation; ?>" width="1000" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                            
                                        </div>

                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="columns mt-5">
                        <div style="width: 100%;border-left: 1px solid #dbe3ef;border-right: 1px solid #dbe3ef;border-bottom: 1px solid #dbe3ef;">
                            <div class="store-contact-bar">
                                <h1 style="font-size: 22px;color: #000;padding: 7px;">Send message to supplier</h1>
                            </div>
                            <div class="columns">
                                <div class="column is-auto mt-5 pt-5 mb-5 pb-5" style="height: 465px;">
                                    <div class="p-5">
                                        <h2>Send your message to this supplier</h2>
                                        <?php if(Session::get('success') != null) { ?>
                                        <div class="alert alert-info alert-dismissible" role="alert">
                                            <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                            <strong><?php echo Session::get('success') ;  ?></strong>
                                            <?php Session::put('success',null) ;  ?>
                                        </div>
                                        <?php } ?>
                                        <?php
                                        if(Session::get('failed') != null) { ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                            <strong><?php echo Session::get('failed') ; ?></strong>
                                            <?php echo Session::put('failed',null) ; ?>
                                        </div>
                                        <?php } ?>
                                        <br>
                                        {!! Form::open(['url' =>'sendsuppliercontactmessage','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <table width="70%">
                                            <tr>
                                                <td style="text-align: right">To:&nbsp;&nbsp;&nbsp;</td>
                                                <td>Rakibul Islam</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right">*Message:&nbsp;&nbsp;&nbsp;</td>
                                                <td colspan="3">
                                                    <textarea class="textarea" placeholder="e.g. Hello world" name="message" required=""></textarea>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right"></td>
                                                <td colspan="3">
                                                    <label class="checkbox">
                                                        <input type="checkbox"  required="">
                                                        Recommend matching suppliers if this supplier doesn’t contact me on Message Center within 24 hours.
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right"></td>
                                                <td colspan="3">
                                                    <label class="checkbox">
                                                        <input type="checkbox"  checked required="">
                                                        agree to share my Business Card to the supplier.
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: right"></td>
                                                <td colspan="3">
                                                    <button class="button is-danger">Send</button>
                                                </td>
                                            </tr>
                                        </table>
                                        <input type="hidden" name="supplierid" value="{{ $supplier_id }}">
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection

@section('store_social_network')
    <div class="container">
        <div class="columns">
            <?php $social_icon = DB::table('tbl_social_media')->where('supplier_id', $supplier_id)->first() ; ?>
            <div class="column is-half is-offset-two-fifths">
                <ul class="store_social">
                    <li><a href="<?php if($social_icon){echo $social_icon->facebook;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/fb.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->twitter;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/003-twitter.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->linkedin;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/002-linkedin.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->google;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/004-search.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->pinterest;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/001-pinterest.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->instagram;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/005-instagram.png') }}"></a></li>
                    <li><a href="<?php if($social_icon){echo $social_icon->youtube;}else{echo ""; } ?>" target="_new"><img style="width:48px;height:48px" src="{{ URL::to('public/images/social/006-youtube.png') }}"></a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/storeSlider.css') }}">
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/supplierSlider.css') }}">

    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/store.css') }}">
    <link rel="stylesheet" href="{{ URL::to('public/frontEnd/assets/css/store_nested_menu.css') }}">

    <style>
        .store_social ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .store_social li {
            float: left;
        }

        .store_social li a {
            display: block;
            color: #000;
            text-align: center;
            padding: 10px 10px;
            text-decoration: none;
        }

        .store-contact-bar {
            width: 100%;
            height: 55px;
            background: #fff;
            border-top: 4px solid #644c40;
            border-bottom: 1px solid #dbe3ef;
        }

    </style>
@endsection

@section('js')
    <script>
        // $("#sendsuppliercontactmessage").submit(function(e){
        //     e.preventDefault()
            
        //     var message = $("[name=message]").val() ;
        //     var supplierid = $("[name=supplierid]").val() ;
    
            
        //     $.ajaxSetup({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         }
        //     });
    
        //     $.ajax({
        //         'url':"{{ url('/sendsuppliercontactmessage') }}",
        //         'type':'get',
        //         'dataType':'text',
        //         data: {message:message,supplierid:supplierid},
        //         success:function(data)
        //         {
        //             console.log(data) ;
        //             return false ;
                    
        //         	if(data == 'invalid_login'){
        //         		toastr.error('Please Login First', 'Access Failed !!', { positionClass: 'toast-top-center', });
        //         		return false ;
        //         	}else if(data == "supplier_not_buy"){
        //         		toastr.error('Sorry You Can Not Buy Your Own Product', 'Cart Failed !!', { positionClass: 'toast-top-center', });
        //         		return false ;
        //         	}else{
        //         		$('.cart-area').empty().html(data) ;
        //         		toastr.success('Thanks !! Product Cart Successfully', 'Cart Success!!', { positionClass: 'toast-top-center', });
    	   //             setTimeout(function(){
        //     				location.reload() ;
    			 //       }, 3000);
        //         	}
    
        //         }
        //     });
                
            
            
            
        // })

    </script>
    
    <script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}", "Success", { positionClass: 'toast-top-center', });
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}", "Warning", { positionClass: 'toast-top-center', });
        break;
        case 'failed':
        toastr.error("{{ Session::get('message') }}", "Failed", { positionClass: 'toast-top-center', });
        break;
    }
    @endif
</script>
@endsection

@section('store_background')

    <?php

    if($banner_info){
        // 0 = color, 1 = image
        if($banner_info->background_image !=""){
            $store_background = 1;
        }else{
            $store_background = 0;
        }
    }else{
        $store_background = 0;
    }
    $store_background = '1';
    if($store_background == 1){ ?>
    style="background: url('https://www.availtrade.com//public/images/'.$banner_info->background_image);background-repeat: no-repeat;background-size: 100% 100%;"
    <?php }else{ ?>
    style="background: pink;"
    <?php } ?>

@endsection
