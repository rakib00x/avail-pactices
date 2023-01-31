@extends('admin.masterAdmin')
@section('title')
Admin Accounts Settings
@endsection

@section('content')
@push('styles')
<style>
    @media screen and (min-width: 992px){
        .modal-dialog {
            max-width: 1000px!important;
        }
    }
    
    .siam_active .card{
        border: 2px solid #42b72a ;
    }
    
    .selected_icon{
        position: absolute;
        padding: 38%;
        font-size: 30px;
        color: #4ebd37;
    }
    
    .siam_class{
        cursor: pointer;
    }
    
    .meta_class_image{
        cursor: pointer;
    }
    
    .remove_project_file3{
        width: 100px;
        height: 100px;
        float: left;
        margin: 5px;
    } 
</style>
@endpush
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">Account Settings</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Pages</a>
                                </li>
                                <li class="breadcrumb-item active"> Account Settings
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- account setting page start -->
            <section id="page-account-settings">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <!-- left menu section -->
                            <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                            <i class="bx bx-cog"></i>
                                            <span>General</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                            <i class="bx bx-lock"></i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="account-pill-info" data-toggle="pill" href="#account-vertical-info" aria-expanded="false">
                                            <i class="bx bx-info-circle"></i>
                                            <span>Info</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- right content section -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                                    {!! Form::open(['url' =>'updateAdminGeneralInfo','method' => 'post','role' => 'form', 'files'=>'true']) !!}
                                                    <div class="media">
                                                        <a href="#">
                                                            <?php if($values->image != "" || $values->image != null){
                                                                if(strpos($values->image, "https") !== false){
                                                                    $image_url = $values->image ;
                                                                } else{
                                                                    $image_url = "public/images/".$values->image;
                                                                }
                                                            }else{
                                                                $image_url = "/public/app-assets/images/portrait/small/avatar-s-11.jpg";
                                                            } ?>
                                                            <img src='{{URL::to("$image_url")}}' class="rounded mr-75" alt="profile image"  height="64" width="64">
                                                        </a>
                                                        <div class="media-body mt-25">
                                                            <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                                <label for="select-files" class="btn btn-sm btn-light-primary ml-50 mb-50 mb-sm-0">
                                                                    <span>Upload new photo</span>
                                                                    <input id="select-files" class="select-files" name="images" type="file" hidden="" value="{{ $values->image }}">
                                                                </label>
                                                            </div>
                                                            <p class="text-muted ml-1 mt-50"><small>Allowed JPG, GIF or PNG. Max
                                                                size of
                                                            800kB</small></p>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>First Name</label>
                                                                    <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ $values->first_name }}" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Last Name</label>
                                                                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ $values->last_name }}" required >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>E-mail</label>
                                                                    <input type="email" class="form-control" placeholder="Email" name="email" readonly="" value="{{ $values->email }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="alert bg-rgba-warning alert-dismissible mb-2" role="alert">
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                                <p class="mb-0">
                                                                    Your email is not confirmed. Please check your inbox.
                                                                </p>
                                                                <a href="javascript: void(0);">Resend confirmation</a>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button type="submit" id="updateUserBasicInfo" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                            changes</button>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>

                                                </div>
                                                <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                                    <form  id="password_change" novalidate>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Old Password</label>
                                                                        <input type="password" class="form-control" name="old_password" required placeholder="Old Password" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <p style="color: red;text-align: center;">{{$errors->first('country')}}</p>
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>New Password</label>
                                                                        <input type="password" name="password" class="form-control" placeholder="New Password" minlength="6" required >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <p style="color: red;text-align: center;">{{$errors->first('country')}}</p>
                                                                    <div class="controls">
                                                                        <label>Retype new Password</label>
                                                                        <input type="password" name="con-password" class="form-control" placeholder="Retype new Password" minlength="6" required="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                                changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                                                    <form id="userInfo" novalidate>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Birth date</label>
                                                                        <input type="text"  class="form-control birthdate-picker pickadate" name="dob" value="<?php if($values->dob != null){echo date("d F, Y", strtotime($values->dob)); } ?>" required placeholder="Birth date date" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <select class="form-control" name="country_id" id="accountSelect" required="">
                                                                        <option value="" <?php if($values->country == ""){echo "selected"; }  ?>>Select Country</option>
                                                                        <?php foreach ($all_countries as $cvalue) { ?>
                                                                            <option value="<?php echo $cvalue->id; ?>" <?php if($values->country == $cvalue->id){echo "selected";}else{echo " ";} ?>><?php echo $cvalue->countryName; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Phone</label>
                                                                        <input type="text" class="form-control" required placeholder="Phone number" name="mobile" value="<?php echo $values->mobile ; ?>" data-validation-required-message="This phone number field is required">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                                changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!-- account setting page ends -->

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#home-fill" role="tab" aria-controls="home-fill" aria-selected="true">
                                        Select File
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-fill" data-toggle="tab" href="#profile-fill" role="tab" aria-controls="profile-fill" aria-selected="false">
                                        Upload File
                                    </a>
                                </li>
                            </ul>

                            <input type="text" name="search_keyword" id="search_keyword" class="form-control col-md-4" placeholder="Search">
                            <button type="button" class="btn btn-primary" onclick="finalselectedimage()">OK</button>
                            <button type="button" class="close" onclick="modalclosewithremoveimage()">&times;</button>
                        </div>
                        <div class="modal-body">
                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
                                <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                    <div class="row " id="table_data">


                                    </div>
                                </div>
                                <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                    <form method="post"  action="{{url('adminImage/upload')}}" enctype="multipart/form-data" 
                                    class="dropzone" id="dropzone">
                                    @csrf
                                </form>   
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-default" id="saveImage">Save</button>
                                </div>
                            </div>

                        </div>
                        <!-- Nav Filled Ends -->
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection

@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('body').on('click', '#myBtn', function (e) {
            $("#myModal").modal();
            return false ;
        });

        $('body').on('click', '#addCategory', function (e) {
            $("#addModal").modal();
            return false ;
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getAllImages') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                $("#table_data").empty();
                $("#table_data").html(data);

            }
        });

    });

    $('body').on('click', '.siam_class', function (e) {
        e.preventDefault();

        $('.siam_class').removeClass('siam_active') ;
        $(this).addClass('siam_active');

        $('#myModal').modal('show');
        
        $("#table_data").each(function(){
            $(this).find('.icon_show').css('display', 'none') ;
        });

        $(this).find('.icon_show').removeAttr("style") ;

        var inputvalu = $(this).find('.captureInput').val();
        var x = document.createElement("IMG");
        x.setAttribute("src", "public/images/" + inputvalu);
        x.setAttribute("width", "200");
        x.setAttribute("height", "200");
        x.setAttribute("alt", "The Pulpit Rock");

        $(".image_siam").empty();
        $(".image_siam").append(x);
        $(".slected_category_icon").val(inputvalu) ;

    });

    Dropzone.options.dropzone =
    {
        maxFilesize: 12,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 50000,
        removedfile: function(file) 
        {
            var name = file.upload.filename;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url("/image/delete") }}',
                data: {filename: name},
                success: function (data){
},
error: function(e) {
    console.log(e);
}});
            var fileRef;
            return (fileRef = file.previewElement) != null ? 
            fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },

        success: function(file, response) {
            console.log(response);
        },
        error: function(file, response)
        {
            return false;
        }
    };

    $("#saveImage").click(function(e){
        e.preventDefault() ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/adminSaveImage') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                Dropzone.forElement("#dropzone").removeAllFiles(true);
                toastr.success('Thanks !! Media Add Successfully Compeleted', { positionClass: 'toast-bottom-full-width', });
                $.ajax({
                    'url':"{{ url('/getAllImages') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#table_data").empty();
                        $("#table_data").html(data);

                    }
                });
                return false;
            }
        });


    }) ;

    $('body').on('keyup', '#search_keyword', function (e) {
        e.preventDefault();

        var search_keyword = $(this).val() ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getSearchValue') }}",
            'type':'post',
            'dataType':'text',
            data: {search_keyword: search_keyword},
            success:function(data){
                $("#table_data").empty();
                $("#table_data").html(data);

            }
        });

    });
    
    function finalselectedimage() {
        $("#myModal").modal('hide');
    }

    function modalclosewithremoveimage() {
        $('.siam_class').removeClass('siam_active') ;
        $("#table_data").each(function(){
            $('.icon_show').css('display', 'none') ;
        });
        $("#image_siam").empty() ;
        $("#myModal").modal('hide');
    }  
    
    $(document).on('click', '#product_image_pagination .page-link', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        adminmediaimagepaginate(page);
    });

    function adminmediaimagepaginate(page)
    {
        var search_keyword = $("#search_keyword").val() ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url:"{{ url('getadminmediaimagepaginate') }}",
            method:"POST",
            data:{page:page, search_keyword:search_keyword},
            success:function(data)
            {
                $("#myModal").show();
                $("#table_data").empty();
                $("#table_data").html(data);
            }
        });
    }


</script>
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
        setTimeout(function(){
            location.reload();
        }, 3000);
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;

        case 'failed':
        toastr.error("{{ Session::get('message') }}");
        break;
    }
    @endif
</script>

<script>
    $("#password_change").submit(function(e){
        e.preventDefault();

        var old_password        = $("[name=old_password]").val() ;
        var password            = $("[name=password]").val() ;
        var confrim_password    = $("[name=con-password]").val() ;


        if (old_password == "") {
            toastr.warning('Input Old Password First', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        if(password == "" || confrim_password == ""){
            toastr.warning('Password And Confrim Password Can Not Be Empty', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        if(password != confrim_password){
            toastr.warning('Sorry Password And Confrim Password Not Match', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/adminPasswordChange') }}",
            'type':'post',
            'dataType':'text',
            data: {old_password: old_password, password:password, confrim_password:confrim_password},
            success:function(data){
                console.log(data) ;
                if (data == "password_not_match") {
                    toastr.warning('Sorry Old Password Not Match', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }else{
                    toastr.success('Thanks Password Change Successfully', { positionClass: 'toast-bottom-full-width', });
                    $("[name=old_password]").val("") ;
                    $("[name=password]").val("") ;
                    $("[name=con-password]").val("") ;
                    return false ;
                }
            }
        });
    });       

    $("#userInfo").submit(function(e){
        e.preventDefault();

        var dob         = $("[name=dob]").val() ;
        var country_id  = $("[name=country_id]").val() ;
        var mobile      = $("[name=mobile]").val() ;

        if (dob == "") {
            toastr.warning('Select Date Of Birth', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        if(country_id == ""){
            toastr.warning('Select Country', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        if(mobile == ""){
            toastr.warning('Input Your Mobile Number', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updateAdminGeneralInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {dob:dob, country_id:country_id, mobile:mobile},
            success:function(data){
                console.log(data) ;
                if (data == "duplicate_found") {
                    toastr.warning('Sorry .. Mobile Number Alraey Exist', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }else{
                    toastr.success('Info Update Successfully', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }
            }
        });
    });

</script>   

@endsection