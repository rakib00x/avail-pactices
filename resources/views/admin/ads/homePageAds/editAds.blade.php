
<div class="row">
     <div class="col-md-4">
        <label>Select Secondary Category<span style="color:red;">*</span></label>
    </div>
    
    <div class="col-md-8 form-group">
        <select class="form-control" id="primary_category_id" class="primary_category_id" name="primary_category_id">
            <option value="">Select Category</option>
            <?php foreach ($all_primarycategory as $svalue) { ?>
                <option value="<?php echo $svalue->id ; ?>" <?php if($svalue->id == $value->primary_category_id){echo "selected"; }else{echo "";} ?>><?php echo $svalue->category_name." ".$svalue->id ; ?></option>
            <?php } ?>
        </select>
    </div>
    
    <div class="col-md-4">
        <label>Ads Title <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="jason" class="form-control title" name="ads_title" value="<?php echo $value->ads_title ; ?>" required="">
    </div>
    <div class="col-md-4">
        <label>Ads Link <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="kabir" class="form-control link" name="ads_link" value="<?php echo $value->ads_link ; ?>">
    </div>

    <div class="col-md-4">
        <label>Image Kewords<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="hassan" class="form-control image_keyword" name="image_keyword" value="<?php echo $value->image_keyword ; ?>">
    </div>


    <div class="col-md-4">
        <label>Ads Image<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control category_icon" name="ads_image">
        {{--<input type="hidden" name="slected_category_icon" class="slected_category_icon" id="logo" value="<?php echo $value->ads_image; ?>">--}}
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/adminAds/'.$value->ads_image)}}" alt="" width="200" height="200">
        </span>
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">
    <input type="hidden" name="selected_icon_edit" >

    <br>
    <br>
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>