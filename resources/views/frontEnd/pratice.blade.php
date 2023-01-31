<form action="#" method="get">
	<div class="header-search-wrapper">
		<select class="product-search-width">
			<option value="volvo">Products {{ Session::get('type') }}<i class="fa fa-angle-down product-search-width-color " aria-hidden="true"></i></option>
			<option value="saab">Suppliers</option>
		</select>

		<input  type="search" class="form-control" name="q" id="q" placeholder="Search..." required>
		<i style="margin-left: -60px;padding-right: 10px;padding-top: 5px" class="fa fa-camera" aria-hidden="true"></i>
		<button class="btn icon-search-3" type="submit"></button>
	</div><!-- End .header-search-wrapper -->
</form>