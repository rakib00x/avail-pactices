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

        .selected_icon{
            position: absolute;
            padding: 38%;
            font-size: 30px;
            color: #4ebd37;
        }
        
    </style>
@endpush
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Color List</h4>
                            <div class="card">
                                <div class="card-header">
                                    
                                    <a role="button" class="float-right btn btn-primary btn-md" id="addCategory">+ Add Color</a>

                                </div>

                                <div class="card-content" id="body_data">
                                    
                                </div>


                            </div>
                        </div>
                    </div>
                </section>

                                <!-- Modal -->
                <div class="modal fade" id="addModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Add Color</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                {!! Form::open(['id' =>'insertPrimaryColorInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Color Name <span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control color_name" name="color_name" required="">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Image <span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group" >
                                                <input type="file" class="form-control " name="color_image" id="myBtn">
                                                <input type="hidden" name="slected_category_icon" class="slected_category_icon" id="slected_category_icon">
                                                <span id="image_siam" class="image_siam"></span>
                                            </div>



                                            <br>
                                            <br>
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

                <!-- Modal -->
                <div class="modal fade" id="editModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Update Color </h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">

                                {!! Form::open(['id' =>'updatePrimaryColorInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body" id="mainCategoryEditForm">

                                    </div>
                                {!! Form::close() !!}

                    <!-- Nav Filled Ends -->
                            </div>
                            
                        </div>
                    </div>
                </div>


                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#home-fill" role="tab" aria-controls="home-fill" aria-selected="true">
                                            Select File
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-tab-fill" data-toggle="tab" href="#profile-fill" role="tab" aria-controls="profile-fill" aria-selected="false">
                                            Upload File
                                        </a>
                                    </li>
                                </ul>

                                <input type="text" name="search_keyword" id="search_keyword" class="form-control col-md-4" placeholder="Search">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <!-- Tab panes -->
                                <div class="tab-content pt-1">
                                    <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                        <div class="row " id="table_data">


                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                        <form method="post"  action="{{ url('supplierImage/upload') }}" enctype="multipart/form-data" 
                                            class="dropzone" id="dropzone">
                                        @csrf
                                        </form>   
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-default" id="saveImage">Save</button>
                                        </div>
                                    </div>

                                </div>
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
        $(document).ready(function(){
            $('body').on('click', '#myBtn', function (e) {
                $("#myModal").modal();
                return false ;
            });

            $('body').on('click', '#addCategory', function (e) {
                $("#addModal").modal();
                return false ;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/getAllSupplierSingleImage') }}",
                'type':'get',
                'dataType':'text',
                success:function(data){
                    $("#table_data").empty();
                    $("#table_data").html(data);
                  
                }
            });

        });

        $('body').on('click', '.single_image_select', function (e) {
            e.preventDefault();

            $('.single_image_select').removeClass('siam_active') ;
            $(this).addClass('siam_active');

            $('#myModal').modal('show');

            $('.icon_single_show').css('display', 'none') ;
            $(this).find('.icon_single_show').removeAttr('style');

            var inputvalu = $(this).find('.single_image_value').val();
            var x = document.createElement("IMG");
            x.setAttribute("src", "public/images/" + inputvalu);
            x.setAttribute("width", "200");
            x.setAttribute("height", "200");
            x.setAttribute("alt", "The Pulpit Rock");

            $(".image_siam").empty();
            $(".image_siam").append(x);
            $(".slected_category_icon").val(inputvalu) ;

        });

        Dropzone.options.dropzone =
         {
            maxFilesize: 12,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 50000,
            removedfile: function(file) 
            {
                var name = file.upload.filename;
                $.ajax({
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                    type: 'POST',
                    url: '{{ url("/image/meta_delete") }}',
                    data: {filename: name},
                    success: function (data){
                        //console.log("File has been successfully removed!!");
                    },
                    error: function(e) {
                        console.log(e);
                    }});
                    var fileRef;
                    return (fileRef = file.previewElement) != null ? 
                    fileRef.parentNode.removeChild(file.previewElement) : void 0;
            },
       
            success: function(file, response) 
            {
                console.log(response);
            },
            error: function(file, response)
            {
               return false;
            }
        };

        $("#saveImage").click(function(e){
            e.preventDefault() ;

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/supplierSaveImage') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        Dropzone.forElement("#dropzone").removeAllFiles(true);
                        toastr.success('Thanks !! Media Add Successfully Compeleted', { positionClass: 'toast-bottom-full-width', });
                        $.ajax({
                            'url':"{{ url('/getAllSupplierSingleImage') }}",
                            'type':'get',
                            'dataType':'text',
                            success:function(data){
                                $("#table_data").empty();
                                $("#table_data").html(data);
                              
                            }
                        });
                        return false;
                    }
                });

        
        }) ;

        $('body').on('keyup', '#search_keyword', function (e) {
            e.preventDefault();

            var search_keyword = $(this).val() ;

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/supplierMediaImageSearch') }}",
                'type':'post',
                'dataType':'text',
                data: {search_keyword: search_keyword},
                success:function(data){
                    $("#table_data").empty();
                    $("#table_data").html(data);
                  
                }
            });

        });

    </script>



    <!-- insert Section Start Here -->
    <script type="text/javascript">
        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/getAllPrimaryColor') }}",
                'type':'post',
                'dataType':'text',
                success:function(data){
                    $("#body_data").empty();
                    $("#body_data").html(data);
                  
                }
            });

        });



        $('body').on('submit', '#insertPrimaryColorInfo', function (e) {
        e.preventDefault();

            var color_name = $('[name="color_name"]').val() ;
            var color_image = $("[name=slected_category_icon]").val() ;

            if (color_name == "") {
                toastr.info('Oh shit!! Please Input Color Name', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            if (color_image == "") {
                toastr.info('Oh shit!! Please Select An Image', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/insertPrimaryColorInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {color_name: color_name, color_image:color_image},
                success:function(data){

                    if (data == "success") {

                        $.ajax({
                            'url':"{{ url('/getAllPrimaryColor') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#body_data").empty();
                                $("#body_data").html(data);
                              
                            }
                        });

                        $("#addModal").modal('hide');
                        toastr.success('Thanks !! Color Name Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                        return false;
                    }else if(data == "failed"){
                        toastr.error('Sorry !! Color Name Not Added', { positionClass: 'toast-bottom-full-width', });
                            return false;
                    }else if(data == "duplicate_found"){
                        toastr.error('Sorry !! Color Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                            return false;
                    }else{
                        toastr.info('Oh shit!! Color Name Or Image Can not be empty', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                  
                }
            });

        });



 $(function(){
        $('body').on('click', '.changeColorStatus', function (e) {
            e.preventDefault();

            var color_id = $(this).attr('getColorid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/changeColorStatus') }}",
                'type':'post',
                'dataType':'text',
                data:{color_id:color_id},
                success:function(data)
                {
                    $.ajax({
                        'url':"{{ url('/getAllPrimaryColor') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);

                        }
                    });

                    if(data == "success"){
                        toastr.success('Thanks !! The Color status has activated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Thanks !! The Color status has deactivated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                }
            });

        })
    });


        $('body').on('submit', '#updatePrimaryColorInfo', function (e) {
            e.preventDefault();

            var color_name   = $(".ismail").val() ;
            var color_image   = $(".slected_category_icon").val() ;
            var primary_id      = $("[name=primary_id]").val();

            if (color_name == "") {
                toastr.info('Oh shit!! Please Input Color Company Name', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            if (color_image == "") {
                toastr.info('Oh shit!! Please Select An Image', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/updatePrimaryColorInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {color_name: color_name, color_image:color_image, primary_id:primary_id},
                success:function(data){
                    $.ajax({
                        'url':"{{ url('/getAllPrimaryColor') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);
                          
                        }
                    });
                    $("#editModal").modal('hide') ;
                    if (data == "success") {
                        toastr.success('Thanks !! Color Name Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                        return false;
                    }else if(data == "failed"){
                        toastr.error('Sorry !! Color Name Not Updated', { positionClass: 'toast-bottom-full-width', });
                            return false;
                    }else if(data == "duplicate_found"){
                        toastr.error('Sorry !! Color Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                            return false;
                    }else{
                        toastr.info('Oh shit!! Color Name Or Image Can not be empty', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                  
                }
            });

        });

// delete

    function deleteColor(id) {

        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/primaryColorDelete') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){

                    if (data == "success") {
                        $.ajax({
                            'url':"{{ url('/getAllPrimaryColor') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#body_data").empty();
                                $("#body_data").html(data);

                            }
                        });

                        toastr.error('Thanks !! You have Delete the Color Name', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Sorry !! Color Name Not Delete', { positionClass: 'toast-bottom-full-width', });
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
                'url':"{{ url('/editMainColor') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                    $("#mainCategoryEditForm").empty().html(data) ;
                }
            });
        }
    </script>

@endsection