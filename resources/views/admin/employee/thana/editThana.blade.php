<div class="row">
	<div class="col-md-4">
        <label>Select District<span style="color:red;">*</span></label>
    </div>
      @php
      $dataD = DB::table('districts')->get() ;
      @endphp
                                    <div class="col-md-8 form-group">
                                        <select class="form-control district_id" name="district_id">
                                            <?php foreach ($dataD as $values) { ?>
                                             <option value="<?php echo $values->id;?>" <?php if($values->id == $value->district_id){echo "selected"; }else{echo "";} ?>><?php echo $values->name; ?></option>
                                            <?php } ?>

                                        </select>
                                    </div>


    <div class="col-md-4">
        <label> Name <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="name" class="form-control name" name="name" value="<?php echo $value->name ; ?>" required="">
    </div>
    
    <input type="hidden" name="id" value="<?php echo $value->id ; ?>">
    <!--<input type="hidden" name="district_id" value="<?php echo $value->district_id ; ?>">-->
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>