@extends('admin.masterAdmin')
@section('title','Home Country Decoration List')
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
                                <h4 class="card-title">Assign Home Top Category</h4>
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
                                    {!! Form::open(['url' =>'updateHomeCountryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="form-body">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <label>Select First Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="select2 form-control" name="home_country_id[]" multiple="multiple">
                                                        <?php foreach ($all_country as $value): ?>
                                                            <option value="{{ $value->id }}" <?php 
                                                                if($home_country){
                                                                    $category_explode = explode(",", $home_country->home_country_id) ;
                                                                    if (in_array($value->id, $category_explode)) {
                                                                        echo "selected" ;
                                                                    }else{
                                                                        echo "" ;
                                                                    }
                                                                }
                                                             ?>>{{ $value->countryName }}
                                                         </option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </div> 


                                                <div class="col-sm-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Update</button>
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