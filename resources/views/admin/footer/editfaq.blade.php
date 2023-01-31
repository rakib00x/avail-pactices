<div class="row">
    <div class="col-md-4">
        <label> Name <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text"  class="form-control qun" name="qun" value="<?php echo $value->qun ; ?>" required="">
    </div>
    <div class="col-md-4">
        <label> Time <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text"  class="form-control ans" name="ans" value="<?php echo $value->ans ; ?>" required="">
    </div>


    <input type="hidden" id="pr_id" name="pr_id" value="<?php echo $value->id ; ?>">
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>