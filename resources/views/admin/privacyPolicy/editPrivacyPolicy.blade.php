<div class="row">
    <div class="col-md-4">
        <label>Titile  <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" id="meta_title" class="form-control meta_title" name="meta_title" value="<?php echo $value->meta_title ; ?>" required="">
    </div>

    <div class="col-md-4">
        <label>Discription  <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <textarea type="text" id="meta_discription" class="form-control meta_discription summernote" name="meta_discription" value="<?php echo $value->meta_discription ; ?>" required=""></textarea>
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.summernote').summernote();
    });
  </script>