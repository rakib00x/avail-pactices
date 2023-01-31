<?php $timeoutQuery = DB::table('tbl_settings')->where('id',1)->first(); $timeout = $timeoutQuery->timeout; ?>
@extends('mobile.master-website')
@section('content')
    <?php 
        $base_url = "https://availtrade.com/m";
    ?>

<!-- Login Wrapper Area-->
<div class="login-wrapper d-flex align-items-center justify-content-center text-center">
    <!-- Background Shape-->
    <div class="background-shape"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5">
                <h4 class="text-white">Verify Your Mail <span style="color:red;" id="countdowntimer"></span></h4>
            
                <!-- Register Form-->
                <div class="register-form mt-5 px-4">
                    
        
                     @if (!empty(Session::get('failed')))
                     
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          <?php
                            $message2 = Session::get('failed');
                            if($message2){
                                    echo '<strong>'.$message2.'</strong>';
                                    Session::put('failed',null);
                                }
                            ?>
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        
                    @endif

                    {!! Form::open(['url' =>'recoveryCodeCheck','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}

                        <div class="form-group text-start mb-4"><span>Recovery Code</span>
                          <label for="email"><i class="lni lni-user"></i></label>
                          <input class="form-control" id="email" name="recovery_code" type="text" max="6" placeholder="Enter you verify code" required>
                        </div>
                        <button class="btn btn-warning btn-lg w-100" id="recovery-submit-button" type="submit">Verify & Procced</button>

                    {!! Form::close() !!}
                </div>
                <!-- Login Meta-->
                <div class="login-meta-data"><a class="forgot-password d-block mt-3 mb-1" href="{{ URL::to('m/signin') }}">Login</a>
                    <p class="mb-0">Didn't have an account?<a class="ms-1" href="{{ URL::to('m/register') }}">Register Now</a></p>
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
        
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;
    }
    @endif
    
    $(document).ready(function () {
    
        var timeleft = <?php echo $timeout; ?>;
        //var timeleft = 7;
        var downloadTimer = setInterval(function(){
            timeleft--;
            $("#countdowntimer").text(timeleft);
            if(timeleft <= 0){
                clearInterval(downloadTimer);
                //$("#countdowntimer").empty();
                $("#countdowntimer").html("<img id=\"resend\" src=\"{{ URL::to('public/webassets/resend.png') }}\"/>");
                $("#recovery-submit-button").hide();
            }
        },1000);
        
    })  

    $(function(){
        $('body').on('click','#resend',function(e){
           e.preventDefault();
           
            $.ajaxSetup({
            	headers: {
            	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            
            $.ajax({
            	'url':"{{ url('/resendpasswordRecoveryCode') }}",
            	'type':'post',
            	'dataType':'text',
            	success:function(data)
            	{
                    if(data == 'success'){
                        window.location.reload();
                    }
            	}
            });
           
        });
    })


</script>
@endsection

