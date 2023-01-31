@extends('marketing.employee-master')
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
    #product_description{
        color:#fff;
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
<a style="margin-bottom: -25px;" href="{{URL::to ('/marketerproductlist')}}" class="btn btn-primary float-right" role="button" aria-pressed="true">Product List</a>
</div>
<div class="card-content">
<div class="card-body">
<form method="post"> 
<div class="row">
<div class="col-12 col-sm-12 col-md-3 ">
<div class="list-group" role="tablist">
<a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab">Add Products <span style="color: red!important;
    font-size: 15px;">*</span></a>

<a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" >Meta  Tag</a>


<a class="list-group-item list-group-item-action" id="list-escription-list" data-toggle="list" href="#list-description" role="tab">Description <span style="color: red!important;
    font-size: 15px;">*</span></a>

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
                    

                    <div class="col-md-3 mt-2">
                        <label>Product Name</label>
                    </div>
                    <div class="col-md-9 form-group mt-2">
                        <input type="text" id="product-name" class="form-control" name="product_name" value="<?php echo $product_info->product_name ; ?>" required="">
                    </div>

                    
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Meta Title Start -->
<div class="tab-pane" id="list-settings" role="tabpanel" aria-labelledby="list-settings-list">
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
                    
                    <div class="col-md-12 col-sm-12 col-12  form-group">
                    <fieldset class="form-group">
                        <textarea class="form-control summernote" name="product_description" rows="10" placeholder="Product Description"><?php echo $product_info->product_description; ?></textarea>
                    </fieldset>
                </div>
                 </div>
            </div>
        </div>
    </div>
</div>


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
        $(".product_page_submit").click(function(e){
            e.preventDefault() ;
        // tinymce.get("product_details_users").getContent();

            var product_name            = $("[name=product_name]").val() ;
            var producttags             = $("#producttags").val() ;
            var meta_title               = $("[name=meta_title]").val() ;
            var meta_description         = $("[name=meta_description]").val() ;
            var product_description      = $("[name=product_description]").val() ;
            var primary_id               = $("[name=primary_id]").val() ;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                'url':"{{ url('/marketerUpdateProductInfo') }}",
                'type':'post',
                'dataType':'text',
                data: {product_name: product_name,producttags:producttags,meta_title:meta_title,meta_description:meta_description,product_description:product_description,primary_id:primary_id},
                success:function(data){
                    console.log(data);
                    if(data == "success"){
                      toastr.success("Product Update Successfully Compeleted");
                        location.reload(true) ;
                    }

                }
            });
        });

    </script>
    

@endsection

