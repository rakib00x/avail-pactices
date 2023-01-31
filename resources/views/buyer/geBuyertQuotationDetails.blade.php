<div class="row">
    <div class="col-md-12">
        
        <div class="table-responsive">
            <table class="table table-borderd">
                <tr>
                    <td>Product</td>
                    <td>:</td>
                    <td><a href="{{ URL::to('product/'.$qutation_value->slug) }}">{{ $qutation_value->product_name }}</a></td>
                </tr>
                <tr>
                    <td>Subject</td>
                    <td>:</td>
                    <td>{{ $qutation_value->subject }}</td>
                </tr>
                <tr>
                    <td>Message</td>
                    <td>:</td>
                    <td>{{ $qutation_value->message }}</td>
                </tr>
            </table>
        </div>
        
    </div>
    
    <div class="col-md-12">
        <section class="chat-window-wrapper" >
          <div class="chat-area">
            <!-- chat card start -->
            <div class="card chat-wrapper shadow-none">
              <div class="card-body chat-container ps ps--active-y" style="height:421px">
                <div class="chat-content quation_reply" id="chatbox_b<?php echo $qutation_value->id; ?>" style=" overflow-y:scroll;overflow-x:hidden;height:400px;">
                    
                    <?php foreach($get_quotation_reply as $replyMessage): ?>
                      <div class="chat <?php if($replyMessage->sender_id == Session::get('buyer_id')){echo ''; }else{echo 'chat-left';} ?>">
                        <div class="chat-body">
                            
                          <div class="chat-message" style="width:70%!important">
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
                  
                </div>
              <div class="ps__rail-x" style="left: 0px; bottom: -596px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 596px; right: 0px; height: 485px;"><div class="ps__thumb-y" tabindex="0" style="top: 268px; height: 217px;"></div></div></div>
              <div class="card-footer chat-footer border-top px-2 pt-1 pb-0 mb-1">
                  
                <form class="d-flex align-items-center" onsubmit="chatMessagesSend(event, <?php echo $qutation_value->id; ?>);">
                  <input type="text" class="form-control chat-message-send mx-1" name="reply_message" placeholder="Type your message here...">
                  <button type="submit" class="btn btn-primary glow send d-lg-flex"><i class="bx bx-paper-plane"></i>
                    <span class="d-none d-lg-block ml-1">Send</span></button>
                </form>
              </div>
            </div>
            <!-- chat card ends -->
          </div>
        </section>
    </div>

</div>


