@extends('admin.masterAdmin')
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


</style>
@endpush
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title">Thana List</h4>
                        <div class="card">
                            <div class="card-header">

                                <a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#addModal" >+ Add Thana</a>

                            </div>

                            <div class="card-content" id="body_data">
                             
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel1">Add Thana</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'insertThana','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Select District<span style="color:red;">*</span></label>
                                    </div>

                                    <div class="col-md-8 form-group">
                                        <select class="form-control" name="district_id">
                                            <option >Select Category</option>
                                            <?php foreach ($dataDistrict as $value) { ?>
                                                <option value="<?php echo $value->id ; ?>" ><?php echo $value->name ; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label> Name <span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control" name="name" required="">
                                    </div>
                                    <br>
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

            <div class="modal fade" id="editModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel1">Add Thana</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'updateThana','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body" id="thanaForm">
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<!-- Alert Assets -->
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/fetchThana') }}",
            'type':'post',
            'dataType':'text',

            success:function(data){

                $("#body_data").empty();
                $("#body_data").html(data);

            }
        });

    });

    $(function(){
        $('body').on('click', '.changeThanaStatus', function (e) {
            e.preventDefault();

            var id = $(this).attr('getThana');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/empolyeeThanaStatus') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data)
                {
                    $.ajax({
                        'url':"{{ url('/fetchThana') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);

                        }
                    });

                    if(data == "success"){
                        toastr.success('Thanks !! The District status has activated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Thanks !! The District status has deactivated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                }
            });

        })
    });


    $('body').on('submit', '#insertThana', function (e) {
    e.preventDefault();
    var district_id = $('[name="district_id"]').val() ;
    var name = $('[name="name"]').val() ;

    if (district_id == "") {
        toastr.info('Oh shit!! Please Select District Name', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    if (name == "") {
        toastr.info('Oh shit!! Please Input Name', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':"{{ url('/insertThana') }}",
        'type':'post',
        'dataType':'text',
        data: {name: name,district_id: district_id},
        success:function(data){
            if (data == "success") {
                $.ajax({
                    'url':"{{ url('/fetchThana') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#body_data").empty();
                        $("#body_data").html(data);
                    }
                });

                $("#addModal").modal('hide');
                toastr.success('Thanks !! District Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                return false;
            }else if(data == "failed"){
                toastr.error('Sorry !! District Not Added', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else if(data == "duplicate_found"){
                toastr.error('Sorry !! District Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
        }
    });

});



    $('body').on('submit', '#updateThana', function (e) {
        e.preventDefault();

        var name	= $(".name").val() ;
        var district_id	= $(".district_id").val() ;
        // var district_id  = $("[name=district_id]").val() ;
        var id 	   = $("[name=id]").val() ;
        
        
        if (name == "") {
            toastr.info('Oh shit!! Please Input  Name', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
        if (district_id == "") {
            toastr.info('Oh shit!! Please Select  District', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updateThana') }}",
            'type':'post',
            'dataType':'text',
            data: {name:name,id:id,district_id:district_id},
            success:function(data){
                $.ajax({
                    'url':"{{ url('/fetchThana') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#body_data").empty();
                        $("#body_data").html(data);

                    }
                });

                $("#editModal").modal('hide') ;
                if (data == "success") {
                    toastr.success('Thanks !! Thana Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !! Thana Not Updated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "duplicate_found"){
                    toastr.error('Sorry !! This Thana  Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });

    });

    function edito(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/editThana') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){

                $("#thanaForm").empty().html(data) ;

            }
        });
    }
    
    function deletevideo(event, id) {
        event.preventDefault() ;

        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/deleteThana') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){

                    if (data == "success") {
                        $.ajax({
                            'url':"{{ url('/fetchThana') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#body_data").empty();
                                $("#body_data").html(data);

                            }
                        });

                        toastr.success('Thanks !! You have Delete the  Video', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Sorry !! Video Not Delete', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }

                }
            });
        } else {
            toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
    }
</script>

@endsection
