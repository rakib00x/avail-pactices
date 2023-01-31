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

							<h4 class="card-title">All Logo & Favicon List</h4>

							<div class="card">
								<div class="card-header">

									<a role="button" class="float-right btn btn-primary btn-md" href="" id="addCategory">+ Add Logo</a>

								</div>

								<div class="card-content" id="body_data">

									<div class="card-body card-dashboard">
									    <div class="table-responsive">
									        <table class="table zero-configuration">
									            <thead>
									                <tr>
									                    <th>SN</th>
									                    <th>Logo</th>
									                    <th>Icon</th>
									                    <th>Status</th>
									                    <th>Action</th>
									                </tr>
									            </thead>
									            
									            <tbody>
									                
									                <?php $i=1;?>
									                @foreach($settings as $value)
									                    <tr>
									                        <td>{{$i++}}</td>
									                        <td><img src="{{ URL::to('public/images/'.$value->logo) }}" alt="" style="width: 75px;height: 33px;"></td>
									                        <td><img src="{{ URL::to('public/images/'.$value->favicon) }}" alt="" style="width: 75px;height: 33px;"></td>
									                        <td>
									                            <div class="custom-control custom-switch custom-control-inline mb-1">
									                                <input type="checkbox" class="custom-control-input changeCategoryStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getCurrencyid="{{$value->id}}" id="customSwitch{{$value->id}}">
									                                <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
									                            </div>
									                        </td>
									                        <td>
									                            <div class="invoice-action">
									                                <a onclick="edit('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editModal" href="" class="invoice-action-edit cursor-pointer">
									                                    <i style="font-size:25px;" class="bx bx-edit"></i>
									                                </a>
									                                <a onclick="deleteCurrency('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
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
	            <div class="modal fade" id="addModal" role="dialog">
	                <div class="modal-dialog">
	                    <!-- Modal content-->
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h3 class="modal-title" id="myModalLabel1">Add Site Settings</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'insertSiteSettingInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
									<div class="form-body">
										<div class="row">

											<div class="col-12">
												
												<div class="form-group">
													<label for="first-name-vertical">Logo</label>
													<input type="file" class="form-control" name="logo" required="">
												</div>
											</div>
											<div class="col-12">
												
												<div class="form-group">
													<label for="first-name-vertical">Favicon </label>
													<input value="" type="file"  class="form-control" name="favicon" required="">
												</div>
											</div>

											<div class="col-12 d-flex justify-content-end">
												<button type="submit" class="btn btn-primary mr-1 mb-1">Add</button>
											</div>
										</div>
									</div>
                                {!! Form::close() !!}

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
	                            <h3 class="modal-title" id="myModalLabel1">Update Site Settings</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'updateSiteSettings','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body" id="mainCategoryEditForm">

                                    </div>
                                {!! Form::close() !!}

	                <!-- Nav Filled Ends -->
	                        </div>
	                        
	                    </div>
	                </div>
	            </div>


            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#home-fill" role="tab" aria-controls="home-fill" aria-selected="true">
                                        Select File
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-fill" data-toggle="tab" href="#profile-fill" role="tab" aria-controls="profile-fill" aria-selected="false">
                                        Upload File
                                    </a>
                                </li>
                            </ul>

                            <input type="text" name="search_keyword" id="search_keyword" class="form-control col-md-4" placeholder="Search">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body">
                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
                                <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                    <div class="row " id="table_data">


                                    </div>
                                </div>
                                <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                    <form method="post"  action="{{url('image/upload/store')}}" enctype="multipart/form-data" 
                                    class="dropzone" id="dropzone">
                                    @csrf
                                </form>   
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-default" id="saveImage">Save</button>
                                </div>
                            </div>

                        </div>
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
<!-- Alert Assets -->
	<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
	<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('body').on('click', '#myBtn', function (e) {
            $("#myModal").modal();
            return false ;
        });

        $('body').on('click', '#addCategory', function (e) {
            $("#addModal").modal();
            return false ;
        });


    });

</script>
	<!-- Delete Section Start Here -->
	<script type="text/javascript">

	    $('body').on('submit', '#insertSiteSettingInfo', function (e) {
        e.preventDefault();


		    let myForm = document.getElementById('insertSiteSettingInfo');
	        let formData = new FormData(myForm);


	        $.ajaxSetup({
	            headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	        });
	        
	        $.ajax({
	            'url':"{{ url('/insertSiteSettingInfo') }}",
	            'data': formData,
	            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
	            'contentType': false,
	            'type': 'POST',
	            success: function(data) {
	                if (data) {
	                    toastr.success('Logo And Favicon Add Successfully', { positionClass: 'toast-bottom-full-width', });
	                    setTimeout(function(){
	                        location.reload();
	                    }, 3000);
	                    return false ;
	                }
	            }
	        });

	    });

	    $(function(){
            $('body').on('click', '.changeCategoryStatus', function (e) {
                e.preventDefault();

                var setting_id = $(this).attr('getCurrencyid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changeSiteSetttingstatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{setting_id:setting_id},
                    success:function(data)
                    {
                        if(data == "success"){
                            toastr.success('Thanks !! Status Change Successfully', { positionClass: 'toast-bottom-full-width', });
                            setTimeout(function(){
		                        location.reload();
		                    }, 3000);
                            return false;
                        }else{
                            toastr.error('Sorry !! Already Have A active logo and Favicon. Please Deactive first', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }
                    }
                });

			})
		});
		


	    $('body').on('submit', '#updateSiteSettings', function (e) {
	        e.preventDefault();

	        let myForm = document.getElementById('updateSiteSettings');
	        let formData = new FormData(myForm);


	        $.ajaxSetup({
	            headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	            }
	        });
	        
	        $.ajax({
	            'url':"{{ url('/updateSiteSettings') }}",
	            'data': formData,
	            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
	            'contentType': false,
	            'type': 'POST',
	            success: function(data) {
	                if (data) {
	                    toastr.success('Logo And Favicon Update Successfully', { positionClass: 'toast-bottom-full-width', });
	                    setTimeout(function(){
	                        location.reload();
	                    }, 3000);
	                    return false ;
	                }
	            }
	        });

	    });

		function deleteCurrency(id) {

		var r = confirm("Are You Sure To Delete It!");
		if (r == true) {
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });

		    $.ajax({
		        'url':"{{ url('/deleteSettingLogo') }}",
		        'type':'post',
		        'dataType':'text',
		        data:{id:id},
		        success:function(data){

		        	if (data == "success") {
		                toastr.error('Thanks !! Delete Successfully', { positionClass: 'toast-bottom-full-width', });
		                setTimeout(function(){
	                        location.reload();
	                    }, 3000);
		                return false;
		        	}
		        	
		        }
		    });
			} else {
				toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
		        return false;
			}
        }

        function edit(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/editSiteSettings') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                	
                	$("#mainCategoryEditForm").empty().html(data) ;

                }
            });
        }
	</script>

@endsection