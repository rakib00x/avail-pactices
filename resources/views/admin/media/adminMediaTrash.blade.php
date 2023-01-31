@extends('admin.masterAdmin')
@section('title')
Admin Media Trash
@endsection
@section('content')
@push('styles')
    <style>
        @media screen and (min-width: 992px){
            .modal-dialog {
                max-width: 700px!important;
            }
        }
        .selected_icon{
            position: absolute;
            top: 10%;
            left: 30%;
            font-size: 30px;
            color: #4ebd37;
        }
        .media_active{
            border: 2px solid #4ebd37;
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
                            <h5 class="content-header-title float-left pr-1 mb-0">Media</h5>
                            <div class="breadcrumb-wrapper col-12">
                                <ol class="breadcrumb p-0 mb-0">
                                    <li class="breadcrumb-item"><a href="{{URL::to('supplierDashboard')}}"><i class="bx bx-home-alt"></i></a>
                                    </li>
                                    <li class="breadcrumb-item active"> Media List
                                    </li>
                                </ol>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-6 mb-1" >
                        <div class="row">
                            <div class="col-md-12">
                                <a href="#" title="Delete" class="btn btn-danger" onclick="deleteSupplierAllTrashImage()">Empty Trash</a>
                                <a href="#" title="Restore" class="btn btn-success" onclick="supplierTrashImageRestore()">Restore &nbsp;</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 row mb-1">
                        <div class="col-md-10">
                            <input type="text" class="form-control search_value" placeholder="Search" name="search_value">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success" id="mediaSearch"><i class="ficon bx bx-search"></i></button>
                        </div>
                    </div>
                </div>
                <!-- account setting page start -->
                <section id="page-account-settings">
                    <div class="row">


                        <div class="col-md-12 page-account-settings">
                            <div class="col-md-12">
                                <div class="row" style="border: 2px solid #fff;padding: 10px;height: 580px;">
                                    @foreach ($result as $value)
                                        <div class="col-2 mb-1">
                                            <a href="#" onclick="mediaStatusChange(<?php echo $value->id ; ?>)" >
                                                <img src="{{ URL::to('/public/images/'.$value->image)}}" alt="" class="img-thumbnail <?php if($value->select_status == 1){echo "media_active";}else{echo ""; } ?>" style="width: 100%;height:100px;" id="media_active_status_<?php echo $value->id; ?>">
                                                <i class="fa fa-check icon_show selected_icon" aria-hidden="true" style="display: <?php if($value->select_status == 0){echo "none";}else{echo "";} ?>" id="media_image_<?php echo $value->id; ?>"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>  
                                <div class="row">
                                    <div class="col-6 offset-md-6" style="margin-top: 10px;">
                                        <ul class="pagination" style="float: right;">
                                            {!! $result->onEachSide(1)->links() !!}
                                        </ul>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- account setting page ends -->



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

        function mediaStatusChange(id) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/adminMediaStatusChange') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                    console.log(data);
                    if (data == "product_image_exit") {
                       toastr.error('Sorry !! Image Already Used', { positionClass: 'toast-bottom-full-width', });
                        return false ;
                    }else{
                        if (data == 1) {
                            $("#media_active_status_"+id+"").addClass('media_active');
                            $("#media_image_"+id+"").removeAttr('style');
                        }else{
                            $("#media_active_status_"+id+"").removeClass('media_active');
                            $("#media_image_"+id+"").css("display", "none");
                        }
                    }
                    
                }
            });  
        }
        
        function supplierTrashImageRestore() {

            var r = confirm("Are You Sure To Restore it!");
            if (r == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/adminTrashImageRestore') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){

                        if (data == "success") {
                            toastr.success('Thanks !! Image Restore Successfully ', { positionClass: 'toast-bottom-full-width', });
                            setTimeout(function(){
                                url = "adminMediaTrash";
                                $(location).attr("href", url);
                            }, 3000);
                            return false;
                        }else if(data == "product_image_exit"){
                            toastr.error('Sorry !! Image Already Used', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }
                        
                    }
                });
            } else {
                toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
        }


        function deleteSupplierAllTrashImage() {

            var r = confirm("Are You Sure To Delete All Trash Image!");
            if (r == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/deleteAdminAllTrashImage') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){

                        if (data == "success") {
                            toastr.success('Thanks !! All Trash Image Delete Successfully ', { positionClass: 'toast-bottom-full-width', });
                            setTimeout(function(){
                                url = "adminMediaTrash";
                                $(location).attr("href", url);
                            }, 3000);
                            return false;
                        }else if(data == "product_image_exit"){
                            toastr.error('Sorry !! Image Already Used', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }
                        
                    }
                });
            } else {
                toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
        }

        $(document).on('click', '.page-link', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            var search_value = $('.search_value').val() ;
            fetch_data(page, search_value);
        });

        function fetch_data(page, search_value)
        {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"{{ url('getAdminMediaTrashPagnationResult') }}",
                method:"POST",
                data:{page:page, search_value:search_value},
                success:function(data)
                {
                    $(".page-account-settings").empty();
                    $(".page-account-settings").html(data);
                }
            });
        }

        $("#mediaSearch").click(function(e){
            var search_value = $('.search_value').val() ;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/getAdminTrashMediaSearchValue') }}",
                'type':'post',
                'dataType':'text',
                data:{search_value:search_value},
                success:function(data){

                    $(".page-account-settings").empty();
                    $(".page-account-settings").html(data);
                    
                }
            });
        })
    </script>


@endsection