@extends('admin.masterAdmin')
@section('title','Seller Payouts')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- users list start -->
            <section class="users-list-wrapper">
                <div class="tab-pane" id="profile" aria-labelledby="profile-tab" role="tabpanel">
                    <!-- user profile nav tabs profile start -->
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-12 col-sm-3 text-center mb-1 mb-sm-0">
                                                <?php if ($value->image): ?>
                                                    <img src="{{URL::to('public/images/'.$value->image)}}" class="rounded" alt="group image" height="120" width="120" />
                                                <?php else: ?>
                                                    <img src="{{URL::to('public/images/avatar.png')}}" class="rounded" alt="group image" height="120" width="120" />
                                                <?php endif ?>
                                                
                                            </div>
                                            <div class="col-12 col-sm-9">
                                                <div class="row">
                                                    <div class="col-12 text-center text-sm-left">
                                                        <h3 class="media-heading mb-0"><?php echo $value->first_name." ".$value->last_name; ?></h3>
                                                        <small class="text-muted align-top"><a href="#"><?php echo $value->first_name." ".$value->last_name; ?></a></small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="card-title">About <?php echo $value->companyName ?></h5>
                                        <ul class="list-unstyled">
                                            <li><i class="cursor-pointer bx bx-map mb-1 mr-50"></i><?php echo $value->address ; ?></li>
                                            <li><i class="cursor-pointer bx bx-map mb-1 mr-50"></i><?php echo $value->companyAddress; ?></li>
                                            <li><i class="cursor-pointer bx bx-phone-call mb-1 mr-50"></i><?php echo $value->mobile; ?> </li>
                                            <li><i class="cursor-pointer bx bx-envelope mb-1 mr-50"></i><?php echo $value->email; ?></li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <h5 class="card-title">Payout Info</h5>
                                        <ul class="list-unstyled">
                                            <li><i class="cursor-pointer bx bx-map mb-1 mr-50"></i>Bank Name :</li>
                                            <li><i class="cursor-pointer bx bx-map mb-1 mr-50"></i>Bank Acc Name :</li>
                                            <li><i class="cursor-pointer bx bx-phone-call mb-1 mr-50"></i>Bank Acc Number : </li>
                                            <li><i class="cursor-pointer bx bx-envelope mb-1 mr-50"></i>Bank Routing Number :</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <?php if($value->legalDocument != null):  ?>
                                                <div class="col-md-6">
                                                    <h4>NID Card/ Driving Licence/ Passport</h4>
                                                    <img src="{{ URL::to('/'.$value->legalDocument) }}" alt="" width="150" height="150">
                                                </div>
                                            <?php endif ; ?>

                                            <?php if($value->temp_legal_document != null):  ?>
                                                <div class="col-md-6">
                                                    <h4>Temporary NID Card/ Driving Licence/ Passport</h4>
                                                    <img src="{{ URL::to('/'.$value->temp_legal_document) }}" alt="" width="150" height="150">
                                                </div>
                                            <?php endif ; ?>
                                        </div>

                                        <div class="row">
                                            <?php if($value->companyLicenseCopy != null):  ?>
                                            <div class="col-md-6">
                                                <h4>Business Licence</h4>
                                                <img src="{{ URL::to('/'.$value->companyLicenseCopy) }}" alt="" width="150" height="150">
                                            </div>
                                            <?php endif ; ?>

                                            <?php if($value->temp_compny_license != null):  ?>
                                            <div class="col-md-6">
                                                <h4>Temporary Business Licence</h4>
                                                <img src="{{ URL::to('/'.$value->temp_compny_license) }}" alt="" width="150" height="150">
                                            </div>
                                            <?php endif ; ?>
                                        </div>

                                        <div class="row mt-2">
                                            <h4 class="col-md-12">Verify Info</h4>
                                            <div class="form-group col-md-2">
                                                <input type="radio" name="profile_verify_status" <?php if($value->profile_verify_status == 1 ){echo "checked"; }else{echo ""; } ?> onclick="changeSupplierStatus(1)" value="1">
                                                <label>Verified</label>
                                            </div>
                                            <div class="form-group col-md-2">
                                                <input type="radio" name="profile_verify_status" <?php if($value->profile_verify_status != 1 ){echo "checked"; }else{echo ""; } ?> onclick="changeSupplierStatus(2)" value="2">
                                                <label>Not Verified</label>
                                            </div>
                                        </div>  
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <h6><small class="text-muted">Bio</small></h6>
                                        <p>Built-in customizer enables users to change their admin panel look & feel based on their
                                            preferences Beautifully crafted, clean & modern designed admin theme with 3 different demos &
                                        light - dark versions.</p>
                                    </div>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Name</th>
                                                                <th class="text-center">Number</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>Total Products</td>
                                                                <td>10</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Total orders</td>
                                                                <td>0</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Total Sold Amount</td>
                                                                <td>$0.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Wallet Balance</td>
                                                                <td>$20</td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- user profile nav tabs profile ends -->
                </div>
            </section>
            <!-- users list ends -->
        </div>
    </div>
</div>
<!-- END: Content-->
@endsection
@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script>
    function changeSupplierStatus(profile_verify_status){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/changeAdminSupplierStatus') }}",
            'type':'post',
            'dataType':'text',
            data:{profile_verify_status:profile_verify_status, supplier_id:<?php echo $value->id; ?>},
            success:function(data){
                if (data == "success") {
                    toastr.success('Thanks Seller Profile Verify Status Change Successfully', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }
            }
        });
    }
</script>
@endsection