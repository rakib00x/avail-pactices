<?php foreach($result as $mainchatvalue): ?>

    <div class="member sonia member_with_<?php echo $mainchatvalue->id; ?>" zamirul="<?php echo $mainchatvalue->id; ?>" sabbir="<?php echo $mainchatvalue->first_name.' '.$mainchatvalue->last_name; ?>">
    	<div class="photo">

		<?php if($mainchatvalue->image != "" || $mainchatvalue->image != null){
			if(strpos($mainchatvalue->image, "https") !== false){
				$image_url = $mainchatvalue->image ;
			} else{
				$image_url = "public/images/".$mainchatvalue->image;
			}
		}else{
			$image_url = "public/images/Image 4.png";
		} ?>
		<img  src='{{ URL::to("$image_url") }}' style="height: 40px!important; margin-right: 5px;"/>

    	</div>
    	<div class="userinfo">
    		<h2 style="width: 100% !important;" class="username username_color_<?php echo $mainchatvalue->id; ?>"><?php echo $mainchatvalue->first_name.' '.$mainchatvalue->last_name; ?> <span id="message_count_<?php echo $mainchatvalue->id;  ?>">0</span></h2>
    		<p style="width: 100% !important;" class="company username_color_<?php echo $mainchatvalue->id; ?>"><?php echo $mainchatvalue->storeName; ?></p>
    	</div>
    	
    	
    </div>
<?php endforeach; ?>