 <?php foreach ($result as $value): ?>
<div class="cart-item">
    <p class="cart-supplier-title">{{ $value->storeName }}</p>
    <?php 
        $all_product = DB::table('cart')
            ->join('tbl_product', 'cart.product_id', '=', 'tbl_product.id')
            ->select('cart.*', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.slug')
            ->where('cart.supplier_id', $value->supplier_id)
            ->where('cart.customer_id', $value->customer_id)
            ->get() ;
        foreach($all_product as $product):
     ?>
    <article class="media">
        <figure class="media-left">

            <p class="image is-64x64">
                <?php $first_image_explode = explode("#", $product->products_image); ?>
                <img src="{{ URL::to('public/images/'.$first_image_explode[0]) }}">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>{{ $product->product_name }}</p>
            </div>
            <nav class="level is-mobile">

                <div class="level-left">
                    <p><?php 
                    $main_currancy_status 	= DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;

                    if($product->sale_price > 0){
                        $cart_single_price = cartBasePrice($product->id);
                        $total_amount = $cart_single_price ;
                        echo $main_currancy_status->symbol." ".number_format($total_amount,2) ;
                    }else{
                        echo ucwords($product->sale_price);
                    }
                ?> x {{ $product->quantity }}</p>
                </div>


            </nav>
        </div>
    </article>
    <?php endforeach ?>
</div>
<?php endforeach ?>