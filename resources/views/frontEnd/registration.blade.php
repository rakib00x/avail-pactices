@extends('frontEnd.master')
@section('title','Registration')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/registration.css') }}">
@endsection
@section('content')
<div class="wrapper" style="background: #f4f4f4;">
    <div class="container">
        <!-- start of the four box -->
        <div class="columns">

            <div class="column is-three-fifths is-offset-one-fifth box mb-5 pt-5">
                <h1 class="pl-5 pb-5" style="font-size: 30px;font-weight: bold;margin-left:14rem;">Buyer & Seller Registration</h1>
                <div class="columns pb-5 pl-5">
                	<form enctype="multipart/form-data" onsubmit="return mySubmitFunction(event)" method="post" >
                    <table>
                        <tr>
                            <td style="font-size:24px;">Please choose your type:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td style='font-size:24px;'>
                                &nbsp;&nbsp;<input type="radio" name="user_type" class="user_type" value="3" checked="checked"> <label>Buyer</label>
                                &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="user_type" class="user_type" value="2"> <label>Seller</label>
                            </td>
                                <!--<span style="display:none">-->
                            <!--    &nbsp;&nbsp;<input type="radio" name="user_type" class="user_type" value="7"> <label>Indristrial</label>&nbsp;&nbsp;<input type="radio" name="user_type" class="user_type" value="6"> <label>Marketing</label>-->
                            <!--    </span>-->
                            <!--</td>-->
                            <!--<input type="hidden" name="user_type" class="user_type" value="3">-->
                        </tr>
                        <tr>
                            <td class="td-right">Country/Region:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <?php 

                                    $result = DB::table('tbl_countries')
                                        ->orderBy('countryName', 'asc')
                                        ->get() ;
                                 ?>
                                <select class="reg-input" id="country" name="country" required="">
                                    <option value="">Select Country</option>
                                    <?php foreach ($result as $value): ?>
                                        <?php $country_code = DB::table('countries')->where('country_code', $value->countryCode)->first() ; ?>
                                        <option value="{{ $value->id }}" get_country_code="<?php echo $country_code->phone_code; ?>" <?php if($value->countryCode == Session::get('countrycode')){echo "selected"; } ?> style="font-size:24px;">{{ $value->countryName }}</option>
                                    <?php endforeach ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-right">First Name:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" type="text" name="first_name" required="">
                            </td>
                        </tr>

                        <tr>
                            <td class="td-right">Last Name:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" name="last_name" type="text" required="">
                            </td>
                        </tr>
                       <tr>
                            <td class="td-right">Email address:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                            	<span id="email_validation"></span>
                                <input class="reg-input" name="email" id="email_check" type="email" required="">
                            </td>
                        </tr>

                         <tr>
                            <td class="td-right">Phone number:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <span id="mobile_validation"></span>
                                <input class="reg-code" name="mobilecode" value="<?php $country_info = DB::table('countries')->where('country_code', Session::get('countrycode'))->first() ; echo "+".$country_info->phone_code; ?>" readonly type="text"><input class="reg-mobilenumner" name="mobile" id="mobile_check" type="text" required="">
                            </td>
                        </tr>

                        <tr>
                            <td class="td-right">Password:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" type="password" id="new_password" name="password" required="">
                            </td>
                            <td style="padding-top:13px !important;"><i class="fa fa-times-circle siam_check_sss" style="display: none;" aria-hidden="true"></i><i class="fa fa-check-circle siam_check_sss2" style="display: none;" aria-hidden="true"></i></td>
                            <td style="padding-top:13px !important;"><span id="togglePasswshow" class="fa fa-eye fa-eye-slash" style="margin-left: -43px;margin-top: 10px;"></span></td>
                        </tr>

                        <tr>
                            <td class="td-right">Repeat Password:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" type="password" name="repassword" id="confirm_password" required="">
                            </td>
                            <td style="padding-top:13px !important;"><i class="fa fa-times-circle siam_check_sss3" style="display: none;" aria-hidden="true"></i><i class="fa fa-check-circle siam_check_sss4" style="display: none;" aria-hidden="true"></i></td>
                            <td style="padding-top:13px !important;"><span id="togglePassword" class="fa fa-eye fa-eye-slash" style="margin-left: -43px;margin-top: 10px;"></span></td>
                        </tr>

                      <tr>
                            <td></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                &nbsp;&nbsp;Didn't Have An Supplier Account? <a href="{{ URL::to('supplierregistration') }}">Supplier Registration</a>
                            </td>
                        </tr>
                        
                        <tr>
                            <td></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                &nbsp;&nbsp;<input type="checkbox" name="termsandcondition" value="1" > <a href="{{ URL::to('terms-and-condition') }}">Terms and Condition</a>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-submit" type="submit" value="Agree and Register">
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

	$('.user_type').change(function(e){
		e.preventDefault() ;
		var user_type = $(this).val() ;

		if (user_type == 3) {
			$('.store_name_validation').css('display', 'none');
		}else{
			$('.store_name_validation').removeAttr('style') ;
		}
	});    

    $('#country').change(function(e){
        e.preventDefault() ;

        var phone_code = $('option:selected', this).attr('get_country_code');
        console.log(phone_code) ;
        $(".reg-code").val("+"+phone_code) ;
    });

	$('#store_name').keyup(function(e){
		e.preventDefault() ;
		var store_name = $(this).val() ;
		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
        });
        $.ajax({
            'url':"{{ url('/checkSupplierStoreName') }}",
            'type':'post',
            'dataType':'text',
            data: {store_name: store_name},
            success:function(data){
            	if (data == 'success') {
            		$('#store_section').empty().append('<p style="color:green">Valid Store Name</p>') ;
            	}else{
            		$('#store_section').empty().append('<p style="color:red">Sorry! Store Name Already Exist.</p>') ;
            	}

            }
        });


	});
</script>

<script>
	function mySubmitFunction(e) {
	  e.preventDefault();

	  var user_type 	= $('input[name="user_type"]:checked').val() ;
	  var country 		= $("#country :selected").val() ;
	  var mobile 		= $("[name=mobile]").val() ;
	  var first_name 	= $("[name=first_name]").val() ;
	  var last_name 	= $("[name=last_name]").val() ;
	  var email 		= $("[name=email]").val() ;
	  var password 		= $("[name=password]").val() ;
	  var repassword 	= $("[name=repassword]").val() ;
	  var store_name 	= $("#store_name").val() ;
// 	  var newsletter 	= $('input[name="newsletter"]:checked').val() ;
	  var termsandcondition 	= $('input[name="termsandcondition"]:checked').val() ;
	   
	  if(user_type == undefined){
	        toastr.warning('Select Registration Type.', 'Warning', { positionClass: 'toast-top-center', });
	  	    return false ;
	  }
	  
	  if (user_type == 2) {
	  	if (store_name == "") {
	  		$('#store_section').empty().append('<p style="color:red">Store Name failed Is required</p>') ;
	  		toastr.warning("Store Name failed Is required");
	  		
	  	}
	  }

        if(password.length < 8){
            toastr.warning('Password less than 8 Character.', 'Warning', { positionClass: 'toast-top-center', });
	  	    return false ; 
        }

	  if (password != repassword) {
	        toastr.warning('Password And Re Password Not Match.', 'Warning', { positionClass: 'toast-top-center', });
	  	    return false ;
	  }
	  
	  
	  if(termsandcondition == undefined){
	        toastr.warning('Check term & conditions first.', 'Warning', { positionClass: 'toast-top-center', });
  	        return false ;
	  }
	  

	  $(".btn_submit").prop( "disabled", true ) ;


	  $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
        });
        
        $.ajax({
            'url':"{{ url('/registrationStore') }}",
            'type':'post',
            'dataType':'text',
            data: {user_type: user_type, country:country, first_name:first_name, last_name:last_name, mobile:mobile, email:email, password:password, repassword:repassword, store_name:store_name},
            success:function(data){
                
                // console.log(data);
                // return false;
                
            	if (data == "success") {
            		toastr.success('Open your email and click on verify link and then try to login.', 'Registration Success !! ', { positionClass: 'toast-top-center', });
          			function explode(){
          			    if(user_type == 2){
          			        url = "login";
          			    }else{
          			        url = "login";
          			    }
		            	
                		$(location).attr("href", url);
		            }
		            setInterval(explode,5000);
            	}else if(data == "email_duplicate"){
            		toastr.warning('Sorry ! Mail Already Exist.', '', { positionClass: 'toast-top-center', });
	  				return false ;
            	}else if(data == "mobile_duplicate"){
            		toastr.warning('Sorry ! Mobile Already Exist.', '', { positionClass: 'toast-top-center', });
	  				return false ;
            	}else if(data == "invalid_mail"){
            		toastr.warning('Sorry ! Invalid Mail.', '', { positionClass: 'toast-top-center', });
	  				return false ;
            	}else if(data == "duplicate_storename"){
            		$('#store_section').empty().append('<p style="color:red">Sorry! Store Name Already Exist.</p>') ;
            		toastr.warning('Store Name failed Is required.', '', { positionClass: 'toast-top-center', });
	  				return false ;
            	}

            }
        });

	}

	$("#email_check").change(function(e){
		e.preventDefault() ;

		var email = $(this).val() ;

		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
        });
        $.ajax({
            'url':"{{ url('/registrationEmailCheck') }}",
            'type':'post',
            'dataType':'text',
            data: {email: email},
            success:function(data){
               $("#email_validation").empty().html(data) ;
            }
        });

	});

	$("#mobile_check").change(function(e){
		e.preventDefault() ;

		var mobile = $(this).val() ;

		$.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
        });


        $.ajax({
            'url':"{{ url('/registrationMobileCheck') }}",
            'type':'post',
            'dataType':'text',
            data: {mobile: mobile},
            success:function(data){
               $("#mobile_validation").empty().html(data) ;
            }
        });

	});


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

	togglePassword.addEventListener('click', function (e) {
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
