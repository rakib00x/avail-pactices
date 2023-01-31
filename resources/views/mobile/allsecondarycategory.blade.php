@extends('mobile.master-website')
@section('content')
    <?php 
        $base_url = "https://availtrade.com//";
     ?>
        <div class="container" style="padding-top: 80px!important;padding-bottom:40px!important">
            <ul class="page-nav ps-0">
                <?php foreach ($all_secondary_category as $key => $value): ?>
                    <li><a href="{{ URL::to('m/seccategory/'.$value->secondary_category_slug.'/heightolow') }}">{{ $value->secondary_category_name }} <i class="lni lni-chevron-right"></i></a></li>
                <?php endforeach ?>
            </ul>
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
    {{ $primary_category->category_name }}
@endsection


