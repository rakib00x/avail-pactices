@extends('admin.masterAdmin')
@section('content')

<div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">

                <section id="basic-datatable">
                    <div class="row">


                        <div class="col-8">

                            <h4 class="card-title">Package</h4>

                            <div class="card">

                                <div class="card-content">

                                    <section id="basic-vertical-layouts">
                                      <div class="row match-height">
                                        <div class="col-md-12 col-12">
                                          <div class="card" style="">
                                            <div class="card-header">
                                              <h4 class="card-title">Edit Package</h4>
                                            </div>
                                            <div class="card-body">
                                                
                                                <?php if(Session::get('success') != null) { ?>
                                                    <div class="alert alert-info alert-dismissible" role="alert">
                                                    <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                    <strong><?php echo Session::get('success') ;  ?></strong>
                                                    <?php Session::put('success',null) ;  ?>
                                                </div>
                                                <?php } ?>

                                                <?php
                                                    if(Session::get('failed') != null) { ?>
                                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                    <strong><?php echo Session::get('failed') ; ?></strong>
                                                    <?php echo Session::put('failed',null) ; ?>
                                                </div>
                                                <?php } ?>

                                                @if (count($errors) > 0)
                                                    @foreach ($errors->all() as $error)      
                                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                                        <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                                        <strong>{{ $error }}</strong>
                                                    </div>
                                                    @endforeach
                                                @endif

                                                {!! Form::open(['url' =>'updateadminpackage','method' => 'post','role' => 'form', 'class' => 'form form-vertical', 'files'=>'true']) !!}
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Package Category</label>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <fieldset class="form-group">
                                                                <select class="form-control" name="category_id" required>
                                                                  <option value="">Select an option</option>
                                                                  <?php foreach ($all_category as $value): ?>
                                                                      <option value="{{ $value->id }}" <?php if($value->id == $package_info->category_id){echo "selected"; }else{echo ""; } ?>>{{ $value->category_name }}</option>
                                                                  <?php endforeach ?>
                                                                </select>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Package Name</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" class="form-control" name="package_name" value="{{ $package_info->package_name }}" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Duration</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="text" id="password" class="form-control" name="package_duration" value="{{ $package_info->package_duration }}" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Amount</label>
                                                        </div>

                                                        <div class="col-md-8 form-group">
                                                            <input type="number" class="form-control" name="package_price" value="{{ $package_info->package_price }}" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Discount %</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" class="form-control" name="discount_percentage" value="{{ $package_info->discount_percentage }}" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Product Upload</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number"  class="form-control" name="product_limit" value="{{ $package_info->product_limit }}" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Banner Update</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <fieldset class="form-group">
                                                                <select class="form-control" name="banner_update_status" required>
                                                                  <option value="">Select an option</option>
                                                                  <option value="1" <?php if($package_info->banner_update_status == 1){echo "selected"; }else{echo ""; } ?>>Yes</option>
                                                                  <option value="2" <?php if($package_info->banner_update_status == 2){echo "selected"; }else{echo ""; } ?>>No</option>
                                                                </select>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Logo Update</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <fieldset class="form-group">
                                                                <select class="form-control" name="logo_update_status" required>
                                                                  <option value="">Select an option</option>
                                                                  <option value="1" <?php if($package_info->logo_update_status == 1){echo "selected"; }else{echo ""; } ?>>Yes</option>
                                                                  <option value="2" <?php if($package_info->logo_update_status == 2){echo "selected"; }else{echo ""; } ?>>No</option>
                                                                </select>
                                                            </fieldset>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Primary Category Limit</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                             <input type="number" id="contact-info" class="form-control" name="primary_category_limit" value="{{ $package_info->primary_category_limit }}" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Secondary Category Limit</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                             <input type="number" id="contact-info" class="form-control" name="seconday_category_limit" value="{{ $package_info->seconday_category_limit }}" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Slider Update</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="number" class="form-control" name="slider_update_status" value="{{ $package_info->slider_update_status }}" required>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <label>Social Media Update</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <fieldset class="form-group">
                                                                <select class="form-control" name="social_media_status" required>
                                                                  <option value="">Select an option</option>
                                                                  <option value="1" <?php if($package_info->social_media_status == 1){echo "selected"; }else{echo ""; } ?>>Yes</option>
                                                                  <option value="2" <?php if($package_info->social_media_status == 2){echo "selected"; }else{echo ""; } ?>>No</option>
                                                                </select>
                                                            </fieldset>
                                                        </div>
                                                        
                                                        <div class="col-md-3">
                                                            <label>Border Color</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="color" class="form-control" name="border_color" value="<?php echo $package_info->border_color; ?>" required>
                                                        </div>
                                                        
                                                        <input type="hidden" name="primary_id" value="{{ $package_info->id }}">

                                                        <div class="col-sm-11 d-flex justify-content-center">
                                                            <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                              {!! Form::close() !!}
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </section>

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
<script type="text/javascript">
     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(150)
                    .height(200);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
