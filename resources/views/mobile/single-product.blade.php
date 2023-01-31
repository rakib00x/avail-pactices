@extends('mobile.master-website')
@section('content')
    <div class="page-content-wrapper">
        <!-- Product Slides-->
        <div class="product-slides owl-carousel">
            <!-- Single Hero Slide-->
            <div class="single-product-slide" style="background-image: url({{ URL::to('public/img/bg-img/6.jpg') }})"></div>
            <!-- Single Hero Slide-->
            <div class="single-product-slide" style="background-image: url({{ URL::to('public/img/bg-img/6.jpg') }})"></div>
            <!-- Single Hero Slide-->
            <div class="single-product-slide" style="background-image: url({{ URL::to('public/img/bg-img/6.jpg') }})"></div>
        </div>
        <div class="product-description pb-3">
            <!-- Product Title & Meta Data-->
            <div class="product-title-meta-data bg-white mb-3 py-3">
                <div class="container d-flex justify-content-between">
                    <div class="p-title-price">
                        <h5 class="mb-1">BDT 329.93 - BDT 668.43</h5>
                        <p>Min. Order: 200 Pieces</p>
                        <p class="mb-0">Handmade Bohemian Crossbody Bag Cotton Macrame Handbags</p>
                    </div>
                </div>
            </div>

            <!-- Send Inquiry -->
            <div class="flash-sale-panel bg-white mb-3 py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <center>
                                <button class="custom-send-inquiry mb-2">Send Inquiry</button>
                                <button class="custom-chat-now-button">Chat Now</button>
                            </center>
                        </div>
                    </div>


                </div>
            </div>
            <!-- Selection Panel-->
            <div class="container">

                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6>Color</h6>
                </div>

                <div class="row g-1">

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/2.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/3.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/6.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/1.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/2.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/6.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/5.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/4.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/1.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/4.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/2.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/3.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/6.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/7.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/8.png') }}" alt="">
                        </div>
                    </div>

                    <div class="col-2 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <img class="mb-1" src="{{ URL::to('public/img/product/9.png') }}" alt="">
                        </div>
                    </div>

                </div>

            </div>
            <div class="container mt-4">

                <div class="section-heading d-flex align-items-center justify-content-between">
                    <h6>Size</h6>
                </div>

                <div class="row g-1">

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span>XL</span>
                        </div>
                    </div>

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span>75 B</span>
                        </div>
                    </div>

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span>10 Litre</span>
                        </div>
                    </div>

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span>M</span>
                        </div>
                    </div>

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span> 42 KG</span>
                        </div>
                    </div>

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span>XL</span>
                        </div>
                    </div>

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span>75 B</span>
                        </div>
                    </div>

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span>10 Litre</span>
                        </div>
                    </div>

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span>M</span>
                        </div>
                    </div>

                    <div class="col-3 col-md-2 col-lg-4">
                        <div class="single-product-color">
                            <input type="checkbox" name="size"> <span> 42 KG</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="cart-form-wrapper bg-white mb-3 py-3">
            <div class="container">
                <form class="cart-form" action="#" method="">
                    <div class="order-plus-minus d-flex align-items-center">
                        <div class="quantity-button-handler">-</div>
                        <input class="form-control cart-quantity-input" type="text" step="1" name="quantity" value="3">
                        <div class="quantity-button-handler">+</div>
                    </div>
                    <button class="btn btn-danger ms-3" type="submit">Add To Cart</button>
                </form>
            </div>
        </div>

        <div class="cart-form-wrapper bg-gray mb-3 py-3">
            <div class="container">
                <table class="table">
                    <tr>
                        <td>Ship from</td>
                        <td>China</td>
                    </tr>
                    <tr>
                        <td>Ship to</td>
                        <td>Bangladesh</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="cart-form-wrapper bg-warning mb-3 py-3">
            <div class="container">
                <table class="table">
                    <tr>
                        <td>Place of Origin</td>
                        <td>:</td>
                        <td>Guangdong, China</td>
                    </tr>
                    <tr>
                        <td>Strap Type</td>
                        <td>:</td>
                        <td>Adjusted-straps</td>
                    </tr>
                    <tr>
                        <td>Color</td>
                        <td>:</td>
                        <td>Red, Green, Blue</td>
                    </tr>
                    <tr>
                        <td>Use</td>
                        <td>:</td>
                        <td>daily dress</td>
                    </tr>
                    <tr>
                        <td>Product Name</td>
                        <td>:</td>
                        <td>seamless braset</td>
                    </tr>
                    <tr>
                        <td>Material</td>
                        <td>:</td>
                        <td>NYLON / Elastane</td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>:</td>
                        <td>women</td>
                    </tr>
                    <tr>
                        <td>Place of Origin</td>
                        <td>:</td>
                        <td>Guangdong, China</td>
                    </tr>
                    <tr>
                        <td>Strap Type</td>
                        <td>:</td>
                        <td>Adjusted-straps</td>
                    </tr>
                    <tr>
                        <td>Color</td>
                        <td>:</td>
                        <td>Red, Green, Blue</td>
                    </tr>
                    <tr>
                        <td>Use</td>
                        <td>:</td>
                        <td>daily dress</td>
                    </tr>
                    <tr>
                        <td>Product Name</td>
                        <td>:</td>
                        <td>seamless braset</td>
                    </tr>
                    <tr>
                        <td>Material</td>
                        <td>:</td>
                        <td>NYLON / Elastane</td>
                    </tr>
                    <tr>
                        <td>Gender</td>
                        <td>:</td>
                        <td>women</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="bg-white mb-3 py-3">
            <div class="container d-flex justify-content-between">
                <div class="p-title-price">
                    <h5 class="mb-1">Zhongshan Shaxi Wanbao Garment Factory</h5>
                    <p><img src="https://u.alicdn.com/mobile/g/common/flags/1.0.0/assets/cn.png" width="24" height="18" alt=""> CN <span style="background: #d1d1d1;color: #fff;border-radius: 5px;padding-left: 6px;padding-right: 6px;font-weight: bold;">1 YR</span> Manufacturer, Trading Company</p>
                    <center><button class="custom-send-inquiry mb-2">Visit Store</button></center>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6>Hot Selling</h6>
            </div>
            <div class="row g-3">

                <!-- Single Top Product Card-->
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-hot-selling" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/2.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-hot-selling" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/2.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-hot-selling" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/1.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-hot-selling" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/4.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-hot-selling" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/8.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-hot-selling" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/5.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-hot-selling" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/1.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-hot-selling" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/2.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-4 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-hot-selling" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/1.png') }}" alt="">
                            </a>
                            <p class="mb-1">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="container mt-4 pb-4">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6>Recommended from other supplier</h6>
            </div>
            <div class="row g-3">

                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-recommended" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/2.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-recommended" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/2.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-recommended" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/1.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-recommended" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/4.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-recommended" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/8.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-recommended" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/5.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-recommended" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/1.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-recommended" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/2.png') }}" alt="">
                            </a>
                            <p class="mb-0">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

                <!-- Single Top Product Card-->
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card top-product-card">
                        <div class="card-body">
                            <a class="product-thumbnail d-block single-product-recommended" href="#">
                                <img class="mb-1" src="{{ URL::to('public/img/product/1.png') }}" alt="">
                            </a>
                            <p class="mb-1">BDT 985.50</p>
                            <p>2 Set(MOQ)</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
@endsection

@section('css')
<style>
    .custom-send-inquiry {
        width: 80%;
        font-family: Arial;
        color: #fff;
        outline: none;
        border: none;
        font-weight: 550;
        border-radius: 100px;
        padding: 0 28px;
        height: 40px;
        font-size: 17px;
        border-width: 1px;
        border-style: solid;
        background: #f60;
        border-color: #f60;
    }
    div.flash-sale-panel div.container div.col-md-12 button.custom-chat-now-button {
        text-align: center;
        width: 80% !important;
        font-family: Arial;
        color: #f60 !important;
        font-weight: normal;
        border-radius: 100px;
        padding: 0 28px !important;
        height: 40px;
        font-size: 17px;
        border-width: 1px;
        border-style: solid;
        background: #eeeeee;
        border-color: #f60;
        cursor: pointer;
        -moz-transition: all .3s ease-out;
        -webkit-transition: all .3s ease-out;
        transition: all .3s ease-out;
    }
    div.flash-sale-panel div.container div.col-md-12 button.custom-chat-now-button:hover {
        text-align: center;
        width: 80% !important;
        font-family: Arial;
        color: #f60 !important;
        font-weight: normal;
        border-radius: 100px;
        padding: 0 28px !important;
        height: 40px;
        font-size: 17px;
        border-width: 1px;
        border-style: solid;
        background: #febd92;
        border-color: #f60;
        cursor: pointer;
        -moz-transition: all .3s ease-out;
        -webkit-transition: all .3s ease-out;
        transition: all .3s ease-out;
    }
    .single-product-color img {
        border: 1px solid #ddd !important;
        width: 50px !important;
        height: 50px !important;
        padding: 5px;
    }
    .single-product-recommended img {
        border: 1px solid #ddd !important;
        width: 142px !important;
        height: 142px !important;
        padding: 5px;
    }
    .single-product-hot-selling img {
        border: 1px solid #ddd !important;
        width: 74px !important;
        height: 74px !important;
        padding: 5px;
    }
</style>
@endsection
