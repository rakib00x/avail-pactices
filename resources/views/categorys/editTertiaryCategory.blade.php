<div class="row">
    <div class="col-md-4">
        <label>Select Tertiary Category<span style="color:red;">*</span></label>
    </div>
    
    <div class="col-md-8 form-group">
        <select class="form-control primary_category" id="primary_category" class="primary_category" name="primary_category" siam="siam_main_category">
            <option value="">Select Category</option>
            <?php foreach ($all_primarycategory as $svalue) { ?>
                <option value="<?php echo $svalue->id ; ?>" <?php if($svalue->id == $value->primary_category_id){echo "selected"; }else{echo "";} ?>><?php echo $svalue->category_name." ".$svalue->id ; ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-4">
        <label>Select Secondary Category<span style="color:red;">*</span></label>
    </div>
    
    <div class="col-md-8 form-group">
        <select class="form-control secondary_category" id="secondary_category" name="secondary_category" siam="siam_secondary_category" >
            <option value="">Select Secondary Category</option>
            @foreach($all_secondarycategory as $sevalue)
            <option value="{{ $sevalue->id }}" <?php if($sevalue->id == $value->secondary_category_id){echo "selected"; }else{echo ""; } ?>>{{ $sevalue->secondary_category_name }}</option>
            @endforeach
        </select>
    </div>


    <div class="col-md-4">
        <label>Category Name<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control category_name" siam="siam_category_name" name="category_name" value="<?php echo $value->tartiary_category_name ; ?>" required="">
    </div>


    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">



    <br>
    <br>
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>
