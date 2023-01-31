@extends('admin.masterAdmin')
@section('title')
Supplier Accounts Settings
@endsection
@section('content')
@push('styles')
<style>
    @media screen and (min-width: 992px){
        .modal-dialog {
            max-width: 1000px!important;
        }
    }
    .siam_active .card{
        border: 1px solid red ;
    }
    .siam_class{
        cursor: pointer;
    }

    .selected_icon{
        position: absolute;
        padding: 38%;
        font-size: 30px;
        color: #4ebd37;
    }
</style>
@endpush
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Category Upper Side Category</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {!! Form::open(['id' =>'insertuppercategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="row">

                                            <div class="col-md-12 form-group">
                                                <label>Select Secondary Category <span style="color:red;">*</span></label>
                                                <select name="category_id_siam" class="form-control" required="">
                                                    <option value="">Select Category</option>
                                                    @foreach($result as $values)
                                                        <option value="{{ $values->id }}">{{ $values->secondary_category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <br>
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}

                                </div>
                                
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Upper Category List</h4>
                            </div>
                            <div class="card-content">
                                {!! Form::open(['url' =>'updateuppercategorylistinfo','method' => 'post','role' => 'form','class'=>'form-horizontal']) !!}
                                <ul class="list-group list-group-flush" id="sortable">
                                    <input type="hidden" name="main_category_id" value="<?php echo $values->primary_category_id; ?>">
                                    <?php foreach ($upper_side_list as $uvalue) { ?>
                                        <li class="list-group-item ui-state-default m-1 row">
                                            <div class="col-md-8">
                                                <input type="hidden" name="primary_category_id[]" value="<?php echo $uvalue->id; ?>"><?php echo $uvalue->secondary_category_name; ?> 
                                            </div>
                                            <div class="col-md-4">
                                                <div class="custom-control custom-switch custom-control-inline mb-1">
                                                    <input type="checkbox" class="custom-control-input changeHomeCatgeoryStatus" <?php if($uvalue->sidebar_active == 1){ echo 'checked'; }else{ echo ''; } ?> getCategoryId="{{$uvalue->id}}" id="customSwitch{{$uvalue->id}}">
                                                    <label class="custom-control-label mr-1" for="customSwitch{{$uvalue->id}}"></label>
                                                </div>
                                                <a onclick="deleteHomeSecondayCategoryUpper('{{$uvalue->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
                                                    <i style="font-size:25px;" class="bx bx-trash"></i>
                                                </a>
                                            </div>
                                        </li>
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

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Category Bottom Side Category</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {!! Form::open(['id' =>'insertBottomcategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="row">

                                            <div class="col-md-12 form-group">
                                                <label>Select Secondary Category <span style="color:red;">*</span></label>
                                                <select name="category_id_s" class="form-control" required="">
                                                    <option value="">Select Category</option>
                                                    @foreach($result as $value)
                                                        <option value="{{ $value->id }}">{{ $value->secondary_category_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <br>
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}

                                </div>
                                
                            </div>

                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Bottom Category List</h4>
                            </div>
                            <div class="card-content">
                                {!! Form::open(['url' =>'updatebottomcategorylistinfo','method' => 'post','role' => 'form','class'=>'form-horizontal']) !!}
                                <ul class="list-group list-group-flush" id="sortable2">
                                    <input type="hidden" name="main_category_id" value="<?php echo $values->primary_category_id; ?>">
                                    <?php foreach ($bottom_side_list as $bvalue) { ?>
                                        <li class="list-group-item ui-state-default m-1 row">
                                            <div class="col-md-8">
                                                <input type="hidden" name="primary_category_id[]" value="<?php echo $bvalue->id; ?>"><?php echo $bvalue->secondary_category_name; ?> 
                                            </div>
                                            <div class="col-md-4">
                                                <div class="custom-control custom-switch custom-control-inline mb-1">
                                                    <input type="checkbox" class="custom-control-input changesidebarsecondarylowercategorystatus" <?php if($bvalue->sidebar_active == 1){ echo 'checked'; }else{ echo ''; } ?> getsecondaryid="{{$bvalue->id}}" id="customSwitch{{$bvalue->id}}">
                                                    <label class="custom-control-label mr-1" for="customSwitch{{$bvalue->id}}"></label>
                                                </div>
                                                <a onclick="deleteHomeSecondayCategoryUpper('{{$bvalue->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
                                                    <i style="font-size:25px;" class="bx bx-trash"></i>
                                                </a>
                                            </div>
                                        </li>
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
            </section>

        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>

<script src="{{ URL::to('//code.jquery.com/ui/1.12.1/jquery-ui.js') }}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script>
  $( function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();    

    $( "#sortable2" ).sortable();
    $( "#sortable2" ).disableSelection();
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

<script>

    $('body').on('click', '.changeHomeCatgeoryStatus', function (e) {
        e.preventDefault();

        var category_id = $(this).attr('getCategoryId');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changeSidebarSecondaryCategoryStatus') }}",
            'type':'post',
            'dataType':'text',
            data:{category_id:category_id},
            success:function(data)
            {
                if(data == "success"){
                    toastr.success('Thanks !! The Category status has activated', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 500);
                    return false;
                }else if(data == "failed"){
                    toastr.warning('Thanks !! The Category status has In Active', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 500);
                    return false;
                }else{
                    toastr.warning('Thanks !! Category Limit Already Exit.', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }


            }
        });
    });

    $("#insertuppercategoryInfo").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('insertuppercategoryInfo');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/insertuppercategoryInfo') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data == "success") {
                    toastr.success('Upper Category Add Successfully', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }else{
                    toastr.success('Category Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }
            }
        })
    });

    function deleteHomeSecondayCategoryUpper(category_id) {
        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/deleteHomeSecondayCategoryUpper') }}",
                'type':'post',
                'dataType':'text',
                data:{category_id:category_id},
                success:function(data){
                    toastr.error('Thanks !! You have Delete the Category', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 3000);
                    return false;
                    
                }
            });
            } else {
                toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
    }


</script>

<script>

    $('body').on('click', '.changesidebarsecondarylowercategorystatus', function (e) {
        e.preventDefault();

        var category_id = $(this).attr('getsecondaryid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changesidebarsecondarylowercategorystatus') }}",
            'type':'post',
            'dataType':'text',
            data:{category_id:category_id},
            success:function(data)
            {
                if(data == "success"){
                    toastr.success('Thanks !! The Category status has activated', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 500);
                    return false;
                }else if(data == "failed"){
                    toastr.warning('Thanks !! The Category status has In Active', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 500);
                    return false;
                }else{
                    toastr.warning('Thanks !! Category Limit Already Exit.', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }


            }
        });
    });

    $("#insertBottomcategoryInfo").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('insertBottomcategoryInfo');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/insertBottomcategoryInfo') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data == "success") {
                    toastr.success('Bottom Category Add Successfully', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }else{
                    toastr.success('Category Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }
            }
        })
    });

    function deleteHomeSecondayCategoryUpper(category_id) {
        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/deleteHomeSecondayCategoryUpper') }}",
                'type':'post',
                'dataType':'text',
                data:{category_id:category_id},
                success:function(data){
                    toastr.error('Thanks !! You have Delete the Category', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 3000);
                    return false;
                    
                }
            });
            } else {
                toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
    }


</script>
@endsection


