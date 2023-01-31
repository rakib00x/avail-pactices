@extends('admin.masterAdmin')
@section('title','Currency')
@section('content')
	<div class="app-content content">
		<div class="content-wrapper">
			<div class="content-body">
				<section id="basic-datatable">
					<div class="row">
                     

						<div class="col-12">

							<div class="card">
							    	
								<div class="card-header">
                                       <a  role="button" aria-pressed="true" data-toggle="modal" data-target="#defaultcurrency" class="float-left btn btn-primary btn-md" href="#">+ Defult Currency</a>
									<a role="button" aria-pressed="true" data-toggle="modal" data-target="#default" class="float-right btn btn-primary btn-md" href="#">+ Add Currency</a>

								</div>

								<div class="card-content" id="getCurrency">

								</div>

							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</div>

	<!-- add form -->
	<div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="myModalLabel1">Add New Currency</h3>
					<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
						<i class="bx bx-x"></i>
					</button>
				</div>
				<div class="modal-body">
					{!! Form::open(['id' =>'addCurrency', 'class'=>'form form-horizontal', 'method' => 'post', 'role' => 'form']) !!}
					<div class="form-body">

						<div class="row">

							<div class="col-12">
								<div class="form-group">
									<label for="first-name-vertical">Currency name</label>
									<input type="text"  class="form-control" name="name" placeholder="Name">
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<label for="first-name-vertical"> Currency symbol</label>
									<input type="text" class="form-control" name="symbol" placeholder="Symbol">
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<label for="first-name-vertical">Currency code</label>
									<input type="text" class="form-control" name="code" placeholder="Code">
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<label for="first-name-vertical">Exchange Rate(1 USD = ?)</label>
									<input type="text" class="form-control" name="rate" placeholder="Exchange Rate">
								</div>
							</div>

							<div class="col-12 d-flex justify-content-end">
								<button type="reset" class="btn btn-light-secondary mr-1 mb-1">RESET</button>
								<button id="currencyAdd" class="btn btn-primary mr-1 mb-1">SAVE</button>
							</div>

						</div>

					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
	
	<!-- add form -->
	<div class="modal fade text-left" id="defaultcurrency" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="myModalLabel1">Add Defult Currency</h3>
					<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
						<i class="bx bx-x"></i>
					</button>
				</div>
				<div class="modal-body">
					{!! Form::open(['id' =>'defultCurrency', 'class'=>'form form-horizontal', 'method' => 'post', 'role' => 'form']) !!}
					<div class="form-body">

						<div class="row">

							<div class="col-12">
								<div class="form-group">
									<label for="first-name-vertical">Currency name</label>
								<select name="currencyid" class="form-control">
                                  <option >Select Currency</option>
                                  @php
                                  $defcurrency = DB::table('tbl_countries')->where('profile', 1)->get(); 
                                  
                                  
                                  @endphp
                                  @foreach($defcurrency as $currencydef)
                                 <option value="{{$currencydef->id}}">{{$currencydef->currencyCode}}</option>
                                  @endforeach
                                  
                                </select>
								</div>
							</div>

							

							<div class="col-12 d-flex justify-content-end">
							<button id="defultCurrency" class="btn btn-primary mr-1 mb-1">SAVE</button>
							</div>

						</div>

					</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

	<!-- update form -->
	<div class="modal fade text-left" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h3 class="modal-title" id="myModalLabel1">Update Currency</h3>
					<button type="button" class="close rounded-pill" data-dismiss="modal" aria-label="Close">
						<i class="bx bx-x"></i>
					</button>
				</div>
				<div class="modal-body">
					{!! Form::open(['id' =>'updateCurrency', 'class'=>'form form-horizontal', 'method' => 'post', 'role' => 'form']) !!}

						<div class="form-body">
							<div class="row">

								<div class="col-12">
									<div class="form-group">
										<label for="first-name-vertical">Currency name</label>
										<input value=""  type="text" id="first-name-vertical" class="form-control" name="uname" placeholder="Name">
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="first-name-vertical"> Currency symbol</label>
										<input value="" type="text"  class="form-control" name="usymbol" placeholder=" Symbol">
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="first-name-vertical">Currency code</label>
										<input value="" type="text"  class="form-control" name="ucode" placeholder="Code">
									</div>
								</div>
								<div class="col-12">
									<div class="form-group">
										<label for="first-name-vertical">Exchange Rate(1 USD = ?)</label>
										<input value="" type="text" class="form-control" name="urate" placeholder="Exchange Rate">
									</div>
								</div>
								<input type="hidden" name="primary_id" value="">
								<div class="col-12 d-flex justify-content-end">
									<button type="submit" class="btn btn-primary mr-1 mb-1">SAVE</button>
								</div>
							</div>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js')

	<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
	<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>

	<!-- BEGIN: Page JS-->
	<script type="text/javascript">

		$(function(){
            $('body').on('click', '.changeCurrencyStatus', function (e) {
                e.preventDefault();

                var currencyid = $(this).attr('getCurrencyid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changeCurrencyStatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{currencyid:currencyid},
                    success:function(data)
                    {
                    	$.ajax({
			                'url':"{{ url('/getCurrency') }}",
			                'type':'post',
			                'dataType':'text',
			                success:function(currencyData)
			                {
								$("#getCurrency").empty();
								$("#getCurrency").html(currencyData);
			                }
			            });

                        if(data == 1){
                            toastr.success('Thanks !! The currency status has activated', 'Currency Activated Successfully !!', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }else{
                            toastr.error('Thanks !! The currency status has deactivated', 'Currency Deactivated Successfully !!', { positionClass: 'toast-bottom-full-width', });
                            return false;
                        }


                    }
                });

			})
		})

        $(function(){
            $('body').on('submit', '#addCurrency', function (e) {
                e.preventDefault();

                var name    = $('[name="name"]').val();
                var symbol  = $('[name="symbol"]').val();
                var code  	= $('[name="code"]').val();
                var rate  	= $('[name="rate"]').val();

				if(name == ""){
					toastr.error('Oh shit!! You missed to provide the currency name', 'Currency Name Required !!', { positionClass: 'toast-bottom-full-width', });
					return false;
				}

				if(symbol == ""){
					toastr.warning('Oh shit!! You missed to provide the symbol', 'Symbol Required !!', { positionClass: 'toast-bottom-full-width', });
					return false;
				}

				if(code == ""){
					toastr.info('Oh shit!! You missed to provide the code', 'Code Required !!', { positionClass: 'toast-bottom-full-width', });
					return false;
				}

				if(rate == ""){
					toastr.info('Oh shit!! You missed to provide the rate', 'Rate Required !!', { positionClass: 'toast-bottom-full-width', });
					return false;
				}

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/currencyAdd') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{name:name,symbol:symbol,code:code,rate:rate},
                    success:function(data)
                    {

                        if(data == 1){

                            $('#addCurrency').trigger("reset");
                            $('#default').modal('hide');

                            $.ajax({
                                'url':"{{ url('/getCurrencyList') }}",
                                'type':'post',
                                'dataType':'text',
                                success:function(getData)
                                {
                                    $("#currencyList").empty();
                                    $("#currencyList").html(getData);

                                }
                            });

                            $.ajax({
				                'url':"{{ url('/getCurrency') }}",
				                'type':'post',
				                'dataType':'text',
				                success:function(currencyData)
				                {
									$("#getCurrency").empty();
									$("#getCurrency").html(currencyData);
				                }
				            });

                            toastr.success('Thanks !! You have added the currency', 'Currency Added Successfully !!', { positionClass: 'toast-bottom-full-width', });
                            return false;
						}else{
                            toastr.error('Oh shit !! Something went wrong', 'Currency Not Added !!', { positionClass: 'toast-bottom-full-width', });
                            return false;
						}


                    }
                });

            });

        })
        
        
        $(function(){
            $('body').on('submit', '#defultCurrency', function (e) {
               e.preventDefault();

               var currencyid =  $('[name="currencyid"] :selected').val();
               
               if(currencyid == ""){
					toastr.error('Oh shit!! You missed to provide the currency name', 'Currency Name Required !!', { positionClass: 'toast-bottom-full-width', });
					return false;
				}

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/defultCurrency') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{currencyid:currencyid},
                    success:function(data)
                    {
                        
                    if(data == 1){
                    $('#defaultcurrency').modal('hide');

                            $.ajax({
                                'url':"{{ url('/getCurrencyList') }}",
                                'type':'post',
                                'dataType':'text',
                                success:function(getData)
                                {
                                    $("#currencyList").empty();
                                    $("#currencyList").html(getData);

                                }
                            });

                            $.ajax({
				                'url':"{{ url('/getCurrency') }}",
				                'type':'post',
				                'dataType':'text',
				                success:function(currencyData)
				                {
									$("#getCurrency").empty();
									$("#getCurrency").html(currencyData);
				                }
				            });

                            toastr.success('Thanks !! You have Set Defult currency', 'Currency Added Successfully !!', { positionClass: 'toast-bottom-full-width', });
                            return false;
						}else{
                            toastr.error('Oh shit !! Something went wrong', 'Currency Not Added !!', { positionClass: 'toast-bottom-full-width', });
                            return false;
						}


                    }
                });

			})
		})

        $(document).ready(function(){

            // function explode(){

                

            // }
            // setInterval(explode,1000);

            var receiver_id = 1;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/getCurrency') }}",
                'type':'post',
                'dataType':'text',
                data:{receiver_id: receiver_id},
                success:function(data)
                {
					$("#getCurrency").empty();
					$("#getCurrency").html(data);
                }
            });

            $.ajax({
                'url':"{{ url('/getSymbolList') }}",
                'type':'post',
                'dataType':'text',
                data:{receiver_id: receiver_id},
                success:function(data)
                {
                	console.log(data) ;
					$("#accountSelect").empty().html(data);
                }
            });
        })

		$(document).ready(function(){

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				'url':"{{ url('/getCurrencyList') }}",
				'type':'post',
				'dataType':'text',
				success:function(data)
				{
					$("#currencyList").empty();
					$("#currencyList").html(data);
				}
			});

        })

	</script>
	<!-- END: Page JS-->

	<script type="text/javascript">
        function edit(id) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/currencyEdit') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){
                	var value = data.split("|") ;
                    $('[name="uname"]').val(value[0]);
                    $('[name="usymbol"]').val(value[1]);
                    $('[name="ucode"]').val(value[3]);
                    $('[name="urate"]').val(value[2]);
                    $('[name="primary_id"]').val(value[5]);

                }
            });
        }
	</script>
	<script type="text/javascript">
        $('body').on('submit', '#updateCurrency', function (e) {
            e.preventDefault();

            var name    	= $('[name="uname"]').val();
            var symbol  	= $('[name="usymbol"]').val();
            var code  		= $('[name="ucode"]').val();
            var rate  		= $('[name="urate"]').val();
            var primary_id 	= $('[name="primary_id"]').val();

			if(name == ""){
				toastr.error('Oh shit!! You missed to provide the currency name', 'Currency Name Required !!', { positionClass: 'toast-bottom-full-width', });
				return false;
			}

			if(symbol == ""){
				toastr.warning('Oh shit!! You missed to provide the symbol', 'Symbol Required !!', { positionClass: 'toast-bottom-full-width', });
				return false;
			}

			if(code == ""){
				toastr.info('Oh shit!! You missed to provide the code', 'Code Required !!', { positionClass: 'toast-bottom-full-width', });
				return false;
			}

			if(rate == ""){
				toastr.info('Oh shit!! You missed to provide the rate', 'Rate Required !!', { positionClass: 'toast-bottom-full-width', });
				return false;
			}

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/currencyUpdate') }}",
                'type':'post',
                'dataType':'text',
                data:{name:name,symbol:symbol,code:code,rate:rate,primary_id:primary_id},
                success:function(data)
                {	

                    if(data == "success"){

                        $('#update').modal('hide');

                        $.ajax({
                            'url':"{{ url('/getCurrencyList') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(getData)
                            {
                                $("#currencyList").empty();
                                $("#currencyList").html(getData);
                            }
                        });

                        $.ajax({
			                'url':"{{ url('/getCurrency') }}",
			                'type':'post',
			                'dataType':'text',
			                success:function(currencyData)
			                {
								$("#getCurrency").empty();
								$("#getCurrency").html(currencyData);
			                }
			            });

                        toastr.success('Thanks !! You have Update the currency', 'Currency Update Successfully !!', { positionClass: 'toast-bottom-full-width', });
                        return false;
					}else if(data == "failed"){
                        $('#update').modal('hide');

                        $.ajax({
                            'url':"{{ url('/getCurrencyList') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(getData)
                            {
                                $("#currencyList").empty();
                                $("#currencyList").html(getData);
                            }
                        });

                        toastr.error('Sorry !! Currency Not Update', { positionClass: 'toast-bottom-full-width', });
                        return false;
					}else{
                        toastr.error('Oh shit !! Something went wrong', 'Currency Not Added !!', { positionClass: 'toast-bottom-full-width', });
                        return false;
					}


                }
            });

        });
	</script>	

	<script type="text/javascript">
         function deleteCurrency(id) {

			var r = confirm("Are You Sure To Delete It!");
			if (r == true) {
				$.ajaxSetup({
	                headers: {
	                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	                }
	            });

	            $.ajax({
	                'url':"{{ url('/currencyDelete') }}",
	                'type':'post',
	                'dataType':'text',
	                data:{id:id},
	                success:function(data){

	                	if (data == "success") {
	                		$.ajax({
	                            'url':"{{ url('/getCurrencyList') }}",
	                            'type':'post',
	                            'dataType':'text',
	                            success:function(getData)
	                            {
	                                $("#currencyList").empty();
	                                $("#currencyList").html(getData);
	                            }
	                        });

	                        $.ajax({
				                'url':"{{ url('/getCurrency') }}",
				                'type':'post',
				                'dataType':'text',
				                success:function(currencyData)
				                {
									$("#getCurrency").empty();
									$("#getCurrency").html(currencyData);
				                }
				            });

	                        toastr.error('Thanks !! You have Delete the currency', 'Currency Delete Successfully !!', { positionClass: 'toast-bottom-full-width', });
	                        return false;
	                	}else{
	                		toastr.error('Sorry !! Currency Not Delete', { positionClass: 'toast-bottom-full-width', });
                    		return false;
	                	}
	                	
	                }
	            });
				} else {
					toastr.error('Sorry !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
                    return false;
				}

            
        }

	</script>

@endsection