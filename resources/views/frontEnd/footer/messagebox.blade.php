
<?php
  	if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){
      if(Session::get('supplier_id') != null){
        $main_login_id = Session::get('supplier_id');
      }else{
        $main_login_id = Session::get('buyer_id');
      }
  }else{
      $main_login_id = 0;
  }

  if($main_login_id == 0){
    return Redirect::to('/')-send();
  }

  $customer_info = DB::table('express')->where('id', $main_login_id)->first() ;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset='UTF-8'>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="robots" content="noindex">
  <title>MessageBox-Availtrade</title>
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>

  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css'>
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'>


<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/message-box.css') }}">

</head>
<body>

<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">

      <?php if($customer_info->image != "" || $customer_info->image != null){
            if(strpos($customer_info->image, "https") !== false){
                $image_url = $customer_info->image ;
            } else{
                if($customer_info->type == 2){
                    $image_url = "public/images/spplierPro/".$customer_info->image;
                }else{
                    $image_url = "public/images/buyerPic/".$customer_info->image;
                }
            }
        }else{
            $image_url = "public/images/Image 4.png";
        }
      ?>

				<img id="profile-img" src='{{ URL::to("$image_url") }}' class="online" alt="" />
				<p>
          @if($customer_info->type == 2)
            {{ str_replace("-",' ',$customer_info->storeName) }}
          @else
            {{ $customer_info->first_name.' '.$customer_info->last_name }}
          @endif
        </p>
				<i class="fa fa-chevron-down expand-button" aria-hidden="true"></i>
				<div id="status-options">
					<ul>
						<li id="status-online" class="active"><span class="status-circle"></span> <p>Online</p></li>
						<li id="status-away"><span class="status-circle"></span> <p>Away</p></li>
						<li id="status-busy"><span class="status-circle"></span> <p>Busy</p></li>
						<li id="status-offline"><span class="status-circle"></span> <p>Offline</p></li>
					</ul>
				</div>
				<div id="expanded">
					<label for="twitter"><i class="fa fa-facebook fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mikeross" />
					<label for="twitter"><i class="fa fa-twitter fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="ross81" />
					<label for="twitter"><i class="fa fa-instagram fa-fw" aria-hidden="true"></i></label>
					<input name="twitter" type="text" value="mike.ross" />
				</div>
			</div>
		</div>
		<div id="search">
			<label for=""><i class="fa fa-search" aria-hidden="true"></i></label>
			<input type="text" placeholder="Search contacts..." id="myInput" />
		</div>
		<div id="contacts">
			<ul id="myList">
      <?php
          if(Session::get('buyer_id') != NULL){
              $login_primary_id = Session::get('buyer_id');
          }else{
              $login_primary_id = Session::get('supplier_id');
          }

          $getSupplier = DB::table('tbl_messages')->where('sender_id',$login_primary_id)->orWhere('receiver_id',  $login_primary_id)->get();
          $allSupplierIds = array();
          $allSenderIds = array();
          foreach($getSupplier as $supplierChatValue){
              $allSupplierIds[]   = $supplierChatValue->receiver_id;
              $allSenderIds[]     = $supplierChatValue->sender_id;
              
              $data_main_chat                         = array();
              $data_main_chat['chat_person_count']    = 1;
              DB::table('tbl_messages')->where('receiver_id', $login_primary_id)->update($data_main_chat) ;
          }
          $mainSupplierMarge  = array_merge($allSupplierIds, $allSenderIds);
          $uniqueArray        = array_unique($mainSupplierMarge);
      ?>
        
        <?php     
          foreach($uniqueArray as $getSupplierValue){
              $scQuery = DB::table('express')->where('id',$getSupplierValue)->first();
        ?>
          <?php if($getSupplierValue != $login_primary_id && $scQuery != null): ?>
          <li class="contact member_with_<?php echo $getSupplierValue; ?>" zamirul="<?php echo $scQuery->id; ?>" sabbir="<?php if($scQuery->type == 2){ echo str_replace("-",' ',$scQuery->storeName); }else{ echo $scQuery->first_name.' '.$scQuery->last_name; } ?>">
            <div class="wrap">
              <span class="contact-status online"></span>

              <?php if($scQuery->image != "" || $scQuery->image != null){
                    if(strpos($scQuery->image, "https") !== false){
                            $image_url_2 = $scQuery->image ;
                            $image_system = 1 ;
                        } else{
                            if($scQuery->type == 2){
                              $image_url_2 = "public/images/spplierPro/".$scQuery->image;
                            }else{
                              $image_url_2 = "public/images/buyerPic/".$scQuery->image;
                            }

                            $image_system = 0 ;
                        }
                    }else{
                        $image_url_2 = "public/images/Image 4.png";
                        $image_system = 0 ;
                    } 
                ?>
              <img src='{{ URL::to("$image_url_2") }}' id="message_person_image_<?php echo $scQuery->id; ?>" alt="">
              <div class="meta">
                <p class="name">
                @if($scQuery->type == 2)
                  {{ str_replace("-",' ',$scQuery->storeName) }}
                @else
                  {{ $scQuery->first_name.' '.$scQuery->last_name }}
                @endif
                </p>
                <p class="preview" id="last_message_<?php echo $scQuery->id; ?>">
                  @php 
                  $sender_id = $scQuery->id ;
                  $get_customer_last_message = DB::table('tbl_messages')->where(function ($query) use ($sender_id, $login_primary_id) {
                        $query->where('receiver_id', $sender_id)->where('sender_id', $login_primary_id);
                    })->oRwhere(function ($query) use ($sender_id, $login_primary_id) {
                        $query->where('receiver_id', $login_primary_id)->where('sender_id', $sender_id);
                    })->orderBy('id', 'desc')->first();
                    echo $get_customer_last_message->message; 
                  @endphp
                </p>
              </div>
            </div>
          </li>

          <?php endif; ?>
        <?php } ?>


			</ul>
		</div>
		
	</div>
	<div class="content chat-window">
		<div class="contact-profile">
    <img src="http://emilcarlsson.se/assets/harveyspecter.png" id='chat_person_image' alt="">
			<p class="supplier-name-holder">Harvey Specter</p>
			<button style="float:right;height:3rem;width:5rem;margin-top:.3rem;"> <a style="text-decoration:none;" href="{{ URL::to('') }}">Home</a></button>
			<div class="social-media">
				<!--<i class="fa fa-facebook" aria-hidden="true"></i>-->
				<!--<i class="fa fa-twitter" aria-hidden="true"></i>-->
				<!-- <i class="fa fa-instagram" aria-hidden="true"></i>-->
			</div>
		</div>
		<div class="messages">
        <ul id="loadChat">

        </ul>
        <h4 class="withoutchat" style="margin-top:10rem;padding-left:3rem;font-size:3vw;">Select chat person and start chating</h4>
		</div>
		<div class="message-input">
      {!! Form::open(['method'=>'post','id'=>'saveMessage','files' => true ]) !!}
        <div class="wrap">
            <input type="text" placeholder="Write your message..." name="message" />
                <i class="fa fa-paperclip attachment" aria-hidden="true"><input class="fiilee" type="file" name="attachment"></i>
            
            <input type="hidden" id="receiver_id_by_ajax" name="receiver_id">
          <button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </div>
      {!! Form::close() !!}
		</div>
	</div>
</div>
</script><script src='https://code.jquery.com/jquery-2.2.4.min.js'></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script >



$(".contact").click(function(){

    $('.contact').removeClass('active');
    $(this).addClass('active') ;

    var receiver_id      = $(this).attr("zamirul");
    var supplier_name    = $(this).attr("sabbir");

    $('.supplier-name-holder').empty();
    $('.supplier-name-holder').text(supplier_name);
    
    $('#receiver_id_by_ajax').empty();
    $('#receiver_id_by_ajax').val(receiver_id);

    var src_image = $("#message_person_image_"+receiver_id).attr('src');

    $('#chat_person_image').removeAttr('src');
    $('#chat_person_image').attr('src', src_image) ;

    $('.withoutchat').css('display', 'none') ;
    $('.preview').css('display', 'block');
    $('#last_message_'+receiver_id).css('display', 'none');

    $.ajaxSetup({
      headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  
    $.ajax({
      'url':"{{ url('/loadMessagesForMessageBox') }}",
      'type':'post',
      'dataType':'text',
      data:{receiver_id:receiver_id},
      success:function(data)
      {
          $("#loadChat").empty();
          $("#loadChat").html(data);
          $(".chat-window .messages").animate({ scrollTop: 9999999 }, 'slow');
      }
    });

    var my_id = <?php echo $main_login_id; ?> ;

    Pusher.logToConsole = false;

    var pusher = new Pusher('01cfb52a4bea1b16b3c3', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        $('#saveMessage')[0].reset();

        var form_id     = data.from ;
        var to_id       = data.to ;


        if (my_id == form_id && to_id == receiver_id) {
            $.ajax({
                'url':"{{ url('/loadMessagesForMessageBox') }}",
                'type':'post',
                'dataType':'text',
                data:{receiver_id:receiver_id},
                success:function(data)
                {

                    $("#loadChat").empty();
                    $("#loadChat").html(data);
                    $(".chat-window .messages").animate({ scrollTop: 9999999 }, 'slow');

                }
            });
        } else if (my_id == to_id && receiver_id == form_id) {
            if (receiver_id == form_id && to_id == my_id) {
                $.ajax({
                    'url':"{{ url('/loadMessagesForMessageBox') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{receiver_id:receiver_id},
                    success:function(data)
                    {

                        $("#loadChat").empty();
                        $("#loadChat").html(data);
                        $(".chat-window .messages").animate({ scrollTop: 9999999 }, 'slow');

                    }
                });
            } else {
                // $('.message_count').append(1);
            }
        }

    });
    
  }) 

  $(function(){
      $('body').on('submit','#saveMessage',function(e) {
          e.preventDefault();
          
        var form_data = new FormData(this);
          
        var receiver_id = $("#receiver_id_by_ajax").val();


          $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
      
          $.ajax({
              url:"{{ url('/saveMessage') }}",
              type:'post',
              dataType:'text',
              contentType: false,
              processData: false,
              cache: false,
              data:form_data,
              success:function(data)
              {
                  
                  
              }
          }); 
      });
  }) 

  var receiver_id = 0 ;
    Pusher.logToConsole = false;

    var pusher = new Pusher('01cfb52a4bea1b16b3c3', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {

        var form_id     = data.from ;
        var to_id       = data.to ;
        $('#last_message_'+form_id).empty().append(data.messages);

        $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/newchatboxpersoncount') }}",
            'type':'post',
            'dataType':'text',
            data:{receiver_id: receiver_id},
            success:function(data)
            {
                if(data != 2){
                    $(".chat-members").append(data) ;
                }
            }
        });
    });

</script>

<script>
    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myList li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
</script>
</body>
</html>