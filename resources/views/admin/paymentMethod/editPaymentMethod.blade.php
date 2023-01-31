
<div class="row">
    <div class="col-md-4">
        <label>Payment Method Name<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control ismail" name="paymentMethodName" value="<?php echo $value->paymentMethodName ; ?>" required="">
    </div>

    <div class="col-md-4">
        <label>Company Logo <span style="color:red;">*</span></label>

    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control" name="logo" value="<?php echo $value->logo; ?>">
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/paymeentLogo/'.$value->logo)}}" alt="" width="200" height="200">
        </span>
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">
    <input type="hidden" name="selected_icon_edit" >
    
    <br>
    <br>
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>
