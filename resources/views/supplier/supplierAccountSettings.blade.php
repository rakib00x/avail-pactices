@extends('supplier.masterSupplier')
@section('title')
Supplier Accounts Settings
@endsection
@section('content')
@push('styles')
<style>
    @media screen and (min-width: 992px){
        .modal-dialog {
            max-width: 1000px!important;
        }
    }
    .siam_active .card{
        border: 1px solid red ;
    }
    .siam_class{
        cursor: pointer;
    }

    .selected_icon{
        position: absolute;
        padding: 38%;
        font-size: 30px;
        color: #4ebd37;
    }
</style>
@endpush
<div class="app-content content">
    <div class="content-overlay"></div>
    <?php $default_banner = DB::table('tbl_default_setting')->first(); ?>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">Account Settings</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Pages</a>
                                </li>
                                <li class="breadcrumb-item active"> Account Settings
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- account setting page start -->
            <section id="page-account-settings">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <!-- left menu section -->
                            <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                                <ul class="nav nav-pills flex-column">

                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                            <i class="bx bx-cog"></i>
                                            <span>General</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                            <i class="bx bx-lock"></i>
                                            <span>Change Password</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="account-pill-info" data-toggle="pill" href="#account-vertical-info" aria-expanded="false">
                                            <i class="bx bx-info-circle"></i>
                                            <span>Info</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="company-pill-info" data-toggle="pill" href="#company-vertical-info" aria-expanded="false">
                                            <i class="bx bx-info-circle"></i>
                                            <span>Company Information</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="store-information" data-toggle="pill" href="#store-information-info" aria-expanded="false">
                                            <i class="bx bx-home"></i>
                                            <span>Store Information</span>
                                        </a>
                                    </li>
                                </ul>

                                <?php if ($values->profile_verify_status == 1): ?>
                                    <img src="{{URL::to('public/images/verify_image.png')}}" alt="" class="img-fluid m-2" style="width: 215px;height: 192px;border-radius: 20px;margin-left:0px!important;">
                                <?php endif ?>
                                
                            </div>
                            <!-- right content section -->
                            <div class="col-md-9">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">
                                                    {!! Form::open(['url' =>'updateSupplierGeneralInfo','method' => 'post','role' => 'form', 'files'=>'true']) !!}
                                                    <div class="media">
                                                        <a href="#">
                                                            <?php if($values->image != "" || $values->image != null){
                                                                if(strpos($values->image, "https") !== false){
                                                                    $image_url = $values->image ;
                                                                } else{
                                                                    $image_url = "public/images/spplierPro/".$values->image;
                                                                }
                                                            }else{
                                                                $image_url = "/public/images/defult/".$default_banner->logo;
                                                            } ?>
                                                            <span class="media_image">
                                                                <img src='{{URL::to("$image_url")}}' class="rounded mr-75" alt="profile image"  height="64" width="64">
                                                            </span>

                                                            <input type="hidden" value="" name="selected_image" id="selected_image" >
                                                            
                                                        </a>
                                                        <div class="media-body mt-25">
                                                            <div class="col-12 px-0 d-flex flex-sm-row flex-column justify-content-start">
                                                                <label for="select-files" class="btn btn-sm btn-light-primary ml-50 mb-50 mb-sm-0">
                                                                    <span>Upload new photo</span>
                                                                    <input id="select-files" class="select-files" name="image" type="file" hidden="" value="{{ $values->image }}">
                                                                </label>
                                                            </div>
                                                            <p class="text-muted ml-1 mt-50"><small>Allowed JPG, GIF or PNG. Max
                                                                size of800kB</small></p>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>First Name</label>
                                                                    <input type="text" class="form-control" placeholder="First Name" name="first_name" value="{{ $values->first_name }}" required>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Last Name</label>
                                                                    <input type="text" class="form-control" placeholder="Last Name" name="last_name" value="{{ $values->last_name }}" required >
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>E-mail</label>
                                                                    <input type="email" class="form-control" name="email" value="{{ $values->email }}" required="">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Designation</label>
                                                                    <input type="text" class="form-control" name="designation" value="{{ $values->designation }}" maxlength="50" >
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Address</label>
                                                                    <input type="text" class="form-control" name="address" value="{{ $values->address }}" >
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Zip Code</label>
                                                                    <input type="text" class="form-control" name="zipPostalCode" value="{{ $values->zipPostalCode }}" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Province/State</label>
                                                                    <input type="text" class="form-control" name="stateName" value="{{ $values->stateName }}" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>City</label>
                                                                    <input type="text" class="form-control" name="city" value="{{ $values->city }}" >
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button type="submit" id="updateUserBasicInfo" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                            changes</button>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>

                                                </div>
                                                <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">
                                                    <form  id="password_change" novalidate>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Old Password</label>
                                                                        <input type="password" class="form-control" name="old_password" required placeholder="Old Password" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <p style="color: red;text-align: center;">{{$errors->first('password')}}</p>
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>New Password</label>
                                                                        <input type="password" name="password" class="form-control" placeholder="New Password" minlength="6" required >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <p style="color: red;text-align: center;">{{$errors->first('password')}}</p>
                                                                    <div class="controls">
                                                                        <label>Retype new Password</label>
                                                                        <input type="password" name="con-password" class="form-control" placeholder="Retype new Password" minlength="6" required="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                                changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">
                                                    <form id="userInfo" novalidate>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="controls">
                                                                   <label>Birthday</label>
                                                                    <input type="date" class="form-control" name="dob" value="{{$values->dob}}" required placeholder="Birth date date">
                                                                    </div>
                                                                    </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Country</label>
                                                                    <select class="form-control" name="country_id" id="accountSelect" required="" disabled="">
                                                                        <option value="" <?php if($values->country == ""){echo "selected"; }  ?>>Select Country</option>
                                                                        <?php foreach ($all_countries as $cvalue) { ?>
                                                                            <option value="<?php echo $cvalue->id; ?>" <?php if($values->country == $cvalue->id){echo "selected";}else{echo " ";} ?>><?php echo $cvalue->countryName; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Phone</label>
                                                                        <input type="text" class="form-control" required placeholder="Phone number" name="mobile" value="<?php echo $values->mobile ; ?>" data-validation-required-message="This phone number field is required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Store Name</label>
                                                                    <input type="text" class="form-control" name="storeName" placeholder="Store Name" value="<?php echo $values->storeName ; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Website</label>
                                                                    <input type="text" class="form-control" name="weburl" placeholder="Website address" value="<?php echo $values->companyWebsite ; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                                changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div> 

                                                <div class="tab-pane fade" id="company-vertical-info" role="tabpanel" aria-labelledby="company-pill-info" aria-expanded="false">
                                                    <form id="company_information" novalidate>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Telephone</label>
                                                                        <input type="text" class="form-control" required placeholder="Telephone" name="companyTelephone" value="<?php echo $values->companyTelephone ; ?>" data-validation-required-message="This Telephone number field is required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Company Name</label>
                                                                        <input type="text" class="form-control" required placeholder="Company Name" name="companyName" value="<?php echo $values->companyName; ?>" data-validation-required-message="This Company Name field is required">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Operational Address</label>
                                                                    <input type="text" class="form-control" name="companyAddress" placeholder="Opreational Address" value="<?php echo $values->companyAddress ; ?>">
                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Company Short Description <span>Max Lenght: 131</span></label>
                                                                    <textarea class="form-control" name="companyDetails" placeholder="Write some word in your company" maxlength="131"><?php echo $values->companyDetails ; ?></textarea>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <label>Google map Embed</label>
                                                                    <textarea class="form-control" name="googleMapLocation" width="100" height="70" placeholder="Google Map Embed Link"><?php echo $values->googleMapLocation ; ?></textarea>
                                                                    
                                                                    <div>
                                                                        <iframe src="<?php echo $values->googleMapLocation ; ?>" width="100" height="70" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-12">
                                                                
                                                                <div class="row">
                                                              <div class="col-xs-4">
                                                               <fieldset class="form-group">
                                                                        <textarea class="form-control" name="company_profile" rows="20" cols="50" placeholder="Company Description" id="product_details_users" required=""><?php echo $values->company_profile ; ?></textarea>
                                                                    </fieldset>
                                                             
                                                              </div>
                                                            </div>
                                                               
                                                            </div>
                                                            
                                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                                changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>   

                                                <div class="tab-pane fade " id="store-information" role="tabpanel" aria-labelledby="store-information-info" aria-expanded="false">
                                                    <form  id="password_change" novalidate>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>Old Password</label>
                                                                        <input type="password" class="form-control" name="old_password" required placeholder="Old Password" >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <p style="color: red;text-align: center;">{{$errors->first('country')}}</p>
                                                                <div class="form-group">
                                                                    <div class="controls">
                                                                        <label>New Password</label>
                                                                        <input type="password" name="password" class="form-control" placeholder="New Password" minlength="6" required >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group">
                                                                    <p style="color: red;text-align: center;">{{$errors->first('country')}}</p>
                                                                    <div class="controls">
                                                                        <label>Retype new Password</label>
                                                                        <input type="password" name="con-password" class="form-control" placeholder="Retype new Password" minlength="6" required="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                                <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                                changes</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>                                             

                                                <div class="tab-pane fade" id="store-information-info" role="tabpanel" aria-labelledby="store-information" aria-expanded="false">
                                                    {!! Form::open(['id' =>'addSupplierDocuments','method' => 'post','role' => 'form', 'files'=>'true']) !!}
                                                    <div class="row">

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>NID Card/ Driving Licence/ Passport <span style="color: red;">Scan Copy</span></label>

                                                                    <div class="media">
                                                                        <a href="#">
                                                                            <?php if($values->p_verify_status == 0){
                                                                                $image_url3 = $values->legalDocument;
                                                                            }elseif($values->p_verify_status != 0){
                                                                                $image_url3 = $values->temp_legal_document;
                                                                            }else{
                                                                                $image_url3 = "";
                                                                            } ?>

                                                                            <?php if ($image_url3 != ""): ?>
                                                                                <img src='{{URL::to("$image_url3")}}' class="rounded mr-75" alt="profile image"  height="64" width="100">  
                                                                                <?php if ($values->profile_verify_status == 1): ?>
                                                                                    <span style="color: green;"> Verified</span>
                                                                                <?php else: ?>
                                                                                    <span style="color: red;">Not Verified</span>  
                                                                                <?php endif ?>
                                                                            <?php endif ?>
                                                                        </a>
                                                                    </div>

                                                                    <?php if ($values->profile_verify_status == 1): ?>
                                                                        <input type="file" class="form-control" name="personal_licence" >  
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Business Licence <span style="color: red;">Scan Copy</span></label>

                                                                    <div class="media">
                                                                        <a href="#">
                                                                            <?php if($values->b_verify_status == 0){
                                                                                $image_url2 = $values->companyLicenseCopy;
                                                                            }elseif($values->b_verify_status != 0){
                                                                                $image_url2 = $values->temp_compny_license;
                                                                            }else{
                                                                                $image_url2 = "";
                                                                            } ?>
                                                                            <?php if ($image_url2 != ""): ?>
                                                                                <img src='{{URL::to("$image_url2")}}' class="rounded mr-75" alt="profile image"  height="64" width="100"> 
                                                                                <?php if ($values->profile_verify_status == 1): ?>
                                                                                    <span style="color: green;"> Verified</span>
                                                                                <?php else: ?>
                                                                                    <span style="color: red;">Not Verified</span>  
                                                                                <?php endif ?>
                                                                            <?php endif ?>
                                                                        </a>
                                                                    </div>

                                                                    <?php if ($values->profile_verify_status == 1): ?>
                                                                        <input type="file" class="form-control" name="business_licence" >  
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <div class="controls">
                                                                    <label>Others Documents <span style="color: red;">Scan Copy</span></label>

                                                                    <div class="media">
                                                                        <a href="#">
                                                                            <?php if($values->others_document != "" || $values->others_document != null){
                                                                                $image_url = $values->others_document;
                                                                            }else{
                                                                                $image_url = "";
                                                                            } ?>
                                                                            <?php if ($image_url != ""): ?>
                                                                                <img src='{{URL::to("$image_url")}}' class="rounded mr-75" alt="profile image"  height="64" width="64">
                                                                            <?php endif; ?>
                                                                            
                                                                        </a>
                                                                    </div>

                                                                    <input type="file" class="form-control" name="other_documents" >
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 d-flex flex-sm-row flex-column justify-content-end">
                                                            <button type="submit" class="btn btn-primary glow mr-sm-1 mb-1">Save
                                                            changes</button>
                                                        </div>
                                                        {!! Form::close() !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
            <!-- account setting page ends -->

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab-fill" data-toggle="tab" href="#home-fill" role="tab" aria-controls="home-fill" aria-selected="true">
                                        Select File
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab-fill" data-toggle="tab" href="#profile-fill" role="tab" aria-controls="profile-fill" aria-selected="false">
                                        Upload File
                                    </a>
                                </li>
                            </ul>

                            <input type="text" name="search_keyword" id="search_keyword" class="form-control col-md-4" placeholder="Search">
                            <button type="submit" class="btn btn-primary" onclick="insertMediaImage()">Submit</button>
                            <button type="button" class="close" data-dismiss="modal" onclick="clickMediaHidden()">&times;</button>

                        </div>
                        <div class="modal-body">
                            <!-- Tab panes -->
                            <div class="tab-content pt-1">
                                <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                    <div class="row" id="table_data">
                                        
                                    </div>
                                </div>
                                <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                    <form method="post"  action="{{url('supplierImage/upload')}}" enctype="multipart/form-data" 
                                    class="dropzone" id="dropzone">
                                    @csrf
                                </form>   
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-default" id="saveImage">Save</button>
                                </div>
                            </div>

                        </div>
                        <!-- Nav Filled Ends -->
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection

@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>

 <script src="{{ URL::to('//cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.3/tinymce.min.js') }}" integrity="sha512-DB4Mu+YChAdaLiuKCybPULuNSoFBZ2flD9vURt7PgU/7pUDnwgZEO+M89GjBLvK9v/NaixpswQtQRPSMRQwYIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      tinymce.init({
        selector: '#product_details_users',
        plugins: 'code lists',
          mobile: {
            menubar: true,
            plugins: 'autosave lists autolink',
            toolbar: ' styleselect | bold italic underline alignleft aligncenter alignright alignjustify bullist numlist | link'
          }
      });
    </script>
<script>
    $(document).ready(function(){
        $("iframe").width(800);

        $('body').on('click', '#myBtn', function (e) {
            $("#myModal").modal();
            return false ;
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getAllSupplierSingleImage') }}",
            'type':'get',
            'dataType':'text',
            success:function(data){
                $("#table_data").empty();
                $("#table_data").html(data);

            }
        });

    });

    $('body').on('click', '.single_image_select', function (e) {
        e.preventDefault();
        $('.single_image_select').removeClass('siam_active') ;
        $(this).addClass('siam_active');
        $('#myModal').modal('show');
        $('.icon_single_show').css('display', 'none') ;
        $(this).find('.icon_single_show').removeAttr('style');
        var inputvalu = $(this).find('.single_image_value').val();
        console.log(inputvalu);
        $("[name=selected_image]").val(inputvalu) ;

    });

    function insertMediaImage(){
        var inputvalus = $("[name=selected_image]").val() ;
        console.log(inputvalus) ;

        $('#myModal').modal('hide');
        var x = document.createElement("IMG");
        x.setAttribute("src", "public/images/" + inputvalus);
        x.setAttribute("width", "200");
        x.setAttribute("height", "200");
        x.setAttribute("alt", "");
        $(".media_image").empty().append('<img width="64px" height="64px" class="rounded mr-75" src="public/images/'+inputvalus+'" />');

        $(".select-files").val(inputvalus) ;
    }

    function clickMediaHidden(){
        $("#selected_image").val("");
        $('.icon_single_show').css('display', 'none');
        $('.single_image_select').removeClass('siam_active') ;
        $(".select-files").val("") ;
    }

    Dropzone.options.dropzone =
    {
        maxFilesize: 12,
        renameFile: function(file) {
            var dt = new Date();
            var time = dt.getTime();
            return time+file.name;
        },
        acceptedFiles: ".jpeg,.jpg,.png,.gif",
        addRemoveLinks: true,
        timeout: 50000,
        removedfile: function(file) 
        {
            var name = file.upload.filename;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url("/image/meta_delete") }}',
                data: {filename: name},
                success: function (data){
//console.log("File has been successfully removed!!");
},
error: function(e) {
    console.log(e);
}});
            var fileRef;
            return (fileRef = file.previewElement) != null ? 
            fileRef.parentNode.removeChild(file.previewElement) : void 0;
        },

        success: function(file, response) 
        {
            console.log(response);
        },
        error: function(file, response)
        {
            console.log(response) ;
            return false;
        }
    };

    $("#saveImage").click(function(e){
        e.preventDefault() ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/supplierSaveImage') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                Dropzone.forElement("#dropzone").removeAllFiles(true);
                toastr.success('Thanks !! Media Add Successfully Compeleted', { positionClass: 'toast-bottom-full-width', });
                $.ajax({
                    'url':"{{ url('/getAllSupplierSingleImage') }}",
                    'type':'get',
                    'dataType':'text',
                    success:function(data){
                        $("#table_data").empty();
                        $("#table_data").html(data);

                    }
                });
                return false;
            }
        });


    }) ;

    $('body').on('keyup', '#search_keyword', function (e) {
        e.preventDefault();

        var search_keyword = $(this).val() ;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/supplierMediaImageSearch') }}",
            'type':'post',
            'dataType':'text',
            data: {search_keyword: search_keyword},
            success:function(data){
                $("#table_data").empty();
                $("#table_data").html(data);

            }
        });

    });

</script>
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
        setTimeout(function(){
            location.reload();
        }, 3000);
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
    $("#password_change").submit(function(e){
        e.preventDefault();

        var old_password        = $("[name=old_password]").val() ;
        var password            = $("[name=password]").val() ;
        var confrim_password    = $("[name=con-password]").val() ;


        if (old_password == "") {
            toastr.warning('Input Old Password First', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        if(password == "" || confrim_password == ""){
            toastr.warning('Password And Confrim Password Can Not Be Empty', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        if(password != confrim_password){
            toastr.warning('Sorry Password And Confrim Password Not Match', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/supplierPasswordChange') }}",
            'type':'post',
            'dataType':'text',
            data: {old_password: old_password, password:password, confrim_password:confrim_password},
            success:function(data){
                console.log(data) ;
                if (data == "password_not_match") {
                    toastr.warning('Sorry Old Password Not Match', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }else{
                    toastr.success('Thanks Password Change Successfully', { positionClass: 'toast-bottom-full-width', });
                    $("[name=old_password]").val("") ;
                    $("[name=password]").val("") ;
                    $("[name=con-password]").val("") ;
                    return false ;
                }
            }
        });
    });       

    $("#userInfo").submit(function(e){
        e.preventDefault();

        var dob         = $("[name=dob]").val() ;
        var mobile      = $("[name=mobile]").val() ;
        var storeName   = $("[name=storeName]").val() ;
        var weburl      = $("[name=weburl]").val() ;


        if (dob == "") {
            toastr.warning('Select Date Of Birth', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        if(mobile == ""){
            toastr.warning('Input Your Mobile Number', { positionClass: 'toast-bottom-full-width', });
            return false ;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updateSupplierBasicInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {dob:dob, storeName:storeName, mobile:mobile, weburl:weburl},
            success:function(data){
                console.log(data) ;
                if (data == "duplicate_found") {
                    toastr.warning('Sorry .. Mobile Number Alraey Exist', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }else if(data == "not_adult"){
                    toastr.warning('Sorry Age Must Upper Then 18+', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }else if(data == "invalid_dob"){
                    toastr.warning('Sorry Invalid DOB Check It Menually', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }else{
                    toastr.success('Info Update Successfully', { positionClass: 'toast-bottom-full-width', });
                    return false ;
                }
            }
        });
    });


    $("#addSupplierDocuments").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('addSupplierDocuments');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/insertAddSupplierDocuments') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data) {
                    toastr.success('Store Information Add / Update Successfully', { positionClass: 'toast-bottom-full-width', });

                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }
            }
        })
    })    

    $("#company_information").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('company_information');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updateSupplierCompanyInformation') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data) {
                    toastr.success('Company Information Update Successfully', { positionClass: 'toast-bottom-full-width', });

                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }
            }
        })
    })

</script>   

@endsection