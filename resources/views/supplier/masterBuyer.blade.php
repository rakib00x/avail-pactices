<?php
    $buyer_id       = Session::get('buyer_id');
    $buyer_type     = Session::get('buyer_type');

    if($buyer_id == null){
        return Redirect::to('/login')->send();
        exit();
    }

    if($buyer_id == null && $buyer_type == null){
        return Redirect::to('/login')->send();
        exit();
    }

    if($buyer_id == null && $buyer_type != '3'){
        return Redirect::to('/login')->send();
        exit();
    }

    if($buyer_type != '3'){
        return Redirect::to('/login')->send();
        exit();
    }


    $buyer_info = DB::table('express')->where('id', $buyer_id)->first() ;
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
    <title>Avail Trade || @yield('title','Buyer Dasboard')</title>
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
    <style type="text/css">
        body.dark-layout p, body.dark-layout small, body.dark-layout span, body.dark-layout label{
            color: #ffffff!important;
        }

        body.dark-layout .list-group .list-group-item:not([class*="list-group-item-"]), body.dark-layout .list-group .list-group-item.list-group-item-action{
            color: #ffffff!important ;
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
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="app-email.html" data-toggle="tooltip" data-placement="top" title="Email"><i class="ficon bx bx-envelope"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="{{URL::to('chat')}}" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon bx bx-chat"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#" data-language="en"><i class="flag-icon flag-icon-us mr-50"></i> English</a><a class="dropdown-item" href="#" data-language="fr"><i class="flag-icon flag-icon-fr mr-50"></i> French</a><a class="dropdown-item" href="#" data-language="de"><i class="flag-icon flag-icon-de mr-50"></i> German</a><a class="dropdown-item" href="#" data-language="pt"><i class="flag-icon flag-icon-pt mr-50"></i> Portuguese</a></div>
                        </li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i class="ficon bx bx-fullscreen"></i></a></li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon bx bx-search"></i></a>
                            <div class="search-input">
                                <div class="search-input-icon"><i class="bx bx-search primary"></i></div>
                                <input class="input" type="text" placeholder="Explore Frest..." tabindex="-1" data-search="template-search">
                                <div class="search-input-close"><i class="bx bx-x"></i></div>
                                <ul class="search-list"></ul>
                            </div>
                        </li>
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon bx bx-bell bx-tada bx-flip-horizontal"></i><span class="badge badge-pill badge-danger badge-up">5</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header px-1 py-75 d-flex justify-content-between"><span class="notification-title">7 new Notification</span><span class="text-bold-400 cursor-pointer">Mark all as read</span></div>
                                </li>
                                <li class="scrollable-container media-list"><a class="d-flex justify-content-between" href="javascript:void(0)">
                                    <div class="media d-flex align-items-center">

                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0"><img src="{{ URL::to('public/images/avatar_defualt.png') }}" alt="avatar" height="39" width="39"></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">Congratulate Socrates Itumay</span> for work anniversaries</h6><small class="notification-text">Mar 15 12:32pm</small>
                                        </div>

                                    </div>
                                </a>
                                <div class="d-flex justify-content-between read-notification cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0"><img src="{{ URL::to('public/app-assets/images/portrait/small/avatar-s-16.jpg') }}" alt="avatar" height="39" width="39"></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">New Message</span> received</h6><small class="notification-text">You have 18 unread messages</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center py-0">
                                        <div class="media-left pr-0"><img class="mr-1" src="{{ URL::to('public/app-assets/images/icon/sketch-mac-icon.png') }}" alt="avatar" height="39" width="39"></div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">Updates Available</span></h6><small class="notification-text">Sketch 50.2 is currently newly added</small>
                                        </div>
                                        <div class="media-right pl-0">
                                            <div class="row border-left text-center">
                                                <div class="col-12 px-50 py-75 border-bottom">
                                                    <h6 class="media-heading text-bold-500 mb-0">Update</h6>
                                                </div>
                                                <div class="col-12 px-50 py-75">
                                                    <h6 class="media-heading mb-0">Close</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-primary bg-lighten-5 mr-1 m-0 p-25"><span class="avatar-content text-primary font-medium-2">LD</span></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">New customer</span> is registered</h6><small class="notification-text">1 hrs ago</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="cursor-pointer">
                                    <div class="media d-flex align-items-center justify-content-between">
                                        <div class="media-left pr-0">
                                            <div class="media-body">
                                                <h6 class="media-heading">New Offers</h6>
                                            </div>
                                        </div>
                                        <div class="media-right">
                                            <div class="custom-control custom-switch">
                                                <input class="custom-control-input" type="checkbox" checked id="notificationSwtich">
                                                <label class="custom-control-label" for="notificationSwtich"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-danger bg-lighten-5 mr-1 m-0 p-25"><span class="avatar-content"><i class="bx bxs-heart text-danger"></i></span></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">Application</span> has been approved</h6><small class="notification-text">6 hrs ago</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between read-notification cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0"><img src="{{ URL::to('public/app-assets/images/portrait/small/avatar-s-4.jpg') }}" alt="avatar" height="39" width="39"></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">New file</span> has been uploaded</h6><small class="notification-text">4 hrs ago</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center">
                                        <div class="media-left pr-0">
                                            <div class="avatar bg-rgba-danger m-0 mr-1 p-25">
                                                <div class="avatar-content"><i class="bx bx-detail text-danger"></i></div>
                                            </div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">Finance report</span> has been generated</h6><small class="notification-text">25 hrs ago</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between cursor-pointer">
                                    <div class="media d-flex align-items-center border-0">
                                        <div class="media-left pr-0">
                                            <div class="avatar mr-1 m-0"><img src="{{ URL::to('public/app-assets/images/portrait/small/avatar-s-16.jpg') }}" alt="avatar" height="39" width="39"></div>
                                        </div>
                                        <div class="media-body">
                                            <h6 class="media-heading"><span class="text-bold-500">New customer</span> comment recieved</h6><small class="notification-text">2 days ago</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item p-50 text-primary justify-content-center" href="javascript:void(0)">Read all notifications</a></li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="user-nav d-sm-flex d-none"><span class="user-name"><?php echo $buyer_info->first_name." ".$buyer_info->last_name ; ?></span><span class="user-status text-muted">Available</span></div><span>
                                <?php if($buyer_info->image != "" || $buyer_info->image != null){
                                    if(strpos($buyer_info->image, "https") !== false){
                                       $image_url = $buyer_info->image ;
                                    } else{
                                       $image_url = "public/images/".$buyer_info->image;
                                    }
                                }else{
                                    $image_url = "/public/frontEnd/default-user.png";
                                } ?>

                                <img class="round" src='{{ URL::to("$image_url") }}' alt="avatar" height="40" width="40">

                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pb-0"><a class="dropdown-item" href="{{ URL::to('supplierAccountSettings') }}"><i class="bx bx-user mr-50"></i> Edit Profile</a><a class="dropdown-item" href="app-email.html"><i class="bx bx-envelope mr-50"></i> My Inbox</a><a class="dropdown-item" href="app-todo.html"><i class="bx bx-check-square mr-50"></i> Task</a><a class="dropdown-item" href="{{URL::to('supplier-chat')}}"><i class="bx bx-message mr-50"></i> Chats</a>
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
            <li class=" nav-item"><a href="{{URL::to('/buyerDashboard')}}"><i class="menu-livicon" data-icon="desktop"></i><span class="menu-title" data-i18n="Dashboard">Buyer Dashboard</span><span class="badge badge-light-danger badge-pill badge-round float-right mr-2">2</span></a>
            </li>

            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User"> Account</span></a>
                <ul class="menu-content">
                    <li class=" nav-item"><a href="{{URL::to('/buyerAccountSettings')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Account Settings</span></a>
                    </li>
                </ul>
            </li>

            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User">Address</span></a>
                <ul class="menu-content">
                    <li class=" nav-item"><a href="{{URL::to('/buyerShippingAddress')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Shipping Address</span></a>
                    </li>

                </ul>
            </li>

            <li class=" nav-item"><a href="#"><i class="menu-livicon" data-icon="users"></i><span class="menu-title" data-i18n="User"> Order</span></a>
                <ul class="menu-content">
                    <li class=" nav-item"><a href="{{URL::to('/buyerOrderList')}}"><i class="bx bx-right-arrow-alt"></i><span class="menu-item" data-i18n="List">Order List</span></a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
<!-- END: Main Menu-->

@yield('content')

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-dark">
    <p class="clearfix mb-0"><span class="float-left d-inline-block"><?php echo date('Y'); ?> &copy; PIXINVENT</span><span class="float-right d-sm-inline-block d-none">Crafted with<i class="bx bxs-heart pink mx-50 font-small-3"></i>by<a class="text-uppercase" href="https://1.envato.market/pixinvent_portfolio" target="_blank">Pixinvent</a></span>
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