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
                                <label for="users-list-status">Status</label>
                                <fieldset class="form-group">
                                    <select class="form-control" id="users-list-status">
                                        <option value="">Any</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Active</option>
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
            'url':"{{ url('/getAllBuyer') }}",
            'type':'post',
            'dataType':'text',
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
            'url':"{{ url('/getBuyerByStatus') }}",
            'type':'post',
            'dataType':'text',
            data: {status: status},
            success:function(data){
                $("#table_data").empty();
                $("#table_data").html(data);
              
            }
        });
    });

    function deleteBuyer(event, buyer_id) {
        event.preventDefault() ;

        var r = confirm("Are you sure delete this buyer ?") ;
        if(r){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/deleteBuyerInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {buyer_id: buyer_id},
                success:function(data){

                    $.ajax({
                        'url':"{{ url('/getAllBuyer') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#table_data").empty();
                            $("#table_data").html(data);
                        
                        }
                    });

                    toastr.success('Thanks !! The Buyer Delete Successfully', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            });
        }else{
            toastr.error('Sorry !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

    }


</script>
@endsection