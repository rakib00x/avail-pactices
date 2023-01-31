@extends('supplier.masterSupplier')
@section('content')
	<div class="app-content content">
		<div class="content-wrapper">
			<div class="content-body">
				<section id="basic-datatable">
					<div class="row">


						<div class="col-12">

							<h4 class="card-title">Secondary Category List</h4>

							<div class="card">

								<div class="card-header">

									<a role="button" class="float-right btn btn-primary btn-md" href="" id="addCategory">+ Add Secondary Category</a>

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
	                            <h3 class="modal-title" id="myModalLabel1">Add Main Category</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'insertCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Select Category<span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <select class="form-control" name="main_category_id" required="">
                                                	<?php foreach ($result as $privalue) { ?>
                                                		<option value="<?php echo $privalue->id; ?>"><?php $privalue->category_name; ?></option>
                                                	<?php } ?>
                                                    
                                                </select>
                                            </div>                                            

                                            <div class="col-md-4">
                                                <label>Category Name<span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control" name="category_name" required="">
                                            </div>


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
	                            <h3 class="modal-title" id="myModalLabel1">Update Main Category</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'updatePrimaryCategoryInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body" id="mainCategoryEditForm">
                                    	<div class="row">
                                            <div class="col-md-4">
                                                <label>Category Name<span style="color:red;">*</span></label>
                                            </div>
                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control category_name" name="category_name" required="">
                                            </div>

                                            <input type="hidden" class="primary_id" name="primary_id" >

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

		$('body').on('click', '#addSecondaryCategory', function (e) {
	        $("#addModal").modal();
	        return false ;
	    });

		$(document).ready(function(){

		    $.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });
		    $.ajax({
		        'url':"{{ url('/getSupplierSecondaryCategory') }}",
		        'type':'post',
		        'dataType':'text',
		        success:function(data){
		            $("#body_data").empty();
		            $("#body_data").html(data);
		          
		        }
		    });

	    });

	    $('body').on('submit', '#insertCategoryInfo', function (e) {
        e.preventDefault();

	        var main_category_id 	= $('[name="main_category_id"]').val() ;
	        var category_name 		= $('[name="category_name"]').val() ;

	        if (main_category_id == "" || main_category_id == undefined) {
	            toastr.info('Oh shit!! Please Input Category Name', { positionClass: 'toast-bottom-full-width', });
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
	            'url':"{{ url('/insertSupplierPrimaryCategoryInfo') }}",
	            'type':'post',
	            'dataType':'text',
	            data: {category_name: category_name},
	            success:function(data){

	                if (data == "success") {

	                    $.ajax({
					        'url':"{{ url('/getSupplierSecondaryCategory') }}",
					        'type':'post',
					        'dataType':'text',
					        success:function(data){
					            $("#body_data").empty();
					            $("#body_data").html(data);
					          
					        }
					    });

					    $("#addModal").modal('hide');
	                    toastr.success('Thanks !! Primary Category Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

	                    return false;
	                }else if(data == "failed"){
	                    toastr.error('Sorry !! Primary Category Not Added', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }else if(data == "duplicate_found"){
	                    toastr.error('Sorry !! Primary Category Already Exist', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }else{
	                    toastr.info('Oh shit!! Category Name And Category Icon Can not be empty', { positionClass: 'toast-bottom-full-width', });
	                    return false;
	                }
	              
	            }
	        });

	    });

	    $(function(){
            $('body').on('click', '.changeSupplierCategoryStatus', function (e) {
                e.preventDefault();

                var category_id = $(this).attr('getCurrencyid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changeSupplierCategoryStatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{category_id:category_id},
                    success:function(data)
                    {
                    	$.ajax({
					        'url':"{{ url('/getSupplierSecondaryCategory') }}",
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
		


	    $('body').on('submit', '#updatePrimaryCategoryInfo', function (e) {
	        e.preventDefault();

	        var category_name 	= $(".category_name").val() ;
	        var primary_id 		= $("[name=primary_id]").val() ;

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
	            'url':"{{ url('/updateSupplierPrimaryCategoryInfo') }}",
	            'type':'post',
	            'dataType':'text',
	            data: {category_name: category_name, primary_id:primary_id},
	            success:function(data){
	            	$.ajax({
				        'url':"{{ url('/getSupplierSecondaryCategory') }}",
				        'type':'post',
				        'dataType':'text',
				        success:function(data){
				            $("#body_data").empty();
				            $("#body_data").html(data);
				          
				        }
				    });
				    $("#editModal").modal('hide') ;
	                if (data == "success") {
	                    toastr.success('Thanks !! Primary Category Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });
	                    return false;
	                }else if(data == "failed"){
	                    toastr.error('Sorry !! Primary Category Not Updated', { positionClass: 'toast-bottom-full-width', });
	                    return false;
	                }else if(data == "duplicate_found"){
	                    toastr.error('Sorry !! Primary Category Name Already Exist', { positionClass: 'toast-bottom-full-width', });
	                    return false;
	                }else{
	                    toastr.info('Oh shit!! Category Name And Category Icon Can not be empty', { positionClass: 'toast-bottom-full-width', });
	                    return false;
	                }
	              
	            }
	        });

	    });

		function deleteMainCategory(id) {

		var r = confirm("Are You Sure To Delete It!");
		if (r == true) {
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });

		    $.ajax({
		        'url':"{{ url('/supplierPrimaryCategoryDelete') }}",
		        'type':'post',
		        'dataType':'text',
		        data:{id:id},
		        success:function(data){

		        	if (data == "success") {
		        		$.ajax({
					        'url':"{{ url('/getSupplierSecondaryCategory') }}",
					        'type':'post',
					        'dataType':'text',
					        success:function(data){
					            $("#body_data").empty();
					            $("#body_data").html(data);
					          
					        }
					    });

		                toastr.error('Thanks !! You have Delete the Primary Category', { positionClass: 'toast-bottom-full-width', });
		                return false;
		        	}else if(data == "cused"){
                        toastr.error('Sorry !! Primary Category Already Used', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
		        		toastr.error('Sorry !! Primary Category Not Delete', { positionClass: 'toast-bottom-full-width', });
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
                'url':"{{ url('/getSupplierCategoryById') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                	var values = data.split("-");
                	$(".category_name").val(values[0]) ;
                	$(".primary_id").val(values[1]) ;
                }
            });
        }
	</script>

@endsection