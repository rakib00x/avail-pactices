
<div class="row">
    <div class="col-md-4">
        <label>Color Name <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control ismail" name="color_name" value="<?php echo $value->color_name ; ?>" required="">
    </div>

    <div class="col-md-4">
        <label>Image <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control category_icon" name="color_image" id="myBtn">
        <input type="hidden" name="slected_category_icon" class="slected_category_icon" id="logo" value="<?php echo $value->color_image; ?>">
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/'.$value->color_image)}}" alt="" width="200" height="200">
        </span>
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">

    <br>
    <br>
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>



