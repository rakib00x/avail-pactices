<?php
    $admin_id       = Session::get('admin_id');
    $type           = Session::get('type');
    if($admin_id == null){
        return Redirect::to('/apanel')->send();
        exit();
    }

    if($admin_id == null && $type == null){
        return Redirect::to('/apanel')->send();
        exit();
    }

    if($admin_id == null && $type != '1'){
        return Redirect::to('/apanel')->send();
        exit();
    }

    if($type != '1'){
        return Redirect::to('/apanel')->send();
        exit();
    }
    
    date_default_timezone_set('Asia/Dhaka');
    $date_time = date("Y-m-d H:i:s") ;
    
    $admin_info = DB::table('express')->where('id', $admin_id)->first() ;
    
    $total_pending_supplier = DB::table('express')->where('type', 2)->where('package_id', '>', 0)->where('package_status', 0)->count() ;
    $pending_package_update = DB::table('tbL_package_update_history')->where('status', 0)->count();
    
    $all_pending_reviews = DB::table('tbl_reviews')
        ->leftJoin('express', 'tbl_reviews.buyer_id', '=', 'express.id')
        ->leftJoin('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.id')
        ->select('tbl_reviews.*', 'tbl_product.supplier_id', 'tbl_product.product_name', 'express.first_name', 'express.last_name', 'express.email', 'express.type', 'express.storeName')
        ->where('tbl_reviews.status', 0)
        ->orderBy('tbl_reviews.id', 'desc')
        ->get() ; 
    
    $all_pending_contact = DB::table('contact')->where('status', 0)->orderBy('id', 'desc')->get() ;
    
    $all_pending_support = DB::table('tbl_support_ticket')
            ->join('express', 'tbl_support_ticket.supplier_id', '=', 'express.id')
            ->select('tbl_support_ticket.*', 'express.first_name', 'express.last_name', 'express.email')
            ->orderBy('tbl_support_ticket.id', 'desc')
            ->where('tbl_support_ticket.status', 0)
            ->get() ;
    
    $all_pending_supplier = DB::table('express')
            ->join('tbl_package', 'express.package_id', '=', 'tbl_package.id')
            ->select('express.*', 'tbl_package.package_name', 'tbl_package.package_price')
            ->where('express.package_id', '>', 0)
            ->where('express.package_status', 0)
            ->orderBy('express.id', 'desc')
            ->get() ;
    
    $all_banned_account = DB::table('express')
        ->where('status', 3)
        ->where('attem_time', '>', 0)
        ->count() ;
    
    
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
    <meta name="author" content="PIXINVENT">
    <title>Avail Trade || @yield('title','Admin Dasboard')</title>
    <link rel="apple-touch-icon" href="{{ URL::to('public/app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('public/app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{URL::to('public/app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/extensions/dragula.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/themes/semi-dark-layout.css') }}">
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
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/forms/select/select2.min.css')}}">
    
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/pickers/daterange/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{URL::to('//cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css')}}">
    <link href="{{URL::to('//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css')}}" rel="stylesheet">
    
    @stack('styles')
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern dark-layout 2-columns  navbar-sticky footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="dark-layout">

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
                        <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{URL::to('sendEmail')}}" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon bx bx-envelope"></i></a></li>
                        <!--<li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-chat.html" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon bx bx-chat"></i></a></li>-->
                       
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"><i class="ficon bx bx-star warning"></i></a>
                            <!--<div class="bookmark-input search-input">-->
                            <!--    <div class="bookmark-input-icon"><i class="bx bx-search primary"></i></div>-->
                            <!--    <input class="form-control input" type="text" placeholder="Explore Frest..." tabindex="0" data-search="template-search">-->
                            <!--    <ul class="search-list"></ul>-->
                            <!--</div>-->
                        </li>
                    </ul>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                        <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#" data-language="en"><i class="flag-icon flag-icon-u mr-50"></i> English</a>
                        <a class="dropdown-item" href="#" data-language="fr"><i class="flag-icon flag-icon-f mr-50"></i> Bangla</a>
                        </div>
                    </li>
                    <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
                    <!--<li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon bx bx-search"></i></a>-->
                    <!--    <div class="search-input">-->
                    <!--        <div class="search-input-icon"><i class="bx bx-search primary"></i></div>-->
                    <!--        <input class="input" type="text" placeholder="Explore Frest..." tabindex="-1" data-search="template-search">-->
                    <!--        <div class="search-input-close"><i class="bx bx-x"></i></div>-->
                    <!--        <ul class="search-list"></ul>-->
                    <!--    </div>-->
                    <!--</li>-->
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up"><?php echo count($all_pending_reviews)+count($all_pending_contact)+count($all_pending_support); ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title"><?php echo count($all_pending_reviews)+count($all_pending_contact)+count($all_pending_support)+count($all_pending_supplier); ?> new Notification</span><span class="text-bold-400 cursor-pointer">Mark all as read</span></div>
                            </li>
                            <li class="scrollable-container media-list">
                                
                                <?php foreach ($all_pending_reviews as $reviewvalue): ?>
                                    <div class="d-flex justify-content-between cursor-pointer">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                    <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <a href="{{ URL::to('allReviews') }}"><h6 class="media-heading"><span class="text-bold-500"><?php if($reviewvalue->type == 2){echo $reviewvalue->storeName; }else{echo $reviewvalue->first_name." ".$reviewvalue->last_name; } ?></span> </h6>
                                                <small class="notification-text"><?php echo substr($reviewvalue->product_name, 0, 30); ?> {{ $reviewvalue->created_at }} </small></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                
                                <?php foreach ($all_pending_supplier as $suppliervalue): ?>
                                    <div class="d-flex justify-content-between cursor-pointer">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                    <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <a href="{{ URL::to('adminpackagependingsellers') }}"><h6 class="media-heading"><span class="text-bold-500"><?php echo $suppliervalue->first_name." ".$suppliervalue->last_name; ?></span> </h6>
                                                <small class="notification-text">{{ $suppliervalue->package_name }}{{ $reviewvalue->created_at ?? ''}} </small></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                
                                <?php foreach ($all_pending_contact as $contactvalue): ?>
                                    <div class="d-flex justify-content-between cursor-pointer">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                    <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <a href="{{ URL::to('allcontact') }}"><h6 class="media-heading"><span class="text-bold-500"><?php echo $contactvalue->name; ?></span> </h6>
                                                <small class="notification-text"><?php echo $contactvalue->subject; ?> {{ $reviewvalue->created_at ?? ''}} </small></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                
                                <?php foreach ($all_pending_support as $supportvalue): ?>
                                    <div class="d-flex justify-content-between cursor-pointer">
                                        <div class="media d-flex align-items-center">
                                            <div class="media-left pr-0">
                                                <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                    <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <a href="{{ URL::to('allticket') }}"><h6 class="media-heading"><span class="text-bold-500">{{ $supportvalue->first_name." ".$supportvalue->last_name }}</span> </h6>
                                                <small class="notification-text"><?php echo $supportvalue->ticket_number; ?> {{ $reviewvalue->created_at??'' }} </small></a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                                
                            </li>
      
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name"><?php echo $admin_info->first_name." ".$admin_info->last_name ; ?></span><span class="user-status text-muted">Available</span></div><span>
                                <?php if ($admin_info->image == "" || $admin_info->image == null): ?>
                                    <img class="round" src="{{ URL::to('/public/frontEnd/default-user.png') }}" alt="avatar" height="40" width="40">
                                <?php else: ?>
                                    <img class="round" src="{{ URL::to('public/images/adminPic/'.$admin_info->image) }}" alt="avatar" height="40" width="40">
                                <?php endif ;?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0">
                            <!--<a class="dropdown-item" href="page-user-profile.html"><i class="bx bx-user mr-50"></i> Edit Profile</a>-->
                            <!--<a class="dropdown-item" href="app-email.html"><i class="bx bx-envelope mr-50"></i> My Inbox</a>-->
                            <!--<a class="dropdown-item" href="app-todo.html"><i class="bx bx-check-square mr-50"></i> Task</a>-->
                            <!--<a class="dropdown-item" href="app-chat.html"><i class="bx bx-message mr-50"></i> Chats</a>-->
                            <div class="dropdown-divider mb-0"></div><a class="dropdown-item" href="{{URL::to('adminLogout')}}"><i class="bx bx-power-off mr-50"></i> Logout</a>
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
            <li class="nav-item mr-auto"><a class="navbar-brand" target="_blank" href="https://www.availtrade.com/">
                    <div class="brand-logo"><img class="logo" src="{{ URL::to('public/app-assets/images/logo/logo.png') }}" /></div>
                    <h2 class="brand-text mb-0">Availtrade</h2>
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block primary" data-ticon="bx-disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
            <li class=" nav-item"><a href="{{ URL::to('adminDashboard') }}"><i class="menu-livicon" data-icon="desktop"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span><span class="badge badge-light-danger badge-pill badge-round float-right mr-2">2</span></a>
                <ul class="menu-content">
                    <li class="active"><a href="{{ URL::to('adminDashboard') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Analytics">Analytics</span></a>
                    </li>
                </ul>
            </li>
              <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User"> Account</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/adminAccountSettings')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Account Settings</span></a></li>
                </ul>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Ads</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/adminHomePopupAds')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="popupads">Popup Ads</span></a></li>
                </ul>

                <ul class="menu-content">
                    <li><a href="{{URL::to('/adminHomeAds')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Home Page Ads</span></a></li>
                </ul>

                <ul class="menu-content">
                    <li><a href="{{URL::to('/adminAds')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">All Categories Page Ads</span></a></li>
                </ul>
                
                <ul class="menu-content">
                    <li><a href="{{URL::to('/adminadslist')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Media">Admin Ads List</span></a>
                    </li>
                </ul>
            </li>
            
          
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Bank & Mobile Bank</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/bankList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Bank List</span></a>
                    </li>
                </ul>
                
                 <ul class="menu-content">
                    <li><a href="{{URL::to('/mobilebanklist')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Mobile Bank List</span></a>
                    </li>
                </ul>
            </li>
           

            <li class=" nav-item">
                <a href="{{URL::to('/allbanner')}}">
                    <i class="menu-livicon" data-icon="notebook"></i>
                    <span class="menu-title" data-i18n="Account Settings">Banner </span>
                </a>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Categories</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/mainCategoryList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Primary Category</span></a>
                    </li>
                     <ul class="menu-content">
                    <li><a href="{{URL::to('/secondaryCategoryList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Secondary Category</span></a>
                    </li>

                     <li><a href="{{URL::to('/tertiaryCategoryList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Tertiary Category</span></a>
                    </li>
                </ul>
                </ul>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User"> Email Send </span></a>
                <ul class="menu-content">
                      <li><a href="{{URL::to('/sendEmail')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Email List</span></a>
                    </li>
                </ul>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Front Page Design</span></a>
                <ul class="menu-content">
                     <ul class="menu-content">
                        <li><a href="{{URL::to('/adminSidebarCategoryList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Sidebar Catgeory List</span></a>
                        </li>
                        <li><a href="{{URL::to('/adminSidebarTertiaryCategoryList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Sidebar Tertiary Catgeory List</span></a>
                        <li><a href="{{URL::to('/adminHomeCategoryList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Home Categorys</span></a>
                        </li>
                        <li><a href="{{URL::to('/adminHomeCountryList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Front Country List</span></a>
                        </li>


                    </ul>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Footer Page</span></a>
                <ul class="menu-content">
                     <ul class="menu-content">
                        <li><a href="{{URL::to('/namaz')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Notice </span></a>
                        </li>
                        <li><a href="{{URL::to('/videoinfo')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Video List</span></a>
                        <li><a href="{{URL::to('/faqinfo')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Faq</span></a>
                        </li>
                       <li><a href="{{URL::to('/terms')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Terms & Condition</span></a>
                        </li>


                    </ul>
                </ul>
            </li>
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="Media">Employee</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/employee/list')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Media">Employee List</span></a>
                    </li>
                    <li><a href="{{URL::to('/distric')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Trash">District</span></a>
                    </li>
                    <li><a href="{{URL::to('/thana')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Trash">Thana</span></a>
                    </li>
                     <li><a href="{{URL::to('/employees/paymeent')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Trash">Paymeent</span></a> 
                    </li>
                </ul>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="Media">Media</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/adminMedia')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Media">Media</span></a>
                    </li>
                    <li><a href="{{URL::to('/adminMediaTrash')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Trash">Trash</span></a>
                    </li>
                </ul>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Meta Tags</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/metaTags')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Meta Tags Details</span></a>
                    </li>
                </ul>
            </li> 
            
            <li class=" nav-item"><a href="{{URL::to('/allinvoice')}}"><i class="menu-livicon" data-icon="notebook"></i><span class="menu-title" data-i18n="Account Settings">Orders </span><span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                <?php $order_count = DB::table('order')->where('status', 1)->count() ; echo number_format($order_count) ; ?>
            </span></a>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Package</span></a>
                <ul class="menu-content">
                     <ul class="menu-content">
                    <li><a href="{{URL::to('/smtp')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">SMTP</span></a>
                    </li>
                    <li><a href="{{URL::to('/addForm')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Add New Form</span></a>
                    </li>
                </ul>
                </ul>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Price</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/adminUnitPrice')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Unit Pirce</span></a>
                    </li>
                </ul>
            </li> 
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Payment Methods</span></a>
                <ul class="menu-content">
                 <li><a href="{{URL::to('/PaymentMethodList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Payment Methods</span></a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item">
                <a href="{{URL::to('/allReviews')}}">
                    <i class="menu-livicon" data-icon="notebook"></i>
                    <span class="menu-title" data-i18n="Account Settings">Reviews </span>
                    <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                    <?php $ticket_count = DB::table('tbl_reviews')->where('status', 0)->count() ; echo number_format($ticket_count) ; ?>
                    </span>
                </a>
            </li>
            
            <li class=" nav-item">
                <a href="{{URL::to('/allHoldAccount')}}">
                    <i class="menu-livicon" data-icon="notebook"></i>
                    <span class="menu-title" data-i18n="Account Settings">Hold Account</span>
                    <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                    <?php echo number_format($all_banned_account) ; ?>
                    </span>
                </a>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User"> Supplier </span>  <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                    <?php echo number_format($total_pending_supplier + $pending_package_update) ; ?>
                    </span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/adminsupplierpackageupdate')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Update Package</span><span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                    <?php echo number_format($pending_package_update) ; ?>
                    </span></a></li>
                    <li><a href="{{URL::to('/adminpackagependingsellers')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Pending Suppllier </span><span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                    <?php echo number_format($total_pending_supplier) ; ?>
                    </span></a></li>
                    {{--
                    <li><a href="{{URL::to('/allSeller')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">All Suppllier</span><span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                        <?php $sup_count =DB::table('express')->where('type', 2)->count() ; echo number_format($sup_count) ; ?>
                        </span>
                    </a>
                    </li>
                    <li><a href="{{URL::to('/sellerPayout')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Payouts</span></a>
                    </li>
                    <li><a href="{{URL::to('/sellerPayoutRequest')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Payout Requests</span></a>
                    </li>--}}
                    <li><a href="{{URL::to('/adminpackagebanner')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Package Banner</span></a>
                    </li>
                    <li><a href="{{URL::to('/adminpackagecategorylist')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">All Package Category</span></a>
                    </li>
                    <li><a href="{{URL::to('/adminsupplierpackage')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">All Pacakge</span></a>
                    </li>
                </ul>
            </li>
             <li class=" nav-item">
                <a href="{{URL::to('/allSeller')}}">
                    <i class="menu-livicon" data-icon="notebook"></i>
                    <span class="menu-title" data-i18n="Account Settings">All Supplier List </span>
                    <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                        <?php $sup_count =DB::table('express')->where('type', 2)->where('seller_type', 0)->count() ; echo number_format($sup_count) ; ?>
                    
                    </span>
                </a>
            </li>
             <li class=" nav-item">
                <a href="{{URL::to('/allSubSeller')}}">
                    <i class="menu-livicon" data-icon="notebook"></i>
                    <span class="menu-title" data-i18n="Account Settings">All Seller List </span>
                    <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                        <?php $sup_count =DB::table('express')->where('type', 2)->where('seller_type', 1)->count() ; echo number_format($sup_count) ; ?>
                    
                    </span>
                </a>
            </li>
             <li class=" nav-item">
                <a href="{{URL::to('/allBuyer')}}">
                    <i class="menu-livicon" data-icon="notebook"></i>
                    <span class="menu-title" data-i18n="Account Settings">All Buyer List </span>
                    <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                        <?php $buyer_count =DB::table('express')->where('type', 3)->count() ; echo number_format($buyer_count) ; ?>
                    
                    </span>
                </a>
            </li>
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Site Message</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/privacyPolicyList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Privacy Policy</span></a>
                    </li>
                    <li><a href="{{URL::to('/termConditionList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Terms & Condition</span></a>
                    </li>
                    <li><a href="{{URL::to('/aboutpage')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">About US</span></a>
                    </li>
                </ul>
            </li> 
            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Shippings</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/shippingList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Shippings List</span></a>
                    </li>
                </ul>
            </li>

            
            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User"> Slider</span></a>
                <ul class="menu-content">
                    <li><a href="{{URL::to('/homeSlider')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Home Slider</span></a></li>

                    <li><a href="{{URL::to('/categorySlider')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Category Slider</span></a></li>
                </ul>
            </li>

            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Settings</span></a>
                <ul class="menu-content">
                    <li><a href="{{ URL::to('/currency-list') }}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Currency</span></a>
                    </li>
                     <ul class="menu-content">
                        <li><a href="{{URL::to('/smtp')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">SMTP</span></a>
                        </li>
                        <li><a href="{{URL::to('/socialMedia')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Soical Media</span></a>
                        </li>
                        <li><a href="{{URL::to('/siteSettings')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Site Settings</span></a>
                        </li>
                        <li><a href="{{URL::to('/defaultSiteSettings')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="Invoice List">Default Settings</span></a>
                        </li>
                    </ul>
                </ul>
            </li>
            
            <li class=" nav-item"><a href="{{URL::to('/allsubscriber')}}"><i class="menu-livicon" data-icon="notebook"></i><span class="menu-title" data-i18n="Account Settings">Subscribers </span></a>
            </li>
            
            <li class=" nav-item"><a href="{{URL::to('/allticket')}}"><i class="menu-livicon" data-icon="notebook"></i><span class="menu-title" data-i18n="Account Settings">Ticket </span><span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                <?php $ticket_count = DB::table('tbl_support_ticket')->where('status', 0)->count() ; echo number_format($ticket_count) ; ?>
            </span></a>
            </li>
            <li class=" nav-item"><a href="{{URL::to('/allcontact')}}"><i class="menu-livicon" data-icon="notebook"></i><span class="menu-title" data-i18n="Account Settings">Contact From </span>
            <span class="badge badge-light-danger badge-pill badge-round float-right mr-2">
                    <?php $contact = DB::table('contact')->where('status', 0)->count() ; echo number_format($contact) ; ?>
                    </span>
            </a>
            </li>
            

        </ul>
    </div>
</div>
<!-- END: Main Menu-->

@yield('content')

<!-- BEGIN: Footer-->
<!--<footer class="footer footer-static footer-dark">-->
<!--    <p class="clearfix mb-0"><span class="float-left d-inline-block">2021 &copy; AVAILTRADE</span><span class="float-right d-sm-inline-block d-none">Crafted with<i class="bx bxs-heart pink mx-50 font-small-3"></i>by<a class="text-uppercase" href="https://1.envato.market/pixinvent_portfolio" target="_blank">Pixinvent</a></span>-->
<!--        <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>-->
<!--    </p>-->
<!--</footer>-->
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
<script src="{{ URL::to('public/app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<!-- BEGIN: Page JS-->
<!-- BEGIN: Page JS-->
<script src="{{ URL::to('public/app-assets/js/scripts/forms/select/form-select2.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/forms/number-input.js')}}"></script>
<!-- BEGIN: Page Vendor JS-->
<script src="{{ URL::to('public/app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/pages/app-invoice.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/datatables/datatable.js')}}"></script>
<script src="{{ URL::to('//cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/dropzone.js') }}"></script>
<script src="{{URL::to('//cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/pickers/dateTime/pick-a-datetime.min.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
</script>

@yield('js')
</body>
<!-- END: Body-->

</html>