<?php foreach($fetchingChat as $chat){
        $product_id = $chat->product_id;
    ?>
        @if($chat->receiver_id != $sender_id)

            <!-- User Message Content-->
            <div class="user-message-content">
                <!-- User Message Text-->
                <div class="user-message-text">
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
