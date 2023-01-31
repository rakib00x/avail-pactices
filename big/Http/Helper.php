<?php

    function supplier_base_price($product_id)
    {
        $product_info = DB::table('tbl_product')->where('id', $product_id)->first() ;
        $product_price_info2 = DB::table('tbl_product_price')
            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
            ->where('tbl_product_price.product_id', $product_id)
            ->orderBy('tbl_product_price.product_price', 'asc')
            ->first() ;
            
        $product_price_info3 = DB::table('tbl_product_price')
            ->leftJoin('tbl_currency_status', 'tbl_product_price.currency_id', '=','tbl_currency_status.id')
            ->join('tbl_product', 'tbl_product_price.product_id', '=', 'tbl_product.id')
            ->join('tbl_unit_price', 'tbl_product.unit', '=', 'tbl_unit_price.id')
            ->select('tbl_product_price.*', 'tbl_currency_status.code', 'tbl_product.product_name', 'tbl_product.products_image', 'tbl_product.unit', 'tbl_unit_price.unit_name', 'tbl_product.slug','tbl_currency_status.rate as currency_rate')
            ->where('tbl_product_price.product_id', $product_id)
            ->orderBy('tbl_product_price.product_price', 'desc')
            ->first() ;
            
    	if($product_price_info2->product_price > 0){
            if(Session::has('requestedCurrency')){
                $main_currancy_status2 = DB::table('tbl_currency_status')->where('id', Session::get('requestedCurrency'))->first() ;
                $product_price_convert2 = $product_price_info2->product_price / $product_price_info2->currency_rate;
                $now_product_price_is2 = $product_price_convert2 * $main_currancy_status2->rate ;
                $currency_code2         = $main_currancy_status2->symbol;
                
                $product_price_convert_max = $product_price_info3->product_price / $product_price_info2->currency_rate;
                $now_product_price_is_max = $product_price_convert_max * $main_currancy_status2->rate ;

            }else{
                
                $currency_code2             = $product_price_info2->code;
                $now_product_price_is2      = $product_price_info2->product_price;
                $now_product_price_is_max   = $product_price_info3->product_price;
            }

        }
        
        if($product_price_info2->price_status == 3){
            return "Negotiate";
        }else{
            if($now_product_price_is2 == $now_product_price_is_max){
                return $currency_code2." ".$$now_product_price_is2 ;
            }else{
                return $currency_code2." ".$now_product_price_is2." - ".$now_product_price_is_max ;
            }
        }
    }
    
    
    function imageresize($image){
        $image_name_with_path = 'public/images/'.$image ;
        \Image::make($image_name_with_path)->fit(1000)->save($image_name_with_path) ;
    }
    
?>