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
                                <h4 class="card-title">Assign Home Sidebar Product</h4>
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
                                    {!! Form::open(['url' =>'updateHomeThreeProductInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label>Select First Product <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="product_id" name="product_id">
                                                        <option value="0">Select Product</option>
                                                        <?php foreach ($result as $wvalue) { ?>
                                                            <option value="<?php echo $wvalue->id; ?>" <?php if ($all_three_product) {
                                                                if($wvalue->id == $all_three_product->product_id){echo "selected"; }else{echo "";}
                                                            } ?>>{{ $wvalue->product_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div> 


                                                <div class="col-md-3">
                                                    <label>Select Second Product <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="second_product_id" name="second_product_id">
                                                        <option value="0">Select Second Product</option>
                                                        <?php foreach ($result as $wvalue2) { ?>
                                                            <option value="<?php echo $wvalue2->id; ?>" <?php if ($all_three_product) {
                                                               if($wvalue2->id == $all_three_product->second_product_id){echo "selected"; }else{echo "";} 
                                                            } ?>>{{ $wvalue2->product_name }}</option>
                                                        <?php } ?>

                                                    </select>
                                                </div> 

                                                <div class="col-md-3">
                                                    <label>Select Third Product <span style="color:red;">*</span></label>
                                                </div>
                                                <div class="col-md-9 form-group">
                                                    <select class="form-control select2" id="third_product_id" name="third_product_id">
                                                        <option value="0">Select Product</option>
                                                        <?php foreach ($result as $wvalue3) { ?>
                                                            <option value="<?php echo $wvalue3->id; ?>" <?php if ($all_three_product) {
                                                                if($wvalue3->id == $all_three_product->third_product_id){echo "selected"; }else{echo "";}
                                                            } ?>>{{ $wvalue3->product_name }}</option>
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