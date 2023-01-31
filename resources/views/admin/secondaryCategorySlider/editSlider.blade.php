
<div class="row">
    <div class="col-md-4">
        <label>Slider Title <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="jason" class="form-control title" name="slider_title" value="<?php echo $value->slider_title ; ?>" required="">
    </div>

        <div class="col-md-4">
        <label>Slider Link <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="kabir" class="form-control link" name="slider_link" value="<?php echo $value->slider_link ; ?>">
    </div>


    <div class="col-md-4">
        <label>Slider Image<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control category_icon" name="slider_image" id="admineditsection">
        <input type="hidden" name="slected_category_icon" class="slected_category_icon" id="logo" value="<?php echo $value->slider_image; ?>">
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/'.$value->slider_image)}}" alt="" width="200" height="200">
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





