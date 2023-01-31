<div class="row">
    <div class="col-md-8">
        <?php echo "Branch: <strong>".$bank_info->bank_branch_name .'</strong></br> Account Name:  <strong>'.$bank_info->bank_account_name.'</strong></br> Account Number :<strong>'.$bank_info->bank_account_number.'</strong></br> Payment Amount: <strong>'.'<span style="font-family:SolaimanLipi">'.$main_currancy_status->symbol.'</span> '.$final_product_price.'</strong></br>'; ?>
    </div>
    
    <div class="col-md-4">
        <img src="{{ URL::to('public/images/bankLogo/'.$bank_info->bank_logo) }}" width="100%" height="80" >
    </div>
</div>