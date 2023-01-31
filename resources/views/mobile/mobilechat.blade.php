@extends('mobile.master-website')
@section('content')
    <div class="page-content-wrapper" >
      <!-- Live Chat Intro-->
      <div class="live-chat-intro pt-5 mb-4">
          <?php if($receiverPhotoQuery->image != "" || $receiverPhotoQuery->image != null){
                                                    
             if($receiverPhotoQuery->type == 2){
                 $image_url_2 = "public/images/spplierPro/".$receiverPhotoQuery->image;
                           }else{
                   $image_url_2 = "public/images/buyerPic/".$receiverPhotoQuery->image;
                     }
                    
                     }else{
                     $image_url_2 = "public/images/Image 4.png";
                   } 
             ?>
        <p>Start a conversation</p><img src='{{ URL::to("$image_url_2") }}' alt="">
        <div class="status online">{{ $receiverPhotoQuery->first_name.' '.$receiverPhotoQuery->last_name }}</div>
        <!-- Use this code for "Offline" Status-->
        <!-- .status.offline We’ll be back soon-->
      </div>
      <!-- Support Wrapper-->
      <div class="support-wrapper py-3">
        <div class="container chat-window">
          <!-- Live Chat Wrapper-->
          <div class="live-chat-wrapper chat-details" id="loadChat">

            <?php foreach($fetchingChat as $chat){
                $product_id = $chat->product_id;
            ?>
                @if($chat->receiver_id != $sender_id)

                    <!-- User Message Content-->
                    <div class="user-message-content pb-3">
                        <!-- User Message Text-->
                        <div class="user-message-text pb-1">
                            <div class="d-block">
                                <p>{{ $chat->message }}</p>
                                @if($chat->chatphoto)
                                    <img src="{{ URL::to('public/images') }}/{{ $chat->chatphoto }}" alt="" class="img-fluid" style="max-width:50%!important">
                                @endif
                            </div>
                        </div>
                    </div>
                    
                @else
                    <!-- Agent Message Content-->
                    <div class="agent-message-content d-flex align-items-start">
                        <!-- Agent Thumbnail-->
                        <div class="agent-thumbnail me-2 mt-2"><img src='{{ URL::to("$rphoto") }}' alt=""></div>
                        <!-- Agent Message Text-->
                        <div class="agent-message-text">
                            <div class="d-block">
                                <p>{{ $chat->message }}</p>
                                @if($chat->chatphoto)
                                    <img src="{{ URL::to('public/images') }}/{{ $chat->chatphoto }}" alt="" class="img-fluid" style="max-width:50%!important">
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            <?php } ?>


          </div>
        </div>
      </div>
    </div>
    <!-- Type Message Form-->
    <div class="type-text-form">
        {!! Form::open(['method'=>'post','id'=>'saveMessage','files' => true ]) !!}
            <div class="form-group file-upload mb-0">
                <input id="messagebox" type="file" name="attachment"><i class="lni lni-plus"></i>
            </div>
            <input id="messageattachment" class="form-control" name="message" cols="30" rows="10" placeholder="Type your message">
            <input type="hidden" id="receiver_id_by_ajax" value="{{ $receiver_id }}" name="receiver_id">
            <button type="submit">
                <svg class="bi bi-arrow-right" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"></path>
                </svg>
            </button>
      
        {!! Form::close() !!}
    </div>

@endsection

@section('page_headline')
    Chat
@endsection
@section('js')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    $('document').ready(function(){
        $('html,body').animate({ scrollTop: 9999 }, 'slow');
        var receiver_id = $("#receiver_id_by_ajax").val();

         // Enable pusher logging - don't include this in production
         Pusher.logToConsole = false;

         var pusher = new Pusher('01cfb52a4bea1b16b3c3', {
            cluster: 'ap2'
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function(data) {
            $("#messagebox").val("");
            $("#messageattachment").val("");


            $.ajax({
                'url':"{{ url('/m/loadMobileMessages') }}",
                'type':'post',
                'dataType':'text',
                data:{receiver_id:receiver_id},
                success:function(data)
                {
                    $("#loadChat").empty();
                    $("#loadChat").html(data);
                    $('html,body').animate({ scrollTop: 9999 }, 'slow');
                }
            });
        });
    });
    	
    $(function(){
        $('body').on('submit','#saveMessage',function(e) {
            e.preventDefault();
            
        	var form_data = new FormData(this);
            
            var receiver_id = $("#receiver_id_by_ajax").val();
            var sender_id = "<?php echo $sender_id; ?>"

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        
            $.ajax({
                url:"{{ url('/m/saveMobileMessage') }}",
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
    }) ;
</script>
@endsection

