<div class="row">
    <div class="col-md-4">
        <label>Select Menu<span style="color:red;">*</span></label>
    </div>
    
    <div class="col-md-8 form-group">
        <select class="form-control" id="mainmenu" class="mainmenu" name="menu_id">
            <option value="">Select Category</option>
            <?php foreach ($all_primarycategory as $svalue) { ?>
                <option value="<?php echo $svalue->id ; ?>" <?php if($svalue->id == $value->menu_id){echo "selected"; }else{echo "";} ?>><?php echo $svalue->menu_name; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-4">
        <label>Sub-Menu <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control sub_menu_name" id="sub_menu_name" name="sub_menu_name" value="<?php echo $value->sub_menu_name ; ?>" required="">
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">

    <br>
    <br>
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>