@extends('mobile.master-website')
@section('content')
    <?php 
        $base_url = "https://availtrade.com/";
    ?>
<!-- Login Wrapper Area-->
<div class="login-wrapper d-flex align-items-center justify-content-center text-center">
    <!-- Background Shape-->
    <div class="background-shape"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-9 col-md-7 col-lg-6 col-xl-5"><img class="big-logo" src="img/core-img/logo-white.png" alt="">
                <!-- Register Form-->
                <div class="register-form mt-5 px-4" style="margin-top:5rem;">
                    <form enctype="multipart/form-data" onsubmit="mySubmitFunction(event)" method="post" >
                        
                        <div class="form-group text-start mb-1"><span style="margin-left: 1rem;font-size: 2.2rem;">Choose user type</span>
                            <table style="color: #fff;font-size:12px;">
                                <tr >
                                    <td><input style="margin-left:2.4rem;" type="radio" value="3" name="user_type" checked></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td style="font-size:20px;">Buyer</td>
                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td><input  type="radio" value="2" name="user_type"></td>
                                    <td>&nbsp;&nbsp;</td>
                                    <td style="font-size:20px;">Seller</td>
                                    <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
                                    <!--<td><input type="radio" value="" name="user_type"></td>-->
                                    <!--<td>&nbsp;&nbsp;</td>-->
                                    <!--<td>Indristrial</td>-->
                                    <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>-->
                                    <!--<td><input type="radio" value="" name="user_type"></td>-->
                                    <!--<td>&nbsp;&nbsp;</td>-->
                                    <!--<td>Marketing</td>-->
                                </tr>
                            </table>
                        </div>
                        <div class="form-group text-start mb-4 mt-3"><span>Country/Region</span>
                            <label><i class="lni lni-money-location"></i></label>
                            <select class="mb-3 form-control form-select" name="country" id="" required>
                                <?php 

                                    $result = DB::table('tbl_countries')
                                        ->orderBy('countryName', 'asc')
                                        ->get() ;
                                ?>
                                
                                <option value="">Select Country</option>
                                <?php foreach ($result as $value): ?>
                                    <?php $country_code = DB::table('countries')->where('country_code', $value->countryCode)->first() ; ?>
                                    <option value="{{ $value->id }}" get_country_code="<?php echo $country_code->phone_code; ?>" <?php if($value->countryCode == "BD"){echo "selected"; } ?>>{{ $value->countryName }}</option>
                                <?php endforeach ?>

                            </select>
                        </div>
                        
                        <div class="form-group text-start mb-4"><span>First Name</span>
                            <label><i class="lni lni-user"></i></label>
                            <input class="form-control" name="first_name" type="text" required>
                        </div>
                        
                        <div class="form-group text-start mb-4"><span>Last Name</span>
                            <label><i class="lni lni-user"></i></label>
                            <input class="form-control" name="last_name" type="text" required>
                        </div>
                        
                        <!--<div class="form-group text-start mb-4 store_name_validation" style="display:none">-->
                        <!--    <span>Store Name</span>-->
                        <!--    <label><i class="lni lni-shopping-basket"></i></label>-->
                        <!--    <input class="form-control" type="text" name="store_name" id="store_name">-->
                        <!--</div>-->
                        
                        <div style="color:#ffffff !important;" class="form-group text-start mb-4" id="email_validation"></div>
                        
                        <div class="form-group text-start mb-4"><span>Email</span>
                            <label for="email"><i class="lni lni-envelope"></i></label>
                            <input class="form-control" name="email" id="email" type="email" placeholder="help@example.com" required>
                        </div>
                        
                        <div style="color:#ffffff !important;" class="form-group text-start mb-4" id="mobile_validation"></div>
                        
                        <div class="form-group text-start mb-4"><span>Phone Number</span>
                            <table width="100%">
                                <tr width="100%">
                                    <td width="5%"><label style="color: #fff;"><i class="lni lni-phone"></i></label></td>
                                    <td width="7%">&nbsp;&nbsp;</td>
                                    <td width="88%"><input class="form-control" type="text" placeholder="01700000000" name="mobile" required></td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="form-group text-start mb-4"><span>Password</span>
                            <label><i class="lni lni-lock"></i></label>
                            <input class="input-psswd form-control" type="password" name="password" id="password" placeholder="********************" required>
                            <span id="togglePasswordshow" class="fa fa-eye fa-eye-slash" style="margin-left: 280px;margin-top: -28px;z-index:999"></span>
                        </div>
                        
                        <div class="form-group text-start mb-4"><span>Repeat Password</span>
                            <label><i class="lni lni-lock"></i></label>
                            <input class="input-psswd form-control" type="password" name="repassword" id="repassword" placeholder="********************" required>
                            <span id="togglePassword" class="fa fa-eye fa-eye-slash" style="margin-left: 280px;margin-top: -28px;z-index:999"></span>
                        </div>
                        <div class="form-group text-start mb-4">
                            <div class="form-group">
                                <input type="checkbox">
                                 <a style="color: #fff;" href="{{route('fterms')}}">Terms &amp; Condition</a>
                                 <input type="hidden" name="newsletter" value="1" >
                          </div>
                        </div>
                         <div class="login-meta-data mb-1">
                    <p class="mt-3 mb-0">Already have an account?<a class="ms-1" href="{{ URL::to('signin') }}">Sign In</a></p>
                </div>
                        
                        <button class="btn btn-success btn-lg w-100 mb-4" type="submit">Sign Up</button>
                    </form>
                </div>
                <!-- Login Meta-->
                <div class="login-meta-data">
                    <p class="mt-3 mb-0">Already have an account?<a class="ms-1" href="{{ URL::to('signin') }}">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page_headline')
    Create an account
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
 $('#country').change(function(e){
        e.preventDefault() ;

        var phone_code = $('option:selected', this).attr('get_country_code');
        $(".reg-code").val("+"+phone_code) ;
    });


	$("#password").keyup(function(e){
		e.preventDefault() ;

		var password 		= $("#repassword").val().length ;
		var new_password 	= $(this).val().length ;
		if (new_password > 5 ) {
			$(".siam_check_sss2").removeAttr('style') ;
			$(".siam_check_sss").css('display','none') ;
		}else{
			$(".btn_submit").attr('disabled') ;
			$(".siam_check_sss").removeAttr('style') ;
			$(".siam_check_sss2").css('display','none') ;
		}
	});
	
	$("#repassword").keyup(function(e){
		e.preventDefault() ;
		var password = $("#password").val().length ;
		var new_password = $(this).val().length ;

		if (new_password > 5 && password == new_password) {
			$(".siam_check_sss4").removeAttr('style') ;
			$(".siam_check_sss3").css('display','none') ;
			$(".siam_check_sss2").removeAttr('style') ;
			$(".siam_check_sss").css('display','none') ;
		}else{
			$(".btn_submit").attr('disabled') ;
			$(".siam_check_sss3").removeAttr('style') ;
			$(".siam_check_sss4").css('display','none') ;
		}
	});

</script>

<script>

	function mySubmitFunction(event) {
        event.preventDefault();

     var user_type 	= $('input[name="user_type"]:checked').val() ;
	  var country 		= $("[name=country]").val() ;
	  var mobile 		= $("[name=mobile]").val() ;
	  var first_name 	= $("[name=first_name]").val() ;
	  var last_name 	= $("[name=last_name]").val() ;
	  var email 		= $("[name=email]").val() ;
	  var password 		= $("[name=password]").val() ;
	  var repassword 	= $("[name=repassword]").val() ;
	  
	  var store_name 	= $("#store_name").val() ;
	  
	  var newsletter 	= $("input[name='newsletter']").val() ;



	  if (password != repassword) {
	  	toastr.warning("Password And Re Password Not Match");
	  	return false ;
	  }

	  $(".btn_submit").prop( "disabled", true ) ;


	  $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
        });
        $.ajax({
            'url':"{{ url('/m/registrationStore') }}",
            'type':'post',
            'dataType':'text',
            data: {user_type: user_type, country:country, first_name:first_name, last_name:last_name, mobile:mobile, email:email, password:password, repassword:repassword, newsletter:newsletter, store_name:store_name},
            success:function(data){
            	if (data == "success") {
            		toastr.success('Registration Successfully Completed.', 'Please Check Your Email And Verify', { positionClass: 'toast-top-center', });
          			function explode(){
          			    if(user_type == 2){
          			        url = "<?php echo env('APP_URL'); ?>login";
          			    }else{
          			        url = "<?php echo env('APP_URL'); ?>login";
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
            	}else if(data == "news_status"){
            		toastr.warning('Check Newsletter Status.', '', { positionClass: 'toast-top-center', });
	  				return false ;
            	}else if(data == "duplicate_storename"){
            		$('#store_section').empty().append('<p style="color:red">Sorry! Store Name Already Exist.</p>') ;
            		toastr.warning('Store Name failed Is required.', '', { positionClass: 'toast-top-center', });
	  				return false ;
            	}else{
            		toastr.warning('Check Newsletter Status.', '', { positionClass: 'toast-top-center', });
	  				return false ;
            	}

            }
        });


	}

	$('[name="email"]').change(function(e){
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

	$('[name="mobile"]').change(function(e){
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
                //console.log(data);
               $("#mobile_validation").empty().html(data);
            }
        });

	});
</script>
<script>
togglePasswordshow.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});
</script>
<script>
togglePassword.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'repassword';
    repassword.setAttribute('type', type);
    this.classList.toggle('fa-eye-slash');
});
</script>
@endsection