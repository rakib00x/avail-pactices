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
        border: 2px solid #42b72a ;
    }
    
    .selected_icon{
        position: absolute;
        padding: 38%;
        font-size: 30px;
        color: #4ebd37;
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

                        <h4 class="card-title">Mobile Bank List</h4>

                        <div class="card">
                            <div class="card-header">

                                <a role="button" class="float-right btn btn-primary btn-md" id="addCategory">+ Add Mobile Bank Information</a>

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
                            <h3 class="modal-title" id="myModalLabel1">Add Mobile Bank Information</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'insertMobileBankInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Bank Name <span style="color:red;">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control bank_name" name="bank_name" required="">
                                    </div>  

                                    <div class="col-md-4">
                                        <label>Counter Number <span style="color:red;">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control counter_number" name="counter_number" required="">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Payment Number<span style="color:red;">*</span>
                                        </label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control payment_number" name="payment_number" required="">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Bank Logo <span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-8 form-group" >
                                        <input type="file" class="form-control " name="bank_logo" >
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
                            <h3 class="modal-title" id="myModalLabel1">Update Bank Information </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'updateMobileBankInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
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
                            <input type="hidden" name="media_section" id="media_section" value="0">
                            <button type="button" class="btn btn-primary" onclick="finalselectedimage()">OK</button>
                            <button type="button" class="close" onclick="modalclosewithremoveimage()">&times;</button>

                        </div>
                        <div class="modal-body">
                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
                                <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                    <div class="row " id="table_data">


                                    </div>
                                </div>
                                <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                    <form method="post"  action="{{url('image/upload/store')}}" enctype="multipart/form-data" 
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
        
        $('body').on('click', '#admineditsection', function (e) {
            $("[name=media_section]").val(1);
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
            'url':"{{ url('/getAllImages') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                $("#table_data").empty();
                $("#table_data").html(data);

            }
        });

    });

        $('body').on('click', '.siam_class', function (e) {
        e.preventDefault();
        var show_type = $("[name=media_section]").val();

        $('.siam_class').removeClass('siam_active') ;
        $(this).addClass('siam_active');
        $('#myModal').modal('show');

        $("#table_data").each(function(){
            $(this).find('.icon_show').css('display', 'none') ;
        });
        $(this).find('.icon_show').removeAttr("style") ;

        var inputvalu = $(this).find('.captureInput').val();
        if(show_type == 0){
            var x = document.createElement("IMG");
            x.setAttribute("src", "public/images/" + inputvalu);
            x.setAttribute("width", "200");
            x.setAttribute("height", "200");
            x.setAttribute("alt", "The Pulpit Rock");
            $(".image_siam").empty();
            $(".image_siam").append(x);
            $(".slected_category_icon").val(inputvalu) ;
        }else{
            $("[name=selected_icon_edit]").val(inputvalu) ;
        }

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
                url: '{{ url("/image/delete") }}',
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

        success: function(file, response) {
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
            'url':"{{ url('/adminSaveImage') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                Dropzone.forElement("#dropzone").removeAllFiles(true);
                toastr.success('Thanks !! Media Add Successfully Compeleted', { positionClass: 'toast-bottom-full-width', });
                $.ajax({
                    'url':"{{ url('/getAllImages') }}",
                    'type':'post',
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
            'url':"{{ url('/getSearchValue') }}",
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



<!-- Insert Section Start Here -->
<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getallmobilebank') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                $("#body_data").empty();
                $("#body_data").html(data);

            }
        });

    });


//insert
$("#insertMobileBankInfo").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('insertMobileBankInfo');
        let formData = new FormData(myForm);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            'url':"{{ url('/insertMobileBankInfo') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data == "success") {

                    $.ajax({
                        'url':"{{ url('/getallmobilebank') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);

                        }
                    });

        $("#addModal").modal('hide');
                toastr.success('Thanks !! Bank Information Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                return false;
            }else if(data == "failed"){
                toastr.error('Sorry !! Bank Information Not Added', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else if(data == "duplicate_found"){
                toastr.error('Sorry !! Mobile Bank Information Already Exist', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else{
                toastr.info('Oh shit!! Bank Information Can not be empty', { positionClass: 'toast-bottom-full-width', });
                return false;
            }


            }
        })
    })



// status change

$(function(){
    $('body').on('click', '.changemobilebankstatus', function (e) {
        e.preventDefault();

        var bank_id = $(this).attr('getBankid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changemobilebankstatus') }}",
            'type':'post',
            'dataType':'text',
            data:{bank_id:bank_id},
            success:function(data)
            {
                $.ajax({
                    'url':"{{ url('/getallmobilebank') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#body_data").empty();
                        $("#body_data").html(data);

                    }
                });
               
                if(data == "success"){
                    toastr.success('Thanks !! The Bank status has activated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.error('Thanks !! The Bank status has deactivated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            }
        });

    })
});


//update
$("#updateMobileBankInfo").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('updateMobileBankInfo');
        let formData = new FormData(myForm);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            'url':"{{ url('/updateMobileBankInfo') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                
                    $.ajax({
                        'url':"{{ url('/getallmobilebank') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);

                        }
                    });

             $("#editModal").modal('hide');
             if (data == "success") {
                toastr.success('Thanks !! Bank Information Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });
                return false;
            }else if(data == "failed"){
                toastr.error('Sorry !! Bank Information Not Update', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else if(data == "duplicate_found"){
                toastr.error('Sorry !! Mobile Bank Information Already Exist', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else{
                toastr.info('Oh shit!! Bank Information Can not be empty', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            }
            
        })
    })


// delete

function deleteBank(id) {
    var r = confirm("Are You Sure To Delete It!");
    if (r == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/bankMobileDelete') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){

                if (data == "success") {
                    $.ajax({
                        'url':"{{ url('/getAllBank') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);
                        }
                    });

                    toastr.error('Thanks !! You have Delete the Bank Information', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.error('Sorry !! Bank Information Not Delete', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });
    } else {
        toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
        return false;
    }
}

// edit

function edit(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        'url':"{{ url('/editmobileBank') }}",
        'type':'post',
        'dataType':'text',
        data:{id:id},
        success:function(data){

            $("#mainCategoryEditForm").empty().html(data) ;

        }
    });
}

function finalselectedimage() {
    var show_type = $("[name=media_section]").val();

    if(show_type == 1){
        var inputvalu = $("[name=selected_icon_edit]").val() ;
        var x = document.createElement("IMG");
        x.setAttribute("src", "public/images/" + inputvalu);
        x.setAttribute("width", "200");
        x.setAttribute("height", "200");
        x.setAttribute("alt", "The Pulpit Rock");
        $(".image_siam").empty();
        $(".image_siam").append(x);
        $(".slected_category_icon").val(inputvalu) ;

        $("[name=selected_icon_edit]").val("");
    }
    
    $("#myModal").modal('hide');
}

function modalclosewithremoveimage() {
    $('.siam_class').removeClass('siam_active') ;
    $("#table_data").each(function(){
        $('.icon_show').css('display', 'none') ;
    });

    $("#image_siam").empty() ;

    var show_type = $("[name=media_section]").val();
    if(show_type == 1){
        $("[name=selected_icon_edit]").val("");
    }

    $("#myModal").modal('hide');
}

$(document).on('click', '#product_image_pagination .page-link', function(event){
    event.preventDefault();
    var page = $(this).attr('href').split('page=')[1];
    adminmediaimagepaginate(page);
});

function adminmediaimagepaginate(page)
{
    var search_keyword = $("#search_keyword").val() ;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url:"{{ url('getadminmediaimagepaginate') }}",
        method:"POST",
        data:{page:page, search_keyword:search_keyword},
        success:function(data)
        {
            $("#myModal").show();
            $("#table_data").empty();
            $("#table_data").html(data);
        }
    });
}
</script>

@endsection