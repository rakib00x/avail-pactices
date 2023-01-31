<div class="row">
    <div class="col-md-4">
        <label>Ads Title<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="ads_heading" class="form-control ads_heading" name="ads_heading" value="{{ $value->ads_heading }}">
    </div>

    <div class="col-md-4">
        <label>Ads Paragraph</label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="ads_paragraph" class="form-control ads_paragraph" name="ads_paragraph" value="{{ $value->ads_paragraph }}">
    </div>

    <div class="col-md-4">
        <label>Ads Link <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="ads_link" class="form-control ads_link" name="ads_link" value="{{ $value->ads_link }}">
    </div>

    <div class="col-md-4">
        <label>Link Title <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="link_title" class="form-control link_title" name="link_title" value="{{ $value->link_title }}">
    </div>

    <div class="col-md-4">
        <label>Ads Image<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control category_icon" id="ads_image" name="ads_image" value="{{ $value->ads_image }}">
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/popupAds/'.$value->ads_image)}}" alt="" width="200" height="200">
        </span>
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">
    
    <input type="hidden" name="selected_icon_edit" >
    <br>
    <br>
    <br>
    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
    </div>
</div>
