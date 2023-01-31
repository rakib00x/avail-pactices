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
                        <h4 class="card-title">Distict List</h4>
                        <div class="card">
                            <div class="card-header">

                                <a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#addModal" >+ Add Distict</a>

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
                            <h3 class="modal-title" id="myModalLabel1">Add District</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'insertDistrict','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body">
                                <div class="row">
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
                            <h3 class="modal-title" id="myModalLabel1">Update Distict</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'updateDistrict','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body" id="districtForm">
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
            'url':"{{ url('/fectchDistrict') }}",
            'type':'post',
            'dataType':'text',

            success:function(data){

                $("#body_data").empty();
                $("#body_data").html(data);

            }
        });

    });

    $(function(){
        $('body').on('click', '.changeDistrictStatus', function (e) {
            e.preventDefault();

            var id = $(this).attr('getDistrict');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/changeDistrictStatus') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data)
                {
                    $.ajax({
                        'url':"{{ url('/fectchDistrict') }}",
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


    $('body').on('submit', '#insertDistrict', function (e) {
    e.preventDefault();

    var name = $('[name="name"]').val() ;

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
        'url':"{{ url('/insertDistrict') }}",
        'type':'post',
        'dataType':'text',
        data: {name: name},
        success:function(data){
            if (data == "success") {
                $.ajax({
                    'url':"{{ url('/fectchDistrict') }}",
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



    $('body').on('submit', '#updateDistrict', function (e) {
        e.preventDefault();

        var name	   = $(".name").val() ;
        var id 	   = $("[name=id]").val() ;
        
        
        if (name == "") {
            toastr.info('Oh shit!! Please Input  Name', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updateDistrict') }}",
            'type':'post',
            'dataType':'text',
            data: {name:name,id:id},
            success:function(data){

                $.ajax({
                    'url':"{{ url('/fectchDistrict') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#body_data").empty();
                        $("#body_data").html(data);

                    }
                });

                $("#editModal").modal('hide') ;
                if (data == "success") {
                    toastr.success('Thanks !!  Help Video Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !!  Help Video Not Updated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "duplicate_found"){
                    toastr.error('Sorry !!  This Video  Already Exist', { positionClass: 'toast-bottom-full-width', });
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
            'url':"{{ url('/editDistrict') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){

                $("#districtForm").empty().html(data) ;

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
                'url':"{{ url('/deleteDistrict') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){

                    if (data == "success") {
                        $.ajax({
                            'url':"{{ url('/fectchDistrict') }}",
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
