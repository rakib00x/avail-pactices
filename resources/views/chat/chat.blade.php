<?php if(Session::get('supplier_id') !=null): ?>
    @extends('supplier.masterSupplier')
<?php else: ?>
    @extends('buyer.masterBuyer')
<?php endif; ?>

@section('title')
Chat
@endsection

@section('content')
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-area-wrapper">
            <div class="sidebar-left">
                <div class="sidebar">
                    <!-- app chat sidebar start -->
                    <div class="chat-sidebar card">
                        <span class="chat-sidebar-close">
                            <i class="bx bx-x"></i>
                        </span>
                        <div class="chat-sidebar-search">
                            <div class="d-flex align-items-center">
                                <fieldset class="form-group position-relative has-icon-left mx-75 mb-0">
                                    <input type="text" class="form-control round" id="chat-search" placeholder="Search">
                                    <div class="form-control-position">
                                        <i class="bx bx-search-alt text-dark"></i>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <div class="chat-sidebar-list-wrapper pt-2">
                            <h6 class="px-2 pt-2 pb-25 mb-0">CHATS</h6>
                            <ul class="chat-sidebar-list">
                                <?php foreach ($result as $chatttingvalue): ?>
                                    <li class="user" id="<?php echo $chatttingvalue->supplier_id; ?>">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar m-0 mr-50">
                                                <?php if($chatttingvalue->image != "" || $chatttingvalue->image != null){
                                                    $image_url = "public/images/".$chatttingvalue->image;
                                                } else{
                                                        $image_url = URL::to('/public/images/av.png');
                                                 } ?>
                                                <img src="{{ $image_url }}" height="36" width="36" alt="sidebar user image">

                                                <!-- <span class="avatar-status-busy"></span> -->
                                            </div>
                                            <div class="chat-sidebar-name">
                                                <h6 class="mb-0"><?php echo $chatttingvalue->first_name." ".$chatttingvalue->last_name ; ?></h6>
                                            </div>
                                        </div>
                                    </li>
                                <?php endforeach ; ?>

                            </ul>
                        </div>
                    </div>
                    <!-- app chat sidebar ends -->
                </div>
            </div>
            <div class="content-right">
                <div class="content-overlay"></div>
                <div class="content-wrapper">
                    <div class="content-header row">
                    </div>
                    <div class="content-body">
                        <!-- app chat overlay -->
                        <div class="chat-overlay"></div>
                        <!-- app chat window start -->
                        <section class="chat-window-wrapper">
                            <div class="chat-start">
                                <span class="bx bx-message chat-sidebar-toggle chat-start-icon font-large-3 p-3 mb-1"></span>
                                <h4 class="d-none d-lg-block py-50 text-bold-500">Select a contact to start a chat!</h4>
                                <button class="btn btn-light-primary chat-start-text chat-sidebar-toggle d-block d-lg-none py-50 px-1">Start
                                    Conversation!</button>
                            </div>
                        </section>
                        <!-- app chat window ends -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

@endsection
@section('js')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    var receiver_id = '';
    var my_id       = "{{ Session::get('supplier_id') }}";

    $(document).ready(function () {
        // ajax setup form csrf token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;
        var pusher = new Pusher('568cb481e955a0648135', {
            cluster: 'ap2',
            forceTLS: true
        });

        var channel = pusher.subscribe('my-channel');
        channel.bind('my-event', function (data) {
            //alert(JSON.stringify(data));
            if (my_id == data.from) {
                $('#' + data.to).click();
            } else if (my_id == data.to) {
                if (receiver_id == data.from) {
                    // if receiver is selected, reload the selected user ...
                    $('#' + data.from).click();
                } else {
                    // if receiver is not seleted, add notification for that user
                    var pending = parseInt($('#' + data.from).find('.pending').html());

                    if (pending) {
                        $('#' + data.from).find('.pending').html(pending + 1);
                    } else {
                        $('#' + data.from).append('<span class="pending">1</span>');
                    }
                }
            }
        });

        $('.user').click(function () {

           receiver_id = $(this).attr('id');

           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/getMessage') }}",
                'type':'post',
                'dataType':'text',
                data: {receiver_id: receiver_id},
                success:function(data){
                    $('.chat-window-wrapper').empty().html(data);
                    scrollToBottomFunc();
                }
            });
        });

        $(document).on('submit', '#sendMessage', function (e) {

            e.preventDefault();

            let myForm = document.getElementById('sendMessage');
            let formData = new FormData(myForm);

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/message') }}",
                'data': formData,
                'processData': false, // prevent jQuery from automatically transforming the data into a query string.
                'contentType': false,
                'type': 'POST',
                success: function (data) {
                    console.log(data);
                },
                error: function (jqXHR, status, err) {
                },
                complete: function () {
                    scrollToBottomFunc();
                }
            })

        });

    });
    function scrollToBottomFunc() {

        // $(".message-wrapper").animate({
        //   scrollTop: $('.message-wrapper')[0].scrollHeight - $('.message-wrapper')[0].clientHeight
        // }, 1000);
        // return false;
    }
</script>
@endsection



