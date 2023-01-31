@extends('supplier.masterSupplier')
@section('title')
    Supplier Accounts Settings
@endsection
@section('content')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-area-wrapper">
            <div class="sidebar-left">
                <div class="sidebar">
                    <!-- app chat user profile left sidebar start -->
                    <div class="chat-user-profile">
                        <header class="chat-user-profile-header text-center border-bottom">
                            <span class="chat-profile-close">
                                <i class="bx bx-x"></i>
                            </span>
                            <div class="my-2">
                                <div class="avatar">
                                    <img src="app-assets/images/portrait/small/avatar-s-11.jpg" alt="user_avatar" height="100" width="100">
                                </div>
                                <h5 class="mb-0">John Doe</h5>
                                <span>Designer</span>
                            </div>
                        </header>
                        <div class="chat-user-profile-content">
                            <div class="chat-user-profile-scroll">
                                <h6 class="text-uppercase mb-1">ABOUT</h6>
                                <p class="mb-2">It is a long established fact that a reader will be distracted by the readable content .</p>
                                <h6>PERSONAL INFORAMTION</h6>
                                <ul class="list-unstyled mb-2">
                                    <li class="mb-25">email@gmail.com</li>
                                    <li>+1(789) 950 -7654</li>
                                </ul>
                                <h6 class="text-uppercase mb-1">CHANNELS</h6>
                                <ul class="list-unstyled mb-2">
                                    <li><a href="javascript:void(0);"># Devlopers</a></li>
                                    <li><a href="javascript:void(0);"># Designers</a></li>
                                </ul>
                                <h6 class="text-uppercase mb-1">SETTINGS</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-50 "><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-tag mr-50"></i> Add
                                            Tag</a></li>
                                    <li class="mb-50 "><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-star mr-50"></i>
                                            Important Contact</a>
                                    </li>
                                    <li class="mb-50 "><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-image-alt mr-50"></i>
                                            Shared
                                            Documents</a></li>
                                    <li class="mb-50 "><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-trash-alt mr-50"></i>
                                            Deleted
                                            Documents</a></li>
                                    <li><a href="javascript:void(0);" class="d-flex align-items-center"><i class="bx bx-block mr-50"></i> Blocked
                                            Contact</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- app chat user profile left sidebar ends -->
                    <!-- app chat sidebar start -->
                    <div class="chat-sidebar card">
                        <span class="chat-sidebar-close">
                            <i class="bx bx-x"></i>
                        </span>
                        <div class="chat-sidebar-search">
                            <div class="d-flex align-items-center">
                                <div class="chat-sidebar-profile-toggle">
                                    <div class="avatar">
                                        <img src="public/app-assets/images/portrait/small/avatar-s-11.jpg" alt="user_avatar" height="36" width="36">
                                    </div>
                                </div>
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
                                @foreach($chattingpersonQuery as $chattingperson)
                                    <a href="{{ URL::to('chatDetails') }}/{{ $chattingperson->customer_id }}">
                                    <li>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar m-0 mr-50"><img src="{{ URL::to('public/images') }}/{{ $chattingperson->image }}" height="36" width="36" alt="sidebar user image">
                                                <span class="avatar-status-busy"></span>
                                            </div>
                                            <div class="chat-sidebar-name">
                                                <h6 class="mb-0">{{ $chattingperson->first_name }} {{ $chattingperson->last_name }}</h6>
                                            </div>
                                        </div>
                                    </li>
                                    </a>
                                @endforeach
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
                            <div class="chat-start d-none">
                                <span class="bx bx-message chat-sidebar-toggle chat-start-icon font-large-3 p-3 mb-1"></span>
                                <h4 class="d-none d-lg-block py-50 text-bold-500">Select a contact to start a chat!</h4>
                                <button class="btn btn-light-primary chat-start-text chat-sidebar-toggle d-block d-lg-none py-50 px-1">Start
                                    Conversation!</button>
                            </div>
                            <div class="chat-area">
                                <div class="chat-header">
                                    <header class="d-flex justify-content-between align-items-center border-bottom px-1 py-75">
                                        <div class="d-flex align-items-center">
                                            <div class="chat-sidebar-toggle d-block d-lg-none mr-1"><i class="bx bx-menu font-large-1 cursor-pointer"></i>
                                            </div>
                                            <div class="avatar chat-profile-toggle m-0 mr-1">
                                                <img src="{{ URL::to('public/images') }}/{{ $receiverQuery->image }}" alt="avatar" height="36" width="36">
                                                <span class="avatar-status-busy"></span>
                                            </div>
                                            <h6 class="mb-0">{{ $receiverQuery->first_name }} {{ $receiverQuery->last_name }}</h6>
                                        </div>
                                        <div class="chat-header-icons">
                                            <span class="chat-icon-favorite">
                                                <i class="bx bx-star font-medium-5 cursor-pointer"></i>
                                            </span>
                                            <span class="dropdown">
                                                <i class="bx bx-dots-vertical-rounded font-medium-4 ml-25 cursor-pointer dropdown-toggle nav-hide-arrow cursor-pointer" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu">
                                                </i>
                                                <span class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="JavaScript:void(0);"><i class="bx bx-pin mr-25"></i> Pin to top</a>
                                                    <a class="dropdown-item" href="JavaScript:void(0);"><i class="bx bx-trash mr-25"></i> Delete chat</a>
                                                    <a class="dropdown-item" href="JavaScript:void(0);"><i class="bx bx-block mr-25"></i> Block</a>
                                                </span>
                                            </span>
                                        </div>
                                    </header>
                                </div>
                                <!-- chat card start -->
                                <div class="card chat-wrapper shadow-none">
                                    <div class="card-content">
                                        <div class="card-body chat-container" style="overflow-y: scroll !important;">
                                            <div class="chat-content" id="loadChat">


                                            </div>
                                            <div class="ps__rail-x" style="left: 0px; bottom: -359px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 359px; right: 0px; height: 759px;"><div class="ps__thumb-y" tabindex="0" style="top: 244px; height: 515px;"></div></div></div>
                                    </div>
                                    <div class="card-footer chat-footer border-top px-2 pt-1 pb-0 mb-1">

                                        {!! Form::open(['method'=>'post','class'=>'d-flex align-items-center','id'=>'saveMessage','files' => true ]) !!}
                                            <input type="file" name="attachment">
                                            <input name="message" type="text" class="form-control chat-message-send mx-1" placeholder="Type your message here...">
                                            <button type="submit" class="btn btn-primary glow send d-lg-flex"><i class="bx bx-paper-plane"></i>
                                            <span class="d-none d-lg-block ml-1">Send</span></button>
                                        {!! Form::close() !!}

                                    </div>
                                </div>
                                <!-- chat card ends -->
                            </div>
                        </section>


                        <!-- app chat window ends -->
                        <!-- app chat profile right sidebar start -->
                        <section class="chat-profile">
                            <header class="chat-profile-header text-center border-bottom">
                                <span class="chat-profile-close">
                                    <i class="bx bx-x"></i>
                                </span>
                                <div class="my-2">
                                    <div class="avatar">
                                        <img src="public/app-assets/images/portrait/small/avatar-s-26.jpg" alt="chat avatar" height="100" width="100">
                                    </div>
                                    <h5 class="app-chat-user-name mb-0">Elizabeth Elliott</h5>
                                    <span>Devloper</span>
                                </div>
                            </header>
                            <div class="chat-profile-content p-2">
                                <h6 class="mt-1">ABOUT</h6>
                                <p>It is a long established fact that a reader will be distracted by the readable content.</p>
                                <h6 class="mt-2">PERSONAL INFORMATION</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-25">email@gmail.com</li>
                                    <li>+1(789) 950-7654</li>
                                </ul>
                            </div>
                        </section>
                        <!-- app chat profile right sidebar ends -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->
@endsection

@section('js')
<script>
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        'url':"{{ url('/loadSupplierChat') }}",
        'type':'post',
        'dataType':'text',
        success:function(data)
        {
            $("#loadChat").html(data);
            $(".chat-container").animate({ scrollTop: 9999999 }, 'slow');
        }
    });

    setInterval(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/getUnreadMessageSupplier') }}",
            'type':'post',
            'dataType':'text',
            success:function(data)
            {
                // console.log(data);
                // return false;

                if(data.trim() == "load"){

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        'url':"{{ url('/loadSupplierChatSabbir') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data)
                        {
                            $("#loadChat").html(data);
                            $(".chat-container").animate({ scrollTop: 9999999 }, 'slow');
                        }
                    });
                }else{
                    console.log('no data found');
                }
            }
        });

    }, 500);

})

$(function(){
    $('body').on('submit','#saveMessage',function(e) {
        e.preventDefault();

        var form_data = new FormData(this);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:"{{ url('saveSupplierMessage') }}",
            type:'post',
            dataType:'text',
            contentType: false,
            processData: false,
            cache: false,
            data:form_data,
            success:function(data)
            {

                // console.log(data);
                // return false;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/loadSupplierChatSabbir') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data)
                    {
                        $('[name="message"]').val('');
                        $("#loadChat").html(data);
                        $(".chat-container").animate({ scrollTop: 9999999 }, 'slow');
                    }
                });
            }
        });

    });
})

</script>
@endsection
