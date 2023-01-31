@extends('seller.seller-master')
@section('title','Seller Message List')
@section('content')
<style>
    @media screen and (min-width: 992px){
        .modal-dialog {
            max-width: 1000px!important;
        }
    }
</style>
 <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Message List</h4>
                                
                                </div>
                                <div class="card-content">
                                    <div class="card-body card-dashboard">

                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <span>SL#</span>
                                                        </th>
                                                        <th>Date</th>
                                                        <th>Customer Name</th>
                                                        <th>Product</th>
                                                        <th>Subject</th>
                                                        <th>Message</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                    
                                                    <?php foreach ($result as $key=>$value): ?>
                                                       <?php
                                                            $total_receive_message_count = DB::table('tbl_quotation_reply')
                                                                ->join('tbl_supplier_quotation', 'tbl_quotation_reply.message_id', '=', 'tbl_supplier_quotation.id')
                                                                ->select('tbl_quotation_reply.*', 'tbl_supplier_quotation.supplier_id')
                                                                ->where('tbl_quotation_reply.receiver_id', Session::get('supplier_id'))
                                                                ->where('tbl_supplier_quotation.supplier_id', Session::get('supplier_id'))
                                                                ->where('tbl_quotation_reply.message_id', $value->id)
                                                                ->where('tbl_quotation_reply.receiver_status', 0)
                                                                ->count() ;
                                                       ?>
                                                        <tr>
                                                            <td>
                                                                <a href="#">{{ $key+1 }}</a>
                                                            </td>
                                                            <td><small class="text-muted">{{ $value->created_at }}</small></td>
                                                            <td><small class="text-muted"><?php if($value->type == 2){echo $value->storeName; }else{echo $value->first_name." ".$value->last_name; } ?></small></td>
                                                            <td><small class="text-muted"><a href="{{ URL::to('product/'.$value->slug) }}" target="_new">{{ $value->product_name }}</a></span></td>
                                                            <td><span class="invoice-customer">{{ $value->subject }}</span></td>
                                                             <td>
                                                                 <div class="position-relative d-inline-block mr-2">
                                                                     <a class="btn btn-success btn-sm" onclick="getQuotationDetails({{ $value->id }})">Message </a>
                                                                    <span class="badge badge-pill badge-primary badge-up badge-round"><?php echo $total_receive_message_count; ?></span>
                                                                  </div>
                                                            </td>
                                                        </tr>
                                                        
                                                    <?php endforeach ?>
                    
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
                <div class="modal fade" id="editModal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Quotation Details</h3>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>

                            </div>
                            <div class="modal-body" id="qutation_details">

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
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
        setTimeout(function(){
            location.reload();
        }, 3000);
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;

        case 'failed':
        toastr.error("{{ Session::get('message') }}");
        break;
    }
    @endif
</script>

<script>
    var quation_id_main = null;
    function getQuotationDetails(quation_id){
        quation_id_main = quation_id;
        
        $(".chat_main_box #chatbox_"+quation_id_main).animate({ scrollTop: 9999999 }, 'slow');
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/getQuotationDetails') }}",
            'type':'post',
            'dataType':'text',
            data:{quation_id:quation_id},
            success:function(data)
            {
                $("#editModal").modal('show') ;
                $("#qutation_details").empty().html(data);
            }
        });
    }
    
    function chatMessagesSend(event, quation_id){
        event.preventDefault() ;
        
        var replyMessage = $(".chat-message-send").val() ;
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/supplierSendQuotationReply') }}",
            'type':'post',
            'dataType':'text',
            data:{quation_id:quation_id, replyMessage:replyMessage},
            success:function(data)
            {
                $("#editModal").modal('show') ;
                $(".quation_reply").empty().html(data);
                $(".chat_main_box #chatbox_"+quation_id_main).animate({ scrollTop: 9999999 }, 'slow');
                $(".chat-message-send").val("");
            }
        });
        
    }
    
</script>
@endsection