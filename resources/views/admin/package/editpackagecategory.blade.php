@extends('admin.masterAdmin')
@section('content')

<div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">

                <section id="basic-datatable">
                    <div class="row">


                        <div class="col-6">

                            <h4 class="card-title">Package</h4>

                            <div class="card">

                                <div class="card-content">

                                    <section id="basic-vertical-layouts">
                                      <div class="row match-height">
                                        <div class="col-md-12 col-12">
                                          <div class="card" style="">
                                            <div class="card-header">
                                              <h4 class="card-title">Update Package Category</h4>
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

                                                {!! Form::open(['url' =>'updatepackagecategory','method' => 'post','role' => 'form', 'class' => 'form form-vertical', 'files'=>'true']) !!}
                                                <div class="form-body">
                                                  <div class="row">
                                                    <div class="col-12">
                                                      <div class="form-group">
                                                        <label for="first-name-vertical">Package name</label>
                                                        <input type="text" class="form-control" name="package_name" value="{{ $value->category_name }}" required>
                                                      </div>
                                                    </div>
                                                    <div class="col-12">
                                                      <fieldset class="form-group">
                                                        <label for="first-name-vertical">Duration Type</label>
                                                        <select class="form-control" name="duration_type" required>
                                                          <option value="">Select an option</option>
                                                          <option value="1" <?php if($value->duration_type == 1){echo "selected"; }else{echo ""; } ?>>Monthly</option>
                                                          <option value="2" <?php if($value->duration_type == 2){echo "selected"; }else{echo ""; } ?>>Yearly</option>
                                                        </select>
                                                      </fieldset>
                                                    </div>
                                                    <input type="hidden" name="primary_id" value="<?php echo $value->id; ?>">
                                                    <div class="col-12 d-flex justify-content-end">
                                                      <button type="reset" class="btn btn-light-secondary">Reset</button>
                                                      <button type="submit" class="btn btn-primary mr-1">Submit</button>
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
