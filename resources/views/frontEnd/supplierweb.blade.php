@extends('frontEnd.master')
@section('title','Supplier Website')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/supplierweb.css') }}">
@endsection
@section('content')
<div class="supwebhome">
<div class="container navigation_menu">
	<div class="row">
		<div class="col-12">

			<div id="sliderControl" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					@foreach($slider as $key=>$value)
					<div class="carousel-item <?php if($key == 0){echo "active"; } ?>">
						<img class="d-block w-100 slider_image" src="{{ URL::to('public/images/'.$value->slider_image)}}" alt="First slide">
					</div>
					@endforeach
				</div>
				<a class="carousel-control-prev" href="#sliderControl" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#sliderControl" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>


		</div>
	</div>

	<nav class="navbar navbar-expand-lg navbar-light bg-light" id="main_navbar">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                	<?php 
                		$supplier_info = DB::table('express')->where('id', $store_info->id)->first() ;
                	 ?>
                    <a class="nav-link" href="{{ url('supplier/supplierWeb/'.strtolower(preg_replace('/[^A-Za-z0-9\-]/', '-', 
            $supplier_info->storeName))) }}">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item <?php if(count($category) != 0){echo "dropdown"; }else{echo "";} ?> ">
	                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
	                	aria-haspopup="true" aria-expanded="false" onclick="allproduct()">
	                	Product's <span style="float: right;">▾</span>
	                </a>

			       	<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
			       		<?php foreach ($category as $key=>$catpvalue) { ?>
	                	<?php 
	                		$check = DB::table('tbl_supplier_secondary_category')
	                			->where('primary_category_id', $catpvalue->id)
	                			->where('supplier_id', $supplier_info->id)
	                			->where('status', 1)
	                			->count() ;
	                	?>
			            <li class="nav-item dropdown">
		                	<a class="dropdown-item dropdown-toggle" href="#" onclick="maincategoryproduct(<?php echo $catpvalue->id; ?>)" id="navbarDropdown1" role="button" data-toggle="dropdown"
		                		aria-haspopup="true" aria-expanded="false"><?php echo substr($catpvalue->category_name, 0,25); ?>
		                		 <span style="float: right;"><?php if($check > 0) {echo '<i class="fa fa-chevron-right dropdown-menu-icon" aria-hidden="true"></i>'; }?></span>
		                	</a>
		                	<?php if ($check > 0): ?>
		                		<ul class="dropdown-menu" aria-labelledby="navbarDropdown1">
		                			<?php 
		                				$subcategory = DB::table('tbl_supplier_secondary_category')
				                			->where('primary_category_id', $catpvalue->id)
				                			->where('supplier_id', $supplier_info->id)
				                			->where('status', 1)
				                			->get() ;
		                			 ?>
		                			<?php foreach ($subcategory as $subvalue): ?>
		                				<li><a class="dropdown-item" href="#" onclick="secondarycategoryproduct(<?php echo $catpvalue->id; ?>,<?php echo $subvalue->id ?>)"><?php echo substr($subvalue->secondary_category_name, 0, 20); ?>
		                						
		                					</a></li>
		                			<?php endforeach ?>
			                	</ul>
		                	<?php endif ?>
			            </li>
			            <?php } ?>
			        </ul>
			    </li>

                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Profile</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link disabled" href="#" onclick="supplierContact()">Contact</a>
                </li>

                @foreach($menu as $value)
                <?php
					$check_2 = DB::table('tbl_sub_menu')
					->where('menu_id',$value->id)
					->count();
				?>
                <li class="nav-item <?php if($check_2 != 0){echo "dropdown"; }else{echo "";} ?> ">
	                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
	                	aria-haspopup="true" aria-expanded="false">{{$value->menu_name}} <span style="float: right;"> <?php if($check_2 > 0) {echo "▾"; }?></span>
	                </a>
	                <?php if ($check_2 > 0): ?>
	                	<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
				       		<?php 
				       			$all_submen = DB::table('tbl_sub_menu')
								->where('menu_id',$value->id)
								->get() ;
							?>
				       		<?php foreach ($all_submen as $key=>$submvalue) { ?>
				            <li class="nav-item dropdown">
			                	<a class="dropdown-item dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-toggle="dropdown"
			                		aria-haspopup="true" aria-expanded="false">
			                		<?php echo $submvalue->category_name ; ?> 
			                	</a>
				            </li>
				            <?php } ?>
				        </ul>
	                <?php endif ?>
			    </li>
			    @endforeach
            </ul>
            <form id="getSerachResult" class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" name="search_keyword" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="row mt-2">
    	<div class="col-12">
    		<nav class="toolbox">
		        <div class="toolbox-left">
		            <div class="toolbox-item toolbox-sort">
		                <div class="select-custom">
		                	<label for="">Short By:</label>
		                    <select name="orderby" class="form-control">
		                        <option value="menu_order" selected="selected">Default sorting</option>
		                        <option value="popularity">Sort by popularity</option>
		                        <option value="rating">Sort by average rating</option>
		                        <option value="date">Sort by newness</option>
		                        <option value="price">Sort by price: low to high</option>
		                        <option value="price-desc">Sort by price: high to low</option>
		                    </select>
		                </div><!-- End .select-custom -->

		                <a href="#" class="sorter-btn" title="Set Ascending Direction"><span class="sr-only">Set Ascending Direction</span></a>
		            </div><!-- End .toolbox-item -->
		        </div><!-- End .toolbox-left -->


		        <div class="toolbox-item toolbox-show">
		            <div class="select-custom">
		            	<label for="">Short By:</label>
		            	<select name="orderby" class="form-control">
		            		<option value="18" selected="selected">18</option>
		            		<option value="">24</option>
		            		<option value="">36</option>
		            	</select>
		            </div><!-- End .select-custom -->
		        </div><!-- End .toolbox-item -->

		        <div class="layout-modes">
		            <a href="category.html" class="layout-btn btn-grid active" title="Grid">
		                <i class="icon-mode-grid"></i>
		            </a>
		            <a href="category-list.html" class="layout-btn btn-list" title="List">
		                <i class="icon-mode-list"></i>
		            </a>
		        </div><!-- End .layout-modes -->
		    </nav>
    	</div>
    </div>	
    <span id="supplier_product">
    	
    </span>

</div>	



<div class="clearfix"></div>
</div>
</div>
@endsection

@section('js')
<script>
	$(document).ready(function(){

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/supplier/getSupplierProduct') }}",
            'type':'post',
            'dataType':'text',
            data:{supplier_id:<?php echo $supplier_info->id ; ?>},
            success:function(data){
                $("#supplier_product").empty();
                $("#supplier_product").html(data);

            }
        });
	});

	function allproduct(){
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/supplier/getSupplierProduct') }}",
            'type':'post',
            'dataType':'text',
            data:{supplier_id:<?php echo $supplier_info->id ; ?>},
            success:function(data){
                $("#supplier_product").empty();
                $("#supplier_product").html(data);

            }
        });
	}

	function maincategoryproduct(category_id){

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/supplier/getSupplierCategroyProduct') }}",
            'type':'post',
            'dataType':'text',
            data:{supplier_id:<?php echo $supplier_info->id ; ?>,category_id:category_id},
            success:function(data){
                $("#supplier_product").empty();
                $("#supplier_product").html(data);
            }
        });

	}	

	function secondarycategoryproduct(category_id, secondary_category_id){

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/supplier/getSupplierSecondaryCategroyProduct') }}",
            'type':'post',
            'dataType':'text',
            data:{supplier_id:<?php echo $supplier_info->id ; ?>,category_id:category_id, secondary_category_id:secondary_category_id},
            success:function(data){
                $("#supplier_product").empty();
                $("#supplier_product").html(data);
            }
        });

	}	

	function secondarycategoryproduct(category_id, secondary_category_id){

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/supplier/getSupplierSecondaryCategroyProduct') }}",
            'type':'post',
            'dataType':'text',
            data:{supplier_id:<?php echo $supplier_info->id ; ?>,category_id:category_id, secondary_category_id:secondary_category_id},
            success:function(data){
                $("#supplier_product").empty();
                $("#supplier_product").html(data);
            }
        });

	}

	function supplierContact()
	{
		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/supplier/supplierContact') }}",
            'type':'post',
            'dataType':'text',
            data:{supplier_id:<?php echo $supplier_info->id ; ?>},
            success:function(data){
                $("#supplier_product").empty();
                $("#supplier_product").html(data);
            }
        });
	}

	$("#getSerachResult").submit(function(e){
		e.preventDefault();

		var search_keyword = $("[name=search_keyword]").val() ;

		$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/supplier/getSupplirSerachResult') }}",
            'type':'post',
            'dataType':'text',
            data:{supplier_id:<?php echo $supplier_info->id ; ?>, search_keyword:search_keyword},
            success:function(data){
                $("#supplier_product").empty();
                $("#supplier_product").html(data);
            }
        });

	})
</script>
<script>
    $(function () {
        $('#main_navbar').bootnavbar();
    })
</script>
<script>
$(document).ready(function(){

 $(document).on('click', '.page-link', function(event){
    event.preventDefault(); 
    var page = $(this).attr('href').split('page=')[1];
    fetch_data(page);
 });

 function fetch_data(page)
 {
  	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

  $.ajax({
      url:"{{ url('supplier/supplierProductPagination') }}",
      method:"POST",
      data:{page:page,supplier_id:<?php echo $supplier_info->id ; ?>},
      success:function(data)
      {
       	$("#supplier_product").empty();
        $("#supplier_product").html(data);
      }
    });
 }

});
</script> 
@endsection