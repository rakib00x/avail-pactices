@extends('admin.masterAdmin')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">


                        <div class="col-12">

                            <h4 class="card-title">Banner List</h4>

                            <div class="card">
                                <div class="card-header">
                                    <button type="submit" class="float-right btn btn-primary btn-md" data-toggle="modal" data-target="#myModal">+ Add Banner</button>
                                </div>

                                <?php if(Session::get('success') != null) { ?>
                                <div class="alert alert-info alert-dismissible" role="alert">
                                    <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                    <strong><?php echo Session::get('success') ;  ?></strong>
                                    <?php Session::put('success',null) ;  ?>
                                </div>
                                <?php } ?>
                                
                                <?php
                                if(Session::get('failed') != null) { ?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                    <strong><?php echo Session::get('failed') ; ?></strong>
                                    <?php echo Session::put('failed',null) ; ?>
                                </div>
                                <?php } ?>



                                <div class="card-content" id="body_data">


                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Image</th>
                                                        <th>Status</th>
                                                        <th>Action</th>

                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    
                                                    <?php $i=1;?>
                                                    @foreach($result as $value)
                                                        <tr>
                                                            <td>{{$i++}}</td>
                                                            <td><img src="{{ URL::to('public/images/Banner/'.$value->image) }}" alt="" style="width: 75px;height: 33px;"></td>
                                                            <td>
                                                                <div class="custom-control custom-switch custom-control-inline mb-1">
                                                                    <input type="checkbox" class="custom-control-input changeBannerStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getbannerid="{{$value->id}}" id="customSwitch{{$value->id}}">
                                                                    <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="invoice-action">
                                                                    <a onclick="editbanner(<?php echo $value->id ; ?>)" data-toggle="modal" id="edit" data-target="#editModal" href="" class="invoice-action-edit cursor-pointer">
                                                                        <i style="font-size:25px;" class="bx bx-edit"></i>
                                                                    </a>
                                                                    <a href="{{ URL::to('deleteBannerInfo/'.$value->id) }}" class="invoice-action-view mr-1" style="cursor: pointer;">
                                                                        <i style="font-size:25px;" class="bx bx-trash" onclick="return confirm('Are you sure to delete it ??')"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>




                                </div>

                            </div>
                        </div>
                    </div>
                </section>

                <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Add Banner</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body">
                                <div class="form-body">
                                    <div class="row">
                                        {!! Form::open(['id' =>'addBannerInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                            <div class="col-md-12" >
                                                 <label>Banner <span style="color:red;">Max Size : 2M*</span></label>
                                                <input type="file" class="form-control" name="image" required="">
                                            </div>
                                            <br>
                                            <br>
                                            <br>
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>

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
                                <h3 class="modal-title" id="myModalLabel1">Edit Banner</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body" id="modal_data">

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

        $("#addBannerInfo").submit(function(e){
            e.preventDefault() ;

            let myForm = document.getElementById('addBannerInfo');
            let formData = new FormData(myForm);

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                'url':"{{ url('/savebannerimageinfo') }}",
                'data': formData,
                'processData': false, // prevent jQuery from automatically transforming the data into a query string.
                'contentType': false,
                'type': 'POST',
                success: function(data) {
                    if (data == "success") {
                        toastr.success('Banner Add Successfully', { positionClass: 'toast-bottom-full-width', });
                        setTimeout(function(){
                            location.reload();
                        }, 1000);
                        return false ;
                    }else{
                        toastr.error('Invalid Image Format', { positionClass: 'toast-bottom-full-width', });
                        return false ;
                    }
                }
            })


        }) ;       
        
    });
    
    $('body').on('submit', '#updateBanner', function(e) {

            e.preventDefault() ;

            let myForm = document.getElementById('updateBanner');
            let formData = new FormData(myForm);
            

            $.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                'url':"{{ url('/updatebannerimageinfo') }}",
                'data': formData,
                'processData': false, // prevent jQuery from automatically transforming the data into a query string.
                'contentType': false,
                'type': 'POST',
                success: function(data) {
                    
                     $("#editModal").modal('hide') ;
                   if (data == "success") {
                        toastr.success('Banner Update Successfully', { positionClass: 'toast-bottom-full-width', });
                        setTimeout(function(){
                           location.reload();
                        }, 1000);
                        return false ;
                    }else{
                        toastr.error('Invalid Image Format', { positionClass: 'toast-bottom-full-width', });
                        return false ;
                    }
                }
            })


        }) ;  
    

function editbanner(banner_id) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/editbanner') }}",
            'type':'post',
            'dataType':'text',
            data: {banner_id: banner_id},
            success:function(data){
                $("#modal_data").empty();
                $("#modal_data").html(data);

            }
        });

    }

    $(function(){
    $('body').on('click', '.changeBannerStatus', function (e) {
        e.preventDefault();

        var banner_id = $(this).attr('getbannerid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changeBannerStatus') }}",
            'type':'post',
            'dataType':'text',
            data:{banner_id:banner_id},
            success:function(data)
            {

                if(data == "success"){
                    toastr.success('Banner Status Successfully', { positionClass: 'toast-bottom-full-width', });
                        setTimeout(function(){
                            location.reload(true);
                        }, 100);
                    return false ;
                }else{
                    toastr.error('Thanks !! Banner status has deactivated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            }
        });

    })
});





</script>


@endsection