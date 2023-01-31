<?php foreach ($media_result as $value) { ?>
    <div class="col-md-2 siam_class" id="image_product_id_<?php echo $value->id ; ?>">
        <div class="card">
          <img class="card-img-top img-thumbnail" src="{{URL::to('public/images/'.$value->image)}}" alt="image" style="height: 150px;">
          <i class="fa fa-check icon_show selected_icon" aria-hidden="true" style="display: none;"></i>
          <input type="hidden" name="captureInput" class="captureInput" value="<?php echo $value->image ; ?>">
          <input type="hidden" name="captureidinfo" class="captureidinfo" value="<?php echo $value->id ; ?>">
        </div>
    </div> 
<?php } ?>

<div class="col-12 m-1" id="product_image_pagination" >
  {!! $media_result->onEachSide(1)->links() !!}
</div>
