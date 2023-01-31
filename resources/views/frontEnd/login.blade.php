@extends('frontEnd.master')
@section('title','Login')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ URL::to('public/frontEnd/assets/css/login.css') }}">

<style>
    
.login-child-theree {
  position: absolute;
  background: #fff;
  width: 580px;
  height: 400px;
  top: 42px;
  left: 4%;
  border: solid 1px #ddd;
  box-shadow: 0 0 10px #ddd;
  background: #fff;
}

div.gallery {
  margin: 5px 5px 5px 0;
  border: 1px solid #ccc;
  float: left;
  width: 100px;
}

div.gallery:hover {
  border: 1px solid #777;
}

div.gallery img {
  width: 100%;
  height: auto;
}

div.desc {
  padding: 2px;
  text-align: center;
}
</style>
@endsection
@section('content')
<div class="wrapper" style="background: #f4f4f4;">


    <div class="login-container">
        <div class="login-parent">
            <div class="login-child-one">
                <?php 
                    $default_info = DB::table('tbl_default_setting')->first() ;
                    if($default_info):
                ?>
                    <img src="{{ URL::to('public/images/defult/'.$default_info->login_background) }}" style="width: 100%;height: 600px;" alt="availtrade login">
                <?php else: ?>
                    <img src="{{ URL::to('public/images/login.jpg') }}" style="width: 100%;height: 600px;" alt="availtrade Login">
                <?php endif; ?>

            </div>
            <div class="login-child-two" style="height:457px!important">
                

                <div class="login-box">
                    @if (!empty(Session::get('login_faild')))
                    <article class="message is-danger">
                      <div class="message-header">
                        <p><?php
                        $message2 = Session::get('login_faild');
                        if($message2){
                                echo '<strong>'.$message2.'</strong>';
                                Session::put('login_faild',null);
                            }
                        ?></p>
                      </div>
                    </article>
                    @endif

                    {!! Form::open(['url' =>'buyerSignIn','method' => 'post','role' => 'form', 'files' => true]) !!}
                        <table width="100%">
                            <tr>
                                <td>
                                    <label style="font-size:24px;">Account: </label><br>
                                    <input class="login-text" type="text" name="email" placeholder="Email address or Mobile Number " value="<?php if(!empty($_COOKIE['cookie_username'])){ echo $_COOKIE['cookie_username']; }else{ echo ""; } ?>" required="">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label style="font-size:24px;">Password:</label><span style="float: right;font-size:24px;"><a href="{{ URL::to('forgot-password') }}">forget password ?</a></span><br>
                                    <input class="login-text" type="password" name="password" id="password" placeholder="Password" value="<?php if(!empty($_COOKIE['cookie_password'])){ echo $_COOKIE['cookie_password']; }else{ echo ""; } ?>" required="">
                                </td>
                                <td style="padding-top:13px !important;"><span id="togglePasswordshow" class="fa fa-eye fa-eye-slash" style="margin-left: -33px;margin-top: 36px;"></span></td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="checkbox" name="remember" checked> <label style="font-size:24px;">Stay signed in</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input class="signin" type="submit" value="Sign In">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label style="font-size:20px;">Sign InMobile Number or email </label><span style="float: right;font-size:24px;"><a href="{{ URL::to('registration') }}">Join Free</a></span><br>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="prev" value="{!! URL::previous() !!}">
                    {!! Form::close() !!}
                    <hr>
                    <div class="social-container">
                        <div class="social-left">
                            <p style="font-size:24px;">Sign in with: </p>
                        </div>
                        <div class="social-right" style="left: 145px;margin-top: 6px!important;">
                            <p><a href="{{URL::to('loginwithfacebook')}}"><img src="{{ URL::to('public/frontEnd/footer/facebook.png') }}" width="32" height="32" alt=""></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{URL::to('loginwithgmail')}}"><img src="{{ URL::to('public/frontEnd/footer/google.png') }}" width="32" height="32" alt=""></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="{{URL::to('loginwithlinkedin')}}"><img src="{{ URL::to('public/frontEnd/footer/linkedin.png') }}" width="32" height="32" alt=""></a>&nbsp;&nbsp;&nbsp;&nbsp;
                            <!--<a href="#"><img src="{{ URL::to('public/frontEnd/footer/twitter.png') }}" width="32" height="32" alt=""></a>-->
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <div class="login-child-theree" style="height:457px!important">
             @foreach($product as $products)
            <div class="gallery">
                <?php $img = explode("#", $products->products_image); ?>
              <a  href="{{ URL::to('product/'.$products->slug)}}">
                <img src="{{ URL::to('public/images/'.$img[0]) }}" alt="{{ Str::limit($products->product_name, 20) }}" width="300" height="300">
              </a>
              <div class="desc"><?php
				                        $product_price_info2 = DB::table('tbl_product_price')
                                            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
                                            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
                                            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
                                            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
                                            ->where('tbl_product_price.product_id', $products->id)
                                            ->orderBy('tbl_product_price.product_price', 'asc')
                                            ->first() ;
    
    									if($product_price_info2->product_price > 0){
                                            if(Session::has('requestedCurrency')){
                                                $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                                                $product_price_convert2 = $product_price_info2->product_price / $product_price_info2->currency_rate;
                                                $now_product_price_is2 = $product_price_convert2 * $main_currancy_status2->rate ;
                                                $currency_code2 = $main_currancy_status2->symbol;
                                            }else{
                                                $currency_code2 = $product_price_info2->code;
                                                $now_product_price_is2 = $product_price_info2->product_price;
                                            }
                                            
                                            echo $currency_code2." ".number_format($now_product_price_is2, 2);
                                        }else{
                                            echo ucwords($product_price_info2->negotiate_price);
                                        }
				                    ?></div>
            </div>
            @endforeach
            
                
                </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
        break;
        case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;
        case 'failed':
        toastr.error("{{ Session::get('message') }}");
        break;
    }
    @endif
</script>

<script>

    $("#togglePasswordshow").click(function(e){
        e.preventDefault() ;
    
        var type = $("[name=password]").attr('type') === 'password' ? 'text' : 'password';
        
        $("[name=password]").attr('type', type);
        this.classList.toggle('fa-eye-slash');

    })
</script>
@endsection
