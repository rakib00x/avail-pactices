@extends('supplier.masterSupplier')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title">Header Menu Color Change</h4>
                        <div class="card">
                            <div class="card-header">

                                {!! Form::open(['url' =>'udpateSupplierHeaderSettings','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}

                                    <div class="row">
                                        <div class="col-12">
                                            <p style="color: red;text-align: center;">{{ $errors->first('background_color') }}</p>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Background Color</label>
                                                    <input type="color" class="form-control" name="background_color" value="<?php echo $color_info->background_color ; ?>" required >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p style="color: red;text-align: center;">{{ $errors->first('font_color') }}</p>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Font Color</label>
                                                    <input type="color" name="font_color" class="form-control" value="<?php echo $color_info->font_color ; ?>" required >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <p style="color: red;text-align: center;">{{$errors->first('hover_color')}}</p>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Hover Color</label>
                                                    <input type="color" name="hover_color" class="form-control" value="<?php echo $color_info->hover_color ; ?>" required="">
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="primary_id" value="<?php echo $color_info->id ; ?>">
                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                            <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                            changes</button>
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

@endsection

@section('js')
<!-- Alert Assets -->
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}", '', { positionClass: 'toast-top-center', });
        break;

        case 'warning':
        toastr.warning("{{ Session::get('message') }}", '', { positionClass: 'toast-top-center', });
        break;

        case 'success':
        toastr.success("{{ Session::get('message') }}", '', { positionClass: 'toast-top-center', });
        break;

        case 'failed':
        toastr.error("{{ Session::get('message') }}", '', { positionClass: 'toast-top-center', });
        break;
    }
    @endif
</script>
@endsection