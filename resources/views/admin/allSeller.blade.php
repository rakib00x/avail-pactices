@extends('admin.masterAdmin')
@section('title','All Seller')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- users list start -->
            <section class="users-list-wrapper">
                <div class="users-list-filter px-1">
                    <form>
                        <div class="row border rounded py-2 mb-2">
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="users-list-verified">Verified</label>
                                <fieldset class="form-group">
                                    <select class="form-control" id="users-list-verified">
                                        <option value="">Any</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3">
                                <label for="users-list-status">Status</label>
                                <fieldset class="form-group">
                                    <select class="form-control" id="users-list-status">
                                        <option value="">Any</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Active</option>
                                        <option value="2">Close</option>
                                        <option value="3">Banned</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
                                <button type="reset" class="btn btn-primary btn-block glow users-list-clear mb-0">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="users-list-table">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body" id="table_data">


                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- users list ends -->
            
                        <!-- Modal -->
            <div class="modal fade" id="editModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel1">Update Seller Information </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'updateSellerInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body" id="mainCategoryEditForm">

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
<!-- END: Content-->

@endsection
@section('js')
    <script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getAllSaller') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                $("#table_data").empty();
                $("#table_data").html(data);
              
            }
        });
    });


    $("#users-list-verified").change(function(e){
        e.preventDefault() ;

        var verify_status = $(this).val() ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getSellerByVerifyStatus') }}",
            'type':'post',
            'dataType':'text',
            data: {verify_status: verify_status},
            success:function(data){
                $("#table_data").empty();
                $("#table_data").html(data);
              
            }
        });
    });    

    $("#users-list-status").change(function(e){
        e.preventDefault() ;

        var status = $(this).val() ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getSellerByStatus') }}",
            'type':'post',
            'dataType':'text',
            data: {status: status},
            success:function(data){
                $("#table_data").empty();
                $("#table_data").html(data);
              
            }
        });
    });

    $('body').on('click', '.changeSellerStatus', function (e) {
        e.preventDefault();

        var seller_id = $(this).attr('getCurrencyid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changeSellerStatus') }}",
            'type':'post',
            'dataType':'text',
            data:{seller_id:seller_id},
            success:function(data)
            {
                $.ajax({
                    'url':"{{ url('/getAllSaller') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(currencyData)
                    {
                        $("#table_data").empty();
                        $("#table_data").html(currencyData);
                    }
                });

                if(data == "success"){
                    toastr.success('Thanks !! The Seller status has activated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "failed"){
                    toastr.warning('Thanks !! The Seller status has In Active', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.warning('Thanks !! Seller Already Banned You Can Not Change Status', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }


            }
        });

    });
    
    function suspendSeller(event, seller_id){
        
        event.preventDefault() ;
        
    
        var r=confirm("Are you sure to suspend this seller ?");
          
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        if(r){
            $.ajax({
                'url':"{{ url('/changeSellerStatusToSuspend') }}",
                'type':'post',
                'dataType':'text',
                data:{seller_id:seller_id},
                success:function(data)
                {
                    $.ajax({
                        'url':"{{ url('/getAllSaller') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(currencyData)
                        {
                            $("#table_data").empty();
                            $("#table_data").html(currencyData);
                        }
                    });
        
                    if(data == "success"){
                        toastr.success('Thanks !! The Seller status has suspend', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.warning('Thanks !! Seller Already Suspend You Can Not Change Status', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
        
        
                }
            });
        }else{
            toastr.warning('Thanks !! Suspend cancel successfully', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

    }
    
    function adminSupplierEdit(event, seller_id){
        event.preventDefault() ;
        
        $("#editModal").modal('show');
        
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/editSupplierInfoForAdmin') }}",
            'type':'post',
            'dataType':'text',
            data:{seller_id:seller_id},
            success:function(data)
            {
    
                $("#mainCategoryEditForm").empty().html(data);

            }
        });
    }
    
    $("#updateSellerInfo").submit(function(e){
        e.preventDefault() ;
        
        var country_id  = $(".country_id").val();
        var primary_id  = $("[name=primary_id]").val() ;
        
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/updateSupplierCountryInfo') }}",
            'type':'post',
            'dataType':'text',
            data:{country_id:country_id, primary_id:primary_id},
            success:function(data)
            {
    
                $.ajax({
                    'url':"{{ url('/getAllSaller') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(currencyData)
                    {
                        $("#table_data").empty();
                        $("#table_data").html(currencyData);
                    }
                });
    
                if(data == "success"){
                    $("#editModal").modal('hide');
                    toastr.success('Thanks !! Seller Country Change Successfully', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "failed"){
                    toastr.warning('Thanks !! Country Not Update', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.warning('Thanks !! Somthing Went Wrong', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });
        
    });
    
    function deleteSupplierInfo(event, supplier_id) {
        event.preventDefault() ;

        var r = confirm("Are you sure to delete this seller ??");
        if(r){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/deleteSupplierAllInfo') }}",
                'type':'post',
                'dataType':'text',
                data:{supplier_id:supplier_id},
                success:function(data)
                {
        
                    $.ajax({
                        'url':"{{ url('/getAllSaller') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(currencyData)
                        {
                            $("#table_data").empty();
                            $("#table_data").html(currencyData);
                        }
                    });
        
                    if(data == "success"){
                        toastr.success('Thanks !! Seller Delete Successfully', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.warning('Sorry !! Somthing Went Wrong', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }

                }
            });
        }else{
            toastr.warning('Thanks !! Delete Cancel Successfully', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

    }


</script>
@endsection