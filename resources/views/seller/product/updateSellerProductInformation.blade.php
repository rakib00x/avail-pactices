@extends('seller.seller-master')
@section('title')
Product Update
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
</style>
@endpush
<div class="app-content content">
<div class="content-overlay"></div>
<div class="content-wrapper">
<div class="content-header row">
<div class="content-header-left col-12 mb-2 mt-1">
<div class="row breadcrumbs-top">
<div class="col-12">
<h5 class="content-header-title float-left pr-1 mb-0">Product Information Update</h5>
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
<h4 class="card-title">Product Information</h4>
<a style="margin-bottom: -25px;" href="{{URL::to ('/sellerproductlist')}}" class="btn btn-primary float-right" role="button" aria-pressed="true">Product List</a>
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
<a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" style="display:none">Video </a>
<a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" style="display:none">Meta  Tag</a>
<a class="list-group-item list-group-item-action" id="list-customer-list" data-toggle="list" href="#list-customer" role="tab" style="display:none">Customer Choice</a>
<a class="list-group-item list-group-item-action" id="list-price-list" data-toggle="list" href="#list-price" role="tab">Price <span style="color: red!important;
    font-size: 15px;">*</span></a>
<a class="list-group-item list-group-item-action" id="list-escription-list" data-toggle="list" href="#list-description" role="tab">Description <span style="color: red!important;
    font-size: 15px;">*</span></a>
<a class="list-group-item list-group-item-action" id="list-Shipping-list" data-toggle="list" href="#list-Shipping" role="tab" style="display:none">Shipping Info</a>
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
                        <label>Select Category <span style="color: red!important;font-size: 15px;">*</span></label>
                    </div>
                    <div class="col-md-9 form-group">
                        <select class="form-control select2" id="product_web_category" name="product_web_category">
                            <option value="0">Select Category</option>
                            <?php foreach ($all_primary_category as $wvalue) { ?>
                                <option value="<?php echo $wvalue->id; ?>" <?php if($wvalue->id == $product_info->w_category_id){echo "selected"; }else{echo ""; }?>>{{ $wvalue->category_name }}</option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Subcategory <span style="color: yellow!important;font-size: 15px;">*</span></label>
                    </div>
                    <div class="col-md-9 form-group">
                        <div class="form-group">
                            <select class="form-control" id="secondary_category_id" name="secondary_category_id">
                                <option value="">Select An Option</option>
                                <?php foreach ($category_wise_secondary as $wsvalue) { ?>
                                    <option value="<?php echo $wsvalue->id; ?>" <?php if($wsvalue->id == $product_info->w_secondary_category_id){echo "selected"; }else{echo ""; }?>>{{ $wsvalue->secondary_category_name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>Tertiary Category <span style="color: yellow!important;font-size: 15px;">*</span></label>
                    </div>
                    <div class="col-md-9 form-group">
                        <div class="form-group">
                            <select class="form-control" id="tertiary_category_id" name="tertiary_category_id">
                                <option value="">Select An Option</option>
                                <?php foreach ($category_wise_tertiary as $wtvalue) { ?>
                                    <option value="<?php echo $wtvalue->id; ?>" <?php if($wtvalue->id == $product_info->w_tertiary_categroy_id){echo "selected"; }else{echo ""; }?>>{{ $wtvalue->tartiary_category_name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label>Product Name</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <input type="text" id="product-name" class="form-control" name="product_name" value="<?php echo $product_info->product_name ; ?>" required="">
                    </div>

                    <div class="col-md-3" style="display:none">
                        <label>Brand</label>
                    </div>
                    <div class="col-md-9 form-group" style="display:none">
                        <div class="form-group">
                            <select class="form-control" id="brand_id" name="brand_id" >
                                <option value="">Select Brand</option>
                                <?php foreach ($all_product_brand as $brvalue) { ?>
                                    <option value="{{ $brvalue->id }}" <?php if($product_info->brand_id == $brvalue->id){echo "selected"; }else{echo "";} ?>>{{ $brvalue->brand_name }}</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Unit</label>
                    </div>
                    <div class="col-md-9 form-group">
                        <select class="select2 form-control" id="product-name" name="unit">
                            <option value="">Select A Unit</option>
                                <?php foreach ($all_unit as $tsvalue) { ?>
                                    <option value="<?php echo $tsvalue->id ; ?>" <?php if($product_info->unit == $tsvalue->id){echo "selected"; }else{echo "";} ?>><?php echo $tsvalue->unit_name; ?></option>
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
                    <label>Main Images</label>
                </div>
                <div class="col-md-9 form-group">
                    <input type="file" id="myBtn" class="form-control" name="fname">
                    
                    <ul id="image_siam" class="image_siam list-unstyled">
                    <?php if ($product_info->products_image != "" || $product_info->products_image != null): ?>

                        
                            <?php if (strpos($product_info->products_image, '#') !== false): ?>
                                <?php $all_selected_images = explode('#', $product_info->products_image); 
                                    foreach ($all_selected_images as $imgvalue) { ?>
                                        <?php if ($imgvalue != ""): ?>
                                            <li class="remove_project_file3 ui-state-default" id="item_info_<?php echo rand(11111, 99999);  ?>" style="margin-bottom: 30px;">
                                                <?php $media_info = DB::table('tbl_media')->where('image', $imgvalue)->where('supplier_id', Session::get('supplier_id'))->first(); ?>
                                                <a href="#" style="color: red;float: right;font-size: 17px;" class="remove_project_file" border="2" getmainimageid="<?php echo rand(111111, 999999) ; ?>"><i class="fa fa-times" aria-hidden="true"></i> </a>
                                                <img width="100px" height="100px;" name="upload_project_images[]" type="file" class="new_project_image" src="{{ URL::to('/public/images/'.$imgvalue) }}" />
                                                <input name="upload_images[]" class="upload_images" type="hidden" value="<?php echo $imgvalue ; ?>" />
                                            </li>
                                        <?php endif ?>
                                    <?php }
                                 ?>
                            <?php else: ?>
                                <li class="remove_project_file3 ui-state-default" id="item_info_<?php echo rand(11111, 99999);  ?>" style="margin-bottom: 30px;">

                                        <?php $media_info = DB::table('tbl_media')->where('image', $product_info->products_image)->where('supplier_id', Session::get('supplier_id'))->first(); ?>

                                        <a href="#" style="color: red;float: right;font-size: 17px;" class="remove_project_file" border="2" getmainimageid="<?php echo rand(111111, 999999) ; ?>"><i class="fa fa-times" aria-hidden="true"></i> </a>
                                        <img width="100px" height="100px;" name="upload_project_images[]" type="file" class="new_project_image" src="{{ URL::to('/public/images/'.$product_info->products_image) }}" />
                                        <input name="upload_images[]" class="upload_images" type="hidden" value="<?php echo $product_info->products_image ; ?>" />
                                    </li>
                            <?php endif ; ?>
                    
                    <?php endif ?>
                    </ul>
                    <span ></span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Video Part Start -->
<div class="tab-pane" id="list-messages" role="tabpanel" aria-labelledby="list-messages-list" style="display:none;">
    <div class="form form-horizontal">
        <div class="form-body">
            <div class="row">
                <div class="col-md-3">
                    <label>Video Provider</label>
                </div>
                <div class="col-md-9 form-group">
                    <div class="form-group">
                        <select class="form-control" id="accountSelect" name="video_link_type">
                            <option value="1" <?php if($product_info->link_type == 1){echo "selected"; }else{echo "" ;} ?>>Youtube </option>
                            <option value="2" <?php if($product_info->link_type == 2){echo "selected"; }else{echo "" ;} ?>>DailyMotion</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Video Link</label>
                </div>
                <div class="col-md-9 form-group">
                    <input type="text" class="form-control" name="video_link" value="<?php echo $product_info->video_link ; ?>">
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
                    <input type="text" class="form-control" name="meta_title" value="<?php echo $product_info->meta_title; ?>">
                </div>
                <div class="col-md-2">
                    <label>Description</label>
                </div>
                <div class="col-md-10 form-group">
                    <fieldset class="form-group">
                        <textarea  maxlength="200" class="form-control" name="meta_description" rows="2"><?php echo $product_info->meta_description; ?></textarea>
                    </fieldset>
                </div>
                
                <div class="col-md-2">
                    <label>Tags</label>
                </div>
                <div class="col-md-10 form-group">
                    <div class="form-group">
                        <input type="text" data-role="tagsinput" id="producttags" name="producttags" class="sr-only" value="<?php echo $product_info->product_tags; ?>">
                    </div>
                </div>

                <div class="col-md-2">
                    <label>Meta Image</label>
                </div>

                <div class="col-md-10 form-group">
                    <input type="file" id="meta_image" class="form-control" name="meta_image" >

                    <ul id="meta_image_gallery" class="meta_image_gallery list-unstyled">
                        <?php if ($product_info->meta_image != ""): ?>
                            <li class="remove_meta_image" style="margin-bottom: 30px;">
                                <a href="#" style="color: red;float: right;font-size: 17px;" class="meta_image_anchore" border="2"><i class="fa fa-times" aria-hidden="true"></i></a>
                                <img width="200px" height="200px" name="upload_meta_images[]" type="file" class="upload_meta_images" src="{{ URL::to('public/images/'.$product_info->meta_image) }}" />
                                <input name="meta_images_value" type="hidden" value="<?php echo $product_info->meta_image; ?>" />
                            </li>
                        <?php endif ?>
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

                <?php 
                    $product_images_count = DB::table('tbl_product_color')
                        ->where('product_id', $product_info->id)
                        ->count() ;
                    $product_color_image = DB::table('tbl_product_color')
                        ->where('product_id', $product_info->id)
                        ->get() ;
                 ?>

                <?php if ($product_images_count > 0): ?>
                     

                 <?php foreach ($product_color_image as $pcvalue): ?>
                     
                 <?php endforeach ?>
                     <div class="col-md-5 form-group row">
                        <input type="radio" class="form-control col-md-1 customer_choose_color" name="image__id" value="1"<?php if($pcvalue->color_code != null){echo "checked"; }else{ echo ""; } ?> >
                        <label for="" class="col-md-10" style="margin-top: 10px;">Color</label>
                    </div>
                    <div class="col-md-5 form-group row">
                        <input type="radio" class="form-control col-md-1 customer_choose_color" name="image__id" value="2"<?php if($pcvalue->color_image != null){echo "checked"; }else{echo ""; } ?>>
                        <label for="" class="col-md-10" style="margin-top: 10px;">Image</label>
                    </div>
                <?php else: ?>
                    <div class="col-md-5 form-group row">
                        <input type="radio" class="form-control col-md-1 customer_choose_color" name="image__id" value="1" >
                        <label for="" class="col-md-10" style="margin-top: 10px;">Color</label>
                    </div>
                    <div class="col-md-5 form-group row">
                        <input type="radio" class="form-control col-md-1 customer_choose_color" name="image__id" value="2" >
                        <label for="" class="col-md-10" style="margin-top: 10px;">Image</label>
                    </div>
                <?php endif ?>


                <div class="col-md-12">
                <?php if ($product_images_count > 0): ?>

                        <div class="row color__section" style="display: <?php if($pcvalue->color_code != null){echo ""; }else{echo "none"; } ?>" >
                            <div class="col-md-12 form-group row">
                                <div class="table-responsive">
                                    <table class="table table-bordered mb-0" id="color_table_id">
                                        <thead>
                                            <tr>
                                                <th>Color</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_color">
                                            <?php if ($pcvalue->color_code != null): ?>
                                                <?php foreach ($product_color_image as $cpvalue): ?>
                                                     <tr>
                                                        <td><input type="color" class="form-control color_id" name="color_id[]" value="<?php echo $cpvalue->color_code ; ?>" ></td>
                                                    </tr>
                                                <?php endforeach ?> 
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                    <input type="submit" class="add_items btn btn-success btn-sm add_another_color" style="float: right;" value="Add More" />
                                </div>
                            </div>
                        </div>
            
                        <div class="color_image_section" style="display: <?php if($pcvalue->color_image != null){echo ""; }else{echo "none"; } ?>;">
                            <input type="file" id="product_color_image_selector" class="form-control" name="fname">

                            <ul id="color_image" class="color_image list-unstyled">
                                <?php if($pcvalue->color_image != null): ?>
                                    <?php foreach ($product_color_image as $cmpvalue): ?>
                                        <?php 
                                            $color_id_info = DB::table('tbl_media')
                                                ->where('image', $cmpvalue->color_image)
                                                ->where('supplier_id', Session::get('supplier_id'))
                                                ->first() ;
                                         ?>
                                        <li class="remove_color_images ui-state-default" id="item_color_<?php echo rand(11111, 99999) ; ?>" style="margin-bottom: 30px;float:left;margin-left:10px;">

                                            <a href="#" style="color: red;float: right;font-size: 17px;" class="remove_color_images_s" border="2" getmainimageid="<?php echo $color_id_info->id ; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>

                                            <img width="100px" height="100px;" type="file" src="{{ URL::to('public/images/'.$cmpvalue->color_image) }}" />

                                            <input name="upload_color_image[]" type="hidden" class="upload_color_image" value="<?php echo $cmpvalue->color_image ; ?>" />
                                        </li>
                                    <?php endforeach ?> 
                                <?php endif; ?>

                            </ul>
                        </div> 
                     

                <?php else: ?>

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

                 <?php endif ?>

                 
                </div> 

                <div class="col-md-12">
                    <p><strong>Select Size</strong></p>
                </div>


                <?php 
                    $all_size = DB::table('tbl_size')->where('supplier_id', Session::get('supplier_id'))->where('status', 1)->get() ;
                 ?>


                <?php foreach ($all_size as $size_value): ?>
                    <div class="col-md-4 form-group row">
                        <input type="checkbox" class="form-control col-md-1 size_id" name="size_id[]" value="<?php echo $size_value->id."/".$size_value->size; ?>" <?php 
                            $check_count_size = DB::table('tbl_product_size')->where('product_id', $product_info->id)->where('size_id', $size_value->id)->count() ;
                            if($check_count_size > 0){echo "checked"; }else{echo " ";} 
                         ?>>
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
                    <p style="margin:5px;color: white;"><strong>Pricing Option</strong></p>
                </div>
                <br>
                <?php if ($product_info->price_type != ""): ?>
                    
                    <div class="col-md-3 form-group row" style="display:none">
                        <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="3" <?php if($product_info->price_type == "3"){echo "checked"; }else{echo " ";} ?>>
                        <label for="" class="col-md-10" style="margin-top: 10px;">Negotiated</label>
                    </div>

                    <div class="col-md-3 form-group row" style="display:none">
                        <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="2" <?php if($product_info->price_type == "2"){echo "checked"; }else{echo " ";} ?>>
                        <label for="" class="col-md-10" style="margin-top: 10px;">Single Price</label>
                    </div>

                    <div class="col-md-3 form-group row" style="display:none">
                        <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="4" <?php if($product_info->price_type == "4"){echo "checked"; }else{echo " ";} ?>>
                        <label for="" class="col-md-10" style="margin-top: 10px;">Custom Price</label>
                    </div>

                    <div class="col-md-3 form-group row" style="display:none">
                        <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="1" <?php if($product_info->price_type == "1"){echo "checked"; }else{echo " ";} ?>>
                        <label for="" class="col-md-10" style="margin-top: 10px;">Package Price</label>
                    </div>

                <?php else: ?>

                    <div class="col-md-3 form-group row" style="display:none">
                        <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="3">
                        <label for="" class="col-md-10" style="margin-top: 10px;">Negotiated</label>
                    </div>
                    <div class="col-md-3 form-group row" style="display:none">
                        <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="2">
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

                <?php endif ?>


                <div class="col-md-6 form-group row mt-2">
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
                                <option value="<?php echo $cur_value->id ; ?>" <?php if($product_info->currency_id == $cur_value->id){echo "selected"; }else{echo " ";} ?>>1$ =  &#160; <?php echo $cur_value->rate?> &#160; <?php echo $cur_value->symbol;?> &#160; <?php echo $cur_value->code ; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>

                <?php if ($product_info->price_type != ""): ?>

                        <?php 
                            $single_product_info    = DB::table('tbl_product_price')
                                ->leftJoin('tbl_product_color', 'tbl_product_price.color_id', '=', 'tbl_product_price.id')
                                ->leftJoin('tbl_product_size', 'tbl_product_price.size_id', '=', 'tbl_product_size.id')
                                ->leftJoin('tbl_size', 'tbl_product_size.size_id', '=','tbl_size.id')
                                ->select('tbl_product_price.*', 'tbl_product_color.color_code','tbl_product_color.color_image','tbl_product_size.size_id','tbl_size.size')
                                ->where('tbl_product_price.product_id', $product_info->id)
                                ->first() ;
                                
                            $product_price_siam = DB::table('tbl_product_price')->where('product_id', $product_info->id)->first() ;
                        ?>


                        <div class="col-md-12 row">
                            <div class="col-md-2 unit_price_check" style="display: <?php if ($product_info->price_type == "2"){echo "";}else{echo "none"; } ?>">
                                <label>Unit price</label>
                            </div>
                            <div class="col-md-10 form-group unit_price_check" style="display: <?php if ($product_info->price_type == "2"){echo "";}else{echo "none"; } ?>">
                                <input type="number" class="form-control" name="unit_price" value="<?php echo $single_product_info->product_price; ?>" >
                            </div>
                            <div class="col-md-2 unit_price_check" style="display: <?php if ($product_info->price_type == "2"){echo "";}else{echo "none"; } ?>">
                                <label>Discount</label>
                            </div>
                            <div class="col-md-8 form-group unit_price_check" style="display: <?php if ($product_info->price_type == "2"){echo "";}else{echo "none"; } ?>">
                                <input type="number" class="form-control" name="discount" id="discount" value="<?php echo $single_product_info->discount; ?>" >
                            </div>
                            <div class="col-md-2 form-group unit_price_check" style="display: <?php if ($product_info->price_type == "2"){echo "";}else{echo "none"; } ?>">
                                <?php $check_info = DB::table('tbl_product_price')->where('product_id', $product_info->id)->first() ; ?>
                                <select class="form-control" id="discount_status">
                                    <option value="1" <?php if($check_info->currency_id == 1){echo "selected"; }else{echo " ";} ?>>$</option>
                                    <option value="2" <?php if($check_info->currency_id == 2){echo "selected"; }else{echo " ";} ?>>%</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12 row">
                                <div class="col-md-2 unit_price_check">
                            <label>Quantity </label>
                        </div>

                        <div class="col-md-4 form-group unit_price_check">
                            <input type="number" class="form-control" name="qty" id="qty" value="{{$product_info->qty}}" placeholder="quantity">
                        </div>
                       
                        <div class="col-md-4 form-group unit_price_check">
                            
                            <select class="form-control" id="cond" name="cond">
                                <option>Select Condition</option>
                                <option value="1"  <?php if($product_info->cond == 1){echo "selected";}else{echo " ";}?>>NEW</option>
                                <option value="2" <?php if($product_info->cond == 2){echo "selected"; }else{echo " ";} ?>>USED</option>
                            </select>
                        </div>
                                
                            </div>
                            

                            <div class="form-group col-md-12 row" style="display:none;">
                                <div class="col-md-2 unit_price_check" style="display: <?php if ($product_info->price_type == "2"){echo "";}else{echo "none"; } ?>">
                                   <label>Offer Start</label>
                               </div>
       
                               <div class="col-md-4 form-group unit_price_check" style="display: <?php if ($product_info->price_type == "2"){echo "";}else{echo "none"; } ?>">
                                   <input class="datepicker form-control" name="offer_start_date" data-date-format="dd/mm/yyyy" value="<?php if($product_info->offer_start != null){ echo date("d/m/Y", strtotime($product_info->offer_start)); }else{echo "";} ?>">
                               </div>
       
                               <div class="col-md-2 unit_price_check" style="display: <?php if ($product_info->price_type == "2"){echo "";}else{echo "none"; } ?>">
                                   <label>Offer End</label>
                               </div>
                               <div class="col-md-4 form-group unit_price_check" style="display: <?php if ($product_info->price_type == "2"){echo "";}else{echo "none"; } ?>">
                                   <input class="datepicker form-control" name="offer_end_date" data-date-format="dd/mm/yyyy" value="<?php if($product_info->offer_end != null){ echo date("d/m/Y", strtotime($product_info->offer_end)); }else{echo "";} ?>">
                               </div>
                           </div>
                        </div>


                    <?php 
                        $custom_price_setting    = DB::table('tbl_product_price')
                        ->leftJoin('tbl_product_color', 'tbl_product_price.color_id', '=', 'tbl_product_price.id')
                        ->select('tbl_product_price.*', 'tbl_product_color.color_code','tbl_product_color.color_image')
                        ->where('tbl_product_price.product_id', $product_info->id)
                        ->where('tbl_product_price.price_status', 4)
                        ->get() ;
                     ?>
                    
                    <div class="col-md-12 custom_price" style="display: none;">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content row">

                                        <div class="col-md-4 form-group row">
                                            <input type="radio" class="form-control col-md-1 custom_price_value" name="custom_price_value" value="2" <?php if($single_product_info->color_id != 0 && $product_info->price_type == "4"){echo "checked"; }else{echo "";} ?>>
                                            <label for="" class="col-md-10" style="margin-top: 10px;" >Image Wise Price</label>
                                        </div>
                                        <div class="col-md-4 form-group row">
                                            <input type="radio" class="form-control col-md-1 custom_price_value" name="custom_price_value" value="1" <?php if($product_price_siam->size_id != 0 && $product_info->price_type == "4"){echo "checked"; }else{echo "";} ?>>
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
                                                                <?php if (count($custom_price_setting) > 0): ?>
                                                                    <?php foreach ($custom_price_setting as $key => $cspvalues):?>
                                                                        <tr class="">
                                                                            <?php if($single_product_info->color_id != ""): ?>

                                                                                <?php 

                                                                                $color_info = DB::table('tbl_product_color')
                                                                                ->where('id', $cspvalues->color_id)->first() ;

                                                                                if ($color_info->color_code != null): ?>
                                                                                    <td>
                                                                                        <center>
                                                                                            <p style="width:50px;height:50px;background: <?php echo $color_info->color_code; ?>"> </p>
                                                                                        </center>
                                                                                    </td>
                                                                                    <?php 
                                                                                        $inputvalu = $color_info->color_code ;
                                                                                     ?>
                                                                                <?php else: ?>
                                                                                    <td>
                                                                                        <img width="100px" height="100px;" src="{{ URL::to('public/images/'.$color_info->color_image) }}" />
                                                                                    </td>
                                                                                    <?php 
                                                                                        $inputvalu = $color_info->color_image ;
                                                                                     ?>
                                                                                <?php endif; ?>
                                                                            <?php else:?>
                                                                                <td>
                                                                                    <?php 
                                                                                        $size_info = DB::table('tbl_size')->where('id', $cspvalues->size_id)->first() ;
                                                                                        $inputvalu = $cspvalues->size_id ;
                                                                                        echo $size_info->size ;
                                                                                    ?>
                                                                                </td>
                                                                            <?php endif; ?>
                                                                            <td><input name="image_per_qty_price[]" class="form-control image_per_qty_price" type="number" step="any" value="<?php echo $cspvalues->product_price; ?>" /></td>
                                                                            <input name="custom_price_image[]" type="hidden" class="custom_price_image" value="<?php echo $inputvalu; ?>" />
                                                                        </tr>
                                                                    <?php endforeach ?>

                                                                <?php endif ?>


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

                                        <?php $color_image_info         = DB::table('tbl_product_color')->where('product_id', $product_info->id)->get() ; ?>
                                        <?php 
                                            $package_price_setting    = DB::table('tbl_product_price')
                                            ->leftJoin('tbl_product_color', 'tbl_product_price.color_id', '=', 'tbl_product_price.id')
                                            ->select('tbl_product_price.*', 'tbl_product_color.color_code','tbl_product_color.color_image')
                                            ->where('tbl_product_price.product_id', $product_info->id)
                                            ->where('tbl_product_price.price_status', 1)
                                            ->get() ;
                                         ?>

                                        <?php if($product_info->price_type == "1"){echo ""; }else{echo "none";} ?>;

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
                                                
                                                    <?php if (count($package_price_setting) > 0): ?>
                                                        <?php foreach ($package_price_setting as $key => $ppspvalues):?>
                                                        <tr class="">
                                                            <?php if($single_product_info->color_id != ""): ?>

                                                                <?php 

                                                                $color_info = DB::table('tbl_product_color')
                                                                ->where('id', $ppspvalues->color_id)->first() ;

                                                                if ($color_info->color_code != null): ?>
                                                                    <td>
                                                                        <center>
                                                                            <p style="width:50px;height:50px;background: <?php echo $color_info->color_code; ?>"> </p>
                                                                        </center>
                                                                    </td>
                                                                    <?php 
                                                                        $package_price_value = $color_info->color_code ;
                                                                     ?>
                                                                <?php else: ?>
                                                                    <td>
                                                                        <img width="100px" height="100px;" src="{{ URL::to('public/images/'.$color_info->color_image) }}" />
                                                                    </td>
                                                                    <?php 
                                                                        $package_price_value = $color_info->color_image ;
                                                                     ?>
                                                                <?php endif; ?>
                                                            <?php endif; ?>
                                                            <td><input type="number" step="any" class="form-control quantity_start" name="quantity_start[]" value="<?php echo $ppspvalues->start_quantity; ?>"></td>
                                                            <td><input type="number" step="any" class="form-control quantity_end" name="quantity_end[]" value="<?php echo $ppspvalues->end_quantity; ?>"></td>
                                                            <td><input type="number" class="form-control price" name="price[]" step="any" value="<?php echo $ppspvalues->product_price; ?>"></td>
                                                            <input name="package_price_image[]" type="hidden" class="package_price_image" value="<?php echo $package_price_value; ?>" />
                                                        </tr>
                                                    <?php endforeach ?>
                                                    <?php endif ?>
                                                </tbody>

                                            </table>
                                            <input type="submit" class="add_items btn btn-success btn-sm add_more add_another" style="float: right;display: none;" value="Add More" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                <?php else: ?>

                <div class="col-md-12">

                    <div class="form-group row">
                        <div class="col-md-2 unit_price_check" style="display: none;">
                            <label>Unit price</label>
                        </div>
                        <div class="col-md-10 form-group unit_price_check" style="display: none;">
                            <input type="number" class="form-control" name="unit_price" value="0" placeholder="Unit price">
                        </div>
                    </div>

                    <div class="form-group row">
                         <div class="col-md-2 unit_price_check" style="display: none;">
                            <label>Discount</label>
                        </div>

                        <div class="col-md-8 form-group unit_price_check" style="display: none;">
                            <input type="number" class="form-control" name="discount" id="discount" value="0" placeholder="Discount">
                        </div>
                        <div class="col-md-2 form-group unit_price_check" style="display: none;">
                            <select class="form-control" id="discount_status">
                                <option value="1">$</option>
                                <option value="2">%</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                         <div class="col-md-2 unit_price_check" style="display: none;">
                            <label>Offer Start</label>
                        </div>

                        <div class="col-md-4 form-group unit_price_check" style="display: none;">
                            <input class="datepicker form-control" name="offer_start_date" data-date-format="dd/mm/yyyy" placeholder="d/m/Y">
                        </div>

                        <div class="col-md-2 unit_price_check" style="display: none;">
                            <label>Offer End</label>
                        </div>
                        <div class="col-md-4 form-group unit_price_check" style="display: none;">
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

                <?php endif ; ?>


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
                    <label>Description</label>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-12  form-group">
                    <fieldset class="form-group">
                        <textarea class="form-control" name="product_description" rows="10" id="product_details_users" placeholder="Product Description"><?php echo $product_info->product_description; ?></textarea>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Shipping Info Start -->
<div class="tab-pane" id="list-Shipping" role="tabpanel" aria-labelledby="list-Shipping-list" style="display:none;">
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
                        <?php if (strpos($product_info->shipping_method, ',') !== false): ?>
                            <?php $all_shipping_method = explode(',', $product_info->shipping_method); 
                                foreach ($all_shipping_method as $smvalue) { ?>
                                    <?php if ($smvalue != ""): ?>
                                        <option value="<?php echo $smvalue ; ?>" selected><?php $shipping_info = DB::table('tbl_shipping')->where('id', $smvalue)->first() ; echo $shipping_info->shippingCompanyName; ?></option>
                                    <?php endif ?>
                                <?php }
                             ?>
                        <?php endif ; ?>
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
                        <?php if (strpos($product_info->payment_method, ',') !== false): ?>
                            <?php $payment_method = explode(',', $product_info->payment_method); 
                                foreach ($payment_method as $pmvalue) { ?>
                                    <?php if ($pmvalue != ""): ?>
                                        <option value="<?php echo $pmvalue ; ?>" selected><?php $payment_info = DB::table('tbl_payment_method')->where('id', $pmvalue)->first() ; echo $payment_info->paymentMethodName; ?></option>
                                    <?php endif ?>
                                <?php }
                             ?>
                        <?php endif ; ?>
                        <?php foreach ($all_payment_method as $paymentmethod) { ?>
                            <option value="<?php echo $paymentmethod->id ; ?>"><?php echo $paymentmethod->paymentMethodName; ?></option>
                        <?php } ?>
                    </select>
                </div>  

            </div>

            <input type="hidden" name="product_id" value="<?php echo $product_info->id; ?>">

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
    <input type="hidden" name="primary_id" id="primary_id" value="<?php echo $product_info->id ; ?>">
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

                        <h4>Upload File</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>


                    </div>
                    <div class="modal-body">
                        <div class="tab-pane" id="profile-fill" role="tabpanel" aria-labelledby="profile-tab-fill">
                            <form id="upload_image_siam" method="POST" enctype="multipart/form-data" >
                                @csrf
                                <label for="main_image" style="border: 1px solid red;width: 100%;padding: 57px;text-align:center">
                                    <input type="file" id="main_image" class="form-control" name="images[]" style="display:none" multiple>
                                    Select Images
                                </label>
                                <input type="hidden" name="image_size" >
                                <input type="hidden" name="update_images" >
                            </form>   

                            <div class="progress" style="height:30px !important;font-size:15px !important">
                                <div class="progress-bar bg-gradient-gplus" role="progressbar" style="width: 0%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
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
                
                var product_images = [];
                $(".upload_images").each(function(){
                    product_images.push($(this).val())
                });
                var total_images = product_images.length;
                $("[name=image_size]").val(total_images);
                $("[name=update_images]").val(product_images);
                
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

            $(this).addClass( "siam_active" );
            $('#myModal').modal('show');
            $(this).find('.icon_show').css('display', 'none') ;

            
            var product_images = [];
            $(".upload_images").each(function(){
                product_images.push($(this).val())
            });

            var image_count = product_images.length + 1 ;


            if (image_count > 5) {
                toastr.error("Sorry! Your Maximum Five Image Upload Limit Over,");
                $(this).removeClass("siam_active") ;
                $(this).find('.icon_show').css("display", 'none') ;
                return false ;
            }
            

            var inputvalu = $(this).find('.captureInput').val();
            var imageidvalue = $(this).find('.captureidinfo').val();
            var random_id = Math.floor(1000 + Math.random() * 9000) ;
            $(this).find('.icon_show').removeAttr("style") ;

            $(".image_siam").append('<li class="remove_project_file3 ui-state-default" id="item_info_'+random_id+'" style="margin-bottom: 30px;">'
                + '<a href="#" style="color: red;float: right;font-size: 17px;" class="remove_project_file" border="2" getmainimageid="'+imageidvalue+'"><i class="fa fa-times" aria-hidden="true"></i></a>'
                + '<img width="100px" height="100px;" name="upload_project_images[]" type="file" class="new_project_image" src="<?php echo url('') ?>/public/images/'+inputvalu+'" />'
                + '<input name="upload_images[]" type="hidden" class="upload_images" value="'+inputvalu+'" />'
                + '<input name="uload_image_id[]" class="uload_image_id" type="hidden" value="'+imageidvalue+'" />'
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
            
            var product_images = [];
            $(".upload_images").each(function(){
                product_images.push($(this).val())
            });

            var image_count = product_images.length ;
            if(image_count > 1){
                var id      = $(this).attr('getmainimageid') ;
                var main_id = 'image_product_id_' + id;
                $("#"+main_id+"").removeClass("siam_active") ;
                $("#"+main_id+"").find('.icon_show').css("display", 'none') ;
                $(this).parent().remove();
            }else{
                toastr.error("Sorry !! You Can't remove last image", { positionClass: 'toast-bottom-full-width', });
                return false ;
            }
            
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
            var x           = "<?php echo url('') ?>/public/images/"+inputvalu;

            $('.icon_single_show').css('display', 'none') ;
            $(this).find('.icon_single_show').removeAttr('style');


            $(".meta_image_gallery").empty().append('<li class="remove_meta_image" style="margin-bottom: 30px;">'
                + '<a href="#" style="color: red;float: right;font-size: 17px;" class="meta_image_anchore" border="2"><i class="fa fa-times" aria-hidden="true"></i></a>'
                + '<img width="200px" height="200px" name="upload_meta_images[]" type="file" class="upload_meta_images" src="<?php echo url('') ?>/public/images/'+inputvalu+'" />'
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

        $('body').on('change', '#secondary_category_id', function (e) {
            e.preventDefault();

            var main_category_id        = $("#product_web_category").val() ;
            var secondary_category_id   = $(this).val() ;

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/getwebtertiarycategory') }}",
                'type':'post',
                'dataType':'text',
                data: {main_category_id: main_category_id, secondary_category_id:secondary_category_id},
                success:function(data){
                    $("#tertiary_category_id").empty();
                    $("#tertiary_category_id").html(data);
                  
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
            var package_template        = $("input.package_template:checked").val() ;
            var image__id               = $("input.customer_choose_color:checked").val() ;
            var custom_price_value      = $("input.custom_price_value:checked").val() ;
            var producttags             = $("#producttags").val() ;


            if (product_web_category == "" || product_web_category == undefined) {
                toastr.error("Sorry! Select Category First.");
                return false ;
            }

            if (secondary_category_id == "" || secondary_category_id == undefined) {
                toastr.error("Sorry! Select Secondary Category First.");
                return false ;
            }

            if (tertiary_category_id == "" || tertiary_category_id == undefined) {
                toastr.error("Sorry! Select Tertiary Category First.");
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


            if (product_name == "") {
                toastr.error("Sorry! Input Product Name.");
                return false ;
            }

            if (unit == "" || unit == undefined) {
                toastr.error("Sorry! Select Product Unit");
                return false ;
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
            var product_description      = tinymce.get("product_details_users").getContent();
            var shipping_status          = $("[name=shipping_status]").val() ;
            var offer_start_date         = $("[name=offer_start_date]").val() ;
            var offer_end_date           = $("[name=offer_end_date]").val() ;
            var qty                      = $("[name=qty]").val() ;
            var cond                     = $("[name=cond]").val() ;
            var product_id               = $("[name=product_id]").val() ;



            var productFinalImages = JSON.stringify(product_images) ;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/sellerUpdateProductInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {product_web_category: product_web_category, product_name: product_name, main_category_id:main_category_id, secondary_category_id:secondary_category_id, tertiary_category_id:tertiary_category_id, brand_id:brand_id, unit:unit, producttags:producttags, productFinalImages:productFinalImages, video_link_type:video_link_type, video_link:video_link, meta_title:meta_title, meta_description:meta_description, meta_image:meta_image, product_description:product_description, shipping_status:shipping_status,all_size_id:all_size_id,all_color_id:all_color_id,all_color_image:all_color_image,quantity_start:quantity_start,quantity_end:quantity_end,package_price_image:package_price_image,price:price,price:price, price_currency:price_currency,unit_price:unit_price, discount:discount,discount_status:discount_status,package_template:package_template,image__id:image__id,shipping_method:shipping_method,payment_method_id:payment_method_id,custom_price_value:custom_price_value,image_per_qty_price:image_per_qty_price,custom_price_image:custom_price_image,offer_start_date:offer_start_date,offer_end_date:offer_end_date,qty:qty,cond:cond,product_id:product_id},
                success:function(data){
                    console.log(data);
                    if(data == "success"){
                      toastr.success("Product Update Successfully Compeleted");
                        setTimeout(function(){
                            location.reload() ;
                        }, 3000);
                    }else if(data == "duplicate_product"){
                      toastr.error("Sorry! Product Already Exit");
                      return false ;
                    }else if(data == "not_verify"){
                      toastr.error("Sorry! Please Verify Your Account First");
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
                $("#color_image .upload_color_image").each(function(){
                    var val_arr = new Array();
                    var inputvalu = $(this).val();
                    var random_id = Math.floor(1000 + Math.random() * 9000) ;

                    val_arr.push('<tr class="" id="item_color_'+random_id+'">'
                        + '<td><img width="100px" height="100px;" src="<?php echo url('') ?>/public/images/'+inputvalu+'" /></td>'
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

        var inputvalu = $(this).find('.captureInput').val();
        var imageidvalue = $(this).find('.captureidinfo').val();
        var random_id = Math.floor(1000 + Math.random() * 9000) ;
        $(this).find('.icon_show').removeAttr("style") ;

        $('.color_image').append('<li class="remove_color_images ui-state-default" id="item_color_'+random_id+'" style="margin-bottom: 30px;float:left;margin-left:10px;">'
            + '<a href="#" style="color: red;float: right;font-size: 17px;" class="remove_color_images_s" border="2" getmainimageid="'+imageidvalue+'"><i class="fa fa-times" aria-hidden="true"></i></a>'
            + '<img width="100px" height="100px;" name="color_image_id[]" type="file" class="color_image_id" src="<?php echo url('') ?>/public/images/'+inputvalu+'" />'
            + '<input name="upload_color_image[]" type="hidden" class="upload_color_image" value="'+inputvalu+'" />'
            + '<input name="upload_color_image_id[]" class="upload_color_image_id" type="hidden" value="'+imageidvalue+'" />'
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
                    $("#color_image .upload_color_image").each(function(){
                        var val_arr = new Array();
                        var inputvalu = $(this).val();
                        var random_id = Math.floor(1000 + Math.random() * 9000) ;


                        val_arr.push('<tr class="" id="item_color_'+random_id+'">'
                            + '<td><img width="100px" height="100px;" name="color_image_id[]" type="file" class="color_image_id" src="<?php echo url('') ?>/public/images/'+inputvalu+'" /></td>'
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

</script>

    <script>
        $("body").on('change', '#upload_image_siam', function(e) {
            e.preventDefault();

            let myForm = document.getElementById('upload_image_siam');
            let formData = new FormData(myForm);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
                
            $.ajax({
                'url':"{{ url('/sellerupdateimageupload') }}",
                'data': formData,
                'processData': false, // prevent jQuery from automatically transforming the data into a query string.
                'contentType': false,
                'type': 'POST',
                beforeSend:function(){
                    $('#success').empty();
                },
                uploadProgress:function(event, position, total, percentComplete)
                {
                    $('.progress-bar').text(percentComplete + '%');
                    $('.progress-bar').css('width', percentComplete + '%');

                },
                success: function(data) {

                    if(data == "invalid_image"){
                        toastr.error("Sorry! Max Image FIle Is 5.");
                        $('#upload_image_siam')[0].reset();
                        return false ;
                    }else{
                        $(".image_siam").empty().html(data);
                        $('#upload_image_siam')[0].reset();
                        $("#myModal").modal('hide');
                        return false;
                    }
                    
                },error:function (response){
                   console.log(response);
                }
            })
        });

        $('.image_siam').on('click', '.remove_project_file', function(e) {
            e.preventDefault();
            var id      = $(this).attr('getmainimageid') ;
            var main_id = 'image_product_id_' + id;

            $(this).parent().remove();
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/removeSellerProductImage') }}",
                'type':'post',
                'dataType':'text',
                data: {id: id},
                success:function(data){
                    console.log(data);
                }
            });
        });
    </script>

@endsection

