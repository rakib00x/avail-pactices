
<div class="row">
    <div class="col-md-4">
        <label>Bank Name <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control ismail" name="bank_name" value="<?php echo $value->bank_name ; ?>" required="">
    </div>

        <div class="col-md-4">
        <label>Bank Account Name <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="saiful" class="form-control saiful" name="bank_account_name" value="<?php echo $value->bank_account_name ; ?>">
    </div>

     <div class="col-md-4">
        <label>Bank Branch Name <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="aman" class="form-control aman" name="bank_branch_name" value="<?php echo $value->bank_branch_name ; ?>">
    </div> 

    <div class="col-md-4">
        <label>Bank Account Number <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="rayhan" class="form-control rayhan" name="bank_account_number" value="<?php echo $value->bank_account_number ; ?>">
    </div>


    <div class="col-md-4">
        <label>Logo <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="file" class="form-control" name="bank_logo" value="{{$value->bank_logo}}">
       {{-- <input type="hidden" name="slected_category_icon" class="slected_category_icon" id="logo" value="<?php echo $value->bank_logo; ?>">--}}
        <span id="image_siam" class="image_siam">
            <img src="{{URL::to('public/images/bankLogo/'.$value->bank_logo)}}" alt="" width="200" height="200">
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





