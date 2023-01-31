
<div class="row">
    <div class="col-md-4">
        <label>Full Name <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control" name="seller_name" value="<?php echo $value->first_name.' '.$value->last_name ; ?>" required="" readonly>
    </div>

    <div class="col-md-4">
        <label>Email <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="email" class="form-control" name="email" value="<?php echo $value->email ; ?>">
    </div>

     <div class="col-md-4">
        <label>Select Country <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <fieldset class="form-group">
            <select class="form-control country_id" id="country_id" name="country_id" required>
              <option value="">Select an option</option>
              <?php foreach ($all_countires as $values): ?>
                  <option value="{{ $values->id }}" @if($values->id == $value->country) selected @else @endif >{{ $values->countryName }}</option>
              <?php endforeach ?>
            </select>
        </fieldset>
    </div> 
    
    

    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">

    <br>
    <br>
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>