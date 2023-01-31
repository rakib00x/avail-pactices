<?php $timeoutQuery = DB::table('tbl_settings')->where('id',1)->first(); $timeout = $timeoutQuery->timeout; ?>
@extends('frontEnd.master')
@section('title','Change Password')
@section('content')
<main class="main">
	<div class="container mt-5">
        <!-- start of the four box -->
        <div class="columns">

            <div class="column is-full box mb-5 pt-5">
                <h1 class="pl-5 pb-5" style="font-size: 20px;font-weight: bold;"></h1>
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
                    
                	<form enctype="multipart/form-data" action="{{URL::to('/recoveryCodeCheck')}}" method="post">
                	@csrf    
                    <table>

                        <tr>
                            <td class="td-right">Recovery Code</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="recovery-input" type="text" name="recovery_code" required="">
                            </td>
                            
                            <td class="td-right"></td>
                            <td>&nbsp;&nbsp;</td>
                            <td style="padding-top:10px !important;"><span style="font-size:21px;">Enter recovery code before</span></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>&nbsp;&nbsp;</td>
                            <td style="float: right !important;"><input class="recovery-submit" id="recovery-submit-button" type="submit" value="Submit Code"></td>
                            <td class="td-right"></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <span style="font-size:40px;font-weight:bold;margin-left: 80px;"><span id="countdowntimer"></span></span>
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
    
$(document).ready(function () {

    var timeleft = <?php echo $timeout; ?>;
    //var timeleft = 7;
    var downloadTimer = setInterval(function(){
        timeleft--;
        $("#countdowntimer").text(timeleft);
        if(timeleft <= 0){
            clearInterval(downloadTimer);
            $("#countdowntimer").empty();
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


