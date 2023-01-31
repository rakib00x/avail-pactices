@extends('mobile/master-website')
@section('content')
    <div class="page-content-wrapper">
        <!-- Top Products-->
        <div class="top-products-area py-3">
            <div class="container">
                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6>Recommended for you</h6>
                    <!-- Select Product Catagory-->
                    <div class="select-product-catagory">
                        <select class="form-select" id="selectProductCatagory" name="selectProductCatagory" aria-label="Default select example">
                            <option selected>Short by</option>
                            <option value="1">Low to High</option>
                            <option value="2">High to Low</option>
                        </select>
                    </div>
                </div>
                <div class="product-catagories">
                    <div class="row g-3">
                        <!-- Single Catagory-->
                        <div class="col-4"><a class="shadow-sm" href="#"><img src="{{ URL::to('public/img/product/5.png') }}" alt="">Furniture</a></div>
                        <!-- Single Catagory-->
                        <div class="col-4"><a class="shadow-sm" href="#"><img src="{{ URL::to('public/img/product/9.png') }}" alt="">Shoes</a></div>
                        <!-- Single Catagory-->
                        <div class="col-4"><a class="shadow-sm" href="#"><img src="{{ URL::to('public/img/product/4.png') }}" alt="">Dress</a></div>
                    </div>
                </div>
                <div class="row g-3">

                    <!-- Single Weekly Product Card-->
                    <div class="col-12 col-md-6">
                        <div class="card weekly-product-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="product-thumbnail-side">
                                    <a class="product-thumbnail d-block single-product-recommended" href="#"><img src="{{ URL::to('public/img/product/10.png') }}" alt=""></a>
                                </div>
                                <div class="product-description"><a class="product-title d-block" href="#">sbs app waterproof membrane/asphalt roll roofing...</a>
                                    <p>BDT 452.71 - BDT 684.49</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Single Weekly Product Card-->
                    <div class="col-12 col-md-6">
                        <div class="card weekly-product-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="product-thumbnail-side">
                                    <a class="product-thumbnail d-block single-product-recommended" href="#"><img src="{{ URL::to('public/img/product/10.png') }}" alt=""></a>
                                </div>
                                <div class="product-description"><a class="product-title d-block" href="#">sbs app waterproof membrane/asphalt roll roofing...</a>
                                    <p>BDT 452.71 - BDT 684.49</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Single Weekly Product Card-->
                    <div class="col-12 col-md-6">
                        <div class="card weekly-product-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="product-thumbnail-side">
                                    <a class="product-thumbnail d-block single-product-recommended" href="#"><img src="{{ URL::to('public/img/product/10.png') }}" alt=""></a>
                                </div>
                                <div class="product-description"><a class="product-title d-block" href="#">sbs app waterproof membrane/asphalt roll roofing...</a>
                                    <p>BDT 452.71 - BDT 684.49</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Single Weekly Product Card-->
                    <div class="col-12 col-md-6">
                        <div class="card weekly-product-card">
                            <div class="card-body d-flex align-items-center">
                                <div class="product-thumbnail-side">
                                    <a class="product-thumbnail d-block single-product-recommended" href="#"><img src="{{ URL::to('public/img/product/10.png') }}" alt=""></a>
                                </div>
                                <div class="product-description"><a class="product-title d-block" href="#">sbs app waterproof membrane/asphalt roll roofing...</a>
                                    <p>BDT 452.71 - BDT 684.49</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .single-product-recommended img {
            border: 1px solid #ddd !important;
            width: 142px !important;
            height: 142px !important;
            padding: 5px;
        }
    </style>
@endsection

@section('page_headline')
    Primary Category Name Goes Here
@endsection

