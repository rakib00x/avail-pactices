@extends('admin.masterAdmin')
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
    <div class="content-wrapper">
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-9">
                        <h4 class="card-title">Social Media Links</h4>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body ">
                                    {!! Form::open(['id' =>'socialMediaUpdate','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label>FaceBook </label>
                                            </div>
                                            <div class="col-md-9 form-group ">
                                                <div class="position-relative has-icon-left">
                                                    <input type="text" id="facebook" class="form-control" name="facebook" value="<?php if($social){echo $social->facebook; } ?>" placeholder="Enter Your Facebook URL Link">
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
                                                    <input type="text" id="google" class="form-control" name="google" value="<?php if($social){echo $social->google; } ?>" placeholder="Enter Your Google URL Link">
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
                                                    <input type="text" id="twitter" class="form-control" name="twitter" value="<?php if($social){echo $social->twitter; } ?>" placeholder="Enter Your Twitter URL Link">
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
                                                    <input type="text" id="linkedin" class="form-control" name="linkedin" value="<?php if($social){echo $social->linkedin; } ?>" placeholder="Enter Your LinkeIn URL Link">
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
                                                    <input type="text" id="instagram" class="form-control" name="instagram" value="<?php if($social){echo $social->instagram; } ?>" placeholder="Enter Your Instagram URL Link">
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
                                                    <input type="text" id="pinterest" class="form-control" name="pinterest"  value="<?php if($social){echo $social->pinterest; } ?>" placeholder="Enter Your Pinterest URL Link">
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
                                                    <input type="text" id="youtube" class="form-control" name="youtube" value="<?php if($social){echo $social->youtube; } ?>" placeholder="Enter Your YouTube URL Link">
                                                    <div class="form-control-position">
                                                        <i class="bx bxl-youtube"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="primary_id" value="<?php if($social){echo $social->id; } ?>">

                                            <div class="col-12 d-flex justify-content-end ">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">SAVE</button>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}
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
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>

<script type="text/javascript">
//update
$('body').on('submit', '#socialMediaUpdate', function (e) {
    e.preventDefault();

    var facebook     = $('#facebook').val() ;
    var twitter      = $('#twitter').val() ;
    var instagram    = $('#instagram').val() ;
    var youtube      = $('#youtube').val() ;
    var linkedin     = $('#linkedin').val() ;
    var pinterest    = $('#pinterest').val() ;
    var google       = $('#google').val() ;
    var primary_id   = $("[name=primary_id]").val();


    if (facebook == "") {
        toastr.info('Oh shit!! Please Enter a url link', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':"{{ url('/socialMediaUpdate') }}",
        'type':'post',
        'dataType':'text',
        data: {facebook: facebook, twitter:twitter, instagram:instagram, youtube:youtube,linkedin:linkedin,linkedin:linkedin,pinterest:pinterest,google:google,primary_id:primary_id},

        success:function(data){
            console.log(data);
            return false ;
            if (data == "success") {
                toastr.success('Thanks !! Records Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                return false;
            }else if(data == "failed"){
                toastr.error('Sorry !! Records Not Updated', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else{
                toastr.info('Oh shit!! Meta Tags and Image Can not be empty', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

        }
    });

});

</script>

@endsection