<div class="chat-area">
    <div class="chat-header">
        <header class="d-flex justify-content-between align-items-center border-bottom px-1 py-75">
            <div class="d-flex align-items-center">
                <div class="chat-sidebar-toggle d-block d-lg-none mr-1"><i class="bx bx-menu font-large-1 cursor-pointer"></i>
                </div>
                <?php $user_info = DB::table('express')->where('id', $user_id)->first() ;
                        
                ?>
                <div class="avatar chat-profile-toggle m-0 mr-1">

                    <?php if($user_info->image != "" || $user_info->image != null){
                    if(strpos($user_info->image, "https") !== false){
                       $image_url = $user_info->image ;
                    }else{
                            $image_url = "public/images/".$user_info->image;
                    }
                    }else{
                            $image_url = URL::to('/public/images/av.png');
                     } ?>

                    <img src="{{ $image_url }}" alt="avatar" height="36" width="36">
                    
                    <span class="avatar-status-busy"></span>
                </div>
                <h6 class="mb-0">
                    <?php echo $user_info->first_name." ".$user_info->last_name ; ?>
                </h6>
            </div>
        </header>
    </div>
    <!-- chat card start -->
    <div class="card chat-wrapper shadow-none">
        <div class="card-content">
            <div class="card-body chat-container ps ps--active-y">
                <div class="chat-content">
                    <?php foreach ($messages as $message): ?>   
                        <div class="chat <?php if($message->sender_id == Session::get('supplier_id')){echo ""; }else{echo "chat-left"; } ?>">
                            <div class="chat-body">
                                <div class="chat-message">
                                    <p>{{ $message->message }}</p>
                                    <span class="chat-time">{{ date('h:i A', strtotime($message->created_at)) }}</span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <div class="ps__rail-x" style="left: 0px; bottom: -582px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 582px; right: 0px; height: 392px;"><div class="ps__thumb-y" tabindex="0" style="top: 212px; height: 143px;"></div></div></div>
        </div>
        <div class="card-footer chat-footer border-top px-2 pt-1 pb-0 mb-1">
            <form class="d-flex align-items-center" id="sendMessage" action="javascript:void(0);">
                <i class="bx bx-face cursor-pointer"></i>
                <i class="bx bx-paperclip ml-1 cursor-pointer"></i>
                <input type="text" class="form-control chat-message-send mx-1" name="message_text" placeholder="Type your message here...">
                <input type="hidden" name="receiver_id" value="<?php echo $user_id; ?>">
                <button type="submit" class="btn btn-primary glow send d-lg-flex"><i class="bx bx-paper-plane"></i>
                    <span class="d-none d-lg-block ml-1">Send</span></button>
            </form>
        </div>
    </div>
    <!-- chat card ends -->
</div>