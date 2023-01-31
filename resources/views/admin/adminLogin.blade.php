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
    <title>Availtade Admin Login Page</title>
    <link rel="apple-touch-icon" href="{{ URL::to('public/app-assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('public/app-assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/vendors.min.css') }}">
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
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/pages/authentication.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/plugins/extensions/toastr.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ URL::to('public/app-assets/css/style.css') }}">
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern dark-layout 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="dark-layout">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- login page start -->
                <section id="auth-login" class="row flexbox-container">
                    <div class="col-xl-8 col-11">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">

                                <!-- left section-login -->
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2">Availtrade</h4>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="divider">
                                                    <div class="divider-text text-uppercase text-muted"><small>login with email</small>
                                                    </div>
                                                </div>

                                                {!! Form::open(['id' =>'adminLogin','method' => 'post','role' => 'form', 'files'=>'true']) !!}
                                                 <div class="form-group mb-50">
                                                    <label class="text-bold-600" for="exampleInputEmail1">Email address</label>
                                                    <input type="email" class="form-control" id="email" placeholder="Email address" value="{{ Cookie::get('admin_cookie_email') }}">
                                                 </div>
                                                <div class="form-group">
                                                    <label class="text-bold-600" for="exampleInputPassword1">Password</label>
                                                    <input type="password" class="form-control" id="password" placeholder="Password" value="{{ Cookie::get('admin_cookie_password') }}">
                                                </div>
                                                <div class="form-group d-flex flex-md-row flex-column justify-content-between align-items-center">
                                                    <div class="text-left">
                                                        <div class="checkbox-sm" style="margin-left: 18px;">
                                                            <input type="checkbox" class="form-check-input" name="remember" value="1" <?php if(Cookie::get('admin_remember') == 1){echo "checked"; }else{echo "";}  ?>>
                                                            <label class="checkboxsmall"><small>Keep me logged in</small></label>
                                                        </div>
                                                    </div>
                                                    <div class="text-right" style="display: none;"><a href="#" class="card-link"><small>Forgot Password?</small></a></div>
                                                </div>
                                                <button type="submit" class="btn btn-primary glow w-100 position-relative">Login<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- right section image -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-3">
                                    <div class="card-content">
                                        <img class="img-fluid" src="{{ URL::to('public/app-assets/images/pages/login.png') }}" alt="branding logo">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
                <!-- login page ends -->

            </div>
        </div>
    </div>
    <!-- END: Content-->

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

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ URL::to('public/app-assets/js/scripts/configs/vertical-menu-dark.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/core/app.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/components.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/footer.js') }}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
    <!-- END: Theme JS-->


    <!-- BEGIN: Page JS-->
    <script type="text/javascript">
    $(function(){

      $("#adminLogin").on('submit',function(e){
        e.preventDefault();

        var email     = $("#email").val();
        var password  = $("#password").val();
        var remember  = $("[name=remember]").val();

        if(email == ""){
          toastr.error('Oh shit!! You missed to provide the email', 'E-mail Required !!', { positionClass: 'toast-top-full-width', });
          return false;
        }

        if(password == ""){
          toastr.warning('Oh shit!! You missed to provide the password', 'Password Required !!', { positionClass: 'toast-top-full-width', });
          return false;
        }

        $.ajaxSetup({
        	headers: {
        	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });

        $.ajax({
        	'url':"{{ url('/adminLogin') }}",
        	'type':'post',
        	'dataType':'text',
        	data:{email:email,password:password,remember:remember},
        	success:function(data)
        	{

            if(data == "1"){
              toastr.success('Admin login granted successfully &amp; you are redirecting to <strong>ADMIN DASHBOARD</strong>', 'Access Permission !!', { positionClass: 'toast-top-full-width', });

              setTimeout(function(){
                url = "adminDashboard";
                $(location).attr("href", url);
              }, 3000);

            }else{
              toastr.error('Admin login granted failed', 'Access Permission !!', { positionClass: 'toast-top-full-width', });
            }

        	}
        });

      });

    })
    </script>
    <!-- END: Page JS-->

</body>
<!-- END: Body-->

</html>
