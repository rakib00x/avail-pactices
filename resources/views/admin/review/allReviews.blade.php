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
                                                    <th>Supplier</th>
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
                                                    <td>
                                                        {{ $value->first_name." ".$value->last_name }}
                                                        <br>
                                                        {{ $value->storeName }}
                                                    </td>
                                                    <td><a href="{{ URL::to('product/'.$value->slug) }}" title="{{ Str::limit($value->product_name, 20) }}" target="_new">{{ Str::limit($value->product_name, 20) }}</a></td>
                                                    <td>{{ $value->review_star." Star" }}</td>
                                                    <td>
                                                        <div class="badge badge-pill badge-light-<?php if($value->status == 0){ echo 'warning'; }else{ echo 'success'; } ?> mr-1"><?php if($value->status == 0){ echo 'Pending'; }else{ echo 'Approve'; } ?></div>
                                                    </td>
                                                    <td>
                                                        <div class="invoice-action">
                                                            <a onclick="viewAdminReviewDetails(event, '{{$value->id}}')" href="#" class="invoice-action-edit cursor-pointer" title="details">
                                                                <i style="font-size:25px;" class="bx bx-edit"></i>
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

    function viewAdminReviewDetails(event, id) {
        event.preventDefault() ;

        $("#review_modal").modal('show') ;

       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/getAdminReviewDetails') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data)
            {
                $("#reviewDetails").empty().html(data) ;
            }
        }); 
    }

</script>

@endsection