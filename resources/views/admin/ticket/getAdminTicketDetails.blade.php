
<div class="row">
    <div class="col-md-4">
        <label>Ticket Title<span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <input type="text" class="form-control title" name="slider_title" value="<?php echo $ticket_details->ticket_title ; ?>" required="" readonly="">
    </div>

    <div class="col-md-4">
        <label>Ticket Details <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <textarea class="form-control" name="ticket_details" readonly=""><?php echo $ticket_details->ticket_details ; ?></textarea> 
    </div>

    <?php if ($ticket_details->image != null || $ticket_details->image != ""): ?>
        <div class="col-md-4">
            <label>Ticket Images <span style="color:red;">*</span></label>
        </div>
        <div class="col-md-8 form-group">
            <img src="{{ URL::to('public/images/'.$ticket_details->image) }}" width="200" height="200" alt="">
        </div>
    <?php endif ?>
    
    <div class="col-md-4">
        <label>Ticket Status <span style="color:red;">*</span></label>
    </div>
    <div class="col-md-8 form-group">
        <select class="form-control select2" id="ticket_status" name="ticket_status" required="">
            <option value="0" <?php if($ticket_details->status == 0){echo "selected"; }else{echo "" ;} ?>>Pending</option>
            <option value="1" <?php if($ticket_details->status == 1){echo "selected"; }else{echo "" ;} ?>>Complete</option>
        </select>
    </div>

    <div class="col-md-4">
        <label>Ticket Reply </label>
    </div>
    <div class="col-md-8 form-group">
        <textarea class="form-control" name="ticket_reply" <?php if($ticket_details->ticket_reply != null){echo "readonly"; }else{echo "" ;} ?>><?php echo $ticket_details->ticket_reply ; ?></textarea> 
    </div>

    <input type="hidden" name="primary_id" value="<?php echo $ticket_details->id ; ?>">

    <br>
    <br>
    <br>

    <div class="col-sm-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
    </div>
</div>





