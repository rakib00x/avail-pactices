<div class="member sonia member_with_<?php echo $scQuery->id; ?>" zamirul="<?php echo $scQuery->id; ?>" sabbir="<?php echo $scQuery->first_name.' '.$scQuery->last_name; ?>" style="background-color:#ffefb3">
	<div class="photo">
	    
		<img class="avatar" src="{{ URL::to('public/images') }}/{{ $scQuery->image }}" alt="">
	</div>
	<div class="userinfo">
		<h2 style="width: 100% !important;" class="username"><?php echo $scQuery->first_name.' '.$scQuery->last_name; ?> <span id="message_count_<?php echo $scQuery->id;  ?>">0</span></h2>
		<p style="width: 100% !important;" class="company"><?php echo $scQuery->storeName; ?></p>
	</div>
</div>