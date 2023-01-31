<div class="row">
    <div class="col-md-4">
        <label> Name <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control name_data" name="name" value="<?php echo $value->name ; ?>" required="">
    </div>
    <div class="col-md-4">
        <label> Link <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control link_data" name="link" value="<?php echo $value->link ; ?>" required="">
    </div>


    <input type="hidden" name="p_id" value="<?php echo $value->id ; ?>">
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>