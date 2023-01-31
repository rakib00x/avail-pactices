<div class="col-md-12">
    <div class="row" style="border: 2px solid #fff;padding: 10px;height: 600px;">
        @foreach ($result as $value)
            <div class="col-2 mb-1">
                <a href="#" onclick="mediaStatusChange(<?php echo $value->id ; ?>)" >
                    <img src="{{ URL::to('/public/images/'.$value->image)}}" alt="" class="img-thumbnail <?php if($value->select_status == 1){echo "media_active";}else{echo ""; } ?>" style="width: 100%;height:100px;" id="media_active_status_<?php echo $value->id; ?>">
                    <i class="fa fa-check icon_show selected_icon" aria-hidden="true" style="display: <?php if($value->select_status == 0){echo "none";}else{echo "";} ?>" id="media_image_<?php echo $value->id; ?>"></i>
                </a>
            </div>
        @endforeach
    </div>  
    <div class="row">
        <div class="col-6 offset-md-6" style="margin-top: 10px;">
            <ul class="pagination" style="float: right;">
                {!! $result->onEachSide(1)->links() !!}
            </ul>    
        </div>
    </div>
</div>