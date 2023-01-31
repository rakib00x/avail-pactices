<div class="row">
    <div class="col-md-4">
        <label>Menu Name <span style="color:red;">*</span></label>
    </div>
    
    <div class="col-md-8 form-group">
        <input type="text" id="menu_update" class="form-control menu_name" name="menu_name" value="<?php echo $value->menu_name ; ?>" required="">
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $value->id;?>">
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>