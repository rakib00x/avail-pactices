 @foreach($fetchingChat as $headermessage)
 <article class="media sender_media_<?php echo $headermessage->sender_id; ?> another_member_selector" siam_main_id="{{ $headermessage->sender_id }}">
        <figure class="media-left">
            <?php if($headermessage->image != "" || $headermessage->image != null){
                if(strpos($headermessage->image, "https") !== false){
                        $image_url_2 = $headermessage->image ;
                        $image_system = 1 ;
                    } else{

                        if($headermessage->type == 2){
                            $image_url = env("APP_URL")."public/images/spplierPro/".$headermessage->imag;
                        }else{
                            $image_url = env("APP_URL")."public/images/buyerPic/".$headermessage->imag;
                        }
                        $image_system = 0 ;
                    }
                }else{
                    $image_url_2 = env("APP_URL")."public/images/Image 4.png";
                    $image_system = 0 ;
                } 
            ?>
            @if($image_system = 0 )
                <img style="border-radius: 50%;" src='{{ URL::to("$image_url_2") }}'>
            @else
                <img style="border-radius: 50%;" src="<?php echo $image_url_2; ?>">
            @endif
                
        </figure>
        <div class="media-content">
            <div class="content">
                <p>{{ $headermessage->first_name." ".$headermessage->last_name }}</p>
            </div>
            <nav class="level is-mobile">
                <div class="level-left">
                    @php 
                        $last_message = DB::table('tbl_messages')
                            ->where('sender_id', $headermessage->sender_id)
                            ->where('receiver_id', $headermessage->receiver_id)
                            ->orderBy('id', 'desc')
                            ->first() ;
                    @endphp
                    <p>{{ $last_message->message }}</p>
                </div>
            </nav>
        </div>
        <div class="media-right">
            <div class="circle">
                <span class="circle__content sender_message_<?php echo $headermessage->sender_id; ?>">{{ $headermessage->totalnewmessage }}</span>
            </div>
        </div>
</article>
@endforeach
<div class="cart-button">
    <a href="{{ URL::to('msBox') }}">
    <input type="submit" class="cart-submit" value="View all messages >"></a>
</div>