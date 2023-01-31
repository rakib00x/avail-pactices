<div class="row">
    <div class="col-md-4">
        <label>Select Menu<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <select class="form-control menuone" id="menuone" class="menuone" name="menu_id">
            <option value="">Select Menu</option>
            <?php foreach ($menu as $svalue) { ?>
                <option value="<?php echo $svalue->id ; ?>" <?php if($svalue->id == $value->menu_id){echo "selected"; }else{echo "";} ?>><?php echo $svalue->menu_name ; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="col-md-4">
        <label>Select Sub-Menu<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <select class="form-control menutwo" id="menutwo" name="sub_menu_id">
            <option value="">Select Sub-Menu</option>
            @foreach($submenu as $sevalue)
            <option value="{{ $sevalue->id }}" <?php if($sevalue->id == $value->sub_menu_id){echo "selected"; }else{echo ""; } ?>>{{ $sevalue->sub_menu_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label>Sub Sub-Menu<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control sub_sub_menu_name" id="lastmenu" name="sub_sub_menu_name" value="<?php echo $value->sub_sub_menu_name ; ?>" required="">
    </div>
    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">
    <br>
    <br>
    <br>
    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>
