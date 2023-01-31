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

							<h4 class="card-title">Tertiary Category List</h4>

							<div class="card">
								<div class="card-header">
                                    <?php if(Session::get('success') != null) { ?>
									<div class="alert alert-primary alert-dismissible mb-2" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<div class="d-flex align-items-center">
											<i class="bx bx-star"></i>
											<span>
												<?php echo Session::get('success') ;  ?>
											</span>
										</div>
                                        <?php Session::put('success',null) ;  ?>
									</div>
                                    <?php } ?>

                                    <?php
                                    if(Session::get('failed') != null) { ?>
									<div class="alert alert-danger alert-dismissible mb-2" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
										<div class="d-flex align-items-center">
											<i class="bx bx-error"></i>
											<span>
												<?php echo Session::get('failed') ; ?>
											</span>
										</div>
                                        <?php echo Session::put('failed',null) ; ?>
									</div>
                                    <?php } ?>

									<a role="button" class="float-right btn btn-primary btn-md" href="{{URL::to('/addPrimaryCategory')}}" id="addCategory">+ Add Tertiary Category</a>

								</div>

								<div class="card-content" id="body_data">

									


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
	                            <h3 class="modal-title" id="myModalLabel1">Add Tertiary Category</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'insertTertiaryCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Select Priamry Category<span style="color:red;">*</span></label>
                                            </div>
                                            
                                            <div class="col-md-8 form-group">
                                                <select class="form-control primary_category" id="primary_category" name="primary_category">
                                                    <option value="">Select Category</option>
                                                    <?php foreach ($all_primarycategory as $value) { ?>
                                                        <option value="<?php echo $value->id ; ?>" ><?php echo $value->category_name ; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Select Secondary Category<span style="color:red;">*</span></label>
                                            </div>
                                            
                                            <div class="col-md-8 form-group">
                                                <select class="form-control secondary_category" id="secondary_category" name="secondary_category">
													
												</select>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Category Name<span style="color:red;">*</span></label>
                                            </div>

                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control" name="category_name" required="">
                                            </div>

                                            <br>
                                            <br>
                                            <br>

                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
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
	                            <h3 class="modal-title" id="myModalLabel1">Update Tertiary Category</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'updateTertiaryCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body" id="mainCategoryEditForm">

                                    </div>
                                {!! Form::close() !!}

	                <!-- Nav Filled Ends -->
	                        </div>
	                        
	                    </div>
	                </div>
	            </div>


				<!-- Modal -->
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
		$(document).ready(function(){

		    $.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });
		    $.ajax({
		        'url':"{{ url('/getAllTertiaryCategoryData') }}",
		        'type':'post',
		        'dataType':'text',
		        success:function(data){
		            $("#body_data").empty();
		            $("#body_data").html(data);
		          
		        }
		    });

	    });

	    $('body').on('change', '.primary_category', function (e) {
        e.preventDefault();

            var primary_category_id = $(this).val() ;


            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/getSecondaryCategoryByPrimaryCategory') }}",
                'type':'post',
                'dataType':'text',
                data: {primary_category_id: primary_category_id},
                success:function(data){
                  $(".secondary_category").empty().html(data) ;
                }
            });

        });

        $('body').on('submit', '#insertTertiaryCategoryInfo', function (e) {
        e.preventDefault();

	        var primary_category_id    = $(".primary_category").val() ;
	        var secondary_category_id  = $("[name=secondary_category]").val() ;
	        var category_name          = $("[name=category_name]").val() ;


	        if (primary_category_id == "") {
                toastr.info('Oh shit!! Select Primary Category First', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            if (secondary_category_id == "") {
	            toastr.info('Oh shit!! Select Secondary Category First', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }

	        if (category_name == "") {
	            toastr.info('Oh shit!! Please Input Category Name', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }

	        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	        });
	        $.ajax({
	            'url':"{{ url('/insertTertiaryCategoryInfo') }}",
	            'type':'post',
	            'dataType':'text',
	            data: {primary_category_id: primary_category_id,category_name: category_name, secondary_category_id:secondary_category_id},
	            success:function(data){

	                if (data == "success") {

	                    $.ajax({
					        'url':"{{ url('/getAllTertiaryCategoryData') }}",
					        'type':'post',
					        'dataType':'text',
					        success:function(data){
					            $("#body_data").empty();
					            $("#body_data").html(data);
					          
					        }
					    });

					    $("#addModal").modal('hide');
	                    toastr.success('Thanks !! Category Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

	                    return false;
	                }else if(data == "failed"){
	                    toastr.error('Sorry !! Category Not Added', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }else if(data == "duplicate_found"){
	                    toastr.error('Sorry !! Category Already Exist', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }else{
	                    toastr.info('Oh shit!! Category Name And Category Icon Can not be empty', { positionClass: 'toast-bottom-full-width', });
	                    return false;
	                }
	              
	            }
	        });

	    });

	    $(function(){
            $('body').on('click', '.changeCategoryStatus', function (e) {
                e.preventDefault();

                var category_id = $(this).attr('getCurrencyid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changeTertiaryCategoryStatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{category_id:category_id},
                    success:function(data)
                    {
                    	$.ajax({
					        'url':"{{ url('/getAllTertiaryCategoryData') }}",
					        'type':'post',
					        'dataType':'text',
					        success:function(data){
					            $("#body_data").empty();
					            $("#body_data").html(data);
					          
					        }
					    });

                        if(data == "success"){
                            toastr.success('Thanks !! The status has activated', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }else{
                            toastr.error('Thanks !! The status has deactivated', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }
                    }
                });

			})
		});
		


	    $('body').on('submit', '#updateTertiaryCategoryInfo', function (e) {
	        e.preventDefault();

	        var category_name 		= $("[siam=siam_category_name]").val() ;
	        var primary_id 			= $("[name=primary_id]").val() ;
            var primary_category_id = $("[siam=siam_main_category]").val() ;
	        var secondary_category_id  = $("[siam=siam_secondary_category]").val() ;


			if (primary_category_id == "") {
                toastr.info('Oh shit!! Select Primary Category First', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            if (secondary_category_id == "") {
	            toastr.info('Oh shit!! Select Secondary Category First', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }


	        if (category_name == "") {
	            toastr.info('Oh shit!! Please Input Category Name', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }


	        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	        });
	        $.ajax({
	            'url':"{{ url('/updateTertiaryCategoryInfo') }}",
	            'type':'post',
	            'dataType':'text',
	            data: {primary_category_id: primary_category_id,category_name: category_name, secondary_category_id:secondary_category_id, primary_id:primary_id},
	            success:function(data){
	            	$.ajax({
				        'url':"{{ url('/getAllTertiaryCategoryData') }}",
				        'type':'post',
				        'dataType':'text',
				        success:function(data){
				            $("#body_data").empty();
				            $("#body_data").html(data);
				          
				        }
				    });
				    $("#editModal").modal('hide') ;
	                if (data == "success") {
	                    toastr.success('Thanks !! Secondary Category Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

	                    return false;
	                }else if(data == "failed"){
	                    toastr.error('Sorry !! Secondary Category Not Updated', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }else if(data == "duplicate_found"){
	                    toastr.error('Sorry !! Secondary Category Name Already Exist', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }else{
	                    toastr.info('Oh shit!! Category Name And Category Icon Can not be empty', { positionClass: 'toast-bottom-full-width', });
	                    return false;
	                }
	              
	            }
	        });

	    });

		function deleteTertiaryCategory(id) {

		var r = confirm("Are You Sure To Delete It!");
		if (r == true) {
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });

		    $.ajax({
		        'url':"{{ url('/tertiaryCategoryDelete') }}",
		        'type':'post',
		        'dataType':'text',
		        data:{id:id},
		        success:function(data){

		        	if (data == "success") {
		        		$.ajax({
					        'url':"{{ url('/getAllTertiaryCategoryData') }}",
					        'type':'post',
					        'dataType':'text',
					        success:function(data){
					            $("#body_data").empty();
					            $("#body_data").html(data);
					          
					        }
					    });

		                toastr.error('Thanks !! You have Delete the Category', { positionClass: 'toast-bottom-full-width', });
		                return false;
		        	}else{
		        		toastr.error('Sorry !! Category Not Delete', { positionClass: 'toast-bottom-full-width', });
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
                'url':"{{ url('/editTertiaryCategory') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                	console.log(data) ;
                	$("#mainCategoryEditForm").empty().html(data) ;

                }
            });
        }
	</script>

@endsection