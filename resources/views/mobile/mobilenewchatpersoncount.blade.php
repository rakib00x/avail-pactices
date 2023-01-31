@foreach($result as $ncahtperson)
    @php
        $scQuery = DB::table('express')->where('id',$ncahtperson->id)->first();
    @endphp
    <?php if($ncahtperson->id != $login_primary_id && $scQuery != null): ?>
    
       <?php if($scQuery->image != "" || $scQuery->image != null){
             if($scQuery->type == 2){
                 $image_url_2 = "public/images/spplierPro/".$scQuery->image;
                           }else{
                   $image_url_2 = "public/images/buyerPic/".$scQuery->image;
                     }
                    
                     }else{
                     $image_url_2 = "public/images/Image 4.png";
                   } 
             ?>
    
        <a class="list-group-item d-flex align-items-center" href="{{ URL::to('m/chat/'.$ncahtperson->id) }}">
            <span class="noti-icon">
                    <img class="avatar" src='{{ URL::to("$image_url_2") }}' alt="">
                
            </span>
        <div class="noti-info">
            <h6 class="mb-0"><?php echo $scQuery->first_name.' '.$scQuery->last_name; ?> <span id="message_count_<?php echo $ncahtperson->id; ?>">0</span></h6><span><?php echo $scQuery->storeName; ?></span>
        </div>
        </a>
    <?php endif; ?>
@endforeach
