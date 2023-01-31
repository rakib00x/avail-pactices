{!! Form::open(['id' =>'editSecondaryCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
    <div class="form-body">
        <div class="row">
            <div class="col-md-4">
                <label>Select Category<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-8 form-group">
                <select class="form-control edit_main_category_id" name="edit_main_category_id" required="">
                    <option value="">Select Main Category</option>
                    <?php foreach ($priamry_all as $privalue3) { ?>
                        <option value="<?php echo $privalue3->id; ?>" <?php if($secondary_value->primary_category_id == $privalue3->id){echo "selected"; }else{echo ""; } ?>><?php echo $privalue3->category_name; ?></option>
                    <?php } ?>
                    
                </select>
            </div>                                            

            <div class="col-md-4">
                <label>Category Name<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" class="form-control edit_secondary_category_name" name="edit_secondary_category_name" value="<?php echo $secondary_value->secondary_category_name; ?>" required="">
            </div>

            <input type="hidden" name="edit_primary_id" value="<?php echo $secondary_value->id ; ?>">

            <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
            </div>
        </div>
    </div>
{!! Form::close() !!}
