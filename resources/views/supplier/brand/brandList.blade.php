@extends('supplier.masterSupplier')
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
                        <h4 class="card-title"> Brand List</h4>
                        <div class="card">
                            <div class="card-header">  
                                <a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#addModal" >+ Add Brand</a>

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
                            <h3 class="modal-title" id="myModalLabel1">Add Brand</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'insertBrandInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Brand Name <span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control brand_name" name="brand_name" required="">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Brand Details </label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control discription" name="discription">
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
                            <h3 class="modal-title" id="myModalLabel1">Update Brand</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'updateBrandInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
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

    $('body').on('submit', '#insertBrandInfo', function (e) {
        e.preventDefault();

        var brand_name = $(".brand_name").val() ;
        var discription = $(".discription").val() ;

        if (brand_name == "") {
            toastr.info('Oh shit!! Please Input Brand Name', { positionClass: 'toast-bottom-full-width', });
            return false;
        } 

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/insertBrandInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {brand_name:brand_name,discription:discription},
            success:function(data){
                if (data == "success") {
                    $("#addModal").modal('hide');
                    $.ajax({
                        'url':"{{ url('/getAllBrand') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);

                        }
                    });
                    
                    toastr.success('Thanks !!  Brand Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                    return false;
                }else if(data == "duplicate_found"){
                    toastr.error('Sorry !!  Brand Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !!  Brand Not Added', { positionClass: 'toast-bottom-full-width', });
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
            'url':"{{ url('/getAllBrand') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                console.log(data);

                $("#body_data").empty();
                $("#body_data").html(data);

            }
        });

    });

    $(function(){
        $('body').on('click', '.changeBrandStatus', function (e) {
            e.preventDefault();

            var brand_id = $(this).attr('getBrandid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/changeBrandStatus') }}",
                'type':'post',
                'dataType':'text',
                data:{brand_id:brand_id},
                success:function(data)
                {
                    $.ajax({
                        'url':"{{ url('/getAllBrand') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);

                        }
                    });

                    if(data == "success"){
                        toastr.success('Thanks !! The Brand status has activated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Thanks !! The Brand status has deactivated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                }
            });

        })
    });



    $('body').on('submit', '#updateBrandInfo', function (e) {
        e.preventDefault();

        var brand_name = $("#brand_name").val();
        var discription = $("#discription").val();
        var primary_id 	= $("[name=primary_id]").val() ;

        if (brand_name == "") {
            toastr.info('Oh shit!! Please Input Brand Name', { positionClass: 'toast-bottom-full-width', });
            return false;
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updateBrandInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {brand_name:brand_name,discription:discription,primary_id:primary_id},
            success:function(data){


                $.ajax({
                    'url':"{{ url('/getAllBrand') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#body_data").empty();
                        $("#body_data").html(data);

                    }
                });

                $("#editModal").modal('hide') ;
                if (data == "success") {
                    toastr.success('Thanks !!  Brand Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !!  Brand Not Updated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "duplicate_found"){
                    toastr.error('Sorry !!  This Brand Name  Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });

    });

    function deleteBrand(id) {

        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/brandDelete') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){

                    if (data == "success") {
                        $.ajax({
                            'url':"{{ url('/getAllBrand') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#body_data").empty();
                                $("#body_data").html(data);

                            }
                        });

                        toastr.error('Thanks !! You have Delete the Brand', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Sorry !! Brand Not Delete', { positionClass: 'toast-bottom-full-width', });
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
            'url':"{{ url('/editBrand') }}",
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