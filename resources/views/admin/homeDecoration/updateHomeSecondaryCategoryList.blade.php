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
                                    {!! Form::open(['url' =>'updateHomeSecondaryCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="form-body">
                                            <div class="row">

                                                <div class="col-md-3">
                                                    <label>Select First Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="secondary_category_1" name="secondary_category_1">
                                                        <option value="0">Select Category</option>
                                                        <?php foreach ($result as $wvalue) { ?>
                                                            <option value="<?php echo $wvalue->id; ?>" <?php if ($top_value) {
                                                               if($wvalue->id == $top_value->secondary_category_1){echo "selected"; }else{echo "";}
                                                            } ?>>{{ $wvalue->secondary_category_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div> 


                                                <div class="col-md-3">
                                                    <label>Select Second Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="secondary_category_2" name="secondary_category_2">
                                                        <option value="0">Select Second Category</option>
                                                        <?php foreach ($result as $wvalue2) { ?>
                                                            <option value="<?php echo $wvalue2->id; ?>" <?php if ($top_value) {
                                                               if($wvalue2->id == $top_value->secondary_category_2){echo "selected"; }else{echo "";} 
                                                            } ?>>{{ $wvalue2->secondary_category_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div> 

                                                <div class="col-md-3">
                                                    <label>Select Third Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="secondary_category_3" name="secondary_category_3">
                                                        <option value="0">Select Category</option>
                                                        <?php foreach ($result as $wvalue3) { ?>
                                                            <option value="<?php echo $wvalue3->id; ?>" <?php if ($top_value) {
                                                                if($wvalue3->id == $top_value->secondary_category_3){echo "selected"; }else{echo "";}
                                                            } ?>>{{ $wvalue3->secondary_category_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div> 


                                                <div class="col-md-3">
                                                    <label>Select Four Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="secondary_category_4" name="secondary_category_4">
                                                        <option value="0">Select Category</option>
                                                        <?php foreach ($result as $wvalue4) { ?>
                                                            <option value="<?php echo $wvalue4->id; ?>" <?php if ($top_value) {
                                                                if($wvalue4->id == $top_value->secondary_category_4){echo "selected"; }else{echo "";}
                                                            } ?>>{{ $wvalue4->secondary_category_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div> 


                                                <div class="col-md-3">
                                                    <label>Select Five Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="secondary_category_5" name="secondary_category_5">
                                                        <option value="0">Select Category</option>
                                                        <?php foreach ($result as $wvalue5) { ?>
                                                            <option value="<?php echo $wvalue5->id; ?>" <?php if ($top_value) {
                                                                if($wvalue5->id == $top_value->secondary_category_5){echo "selected"; }else{echo "";}
                                                            } ?>>{{ $wvalue5->secondary_category_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div> 


                                                <div class="col-md-3">
                                                    <label>Select Six Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="secondary_category_6" name="secondary_category_6" >
                                                        <option value="0">Select Category</option>
                                                        <?php foreach ($result as $wvalue6) { ?>
                                                            <option value="<?php echo $wvalue6->id; ?>" <?php if ($top_value) {
                                                               if($wvalue6->id == $top_value->secondary_category_6){echo "selected"; }else{echo "";}
                                                            } ?>>{{ $wvalue6->secondary_category_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Select Seven Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="secondary_category_7" name="secondary_category_7" >
                                                        <option value="0">Select Category</option>
                                                        <?php foreach ($result as $wvalue7) { ?>
                                                            <option value="<?php echo $wvalue7->id; ?>" <?php if ($top_value) {
                                                                if($wvalue7->id == $top_value->secondary_category_7){echo "selected"; }else{echo "";}
                                                            } ?>>{{ $wvalue7->secondary_category_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div>

                                                <div class="col-md-3">
                                                    <label>Select Eight Category <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="secondary_category_8" name="secondary_category_8" >
                                                        <option value="0">Select Category</option>
                                                        <?php foreach ($result as $wvalue8) { ?>
                                                            <option value="<?php echo $wvalue8->id; ?>" <?php if ($top_value) {
                                                                if($wvalue8->id == $top_value->secondary_category_8){echo "selected"; }else{echo "";}
                                                            } ?>>{{ $wvalue8->secondary_category_name }}</option>
                                                        <?php } ?>

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