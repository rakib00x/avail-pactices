<div class="row">
           <div class="col-md-4">
                    <label>Discription  <span style="color:red;">*</span></label>
                </div>
                <div class="col-md-8 form-group">
                    <textarea type="text" id="descp" class="form-control meta_discription summernote" name="descp" value="<?php echo $value->descp ; ?>" required=""></textarea>
                </div>
    
    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>