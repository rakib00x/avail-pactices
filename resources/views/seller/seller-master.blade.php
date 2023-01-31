<?php
    $supplier_id    = Session::get('supplier_id');
    $supplier_type  = Session::get('supplier_type');
    $seller_type    = Session::get('seller_type');

    if($supplier_id == null){
        return Redirect::to('/login')->send();
        exit();
    }
    
    if($supplier_id == null && $supplier_type == null){
        return Redirect::to('/login')->send();
        exit();
    }
    
    if($supplier_id == null && $supplier_type != '2' && $seller_type != 1){
        return Redirect::to('/login')->send();
        exit();
    }

    if($supplier_type != '2' && $seller_type != 1){
        return Redirect::to('/login')->send();
        exit();
    }
    
    $all_pending_oders = DB::table('order')
        ->join('express', 'order.customer_id', '=', 'express.id')
        ->select('order.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName')
        ->groupBy('order.invoice_number')
        ->where('order.supplier_id', Session::get('supplier_id'))
        ->where('order.status', 0)
        ->get();
        
    $all_pending_reviews = DB::table('tbl_reviews')
        ->leftJoin('express', 'tbl_reviews.buyer_id', '=', 'express.id')
        ->leftJoin('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
        ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName')
        ->where('tbl_product.supplier_id', Session::get('supplier_id'))
        ->where('tbl_reviews.status', 0)
        ->get() ; 

    $supplier_info  = DB::table('express')->where('id', $supplier_id)->first() ;
    $default_banner = DB::table('tbl_default_setting')->first(); 
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="AVAILTRADE">
    <title>Avail Trade || @yield('title','Seller Dasboard')</title>
    <link rel="apple-touch-icon" href="{{ URL::to('public/app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('public/app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{URL::to('public/app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/extensions/dragula.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/green-bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/green-bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/green-components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/themes/green-layout.css') }}">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/pages/dashboard-analytics.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/assets/css/style.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/tables/datatable/datatables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/tables/datatable/responsive.bootstrap.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/forms/select/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/pages/app-chat.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/summernote.min.css') }}">
    <link href="{{URL::to('//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style type="text/css">
        body.dark-layout p, body.dark-layout small, body.dark-layout span, body.dark-layout label{
            color: #ffffff!important;
        }

        body.dark-layout .list-group .list-group-item:not([class*="list-group-item-"]), body.dark-layout .list-group .list-group-item.list-group-item-action{
            color: #ffffff!important ;
        }
        
        .note-editable {
            background: #fff !important;
        } 
    </style>
    @stack('styles')
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern dark-layout content-left-sidebar chat-application navbar-sticky footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="content-left-sidebar" data-layout="dark-layout">

    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-dark">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">
                       <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{URL::to('msBox')}}" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon bx bx-chat"></i></a></li>
                            <!--<li class="nav-item d-none d-lg-block"><a class="nav-link" target="new" href="" data-toggle="tooltip" data-placement="top" title="Visit Your Profile"><i class="ficon bx bx-world"></i></a></li>-->
                        
                         <li class="nav-item d-none d-lg-block"><a class="nav-link" target="new" href="{{ URL::to('') }}" data-toggle="tooltip" data-placement="top"  title="Visit Your Web" ><h4 style="color:white;">Visite Your Site</b></h4></i></a></li>
                        
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us" style="display:none;"></i><span class="selected-language">English</span></a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                                <a class="dropdown-item" href="#" data-language="en"><i class="flag-icon flag-icon-us mr-50"></i> English</a>
                                <a class="dropdown-item" href="#" data-language="bn"><i class="flag-icon flag-icon-bangladesh mr-50"></i> Bangla</a>
                                </div>
                        </li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand" ><i class="ficon bx bx-fullscreen"></i></a></li>
                        <li class="nav-item nav-search" style="display:none;"><a class="nav-link nav-link-search"><i class="ficon bx bx-search"></i></a>
                            <div class="search-input">
                                <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
                                <input class="input" type="text" placeholder="Explore Frest..." tabindex="-1" data-search="template-search">
                                <div class="search-input-close"><i class="bx bx-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="{{ URL::to('') }}"><i class="ficon bx bx-home"></i></a></li>
                         <?php 

                            $total_receive_message = DB::table('tbl_quotation_reply')
                                ->where('receiver_id', Session::get('supplier_id'))
                                ->where('receiver_status', 0)
                                ->count() ;
                                
                            $notification =  DB::table('tbl_supplier_quotation')
                                ->leftJoin('tbl_product', 'tbl_supplier_quotation.product_id', '=', 'tbl_product.id')
                                ->join('express', 'tbl_supplier_quotation.customer_id', '=', 'express.id')
                                ->select('tbl_supplier_quotation.*', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName', 'tbl_product.slug', 'tbl_product.product_name')
                                ->where('tbl_supplier_quotation.supplier_id', Session::get('supplier_id'))
                                ->limit(5)
                                ->get() ;
                               
                            ?>
                        <li class="dropdown dropdown-notification nav-item" ><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up"><?php echo $total_receive_message+count($all_pending_oders)+count($all_pending_reviews); ?></span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title"><?php echo $total_receive_message+count($all_pending_oders)+count($all_pending_reviews); ?> new Notification</span></div>
                                </li>
                                <li class="scrollable-container media-list">
                                    
                                <?php foreach ($all_pending_oders as $ordervalue): ?>
                                    <div class="d-flex justify-content-between cursor-pointer">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                    <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <a href="{{ URL::to('sellerinvoice/'.$ordervalue->invoice_number) }}"><h6 class="media-heading"><span class="text-bold-500"><?php if($ordervalue->type == 2){echo $ordervalue->storeName; }else{echo $ordervalue->first_name." ".$ordervalue->last_name; } ?></span> </h6>
                                                <small class="notification-text">INV-<strong>{{ $ordervalue->invoice_number }}</strong> Amount- <strong>{{ $ordervalue->total_price }}</strong> {{ $ordervalue->created_at }} </small></a>
                                            </div>
                                        </div>
                                    </div>
                                 <?php endforeach ?>
                                 
                                 <?php foreach ($all_pending_reviews as $reviewvalue): ?>
                                    <div class="d-flex justify-content-between cursor-pointer">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                    <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <a href="{{ URL::to('supplierAllReview') }}"><h6 class="media-heading"><span class="text-bold-500"><?php if($reviewvalue->type == 2){echo $reviewvalue->storeName; }else{echo $reviewvalue->first_name." ".$reviewvalue->last_name; } ?></span> </h6>
                                                <small class="notification-text"><?php echo substr($reviewvalue->product_name, 0, 30); ?> {{ $reviewvalue->created_at }} </small></a>
                                            </div>
                                        </div>
                                    </div>
                                 <?php endforeach ?>
                                 
                                 <?php foreach ($notification as $value): ?>
                                    <div class="d-flex justify-content-between cursor-pointer">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                    <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <h6 class="media-heading"><span class="text-bold-500"><?php if($value->type == 2){echo $value->storeName; }else{echo $value->first_name." ".$value->last_name; } ?></span> </h6><small class="notification-text">{{ $value->created_at }}</small>
                                            </div>
                                        </div>
                                    </div>
                                 <?php endforeach ?>
                            </li>

                                
                                       
                            <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="{{URL::to('supplierQuotationList')}}">Read all notifications</a></li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                        <div class="user-nav d-sm-flex d-none"><span class="user-name"><?php echo $supplier_info->first_name." ".$supplier_info->last_name ; ?></span><span class="user-status text-muted">Available</span></div>
                        <span>
                                <?php if($supplier_info->image != "" || $supplier_info->image != null){
                                    if(strpos($supplier_info->image, "https") !== false){
                                       $image_url = $supplier_info->image ;
                                    } else{
                                       $image_url = "public/images/spplierPro/".$supplier_info->image;
                                    }
                                }else{
                                    $image_url = "/public/images/defult/".$default_banner->logo;
                                } ?>

                                <img class="round" src='{{ URL::to("$image_url") }}' alt="avatar" height="40" width="40">
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            <div class="dropdown-divider mb-0"></div><a class="dropdown-item" href="{{URL::to('logout')}}"><i class="bx bx-power-off mr-50"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<!-- END: Header-->

<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto"><a class="navbar-brand" href="{{ URL::to('') }}" target="_new">
                <div class="brand-logo"><img class="logo" src="{{ URL::to('public/app-assets/images/logo/logo.png') }}" /></div>
                <h2 class="brand-text mb-0">Avail Trade</h2>
            </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
            <li class=" nav-item"><a href="{{ URL::to('sellerDashboard') }}"><i class="menu-livicon" data-icon="desktop"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
            </li>

            <li class=" nav-item"><a href="{{URL::to('/selleracountsettings')}}"><i class="menu-livicon" data-icon="wrench"></i><span class="menu-title" data-i18n="Account Settings">Account Settings</span></a>
            </li>

            <li class=" nav-item"><a href="{{URL::to('/sellerproductlist')}}"><i class="menu-livicon" data-icon="list"></i><span class="menu-title" data-i18n="Product">Product List</span></a>
            </li>
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="shoppingcart"></i><span class="menu-title" data-i18n="Invoice">Orders</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/sellerOrdersList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Sell Orders List</span></a>
                    </li>
                    <li><a href="{{URL::to('/sellerOrderBuyList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Buy Orders List</span></a>
                    </li>
                </ul>
            </li> 

            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="envelope-pull"></i><span class="menu-title" data-i18n="Invoice">Message</span> <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
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
                    
                    echo number_format($quotation_count + $total_receive_message_count+$total_sender_message_count) ;
                ?>
            </span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/sellerQuotationList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Inbox </span> <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                <?php echo $quotation_count + $total_receive_message_count; ?></span></a>
                    <li><a href="{{URL::to('/sellerQuotationInbox')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Send </span> <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                <?php echo $total_sender_message_count; ?></span></a>
                    </li>
                </ul>
            </li> 

            <li class=" nav-item"><a href="{{ URL::to('sellerAllReview') }}"><i class="menu-livicon" data-icon="notebook"></i><span class="menu-title" data-i18n="Account Settings">My Reviews</span> <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                <?php 
                    $review_count = DB::table('tbl_reviews')
                    ->leftJoin('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
                    ->select('tbl_reviews.*', 'tbl_product.supplier_id')
                    ->where('tbl_product.supplier_id', Session::get('supplier_id'))
                    ->where('tbl_reviews.status', 0)
                    ->count() ; 
                    echo number_format($review_count) ;
                ?>
            </span></a>
            </li>
        
            
            <li class=" nav-item"><a href="{{URL::to('/sellerticketSection')}}"><i class="menu-livicon" data-icon="question"></i><span class="menu-title" data-i18n="Account Settings">Ticket To Availtrade</span></a>
            </li>

        </ul>
    </div>
</div>
<!-- END: Main Menu-->

@yield('content')

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-dark">
    <p class="clearfix mb-0"><span class="float-left d-inline-block"><?php echo date('Y'); ?> &copy; AVAILTRADE</span><span
    class="float-right d-sm-inline-block d-none">Crafted with<i class="bx bxs-heart pink mx-50 font-small-3"></i>by<a class="text-uppercase" href="https://www.availtrade.com/" target="_blank">AVAILTRADE</a></span>
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
    </p>
</footer>
<!-- END: Footer-->

<!-- BEGIN: Vendor JS-->
<script src="{{ URL::to('public/app-assets/vendors/js/vendors.min.js') }}"></script>
<script>
// the path from root of your site to folder with icons. Also may be as URL, like 'http://yoursite.com/path/to/LivIconsEvo/svg/'
var config = {
    routes: {
        path: "{{ URL::to('public/app-assets/fonts/LivIconsEvo/svg/') }}"
    }
};
</script>
<script src="{{ URL::to('public/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js') }}"></script>
<script src="{{ URL::to('public/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js') }}"></script>
<script src="{{ URL::to('public/app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ URL::to('public/app-assets/js/scripts/configs/vertical-menu-dark.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/core/app.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/components.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/footer.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="{{ URL::to('public/app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/pages/app-invoice.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/datatables/datatable.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/dropzone.js')}}"></script>
<!-- END: Page JS-->

<script src="{{ URL::to('public/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<!-- BEGIN: Page JS-->
<script src="{{ URL::to('public/app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/forms/number-input.js')}}"></script>
<!-- BEGIN: Page Vendor JS-->
<script src="{{ URL::to('public/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/forms/form-repeater.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="{{ URL::to('app-assets/js/scripts/pages/app-chat.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- END: Page JS-->
<script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
    $('.datepicker').datepicker({
        startDate: '-3d'
    });
</script>


@yield('js')

</body>
<!-- END: Body-->

</html>