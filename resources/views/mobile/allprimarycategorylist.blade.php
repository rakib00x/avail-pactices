@extends('mobile.master-website')
@section('css')
<style>
    .single-product-recommended img {
        border: 1px solid #ddd !important;
        width: 142px !important;
        height: 142px !important;
        padding: 5px;
    }
 .categ{
        padding-top:80px !important;
        padding-bottom: 80px !important;
    }
</style>
@endsection
@section('content')
    <?php 
        $base_url = "https://availtrade.com/";
     ?>

   
        </div>
        
        <div class="container categ">
            <ul class="page-nav ps-0">
                <?php foreach ($all_primary_category as $key => $value): ?>
                    <li><a href="{{ URL::to('m/all-secondary-category/'.$value->catgeory_slug) }}">{{ $value->category_name }} <i class="lni lni-chevron-right"></i></a></li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>

@endsection



@section('page_headline')
    All Primary Category
@endsection

