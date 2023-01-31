@extends('supplier.masterSupplier')
@section('title','Suppliers Social Media')
@section('content')
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body"><br>
            <div class="row">
                <div class="col-md-2 col-12"></div>
                <div class="col-md-8 col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Supplier Profile Start with social media progress</h4>
                        </div><hr>
                        <div class="card-content">
                            <div class="card-body">

                                <form enctype="multipart/form-data" action="{{url('/supplierSoicalMediaUpdate')}}" method="post" >
                                    @csrf
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>FaceBook </label>
                                            </div>
                                            <div class="col-md-9 form-group ">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="fname-icon" class="form-control" name="facebook" value="<?php if($social_count > 0){echo $social->facebook; } ?>" placeholder="https:// FaceBook id">
                                                    <div class="form-control-position">
                                                        <i class="bx bxl-facebook"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Google </label>
                                            </div>
                                            <div class="col-md-9 form-group ">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="fname-icon" class="form-control" name="google" value="<?php if($social_count > 0){echo $social->google; } ?>" placeholder="https:// Google id">
                                                    <div class="form-control-position">
                                                        <i class="bx bxl-google"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Twitter </label>
                                            </div>
                                            <div class="col-md-9 form-group ">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="fname-icon" class="form-control" name="twitter" value="<?php if($social_count > 0){echo $social->twitter; } ?>" placeholder="https:// Twitter id">
                                                    <div class="form-control-position">
                                                        <i class="bx bxl-twitter"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>LinkeIn </label>
                                            </div>
                                            <div class="col-md-9 form-group ">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="fname-icon" class="form-control" name="linkedin" value="<?php if($social_count > 0){echo $social->linkedin; } ?>" placeholder="https:// LinkeIn id">
                                                    <div class="form-control-position">
                                                        <i class="bx bxl-linkedin"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Instagram </label>
                                            </div>
                                            <div class="col-md-9 form-group ">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="fname-icon" class="form-control" name="instagram" value="<?php if($social_count > 0){echo $social->instagram; } ?>" placeholder="https:// Instagram id">
                                                    <div class="form-control-position">
                                                        <i class="bx bxl-instagram"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>Pinterest </label>
                                            </div>
                                            <div class="col-md-9 form-group ">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="fname-icon" class="form-control" name="pinterest"  value="<?php if($social_count > 0){echo $social->pinterest; } ?>" placeholder="https:// Pinterest id">
                                                    <div class="form-control-position">
                                                        <i class="bx bxl-pinterest"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <label>YouTube </label>
                                            </div>
                                            <div class="col-md-9 form-group ">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="fname-icon" class="form-control" name="youtube" value="<?php if($social_count > 0){echo $social->youtube; } ?>" placeholder="https:// YouTube Channel id">
                                                    <div class="form-control-position">
                                                        <i class="bx bxl-youtube"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <input type="hidden" name="primary_id" value="<?php if($social_count > 0){echo $social->id; } ?>">

                                            <div class="col-12 d-flex justify-content-end ">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-12"></div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->
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
        toastr.success("{{ Session::get('message') }}");
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