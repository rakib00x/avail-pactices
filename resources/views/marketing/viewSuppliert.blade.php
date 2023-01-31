<div class="row">
    <div class="col-md-4">
        <label>Frist Name<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text"  class="form-control"  value="{{ $value->first_name }}" readonly>
    </div>

    <div class="col-md-4">
        <label>Last Name</label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="ads_paragraph" class="form-control"  value=" {{ $value->last_name }}" readonly>
    </div>

    <div class="col-md-4">
        <label>Email <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text"  class="form-control" value="{{ $value->email }}" readonly>
    </div>

    <div class="col-md-4">
        <label>Mobile<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text"  class="form-control"  value="{{ $value->mobile }}" readonly>
    </div>
    <div class="col-md-4">
        <label>Store Name<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text"  class="form-control"  value="{{ $value->storeName }}" readonly>
    </div>
    <div class="col-md-4">
        <label>Products<span style="color:red;">*</span></label>
    </div>
     <div class="col-md-8 form-group">
        <input type="text"  class="form-control"  value="{{ $product }}" readonly>
    </div>

    <div class="col-md-4">
        <label>Address<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="text" class="form-control"   value="<?php echo $value->address; ?>" readonly>
    </div>
    <div class="col-md-4">
        <label>Reg Year<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="text" class="form-control" name="regYear"  value="<?php echo $value->regYear; ?>" readonly>
    </div>
    <div class="col-md-4">
        <label>Package Status<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="text" class="form-control" name="package_status"  value="<?php echo $value->package_status; ?>" readonly>
    </div>

    <input type="hidden" name="id" value="<?php echo $value->id ; ?>">
    
    <br>
    <br>
    <br>
    <!--<div class="col-sm-12 d-flex justify-content-end">-->
    <!--    <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>-->
    <!--</div>-->
</div>
