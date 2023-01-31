@extends('supplier.masterSupplier')
@section('title')
Product
@endsection
@section('content')

@push('styles')

<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="{{ URL::to('public/frontEnd/assets/css/tagsinput.css') }}" rel="stylesheet" type="text/css">

<style>
    @media screen and (min-width: 992px){
        .modal-dialog {
            max-width: 1000px!important;
        }
    }
    .siam_active .card{
        border: 2px solid #42b72a ;
    }

    .selected_icon{
        position: absolute;
        padding: 38%;
        font-size: 30px;
        color: #4ebd37;
    }

    .siam_class{
        cursor: pointer;
    }

    .meta_class_image{
        cursor: pointer;
    }

    .remove_project_file3{
        width: 100px;
        height: 100px;
        float: left;
        margin: 5px;
    }        

    .remove_meta_image{
        width: 200px;
        height: 200px;
        float: left;
        margin: 5px;
    }

    .note-editor.note-airframe .note-editing-area .note-editable, .note-editor.note-frame .note-editing-area .note-editable {
        padding: 10px;
        overflow: auto;
        word-wrap: break-word;
        height: 265px;
    }
    .note-editor.note-airframe .note-editing-area .note-editable, .note-editor.note-frame .note-editing-area .note-editable p,span,div{
        color: #000 !important;

    }
    
    .bootstrap-tagsinput input{
        color: #8a99b5!important;
    }
    
    #title {
    padding: 10px 0;
    border-bottom: 2px solid #ccc;
    margin-bottom: 10px;
}

.controls {
    display: flex;
    justify-content: space-between;
}

.main-controls {
    display: flex;
}

.control-btn-container {
    display: flex;
}

.control-btn {
    margin-left: 8px;
    width: 38px;
    height: 100%;
}

#filename-input {
    margin-left: 10px;
}

#product_description {
    background-color: #fff;
   color: blue;
    padding: 20px;
    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.5);
    outline: none;
    max-width: 100%;
    min-height: 300px;
    margin: 30px 0;
}

</style>
@endpush
<div class="app-content content">
<div class="content-overlay"></div>
<div class="content-wrapper">
<div class="content-header row">
<div class="content-header-left col-12 mb-2 mt-1">
<div class="row breadcrumbs-top">
<div class="col-12">
<h5 class="content-header-title float-left pr-1 mb-0">Product Information</h5>
<div class="breadcrumb-wrapper col-12">
<ol class="breadcrumb p-0 mb-0">
<li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
</li>
<li class="breadcrumb-item"><a href="#">Pages</a>
</li>
<li class="breadcrumb-item active">Product Information 
</li>
</ol>
</div>
</div>
</div>
</div>
</div>
<div class="content-body">
<!-- account setting page start -->
<section class="list-group-navigation">
<div class="row">
<div class="col-lg-12">
<div class="card">
<div class="card-header">
<h4 class="card-title">Product Information </h4>
<a style="margin-bottom: -25px;" href="{{URL::to ('/supplierProductsList')}}" class="btn btn-primary float-right" role="button" aria-pressed="true">Product List</a>
<?php
if(Session::get('failed') != null) { ?>
    <div class="alert alert-danger alert-dismissible mb-2" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <div class="d-flex align-items-center">
            <i class="bx bx-error"></i>
            <span>
                <?php echo Session::get('failed') ; ?>
            </span>
        </div>
        <?php echo Session::put('failed',null) ; ?>
    </div>
<?php } ?>
</div>
<div class="card-content">
<div class="card-body">
<form method="post"> 
<div class="row">
<div class="col-12 col-sm-12 col-md-3 ">
<div class="list-group" role="tablist">
<a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab">Add Products <span style="color: red!important;
    font-size: 15px;">*</span></a>
<a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab">Images <span style="color: red!important;
    font-size: 15px;">*</span></a>
<a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab">Video </a>
<a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" style="display:none">Meta  Tag</a>
<a class="list-group-item list-group-item-action" id="list-customer-list" data-toggle="list" href="#list-customer" role="tab" style="display:none">Customer Choice</a>
<a class="list-group-item list-group-item-action" id="list-price-list" data-toggle="list" href="#list-price" role="tab">Price <span style="color: red!important;
    font-size: 15px;">*</span></a>
<a class="list-group-item list-group-item-action" id="list-escription-list" data-toggle="list" href="#list-description" role="tab">Description <span style="color: red!important;
    font-size: 15px;">*</span></a>
<a class="list-group-item list-group-item-action" id="list-Shipping-list" data-toggle="list" href="#list-Shipping" role="tab">Shipping & Payment Info</a>
<!-- <a class="list-group-item list-group-item-action" id="list-PDF-list" data-toggle="list" href="#list-PDF" role="tab">PDF Specification</a> -->
</div>
</div>
<div class="col-12 col-sm-12 col-md-9 mt-1">
<div class="tab-content text-justify" id="nav-tabContent">

<!-- General Part Start -->
<div class="tab-pane show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
    <div class="card-body" style="margin-top: -15px;">
        <div class="form form-horizontal">

            <div class="form-body">
                <div class="row">
                    <div class="col-md-3">
                        <label>Select Category <span style="color: red!important;
    font-size: 15px;">*</span></label>
                    </div>
                    <div class="col-md-9 form-group">
                        <select class="form-control select2" id="product_web_category" name="product_web_category">
                            <option value="0">Select Category</option>
                            <?php foreach ($all_web_category as $wvalue) { ?>
                                <option value="<?php echo $wvalue->id; ?>">{{ $wvalue->category_name."->".$wvalue->secondary_category_name."->".$wvalue->tartiary_category_name }}</option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Product Name <span style="color: red!important;
    font-size: 15px;">*</span></label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="product-name" class="form-control" name="product_name" placeholder="Product Name" required="">
                    </div>

                    <div class="col-md-3">
                        <label>Category <span style="color: red!important;
    font-size: 15px;">*</span></label>
                    </div>
                    <div class="col-md-9 form-group">
                        <div class="form-group">
                            <select class="form-control" id="main_cateory_id" name="main_category_id">
                                <option value="0">Select Category</option>
                                <?php foreach ($all_main_category as $mvalue) { ?>
                                    <option value="<?php echo $mvalue->id; ?>">{{ $mvalue->category_name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Subcategory <span style="color: yellow!important;
    font-size: 15px;">*</span></label>
                    </div>
                    <div class="col-md-9 form-group">
                        <div class="form-group">
                            <select class="form-control" id="secondary_category_id" name="secondary_category_id">
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Brand</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <div class="form-group">
                            <select class="form-control" id="brand_id" name="brand_id" >
                                <option value="">Select Brand</option>
                                <?php foreach ($all_product_brand as $brvalue) { ?>
                                    <option value="{{ $brvalue->id }}">{{ $brvalue->brand_name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Unit <span style="color: red!important;
    font-size: 15px;">*</span></label>
                    </div>
                    <div class="col-md-9 form-group">
                        <select class="select2 form-control" id="product-name" name="unit">
                            <option value="">Select A Unit</option>
                                <?php foreach ($all_unit as $tsvalue) { ?>
                                    <option value="<?php echo $tsvalue->id ; ?>"><?php echo $tsvalue->unit_name; ?></option>
                                <?php } ?>
                            </select>
                    </div>
                    
                </div>
            </div>

        </div>
    </div>
</div>
<!--  Image Part Start -->
<div class="tab-pane" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
    <div class="form form-horizontal">
        <div class="form-body">
            <div class="row">
                <div class="col-md-3">
                    <label>Main Images <span style="color: red!important;
    font-size: 15px;">*</span></label>
                </div>
                <div class="col-md-9 form-group">
                    <input type="file" id="myBtn" class="form-control" name="fname">


                    <ul id="image_siam" class="image_siam list-unstyled">
                    </ul>
                    <span ></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Video Part Start -->
<div class="tab-pane" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list">
    <div class="form form-horizontal">
        <div class="form-body">
            <div class="row">
                <div class="col-md-3">
                    <label>Video Provider</label>
                </div>
                <div class="col-md-9 form-group">
                    <div class="form-group">
                        <select class="form-control" id="accountSelect" name="video_link_type">
                            <option value="1">Youtube </option>
                            <option value="2">DailyMotion</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <label>Video Link</label>
                </div>
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control" name="video_link" placeholder="Video Link">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Meta Title Start -->
<div class="tab-pane" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list" style="display:none">
    <div class="form form-horizontal">
        <div class="form-body">
            <div class="row">
                <div class="col-md-2">
                    <label>Meta Title</label>
                </div>
                <div class="col-md-10 form-group">
                    <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
                </div>
                <div class="col-md-2">
                    <label>Description</label>
                </div>
                <div class="col-md-10 form-group">
                    <fieldset class="form-group">
                        <textarea  maxlength="200" class="form-control" name="meta_description" rows="2"></textarea>
                    </fieldset>
                </div>
                
                <div class="col-md-2">
                    <label>Tags</label>
                </div>
                <div class="col-md-10 form-group">
                    <div class="form-group">
                        <input type="text" data-role="tagsinput" id="producttags" name="producttags" class="sr-only" >
                    </div>
                </div>
                    
                <div class="col-md-2">
                    <label>Meta Image</label>
                </div>
                <div class="col-md-10 form-group">
                    <input type="file" id="meta_image" class="form-control" name="meta_image" >

                    <ul id="meta_image_gallery" class="meta_image_gallery list-unstyled">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Customer Choice Start -->
<div class="tab-pane" id="list-customer" role="tabpanel" aria-labelledby="list-customer-list"><form class="form form-horizontal">
<div class="card-body">
    <div class="form form-horizontal">
        <div class="form-body">
            <div class="row">
                <div class="col-md-12">
                    <p><strong>Select Color / Image</strong></p>
                </div>

                <div class="col-md-5 form-group row">
                    <input type="radio" class="form-control col-md-1 customer_choose_color" name="image__id" value="1">
                    <label for="" class="col-md-10" style="margin-top: 10px;">Color</label>
                </div>

                <div class="col-md-5 form-group row">
                    <input type="radio" class="form-control col-md-1 customer_choose_color" name="image__id" value="2">
                    <label for="" class="col-md-10" style="margin-top: 10px;">Image</label>
                </div>

                <div class="col-md-12">

                    <div class="row color__section" style="display: none;">
                        <div class="col-md-12 form-group row">

                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" id="color_table_id">
                                    <thead>
                                        <tr>
                                            <th>Color</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_color"> 
                                        <tr>
                                            <td><input type="color" class="form-control color_id" name="color_id[]" ></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="submit" class="add_items btn btn-success btn-sm add_another_color" style="float: right;" value="Add More" />
                            </div>
                        </div>
                    </div>

                    <div class="color_image_section" style="display: none;">
                        <input type="file" id="product_color_image_selector" class="form-control" name="fname">

                        <ul id="color_image" class="color_image list-unstyled">
                            
                        </ul>
                    </div>  

                </div>  

                <div class="col-md-12">
                    <p><strong>Select Size</strong></p>
                </div>

                <?php 
                    $all_size = DB::table('tbl_size')->where('supplier_id', Session::get('supplier_id'))->where('status', 1)->get() ;
                 ?>
                <?php foreach ($all_size as $size_value): ?>
                    <div class="col-md-4 form-group row">
                        <input type="checkbox" class="form-control col-md-1 size_id" name="size_id[]" value="<?php echo $size_value->id."/".$size_value->size; ?>">
                        <label for="" class="col-md-10" style="margin-top: 10px;"><?php echo $size_value->size; ?></label>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>
</form></div>
<!-- Price Start -->
<div class="tab-pane" id="list-price" role="tabpanel" aria-labelledby="list-price-list">
    <div class="form form-horizontal">
        <div class="form-body">
            <div class="row">

                <div class="col-md-12" style="background-color: #39da8a;height: 29px;">
                    <p style="margin:5px;color: white;"><strong>Pricing Option <span style="color: red!important;font-size: 15px;">*</span></strong></p>
                </div>
                <br>
                <br>
                <div class="col-md-3 form-group row" style="display:none">
                    <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="3">
                    <label for="" class="col-md-10" style="margin-top: 10px;">Negotiated</label>
                </div>
                <div class="col-md-3 form-group row" style="display:none">
                    <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="2" checked>
                    <label for="" class="col-md-10" style="margin-top: 10px;">Single Price</label>
                </div>

                <div class="col-md-3 form-group row" style="display:none">
                    <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="4">
                    <label for="" class="col-md-10" style="margin-top: 10px;">Custom Price</label>
                </div>

                <div class="col-md-3 form-group row" style="display:none">
                    <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="1">
                    <label for="" class="col-md-10" style="margin-top: 10px;">Package Price</label>
                </div>
                <div class="col-md-6 form-group row" >
                    <div class="col-6">
                        <label for="currency_id">Select Your Currency</label>
                    </div>
                    <div class="col-6">
                        <?php 
                            $all_currency = DB::table('tbl_currency_status')
                                ->where('status', 1)
                                ->orderBy('default_status', 'desc')
                                ->get() ;
                        ?>
                        <select class="form-control" style="width:300px;" id="currency_id">
                            <?php foreach ($all_currency as $cur_value) { ?>
                                <option value="<?php echo $cur_value->id ; ?>" <?php if($cur_value->id == Session::get('requestedCurrency')){echo "selected"; }else{echo ""; } ?>>1$ =  &#160; <?php echo $cur_value->rate?> &#160; <?php echo $cur_value->symbol;?> &#160; <?php echo $cur_value->code ; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                </div>

                <div class="col-md-12">

                    <div class="form-group row">
                        <div class="col-md-2 unit_price_check">
                            <label>Unit price</label>
                        </div>
                        <div class="col-md-10 form-group unit_price_check">
                            <input type="number" class="form-control" name="unit_price" value=""  placeholder="Unit price">
                        </div>
                    </div>

                    <div class="form-group row">
                         <div class="col-md-2 unit_price_check">
                            <label>Discount</label>
                        </div>

                        <div class="col-md-8 form-group unit_price_check">
                            <input type="number" class="form-control" name="discount" id="discount" value="0" placeholder="Discount">
                        </div>
                        <div class="col-md-2 form-group unit_price_check">
                            <select class="form-control" id="discount_status">
                                <option value="1">$</option>
                                <option value="2">%</option>
                            </select>
                        </div>
                    </div>
                     <div class="form-group row">
                        <div class="col-md-2 unit_price_check">
                            <label>Quantity </label>
                        </div>

                        <div class="col-md-4 form-group unit_price_check">
                            <input type="number" class="form-control" name="qty" id="qty" value="0" placeholder="quantity">
                        </div>
                       
                        <div class="col-md-4 form-group unit_price_check">
                            
                            <select class="form-control" id="cond" name="cond">
                                <option>Select Condition</option>
                                <option value="1">NEW</option>
                                <option value="2">USED</option>
                            </select>
                        </div>
                        </div>

                    <div class="form-group row">
                         <div class="col-md-2 unit_price_check">
                            <label>Offer Start</label>
                        </div>

                        <div class="col-md-4 form-group unit_price_check">
                            <input class="datepicker form-control" name="offer_start_date" data-date-format="dd/mm/yyyy" placeholder="d/m/Y">
                        </div>

                        <div class="col-md-2 unit_price_check">
                            <label>Offer End</label>
                        </div>
                        <div class="col-md-4 form-group unit_price_check" >
                            <input class="datepicker form-control" name="offer_end_date" data-date-format="dd/mm/yyyy" placeholder="d/m/Y">
                        </div>
                    </div>
                   
                </div>
                <div class="col-md-12 custom_price" style="display: none;">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content row">

                                    <div class="col-md-4 form-group row">
                                        <input type="radio" class="form-control col-md-1 custom_price_value" name="custom_price_value" value="2">
                                        <label for="" class="col-md-10" style="margin-top: 10px;">Image Wise Price</label>
                                    </div>
                    
                                    <div class="col-md-4 form-group row">
                                        <input type="radio" class="form-control col-md-1 custom_price_value" name="custom_price_value" value="1">
                                        <label for="" class="col-md-10" style="margin-top: 10px;">Size Wise Price</label>
                                    </div>


                                    <div class="col-md-12"> 

                                        <div class="card">
                                            <div class="card-content">
                                                <!-- table bordered -->
                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <thead>
                                                            <tr>
                                                                <th>Image / Color OR Size</th>
                                                                <th>Price (Per Quantity)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="custom_price_date"> 

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
                </div>

                <div class="col-md-12 package_price_check" style="display: none;">
                    <div class="row" id="table-bordered">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-content">
                                    <!-- table bordered -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0" id="sale_item_table">
                                            <thead>
                                                <tr>
                                                    <th>Color / Image</th>
                                                    <th>Min Quantity</th>
                                                    <th>Max Quantity</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl" class="package_price_data"> 
                                                
                                            </tbody>

                                        </table>

                                        <input type="submit" class="add_items btn btn-success btn-sm add_more add_another" style="float: right;display: none;" value="Add More" />
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
<!-- Description -->
<div class="tab-pane" id="list-description" role="tabpanel" aria-labelledby="list-description-list">
    <div class="form form-horizontal">
        <div class="form-body">
        <div class="row">
                
                <div class="col-sm-12 col-12 col-md-12">
                    <label>Description <span style="color: red!important;
               font-size: 15px;">*</span></label>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12  form-group">
                    <fieldset class="form-group">
                        <textarea class="form-control" name="product_description" rows="10" placeholder="Product Description" id="product_details_users" required=""></textarea>
                    </fieldset>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- Shipping Info Start -->
<div class="tab-pane" id="list-Shipping" role="tabpanel" aria-labelledby="list-Shipping-list">
    <div class="form form-horizontal">
        <div class="form-body">
            <div class="row">
                <div class="col-md-4">
                    <label>Free Shipping</label>
                </div>
                <div class="col-md-2">
                    <span>Status</span>
                </div>
                <div class="col-md-6 form-group">
                    <div class="custom-control custom-switch custom-control-inline mb-1">
                        <input type="checkbox" class="custom-control-input" value="2" name="shipping_status" checked id="customSwitch1">
                        <label class="custom-control-label mr-1" for="customSwitch1">
                        </label>
                    </div>
                </div>
                <div class="col-md-3">
                    <p>Shipping Method</p>
                </div>
                <div class="col-md-9">
                    <select class="select2 form-control" multiple="multiple" id="shipping_method" name="shipping_method[]">
                        <?php foreach ($all_shipping as $shippingmethod) { ?>
                            <option value="<?php echo $shippingmethod->id ; ?>"><?php echo $shippingmethod->shippingCompanyName; ?></option>
                        <?php } ?>
                    </select>
                </div>  

                <div class="col-md-3 mt-1">
                    <p>Payment Method</p>
                </div>
                <div class="col-md-9 mt-1">
                    <select class="select2 form-control" multiple="multiple" id="payment_method_id" name="payment_method_id[]">
                        <?php foreach ($all_payment_method as $paymentmethod) { ?>
                            <option value="<?php echo $paymentmethod->id ; ?>"><?php echo $paymentmethod->paymentMethodName; ?></option>
                        <?php } ?>
                    </select>
                </div>  
            </div>
        </div>
    </div>
</div>
<!-- PDF Specification -->
<!-- <div class="tab-pane" id="list-PDF" role="tabpanel" aria-labelledby="list-PDF-list">
    <form class="form form-horizontal">
        <div class="form-body">
            <div class="row">
                <div class="col-md-3">
                    <label>PDF Specification</label>
                </div>
                <div class="col-md-8
                9 form-group">
                    <input type="file" class="form-control" name="pdf_description">
                </div>
            </div>
        </div>
    </form> -->
</div>
</div>
</div>
<div class="col-sm-12 d-flex justify-content-end">
<button type="submit" class="btn btn-primary mr-1 mb-1 product_page_submit">Save</button>
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
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>

                    </div>
                    <div class="modal-body">
                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="home-fill" role="tabpanel" aria-labelledby="home-tab-fill">
                                <div class="row " id="table_data">


                                </div>
                            </div>
                            <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                                <form method="post" action="{{url('/upload_supplier_meta/store')}}" enctype="multipart/form-data" 
                                    class="dropzone" id="dropzone">
                                @csrf
                                </form>   
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close </button>
                                    <button type="button" class="btn btn-default" id="saveImage">Save</button>
                                </div>
                            </div>

                        </div>
            <!-- Nav Filled Ends -->
                    </div>
                    
                </div>
            </div>
        </div>        


        <div class="modal fade" id="myModal2" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="meta-tab-fill" data-toggle="tab" href="#meta-fill" role="tab" aria-controls="meta-fill" aria-selected="true">
                                    Select File
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="meta_p-tab-fill" data-toggle="tab" href="#meta_p-fill" role="tab" aria-controls="meta_p-fill" aria-selected="false">
                                    Upload File
                                </a>
                            </li>
                        </ul>

                        <input type="text" name="search_keyword" id="search_keyword" class="form-control col-md-4" placeholder="Search">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="meta-fill" role="tabpanel" aria-labelledby="meta-tab-fill">
                                <div class="row " id="meta_image_all">


                                </div>
                            </div>
                            <div class="tab-pane" id="meta_p-fill" role="tabpanel" aria-labelledby="meta_p-tab-fill">
                                <form method="post"  action="{{url('/upload_supplier_meta/store')}}" enctype="multipart/form-data" 
                                    class="dropzone" id="meta_dropzone">
                                @csrf
                                </form>   
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-default" id="saveMetaImage">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>


        <div class="modal fade" id="myModal3" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="meta-ptab-fill" data-toggle="tab" href="#meta_mp-fill" role="tab" aria-controls="meta_mp-fill" aria-selected="true">
                                    Select File
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="meta_pm-tab-fill" data-toggle="tab" href="#meta_pm-fill" role="tab" aria-controls="meta_pm-fill" aria-selected="false">
                                    Upload File
                                </a>
                            </li>
                        </ul>

                        <input type="text" name="search_keyword" id="search_keyword" class="form-control col-md-4" placeholder="Search">

                        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <!-- Tab panes -->
                        <div class="tab-content pt-1">
                            <div class="tab-pane active" id="meta_mp-fill" role="tabpanel" aria-labelledby="meta-ptab-fill">
                                <div class="row " id="product_color_image">


                                </div>
                            </div>
                            <div class="tab-pane" id="meta_pm-fill" role="tabpanel" aria-labelledby="meta_pm-tab-fill">
                                <form method="post"  action="{{url('/upload_supplier_meta/store')}}" enctype="multipart/form-data" 
                                    class="dropzone" id="meta_dropzone">
                                @csrf
                                </form>   
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-default" id="saveProductColorImage">Save</button>
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
@endsection

@section('js')
    <script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/jquery-ui.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.bundle.min.js"></script>
    <script src="{{URL::to('public/frontEnd/assets/js/tagsinput.js')}}"></script>
    <script src="{{URL::to('public/frontEnd/assets/js/custom-editore.js')}}"></script>
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
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
            toastr.info("{{ Session::get('message') }}", '', { positionClass: 'toast-top-center', });
            break;

            case 'warning':
            toastr.warning("{{ Session::get('message') }}", '', { positionClass: 'toast-top-center', });
            break;

            case 'failed':
            toastr.error("{{ Session::get('message') }}", '', { positionClass: 'toast-top-center', });
            break;
        }
        @endif
    </script>

    <script>
        $(document).ready(function(){
            $('body').on('click', '#myBtn', function (e) {
                $("#myModal").modal();
                return false ;
            });

            $('body').on('click', '#meta_image', function (e) {
                $("#myModal2").modal();
                return false ;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/getAllSupplierImageForProduct') }}",
                'type':'post',
                'dataType':'text',
                success:function(data){
                    $("#table_data").empty();
                    $("#table_data").html(data);
                  
                }
            });

            $.ajax({
                'url':"{{ url('/getSupplierProductColorImage') }}",
                'type':'get',
                'dataType':'text',
                success:function(data){
                    $("#product_color_image").empty();
                    $("#product_color_image").html(data);
                }
            });

        });

        $('body').on('click', '.siam_class', function (e) {
            e.preventDefault();

            $(this).toggleClass( "siam_active" );

            $('#myModal').modal('show');

            $("#table_data").each(function(){
                $(this).find('.icon_show').css('display', 'none') ;
            });


            var arr = new Array();
            $("#table_data .siam_active").each(function(){
                var val_arr = new Array();
                var inputvalu = $(this).find('.captureInput').val();
                var imageidvalue = $(this).find('.captureidinfo').val();
                var random_id = Math.floor(1000 + Math.random() * 9000) ;
                $(this).find('.icon_show').removeAttr("style") ;
                val_arr.push('<li class="remove_project_file3 ui-state-default" id="item_info_'+random_id+'" style="margin-bottom: 30px;">'
                    + '<a href="#" style="color: red;float: right;font-size: 17px;" class="remove_project_file" border="2" getmainimageid="'+imageidvalue+'"><i class="fa fa-times" aria-hidden="true"></i></a>'
                    + '<img width="100px" height="100px;" name="upload_project_images[]" type="file" class="new_project_image" src="public/images/'+inputvalu+'" />'
                    + '<input name="upload_images[]" type="hidden" class="upload_images" value="'+inputvalu+'" />'
                    + '<input name="uload_image_id[]" class="uload_image_id" type="hidden" value="'+imageidvalue+'" />'
                    + '</li>');
                arr.push(val_arr);
            });


            if (arr.length > 5) {
                toastr.error("Sorry! Your Maximum Five Image Upload Limit Over,");
                $(this).removeClass("siam_active") ;
                $(this).find('.icon_show').css("display", 'none') ;
                return false ;
            }


            $(".image_siam").empty() ;
            for (i = 0; i < arr.length; i++) {
              $(".image_siam").append(arr[i]) ;
            }

        });


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
                    url: '{{ url("image/meta_delete") }}',
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
                            'url':"{{ url('/getAllImagesForMetaImage') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#meta_image_all").empty();
                                $("#meta_image_all").html(data);
                              
                            }
                        });


                        $.ajax({
                            'url':"{{ url('/getAllSupplierImageForProduct') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#table_data").empty();
                                $("#table_data").html(data);
                              
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/getSupplierProductColorImage') }}",
                            'type':'get',
                            'dataType':'text',
                            success:function(data){
                                $("#product_color_image").empty();
                                $("#product_color_image").html(data);
                              
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
                'url':"{{ url('/getSearchValue') }}",
                'type':'post',
                'dataType':'text',
                data: {search_keyword: search_keyword},
                success:function(data){
                    $("#table_data").empty();
                    $("#table_data").html(data);
                  
                }
            });

        });

        $('.image_siam').on('click', '.remove_project_file', function(e) {
            e.preventDefault();
            var id      = $(this).attr('getmainimageid') ;
            var main_id = 'image_product_id_' + id;
            $("#"+main_id+"").removeClass("siam_active") ;
            $("#"+main_id+"").find('.icon_show').css("display", 'none') ;
            $(this).parent().remove();
        });
    </script>

    <script>
        $(document).ready(function(){

            $('body').on('click', '#meta_image', function (e) {
                $("#myModal2").modal();
                return false ;
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/getAllImagesForMetaImage') }}",
                'type':'post',
                'dataType':'text',
                success:function(data){
                    $("#meta_image_all").empty();
                    $("#meta_image_all").html(data);
                  
                }
            });

        });

        $('body').on('click', '.meta_class_image', function (e) {
            e.preventDefault();

            $('.meta_class_image').removeClass('siam_active') ;
            $(this).addClass('siam_active');

            $('#myModal2').modal('show');

            var inputvalu   = $(this).find('.meta_image_input').val();
            var x           = "public/images/"+inputvalu;

            $('.icon_single_show').css('display', 'none') ;
            $(this).find('.icon_single_show').removeAttr('style');


            $(".meta_image_gallery").empty().append('<li class="remove_meta_image" style="margin-bottom: 30px;">'
                + '<a href="#" style="color: red;float: right;font-size: 17px;" class="meta_image_anchore" border="2"><i class="fa fa-times" aria-hidden="true"></i></a>'
                + '<img width="200px" height="200px" name="upload_meta_images[]" type="file" class="upload_meta_images" src="public/images/'+inputvalu+'" />'
                + '<input name="meta_images_value" type="hidden" value="'+inputvalu+'" />'
                + '</li>');

        });


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
                    url: '{{ url("image/delete") }}',
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
               return false;
            }
        };

        $("#saveMetaImage").click(function(e){
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
                        Dropzone.forElement("#meta_dropzone").removeAllFiles(true);
                        toastr.success('Thanks !! Media Add Successfully Compeleted', { positionClass: 'toast-bottom-full-width', });
                        $.ajax({
                            'url':"{{ url('/getAllSupplierImageForProduct') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#table_data").empty();
                                $("#table_data").html(data);
                              
                            }
                        });
                        
                        $.ajax({
                            'url':"{{ url('/getAllImagesForMetaImage') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#meta_image_all").empty();
                                $("#meta_image_all").html(data);
                              
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/getSupplierProductColorImage') }}",
                            'type':'get',
                            'dataType':'text',
                            success:function(data){
                                $("#product_color_image").empty();
                                $("#product_color_image").html(data);
                              
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
                'url':"{{ url('/getSearchValue') }}",
                'type':'post',
                'dataType':'text',
                data: {search_keyword: search_keyword},
                success:function(data){
                    $("#table_data").empty();
                    $("#table_data").html(data);
                }
            });

        });

        $('.meta_image_gallery').on('click', '.remove_meta_image', function(e) {
            e.preventDefault();
            $('.icon_single_show').css('display', 'none') ;
            $('.meta_class_image').removeClass('siam_active') ;
            $("#meta_image_gallery").empty() ;
        });
    </script>

    <script>
        $('body').on('change', '#main_cateory_id', function (e) {
            e.preventDefault();

            var main_category_id = $(this).val() ;

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/getSupplierSecondaryCategoryP') }}",
                'type':'post',
                'dataType':'text',
                data: {main_category_id: main_category_id},
                success:function(data){
                    $("#secondary_category_id").empty();
                    $("#secondary_category_id").html(data);
                  
                }
            });

        });

        $(".product_page_submit").click(function(e){
            e.preventDefault() ;


            var product_web_category    = $("[name=product_web_category]").val() ;
            var product_name            = $("[name=product_name]").val() ;
            var main_category_id        = $("[name=main_category_id]").val() ;
            var secondary_category_id   = $("[name=secondary_category_id]").val() ;
            var tertiary_category_id    = $("[name=tertiary_category_id]").val() ;
            var brand_id                = $("[name=brand_id]").val() ;
            var unit                    = $("[name=unit]").val() ;
            var price_currency          = $("#currency_id").val() ;
            var unit_price              = $("[name=unit_price]").val() ;
            var discount                = $("[name=discount]").val() ;
            var discount_status         = $("#discount_status").val() ;
            var shipping_method         = $("#shipping_method").val() ;
            var payment_method_id       = $("#payment_method_id").val() ;
            var upload_images_siam      = $(".upload_images").val() ;
            var package_template        = $("input.package_template:checked").val() ;
            var image__id               = $("input.customer_choose_color:checked").val() ;
            var custom_price_value      = $("input.custom_price_value:checked").val() ;
            var producttags             = $("#producttags").val() ;
            
            


            if (product_web_category == "" || product_web_category == undefined) {
                toastr.error("Sorry! Select Category First.");
                return false ;
            }

            if (product_name == "") {
                toastr.error("Sorry! Input Product Name.");
                return false ;
            }
            
            
            if (main_category_id == 0 || main_category_id == undefined) {
                toastr.error("Sorry! Select main category.");
                return false ;
            }

            if (unit == "" || unit == undefined) {
                toastr.error("Sorry! Select Product Unit");
                return false ;
            }

            
            if (upload_images_siam == "" || upload_images_siam == undefined) {
                toastr.error("Sorry! Select Product Images.");
                return false ;
            }


            if (package_template == "" || package_template == undefined) {
                toastr.error("Sorry! Select price.");
                return false ;
            }

            if (image__id == "" || image__id == undefined) {
                
                var all_color_id    = [];
                var all_color_image = [];
                
            }else{
                if (image__id == 1) {
                    var all_color_id = [];
                    $(".color_id").each(function(){
                        all_color_id.push($(this).val())
                    });

                    if (all_color_id.length == 0) {
                        toastr.error("Select At list single proudct Color.");
                        return false ;
                    }
                }else{
                    var all_color_image = [];
                    $(".upload_color_image").each(function(){
                        all_color_image.push($(this).val())
                    });

                    if (all_color_image.length == 0) {
                        toastr.error("Select At list single proudct Color Image.");
                        return false ;
                    }
                }
            }


            var all_size_id = [];
            $('input.size_id:checked').each(function () {
                all_size_id.push($(this).val());
            });

            var package_price_image = [];
            $(".package_price_image").each(function(){
                package_price_image.push($(this).val())
            });

            var quantity_start = [];
            $(".quantity_start").each(function(){
                quantity_start.push($(this).val())
            });

            var quantity_end = [];
            $(".quantity_end").each(function(){
                quantity_end.push($(this).val())
            });

            var price = [];
            $(".price").each(function(){
                price.push($(this).val())
            });

            var product_images = [];
            $(".upload_images").each(function(){
                product_images.push($(this).val())
            });

            var image_per_qty_price = [];
            $(".image_per_qty_price").each(function(){
                image_per_qty_price.push($(this).val())
            });

            var custom_price_image = [];
            $(".custom_price_image").each(function(){
                custom_price_image.push($(this).val())
            });


            var video_link_type          = $("[name=video_link_type]").val() ;
            var video_link               = $("[name=video_link]").val() ;
            var meta_title               = $("[name=meta_title]").val() ;
            var meta_description         = $("[name=meta_description]").val() ;
            var meta_image               = $("[name=meta_images_value]").val() ;
            var shipping_status          = $("[name=shipping_status]").val() ;
            var offer_start_date         = $("[name=offer_start_date]").val() ;
            var offer_end_date           = $("[name=offer_end_date]").val() ;
            var qty                      = $("[name=qty]").val() ;
            var cond                      = $("[name=cond]").val() ;
            
            var product_description = tinymce.get("product_details_users").getContent();

            if (product_description == "") {
                toastr.error("Sorry! Input Product Description.");
                return false ;
            }


            var productFinalImages = JSON.stringify(product_images) ;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/insertProductInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {product_web_category: product_web_category, product_name: product_name, main_category_id:main_category_id, secondary_category_id:secondary_category_id, tertiary_category_id:tertiary_category_id, brand_id:brand_id, unit:unit, producttags:producttags, productFinalImages:productFinalImages, video_link_type:video_link_type, video_link:video_link, meta_title:meta_title, meta_description:meta_description, meta_image:meta_image, product_description:product_description, shipping_status:shipping_status,all_size_id:all_size_id,all_color_id:all_color_id,all_color_image:all_color_image,quantity_start:quantity_start,quantity_end:quantity_end,package_price_image:package_price_image,price:price,price:price, price_currency:price_currency,unit_price:unit_price, discount:discount,discount_status:discount_status,package_template:package_template,image__id:image__id,shipping_method:shipping_method,payment_method_id:payment_method_id,custom_price_value:custom_price_value,image_per_qty_price:image_per_qty_price,custom_price_image:custom_price_image,offer_start_date:offer_start_date,offer_end_date:offer_end_date,qty:qty,cond:cond},
                success:function(data){
                    if(data == "success"){
                      toastr.success("Product Add Successfully Compeleted");
                        setTimeout(function(){
                        url = "supplierProductsList";
                            $(location).attr("href", url);
                        }, 3000);
                    }else if(data == "select_tertiary_category"){
                      toastr.error("Sorry! Select Sub Category");
                      return false ;
                    }else if(data == "duplicate_product"){
                      toastr.error("Sorry! Product Already Exit");
                      return false ;
                    }else if(data == "not_verify"){
                      toastr.error("Sorry! Please Verify Your Account First");
                      return false ;
                    }else if(data == "input_price_first"){
                      toastr.error("Sorry! Please Input Product Price");
                      return false ;
                    }else if(data == "upload_limit"){
                        toastr.error("Sorry! Your product upload limit is over. Please update your package.");
                        return false ;
                    }else if(data == "package_not_active"){
                        toastr.error("Sorry! Please active your package first.");
                        return false ;
                    }

                }
            });
        });

    </script>
    <script>
      $( function() {
        $( "#image_siam" ).sortable();
        $( "#image_siam" ).disableSelection();
      } );

      $( function() {
        $( "#color_image" ).sortable();
        $( "#color_image" ).disableSelection();
      } );
    </script>

    <script>
  $('document').ready(function() {
  $('.add_another').click(function(e) {
      e.preventDefault() ;
      var total_row  = $('#sale_item_table tr').length;
      var final_row = total_row - 1 ;

      $("#tbl").append('<tr><td><input type="text" class="form-control how_days" name="how_days[]" placeholder="Days" /></td><td><input type="number" class="form-control quantity_start" style="width: 50%; float: left;" name="quantity_start[]" placeholder="Min Quantity" /></td><td><input type="number" step="any" class="form-control quantity_end" name="quantity_end[]" placeholder="Max Quantity"></td><td class="text-bold-500"><input type="number" class="form-control price" step="any" name="price[]" placeholder="Unit(Price)" /><i style="float: right; color: red;" class="fa fa-times remove_product_package" aria-hidden="true"></i></td></tr>');

   });

    $('#sale_item_table').on('click', '.remove_product_package', function(e) {
        e.preventDefault();
        console.log("Hello Siam") ;
         $(this).closest('tr').remove();
    });

    $(".package_template").change(function(e){
        e.preventDefault() ;

        var package_template = $(this).val() ;

        if (package_template == 1) {

            var customer_choose_color = $("input.customer_choose_color:checked").val() ;
            if(customer_choose_color == 1){
                var arr = new Array();
                $("#tbl_color .color_id").each(function(){
                    var val_arr = new Array();
                    var inputvalu = $(this).val();
                    var random_id = Math.floor(1000 + Math.random() * 9000) ;
                    val_arr.push('<tr class="" id="item_color_'+random_id+'">'
                        + '<td> <center><p style="width:50px;height:50px;background: '+inputvalu+'"> </p></center></td>'
                        + '<input name="package_price_image[]" type="hidden" class="package_price_image" value="'+inputvalu+'" />'
                        + '<td><input type="number" step="any" class="form-control quantity_start" name="quantity_start[]" placeholder="Min Quantity"></td>'
                        + '<td><input type="number" step="any" class="form-control quantity_end" name="quantity_end[]" placeholder="Max Quantity"></td>'
                        + '<td><input type="number" class="form-control price" name="price[]" step="any" placeholder="Unit(Price)"></td>'
                        + '</tr>');
                    arr.push(val_arr);
                });

                $(".package_price_data").empty() ;
                for (i = 0; i < arr.length; i++) {
                    $(".package_price_data").append(arr[i]) ;
                }
            }else if(customer_choose_color == 2){
                var arr = new Array();
                $("#product_color_image .siam_active").each(function(){
                    var val_arr = new Array();
                    var inputvalu = $(this).find('.captureInput').val();
                    var imageidvalue = $(this).find('.captureidinfo').val();
                    var random_id = Math.floor(1000 + Math.random() * 9000) ;

                    val_arr.push('<tr class="" id="item_color_'+random_id+'">'
                        + '<td><img width="100px" height="100px;" src="public/images/'+inputvalu+'" /></td>'
                        + '<input name="package_price_image[]" type="hidden" class="package_price_image" value="'+inputvalu+'" />'
                        + '<td><input type="number" step="any" class="form-control quantity_start" name="quantity_start[]" placeholder="Min Quantity"></td>'
                        + '<td><input type="number" step="any" class="form-control quantity_end" name="quantity_end[]" placeholder=Min Quantity"></td>'
                        + '<td><input type="number" class="form-control price" name="price[]" step="any" placeholder="Unit(Price)"></td>'
                        + '</tr>');
                    arr.push(val_arr);
                });

                $(".package_price_data").empty() ;
                for (i = 0; i < arr.length; i++) {
                    $(".package_price_data").append(arr[i]) ;
                }
            }
            $('.package_price_check').removeAttr('style');
            $('.unit_price_check').css('display', 'none') ;
            $('.custom_price').css('display', 'none') ;
        }else if(package_template == 2){
            $('.unit_price_check').removeAttr('style');
            $('.package_price_check').css('display', 'none') ;
            $('.custom_price').css('display', 'none') ;
        }else if(package_template == 4){
            $('.custom_price').removeAttr('style');
            $('.package_price_check').css('display', 'none') ;
            $('.unit_price_check').css('display', 'none') ;
        }else{

            $('.unit_price_check').css('display', 'none');
            $('.package_price_check').css('display', 'none');
            $('.custom_price').css('display', 'none') ;
        }

    })
  
})
</script>
    

<script>
    
    $('body').on('click', '#product_color_image_selector', function (e) {
        $("#myModal3").modal();
        return false ;
    });

    $(".customer_choose_color").change(function(e){
        e.preventDefault() ;

        var color__type = $(this).val() ;
        if (color__type == 1) {
            $('.color__section').removeAttr('style');

            $('input.custom_price_value:checked').prop("checked", false);
            //var siam = $('.custom_price_value').val();
            //console.log(siam);

            $('.color_image_section').css('display', 'none');
            $("#custom_price_date").empty() ;

        }else{
            $('.color_image_section').removeAttr('style');
            $('input.custom_price_value:checked').prop("checked", false);
            $('.color__section').css('display', 'none');
            $("#custom_price_date").empty() ;
            
        }

    });

    $('.add_another_color').click(function(e) {
      e.preventDefault() ;
      var total_row  = $('#color_table_id tr').length;
    var final_row = total_row - 1 ;
    if(final_row > 7){
         toastr.error("Sorry! Your Maximum 8 Color Upload Limit Over,");
         return false ;
    }


      $("#tbl_color").append('<tr><td><input type="color" class="form-control color_id" name="color_id[]"><i style="float:right;color:red;" class="fa fa-times remove_color_id" aria-hidden="true"></i></td></tr>');
    });

    $('#color_table_id').on('click', '.remove_color_id', function(e) {
        e.preventDefault();
         $(this).closest('tr').remove();
    });

    $('body').on('click', '.product_color_image__ss', function (e) {
        e.preventDefault();

        $(this).addClass( "siam_active" );

        $('#myModal3').modal('show');

        var arr = new Array();
        $("#product_color_image .siam_active").each(function(){
            var val_arr = new Array();
            var inputvalu = $(this).find('.captureInput').val();
            var imageidvalue = $(this).find('.captureidinfo').val();
            var random_id = Math.floor(1000 + Math.random() * 9000) ;
            $(this).find('.icon_show').removeAttr("style") ;
            val_arr.push('<li class="remove_color_images ui-state-default" id="item_color_'+random_id+'" style="margin-bottom: 30px;float:left;margin-left:10px;">'
                + '<a href="#" style="color: red;float: right;font-size: 17px;" class="remove_color_images_s" border="2" getmainimageid="'+imageidvalue+'"><i class="fa fa-times" aria-hidden="true"></i></a>'
                + '<img width="100px" height="100px;" name="color_image_id[]" type="file" class="color_image_id" src="public/images/'+inputvalu+'" />'
                + '<input name="upload_color_image[]" type="hidden" class="upload_color_image" value="'+inputvalu+'" />'
                + '<input name="upload_color_image_id[]" class="upload_color_image_id" type="hidden" value="'+imageidvalue+'" />'
                + '</li>');
            arr.push(val_arr);
        });
        
        if (arr.length > 8) {
            toastr.error("Sorry! Your Maximum 8 Image Upload Limit Over,");
            $(this).removeClass("siam_active") ;
            $(this).find('.icon_show').css("display", 'none') ;
            return false ;
        }

        $(".color_image").empty() ;
        for (i = 0; i < arr.length; i++) {
          $(".color_image").append(arr[i]) ;
        }

    });


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
                    url: '{{ url("image/meta_delete") }}',
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
               return false;
            }
        };

        $("#saveProductColorImage").click(function(e){
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
                            'url':"{{ url('/getAllImagesForMetaImage') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#meta_image_all").empty();
                                $("#meta_image_all").html(data);
                              
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/getAllSupplierImageForProduct') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#table_data").empty();
                                $("#table_data").html(data);
                              
                            }
                        });

                        $.ajax({
                            'url':"{{ url('/getSupplierProductColorImage') }}",
                            'type':'get',
                            'dataType':'text',
                            success:function(data){
                                $("#product_color_image").empty();
                                $("#product_color_image").html(data);
                              
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
                'url':"{{ url('/getSearchValue') }}",
                'type':'post',
                'dataType':'text',
                data: {search_keyword: search_keyword},
                success:function(data){
                    $("#table_data").empty();
                    $("#table_data").html(data);
                  
                }
            });

        });

        $('.color_image').on('click', '.remove_color_images_s', function(e) {
            e.preventDefault();
            var id      = $(this).attr('getmainimageid') ;
            var main_id = 'image_id_s_' + id;
            $("#"+main_id+"").removeClass("siam_active") ;
            $("#"+main_id+"").find('.icon_show').css("display", 'none') ;
            console.log(main_id) ;
            $(this).parent().remove();
        });

        $('body').on('change', '.custom_price_value', function (e) {
            e.preventDefault() ;

            var price_type = $(this).val() ;

            if(price_type == 2){

                var customer_choose_color = $("input.customer_choose_color:checked").val() ;
                if(customer_choose_color == 1){
                    var arr = new Array();
                    $("#tbl_color .color_id").each(function(){
                        var val_arr = new Array();
                        var inputvalu = $(this).val();
                        var random_id = Math.floor(1000 + Math.random() * 9000) ;
                        val_arr.push('<tr class="" id="item_color_'+random_id+'">'
                            + '<td> <center><p style="width:50px;height:50px;background: '+inputvalu+'"> </p></center></td>'
                            + '<input name="custom_price_image[]" type="hidden" class="custom_price_image" value="'+inputvalu+'" />'
                            + '<td><input name="image_per_qty_price[]" class="form-control image_per_qty_price" type="number" step="any" value="0" /></td>'
                            + '</tr>');
                        arr.push(val_arr);
                    });

                    $("#custom_price_date").empty() ;
                    for (i = 0; i < arr.length; i++) {
                        $("#custom_price_date").append(arr[i]) ;
                    }
                }else if(customer_choose_color == 2){
                    var arr = new Array();
                    $("#product_color_image .siam_active").each(function(){
                        var val_arr = new Array();
                        var inputvalu = $(this).find('.captureInput').val();
                        var imageidvalue = $(this).find('.captureidinfo').val();
                        var random_id = Math.floor(1000 + Math.random() * 9000) ;

                        val_arr.push('<tr class="" id="item_color_'+random_id+'">'
                            + '<td><img width="100px" height="100px;" name="color_image_id[]" type="file" class="color_image_id" src="public/images/'+inputvalu+'" /></td>'
                            + '<input name="custom_price_image[]" type="hidden" class="custom_price_image" value="'+inputvalu+'" />'
                            + '<td><input name="image_per_qty_price[]" class="form-control image_per_qty_price" type="number" step="any" value="0" /></td>'
                            + '</tr>');
                        arr.push(val_arr);
                    });

                    $("#custom_price_date").empty() ;
                    for (i = 0; i < arr.length; i++) {
                        $("#custom_price_date").append(arr[i]) ;
                    }

                }
                
            }else if(price_type == 1){

                var arr = new Array();
                $('input.size_id:checked').each(function () {
                    var val_arr = new Array();
                    var inputvalu = $(this).val();
                    var random_id = Math.floor(1000 + Math.random() * 9000) ;
                    var main_info = inputvalu.split("/") ;

                    val_arr.push('<tr class="" id="item_color_'+random_id+'">'
                        + '<td>'+main_info[1]+'</td>'
                        + '<input name="custom_price_image[]" type="hidden" class="custom_price_image" value="'+main_info[0]+'" />'
                        + '<td><input name="image_per_qty_price[]" class="form-control image_per_qty_price" type="number" step="any" value="0" /></td>'
                        + '</tr>');
                    arr.push(val_arr);
                });

                $("#custom_price_date").empty() ;
                for (i = 0; i < arr.length; i++) {
                    $("#custom_price_date").append(arr[i]) ;
                }
            }

        });

        $(document).on('click', '#product_image_pagination .page-link', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            product_image_fetch_data(page);
        });

        function product_image_fetch_data(page)
        {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"{{ url('getProductImagePagination') }}",
                method:"POST",
                data:{page:page},
                success:function(data)
                {

                    $("#myModal").show();
                    $("#table_data").empty();
                    $("#table_data").html(data);
                }
            });
        }


        $(document).on('click', '#product_color_image_pagination .page-link', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            product_color_image_fetch_data(page);
        });

        function product_color_image_fetch_data(page)
        {


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url:"{{ url('getProductColorImagePagination') }}",
                method:"POST",
                data:{page:page},
                success:function(data)
                {

                    $("#myModal3").show();
                    $("#product_color_image").empty();
                    $("#product_color_image").html(data);
                }
            });
        }
        
    $(".size_id").change(function(e){
        e.preventDefault() ;
        var all_size_id = [];
        $('input.size_id:checked').each(function () {
            all_size_id.push($(this).val());
        });

        var size_count = all_size_id.length ;
        if(size_count > 8)
        {
            toastr.error("Sorry! Your Maximum 8 Size Checked Limit Over,");
            this.checked = false;
            return false ;
        }

    });

</script>
@endsection



