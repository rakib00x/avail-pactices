@extends('admin.masterAdmin')
@section('title','Home Country Decoration List')
@section('content')
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="users-list-wrapper">
                    <div class="users-list-table">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Default Settings</h4>
                                
                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                
                                @if (!empty(Session::get('success')))
                                    <div class="alert alert-primary alert-success fade show" role="alert"><button class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><?php
                                    $message= Session::get('success');
                                    if($message){
                                        echo $message;
                                        Session::put('success',null);
                                        }
                                    ?></div>
                                    @endif
                    
                                    @if (!empty(Session::get('failed')))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert"><button class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button><?php
                                    $message_failed= Session::get('failed');
                                    if($message_failed){
                                        echo $message_failed;
                                        Session::put('failed',null);
                                        }
                                    ?></div>
                                    @endif
                            </div>
                            
                            <div class="card-content">
                                <div class="card-body">
                                    {!! Form::open(['url' =>'updatedefaultlogobyadmin','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="form-body">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <label>Default Logo <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="file" class="form-control " name="logo" id="myBtn" >
                                                    <?php if ($default_setting): ?>
                                                        <span id="image_siam" class="image_siam">
                                                            <img src="{{ URL::to('public/images/defult/'.$default_setting->logo) }}" class="img-responsive">
                                                        </span>
                                                    <?php endif ?>
                                                </div> 

                                                <div class="col-md-3">
                                                    <label>Default Banner <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="file" class="form-control " name="default_banner" id="myBtn">
                                                    <?php if ($default_setting): ?>
                                                        <span id="image_siam" class="image_siam">
                                                            <img src="{{ URL::to('public/images/defult/'.$default_setting->banner_image) }}" class="img-responsive" style="width: 80%;height:13rem;">
                                                        </span>
                                                    <?php endif ?>
                                                </div>  
                                                
                                                <div class="col-md-3">
                                                    <label>Login Background<span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="file" class="form-control " name="login_background" id="myBtn">   
                                                    <?php if ($default_setting): ?>
                                                        <span id="image_siam" class="image_siam">
                                                            <img src="{{ URL::to('public/images/defult/'.$default_setting->login_background) }}" class="img-responsive" style="width: 80%;height:13rem;">
                                                        </span>
                                                    <?php endif ?>
                                                </div> 


                                                <div class="col-sm-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users list ends -->
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
  <script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;

        case 'success':
        toastr.info("{{ Session::get('message') }}");
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

@endsection