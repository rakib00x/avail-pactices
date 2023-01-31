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

							<h4 class="card-title">All Subscriber's</h4>

							<div class="card">
								<div class="card-content" >
									<div class="card-body card-dashboard">
										<div class="table-responsive">
									        <table class="table zero-configuration">
									            <thead>
									                <tr>
									                    <th>SN</th>
									                    <th>Date</th>
									                    <th>Email</th>
									                    <th>Status</th>
									                </tr>
									            </thead>

									            <tbody>
									                <?php $i=1;?>
									                @foreach($result as $value)
									                <tr>
									                    <td>{{$i++}}</td>
									                    <td>{{$value->created_at}}</td>
									                    <td>{{ $value->email }}</td>
									                    <td>
									                    	<div class="custom-control custom-switch custom-control-inline mb-1">
                                                            <input type="checkbox" class="custom-control-input changeSellerStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getCurrencyid="{{$value->id}}" id="customSwitch{{$value->id}}">
                                                            <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
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


    $('body').on('click', '.changeSellerStatus', function (e) {
        e.preventDefault();

        var subscriber = $(this).attr('getCurrencyid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changeSubscriberStatus') }}",
            'type':'post',
            'dataType':'text',
            data:{subscriber:subscriber},
            success:function(data)
            {
                
                if(data == "success"){
                    toastr.success('Thanks !! The subscriber status change successfully', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
			                url = "allsubscriber";
			                $(location).attr("href", url);
			             }, 3000);
	                    return false;
                    return false;
                    
                }else{
                    toastr.warning('Thanks !! Somthing Went Wrong', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }


            }
        });

    })
	</script>

@endsection