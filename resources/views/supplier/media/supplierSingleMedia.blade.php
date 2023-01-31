<?php foreach ($media_result as $value) { ?>
    <div id="single_image_select" class="col-md-2 single_image_select">
        <div class="card">
          <img class="card-img-top img-thumbnail" src="{{URL::to('public/images/'.$value->image)}}" alt="image" style="height: 150px;">
          <i class="fa fa-check icon_single_show selected_icon" aria-hidden="true" style="display: none;"></i>
          <input type="hidden" name="single_image_value" class="single_image_value" value="<?php echo $value->image ; ?>">
        </div>
    </div> 
<?php } ?> 
