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

							<h4 class="card-title">Sub Sub-Menu List</h4>

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
	            <div class="modal fade" id="adddoublesubmenu" role="dialog">
	                <div class="modal-dialog">
	                    <!-- Modal content-->
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h3 class="modal-title" id="myModalLabel1">Add Sub Sub-Menu</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'insertSubSubMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Select Menu<span style="color:red;">*</span></label>
                                            </div>
                                            
                                            <div class="col-md-8 form-group">
                                                <select class="form-control mainmenu" id="mainmenu" name="menu_name">
                                                    <option value="">Select Menu</option>
                                                    <?php foreach ($menu as $value) { ?>
                                                        <option value="<?php echo $value->id ; ?>" ><?php echo $value->menu_name ; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Select Sub-Menu<span style="color:red;">*</span></label>
                                            </div>
                                            
                                            <div class="col-md-8 form-group">
                                                <select class="form-control secondary_menu" id="secondary_menu" name="sub_menu_name">
													
												</select>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Sub Sub-Menu<span style="color:red;">*</span></label>
                                            </div>

                                            <div class="col-md-8 form-group">
                                                <input type="text" class="form-control sub_sub_menu_name" name="sub_sub_menu_name" required="">

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
	                    <div class="modal-content">
	                        <div class="modal-header">
	                            <h3 class="modal-title" id="myModalLabel1">Update Sub Sub-Menu</h3>
	                            <button type="button" class="close" data-dismiss="modal">&times;</button>

	                        </div>
	                        <div class="modal-body">

	                        	{!! Form::open(['id' =>'updateSubSubMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body" id="menuThreeEdit">

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
		        'url':"{{ url('/getAllSubSubMenuData') }}",
		        'type':'post',
		        'dataType':'text',
		        success:function(data){
		            $("#body_data").empty();
		            $("#body_data").html(data);
		          
		        }
		    });

	    });

	    $('body').on('change', '.mainmenu', function (e) {
        e.preventDefault();
            var menu_id = $(this).val() ;
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/getSubMenuByMenu') }}",
                'type':'post',
                'dataType':'text',
                data: {menu_id: menu_id},
                success:function(data){
                  $(".secondary_menu").empty().html(data) ;
                }
            });

        });

        $('body').on('submit', '#insertSubSubMenuInfo', function (e) {
        e.preventDefault();

	        var menu_id    = $("#mainmenu").val() ;
	        var sub_menu_id  = $("#secondary_menu").val() ;
	        var sub_sub_menu_name    = $("[name=sub_sub_menu_name]").val() ;


	        if (menu_id == "") {
                toastr.info('Oh shit!! Select Menu First', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            if (sub_menu_id == "") {
	            toastr.info('Oh shit!! Select Sub-Menu First', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }

	        if (sub_sub_menu_name == "") {
	            toastr.info('Oh shit!! Please Input Sub Sub-Menu', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }

	        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	        });
	        $.ajax({
	            'url':"{{ url('/insertSubSubMenuInfo') }}",
	            'type':'post',
	            'dataType':'text',
	            data: {menu_id: menu_id,sub_menu_id: sub_menu_id, sub_sub_menu_name:sub_sub_menu_name},
	            success:function(data){

	                if (data == "success") {

	                    $.ajax({
					        'url':"{{ url('/getAllSubSubMenuData') }}",
					        'type':'post',
					        'dataType':'text',
					        success:function(data){
					            $("#body_data").empty();
					            $("#body_data").html(data);
					          
					        }
					    });

					    $("#addModal").modal('hide');
	                    toastr.success('Thanks !! Sub Sub-Menu Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

	                    return false;
	                }else if(data == "failed"){
	                    toastr.error('Sorry !! Sub Sub-Menu Not Added', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }else if(data == "duplicate_found"){
	                    toastr.error('Sorry !! Sub Sub-Menu Already Exist', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                }
	            }
	        });

	    });

	    $(function(){
            $('body').on('click', '.changeSubSubMenuStatus', function (e) {
                e.preventDefault();

                var sub_sub_menu_id = $(this).attr('getSubSubMenuid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changeSubSubMenuStatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{sub_sub_menu_id:sub_sub_menu_id},
                    success:function(data)
                    {
                    	$.ajax({
					        'url':"{{ url('/getAllSubSubMenuData') }}",
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
		


	    $('body').on('submit', '#updateSubSubMenuInfo', function (e) {
	        e.preventDefault();

	        var primary_id 			= $("[name=primary_id]").val() ;
            var menu_id = $(".menuone").val() ;
	        var sub_menu_id  = $(".menutwo").val() ;
	        var sub_sub_menu_name   = $("#lastmenu").val() ;


			if (menu_id == "") {
                toastr.info('Oh shit!! Select Menu First', { positionClass: 'toast-bottom-full-width', });
                return false;
            }

            if (sub_menu_id == "") {
	            toastr.info('Oh shit!! Select Sub-Menu Category First', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }

	        if (sub_sub_menu_name == "") {
	            toastr.info('Oh shit!! Please Input Sub Sub-Menu Name', { positionClass: 'toast-bottom-full-width', });
	            return false;
	        }


	        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
	        });
	        $.ajax({
	            'url':"{{ url('/updateSubSubMenuInfo') }}",
	            'type':'post',
	            'dataType':'text',
	            data: {menu_id: menu_id,sub_menu_id: sub_menu_id, sub_sub_menu_name:sub_sub_menu_name, primary_id:primary_id},
	            success:function(data){
	            	$.ajax({
				        'url':"{{ url('/getAllSubSubMenuData') }}",
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

		function deleteSubSubMenu(id) {

		var r = confirm("Are You Sure To Delete It!");
		if (r == true) {
			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
		    });

		    $.ajax({
		        'url':"{{ url('/subSubMenuDelete') }}",
		        'type':'post',
		        'dataType':'text',
		        data:{id:id},
		        success:function(data){

		        	if (data == "success") {
		        		$.ajax({
					        'url':"{{ url('/getAllSubSubMenuData') }}",
					        'type':'post',
					        'dataType':'text',
					        success:function(data){
					            $("#body_data").empty();
					            $("#body_data").html(data);
					        }
					    });

		                toastr.error('Thanks !! You have Delete the Sub Sub-Menu', { positionClass: 'toast-bottom-full-width', });
		                return false;
		        	}else{
		        		toastr.error('Sorry !! Sub Sub-Menu Not Delete', { positionClass: 'toast-bottom-full-width', });
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
                'url':"{{ url('/editSubSubMenu') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                	console.log(data) ;
                	$("#menuThreeEdit").empty().html(data) ;

                }
            });
        }
	</script>

@endsection