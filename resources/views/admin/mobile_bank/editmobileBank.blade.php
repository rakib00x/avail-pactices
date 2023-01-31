
<div class="row">
    <div class="col-md-4">
        <label>Bank Name <span style="color:red;">*</span>
        </label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control bank_name" name="bank_name" value="{{ $bank_info->bank_name }}" required="">
    </div>  

    <div class="col-md-4">
        <label>Counter Number <span style="color:red;">*</span>
        </label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control counter_number" name="counter_number" value="{{ $bank_info->counter_number }}" required="">
    </div>

    <div class="col-md-4">
        <label>Payment Number<span style="color:red;">*</span>
        </label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control payment_number" name="payment_number" value="{{ $bank_info->payment_number }}" required="">
    </div>

    <div class="col-md-4">
        <label>Logo <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control" name="bank_logo" value="{{ $bank_info->bank_logo }}">
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/mobileBank/'.$bank_info->bank_logo)}}" alt="" width="200" height="200">
        </span>
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $bank_info->id ; ?>">

    <br>
    <br>
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>





