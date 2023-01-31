@extends('mobile.master-website')
@section('content')
<div class="container mt-5">
<div class="row pt-5">
<div class="media ">
  <div class="media-body">
      <h1 class="mt-2 text-center text-primary pt-5">Company Overview</h1>
    <p style="font-size:20px;" class="mt-1"><?php echo $store_info->companyDetails; ?></p>
    
  </div>
</div>
					<table class="table">
					  <thead>
					    <thead>
                            <tr>
                            <th style="width: 50%"> Company Name</th>
                             <td style="width: 50%"> <?php echo $store_info->companyName; ?></td>
                           </tr>
                           <tr>
                           
                            <th style="width: 50%">Country</th>
                             <td style="width: 50%"><img src="{{ URL::to('public/country_flags/') }}/<?php echo strtolower($store_info->countryCode).'.png'; ?>" alt="" style="width:55px;height:40px;"></td>
                           </tr>
                           <tr>
                            <th style="width: 50%">Year Established</th>
                             <td style="width: 50%"> <?php
                                 $year = date("Y", strtotime($store_info->created_at)) ;
                              echo $year; ?></td>
                           </tr>
                           <tr>
                            <th style="width: 50%"> Main Product</th>
                             <td style="width: 50%"> <?php echo $store_info->mainProduct; ?></td>
                           </tr>
                            <tr>
                            <th style="width: 50%">Company Address</th>
                             <td style="width: 50%"> <?php echo $store_info->companyAddress; ?></td>
                           </tr>
                           <tr>
                            <th style="width: 50%">Employee Number</th>
                             <td style="width: 50%"> <?php echo $store_info->companyEmployeeNumber; ?></td>
                           </tr>
                           <tr>
                            <th style="width: 50%">Email</th>
                             <t style="width: 50%"> <?php echo $store_info->email; ?></td>
                           </tr>
                           
				  </thead>
				  </table>
				  <div style="width:100%; <?php if($store_info->googleMapLocation != null){echo ""; }else{echo "display:none"; } ?>">
                 <iframe src="<?php echo $store_info->googleMapLocation; ?>" width="400" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                        
                    </div>
            	<div class="alert alert-primary mb-5 text-center" role="alert">
            	  <a class="btn btn-primary text-center" href="{{ URL::to('m/'.strtolower($store_info->storeName)) }}" role="button">Visit Store</a>
            	</div>


		
	</div>
	
</div>

@endsection