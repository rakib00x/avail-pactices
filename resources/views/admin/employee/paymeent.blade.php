<div class="row">
    <div class="col-md-4">
        <label>Shop List<span style="color:red;">*</span></label>
    </div>
   <?php
    $view = DB::table('express')->where('marketing_id', $value->id)->count();
   ?>
    <div class="col-md-4 form-group">
        <input type="text" id="shop_list" class="form-control shop_list" name="shop_list" value="<?php echo $view;?>">
    </div>
    <div class="col-md-4 form-group">
        <input type="text" id="rate" class="form-control rate" placeholder="Rate" name="rate" value="{{ $value->rate }}">
    </div>
    <div class="col-md-4">
        <label>Balance<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="text" class="form-control balance" name="balance" id="balance" value="<?php echo $value->shop_list*$value->rate; ?>" readable>
    </div>
     <div class="col-md-4">
        <label>Product Price<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="text" class="form-control balance" name="balance" id="balance" value="{{$price_pro}}" readable>
    </div>
    
    @if($view >= 10)
     <div class="col-md-4">
        <label>Monthly Payment<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="text" class="form-control montly" name="monthly" id="monthly" value="200" readable>
    </div>
    @endif
    
    <div class="col-md-4">
        <label>Confirm Paymeent<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="text" class="form-control confirm_amount" name="confirm_amount" id="confirm_amount" value="{{ $value->confirm_amount }}">
    </div>
    <div class="col-md-4">
        <label>Supplier Running Paymeent<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="text" class="form-control confirm_amount" name="confirm_amount" id="confirm_amount" value="<?php echo $view * 50; ?>">
    </div>
    <div class="col-md-4">
        <label>Net Bill Monthly<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group" >
        <input type="text" class="form-control confirm_amount" name="confirm_amount" id="confirm_amount">
    </div>

   
    <div class="col-md-4">
        <label>Peanding Paymeent <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        @php
        $cal = $value->shop_list*$value->rate;
        @endphp
        <input type="text" id="peanding_amount" class="form-control peanding_amount" name="peanding_amount" value="<?php echo $cal-$value->confirm_amount; ?>">
        
    </div>
    
    <input type="hidden" name="id" value="<?php echo $value->id ; ?>">
    
    <br>
    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
    </div>
</div>