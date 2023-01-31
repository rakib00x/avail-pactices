{!! Form::open(['id' =>'updatePrimaryCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
    <div class="form-body" id="mainCategoryEditForm">
        <div class="row">
            <div class="col-md-4">
                <label>Category Name<span style="color:red;">*</span></label>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" class="form-control primary_edit_category_name" name="primary_edit_category_name" value="<?php echo $primary_query->category_name ; ?>" required="">
            </div>

            <input type="hidden" class="priamry_edit_primary_id" name="priamry_edit_primary_id" value="<?php echo $primary_query->id ; ?>" >

            <div class="col-sm-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
            </div>
        </div>
    </div>
{!! Form::close() !!}