<div class="row">
    <div class="col-md-12 form-group mt-2">
        <label>Subject <span style="color:red;">*</span></label>
        <input type="text" class="form-control" name="conditions_name" value="{{ $value->conditions_name }}" required="">
    </div>

    <div class="col-md-12 form-group">
        <label>Terms Details <span style="color:red;">*</span></label>
        <textarea class="form-control summernote" name="conditions_details" required=""><?php echo $value->conditions_details; ?></textarea>
    </div>

    <input type="hidden" name="primary_id" value="{{ $value->id }}">

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.summernote').summernote();
    });
</script>