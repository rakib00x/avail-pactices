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

                                {!! Form::open(['url' =>'updatesupplierbannerimage','method' => 'post','role' => 'form','class'=>'form-horizontal','files' => true]) !!}

                                    <div class="row">


                                        <div class="col-12">
                                            <p style="color: red;text-align: center;">
                                                <?php $default_banner = DB::table('tbl_default_setting')->first(); ?>
                                                <?php if ($banner_info): ?>
                                                    <img src="{{ URL::to('public/images/defult/'.$banner_info->header_image) }}" style="width: 100%; height: 220px;">
                                                <?php else: ?>
                                                    <img src="{{ URL::to('public/images/defult/'.$default_banner->banner_image) }}" style="width: 100%; height: 220px;">
                                                <?php endif ?>
                                            </p>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Banner Image</label>
                                                    <input type="file" class="form-control" name="header_image"  required >
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-12" style="display:none">
                                            <p style="color: red;text-align: center;">
                                                <?php if ($banner_info): ?>
                                                    <img src="{{ URL::to('public/images/'.$banner_info->background_image) }}" style="width: 100%; height: 220px;">
                                                <?php endif ?>
                                            </p>
                                            <div class="form-group">
                                                <div class="controls">
                                                    <label>Background Image</label>
                                                    <input type="file" class="form-control" name="background_image"  >
                                                </div>
                                            </div>
                                        </div>



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