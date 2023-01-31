@extends('supplier.masterSupplier')
@section('title')
Supplier Category
@endsection
@section('content')
@push('styles')
    <style>
        @media screen and (min-width: 992px){
            .modal-dialog {
                max-width: 700px!important;
            }
        }
    </style>
@endpush
<div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-12 mb-2 mt-1">
                    <div class="row breadcrumbs-top">
                        <div class="col-12">
                            <h5 class="content-header-title float-left pr-1 mb-0">Category</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{URL::to('supplierDashboard')}}"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active"> Category List
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- account setting page start -->
                <section id="page-account-settings">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <!-- left menu section -->
                                <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                                    <ul class="nav nav-pills flex-column">
                                        <li class="nav-item">
                                            <a style="background-color: #272e48" class="nav-link d-flex align-items-center active main-category-section" id="category-pill-main" data-toggle="pill" href="#supplier-main-category" aria-expanded="false">
                                                <i class="bx bx-info-circle"></i>
                                                <span>Main Category</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a style="background-color: #272e48" class="nav-link d-flex align-items-center secondary-category-section" id="category-pill-secondary" data-toggle="pill" href="#supplier-secondary-category" aria-expanded="false">
                                                <i class="bx bx-info-circle"></i>
                                                <span>Secondary Category</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- right content section -->
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="tab-content">
                                                    <div role="tabpanel" class="tab-pane active body_data" id="supplier-main-category" aria-labelledby="category-pill-main" aria-expanded="true">

                                        
                                                    </div>
                                                    <div class="tab-pane fade secondary_data" id="supplier-secondary-category" role="tabpanel" aria-labelledby="category-pill-secondary" aria-expanded="false">
                                                        
                                                    </div>
                                                    <div class="tab-pane fade tertiary_data" id="supplier-tertiary-category" role="tabpanel" aria-labelledby="category-pill-tertiary" aria-expanded="false">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- account setting page ends -->

                <!-- Modal -->
                <div class="modal fade" id="addModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Add Main Category</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">

                                {!! Form::open(['id' =>'insertPrimaryCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Category Name<span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control" name="category_name" required="">
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

                <!-- Modal -->
                <div class="modal fade" id="editModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Update Main Category</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body" id="main_category_edit">

                                

                    <!-- Nav Filled Ends -->
                            </div>
                            
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="addSCategory" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Add Secondary Category</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">

                                {!! Form::open(['id' =>'insertSecondaryCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Select Category<span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <select class="form-control main_category_id" name="main_category_id" required="">
                                                    <option value="">Select Main Category</option>
                                                    <?php foreach ($result as $privalue) { ?>
                                                        <option value="<?php echo $privalue->id; ?>"><?php echo $privalue->category_name; ?></option>
                                                    <?php } ?>
                                                    
                                                </select>
                                            </div>                                            

                                            <div class="col-md-4">
                                                <label>Category Name<span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control" name="secondary_category_name" required="">
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


                <!-- Modal -->
                <div class="modal fade" id="editSecondaryCategory" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Edit Secondary Category</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body" id="secondary_category_edit_form">


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
+<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>

    <!-- Delete Section Start Here -->
    <script type="text/javascript">

        $('body').on('click', '#addCategory', function (e) {
            $("#addModal").modal();
            return false ;
        });

        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/getSupplierMainCategory') }}",
                'type':'post',
                'dataType':'text',
                success:function(data){
                    $(".secondary_data").empty();
                    $(".body_data").empty();
                    $(".body_data").append(data);
                }
            });

        });

        $('body').on('click', '.main-category-section', function (e) {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/getSupplierMainCategory') }}",
                'type':'post',
                'dataType':'text',
                success:function(data){
                    $(".secondary_data").empty();
                    $(".body_data").empty();
                    $(".body_data").append(data);
                }
            });

        });



        $('body').on('submit', '#insertPrimaryCategoryInfo', function (e) {
        e.preventDefault();

            var category_name = $('[name="category_name"]').val() ;

            if (category_name == "") {
                toastr.info('Oh shit!! Please Input Category Name', { positionClass: 'toast-bottom-full-width', });
                return false;
            }


            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/insertSupplierPrimaryCategoryInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {category_name: category_name},
                success:function(data){

                    if (data == "success") {

                        $.ajax({
                            'url':"{{ url('/getSupplierMainCategory') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $(".secondary_data").empty();
                                $(".body_data").empty();
                                $(".body_data").html(data);
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/getSuppllierAllMainCategory') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data2){
                                $(".main_category_id").empty().html(data2);
                                $(".main_category_id_ter").empty().html(data2);
                            }
                        });

                        $("#addModal").modal('hide');
                        toastr.success('Thanks !! Primary Category Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                        return false;
                    }else if(data == "failed"){
                        toastr.error('Sorry !! Primary Category Not Added', { positionClass: 'toast-bottom-full-width', });
                            return false;
                    }else if(data == "duplicate_found"){
                        toastr.error('Sorry !! Primary Category Already Exist', { positionClass: 'toast-bottom-full-width', });
                            return false;
                    }else if(data == "package_not_active"){
                        toastr.error('Sorry !! Package Active First', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else if(data == "limit_over"){
                        toastr.error('Sorry !! Primary Category Limit Over', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.info('Oh shit!! Category Name And Category Icon Can not be empty', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                  
                }
            });

        });        


        $(function(){
            $('body').on('click', '.changeSupplierCategoryStatus', function (e) {
                e.preventDefault();

                var category_id = $(this).attr('getCurrencyid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changeSupplierCategoryStatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{category_id:category_id},
                    success:function(data)
                    {
                        $.ajax({
                            'url':"{{ url('/getSupplierMainCategory') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $(".secondary_data").empty();
                                $(".body_data").empty();
                                $(".body_data").html(data);
                            }
                        });

                        if(data == "success"){
                            toastr.success('Thanks !! The status has activated', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }else{
                            toastr.error('Thanks !! The status has deactivated', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }
                    }
                });

            })
        });
        


        $('body').on('submit', '#updatePrimaryCategoryInfo', function (e) {
            e.preventDefault();

            var category_name   = $(".primary_edit_category_name").val() ;
            var primary_id      = $("[name=priamry_edit_primary_id]").val() ;

            if (category_name == "") {
                toastr.info('Oh shit!! Please Input Category Name', { positionClass: 'toast-bottom-full-width', });
                return false;
            }


            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/updateSupplierPrimaryCategoryInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {category_name: category_name, primary_id:primary_id},
                success:function(data){

                    $.ajax({
                        'url':"{{ url('/getSupplierMainCategory') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $(".secondary_data").empty();
                            $(".body_data").empty();
                            $(".body_data").html(data);
                          
                        }
                    });

                    $.ajax({
                        'url':"{{ url('/getSuppllierAllMainCategory') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data2){
                            $(".main_category_id").empty().html(data2);
                            $(".main_category_id_ter").empty().html(data2);
                        }
                    });

                    $("#editModal").modal('hide') ;
                    if (data == "success") {
                        toastr.success('Thanks !! Primary Category Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else if(data == "failed"){
                        toastr.error('Sorry !! Primary Category Not Updated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else if(data == "duplicate_found"){
                        toastr.error('Sorry !! Primary Category Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.info('Oh shit!! Category Name And Category Icon Can not be empty', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                  
                }
            });

        });

        function deleteMainCategory(id) {

            var r = confirm("Are You Sure To Delete It!");
            if (r == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/supplierPrimaryCategoryDelete') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{id:id},
                    success:function(data){

                        console.log(data) ;

                        if (data == "success") {
                            $.ajax({
                                'url':"{{ url('/getSupplierMainCategory') }}",
                                'type':'post',
                                'dataType':'text',
                                success:function(data2){
                                    console.log(data2)
                                    $(".secondary_data").empty();
                                    $(".body_data").empty();
                                    $(".body_data").html(data2);
                                  
                                }
                            });

                            $.ajax({
                                'url':"{{ url('/getSuppllierAllMainCategory') }}",
                                'type':'post',
                                'dataType':'text',
                                success:function(data2){
                                    $(".main_category_id").empty().html(data2);
                                    $(".main_category_id_ter").empty().html(data2);
                                }
                            });

                            toastr.error('Thanks !! You have Delete the Primary Category', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }else if(data == "cused"){
                            toastr.error('Sorry !! Primary Category Already Used', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }else{
                            toastr.error('Sorry !! Primary Category Not Delete', { positionClass: 'toast-bottom-full-width', });
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
                'url':"{{ url('/getSupplierCategoryById') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                    $("#main_category_edit").empty().html(data) ;
                }
            });
        };


    </script>



    <!-- Delete Section Start Here -->
    <script type="text/javascript">

        $('body').on('click', '#addSecondaryCategory', function (e) {
            $("#addSCategory").modal();
            return false ;
        });

        $('body').on('click', '.secondary-category-section', function (e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/getSupplierSecondaryCategory') }}",
                'type':'post',
                'dataType':'text',
                success:function(data){
                    $(".body_data").empty();
                    $(".secondary_data").empty();
                    $(".secondary_data").html(data);
                }
            });
        });


        $('body').on('submit', '#insertSecondaryCategoryInfo', function (e) {
        e.preventDefault();

            var main_category_id            = $('[name="main_category_id"]').val() ;
            var secondary_category_name     = $('[name="secondary_category_name"]').val() ;

            if (main_category_id == "" || main_category_id == undefined) {
                toastr.info('Oh shit!! Please Input Category Name', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            if (secondary_category_name == "") {
                toastr.info('Oh shit!! Please Input Category Name', { positionClass: 'toast-bottom-full-width', });
                return false;
            }


            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/insertSupplierSecondaryCategoryInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {main_category_id:main_category_id, secondary_category_name:secondary_category_name},
                success:function(data){

                    $.ajax({
                        'url':"{{ url('/getSupplierSecondaryCategory') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $(".body_data").empty();
                            $(".secondary_data").empty().html(data);
                        }
                    });

                    if (data == "success") {

                        $("#addSCategory").modal('hide');
                        toastr.success('Thanks !! Secondary Category Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                        return false;
                    }else if(data == "failed"){
                        toastr.error('Sorry !! Secondary Category Not Added', { positionClass: 'toast-bottom-full-width', });
                            return false;
                    }else if(data == "duplicate_found"){
                        toastr.error('Sorry !! Secondary Category Already Exist', { positionClass: 'toast-bottom-full-width', });
                            return false;
                    }else if(data == "package_not_active"){
                        toastr.error('Sorry !! Package Active First', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else if(data == "limit_over"){
                        toastr.error('Sorry !! Secondary Category Limit Over', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.info('Oh shit!! Category Name Can not be empty', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                  
                }
            });

        });

        $(function(){
            $('body').on('click', '.changeSupplierSecodnaryCategoryStatus', function (e) {
                e.preventDefault();

                var category_id = $(this).attr('getSecodnaryCategoryId');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changeSupplierSecodnaryCategoryStatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{category_id:category_id},
                    success:function(data)
                    {
                        $.ajax({
                            'url':"{{ url('/getSupplierSecondaryCategory') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $(".body_data").empty();
                                $(".secondary_data").empty().html(data);
                            }
                        });

                        if(data == "success"){
                            toastr.success('Thanks !! The status has activated', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }else{
                            toastr.error('Thanks !! The status has deactivated', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }
                    }
                });

            })
        });
        

        $('body').on('submit', '#editSecondaryCategoryInfo', function (e) {
            e.preventDefault();

            var main_category_id    = $(".edit_main_category_id").val() ;
            var category_name       = $(".edit_secondary_category_name").val() ;
            var primary_id          = $("[name=edit_primary_id]").val() ;

            if (category_name == "") {
                toastr.info('Oh shit!! Please Input Category Name', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            if (main_category_id == "" || main_category_id == undefined) {
                toastr.info('Oh shit!! Select Main Category', { positionClass: 'toast-bottom-full-width', });
                return false;
            }


            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/updateSupplierSecodnaryCategoryInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {main_category_id:main_category_id, category_name:category_name, primary_id:primary_id},
                success:function(data){

                    $.ajax({
                        'url':"{{ url('/getSupplierSecondaryCategory') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $(".body_data").empty();
                            $(".secondary_data").empty().html(data);
                          
                        }
                    });

                    $("#editSecondaryCategory").modal('hide') ;
                    if (data == "success") {
                        toastr.success('Thanks !! Secondary Category Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else if(data == "failed"){
                        toastr.error('Sorry !! Secondary Category Not Updated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else if(data == "duplicate_found"){
                        toastr.error('Sorry !! Secondary Category Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.info('Oh shit!! Primary Category And Category Name Can not be empty', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                  
                }
            });

        });

        function deleteSecondaryCategory(id) {

        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/deleteSecondaryCategory') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){

                    if (data == "success") {
                        $.ajax({
                            'url':"{{ url('/getSupplierSecondaryCategory') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $(".body_data").empty();
                                $(".secondary_data").empty().html(data);
                            }
                        });

                        toastr.error('Thanks !! You have Delete the Secondary Category', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else if(data == "cused"){
                        toastr.error('Sorry !! Secondary Category Already Used', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Sorry !! Secondary Category Not Delete', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                    
                }
            });
            } else {
                toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
        }

        function secondarycategoryedit(id) {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/secondarycategoryeditfrom') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                   $("#secondary_category_edit_form").empty().html(data) ;
                }
            });
        }
    </script>
@endsection