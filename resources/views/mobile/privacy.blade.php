@extends('mobile.master-website')
@section('content')
 
        	<div class="content is-two-quarters pt-5 pb-5" >
        	    <h1 class="has-text-centered pt-4">
                 Privacy and Policy
                </h1>
	
	
            	   
                        
                        <?php foreach ($privacy as $value) { ?>
                        <h3><?php echo $value->meta_title; ?>      Updated as of <?php echo date('M d Y', strtotime($value->created_at)); ?></h3>
                       
                        <?php echo $value->meta_discription; ?>
                           
                        
                    <?php } ?>
                    <div class="pb-3">
                      <a class="button" style="padding-left:120px" href="{{route('fterms')}}">Terms & Condition</a>  
                    </div>
                    
                  
                </div>
@endsection