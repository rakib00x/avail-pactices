<div class="row">
    <div class="col-md-4">
        <label>Ads Link <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control ads_link" id="ads_link" name="ads_link" value="{{ $ads_info->ads_link }}" required="">
    </div>

    <div class="col-md-4">
        <label>Ads Image <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control ads_image_class" name="ads_image_class" id="admineditsection" >
       <input type="hidden" name="ads_image" class="slected_category_icon" id="logo" value="<?php echo $ads_info->ads_image; ?>">
        <span id="image_siam" class="image_siam">
            <img src="{{ URL::to('public/images/'.$ads_info->ads_image) }}" style="width: 150px;height: 150px;">
        </span>
    </div>
    <input type="hidden" name="primary_id" value="<?php echo $ads_info->id; ?>">
    <input type="hidden" name="selected_icon_edit" >
    
    <br>
    <br>
    <br>
    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>