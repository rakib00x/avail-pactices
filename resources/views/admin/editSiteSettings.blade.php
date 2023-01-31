
<div class="row">
    <div class="col-md-4">
        <label>Logo <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control category_icon" name="logo">
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/'.$settings->logo)}}" alt="" width="200" height="200">
        </span>
    </div>


    <div class="col-md-4">
        <label>Ads Image<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control category_icon" name="favicon">
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/'.$settings->favicon)}}" alt="" width="200" height="200">
        </span>
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $settings->id ; ?>">
    <input type="hidden" name="selected_icon_edit" >

    <br>
    <br>
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>