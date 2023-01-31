@extends('admin.masterAdmin')
@section('title','Home Category Decoration')
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
                <div class="users-list-filter px-1">
                    <div class="row border rounded py-2 mb-2">
                        <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                            <h5>Home Page Decoration</h5>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8 form-horizontal" id="form">
                                    {!! Form::open(['url' =>'updateHomeCategoryDecoration','method' => 'post','role' => 'form','class'=>'form-horizontal']) !!}

                                    <ul class="list-group list-group-flush" id="sortable">
                                        <?php foreach ($result as $value) { ?>
                                            <li class="list-group-item ui-state-default m-1"><input type="hidden" name="primary_category_id[]" value="<?php echo $value->id; ?>"><?php echo $value->h_category_name; ?></li>
                                        <?php } ?>
                                    </ul>

                                    <div class="form-group">
                                        <label class="col-md-4 control-label"></label>
                                        <div class="col-md-8">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}

                                </div>
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