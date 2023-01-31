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
							<h4 class="card-title">Sub-Menu List</h4>
							<div class="card">
								<div class="card-header">

									<a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#addModal" > +Add Sub-Menu</a>

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
	                            <h3 class="modal-title" id="myModalLabel1">Add Sub-Menu</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'insertSubMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Select MenuS<span style="color:red;">*</span></label>
                                            </div>
                                            
                                            <div class="col-md-8 form-group">
                                                <select class="form-control" id="menu_id">
                                                	<option value="">Select Menu</option>
													<?php foreach ($all_primarycategory as $value) { ?>
														<option value="<?php echo $value->id ; ?>" ><?php echo $value->menu_name ; ?></option>
													<?php } ?>
												</select>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Sub-Menu <span style="color:red;">*</span></label>
                                            </div>

                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control sub_menu_name" name="sub_menu_name" required="">
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
	                            <h3 class="modal-title" id="myModalLabel1">Update Sub-Menu</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'updateSubMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body" id="subMenuEdit">

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
		$(document).ready(function(){

		    $.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });
		    $.ajax({
		        'url':"{{ url('/getAllSubMenuData') }}",
		        'type':'post',
		        'dataType':'text',
		        success:function(data){
		            $("#body_data").empty();
		            $("#body_data").html(data);
		        }
		    });
	    });

	    $('body').on('submit', '#insertSubMenuInfo', function (e) {
        e.preventDefault();

	        var menu_id = $("#menu_id").val() ;
	        var sub_menu_name = $('[name="sub_menu_name"]').val() ;

	        if (menu_id == "") {
	            toastr.info('Oh shit!! Select Menu First', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }

	        if (sub_menu_name == "") {
	            toastr.info('Oh shit!! Please Input Sub-Menu Name', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }

	        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	        });
	        $.ajax({
	            'url':"{{ url('/insertSubMenuInfo') }}",
	            'type':'post',
	            'dataType':'text',
	            data: {menu_id: menu_id,sub_menu_name: sub_menu_name},
	            success:function(data){
	                if (data == "success") {
	                    $.ajax({
					        'url':"{{ url('/getAllSubMenuData') }}",
					        'type':'post',
					        'dataType':'text',
					        success:function(data){
					            $("#body_data").empty();
					            $("#body_data").html(data);
					        }
					    });

					    $("#addModal").modal('hide');
	                    toastr.success('Thanks !! Sub-Menu Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

	                    return false;
	                }else if(data == "failed"){
	                    toastr.error('Sorry !! Sub-Menu Not Added', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }else if(data == "duplicate_found"){
	                    toastr.error('Sorry !! Sub-Menu Name Already Exist', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }
	            }
	        });

	    });

	    $(function(){
            $('body').on('click', '.changeSubMenuStatus', function (e) {
                e.preventDefault();

                var sub_menu_id = $(this).attr('getSubMenuid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changeSubMenuStatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{sub_menu_id:sub_menu_id},
                    success:function(data)
                    {
                    	$.ajax({
					        'url':"{{ url('/getAllSubMenuData') }}",
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
		


	    $('body').on('submit', '#updateSubMenuInfo', function (e) {
	        e.preventDefault();

			var menu_id           = $("#mainmenu").val() ;
            var primary_id          = $("[name=primary_id]").val() ;
            var sub_menu_name       = $("#sub_menu_name").val() ;

            if (menu_id == "") {
                toastr.info('Oh shit!! Select Menu First', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            if (sub_menu_name == "") {
                toastr.info('Oh shit!! Please Input Sub-Menu Name', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

	        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	        });
	        $.ajax({
	            'url':"{{ url('/updateSubMenuInfo') }}",
	            'type':'post',
	            'dataType':'text',
	            data: {menu_id: menu_id,sub_menu_name: sub_menu_name,primary_id:primary_id},
	            success:function(data){
	            	$.ajax({
				        'url':"{{ url('/getAllSubMenuData') }}",
				        'type':'post',
				        'dataType':'text',
				        success:function(data){
				            $("#body_data").empty();
				            $("#body_data").html(data);
				          
				        }
				    });
				    $("#editModal").modal('hide') ;
	                if (data == "success") {
	                    toastr.success('Thanks !! Sub-Menu Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

	                    return false;
	                }else if(data == "failed"){
	                    toastr.error('Sorry !! Sub-Menu Not Updated', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }else if(data == "duplicate_found"){
	                    toastr.error('Sorry !! Sub-Menu Name Already Exist', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }
	            }
	        });

	    });

		function deleteSubMenu(id) {

		var r = confirm("Are You Sure To Delete It!");
		if (r == true) {
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });

		    $.ajax({
		        'url':"{{ url('/subMenuDelete') }}",
		        'type':'post',
		        'dataType':'text',
		        data:{id:id},
		        success:function(data){

		        	if (data == "success") {
		        		$.ajax({
					        'url':"{{ url('/getAllSubMenuData') }}",
					        'type':'post',
					        'dataType':'text',
					        success:function(data){
					            $("#body_data").empty();
					            $("#body_data").html(data);
					          
					        }
					    });

		                toastr.error('Thanks !! You have Delete the Sub-Menu', { positionClass: 'toast-bottom-full-width', });
		                return false;
		        	}else if(data == "cused"){
                        toastr.error('Sorry !! Sub-Menu Name Already Used', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
		        		toastr.error('Sorry !! Sub-Menu Not Delete', { positionClass: 'toast-bottom-full-width', });
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
                'url':"{{ url('/editSubMenu') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                	
                	$("#subMenuEdit").empty().html(data) ;

                }
            });
        }
	</script>

@endsection