<div class="row mt-1">

	<div class="col-md-12">
		<div class="card">
		  <div class="card-header"><h3 class="title" style="color: rgb(227, 67, 67);margin-top: 12px;">Contact Information</h3></div>
		  <div class="card-body">
		  	<div class="row">
		  		<div class="col-12 col-md-5 col-xl-5">
					<div style="margin-left:10px;margin-top:10px;border-right:2px solid #dbe3ef">
						<img  src="{{ URL::to('/'.$supplier_info->companyLogo) }}">
						<h3 style="margin-left: 20px;"><?php echo $supplier_info->first_name." ".$supplier_info->last_name ; ?></h3>
						<p style="margin-left: 20px;"><?php echo $supplier_info->designation; ?></p>
						<p style="text-align: center;"><a href=""> Chat Now!</a></p>
					</div>
				</div>
				<div class="col-12 col-md-7 col-xl-7">
					<div style="margin-top:10px;">
						<div class="table-responsive">
							<table>
								<tr>
									<td>Telephone</td>
									<td>:</td>
									<td><?php echo $supplier_info->companyTelephone; ?></td>
								</tr>
								<tr>
									<td>Mobile Phone</td>
									<td>:</td>
									<td><?php echo $supplier_info->mobile; ?></td>
								</tr>
								<tr>
									<td>Address</td>
									<td>:</td>
									<td><?php echo $supplier_info->address; ?></td>
								</tr>
								<tr>
									<td>Zip</td>
									<td>:</td>
									<td><?php echo $supplier_info->zipPostalCode; ?></td>
								</tr>
								<tr>
									<td>Country/Region</td>
									<td>:</td>
									<td><?php echo $supplier_info->countryName; ?></td>
								</tr>
								<tr>
									<td>Province/State</td>
									<td>:</td>
									<td><?php echo $supplier_info->stateName; ?></td>
								</tr>

								<tr>
									<td>City</td>
									<td>:</td>
									<td><?php echo $supplier_info->city; ?></td>
								</tr>
							</table>

						</div>
					</div>
				</div>
		  	</div>
		  </div>
		</div>
	</div>

	<div class="col-12">
		<div class="card">
		  <div class="card-header">
		  	<h3 class="title" style="color: rgb(227, 67, 67);margin-top: 12px;">Company Contact Information</h3>
		  </div>
		  <div class="card-body">
		  	<div class="row">
		  		<div class="col-8 offset-md-2">
					<p><b>Company Name: </b> <?php echo $supplier_info->companyName; ?></p>
					<p><b>Operational Address:	</b> <?php echo $supplier_info->companyAddress; ?></p>
					<p><b>Website:	</b> <?php echo $supplier_info->companyWebsite ?></p>
					<P><b>Website on availtrade.com: </b>  <a href="{{ url('supplier/supplierWeb/'.$supplier_info->storeName) }}"> <?php echo URL::to('/supplier/supplierWeb/'.$supplier_info->storeName); ?></a></P>
				</div>
		  	</div>
		  </div>
		</div>
	</div>

	<div class="col-12">
		<div class="card">
		  <div class="card-header">
		  	<h3 class="title" style="color: rgb(227, 67, 67);margin-top: 12px;">Send message to supplier</h3>
		  </div>
		  <div class="card-body">
		  	<div class="row">
		  		<div class="col-8 offset-md-2">
					<p>To: <?php echo $supplier_info->first_name." ".$supplier_info->last_name ; ?></p>
					<div class="form-group">
						<p> Messege &nbsp;&nbsp; </p>
						<div class="controls">
							<textarea rows="5" style="border: 1px solid red;width: 100%" name="messege" class="form-control" ></textarea> 
						</div>
						<button type="submit" class="btn btn-success mt-1">SEND</button>
					</div>
					
				</div>
		  	</div>
		  </div>
		</div>
	</div>




</div>	