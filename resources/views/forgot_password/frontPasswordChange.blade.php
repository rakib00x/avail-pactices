@extends('frontEnd.master')
@section('title','Change Password')
@section('content')
<main class="main">
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
	<div class="container mt-5">
        <!-- start of the four box -->
        <div class="columns is-centered">

            <div class="column is-full box mb-5 pt-5">
                <h1 class="pl-5 pb-5" style="font-size: 20px;font-weight: bold;">Change Password</h1>
                
                @if (!empty(Session::get('failed')))
                
                    <div class="notification is-danger is-light" style="font-size:24px">
                      <button class="delete"></button><strong><?php
                            $message2 = Session::get('failed');
                            if($message2){
                                    echo $message2;
                                    Session::put('failed',null);
                                }
                            ?></strong>
                    </div>
                @endif
                
                @if (!empty(Session::get('success')))
                
                    <div class="notification is-primary is-light" style="font-size:24px">
                      <button class="delete"></button><strong><?php
                            $message2 = Session::get('success');
                            if($message2){
                                    echo $message2;
                                    Session::put('success',null);
                                }
                            ?></strong>
                    </div>
                @endif
                
                @if (count($errors) > 0)
                    <div class="notification is-danger is-light" style="font-size:24px">
                      <button class="delete"></button><strong>@foreach ($errors->all() as $error){{ $error }} @endforeach</strong>
                    </div>
                @endif
                
                <div class="columns pb-5 pl-5">
                	<form enctype="multipart/form-data" action="{{URL::to('/frontPasswordUpdate')}}" method="post">
                	@csrf    
                    <table>

                        <tr>
                            <td class="td-right">New Password</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" type="password" id="new_password" name="new_password" placeholder="New Password" required="">
                            </td>
                            <td style="padding-top:13px !important;"><i class="fa fa-times-circle siam_check_sss" style="display: none;" aria-hidden="true"></i><i class="fa fa-check-circle siam_check_sss2" style="display: none;" aria-hidden="true"></i></td>
                            <td style="padding-top:13px !important;"><span id="togglePasswshow" class="fa fa-eye fa-eye-slash" style="margin-left: -43px;margin-top: 10px;"></span></td>
                        </tr>
                        
                        <tr>
                            <td class="td-right">Confirm New Password</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" type="password" id="confirm_password" name="confirm_password" placeholder="New Confirm Password" required="">
                            </td>
                            <td style="padding-top:13px !important;"><i class="fa fa-times-circle siam_check_sss3" style="display: none;" aria-hidden="true"></i><i class="fa fa-check-circle siam_check_sss4" style="display: none;" aria-hidden="true"></i></td>
                            <td style="padding-top:13px !important;"><span id="togglePasswordshow" class="fa fa-eye fa-eye-slash" style="margin-left: -43px;margin-top: 10px;"></span></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-submit" type="submit" value="Change Password">
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <center>
                                <img src="images/facebook.jpg" alt="">
                                &nbsp;&nbsp;
                                <img src="images/twitter.jpg" alt="">
                                &nbsp;&nbsp;
                                <img src="images/google.jpg" alt="">
                                &nbsp;&nbsp;
                                <img src="images/linkedin.jpg" alt="">
                                </center>
                            </td>
                        </tr>

                    </table>

                    </form>
                </div>
            </div>

        </div>
        <!-- end of the four box -->
    </div>

	<div class="mb-5"></div><!-- margin -->
</main>
@endsection

@section('js')
<script>
	@if(Session::has('message'))
	    var type = "{{ Session::get('alert-type', 'info') }}";
	    switch(type){
	        case 'info':
	            toastr.info("{{ Session::get('message') }}");
	            break;
	        
	        case 'warning':
	            toastr.warning("{{ Session::get('message') }}");
	            break;

	        case 'success':
	            toastr.success("{{ Session::get('message') }}");

		        setTimeout(function(){
	                url = "login";
	                $(location).attr("href", url);
	            }, 3000);
	            break;

	        case 'failed':
	            toastr.error("{{ Session::get('message') }}");
	            break;
	    }
  	@endif
</script>
<script>
	$("#new_password").keyup(function(e){
		e.preventDefault() ;

		var password 		= $("#confirm_password").val().length ;
		var new_password 	= $(this).val().length ;

		if (new_password > 7) {
			$(".siam_check_sss2").removeAttr('style') ;
			$(".siam_check_sss").css('display','none') ;

			if (password != new_password) {
				$(".btn_submit").attr('disabled') ;
			}else{
				$(".btn_submit").removeAttr('disabled') ;
			}

		}else{
			$(".btn_submit").attr('disabled') ;
			$(".siam_check_sss").removeAttr('style') ;
			$(".siam_check_sss2").css('display','none') ;
		}
	});
	$("#confirm_password").keyup(function(e){
		e.preventDefault() ;
		var password = $("#new_password").val().length ;
		var new_password = $(this).val().length ;
		
		var password_s      =  $("#new_password").val();
		var new_password_s  =   $(this).val();

		if (new_password > 7) {
		    
		    if(password_s == new_password_s){
		        $(".siam_check_sss4").removeAttr('style') ;
			    $(".siam_check_sss3").css('display','none') ;
		    }else{
		        $(".siam_check_sss3").removeAttr('style') ;
			    $(".siam_check_sss4").css('display','none') ;
		    }
			
			if (password == new_password) {
			    
				$(".btn_submit").attr('disabled') ;
			}else{
				$(".btn_submit").removeAttr('disabled') ;
				
			}
		}else{
			$(".btn_submit").attr('disabled') ;
			$(".siam_check_sss3").removeAttr('style') ;
			$(".siam_check_sss4").css('display','none') ;
		}
	});
	togglePasswshow.addEventListener('click', function (e) {
    const type = new_password.getAttribute('type') === 'password' ? 'text' : 'password';
    new_password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
	});

	togglePasswordshow.addEventListener('click', function (e) {
    const type = confirm_password.getAttribute('type') === 'password' ? 'text' : 'password';
    confirm_password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
	});
	
	document.addEventListener('DOMContentLoaded', () => {
      (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
        const $notification = $delete.parentNode;
    
        $delete.addEventListener('click', () => {
          $notification.parentNode.removeChild($notification);
        });
      });
    });
</script>
@endsection
