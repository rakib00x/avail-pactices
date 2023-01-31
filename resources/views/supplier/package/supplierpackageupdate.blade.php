@extends('supplier.masterSupplier')
@section('content')

<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Analytics Start -->
            <section id="dashboard-analytics">
                <div class="row">
                    
                   <div class="col-xl-4 col-md-4 col-lg-4 col-12">
                      <div class="card blog-catagory-card" style="border: 2px solid <?php echo $package->border_color; ?>!important;border-radius: 0px !important;">
                          
                        <span class="text-center">
                            <h1 class="package-title" style="text-transform: uppercase;">{{ $package->package_name }}</h1>
                            <?php
        		                $main_currancy_status = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
            		        ?>
                            <h4 class="package-price"><span style="font-family:'SolaimanLipi'">{{ $main_currancy_status->symbol }}</span> 
                            <?php 
                            	$now_product_price_is   = $package->package_price * $main_currancy_status->rate ;
                            	if($package->discount_percentage > 0){
                            		$discount_amount = $now_product_price_is * $package->discount_percentage/100 ;
                            
                            	}else{
                            		$discount_amount = 0;
                            	}
                            
                              	echo $now_product_price_is-$discount_amount;  ?> / <?php if($package->duration_type == 1){echo "Month"; }else{echo "Yearly"; }
                             ?>
                            </h4>
                            
                            @if($package->discount_percentage > 0)
                            <h4 class="package-original-amount"><del><?php $now_product_price_is   = $package->package_price * $main_currancy_status->rate ; echo $now_product_price_is; ?> </del></h4>
                            <h4 class="package-save">Save @php $package->discount_percentage @endphp% Off</h4>
                            @endif
                            <br>

                            @if($package->discount_percentage > 0)
                            <p class="pt-2 pb-2 package-renew">You pay @php $now_product_price_is-$discount_amount @endphp — Renews at  @php $now_product_price_ist @endphp </p>
                            @endif
                        </span>
                        <hr style="border: 1px solid <?php echo $package->border_color; ?> !important;">
                        <div class="pl-5 package_item">
                            <p><i class="fa fa-<?php if($package->primary_category_limit != 0){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> {{ $package->primary_category_limit }} Primary Category</p>
                            <p><i class="fa fa-<?php if($package->seconday_category_limit != 0){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> {{ $package->seconday_category_limit }} Secondary Category</p>
                            <p><i class="fa fa-<?php if($package->product_limit != 0){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> {{ $package->product_limit }} Product Upload</p>
                            <p><i class="fa fa-<?php if($package->slider_update_status != 0){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> {{ $package->slider_update_status }} Sliders Item</p>
                            <p><i class="fa fa-<?php if($package->banner_update_status ==1){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> Custom Banner </p>
                            <p><i class="fa fa-<?php if($package->logo_update_status ==1){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i>  Custom Logo </p>
                            <p><i class="fa fa-<?php if($package->social_media_status ==1){echo 'check'; }else{echo 'times'; } ?>" aria-hidden="true"></i> Social Media </p>
                        </div>
                            
                        
                      </div>
                    </div>
                    
                    <div class="col-xl-8 col-md-8 col-12">
                       <section id="basic-vertical-layouts">
                          <div class="row match-height">
                            <div class="col-md-12 col-12">
                              <div class="card">
                                <div class="card-header">
                                  <h4 class="card-title">Payment Information</h4>
                                </div>
                                <div class="card-body">
                                    {!! Form::open(['id' =>'packagepayment','class'=>'form form-vertical','method' => 'post','role' => 'form', 'files' => true]) !!}
                                    <div class="form-body">
                                      <div class="row">
                                        <div class="col-12">
                                          <div class="form-group">
                                              <label for="first-name-vertical">Select Method Type</label>
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block mr-2 mb-1">
                                                  <fieldset>
                                                    <div class="radio radio-primary">
                                                        <input type="radio" name="method_type" class="method_type" id="method_1" value="1" checked="">
                                                        <label for="method_1">Bank</label>
                                                    </div>
                                                  </fieldset>
                                                </li>
                                                
                                                <li class="d-inline-block mr-2 mb-1">
                                                  <fieldset>
                                                    <div class="radio radio-primary">
                                                        <input type="radio" name="method_type" class="method_type" id="method_2" value="2">
                                                        <label for="method_2" >Mobile Bank</label>
                                                    </div>
                                                  </fieldset>
                                                </li>
                                            </ul>
                                          </div>
                                        </div>
                                        
                                        <div class="col-12">
                                          <div class="form-group">
                                            <label for="first-name-vertical">Select Bank</label>
                                            <select class="form-control" name="payment_bank_id" id="payment_bank_id" required>
                                              <option>Select an options</option>
                                              <?php foreach($all_bank as $bank): ?>
                                              <option value="{{ $bank->id }}">{{ $bank->bank_name }}</option>
                                              <?php endforeach; ?>
                                            </select>
                                            
                                          </div>
                                        </div>
                                        <div class="col-12">
                                          <div class="form-group">
                                            <label for="email-id-vertical">Bank Details</label>
                                            <br>
                                            <span id="payment_details">
                                                
                                            </span>
                                          </div>
                                        </div>
                                        
                                        <div class="col-12">
                                          <div class="form-group">
                                            <h4>Please Input Your Payment Document</h4>
                                          </div>
                                        </div>

                                        
                                        <div class="col-12 onlyforbank">
                                          <div class="form-group">
                                            <label for="contact-info-vertical">Branch Name</label>
                                            <input type="text" id="contact-info-vertical" class="form-control" name="branch_name" placeholder="Branch Name" >
                                          </div>
                                        </div>   
                                        
                                        
                                        <div class="col-12 onlyforbank">
                                          <div class="form-group">
                                            <label for="contact-info-vertical">Account Name</label>
                                            <input type="text" id="contact-info-vertical" class="form-control" name="account_name" placeholder="Account Name" >
                                          </div>
                                        </div>
                                        
                                        <div class="col-12">
                                          <div class="form-group">
                                            <label for="contact-info-vertical">Account Number</label>
                                            <input type="text" id="contact-info-vertical" class="form-control" name="account_number" placeholder="Account Number" required>
                                          </div>
                                        </div>
                                        
                                        <div class="col-12">
                                          <div class="form-group">
                                            <label for="contact-info-vertical">Transaction ID</label>
                                            <input type="text" id="contact-info-vertical" class="form-control" name="transaction_number" placeholder="Trx****" required>
                                          </div>
                                        </div>
                                        
                                        <div class="col-12 onlyforbank">
                                          <div class="form-group">
                                            <label for="contact-info-vertical">Recipt Copy</label>
                                            <input type="file" id="contact-info-vertical" class="form-control" name="recept_copy" >
                                          </div>
                                        </div>
                                        
                                        <input type="hidden" name="package_id" value="<?php echo $package->id; ?>"/>

                                        <div class="col-12 d-flex justify-content-end">
                                          <button type="submit" class="btn btn-primary mr-1">Submit</button>
                                          <button type="reset" class="btn btn-light-secondary">Reset</button>
                                        </div>
                                      </div>
                                    </div>
                                  {!! Form::close() !!}
                                </div>
                              </div>
                            </div>
                          </div>
                        </section>
                    </div>
                    

                </div>
            </section>
            <!-- Dashboard Analytics end -->

        </div>
    </div>
</div>
<!-- END: Content-->
@endsection

@section('js')
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;
        case 'failed':
        toastr.error("{{ Session::get('message') }}");
        break;
    }
    @endif
</script>
<script>

    $(".method_type").change(function(e){
        e.preventDefault() ;
        
        var method_type = $(this).val() ;
         
        if(method_type == 1){
            $(".onlyforbank").removeAttr('style');
            $("[name=branch_name]").attr('required');
            $("[name=account_name]").attr('required');
            
            $("#payment_details").empty() ;
        }else{
            $(".onlyforbank").css('display','none');
            $("[name=branch_name]").removeAttr('required');
            $("[name=account_name]").removeAttr('required');
            
            $("#payment_details").empty() ;
        }
        
        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
        });
        $.ajax({
            'url':"{{ url('/getallbankforpayment') }}",
            'type':'post',
            'dataType':'text',
            data: {method_type: method_type},
            success:function(data){
            	
            	$("#payment_bank_id").empty().append(data);

            }
        });
        
        
        
    })
    
    $('#payment_bank_id').change(function(e){
        e.preventDefault() ;
        var bank_id     = $(this).val();
        var package_id  = <?php echo $package->id; ?>;
        var method_type = $('.method_type:checked').val() ;
        
        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
        });
        $.ajax({
            'url':"{{ url('/getsupplierpaymentbandetails') }}",
            'type':'post',
            'dataType':'text',
            data: {package_id: package_id, bank_id:bank_id,method_type:method_type},
            success:function(data){
            	$("#payment_details").empty().html(data);

            }
        });
        
    });


</script>

<script>

    $("#packagepayment").submit(function(e){
        e.preventDefault();
        
        let myForm = document.getElementById('packagepayment');
        let formData = new FormData(myForm);
        
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            'url':"{{ url('/insertsupplierpackageupdateinformation') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data == "all_filed_r_required") {
                    alert("Oh shit!! All Star Mark Filed Are Required");
                    return false ;
                }else if(data == "package_exist"){
                    alert("Oh shit!! Sorry! Already Have a pending request please wait for admin response")
                    return false ;
                }else{
                    alert("Thanks ! Package Update Successfully. Please Wait for admin approve");
                    setTimeout(function(){

                        window.location.href = "<?php echo env('APP_URL'); ?>";;
                    }, 3000);
                    return false ;
                }
            }
        })
    })

</script>
@endsection
