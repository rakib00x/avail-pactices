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
                        <h4 class="card-title"> Privacy Policy List</h4>
                        <div class="card">
                            <div class="card-header">
                                
                                <a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#addModal" >+ Add Privacy Policy</a>

                            </div>

                            <div class="card-content" id="body_data">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            <div class="modal fade" id="addModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel1">Add Privacy Policy </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'insertPrivacyPolicyInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Title <span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control meta_title" name="meta_title" required="">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Discription <span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <textarea type="text" class="form-control meta_discription summernote" name="meta_discription" required=""></textarea>
                                    </div>
                                    <br>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}

                            <!-- Nav Filled Ends -->
                        </div>

                    </div>
                </div>
            </div>


            <!-- update -->

            <!-- Modal -->
            <div class="modal fade" id="editModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel1">Update Privacy Policies</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'updatePrivacyPolicyInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body" id="sizeEditForm">

                            </div>
                            {!! Form::close() !!}

                            <!-- Nav Filled Ends -->
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
<script>

    $('body').on('submit', '#insertPrivacyPolicyInfo', function (e) {
        e.preventDefault();

        var meta_title          = $(".meta_title").val() ;
        var meta_discription    = $(".meta_discription").val() ;

        if (meta_title == "") {
            toastr.info('Oh shit!! Please Input A Title', { positionClass: 'toast-bottom-full-width', });
            return false;
        } 

        if (meta_discription == "") {
            toastr.info('Oh shit!! Please Input Details', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/insertPrivacyPolicyInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {meta_title:meta_title,meta_discription:meta_discription},
            success:function(data){
                console.log(data) ;
                if (data == "success") {

                    function explode(){
                        location.reload() ;
                    }
                    setInterval(explode,1000);
                    toastr.success('Thanks !!  Privacy Policy Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !!  Privacy Policy Not Added', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            }
        });
    });
</script>



<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getAllPrivacyPolicy') }}",
            'type':'post',
            'dataType':'text',

            success:function(data){
                console.log(data);
                $("#body_data").empty();
                $("#body_data").html(data);

            }
        });

    });


    $('body').on('submit', '#updatePrivacyPolicyInfo', function (e) {
        e.preventDefault();

        var meta_title 	   = $("#meta_title").val() ;
        var meta_discription     = $("#meta_discription").val() ;
        var primary_id 	        = $("[name=primary_id]").val() ;

         if (meta_title == "") {
            toastr.info('Oh shit!! Please Input A Title', { positionClass: 'toast-bottom-full-width', });
            return false;
        } 

        if (meta_discription == "") {
            toastr.info('Oh shit!! Please Input Details', { positionClass: 'toast-bottom-full-width', });
            return false;
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updatePrivacyPolicyInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {meta_title:meta_title,meta_discription:meta_discription,primary_id:primary_id},
            success:function(data){


                $.ajax({
                    'url':"{{ url('/getAllPrivacyPolicy') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#body_data").empty();
                        $("#body_data").html(data);

                    }
                });

                $("#editModal").modal('hide') ;
                if (data == "success") {
                    toastr.success('Thanks !!  Privacy Policy Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !!  PrivacyPolicy Not Updated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "duplicate_found"){
                    toastr.error('Sorry !!  This Privacy Policy Title Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });

    });

    function deletePrivacyPolicy(id) {

        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/privacyPolicyDelete') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){

                    if (data == "success") {
                        $.ajax({
                            'url':"{{ url('/getAllPrivacyPolicy') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#body_data").empty();
                                $("#body_data").html(data);

                            }
                        });

                        toastr.error('Thanks !! You have Delete the Privacy Policy', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Sorry !! Privacy Policy Not Delete', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }

                }
            });
        } else {
            toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
    }

    function edit(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/editPrivacyPolicy') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){

                $("#sizeEditForm").empty().html(data) ;

            }
        });
    }
</script>

@endsection