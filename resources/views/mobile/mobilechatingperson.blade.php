@extends('mobile.master-website')
@section('content')
    <?php 
        $base_url = "https://availtrade.com/";
     ?>
            <br>
            
        </div>

        <div class="notification-area pb-2" style="margin-top: 47px;">
          <div class="list-group">

            @foreach($uniqueArray as $getSupplierValue)
            @php
                $scQuery = DB::table('express')->where('id',$getSupplierValue)->first();
            @endphp
            <?php if($getSupplierValue != $login_primary_id && $scQuery != null): ?>
             <?php if($scQuery->image != "" || $scQuery->image != null){
                                                    
             if($scQuery->type == 2){
                 $image_url_2 = "public/images/spplierPro/".$scQuery->image;
                           }else{
                   $image_url_2 = "public/images/buyerPic/".$scQuery->image;
                     }
                    
                     }else{
                     $image_url_2 = "public/images/Image 4.png";
                   } 
             ?>
             <a class="list-group-item d-flex align-items-center" href="{{ URL::to('m/chat/'.$getSupplierValue) }}">
                    <span class="noti-icon">
                                <img class="avatar" src='{{ URL::to("$image_url_2") }}' alt="">
                           
                    </span>
                <div class="noti-info">
                    @php 
                        $unread_count = DB::table('tbl_messages')
                            ->join('express', 'tbl_messages.sender_id', '=', 'express.id')
                            ->select('tbl_messages.*', DB::raw('count(tbl_messages.id) as totalnewmessage'))
                            ->where('tbl_messages.receiver_id', $login_primary_id)
                            ->where('tbl_messages.is_read', 0)
                            ->where('tbl_messages.sender_id', $scQuery->id)
                            ->count() ;
                    @endphp
                    <h6 class="mb-0">
                    @if($scQuery->type == 2)
                        {{ str_replace("-",' ',$scQuery->storeName) }}
                    @else
                        {{ $scQuery->first_name.' '.$scQuery->last_name }}
                    @endif
                    <span id="message_count_<?php echo $getSupplierValue; ?>">{{ $unread_count }}</span></h6><span><?php echo $scQuery->storeName; ?></span>
                </div>
                </a>
            <?php endif; ?>
            @endforeach

          </div>
        </div>
       
    </div>

@endsection

@section('css')
<style>
    .single-product-recommended img {
        border: 1px solid #ddd !important;
        width: 142px !important;
        height: 142px !important;
        padding: 5px;
    }
</style>
@endsection

@section('page_headline')
    Chat Person
@endsection

@section('js')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    var receiver_id     = 0 ;
    Pusher.logToConsole = false;

    var pusher = new Pusher('01cfb52a4bea1b16b3c3', {
        cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {

        var form_id     = data.from ;
        var to_id       = data.to ;

        var pending = parseInt($('#message_count_'+form_id).html());
        $('#message_count_'+form_id).empty().append(pending+1);

        $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/m/mobilenewchatpersoncount') }}",
            'type':'post',
            'dataType':'text',
            data:{receiver_id: receiver_id},
            success:function(data)
            {
                if(data != 2){
                    $("#chat-members").append(data) ;
                }
            }
        });
    });

</script>
@endsection


