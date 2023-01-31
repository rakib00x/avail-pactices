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
                        <h4 class="card-title">Review List</h4>
                        <div class="card">

                            <div class="card-content" id="body_data">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration" >
                                            <thead>
                                                <tr>
                                                    <th>SN</th>
                                                    <th>Date</th>
                                                    <th>Product</th>
                                                    <th>Review Star</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody >
                                                <?php $i=1;?>
                                                @foreach($result as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{ $value->created_at }}</td>
                                                    <td><a href="{{ URL::to('product/'.$value->slug)}}" target="_blank">{{ $value->product_name }}</a></td>
                                                    <td>{{ $value->review_star." Star" }}</td>
                                                    <td>
                                                        <div class="custom-control custom-switch custom-control-inline mb-1">
                                                            <input type="checkbox" class="custom-control-input changeSupplierReviewStatus" <?php if($value->status == 0){ echo ''; }else{ echo 'checked'; } ?> getreviewid="{{$value->id}}" id="customSwitch{{$value->id}}">
                                                            <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="invoice-action">
                                                            <a onclick="viewReviewDetails(event, '{{$value->id}}')" href="#" class="invoice-action-edit cursor-pointer" title="details">
                                                                <i style="font-size:25px;" class="bx bx-edit"></i>
                                                            </a>
                                                            <a onclick="deleteSupplierReview('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
                                                                <i style="font-size:25px;" class="bx bx-trash"></i>
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
                <div class="modal fade" id="review_modal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Review Details</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['id' =>'addTicketReply','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body" id="reviewDetails">

                                    </div>
                                {!! Form::close() !!}
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
    $(function(){
        $('body').on('click', '.changeSupplierReviewStatus', function (e) {
            e.preventDefault();

            var review_id = $(this).attr('getreviewid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/changeSupplierReviewStatus') }}",
                'type':'post',
                'dataType':'text',
                data:{review_id:review_id},
                success:function(data)
                {
                    if(data == "success"){
                        toastr.success('Thanks !! Review status change Successfully', { positionClass: 'toast-bottom-full-width', });
                        setTimeout(function(){
                            location.reload() ;
                        }, 3000);
                        return false;
                    }else{
                        toastr.error('Thanks !! Sorry Somthing Went Wrong', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                }
            });

        })
    });

    function viewReviewDetails(event, id) {
        event.preventDefault() ;

        $("#review_modal").modal('show') ;

       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/getSupplierReviewDetails') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data)
            {
                console.log(data) ;
                $("#reviewDetails").empty().html(data) ;
            }
        }); 
    }

    function deleteSupplierReview(id) {

        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/deleteSupplierReview') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){

                    if (data == "success") {
                        toastr.error('Thanks !! You have Delete the review', { positionClass: 'toast-bottom-full-width', });
                        setTimeout(function(){
                            location.reload() ;
                        }, 3000);
                        return false;
                    }else{
                        toastr.error('Sorry !! Review Not Delete', { positionClass: 'toast-bottom-full-width', });
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