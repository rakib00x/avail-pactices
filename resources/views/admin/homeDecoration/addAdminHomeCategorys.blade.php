@extends('admin.masterAdmin')
@section('title','Home Category Decoration List')
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
                                <h4 class="card-title">Add Home Category</h4>
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
                                    {!! Form::open(['url' =>'insertHomeCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="form-body">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <label>Select Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="category_id" name="category_id" required="">
                                                        <option value="0">Select Category</option>
                                                        <?php foreach ($result as $wvalue) { ?>
                                                            <option value="<?php echo $wvalue->id; ?>">{{ $wvalue->category_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div> 

                                                <div class="col-md-3">
                                                    <label>Category name<span style="color:red;">*</span>
                                                    </label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <input type="text" class="form-control" name="catgory_name" required="">
                                                </div> 

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
<script src="{{ URL::to('//code.jquery.com/ui/1.12.1/jquery-ui.js') }}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  } );
  </script>
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