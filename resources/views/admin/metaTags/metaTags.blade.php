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
    
    .meta_class_image{
        cursor: pointer;
    }
    
    .remove_project_file3{
        width: 100px;
        height: 100px;
        float: left;
        margin: 5px;
    } 

</style>
@endpush
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title">Meta Tags</h4>
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body card-dashboard">


                                    {!! Form::open(['id' =>'updateMetaTags','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Meta Title<span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" id="meta_title" class="form-control meta_title" name="meta_title" value="{{ $value->meta_title }}">
                                            </div>

                                            <div class="col-md-4">
                                                <label>Meta Details</label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <textarea type="text" id="meta_details" class="form-control meta_details" name="meta_details" >{{ $value->meta_details }}</textarea>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Meta Keywords <span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <textarea type="text" id="meta_keywords"  class="form-control meta_keywords" name="meta_keywords" >{{ $value->meta_keywords }}</textarea>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Meta Image <span style="color:red;">*</span></label>
                                            </div>

                                            <div class="col-md-8 form-group" >
                                                <input type="file" class="form-control category_icon" name="meta_image">
                                                {{--<input type="hidden" name="slected_category_icon" class="slected_category_icon" id="meta_image" value="<?php echo $value->meta_image; ?>">--}}
                                                <span id="image_siam" class="image_siam">
                                                    <img src="{{URL::to('public/images/mettag/'.$value->meta_image)}}" alt="" width="200" height="200">
                                                </span>
                                            </div>

                                            <input type="hidden" name="primary_id" value="<?php echo $value->id ; ?>">
                                            <br>
                                            <br>
                                            <br>
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
                </div>
            </section>


            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
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
                            <button type="button" class="btn btn-primary" onclick="finalselectedimage()">OK</button>
                            <button type="button" class="close" onclick="modalclosewithremoveimage()">&times;</button>

                        </div>
                        <div class="modal-body">
                            <div class="tab-content pt-1">
                                <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                    <div class="row " id="table_data">


                                    </div>
                                </div>
                                <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                    <form method="post"  action="{{url('shipping/upload/store')}}" enctype="multipart/form-data" 
                                    class="dropzone" id="dropzone">
                                    @csrf
                                </form>   
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-default" id="saveImage">Save</button>
                                </div>
                            </div>

                        </div>
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

        $('.siam_class').removeClass('siam_active') ;
        $(this).addClass('siam_active');

        $('#myModal').modal('show');
        
        $("#table_data").each(function(){
            $(this).find('.icon_show').css('display', 'none') ;
        });

        $(this).find('.icon_show').removeAttr("style") ;

        var inputvalu = $(this).find('.captureInput').val();
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
            'url':"{{ url('/adminSaveImage') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                Dropzone.forElement("#dropzone").removeAllFiles(true);
                toastr.success('Thanks !! Media Add Successfully Compeleted', { positionClass: 'toast-bottom-full-width', });
                $.ajax({
                    'url':"{{ url('/shippingAllImages') }}",
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



<script type="text/javascript">
//update
$("#updateMetaTags").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('updateMetaTags');
        let formData = new FormData(myForm);
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            'url':"{{ url('/updateMetaTags') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
             $("#editModal").modal('hide') ;
            if (data == "success") {
                toastr.success('Thanks !! Meta Tags Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                return false;
            }else if(data == "failed"){
                toastr.error('Sorry !! Meta Tags Not Updated', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else{
                toastr.info('Oh shit!! Meta Tags and Image Can not be empty', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            }
            
        })
    })






function finalselectedimage() {
    $("#myModal").modal('hide');
}

function modalclosewithremoveimage() {
    $('.siam_class').removeClass('siam_active') ;
    $("#table_data").each(function(){
        $('.icon_show').css('display', 'none') ;
    });
    $("#image_siam").empty() ;
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