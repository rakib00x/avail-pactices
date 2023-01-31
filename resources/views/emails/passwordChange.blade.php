@extends('frontEnd.master')
@section('title','Forget Password')
@section('content')
<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
				<li class="breadcrumb-item active" aria-current="page">Forget Password</li>
			</ol>
		</div><!-- End .container -->
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-3">
			</div>
			<div class="col-md-6">

				<h2 class="title login">Forget Password</h2>
				<!-- End .heading -->
				<form enctype="multipart/form-data" action="{{URL::to('/change-password')}}" method="post" >
					@csrf
					<div class="form-group input-group ">
						<div class="input-group-prepend">
							<span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
						</div>
						<input name="recovery_code" class="form-control form-control-sm" placeholder="Enter your email address or phone number" type="text">
					</div> 

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block form-control-sm"> Submit  </button>
					</div>

					<div class="form-footer row">
						<div class="col-md-6 col-6 col-sm-6 ">
							<a href="{{URL::to('/login')}}" class="forget-pass "> Back to login page</a>
						</div>		
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