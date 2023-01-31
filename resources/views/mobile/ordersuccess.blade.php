@extends('mobile.master-website')
@section('content')
    <?php 
        $base_url = "https://availtrade.com/";
    ?>
    <!-- Order/Payment Success-->
    <div class="order-success-wrapper">
      <div class="content"><i class="lni lni-checkmark-circle"></i>
        <h5>Order Done</h5>
        <p>We will notify you of all the details via email. Thank you!</p><a class="btn btn-warning mt-3" href="{{ URL::to('/') }}">Buy Again</a>
      </div>
    </div>
@endsection

@section('page_headline')
    Order Success
@endsection
