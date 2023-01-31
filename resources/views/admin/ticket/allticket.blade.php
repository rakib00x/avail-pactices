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

							<h4 class="card-title">All Ticket</h4>

							<div class="card">
								<div class="card-content" >
									<div class="card-body card-dashboard">
										<div class="table-responsive">
									        <table class="table zero-configuration">
									            <thead>
									                <tr>
									                    <th>SN</th>
									                    <th>Date</th>
									                    <th>Ticket Number</th>
									                    <th>Supplier</th>
									                    <th>Subject</th>
									                    <th>Status</th>
									                    <th>Reply</th>
									                </tr>
									            </thead>

									            <tbody>
									                <?php $i=1;?>
									                @foreach($result as $value)
									                <tr>
									                    <td>{{$i++}}</td>
									                    <td>{{$value->created_at}}</td>
									                    <td>{{ $value->ticket_number }}</td>
									                    <td>
									                    	{{ $value->first_name." ".$value->last_name }}
									                    </td>
									                    <td>
									                    	{{ $value->ticket_title }}
									                    </td>
									                    <td>
									                    	<?php if ($value->status == 0): ?>
									                    		Pending
									                    	<?php else: ?>
									                    		Complete
									                    	<?php endif; ?>
									                    </td>
									                    <td>
									                        <div class="invoice-action">
									                            <a onclick="ticketReply('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
									                                <i style="font-size:25px;" class="bx bx-reply-all"></i>
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
	            <div class="modal fade" id="ticket_details" role="dialog">
	                <div class="modal-dialog">
	                    <!-- Modal content-->
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h3 class="modal-title" id="myModalLabel1">Ticket Reply</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>
	                        </div>
	                        <div class="modal-body">
	                        	{!! Form::open(['id' =>'addTicketReply','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body" id="mainCategoryReply">

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
	<!-- Delete Section Start Here -->
	<script type="text/javascript">

	    $('body').on('submit', '#addTicketReply', function (e) {
        	e.preventDefault();

	        var ticket_status 	= $('[name="ticket_status"]').val() ;
	        var ticket_reply 	= $("[name=ticket_reply]").val() ;
	        var primary_id 		= $("[name=primary_id]").val() ;

	        if (ticket_status == "") {
	            toastr.info('Oh shit!! Please Select Ticket Status', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }

	        if (ticket_reply == "") {
	            toastr.info('Oh shit!! Please Input Ticket Reply', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }

	        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	        });
	        $.ajax({
	            'url':"{{ url('/insetTicketReply') }}",
	            'type':'post',
	            'dataType':'text',
	            data: {ticket_status: ticket_status, ticket_reply: ticket_reply, primary_id:primary_id},
	            success:function(data){
	                if (data == "success") {
					    $("#ticket_details").modal('hide');
	                    toastr.success('Thanks !! Ticket Reply Send Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });
	                    setTimeout(function(){
			                url = "allticket";
			                $(location).attr("href", url);
			             }, 3000);
	                    return false;
	                }else{
	                    toastr.error('Sorry !! Ticket Reply Not Send', { positionClass: 'toast-bottom-full-width', });
	                    return false;
	                }
	              
	            }
	        });

	    });


        function ticketReply(id) {
        	$("#ticket_details").modal('show')

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/getAdminTicketDetails') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                	$("#mainCategoryReply").empty().html(data) ;
                }
            });
        }
	</script>

@endsection