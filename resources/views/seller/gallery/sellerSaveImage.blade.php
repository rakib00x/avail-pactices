@foreach($result as $imagevalue)
<li class="remove_project_file3 ui-state-default"  id="item_info_<?php echo rand(11111, 99999);  ?>" style="margin-bottom: 30px;">

    <?php $media_info = DB::table('tbl_media')->where('id', $imagevalue->id)->first(); ?>

    <a href="#" style="color: red;float: right;font-size: 17px;" class="remove_project_file" border="2" getmainimageid="<?php echo $imagevalue->id ; ?>"><i class="fa fa-times" aria-hidden="true"></i> </a>
    <img width="100px" height="100px;" name="upload_project_images[]" type="file" class="new_project_image" src="{{ URL::to('/public/images/'.$imagevalue->image) }}" />
    <input name="upload_images[]" class="upload_images" type="hidden" value="<?php echo $imagevalue->image ; ?>" />
</li>
@endforeach