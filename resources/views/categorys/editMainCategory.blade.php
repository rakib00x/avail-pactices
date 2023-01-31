<div class="row">
    <div class="col-md-4">
        <label>Category Name<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control category_name" name="category_name" value="<?php echo $value->category_name ; ?>" required="">
    </div>

    <div class="col-md-4">
        <label>Category Icon<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control category_icon" name="category_icon" value="<?php echo $value->category_icon; ?>">
        {{--<input type="hidden" name="slected_category_icon" class="slected_category_icon" id="slected_category_icon" value="<?php echo $value->category_icon; ?>">--}}
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/mainCtegory/'.$value->category_icon)}}" alt="" width="200" height="200">
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