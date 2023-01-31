@extends('admin.masterAdmin')
@section('title','Edit Home Category')
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
                                <h4 class="card-title">Edit Home Category</h4>
                                @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                            
                            <div class="card-content">
                                <div class="card-body">
                                    {!! Form::open(['url' =>'updateHomeCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="form-body">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <label>Select Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="category_id" name="category_id" required="">
                                                        <option value="0">Select Category</option>
                                                        <?php foreach ($result as $wvalue) { ?>
                                                            <option value="<?php echo $wvalue->id; ?>" <?php if($wvalue->id == $value->category_id){ echo "selected"; }else{echo ""; } ?>>{{ $wvalue->category_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div> 

                                                <div class="col-md-3">
                                                    <label>Category name<span style="color:red;">*</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="text" class="form-control" name="catgory_name" value="<?php echo $value->h_category_name; ?>" required="">
                                                </div> 


                                                <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">

                                                <div class="col-sm-12 d-flex justify-content-end">
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