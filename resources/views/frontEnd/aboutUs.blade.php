@extends('frontEnd.master')
@section('title','About US')
@section('content')
<main class="main">
	<nav aria-label="breadcrumb" class="breadcrumb-nav">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
				<li class="breadcrumb-item active" aria-current="page">About US</li>

			</ol>

		</div><!-- End .container -->
	</nav>

	<div class="container mt-2">
		<div class="row">
			<?php foreach ($about_section as $aboutvalue): ?>

				<?php if($aboutvalue->image != "" && $aboutvalue->image_position== 1): ?>
					<div class="col-8">
						<h4><?php echo $aboutvalue->about_title." ".$aboutvalue->image_position; ?></h4>
						<p><?php echo $aboutvalue->about_details; ?></p>
					</div>
					<div class="col-4">
						<img src="{{ URL::to('/public/images/'.$aboutvalue->image) }}" alt="" class="img-fluid">
					</div>
				<?php elseif($aboutvalue->image != "" && $aboutvalue->image_position == 2): ?>
					<div class="col-4">
						<img src="{{ URL::to('/public/images/'.$aboutvalue->image) }}" alt="" class="img-fluid">
					</div>
					<div class="col-8">
						<h4><?php echo $aboutvalue->about_title." ".$aboutvalue->image_position; ?></h4>
						<p><?php echo $aboutvalue->about_details; ?></p>
					</div>
				<?php else: ?>
					<div class="col-12">
						<h4><?php echo $aboutvalue->about_title." ".$aboutvalue->image_position; ?></h4>
						<p><?php echo $aboutvalue->about_details; ?></p>
					</div>
				<?php endif; ?>

				
			<?php endforeach ?>
		</div>


	</div>

	<div class="mb-5"></div><!-- margin -->
</main><!-- End .main -->
@endsection