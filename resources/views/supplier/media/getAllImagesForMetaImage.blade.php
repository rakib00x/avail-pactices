<?php foreach ($media_result as $value) { ?>
    <div id="meta_class_image" class="col-md-2 meta_class_image">
        <div class="card">
          <img class="card-img-top img-thumbnail" src="{{URL::to('public/images/'.$value->image)}}" alt="image" style="height: 150px;">
          <i class="fa fa-check icon_single_show selected_icon" aria-hidden="true" style="display: none;"></i>
          <input type="hidden" name="meta_image_input" class="meta_image_input" value="<?php echo $value->image ; ?>">
        </div>
    </div> 
<?php } ?> 
