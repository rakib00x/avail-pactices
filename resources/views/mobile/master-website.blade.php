<?php
    $social     = DB::table('tbl_social_media')->first();
    $meta_info  = DB::table('tbl_meta_tags')->first();
    $currency   = DB::table('tbl_currency_status')->where('status',1)->get();
    $base_url   = env('APP_URL');
    $settings   = DB::table('tbl_logo_settings')->where('status', 1)->first();
    
    // if(Session::get('availtrades') == 1){
            
    //     }else{
    //         //start of auto currency change
    //         $clientIP = '';
    //         if (isset($_SERVER['HTTP_CLIENT_IP']))
    //             $clientIP = $_SERVER['HTTP_CLIENT_IP'];
    //         else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    //             $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
    //         else if(isset($_SERVER['HTTP_X_FORWARDED']))
    //             $clientIP = $_SERVER['HTTP_X_FORWARDED'];
    //         else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
    //             $clientIP = $_SERVER['HTTP_FORWARDED_FOR'];
    //         else if(isset($_SERVER['HTTP_FORWARDED']))
    //             $clientIP = $_SERVER['HTTP_FORWARDED'];
    //         else if(isset($_SERVER['REMOTE_ADDR']))
    //             $clientIP = $_SERVER['REMOTE_ADDR'];
    //         else
    //             $clientIP = 'UNKNOWN';    
                
    //         $explode = explode(",",$clientIP);
    //         $ip = $explode[0];
    //         $url = "https://api.ipgeolocation.io/ipgeo?apiKey=c5cbdca84f864713abb3eac51dbf6135&ip=".$ip;
            
    //         $curl = curl_init($url);
    //         curl_setopt($curl, CURLOPT_URL, $url);
    //         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
    //         //for debug only!
    //         curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
    //         $resp = curl_exec($curl);
    //         curl_close($curl);
                
    //         $json_object = json_encode($resp);
    //         $decode     = json_decode($json_object);
    //         $geo_object = json_decode($decode);
    //         // $countryCode = $geo_object->country_code2;
    //         $county_info = DB::table('tbl_countries')->where('stuas', 1)->first();
            
    //         $country        = $county_info->countryCode ;
    //         $count = DB::table('tbl_currency_status')->where('code',$country)->count();
           
    //         if($count !=0){
    //           $query = DB::table('tbl_currency_status')->where('code',$country)->first();
    //           $currency_id    = $query->id;
    //         }else{
    //             $currency_id    = 1;
    //         }
           
    //         $agent = new Agent ;
    
    //         if($currency_id != ""){
    //             Session::put('requestedCurrency', null);
    //             Session::put('requestedCurrency',$currency_id);
    //         }
    
    //         if($country != "")
    //         {
    //             Session::put('countrycode', null);
    //             Session::put('countrycode', $country);
    //         }
    //         //end of auto currency change
    //     }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('meta_info')
    <meta name="theme-color" content="#100DD1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="google-site-verification" content="k0EeY83SLz-MJ7Qhk_rszBYI1Ip9xLZ1MG6R26DEvow" />
    <!-- The above tags *must* come first in the head, any other head content must come *after* these tags-->
    <!-- Title-->
    <title>@yield('page_headline') | Availtrade</title>
    <link rel="canonical" href="{{ url()->full() }}"/>
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&amp;display=swap">
    
    <!-- CSS Libraries-->
    <link rel="stylesheet" href="{{ URL::to('public/mobile/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::to('public/mobile/css/animate.css') }}">
    <link rel="stylesheet" href="{{ URL::to('public/mobile/css/owl.carousel.min.css') }}">
    <!--<link rel="stylesheet" href="{{ URL::to('public/mobile/css/font-awesome.min.css') }}">-->
    <link rel="stylesheet" href="{{ URL::to('public/mobile/css/default/lineicons.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Stylesheet-->
    <link rel="stylesheet" href="{{ URL::to('public/mobile/style.css') }}">
    <!-- Web App Manifest-->
    <link rel="manifest" href="{{ URL::to('public/mobile/manifest.json') }}">
    
    <link rel="stylesheet" href="{{ URL::to('public/mobile/fontt.css') }}">
    
    @yield('css')

</head>
<body>
<!-- Preloader-->

   <!-- Sidenav Black Overlay-->
    <div class="sidenav-black-overlay"></div>

    <div class="suha-sidenav-wrapper" id="sidenavWrapper">
        <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null): ?>
            <!-- Sidenav Profile-->
            <?php if (Session::get('supplier_id') != null): ?>
                <?php $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first() ; ?>
                <div class="sidenav-profile">
                    <div class="user-profile"><img src="<?php echo $base_url."public/images/".$supplier_info->image; ?>" alt="" style="width:80px;height: 80px;"></div>
                    <div class="user-info">
                        <h6 class="user-name mb-0">{{ $supplier_info->storeName }}</h6>
                    </div>
                </div>
            <?php else: ?>
                <?php

                    $customer_info = DB::table('express')->where('id', Session::get('buyer_id'))->first() ; ?>
                <?php if($customer_info->image != "" || $customer_info->image != null){
                        if(strpos($customer_info->image, "https") !== false){
                           $image_url = $customer_info->image ;
                        } else{
                           $image_url = $base_url."public/images/".$customer_info->image;
                        }
                    }else{
                        $image_url = $base_url."public/images/Image 4.png";
                    } ?>
                <div class="sidenav-profile">
                    <div class="user-profile"><img src="{{ $image_url }}" alt="" style="width:80px;height: 80px;"></div>
                    <div class="user-info">
                        <h6 class="user-name mb-0">{{ $customer_info->first_name }} {{ $customer_info->last_name }}</h6>
                    </div>
                </div>
            <?php endif; ?>

        <?php else: ?>
        <?php endif ?>
        <!-- Sidenav Nav-->
        
        <ul class="sidenav-nav ps-0">
            
            <?php
                $primarycategory    = DB::table('tbl_primarycategory')
                    ->where('supplier_id',0)
                    ->where('sidebar_active', 1)
                    ->orderBy('sidebar_decoration', 'asc')
                    ->where('status', 1)
                    ->take(7)
                    ->get();
            ?>
            
            <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null || Session::get('seller_id') != null){ ?>
            
                <?php if(Session::get('supplier_id') != null && Session::get('seller_type') != 1){ ?>
                    <?php $main_login_id = Session::get('supplier_id'); $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first();  ?>
                    <li><a href="https://availtrade.com/supplierDashboard"><i class="lni lni-user" ></i>My Proifle</a></li>
                    
                <?php }else if(Session::get('supplier_id') != null && Session::get('seller_type') == 1){ ?>
                
                    <?php $main_login_id = Session::get('buyer_id'); $customer_info = DB::table('express')->where('id', Session::get('supplier_id'))->first();  ?>
                    <li><a href="https://availtrade.com/sellerDashboard"><i class="lni lni-user" ></i>My Proifle</a></li>
                    <?php }else {?>
                    <?php $main_login_id = Session::get('buyer_id'); $customer_info = DB::table('express')->where('id', Session::get('buyer_id'))->first();  ?>
                    <li><a href="https://availtrade.com/buyerDashboard"><i class="lni lni-user" ></i>My Proifle</a></li>
                    <?php } ?>
                
            <?php }else{ ?>
                <li><a href="{{ URL::to('m/signin') }}"><i class="lni lni-user" ></i>My Proifle</a></li>
            <?php } ?>
            
            <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null): ?>
                <?php if(Session::get('supplier_id') != null): ?>
                    <?php 
                    $quotation_count = DB::table('tbl_supplier_quotation')
                    ->where('supplier_id', Session::get('supplier_id'))
                    ->where('status', 0)
                    ->count() ; 

                    $total_receive_message_count = DB::table('tbl_quotation_reply')
                        ->join('tbl_supplier_quotation', 'tbl_quotation_reply.message_id', '=', 'tbl_supplier_quotation.id')
                        ->select('tbl_quotation_reply.*', 'tbl_supplier_quotation.supplier_id')
                        ->where('tbl_quotation_reply.receiver_id', Session::get('supplier_id'))
                        ->where('tbl_supplier_quotation.supplier_id', Session::get('supplier_id'))
                        ->where('tbl_quotation_reply.receiver_status', 0)
                        ->count() ;
                        

                    $total_sender_message_count = DB::table('tbl_quotation_reply')
                        ->join('tbl_supplier_quotation', 'tbl_quotation_reply.message_id', '=', 'tbl_supplier_quotation.id')
                        ->select('tbl_quotation_reply.*', 'tbl_supplier_quotation.customer_id')
                        ->where('tbl_quotation_reply.receiver_id', Session::get('supplier_id'))
                        ->where('tbl_supplier_quotation.customer_id', Session::get('supplier_id'))
                        ->where('tbl_quotation_reply.receiver_status', 0)
                        ->count() ;
                ?>
                    <?php $main_login_id = Session::get('supplier_id'); $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first();  ?>
                    <li><a href="https://availtrade.com/supplierDashboard"><i class="lni lni-alarm lni-tada-effect"></i>Notifications<span class="ms-3 badge badge-warning"><?php echo number_format($quotation_count + $total_receive_message_count+$total_sender_message_count) ; ?></span></a></li>
                    
                <?php else: ?>
                    <?php 
                        $total_receive_message = DB::table('tbl_quotation_reply')
                            ->where('receiver_id', Session::get('buyer_id'))
                            ->where('receiver_status', 0)
                            ->count() ;
                            
                    ?>
                    <?php $main_login_id = Session::get('buyer_id'); $customer_info = DB::table('express')->where('id', Session::get('buyer_id'))->first();  ?>
                    <li><a href="https://availtrade.com/buyerDashboard"><i class="lni lni-alarm lni-tada-effect"></i>Notifications<span class="ms-3 badge badge-warning"><?php echo number_format($total_receive_message) ; ?></span></a></li>
                <?php endif; ?>
            <?php else: ?>
                <li><a href="{{ URL::to('m/login') }}"><i class="lni lni-alarm lni-tada-effect"></i>Notifications</a></li>
            <?php endif;?>
            <li><a href="{{ route('fpolicy') }}"><i class="lni lni-control-panel"></i>Privacy Policy</a></li><span class=""></span>
            <li><a href="{{ route('fterms') }}"><i class="lni lni-pencil-alt"></i>Terms &amp; Condition</a></li>
            <li><a href="{{ route('fcontact') }}"><i class="lni lni-handshake"></i>Contact</a></li>
             <li><a href="{{ URL::to('m/employee/login') }}"><i class="lni lni-handshake"></i>Employee Login</a></li>
            
            
            <li><a href="{{ URL::to('m/all-categories') }}"><i class="lni lni-grid-alt"></i>All Categorys</a></li>
            <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null): ?>
                <li><a href="{{ URL::to('m/signout') }}"><i class="lni lni-power-switch"></i>Sign Out</a></li>
            <?php else: ?>
                <li><a href="{{ URL::to('m/signin') }}"><i class="lni lni-power-switch"></i>Login</a></li>
                <li><a href="{{ URL::to('m/supliersignup') }}"><i class="lni lni-alarm lni-tada-effect"></i>Supplier Registration</a></li>
            <?php endif; ?>
            <li>
                {!! Form::open(['id' =>'minsertSubscribeInfo','method' => 'post','role' => 'form' ,'files' => true]) !!}
                <input style="height:1.8rem !important;margin-left:10px !important;" id="email" class="mobile-sidebar-menu-input-text" placeholder="Subscribe" type="text" /><input type="submit" value="Sent"/>
                {!! Form::close() !!}
            </li>
            
            <li style="margin-top:5px;">
        
                <style>

</style>



            </li>
        </ul>
@php
$socail = DB::table('tbl_social_media')->where('supplier_id', 0)->first();
@endphp
        
<nav class="navbar">
<div class="bar" >
<a class="socail" href="{{$socail->facebook}}" target="_blank">
<img class="soca" src="{{ URL::to('public/frontEnd/footer/facebook.png') }}" ></a>
<a class="socail" href="{{$socail->youtube}}" target="_blank">
<img class="soca" src="{{ URL::to('public/frontEnd/footer/youtube.png') }}" ></a>
<a class="socail" href="{{$socail->twitter}}" target="_blank" >
<img class="soca"  src="{{ URL::to('public/frontEnd/footer/twitter.png') }}" ></a>
<a class="socail" href="{{$socail->linkedin}}" target="_blank">
<img class="soca"  src="{{ URL::to('public/frontEnd/footer/google.png') }}" ></a>
<a class="socail" href="{{$socail->linkedin}}" target="_blank">
<img class="soca"  src="{{ URL::to('public/frontEnd/footer/linkedin.png') }}" ></a>
</div>
</nav>
        <!-- Go Back Button-->
        <div class="go-home-btn" id="goHomeBtn"><i class="lni lni-arrow-left"></i></div>
        <div style="margin:2rem;"><a href="{{ URL::to('availtrade.apk') }}" download="{{ URL::to('availtrade.apk') }}"><img src="{{ URL::to('public/frontEnd/footer/playStore.png') }}" alt=""></a></div>
    </div>
    
        <!-- Header Area-->
    <div class="header-area" id="headerArea">
      <div class="container h-100 d-flex align-items-center justify-content-between">
        <!-- Logo Wrapper-->
        <div class="logo-wrapper"><a href="{{ URL::to('/m') }}"><img src="<?php echo $base_url."public/images/".$settings->logo ?>" alt="" style="max-width:130px!important;height:2.5rem;"></a></div>
        <!-- Search Form-->
        <div class="top-search-form">
          {!! Form::open(['url' =>'m/search','method' => 'get','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
            <input class="form-control" type="text" name="search_keyword" placeholder="Enter your keyword">
            <button type="submit"><i class="fa fa-search"></i></button>
          {!! Form::close() !!}

        </div>
        <!-- Navbar Toggler-->
        <div class="suha-navbar-toggler d-flex flex-wrap" id="suhaNavbarToggler"><span></span><span></span><span></span></div>
        
      </div>
@php
 $namaz 	= DB::table('namazs')->where('status', 1)->get();
@endphp
	@if(count($namaz) > 0)
	<div style="background: #54fd49;top:2px;font-size:1rem;">
	     
	<marquee style="color:#fff;font-size:1rem;" scrollamount="4">
	   @foreach($namaz as $value)
	    {{$value->name}}
	   @endforeach
	    </marquee>
	     
    </div>
    @endif
    </div>
    
    <div class="page-content-wrapper pt-0">

        <div class="header-area-second">
            <div class="container h-100 d-flex align-items-center justify-content-between">
                <!-- Back Button-->
                <div class="back-button" style="width: 50%;">
                    <select class="mt-1 form-select" name="" id="">
                        <!--<option value="1">Bangla</option>-->
                        <option value="2">English</option>
                    </select>
                </div>
                <!-- Page Title-->
                <div class="page-heading">
                    <h6 class="mb-0">
                        
                    </h6>
                </div>
                <!-- Filter Option-->
                <div class="filter-option-second" style="width: 50%;">
                    <select class="mt-0 form-select" id="mobile_currency">
                        <?php foreach($currency as $currencyvalue): ?>
                            <option value="{{ $currencyvalue->id }}" <?php
                            
                            if(Session::has('requestedCurrency')){
    					        $currency_info = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first();
    					        if($currency_info->code == $currencyvalue->code){echo "selected"; }else{echo "";}
    					    }else{
    					        echo "";
    					    }
                            
                            ?>> <?php
                            
                            if(Session::has('requestedCurrency')){
    					        $currency_info = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first();
    					        
    					        if($currency_info->code == $currencyvalue->code){
    					            echo "Currency"; 
    					        }else{
    					            echo  $currencyvalue->name;
    					        }
    					    }else{
    					        echo  $currencyvalue->name;
    					    }
                            
                            ?> {{ $currencyvalue->code }}</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
@yield('content')

<!-- Internet Connection Status-->
<div class="internet-connection-status" id="internetStatus"></div>
<!-- Footer Nav-->
<div class="footer-nav-area" id="footerNav">
    <div class="container h-100 px-0">
        <div class="suha-footer-nav h-100">
            <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
                <li class="<?php if(url()->current() ==  env('app_url').'m/' || url()->current() == env('app_url').'m/'){echo "active"; }else{echo ""; } ?>"><a href="{{ URL::to('/m') }}"><i class="lni lni-home"></i>Home </a></li>
                <li class="<?php if(url()->current() == env("app_url")."m/cart" || url()->current() == env("app_url")."m/cart"){echo "active"; }else{echo ""; } ?>"><a href="{{ URL::to('m/cart') }}"><i class="lni lni-shopping-basket"></i>Cart</a></li>
                <li><a href="{{ URL::to('/m/chating-persons') }}"><i class="lni lni-facebook-messenger"></i>Message</a></li>
                <?php if (Session::get('supplier_id') != null || Session::get('buyer_id') != null): ?>
                    <?php if(Session::get('supplier_id') != null): ?>
                    
                        @if(Session::get('supplier_id') != "null" && Session::get('seller_type') == 0) 
                        <?php $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first();  ?>
                        <li><a href="https://availtrade.com/supplierDashboard" id=""><i class="lni lni-user" ></i>{{ substr($supplier_info->storeName, 0, 10) }}</a></li>
                        @else 
                        <?php $supplier_info = DB::table('express')->where('id', Session::get('supplier_id'))->first();  ?>
                        <li><a href="https://availtrade.com/sellerDashboard" id=""><i class="lni lni-user" ></i>{{ substr($supplier_info->storeName, 0, 10) }}</a></li>
                        @endif
                    <?php else: ?>
                        <?php $customer_info = DB::table('express')->where('id', Session::get('buyer_id'))->first();  ?>
                        <li><a href="https://availtrade.com/buyerDashboard" id=""><i class="lni lni-user" ></i>{{ substr($customer_info->first_name." ".$customer_info->last_name, 0, 10) }}</a></li>
                    <?php endif; ?>
                <?php else: ?>
                 <li class="<?php if(url()->current() ==  env('app_url').'m/signin'  || url()->current() == env('app_url').'m/signin'){echo "active"; }else{echo ""; } ?>"><a href="{{ URL::to('m/signin') }}" id=""><i class="lni lni-user" ></i>My Availtrade</a></li>
                <?php endif;?>
                
            </ul>
        </div>
    </div>
</div>
 

</div>

<!-- All JavaScript Files-->
<script src="{{ URL::to('public/mobile/js/jquery.min.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/waypoints.min.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/jquery.easing.min.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/owl.carousel.min.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/jquery.counterup.min.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/jquery.countdown.min.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/default/jquery.passwordstrength.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/default/dark-mode-switch.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/default/no-internet.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/default/active.js') }}"></script>
<script src="{{ URL::to('public/mobile/js/pwa.js') }}"></script>
<script src="{{ URL::to('public/js/share.js') }}"></script>
<script src="{{ URL::to('//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js') }}"></script>
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
<script>
    $("#minsertSubscribeInfo").submit(function(e){
        e.preventDefault();
        
        var email = $("#email").val() ;
        if(email == ""){
            toastr.warning('Email Filed Is Required.', 'Warning', { positionClass: 'toast-top-center', });
	  	    return false ;
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            'url':"{{ url('/m/minsertSubscribeInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {email: email},
            success: function(data) {
                if (data == "email_exist") {
                    toastr.warning('Oh shit!! Subscribe Email Already Exist. ', "warning", { positionClass: 'toast-top-center', });
                    return false ;
                }else if(data == "success"){
                    $("#email").val(" ");
                    toastr.success('Subscribe Complete Successfully', "success", { positionClass: 'toast-top-center', });
                    return false ;
                }else{
                   
                    toastr.warning('Sorry! Somthing went wrong', "", { positionClass: 'toast-top-center', });
                    return false ;
                }
            }
        })
    })

</script>

<script>
    $("#mobile_currency").change(function(){
        var mobile_currency = $(this).val() ;
        var main_link       = "<?php echo env('APP_URL'); ?>m/mobilechangeCurrency/"+mobile_currency;
        window.location     = main_link;
    });
</script>

@yield('js')

<script>
// Get the modal
var modal = document.getElementById("#login_modal");

$("#myBtn").click(function(){
    modal.style.display = "block";
});

$(".close").click(function(){
    modal.style.display = "none";
});


// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script> 
<script type="text/javascript">
 var path = "{{ route('autocompeleteh') }}";

    $('input.typeahead').typeahead({
        
        source:  function (search_keyword, process) {
         $.ajaxSetup({
        headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
         });

        return $.post(path, { search_keyword: search_keyword }, function (data) {
         return process(data);
         console.log(data);

            });

        }

    });
    </script>

</body>

</html>
