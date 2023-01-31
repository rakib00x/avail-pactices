
<div class="row">
    <div class="col-12">

        <div class="table-responsive">
            <table class="table table-hover">
                <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td><?php echo $review_info->full_name ; ?></td>
                </tr>

                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><?php echo $review_info->email ; ?></td>
                </tr>

                <tr>
                    <td>Supplier </td>
                    <td>:</td>
                    <td><?php echo $review_info->first_name." ".$review_info->last_name." Store Name: ". $review_info->storeName ; ?></td>
                </tr>

                <tr>
                    <td>Store Name </td>
                    <td>:</td>
                    <td><?php echo $review_info->storeName ; ?></td>
                </tr>

                <tr>
                    <td>Product</td>
                    <td>:</td>
                    <td><?php echo $review_info->product_name ; ?></td>
                </tr>

                <tr>
                    <td>Review Star</td>
                    <td>:</td>
                    <td><?php echo $review_info->review_star." Star" ; ?></td>
                </tr>

                <tr>
                    <td>Details</td>
                    <td>:</td>
                    <td><?php echo $review_info->review_details ; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>





