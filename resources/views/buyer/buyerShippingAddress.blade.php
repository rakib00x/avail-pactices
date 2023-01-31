@extends('buyer.masterBuyer')
@section('title','Address')
@section('content')
<div class="app-content content">
	<div class="content-overlay"></div>
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-12 mb-2 mt-1">
				<div class="row breadcrumbs-top">
					<div class="col-12">
						<h5 class="content-header-title float-left pr-1 mb-0">Address</h5>
						<div class="breadcrumb-wrapper col-12">
							<ol class="breadcrumb p-0 mb-0">
								<li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active"> Address
								</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content-body">
			<div class="container">
				<a class="btn btn-danger" id="account-pill-password" data-toggle="pill" href="#" aria-expanded="false">
					Shipping Address
				</a>
				<div class="card-content">
					<div class="card-body">
						<div class="row">
							<div class="col-6">
								<div class="row">
									<div class="col-6">
										<p>{{$result->first_name}} &nbsp;&nbsp; {{$result->last_name}} </p>
									</div>
									<div class="col-6">
										<p>, {{$result->mobile}}</p>
									</div>
								</div>
								<div class="row">
									<div class="col-6">
										<p>{{$result->address}}</p>	
									</div>
									<div class="col-6">
										<p>{{$result->city}}-{{$result->zipPostalCode}}</p>	
									</div>
								</div> 

								<div class="row">
									<div class="col-6">
										<p>{{$result->countryName}}</p>
									</div> 
								</div>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-content">
							<div class="card-body">
								{!! Form::open(['id' =>'buyerShippingAddressUpdate','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>First Name</label>
											<div class="controls">
												<input type="text" value="{{$result->first_name}}" id="first_name" name="first_name" class="form-control" data-validation-required-message="This field is required" >
											</div>
										</div>
										<div class="form-group">
											<label> Street Address </label>
											<div class="controls">
												<input type="text" value="{{$result->address}}" id="address" name="address" class="form-control" data-validation-required-message="This field is required" >
											</div>
										</div>
										<div class="form-group">
											<label>Phone Number</label>
											<div class="controls">
												<input type="text" value="{{$result->mobile}}" id="mobile" name="mobile" class="form-control" data-validation-required-message="This field is required" >
											</div>
										</div>

<div class="form-group">
<label>Country</label>
<div class="controls">
<select class="form-control" name="country" id="country" required="">
<option value="" <?php if($result->country == ""){echo "selected"; }  ?>>Select Country</option>
<?php foreach ($all_countries as $cvalue) { ?>
<option value="<?php echo $cvalue->id; ?>" <?php if($result->country == $cvalue->id){echo "selected";}else{echo " ";} ?>><?php echo $cvalue->countryName; ?></option>
<?php } ?>
</select>
</div>
</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label> Last Name </label>
											<div class="controls">
												<input type="text" value="{{$result->last_name}}" id="last_name" name="last_name" class="form-control" data-validation-required-message="This field is required" >
											</div>
										</div>
										<div class="form-group">
											<label>City </label>
											<div class="controls">
												<input type="text" value="{{$result->city}}" id="city" name="city" class="form-control" data-validation-required-message="This field is required" >
											</div>
										</div>
										<div class="form-group">
											<label> Zip/Postal Code </label>
											<div class="controls">
												<input type="text" value="{{$result->zipPostalCode}}" id="zipPostalCode" name="zipPostalCode" class="form-control" data-validation-required-message="This field is required" >
											</div>
										</div>
										<input type="hidden" name="primary_id" value="<?php echo $result->id ; ?>">
									</div>
								</div>
								<button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
								changes</button>
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

	<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
	<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>

	<script type="text/javascript">
		$('body').on('submit', '#buyerShippingAddressUpdate', function (e) {
			e.preventDefault();

			var first_name     = $('#first_name').val() ;
			var last_name      = $('#last_name').val() ;
			var address    = $('#address').val() ;
			var mobile      = $('#mobile').val() ;
			var zipPostalCode     = $('#zipPostalCode').val() ;
			var country    = $('#country').val() ;
			var city       = $('#city').val() ;
			var primary_id   = $("[name=primary_id]").val();

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				'url':"{{ url('/buyerShippingAddressUpdate') }}",
				'type':'post',
				'dataType':'text',
				data: {first_name: first_name, last_name:last_name, address:address, mobile:mobile,zipPostalCode:zipPostalCode,country:country,city:city,primary_id:primary_id},

				success:function(data){
					if (data == "success") {
						toastr.success('Thanks !! Records Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

						return false;
					}else if(data == "failed"){
						toastr.error('Sorry !! Records Not Updated', { positionClass: 'toast-bottom-full-width', });
						return false;
					}

				}
			});

		});

	</script>

	@endsection