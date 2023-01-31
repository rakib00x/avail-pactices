<div class="row">
    <div class="col-md-8">
        <?php echo "Account Number: <strong>".$bank_info->payment_number .'</strong></br> Counter Number: <strong>'.$bank_info->counter_number.'</strong></br> Payment Amount: <strong>'.'<span style="font-family:SolaimanLipi">'.$main_currancy_status->symbol.'</span> '.$final_product_price.'</strong></br>'; ?>
    </div>
    
    <div class="col-md-4">
        <img src="{{ URL::to('public/images/mobileBank/'.$bank_info->bank_logo) }}" width="100%" height="80" >
    </div>
</div>