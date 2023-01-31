@extends('supplier.masterSupplier')
@section('title','Supplier Message Inbox')
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
                                    <h4 class="card-title">Message Inbox</h4>
                                
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
                                                        <th>Supplier Name</th>
                                                        <th>Product</th>
                                                        <th>Subject</th>
                                                        <th>Message</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                    
                                                    <?php foreach ($result as $key=>$value): ?>
                                                       <?php $total_sender_message_count = DB::table('tbl_quotation_reply')
                                                            ->join('tbl_supplier_quotation', 'tbl_quotation_reply.message_id', '=', 'tbl_supplier_quotation.id')
                                                            ->select('tbl_quotation_reply.*', 'tbl_supplier_quotation.customer_id')
                                                            ->where('tbl_quotation_reply.receiver_id', Session::get('supplier_id'))
                                                            ->where('tbl_supplier_quotation.customer_id', Session::get('supplier_id'))
                                                            ->where('tbl_quotation_reply.message_id', $value->id)
                                                            ->where('tbl_quotation_reply.receiver_status', 0)
                                                            ->count() ; ?>
                    
                                                        <tr>
                                                            <td>
                                                                <a href="#">{{ $key+1 }}</a>
                                                            </td>
                                                            <td><small class="text-muted">{{ $value->created_at }}</small></td>
                                                            <td><small class="text-muted"><?php if($value->type == 2){echo $value->storeName; }else{echo $value->first_name." ".$value->last_name; } ?></small></td>
                                                            <td><small class="text-muted"><a href="{{ URL::to('product/'.$value->slug) }}" target="_new">{{ Str::limit($value->product_name, 20) }}</a></span></td>
                                                            <td><span class="invoice-customer">{{ $value->subject }}</span></td>
                                                            <td>
                                                                 <div class="position-relative d-inline-block mr-2">
                                                                     <a class="btn btn-success btn-sm" onclick="getSupplerInobxQuotationDetails({{ $value->id }})">Message </a>
                                                                    <span class="badge badge-pill badge-primary badge-up badge-round"><?php echo $total_sender_message_count; ?></span>
                                                                  </div>
                                                            </td>
                                                        </tr>
                                                        
                                                    <?php endforeach; ?>
                    
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
    var quation_id_main = null ;
    function getSupplerInobxQuotationDetails(quation_id){
        quation_id_main = quation_id ;
        
        $(".chat_main_box #chatbox_s"+quation_id_main).animate({ scrollTop: 9999999 }, 'slow');
        console.log(quation_id_main) ;
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/getSupplerInobxQuotationDetails') }}",
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
    
    function supplierInboxChatMessagesSend(event, quation_id){
        event.preventDefault() ;
        
        var replyMessage = $(".chat-message-send").val() ;
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/supplierInboxChatMessagesSend') }}",
            'type':'post',
            'dataType':'text',
            data:{quation_id:quation_id, replyMessage:replyMessage},
            success:function(data)
            {
                console.log(data) ;
                $("#editModal").modal('show') ;
                $(".quation_reply").empty().html(data);
                 $(".chat_main_box #chatbox_s"+quation_id_main).animate({ scrollTop: 9999999 }, 'slow');
                $(".chat-message-send").val("");
            }
        });
        
    }
    //     var startInterval = setInterval(function () {
    //     console.log(quation_id_main) ;
    //     if(quation_id_main > 0){
    //         $.ajaxSetup({
    //             headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }
    //         });
        
    //         $.ajax({
    //             'url':"{{ url('/getunreadsupplierinboxquotationmessagecount') }}",
    //             'type':'post',
    //             'dataType':'text',
    //             data:{receiver_id: quation_id_main},
    //             success:function(data)
    //             {
    //                 if(data == "load"){
    //                     $.ajax({
    //                         'url':"{{ url('/getunreadsupplierinboxquotationmessage') }}",
    //                         'type':'post',
    //                         'dataType':'text',
    //                         data:{receiver_id: quation_id_main},
    //                         success:function(data)
    //                         {
    //                             console.log(data) ;
    //                             var chatbox = "chatbox_s"+quation_id_main ;
    //                             $("#"+chatbox).empty().html(data);
    //                              $(".chat_main_box #chatbox_s"+quation_id_main).animate({ scrollTop: 9999999 }, 'slow');
    //                         }
    //                     });
    //                 }
                    
    
    //             }
    //         });
    //     }
        
    
    // }, 1000);

    // //Clearing interval
    // var countInterval = startInterval != undefined ? startInterval : 0;
    
    //  for (var a = 0; a < countInterval; a++) {
    //   clearInterval(a);
    //  }

        

</script>
@endsection