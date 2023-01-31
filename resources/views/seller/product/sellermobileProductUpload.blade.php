@extends('seller.seller-master')
@section('title','Seller Product Upload')
@section('content')
@push('styles')
<style>
.img-thumbnail{
    height:90px !important;
}
#myTab li{
     float: left;
}
#myTab li a{
display: block;
    
}
.dropzone .dz-preview{
    margin: 1px !important;
}

.dropzone .dz-image{
}
.dropzone .dz-preview .dz-image{
    
    
}
.modal .modal-content i{
    top:11;
}

.heading-primary {
  font-size: 2em;
  padding: 2em;
  text-align: center;
}

.accordion dl,
.accordion-list {
  border: 1px solid #ddd;
  margin-top: -57px;
}

.accordion dl:after,
.accordion-list:after {
  content: "";
  display: block;
  height: 1em;
  width: 100%;
  background-color: #1c1111;
}

.accordion dd,
.accordion__panel {
  background-color: #131010;
  font-size: 1em;
  line-height: 1.5em;
}

.accordion p {
  padding: 1em 2em 1em 2em;
}

.accordion {
  position: relative;
  background-color: #eee;
}

.container {
  max-width: 960px;
  padding-left: 1em;
}

.accordionTitle,
.accordion__Heading {
  background-color: #099DF6;
  /*text-align: center; */
  
  text-indent: 3px;
  font-weight: 700;
  padding: 2em;
  display: block;
  text-decoration: none;
  color: #fff;
  -webkit-transition: background-color 0.5s ease-in-out;
  transition: background-color 0.5s ease-in-out;
  border-bottom: 1px solid #30bb64;
}

.accordionTitle:before,
.accordion__Heading:before {
  content: "+";
  font-size: 1.5em;
  line-height: 0.9em;
  float: left;
  -webkit-transition: -webkit-transform 0.3s ease-in-out;
  transition: transform 0.3s ease-in-out;
}

.accordionTitle:hover,
.accordion__Heading:hover {
  background-color: #38CC70;
}

.accordionTitleActive,
.accordionTitle.is-expanded {
  background-color: #38CC70;
}

.accordionTitleActive:before,
.accordionTitle.is-expanded:before {
  -webkit-transform: rotate(-225deg);
  -ms-transform: rotate(-225deg);
  transform: rotate(-225deg);
}

.accordionItem {
  height: auto;
  overflow: auto;
  max-height: 900px;
  -webkit-transition: max-height 1s;
  transition: max-height 1s;
}

@media screen and (min-width: 48em) {
  .accordionItem {
    max-height: 900px;
    -webkit-transition: max-height 0.5s;
    transition: max-height 0.5s;
  }
}

.accordionItem.is-collapsed {
  max-height: 0;
}

.no-js .accordionItem.is-collapsed {
  max-height: 900px;
}

.animateIn {
  -webkit-animation: accordionIn 0.65s normal ease-in-out both 1;
  animation: accordionIn 0.65s normal ease-in-out both 1;
}

.animateOut {
  -webkit-animation: accordionOut 0.75s alternate ease-in-out both 1;
  animation: accordionOut 0.75s alternate ease-in-out both 1;
}

@-webkit-keyframes accordionIn {
  0% {
    opacity: 0;
    -webkit-transform: scale(0.9) rotateX(-60deg);
    transform: scale(0.9) rotateX(-60deg);
    -webkit-transform-origin: 50% 0;
    transform-origin: 50% 0;
  }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
  }
}

@keyframes accordionIn {
  0% {
    opacity: 0;
    -webkit-transform: scale(0.9) rotateX(-60deg);
    transform: scale(0.9) rotateX(-60deg);
    -webkit-transform-origin: 50% 0;
    transform-origin: 50% 0;
  }
  100% {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
  }
}

@-webkit-keyframes accordionOut {
  0% {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
  }
  100% {
    opacity: 0;
    -webkit-transform: scale(0.9) rotateX(-60deg);
    transform: scale(0.9) rotateX(-60deg);
  }
}

@keyframes accordionOut {
  0% {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
  }
  100% {
    opacity: 0;
    -webkit-transform: scale(0.9) rotateX(-60deg);
    transform: scale(0.9) rotateX(-60deg);
  }
}
/*label styles */

.label-style {
  float: left;
  margin-right: 15px;
  padding-top: 5px;
  padding-left: 100px;
}
/* form headings */

.headings {
  text-align: center;
  font-weight: bold;
}
/* button styles */

.button-container {
  text-align: center;
  margin-bottom: 5px;
}
/* position of the hint */

.hint {
  display: inline-block;
  position: relative;
  margin-left: 0.5em;
  margin-top: 0.3em;
}
/* background style for 'i' */

.hint-icon {
  background: #099DF6;
  border-radius: 10px;
  cursor: pointer;
  display: inline-block;
  font-style: normal;
  font-family: 'Libre Baskerville';
  height: 20px;
  line-height: 1.3em;
  text-align: center;
  width: 20px;
}
/* hint icon hover style */

.hint-icon:hover {
  background: #1f8ac9;
}
/* Displays the hint. important! Do not remove. */

.hint:hover .hint-description,
.hint:focus .hint-description {
  display: inline-block;
}
/* position of the hint  */

.hint-description {
  display: none;
  background: #3b3b3b;
  border: 1px solid #099DF6;
  border-radius: 3px;
  font-size: 0.8em;
  color: #ffffff;
  font-weight: bold;
  /*padding: 1em; */
  
  position: absolute;
  left: 30px;
  top: -15px;
  width: 180px;
  height: auto;
}
/* styling for the arrow */

.hint-description:before,
.hint-description:after {
  content: "";
  position: absolute;
  left: -11px;
  top: 15px;
  border-style: solid;
  border-width: 10px 10px 10px 0;
  border-color: transparent #099DF6;
}
/* overlay styling */

.hint-description:after {
  left: -10px;
  border-right-color: #3b3b3b;
}

.note-editable{
  background:black!important ;
}

.selected_icon{
    position: absolute;
    padding: 28px 40%!important;
    font-size: 30px!important;
    color: #4ebd37;
}
</style>

@endpush

<div class="container">
   <a style="margin-top:80px;" href="{{URL::to ('/sellerproductlist')}}" class="btn btn-primary float-right" role="button" aria-pressed="true">Product List</a>
  <h1 class="heading-primary">Product Upload </h1>
  
  <div class="accordion">
    <dl>
      <!-- description list -->
  <form>
      <!--end accordion tab 1 -->

      <dt>
          <!-- accordion tab 2 - Shipping Info -->
        <a href="#accordion2" aria-expanded="false" aria-controls="accordion2" class="accordion-title accordionTitle js-accordionTrigger">Products Info <span style="color: red!important;
    font-size: 15px;">*</span></a>
        </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion2" aria-hidden="true">
        <div class="container-fluid" style="padding-top: 20px;">
          <div class="main-container">

            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="pl-1">Select Category</label>
              </div>
              <div class="form-group col-lg-4">
               <select class="form-control select2" id="product_web_category" name="product_web_category">
                    <option value="0">Select Category</option>
                    <?php foreach ($all_primary_category as $wvalue) { ?>
                        <option value="<?php echo $wvalue->id; ?>">{{ $wvalue->category_name }}</option>
                    <?php } ?>
                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="pl-1">Subcategory</label>
              </div>
              <div class="form-group col-lg-4">
                <select class="form-control select2" id="secondary_category_id" name="secondary_category_id">

                </select>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="pl-1">Tertiary Category</label>
              </div>
              <div class="form-group col-lg-4">
                    <select class="form-control" id="tertiary_category_id" name="tertiary_category_id">
                                
                    </select>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-4">
                <label for="companyname" class="pl-1">Product Name </label>
              </div>
              <div class="form-group col-lg-4">
                <input type="text" id="product-name" class="form-control" name="product_name" placeholder="Product Name" required="">
              </div>
            </div>

            <div class="row" style="display:none">
              <div class="col-xs-4">
                <label for="address-line2" class="pl-1">Brand</label>
              </div>
              <div class="form-group col-lg-4">
                <select class="form-control" id="brand_id" name="brand_id" >
                    <option value="">Select Brand</option>
                    <?php foreach ($all_product_brand as $brvalue) { ?>
                        <option value="{{ $brvalue->id }}">{{ $brvalue->brand_name }}</option>
                    <?php } ?>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <label for="city" class="pl-1">Unit</label>
              </div>
              <div class="form-group col-lg-4">
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
      </dd>
      <!-- end accordion tab 2 -->
       <dt>
         
          <a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger">Main Images <span style="color: red!important;
    font-size: 15px;">*</span></a>
        </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true">
        <div class="container-fluid" style="padding-top: 20px;">
            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="pl-1">Full Name</label>
              </div>
              <div class="form-group col-lg-4">
                <input type="file" id="myBtn" class="form-control" name="fname" style="margin-bottom: 20px;">
                    <ul id="image_siam" class="image_siam list-unstyled" style="display: grid;grid-template-columns: repeat(2, 1fr);">
                    </ul>
              </div>
              
            </div>
          
        </div>
      </dd>

       <dt style="display:none;">
         
          <a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger">Video Provider</a>
        </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true" style="display:none;">
        <div class="container-fluid" style="padding-top: 20px;">
            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="pl-1">Video Provider</label>
              </div>
              <div class="form-group col-lg-4">
                <select class="form-control" id="accountSelect" name="video_link_type">
                            <option value="1">Youtube </option>
                            <option value="2">DailyMotion</option>
                        </select>
              </div>
            </div>


            <div class="row">
              <div class="col-xs-4">
                <label for="companyname" class="pl-1">Video Link</label>
              </div>
              <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="video_link" placeholder="Video Link">
              </div>
            </div>
          
        </div>
      </dd>

      <dt>
         
    <a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger" style="display:none">Meta </a>
        </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true">
        <div class="container-fluid" style="padding-top: 20px;">
            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="pl-1">Meta Title</label>
              </div>
              <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="meta_title" placeholder="Meta Title">
              </div>
            </div>


            <div class="row">
              <div class="col-xs-4">
                <label for="companyname" class="pl-1">Description</label>
              </div>
              <div class="form-group col-lg-4">
                <fieldset class="form-group">
                        <textarea  maxlength="200" class="form-control" name="meta_description" rows="2"></textarea>
                    </fieldset>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <label for="phonenumber" class="pl-1">Tags</label>
              </div>
              <div class="form-group col-lg-4">
                <input type="text" data-role="tagsinput" id="producttags" name="producttags" class="sr-only" >
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <label for="phonenumber" class="pl-1">Meta Image</label>
              </div>
              <div class="form-group col-lg-4">
                <input type="file" id="meta_image" class="form-control" name="meta_image" >
                    <ul id="meta_image_gallery" class="meta_image_gallery list-unstyled">
                    </ul>
              </div>
            </div>
          
        </div>
      </dd>
      <!-- end accordion tab 3 -->

         <dt>
          <a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger" style="display:none">Select Color / Image </a>
        </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true">
        <div class="container-fluid" style="padding-top: 20px;">
          
            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="pl-1">Color</label>
                <div class="form-group">
                <input type="radio" class="form-control col-md-1 customer_choose_color" name="image__id" value="1">
              </div>
                
              </div>
              
               <div class="col-xs-4">
                <div class="form-group ">
                <label for="fullname" class="pl-1">Image</label>
                <input type="radio" class="form-control col-md-1 customer_choose_color" name="image__id" value="2">
                </div>
              </div>
              
                
              
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

             <div class="row">
              <p>Select Size</p>
              
               <?php 
                    $all_size = DB::table('tbl_size')->where('supplier_id', Session::get('supplier_id'))->where('status', 1)->get() ;
                 ?>
                 <?php foreach ($all_size as $size_value): ?>
              <div class="col-xs-4">
                <label for="fullname" class="pl-1"><?php echo $size_value->size; ?></label>
                <div class="form-group">
               <input type="checkbox" class="form-control" style="width:25px;margin-left:.5rem;" name="size_id[]" value="<?php echo $size_value->id."/".$size_value->size; ?>">
              </div>
                
              </div>
               <?php endforeach ?>
              
            </div>

          
        </div>
      </dd>
      <dt>
        <a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger">Pricing Option <span style="color: red!important;
    font-size: 15px;">*</span></a>
      </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true">
        <div class="form form-horizontal">
          <div class="form-body">
              <div class="row">
                  <br>
                  <div class="col-xs-3 form-group row ml-1" style="display:none">
                      <input type="radio" class="form-control package_template" name="package_template" value="3" >
                      <label for="" class="col-md-10" style="margin-top: 10px;font-size: 2.2vmin;">Negotiated</label>
                  </div>&nbsp;&nbsp;
                  <div class="col-xs-3 form-group row" style="display:none">
                      <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="2" checked>
                      <label for="" class="col-md-10" style="margin-top: 10px;font-size: 2.2vmin;">Single Price</label>
                  </div>
                  &nbsp;&nbsp;
                  <div class="col-xs-3 form-group row" style="display:none">
                      <input type="radio" class="form-control col-xs-12 package_template" name="package_template" value="4">
                      <label for="" class="col-md-12" style="margin-top: 10px;font-size: 2.2vmin;">Custom Price</label>
                  </div>
                  &nbsp;&nbsp;
                  <div class="col-xs-3 form-group row" style="display:none">
                      <input type="radio" class="form-control col-md-1 package_template" name="package_template" value="1">
                      <label for="" class="col-md-10" style="margin-top: 10px;font-size: 2.2vmin;">Package Price</label>
                  </div>

                  <div class="col-md-4 form-group row ml-1">
                        <label for="currency_id">Select Your Currency</label>
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

                  <div class="col-md-12">

                      <div class="form-group row">
                          <div class="col-md-2 unit_price_check" >
                              <label>Unit price</label>
                          </div> 
                          <div class="col-md-10 form-group unit_price_check" >
                              <input type="number" class="form-control" name="unit_price"  placeholder="Unit price">
                          </div>
                      </div>
                      <div class="form-group row">
                          <div class="col-md-2" >
                              <label>Quantity</label>
                          </div>

                          <div class="col-md-4 form-group">
                              <input type="number" class="form-control" name="qty" value="0" placeholder="Quantity">
                          </div>
                          <div class="col-md-4 form-group">
                              <select class="form-control" id="cond" name="cond" >
                                <option>Select Condition</option>
                                <option value="1">NEW</option>
                                <option value="2">USED</option>
                            </select>
                          </div>
                          
                          
                         {{-- <div class="col-md-2 unit_price_check" >
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
                          </div>--}}
                          
                          
                      </div>

                      <div class="form-group row">
                          <div class="col-md-2 unit_price_check">
                              <label>Discount</label>
                          </div>

                          <div class="col-md-8 form-group unit_price_check">
                              <input type="number" class="form-control" name="discount" id="discount" value="0" placeholder="Discount">
                          </div>
                          <div class="col-md-2 form-group unit_price_check" >
                              <select class="form-control" id="discount_status">
                                  <option value="1">$</option>
                                  <option value="2">%</option>
                              </select>
                          </div>
                      </div>

                      
                    
                  </div>
                  <div class="col-md-12 custom_price" style="display: none;">
                      <div class="row">
                          <div class="col-12">
                              <div class="card">
                                  <div class="card-content row">

                                      <div class="col-xs-3 form-group row ml-1">
                                          <input type="radio" class="form-control col-xs-12 custom_price_value" name="custom_price_value" value="2">
                                          <label for="" class="col-md-10" style="margin-top: 10px;font-size: 3vmin;">Image Wise Price</label>
                                      </div>
                                      &nbsp;&nbsp;
                                      <div class="col-xs-3 form-group row">
                                          <input type="radio" class="form-control col-xs-12 custom_price_value" name="custom_price_value" value="1">
                                          <label for="" class="col-md-10" style="margin-top: 10px;font-size: 3vmin;">Size Wise Price</label>
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
      </dd>
      <dt>
          <a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger">Description <span style="color: red!important;
    font-size: 15px;">*</span></a>
        </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true">
        <div class="container-fluid">
            <div class="row">
              <div class="col-xs-4">
               <fieldset class="form-group">
                        <textarea class="form-control" name="product_description" rows="10" placeholder="Product Description" id="product_details_users" required=""></textarea>
                    </fieldset>
             
              </div>
            </div>
          
        </div>
      </dd>
      <dt style="display:none;">
          <a href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="accordion-title accordionTitle js-accordionTrigger">Payment Method </a>
        </dt>
      <dd class="accordion-content accordionItem is-collapsed" id="accordion3" aria-hidden="true" style="display:none;">
        <div class="container-fluid" style="padding-top: 20px;">
            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="pl-1">Payment Method</label>
              </div>
              <div class="form-group col-lg-4">
              <select class="select2 form-control" multiple="multiple" id="payment_method_id" name="payment_method_id[]">
                        <?php foreach ($all_payment_method as $paymentmethod) { ?>
                            <option value="<?php echo $paymentmethod->id ; ?>"><?php echo $paymentmethod->paymentMethodName; ?></option>
                        <?php } ?>
                    </select>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4">
                <label for="fullname" class="pl-1">Shipping Method</label>
              </div>
              <div class="form-group col-lg-4">
               <select class="select2 form-control" multiple="multiple" id="shipping_method" name="shipping_method[]">
                        <?php foreach ($all_shipping as $shippingmethod) { ?>
                            <option value="<?php echo $shippingmethod->id ; ?>"><?php echo $shippingmethod->shippingCompanyName; ?></option>
                        <?php } ?>
                    </select>
              </div>
            </div>
          
        </div>
      </dd>
      <dt>
        <a class="accordion-title">
          <button class="btn btn-success btn-lg btn-block product_page_submit" type="submit">Submit</button>
        </a>
        
      </dt>
      </form>

    </dl>
    <!-- end description list -->
  </div>
  <!-- end accordion -->
</div>
<!-- end container -->
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
                                    <input type="file" id="main_image" class="form-control" name="images[]"  multiple style="display:none" accept="image/*">
                                    Select Images
                                </label>
                                <input type="hidden" name="image_size" >
                            </form>  
                            
                            <div class="progress" style="height:30px !important;font-size:15px !important;background:white!important">
                                <div class="progress-bar bg-gradient-gplus" role="progressbar" style="width: 0%;background-color: #c0d3de!important;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100">0%</div>
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

@endsection
@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::to('public/js/jquery.ui.touch-punch.min.js') }}"></script>
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

(function() {
  var d = document,
    accordionToggles = d.querySelectorAll('.js-accordionTrigger'),
    setAria,
    setAccordionAria,
    switchAccordion,
    touchSupported = ('ontouchstart' in window),
    pointerSupported = ('pointerdown' in window);

  skipClickDelay = function(e) {
    e.preventDefault();
    e.target.click();
  }

  setAriaAttr = function(el, ariaType, newProperty) {
    el.setAttribute(ariaType, newProperty);
  };
  setAccordionAria = function(el1, el2, expanded) {
    switch (expanded) {
      case "true":
        setAriaAttr(el1, 'aria-expanded', 'true');
        setAriaAttr(el2, 'aria-hidden', 'false');
        break;
      case "false":
        setAriaAttr(el1, 'aria-expanded', 'false');
        setAriaAttr(el2, 'aria-hidden', 'true');
        break;
      default:
        break;
    }
  };
  //function
  switchAccordion = function(e) {
    e.preventDefault();
    var thisAnswer = e.target.parentNode.nextElementSibling;
    var thisQuestion = e.target;
    if (thisAnswer.classList.contains('is-collapsed')) {
      setAccordionAria(thisQuestion, thisAnswer, 'true');
    } else {
      setAccordionAria(thisQuestion, thisAnswer, 'false');
    }
    thisQuestion.classList.toggle('is-collapsed');
    thisQuestion.classList.toggle('is-expanded');
    thisAnswer.classList.toggle('is-collapsed');
    thisAnswer.classList.toggle('is-expanded');

    thisAnswer.classList.toggle('animateIn');
  };
  for (var i = 0, len = accordionToggles.length; i < len; i++) {
    if (touchSupported) {
      accordionToggles[i].addEventListener('touchstart', skipClickDelay, false);
    }
    if (pointerSupported) {
      accordionToggles[i].addEventListener('pointerdown', skipClickDelay, false);
    }
    accordionToggles[i].addEventListener('click', switchAccordion, false);
  }
})();
</script>
    <script>
        $(document).ready(function(){
            $('body').on('click', '#myBtn', function (e) {
                $('.progress-bar').text('0%');
                $('.progress-bar').css('width', '0%');
                var product_images = [];
                $(".upload_images").each(function(){
                    product_images.push($(this).val())
                });
                var total_images = product_images.length;
                $("[name=image_size]").val(total_images);
                
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
            maxFilesize: 5000,
            renameFile: function(file) {
                var dt = new Date();
                var time = dt.getTime();
               return time+file.name;
            },
            acceptedFiles: ".jpeg,.jpg,.png,.gif",
            addRemoveLinks: true,
            timeout: 180000,
            maxFiles: 5,
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
            },success: function(file, response) 
            {
            },
            error: function(file, response)
            {
                console.log(file);
                
            //     this.on("error", function(file, message) { 
            //         toastr.error("Sorry! Your Maximum Five Image Upload Limit Over,");
            //         this.removeFile(file); 
            //     });
            //   return false;
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
                    'url':"{{ url('/sellerSaveImage') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        Dropzone.forElement("#dropzone").removeAllFiles(true);
                        $("#image_siam").empty().html(data);
                        $("#myModal").modal('hide');
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
                }
            });
        });
    </script>

    <script>

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
        $('body').on('change', '#product_web_category', function (e) {
            e.preventDefault();

            var main_category_id = $(this).val() ;

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });
            $.ajax({
                'url':"{{ url('/getwebsecondarycategory') }}",
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
            var upload_images_siam      = $(".upload_images").val() ;
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

            if (product_name == "") {
                toastr.error("Sorry! Input Product Name.");
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
            
            if(product_images.length > 5){
                toastr.error("Sorry! Max Image FIle Is 5.");
                $(".list-group-item").removeClass('active');
                $(".tab-pane").removeClass('active');
                $("#list-profile-list").addClass('active');
                $("#list-profile").addClass('active');
                return false ;
            }


            var video_link_type          = $("[name=video_link_type]").val() ;
            var video_link               = $("[name=video_link]").val() ;
            var meta_title               = $("[name=meta_title]").val() ;
            var meta_description         = $("[name=meta_description]").val() ;
            var meta_image               = $("[name=meta_images_value]").val() ;
            var shipping_status          = $("[name=shipping_status]").val() ;
            var offer_start_date         = $("[name=offer_start_date]").val() ;
            var offer_end_date           = $("[name=offer_end_date]").val() ;
            var qty                      = $("[name=qty]").val() ;
            var cond                     = $("[name=cond]").val() ;
            
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
                'url':"{{ url('/insertSellerProductInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {product_web_category: product_web_category, product_name: product_name, main_category_id:main_category_id, secondary_category_id:secondary_category_id, tertiary_category_id:tertiary_category_id, brand_id:brand_id, unit:unit, producttags:producttags, productFinalImages:productFinalImages, video_link_type:video_link_type, video_link:video_link, meta_title:meta_title, meta_description:meta_description, meta_image:meta_image, product_description:product_description, shipping_status:shipping_status,all_size_id:all_size_id,all_color_id:all_color_id,all_color_image:all_color_image,quantity_start:quantity_start,quantity_end:quantity_end,package_price_image:package_price_image,price:price,price:price, price_currency:price_currency,unit_price:unit_price, discount:discount,discount_status:discount_status,package_template:package_template,image__id:image__id,shipping_method:shipping_method,payment_method_id:payment_method_id,custom_price_value:custom_price_value,image_per_qty_price:image_per_qty_price,custom_price_image:custom_price_image,offer_start_date:offer_start_date,offer_end_date:offer_end_date,qty:qty,cond:cond},
                success:function(data){
                    if(data == "success"){
                      toastr.success("Product Add Successfully Compeleted");
                        setTimeout(function(){
                        url = "sellerproductlist";
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
        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');
        
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
                'url':"{{ url('/sellerimageupload') }}",
                'data': formData,
                'processData': false, // prevent jQuery from automatically transforming the data into a query string.
                'contentType': false,
                'type': 'POST',
                success: function(data) {
                    if(data == "invalid_image"){
                        toastr.error("Sorry! Max Image FIle Is 5.");
                        $('#upload_image_siam')[0].reset();
                        return false ;
                    }else{
                        $("#image_siam").empty().html(data);
                        $('#upload_image_siam')[0].reset();
                        $("#myModal").modal('hide');
                        return false;
                    }
                    
                },
                xhr: function(){
                    var xhr = new XMLHttpRequest();

                    xhr.upload.addEventListener('progress', function(e){
                        if(e.lengthComputable){
                            var uploadPercent = e.loaded / e.total;
                            uploadPercent = parseInt(uploadPercent * 100);

                            $('.progress-bar').text(uploadPercent + '%');
                            $('.progress-bar').width(uploadPercent + '%');

                            if(uploadPercent == 100){
                                $('.progress-bar').text('Completed');
                                $('#completed').text('File Uploaded');
                            }
                        }
                    }, false);

                    return xhr;
                }
            })
        });
    </script>

@endsection
