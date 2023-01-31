<?php foreach($fetchingChat as $chat){
    $product_id = $chat->product_id;
?>
    <div class="each-chat" style="margin-bottom: <?php if($chat->chatphoto == ""){ echo '0px;'; }else{ echo '130px;'; } ?>">
        <div class="chat-seller">
            
            <div class="seller-photo" style="display: <?php if($chat->sender_id == $sender_id){ echo "none"; }else{ echo ""; } ?>">


            @if($chat->receiver_id != $sender_id)
                
                
                
                <?php
                $siam_info1 = DB::table('express')->where('id', $chat->sender_id)->first();
                if($siam_info1->image != "" || $siam_info1->image != null){
                    if(strpos($siam_info1->image, "https") !== false){
                        $image_url = $siam_info1->image ;
                    } else{
                        
                        if($siam_info1->type == 2){
                            $image_url = "public/images/spplierPro/".$siam_info1->image;
                        }else{
                            $image_url = "public/images/buyerPic/".$siam_info1->image;
                        }
                        
                    }
                }else{
                    $image_url = "public/images/Image 4.png";
                } ?>
            @else
                
                
                <?php
                $siam_info = DB::table('express')->where('id', $receiver_id)->first();
                if($siam_info->image != "" || $siam_info->image != null){
                    if(strpos($siam_info->image, "https") !== false){
                        $image_url = $siam_info->image ;
                    } else{
                        
                        if($siam_info->type == 2){
                            $image_url = "public/images/spplierPro/".$siam_info->image;
                        }else{
                            $image_url = "public/images/buyerPic/".$siam_info->image;
                        }
                        
                    }
                }else{
                    $image_url = "public/images/Image 4.png";
                } ?>
            @endif

            <img class="avatar" src='{{ URL::to("$image_url") }}' alt="">

            </div>
            

            <div class="<?php if($chat->receiver_id != $sender_id){ echo "customer"; }else{ echo "seller"; } ?>-message">
                <?php if($chat->message): ?>
                <p class="<?php if($chat->receiver_id != $sender_id){ echo "right"; }else{ echo "left"; } ?>-message">{{ $chat->message }}</p>
                <?php endif; ?>

                @if($chat->chatphoto)
                    <img class="attachment" src="{{ URL::to('public/images') }}/{{ $chat->chatphoto }}" style="float: <?php if($chat->receiver_id != $sender_id){ echo 'right'; }else{ echo 'left'; } ?> !important;margin-top:5px;display: <?php if($chat->chatphoto == ''){ echo 'none;'; }else{ echo ''; } ?>">
                @endif

            </div>
        </div>

    </div>
<?php } ?>
