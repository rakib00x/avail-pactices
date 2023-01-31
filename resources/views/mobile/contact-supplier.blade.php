@extends('mobile.master-website')
@section('content')
    <div class="page-content-wrapper">

        <div class="container pt-2">
            <div class="section-heading mt-3">
                <h5 class="mb-1">Contact Supplier</h5>
                <p class="mb-4">To:  Cable Necero(Shenzhen Necero Optical Fiber And Cable Co., Ltd.)</p>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <center>
                            <img class="contact-supplier-image-container" src="{{ URL::to('public/img/product/4.png') }}" alt="">
                        </center>
                    </div>
                    <div class="col-md-8">
                        <h6>SC simplex sm G657B3 fiber optical patch cord outdoor 300m to 500m SC simplex drop ftth cable</h6>
                        <p class="mt-2">BDT 41.14 - BDT 85.70 / Pieces</p>
                    </div>
                </div>

            </div>
            <!-- Contact Form-->
            <div class="contact-form mt-3 pb-3">
                <form action="#" method="">

                    <h5>Quantity Needed</h5>
                    <div class="row">
                        <div class="col-md-8">
                            <input class="form-control mb-3" id="email" type="email" placeholder=">2">
                        </div>
                        <div class="col-md-4">
                            <select class="mb-3 form-control form-select" id="topic" name="topic">
                                <option value="">Choose Unit</option>
                                <option value="1">Pcs</option>
                                <option value="2">Kg</option>
                                <option value="3">Litre</option>
                            </select>
                        </div>
                    </div>

                    <textarea class="form-control mb-3" id="message" name="" cols="30" rows="10" placeholder="Write something..."></textarea>
                    <button class="btn btn-success btn-lg w-100">Send Now</button>
                </form>
            </div>
        </div>

    </div>
@endsection

@section('css')
<style>
    .contact-supplier-image-container {
        border: 1px solid #ddd !important;
        width: 250px !important;
        height: 250px !important;
        padding: 5px;
    }
</style>
@endsection
