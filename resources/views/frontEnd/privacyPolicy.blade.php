@extends('frontEnd.master')
@section('title','Privacy Policy')
@section('content')
<style>
 .control-size{
     box-size:0;
 }   
</style>

<section class="hero">
  <div class="hero-body">
    <p class="title login">
     Privacy and Policy
    </p>
  </div>
</section>

        	<div class="content is-two-quarters" style="margin-left:39px;margin-right:39px;">
	
	<!--<div class="content" style="margin-left:35px;">-->
	    
                        
                        <?php foreach ($privacy as $value) { ?>
                        <h3><?php echo $value->meta_title; ?>       <?php echo date('M d Y', strtotime($value->created_at)); ?></h3>
                       
                        <?php echo $value->meta_discription; ?>
                           
                        
                    <?php } ?>
                  
                </div>
        


@endsection