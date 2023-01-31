<div class="row">
    <div class="col-md-4">
        <label>Brand Name <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="brand_name" class="form-control brand_name" name="brand_name" value="<?php echo $value->brand_name ; ?>" required="">
    </div> 

    <div class="col-md-4">
        <label>Brand Details <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="discription" class="form-control discription" name="discription" value="<?php echo $value->discription; ?>">
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>