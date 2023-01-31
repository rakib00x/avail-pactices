<div class="row">
    <div class="col-md-4">
        <label>Ads Title<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="title" class="form-control title" name="title" value="{{ $ads_info->title }}">
    </div>

   

    <div class="col-md-4">
        <label>Ads Link </label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="ads_link" class="form-control ads_link" name="ads_link" value="{{ $ads_info->ads_link }}">
    </div>
    <div class="col-md-4">
        <label>Start Date<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="date" id="start_date" class="form-control start_date" name="start_date" value="{{ $ads_info->start_date }}">
    </div>
    <div class="col-md-4">
        <label>End Date<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="date" id="end_date" class="form-control end_date" name="end_date" value="{{ $ads_info->end_date }}">
    </div>


    <div class="col-md-4">
        <label>Ads Image<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control" name="ads_image">
        {{--<input type="hidden" name="ads_image" class="slected_category_icon" id="logo" value="<?php echo $ads_info->ads_image; ?>">--}}
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/adminssAds/'.$ads_info->ads_image)}}" alt="" width="200" height="200">
        </span>
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $ads_info->id ; ?>">
    
    <input type="hidden" name="selected_icon_edit" >
    <br>
    <br>
    <br>
    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
    </div>
</div>
