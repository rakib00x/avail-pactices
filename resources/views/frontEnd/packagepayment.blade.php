@extends('frontEnd.master')
@section('title','Package Payment')
@section('content')
<div class="wrapper" style="background: #f4f4f4;">

        <div class="container">
        <!-- start of the four box -->
        <div class="columns">

            <div class="column is-three-fifths is-offset-one-fifth box mb-5 pt-5">
                <center><h1 class="pl-5 pb-5" style="font-size: 20px;font-weight: bold;">Your Selected Package Is : {{ $package_info->package_name }}</h1></center>
                
                <div class="columns pb-5 pl-5">
                	{!! Form::open(['id' =>'packagepayment','method' => 'post','role' => 'form', 'files' => true]) !!}
                    <table>

                        <tr>
                            <td>Please Payment Type:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                &nbsp;&nbsp;<input type="radio" name="method_type" class="method_type" value="1" checked> <label style="font-size:21px;">Bank</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="method_type" class="method_type" value="2"> <label style="font-size:21px;">Mobile Bank</label>
                            </td>
                        </tr>

                        <tr>
                            <td class="td-right">Select Payment Bank: *</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <?php 
                                    $result = DB::table('tbl_bank')
                                        ->orderBy('bank_name', 'asc')
                                        ->where('status', 1)
                                        ->get() ;
                                 ?>
                                <select class="reg-input" id="payment_bank_id" name="payment_bank_id" required="">
                                    <option value="">Select Bank</option>
                                    <?php foreach ($result as $value): ?>
                                        <option value="{{ $value->id }}">{{ $value->bank_name }}</option>
                                    <?php endforeach ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="td-right">Bank Details:</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <span id="payment_details">
                                    
                                </span>
                            </td>
                        </tr> 
                        
                        <tr>
                            <td class="td-right"></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <h4 class="pl-5 pb-5" style="font-size: 20px;font-weight: bold;">Please Input Your Payment Document</h4>
                            </td>
                        </tr> 
                        
                        <tr class="onlyforbank">
                            <td class="td-right">Branch Name: *</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" type="text" name="branch_name">
                            </td>
                        </tr>

                        <tr class="onlyforbank">
                            <td class="td-right">Account Name: *</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" name="account_name" type="text">
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="td-right">Account Number: *</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" name="account_number" type="text" required="">
                            </td>
                        </tr>

                        <tr>
                            <td class="td-right">Transaction Number: *</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" name="transaction_number" id="transaction_number" type="text"  required>
                            </td>
                        </tr>
                        
                        <tr class="store_name_validation onlyforbank">
                            <td class="td-right">Recept Copy</td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-input" name="recept_copy" id="recept_copy" type="file" >
                            </td>
                        </tr>

                        <input type="hidden" name="package_id" value="<?php echo $package_info->id; ?>">
                        
                        <tr>
                            <td></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                <input class="reg-submit" type="submit" value="Agree and Payment">
                            </td>
                        </tr>

                    </table>

                    {!! Form::close() !!}
                </div>
            </div>

        </div>
        <!-- end of the four box -->
    </div>
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

        }else{
            $(".onlyforbank").css('display','none');
            $("[name=branch_name]").removeAttr('required');
            $("[name=account_name]").removeAttr('required');
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
        var bank_id = $(this).val();
        var package_id = <?php echo $package_info->id; ?>;
        var method_type = $('.method_type:checked').val() ;
        
        $.ajaxSetup({
	        headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
        });
        $.ajax({
            'url':"{{ url('/getpaymentbandetails') }}",
            'type':'post',
            'dataType':'text',
            data: {package_id: package_id, bank_id:bank_id,method_type:method_type},
            success:function(data){
            	
            	$("#payment_details").empty().append(data);

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
            'url':"{{ url('/insertsupplierpackagepaymentinfo') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data == "all_filed_r_required") {
                    toastr.info('Oh shit!! All Star Mark Filed Are Required', "warning", { positionClass: 'toast-top-center', });
                    return false ;
                }else{
                    toastr.success('Thanks ! Package Update Successfully. Please Wait for admin approve', "success", { positionClass: 'toast-top-center', });
                    setTimeout(function(){
                        window.location.href = "https://www.availtrade.com/package/";
                    }, 3000);
                    return false ;
                }
            }
        })
    })

</script>
@endsection
