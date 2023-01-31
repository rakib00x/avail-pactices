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
                        <h4 class="card-title"> About Page</h4>
                        <div class="card">
                            <div class="card-header">
                                
                                <a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#addModal" >+ Add About Page</a>

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
                            <h3 class="modal-title" id="myModalLabel1">Add About Section </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'insertAboutInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Title <span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="text" class="form-control about_title" name="about_title" required="">
                                    </div>

                                    <div class="col-md-4">
                                        <label>Details <span style="color:red;">*</span></label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <textarea type="text" class="form-control about_details summernote" name="about_details" required=""></textarea>
                                    </div>
                                    <div class="col-md-4">
                                        <label>Image Position </label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <select name="image_position" class="form-control">
                                            <option value="">Select Position</option>
                                            <option value="1">Left Side</option>
                                            <option value="2">Right Side</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label>Image</label>
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <input type="file" class="form-control image" name="image">
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

    </div>
</div>
</div>

@endsection

@section('js')
<!-- Alert Assets -->
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script>

    $('body').on('submit', '#insertAboutInfo', function (e) {
        e.preventDefault();

        let about_title     = $(".about_title").val() ;
        let about_details   = $(".about_details").val() ;
        let image_position  = $(".image_position").val() ;
        let image           = $(".image").val() ;

        if (image != '' && image_position == "") {
            
            toastr.info('Oh shit!! Please Select Image Position', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

        if(about_title == ""){
            toastr.info('Oh shit!! Please Input About Title', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

        if(about_details == ""){
            toastr.info('Oh shit!! Please Input About Details', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

        let myForm = document.getElementById('insertAboutInfo');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/insertAboutInfo') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {

                if (data == "success") {
                    toastr.success('About Section Add Successfully', { positionClass: 'toast-bottom-full-width', });

                    $.ajax({
                        'url':"{{ url('/getAboutPageList') }}",
                        'type':'get',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);
                        }
                    });
                }else if(data == "duplicate_about"){
                    toastr.info('Sorry About Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }else{
                    toastr.info('Sorry! Invalid Image Extension', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }
            }
        })
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
            'url':"{{ url('/getAboutPageList') }}",
            'type':'get',
            'dataType':'text',
            success:function(data){
                $("#body_data").empty();
                $("#body_data").html(data);

            }
        });

    });

    function deleteAboutPageInfo(id) {

        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/deleteAboutPageInfo') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                    console.log(data);

                    if (data == "success") {
                        $.ajax({
                        'url':"{{ url('/getAboutPageList') }}",
                        'type':'get',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);

                        }
                    });

                        toastr.error('Thanks !! You have Delete the About Section', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Sorry !! About Section Not Delete', { positionClass: 'toast-bottom-full-width', });
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