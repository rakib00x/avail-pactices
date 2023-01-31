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
                                              <h4 class="card-title">Package Banner</h4>
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

                                                {!! Form::open(['url' =>'updatepackagebanner','method' => 'post','role' => 'form', 'class' => 'form form-vertical', 'files'=>'true']) !!}
                                                <div class="form-body">
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <label>Package Banner</label>
                                                        </div>
                                                        <div class="col-md-8 form-group">
                                                            <input type="file" class="form-control" name="image" onchange="readURL(this);" required>
                                                            <?php if ($banner_info): ?>
                                                                <img id="blah" src="{{ URL::to('/'.$banner_info->image) }}" width="150" height="150" />
                                                            <?php else: ?>
                                                                <img id="blah" width="150" height="150" />
                                                            <?php endif ?>
                                                            
                                                        </div>

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
