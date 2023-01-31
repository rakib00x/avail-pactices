<?php foreach($fetchingChat as $chat){
$product_id = $chat->product_id;
?>
    <div class="chat <?php if($chat->type == 3){ echo 'chat-left'; } ?>">
        <div class="chat-avatar">
            <a class="avatar m-0">
                <img src="{{ URL::to('public/images') }}/{{ $chat->rphoto }}" alt="avatar" height="36" width="36">
            </a>
        </div>
        <div class="chat-body">
            <div class="chat-message">
                <p>{{ $chat->message }}</p>
                <img style="width:250px; height: 250px;display: <?php if($chat->chatphoto == "" || $chat->chatphoto == null){ echo 'none;'; }else{ echo '0'; } ?>" src="{{ URL::to('public/images') }}<?php if($product_id == 0){ echo '/chat'; }else{ echo ''; } ?>/{{ $chat->chatphoto }}" alt="">
                <span class="chat-time">{{ $chat->created_at }}</span>
            </div>
        </div>
    </div>
<?php } ?>
