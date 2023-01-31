@extends('mobile.master-website')
@section('content')
    <?php 
        $base_url = "https://availtrade.com/";
    ?>
<!-- Login Wrapper Area-->
<div class="login-wrapper d-flex align-items-center justify-content-center text-center">
    
    <style>
    .siam_check_sss{
        color:red;
        margin-left: -68px;
        margin-top: 10px;
    }
    .siam_check_sss2{
        color:green;
        margin-left: -68px;
        margin-top: 10px;
    }
    .siam_check_sss3{
        color:red;
        margin-left: -68px;
        margin-top: 10px;
    }
    .siam_check_sss4{
        color:green;
        margin-left: -68px;
        margin-top: 10px;
    }
    </style>
    
    <!-- Background Shape-->
    <div class="background-shape"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5"><img class="big-logo" src="img/core-img/logo-white.png" alt="">
                <!-- Register Form-->
                <div class="register-form mt-5 px-4">
                     @if (!empty(Session::get('login_faild')))
                    <article class="message is-danger">
                      <div class="message-header">
                        <p><?php
                        $message2 = Session::get('login_faild');
                        if($message2){
                                echo '<strong>'.$message2.'</strong>';
                                Session::put('login_faild',null);
                            }
                        ?></p>
                      </div>
                    </article>
                    @endif

                    {!! Form::open(['url' =>'m/mobilelogin','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}

                        <div class="form-group text-start mb-4"><span>Email</span>
                            <label for="username"><i class="lni lni-user"></i></label>
                            <input class="form-control" id="username" name="email" type="text" placeholder="info@example.com" required>
                        </div>
                        <div class="form-group text-start mb-4"><span>Password </span>
                            <label for="password"><i class="lni lni-lock"></i></label>
                            <input class="form-control" id="password" name="password" id="password" type="password" placeholder="********************" required>
                            <span id="togglePasswordshow" class="fa fa-eye fa-eye-slash" style="margin-left: 280px;margin-top: -28px;z-index:999"></span>
                        </div>
                        <button class="btn btn-success btn-lg w-100" type="submit">Log In</button>

                    {!! Form::close() !!}
                </div>
                <!-- Login Meta-->
                <div class="login-meta-data"><a class="forgot-password d-block mt-3 mb-1" href="{{ URL::to('m/fpass') }}">Forgot Password?</a>
                    <p class="mb-0">Didn't have an account?<a class="ms-1" href="{{ URL::to('m/register') }}">Register Now</a></p><br>
                   
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_headline')
   Login
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
togglePasswordshow.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});
</script>
@endsection

