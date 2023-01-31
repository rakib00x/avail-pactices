@extends('mobile/master-website')
@section('content')
<?php 
        $base_url = "https://availtrade.com/";
     ?>
<?php 
    if (Session::get('supplier_id') != null || Session::get('buyer_id') != null){
         if(Session::get('supplier_id') != null){
            $main_login_id = Session::get('supplier_id');
            	   }else{
            	      $main_login_id = Session::get('buyer_id');
            	   }
            	  }else{
            	      $main_login_id = 0;
            	   }
 ?>
 
      <div class="container" style="padding-top: 66px!important;">
        <!-- Checkout Wrapper-->
        <div class="checkout-wrapper-area py-3">
          <!-- Billing Address-->
          <div class="billing-information-card mb-3">
            <div class="card billing-information-title-card bg-danger">
              <div class="card-body">
                  <div>
                     <h6 class="mb-0 text-white">Billing Information   <a id="myChattttBtn" style="float:right;">Change</a></h6>
                     
                 </div>
                
              </div>
            </div>
 @php
 $user = DB::table('express')->where('id',$main_login_id)->first();

 $address_info = DB::table('tbl_shipping_address')
        ->join('tbl_countries', 'tbl_shipping_address.country_id', '=', 'tbl_countries.id')
         ->select('tbl_shipping_address.*', 'tbl_countries.countryName')
         ->where('tbl_shipping_address.express_id', $main_login_id)
            ->where('tbl_shipping_address.status', 1)
            ->first() ;
 @endphp
        @if($address_info)
            <div class="card user-data-card">
              <div class="card-body">                                   
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-user"></i><span>Full Name</span></div>
                  <div class="data-content">{{ $address_info->contact_name}}</div>
                </div>
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-phone"></i><span>Phone</span></div>
                  <div class="data-content">{{ $address_info->mobile_number}}</div> 
                </div>
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-map-marker"></i><span>Shipping Address</span></div>
                  <div class="data-content">{{ $address_info->address }}</div>
                </div>
                <!-- Edit Address--><a class="btn btn-danger w-100" href="#"  id="myBtn">Edit Billing Information</a>
              </div>
            </div>
            @else
            <div class="card user-data-card">
              <div class="card-body">                                   
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-user"></i><span>Full Name</span></div>
                  <div class="data-content">{{ $customer_info->first_name." ".$customer_info->last_name }}</div>
                </div>
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-envelope"></i><span>Email Address</span></div>
                  <div class="data-content">{{ $customer_info->email }}</div>
                </div>
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-phone"></i><span>Phone</span></div>
                  <div class="data-content">{{ $customer_info->mobile }}</div>
                </div>
                <div class="single-profile-data d-flex align-items-center justify-content-between">
                  <div class="title d-flex align-items-center"><i class="lni lni-map-marker"></i><span>Shipping Address</span></div>
                  <div class="data-content">{{ $customer_info->address }}</div>
                </div>
                <!-- Edit Address--><a class="btn btn-danger w-100" href="#"  id="myBtn">Edit Billing Information</a>
              </div>
            </div>
            @endif
          </div>
          <!-- Shipping Method Choose-->
          <div class="shipping-method-choose mb-3" style="display: none;">
            <div class="card shipping-method-choose-title-card bg-success">
              <div class="card-body">
                <h6 class="text-center mb-0 text-white">Shipping Method Choose</h6>
              </div>
            </div>
            <div class="card shipping-method-choose-card">
              <div class="card-body">
                <div class="shipping-method-choose">
                  <ul class="ps-0">
                    <li>
                      <input id="fastShipping" type="radio" name="selector" checked>
                      <label for="fastShipping">Fast Shipping<span>1 days delivary for $1.0</span></label>
                      <div class="check"></div>
                    </li>
                    <li>
                      <input id="normalShipping" type="radio" name="selector">
                      <label for="normalShipping">Reguler<span>3-7 days delivary for $0.4</span></label>
                      <div class="check"></div>
                    </li>
                    <li>
                      <input id="courier" type="radio" name="selector">
                      <label for="courier">Courier<span>5-8 days delivary for $0.3</span></label>
                      <div class="check"></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <!-- Cart Amount Area-->
          <div class="card cart-amount-area">
            <div class="card-body d-flex align-items-center justify-content-between">
              <h5 class="total-price mb-0">$<span class="counter"><?php echo number_format($total_amount-$total_discount, 2); ?></span></h5>
              <?php if ($supplier_id > 0): ?>
                  <a class="btn btn-warning" href="{{ URL::to('m/mobileorderplace/'.$supplier_id) }}" >Order Place</a>
              <?php endif ?>
              
            </div>
          </div>
        </div>
      </div>
    </div>
    
     <!-- The Modal -->
<div id="myModal" class="modal" >
                  
  <!-- Modal content -->
  <div class="modal-content" style="margin-bottom:5rem;" >
{!! Form::open(['url' =>'m/addNewAddress','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
 
 <span class="close">&times;</span>
 <h1>Shipping Address</h1>
 <div class="form-group">
    
    <label class="form-check-label" for="exampleCheck1">Country:</label>
    <?php  $all_coutnry_info = DB::table('tbl_countries')->orderBy('countryName', 'asc')->get() ;
                                    ?>
    <select class="form-control" id="country" name="country">
        
        <option value="">Select Country</option>
        <?php foreach ($all_coutnry_info as $coutnry): ?>
      <option value="{{ $coutnry->id }}" <?php if($coutnry->countryCode == Session::get('countrycode')){echo "selected"; } ?>>{{ $coutnry->countryName }}</option>
      <?php endforeach ?>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Address</label>
    <input type="text" class="form-control" id="address" name="address"  placeholder="Enter address">
    
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">State/Province</label>
    <input type="text" class="form-control" id="state" name="state"  placeholder="Enter State/Province">
    
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">City</label>
    <input type="text" class="form-control" id="city" name="city"  placeholder="Enter City">
    
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Zip Code</label>
    <input type="text" class="form-control" id="zip_code" name="zip_code"  placeholder="Enter Zip Code">
    
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Contact Name</label>
    <input type="text" class="form-control" id="contact_name" name="contact_name"  placeholder="Enter Contact Name">
    
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Phone Number</label>
    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Phone Number">
  </div>
  
  <input type="hidden" name="express_id" value="{{ $main_login_id }}">
  <button type="submit" class="btn btn-primary">Submit</button>
{!! Form::close() !!}
  </div>

</div>


   <!-- The Modal -->
<div id="all_address" class="modal" >
                  
  <!-- Change Modal content -->
  <div class="modal-content" style="margin-bottom:5rem;" >
 
 <span class="closech">&times;</span>
 <h4>Shipping Address</h4>
  @php
 $user = DB::table('express')->where('id',$main_login_id)->first();
 $address_info = DB::table('tbl_shipping_address')
 ->join('tbl_countries', 'tbl_shipping_address.country_id', '=', 'tbl_countries.id')
 ->select('tbl_shipping_address.*', 'tbl_countries.countryName')
 ->where('tbl_shipping_address.express_id', $main_login_id)
 ->get() ;
@endphp
<table class="table">
    @foreach($address_info as $saddress)
    <tr>
      <td style="cursor:pointer;" onclick="setDefaultAddressInCustomer(event, {{ $saddress->id }}, {{ $main_login_id }})">
          <p><?php echo $saddress->contact_name;?>, <?php echo $saddress->address;?>,<?php echo $saddress->state_name;?></p>
         <p><?php echo $saddress->city_name;?>, <?php echo $saddress->zip_code;?>, <?php echo $saddress->countryName;?></p>
      </td>
     
      
    </tr>
    @endforeach
    
</table>

  </div>

</div>
@endsection

@section('page_headline')
    Checkout
@endsection

@section('js')
<script>
    $("#mobile_currency").change(function(){
	        
        var mobile_currency = $(this).val() ;
        var main_link       = "http://m.availtrade.com/mobilechangeCurrency"+"/"+mobile_currency;
        window.location     = main_link;
    });
    
    function setDefaultAddressInCustomer(event, address_id, express_id){
        event.preventDefault() ;


        $.ajaxSetup({
        	headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/m/addChangeAddress') }}",
            'type':'post',
            'dataType':'text',
            data:{address_id:address_id, express_id:express_id},
            success:function(data)
            {
                toastr.success('Address Change Successfully', "success", { positionClass: 'toast-top-center', });
                setTimeout(() => {
                    location.reload() ;
                }, 3000);
            }
        });
    }

</script>
<script>
// Get the modal
var firstModal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  firstModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  firstModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    firstModal.style.display = "none";
  }
}
</script>
<script>
// Get the modal
var modal2 = document.getElementById("all_address");

// Get the button that opens the modal
var btn2 = document.getElementById("myChattttBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("closech")[0];

// When the user clicks the button, open the modal 
btn2.onclick = function() {
  modal2.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal2.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal2) {
    modal2.style.display = "none";
  }
}
</script>

@endsection
