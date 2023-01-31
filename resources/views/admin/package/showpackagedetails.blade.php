<div>
    <style>
        table tr td{
            padding: 10px 0px;
            color:white;
        }
    </style>
    <h4>
        {{ $supplier_info->first_name." ".$supplier_info->last_name }}
    </h4>
    <table>
        <tr>
            <td>
                Package 
            </td>
            <td>
                :
            </td>
            
            <td>{{ $supplier_info->package_name }}</td>
        </tr>
        
        <tr>
            <td>Duration </td>
            <td>:</td>
            <td>{{ $pckage_info->package_duration }}/ Month</td>
        </tr>
        
        <tr>
            <td>Price </td>
            <td>:</td>
            <td>{{ $pckage_info->package_price }}</td>
        </tr>
        
        <tr>
            <td>Dicount </td>
            <td>:</td>
            <td>{{ $pckage_info->discount_percentage }}</td>
        </tr>
        
        <tr>
            <td>Final Amount </td>
            <td>:</td>
            <td>{{ $pckage_info->package_price - $pckage_info->discount_percentage }}</td>
        </tr>
        
        <tr>
            <td>Bank name </td>
            <td>:</td>
            <td>
                <?php
                    if($price_history->method_type == 1){
                        $bank_info = DB::table('tbl_bank')->where('id', $price_history->bank_id)->first() ;
                        echo $bank_info->bank_name;
                    }else{
                        $bank_info = DB::table('tbl_mobile_bank')->where('id', $price_history->bank_id)->first() ;
                        echo $bank_info->bank_name;
                    }
                ?>
            </td>
        </tr>
        
        <tr>
            <td>Payment Details</td>
        </tr>
        
        <tr>
            <td>Branch Name</td>
            <td>:</td>
            <td>
                {{ $price_history->branch_name }}
            </td>
        </tr>
        
        <tr>
            <td>Account Name</td>
            <td>:</td>
            <td>{{ $price_history->account_name }}</td>
        </tr>
        
        <tr>
            <td>Account Number</td>
            <td>:</td>
            <td>{{ $price_history->account_number }}</td>
        </tr>
        
        <tr>
            <td>Transaction Number</td>
            <td>:</td>
            <td>{{ $price_history->transaction_id }}</td>
        </tr>
        
        <tr>
            <td>Receipt Copy</td>
            <td>:</td>
            <td>
                <img src="{{ URL::to('public/images/'.$price_history->receipt_copy) }}">
            </td>
        </tr>
        
        <tr>
            <td>Actions</td>
            <td>:</td>
            <td>
                <a href="{{ URL::to('changesupplierpackagestatus/'.$supplier_info->id.'/1') }}" class="btn btn-primary btn-sm" onclick="return confirm('Are you sure to approve it')">Approve</a>
                <a href="{{ URL::to('changesupplierpackagestatus/'.$supplier_info->id.'/2') }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to Reject it')">Reject</a>
            </td>
        </tr>
        
        
        
    </table>
</div>