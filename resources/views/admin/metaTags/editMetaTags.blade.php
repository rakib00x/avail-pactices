<div class="row">
    <div class="col-md-4">
        <label>Meta Title<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="meta_title" class="form-control meta_title" name="meta_title" value="{{ $value->meta_title }}">
    </div>

    <div class="col-md-4">
        <label>Meta Details</label>
    </div>
    <div class="col-md-8 form-group">
    <textarea type="text" id="meta_details" class="form-control meta_details" name="meta_details" >{{ $value->meta_details }}</textarea>
    </div>

    <div class="col-md-4">
        <label>Meta Keywords <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <textarea type="text" id="meta_keywords"  class="form-control meta_keywords" name="meta_keywords" >{{ $value->meta_keywords }}</textarea>
    </div>

    <div class="col-md-4">
        <label>Meta Image <span style="color:red;">*</span></label>
    </div>

        <div class="col-md-8 form-group" >
        <input type="file" class="form-control category_icon" name="meta_image">
        {{--<input type="hidden" name="slected_category_icon" class="slected_category_icon" id="meta_image" value="<?php echo $value->meta_image; ?>">--}}
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/'.$value->meta_image)}}" alt="" width="200" height="200">
        </span>
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">
    <br>
    <br>
    <br>
    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
    </div>
</div>
