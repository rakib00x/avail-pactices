<?php foreach($get_quotation_reply as $replyMessage): ?>
  <div class="chat <?php if($replyMessage->sender_id == Session::get('buyer_id')){echo ''; }else{echo 'chat-left';} ?>">
    <div class="chat-body">
      <div class="chat-message">
          <p><strong>  
            <?php if($replyMessage->sender_id == Session::get('buyer_id')){
                $receiver_info = DB::table('express')->where('id', Session::get('buyer_id'))->first() ;
                if($receiver_info->storeName){echo $receiver_info->storeName; }else{echo $receiver_info->first_name." ".$receiver_info->last_name; }
            }else{
                $sender_info = DB::table('express')->where('id', $replyMessage->sender_id)->first() ;
                if($sender_info->storeName){echo $sender_info->storeName; }else{echo $sender_info->first_name." ".$sender_info->last_name; }
            } ?>
            </strong></p>
        <p>{{ $replyMessage->reply_message  }}</p>
        <span class="chat-time">{{ date("d-m-Y H:i:s A", strtotime($replyMessage->created_at)) }}</span>
      </div>
    </div>
  </div>
<?php endforeach ?>