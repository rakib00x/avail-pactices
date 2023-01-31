@extends('marketing.employee-master')
@section('content')
@push('styles')
<style>
    @media screen and (min-width: 992px){
        .modal-dialog {
            max-width: 1000px!important;
        }
    }
    .siam_active .card{
        border: 1px solid red ;
    }

    .siam_class{
        cursor: pointer;
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
                                <li class="breadcrumb-item"><a href="{{URL::to('/marketing/dasboard')}}"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Page</a>
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
                                            <span>Paymeent History</span>
                                        </a>
                                    </li>
                                     <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="account-pill-more" data-toggle="pill" href="#account-vertical-more" aria-expanded="false">
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
                                                    {!! Form::open(['id' =>'updateinfo','method' => 'post','role' => 'form', 'files'=>'true']) !!}
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                
                                                                <?php if($info->photo != null){
                                                                $image_url ="public/images/marketing/".$info->photo;
                                                                 }else{
                                                                    $image_url = "/public/frontEnd/default-user.png";
                                                                  
                                                                }
                                                                ?>
                                                                
                                                                <img src="{{ URL::to("$image_url") }}" class="rounded mr-75" alt="profile image"  height="64" width="64">
                                                                
                                                                <div class="controls">
                                                                    <label>Image</label>
                                                                    
                                                                    <input type="file" class="form-control" name="photo" id="photo">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" class="form-control" name="name" id="name" value="{{$info->name}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>User Name</label>
                                                                    <input type="text" class="form-control" name="username" id="username" value="{{$info->username}}">

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" readonly="" class="form-control" name="email"  value="{{$info->email}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                            changes</button>
                                                        </div>
                                                    </div>
                                                    {!! Form::close() !!}

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
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>New Password</label>
                                                                        <input type="password" name="password" class="form-control" placeholder="New Password" minlength="6" required >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
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
                                                <div class="tab-pane fade" id="account-vertical-more" role="tabpanel" aria-labelledby="account-pill-more" aria-expanded="false">

                                                    {!! Form::open(['id' =>'updateInfoOther','method' => 'post','role' => 'form', 'files'=>'true']) !!}
                                                        <div class="col-12">
                                                        <div class="row">
                                                                
    
                                                                
                                                                 <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Birth date</label>
                                                               <input type="date"  class="form-control" name="dob" value="{{$info->dob}}" required min="1980-01-01" max="2007-12-31">
                                                                       
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        
                                                            
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Division</label>
                                                                <select class="form-control district_id" name="city" id="city"  required="">
                                                                    @php
                                                                    $district = DB::table('districts')->orderBy('id', 'asc')->get();
                                                                    @endphp
                                                                   <option value="" <?php if($info->city == ""){echo "selected"; }  ?>>Select Country</option>
                                                                   <?php foreach ($district as $cvalue) { ?>
                                                                   <option value="<?php echo $cvalue->id; ?>" <?php if($info->city == $cvalue->id){echo "selected";}else{echo " ";} ?>><?php echo $cvalue->name; ?></option>
                                                                        <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                @php
                                                                    $thana = DB::table('thanas')->orderBy('id', 'asc')->get();
                                                                    @endphp
                                                                <label>Thana</label>
                                                                <select class="form-control" name="thana" id="thana" required="">
                                                                    <option value="" <?php if($info->thana == ""){echo "selected"; }  ?>>Select Country</option>
                                                                    <?php foreach ($thana as $calue) { ?>
                                                                   <option value="<?php echo $calue->id; ?>" <?php if($info->thana == $calue->id){echo "selected";}else{echo " ";} ?>><?php echo $calue->name; ?></option>
                                                                        <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Phone</label>
                                                                    <input type="text" class="form-control" required placeholder="Phone number" name="mobile" id="mobile" value="{{$info->mobile}}" data-validation-required-message="This phone number field is required">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Father Name</label>
                                                                    <input type="text" class="form-control" required placeholder="Father Name" name="father_name" id="father_name" value="{{$info->father_name}}" data-validation-required-message="This phone number field is required">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Mother Name</label>
                                                                    <input type="text" class="form-control" required placeholder="Mother Name" name="mather_name" id="mather_name" value="{{$info->mather_name}}" data-validation-required-message="This phone number field is required">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <input type="text" class="form-control" name="address" id="address" placeholder="address" value="{{$info->address}}">
                                                            </div> 
                                                        </div>
                                                        <div class="col-12">
                                                        <div class="form-group">
                                                        <div class="controls">
                                                        <label>Work Area</label>
                                                        <input type="text"  class="form-control" name="work_area" value="{{$info->work_area}}" placeholder="Work Area" >
                                                        </div>
                                                                </div>
                                                            </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Education Qulification</label>
                                                                <input type="text" class="form-control" name="edu_qulification" id="edu_qulification" placeholder="Education Qulification" value="{{$info->edu_qulification}}">
                                                            </div> 
                                                        </div>
                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                            changes</button>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                    </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">

                                                    <form id="userInfo" novalidate>
                                                        <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                        <div class="controls">
                                                        <label>Work Area</label>
                                                        <input type="text"  class="form-control" name="work_area" value="{{$info->work_area}}" readonly>
                                                        </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                        
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                
                                                                <label>Shop List </label>
                                                                <input type="text"  class="form-control"  value="{{$info->shop_list}}" placeholder="Shop List" readonly>
                                                            </div>
                                                        </div>
                                                         <div class="col-12">
                                                            <div class="form-group">
                                                
                                                                <label>Rate </label>
                                                                <input type="text"  class="form-control" name="shop_list" value="{{$info->rate}}" placeholder="Rate" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Pay Paymeent</label>
                                                                    <input type="text" class="form-control" required placeholder="Pay Amount"  value="{{$info->confirm_amount}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Due Amount</label>
                                                                    <input type="text" class="form-control" required placeholder="Due Amount"  value="{{$info->peanding_amount}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label>Total Balance</label>
                                                               <input type="text"  class="form-control" name="balance" value="{{$info->balance}}" placeholder="Total Balance" readonly >
                                                            </div>
                                                        </div>
                                                        <!--<div class="col-12 d-flex flex-sm-row flex-column justify-content-end">-->
                                                        <!--    <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save-->
                                                        <!--    changes</button>-->
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

    </div>
</div>
</div>
@endsection
@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
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
            'url':"{{ url('/marketingChange') }}",
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
        var weburl      = $("[name=weburl]").val() ;


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
            'url':"{{ url('/updateBuyerBasicInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {dob:dob, country_id:country_id, mobile:mobile, weburl:weburl},
            success:function(data){
                console.log(data) ;
                if (data == "duplicate_found") {
                    toastr.warning('Sorry .. Mobile Number Alraey Exist', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }else if(data == "not_adult"){
                    toastr.danger('You are not 18 yet', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }else{
                    toastr.success('Records Update Successfully', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }
            }
        });
    });


    $("#updateinfo").submit(function(e){
        e.preventDefault();

        let myForm = document.getElementById('updateinfo');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/marketingUpdate') }}",
            'data': formData,
            'processData': false, 
            'contentType': false,
            'type': 'POST',
            success:function(data){
                if (data) {
                    toastr.success('Records Update Successfully', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }
            }
        });
    });
    
     $("#updateInfoOther").submit(function(e){
        e.preventDefault();

        let myForm = document.getElementById('updateInfoOther');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/marketingUpdateSe') }}",
            'data': formData,
            'processData': false, 
            'contentType': false,
            'type': 'POST',
            success:function(data){
                if (data) {
                    toastr.success('Records Update Successfully', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }
            }
        });
    });


</script>
    <script type="text/javascript">
       $('body').on('change', '.district_id', function (e) {
            e.preventDefault();

            var district_id = $('.district_id :selected').val() ;
            $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
             });
            $.ajax({
                'url':"{{ url('/getThana') }}",
                'type':'post',
                'dataType':'text',
                data: {district_id: district_id},
                success:function(data){
                    $("#thana").empty();
                    $("#thana").html(data);
                  
                }
            });

        });
    </script>
@endsection
