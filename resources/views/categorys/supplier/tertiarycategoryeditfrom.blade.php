{!! Form::open(['id' =>'editTertiaryCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
    <div class="form-body">
        <div class="row">
            <div class="col-md-4">
                <label>Select Category<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-control edit_main_category_edit" name="edit_main_category_edit" required="">
                    <option value="">Select Main Category</option>
                    <?php foreach ($priamry_edit_all as $privalue45) { ?>
                        <option value="<?php echo $privalue45->id; ?>" <?php if($tertiary_value->primary_category_id == $privalue45->id){echo "selected"; }else{echo ""; } ?>><?php echo $privalue45->category_name; ?></option>
                    <?php } ?>
                    
                </select>
            </div>                                            

            <div class="col-md-4">
                <label>Select Secondary Category<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-control secondary_category_edit_ter" name="secondary_category_edit_ter" required="">
                    <option value="">Select Secondary Category</option>
                    <?php foreach ($editsecondarycategory as $secvalue55) { ?>
                        <option value="<?php echo $secvalue55->id; ?>" <?php if($tertiary_value->secondary_category_id == $secvalue55->id){echo "selected"; }else{echo ""; } ?>><?php echo $secvalue55->secondary_category_name; ?></option>
                    <?php } ?>
                </select>
            </div>                                            

            <div class="col-md-4">
                <label>Tertiary Category Name<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text tertiary_category_name_eidt" class="form-control" name="tertiary_category_name_eidt" value="<?php echo $tertiary_value->tartiary_category_name; ?>" required="">
            </div>

            <input type="hidden" name="edit_sec_primary_id" value="<?php echo $tertiary_value->id ; ?>">

            <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
            </div>
        </div>
    </div>
{!! Form::close() !!}
