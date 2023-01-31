@foreach($result as $scQuery)
<li class="contact member_with_<?php echo $scQuery->id; ?>" zamirul="<?php echo $scQuery->id; ?>" sabbir="<?php if($scQuery->type == 2){ echo str_replace("-",' ',$scQuery->storeName); }else{ echo $scQuery->first_name.' '.$scQuery->last_name; } ?>">
    <div class="wrap">
        <span class="contact-status online"></span>

        <?php if($scQuery->image != "" || $chatvalue->image != null){
            if(strpos($scQuery->image, "https") !== false){
                    $image_url_2 = $scQuery->image ;
                    $image_system = 1 ;
                } else{
                    $image_url_2 = "public/images/".$scQuery->image;
                    $image_system = 0 ;
                }
            }else{
                $image_url_2 = "public/images/Image 4.png";
                $image_system = 0 ;
            } 
        ?>
        <img src='{{ URL::to("$image_url_2") }}' id="message_person_image_<?php echo $scQuery->id; ?>" alt="">
        <div class="meta">
        
        <p class="preview">
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
@endforeach
