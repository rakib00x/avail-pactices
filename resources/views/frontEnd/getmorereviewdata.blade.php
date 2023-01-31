<?php foreach($all_review_pa as $reviewvalue): ?>
    <tr>
        <td>
            <?php $base_url = "https://availtrade.com/"; if($reviewvalue->image != "" || $reviewvalue->image != null){
                    if(strpos($reviewvalue->image, "https") !== false){
                       $image_url = $reviewvalue->image ;
                    } else{
                       $image_url = $base_url."public/images/".$reviewvalue->image;
                    }
                }else{
                    $image_url = $base_url."public/images/Image 4.png";
                } ?>
            <img src="{{ $image_url }}" style="width:40px;height:40px;border-radius:50%;float:left;margin-top:5px;">
            <div style="margin-left:50px">
                <p><?php if($reviewvalue->storeName != null){echo $reviewvalue->storeName; }else{echo $reviewvalue->first_name." ".$reviewvalue->last_name; } ?></p>
                <?php if($reviewvalue->review_star < 2): ?>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                <?php elseif($reviewvalue->review_star < 3): ?>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                <?php elseif($reviewvalue->review_star < 4): ?>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star"></span>
                    <span class="fas fa-star"></span>
                <?php elseif($reviewvalue->review_star < 5): ?>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star"></span>
                <?php else: ?>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                    <span class="fas fa-star checked"></span>
                <?php endif ?>
                
                <p class="text-justify">{{ $reviewvalue->review_details }}</p>  
                <span><?php echo date("d F y", strtotime($reviewvalue->created_at)); ?></span>
            </div>
        </td
       
    </tr>
    <?php endforeach?>
                                    