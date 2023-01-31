@extends('frontEnd.master')
@section('title','Forget Password')
@section('content')
<main class="main">
	<div class="container mt-5">
        <!-- start of the four box -->
        <div class="columns">

            <div class="column is-full box mb-5 pt-5">
                
                @if (!empty(Session::get('failed')))
                
                    <div class="notification is-danger is-light">
                      <button class="delete"></button><strong><?php
                            $message2 = Session::get('failed');
                            if($message2){
                                    echo '<strong>'.$message2.'</strong>';
                                    Session::put('failed',null);
                                }
                            ?></strong>
                    </div>
                    
                @endif
                
                <div class="columns pb-5 pl-5 is-centered" style="height: 470px;margin-top:200px;">
                    
                	<form enctype="multipart/form-data" action="{{URL::to('/sendForgotRecoveyCode')}}" method="post">
                	@csrf    
                    <table>

                        <tr>
                            <td style="font-size: 20px;font-weight: bold;">&nbsp;&nbsp;Forget password ?</td>
                        </tr>

                        <tr>
                            <td>
                                <input class="reg-input" placeholder=" Enter your registered email" type="text" name="email" required="">
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <input class="reg-submit" type="submit" value="Recover">
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

document.addEventListener('DOMContentLoaded', () => {
  (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
    const $notification = $delete.parentNode;

    $delete.addEventListener('click', () => {
      $notification.parentNode.removeChild($notification);
    });
  });
});

@if(Session::has('message'))
var type = "{{ Session::get('alert-type', 'info') }}";
switch(type){
    case 'success':
    	toastr.success("{{ Session::get('message') }}");
    	setTimeout(function(){
    		url = "password-recover";
    		$(location).attr("href", url);
    	}, 3000);
    	break;
    case 'failed':
        toastr.error("{{ Session::get('message') }}");
    break;
}
@endif
</script>
@endsection
