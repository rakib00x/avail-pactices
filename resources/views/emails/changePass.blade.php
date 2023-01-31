@extends('frontEnd.master')
@section('title','Change Password')
@section('content')
<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href=""><i class="icon-home"></i></a></li>
				<li class="breadcrumb-item active" aria-current="page">Change Password</li>
			</ol>
		</div><!-- End .container -->
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">

				<h2 class="title login">Change Password </h2>
				<!-- End .heading -->

				<form enctype="multipart/form-data" action="{{URL::to('/passwordChangeEmail')}}" method="post" >
					@csrf
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<span class="fa fa-lock"></span>
								</span>                    
							</div>
							<input type="password" class="form-control form-control-sm" id="password" name="old_password" placeholder="Old Password" required="required"> 
							          
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<span class="fa fa-lock"></span>
								</span>                    
							</div>
							<input type="password" class="form-control form-control-sm" id="new_password" name="curr_password" placeholder="New Password" required="required"> 
							
							<span class="input-group-text">
								<span  id="togglePasswshow" class="fa fa-eye"></span>
							</span>             
						</div>
					</div>

					<div class="form-group">
						<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<span class="fa fa-lock"></span>
								</span>                    
							</div>
							<input type="password" class="form-control form-control-sm" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required="required"> 
							<span class="input-group-text">
								<span  id="togglePasswordshow" class="fa fa-eye"></span>
							</span>             
						</div>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block form-control-sm"> Submit  </button>
					</div>

					<!-- End .form-footer -->
				</form>
			</div><!-- End .col-md-6 -->

			<div class="col-md-3">
			</div>
		</div><!-- End .row -->
	</div><!-- End .container -->

	<div class="mb-5"></div><!-- margin -->
</main>
@endsection
