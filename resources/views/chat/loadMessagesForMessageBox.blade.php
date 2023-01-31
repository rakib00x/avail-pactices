<?php foreach($fetchingChat as $chat){
    $product_id = $chat->product_id;
?>
    <li class="<?php if($chat->receiver_id != $sender_id){ echo "replies"; }else{ echo "sent"; } ?> ">

        @if($chat->receiver_id != $sender_id)

            <?php
                $my_info = DB::table('express')->where('id', $sender_id)->first();
                    if($my_info->image != "" || $my_info->image != null){
                    if(strpos($my_info->image, "https") !== false){
                        $image_url_1 = $my_info->image ;
                    } else{

                        if($my_info->type == 2){
                            $image_url_1 = "public/images/spplierPro/".$my_info->image;
                        }else{
                            $image_url_1 = "public/images/buyerPic/".$my_info->image;
                        }
                    }
                }else{
                    $image_url_1 = "public/images/1644087686613man-icon-gentleman-logo-a-with-a-beard-vector-23194787.jpg";
                } 
            ?>
            <img class="imgees" src='{{ URL::to("$image_url_1") }}' alt="">

        @else
            <?php
                $sender_info = DB::table('express')->where('id', $receiver_id)->first();
                if($sender_info->image != "" || $sender_info->image != null){
                    if(strpos($sender_info->image, "https") !== false){
                        $image_url = $sender_info->image ;
                    } else{

                        if($sender_info->type == 2){
                            $image_url = "public/images/spplierPro/".$sender_info->image;
                        }else{
                            $image_url = "public/images/buyerPic/".$sender_info->image;
                        }
                    }
                }else{
                    $image_url = "public/images/Image 4.png";
                } ?>
                <img class="imgde" src='{{ URL::to("$image_url") }}' alt="">
        @endif

        @if($chat->message)
        <p>
           {{ $chat->message }}
        </p>
        @endif

        @if($chat->chatphoto)
        
        <li class=" "><span>
           <img src="{{ URL::to('public/images/'.$chat->chatphoto) }}" alt="" style="height:50%;width:50%;float:<?php if($chat->receiver_id != $sender_id){ echo "right"; }else{ echo "left"; } ?>">
        </span></li>

        @endif

    </li>
<?php } ?> 