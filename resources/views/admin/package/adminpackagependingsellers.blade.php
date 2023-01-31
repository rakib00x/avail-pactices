@extends('admin.masterAdmin')
@section('title','All Seller')
@section('content')
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- users list start -->
            <section class="users-list-wrapper">

                <div class="users-list-table">
                    <div class="card">
                        <div class="card-title">Pending Seller List</div>
                        <div class="card-content">
                            <div class="card-body" id="table_data">
        
                             <!-- datatable start -->
                                <div class="table-responsive">
                                    <table id="users-list-datatable" class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>name</th>
                                                <th>phone</th>
                                                <th>email</th>
                                                <th>Package</th>
                                                <th>Package Price</th>
                                                <th>status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $value) { ?>
                                                <tr>
                                                    <td><?php echo $value->id ; ?></td>
                                                    <td><?php echo $value->first_name." ".$value->last_name; ?></td>
                                                    <td><?php echo $value->mobile ; ?></td>
                                                    <td><?php echo $value->email; ?></td>
                                                    <td><?php echo $value->package_name; ?></td>
                                                    <td><?php echo $value->package_price; ?></td>
                                                    <td>  
                                                        <button class="btn btn-primary btn-sm" onclick="showpackagedetails({{ $value->id }})">View</button>
                                                    </td>
                                                </tr>
                                            <?php } ?>


                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- users list ends -->
            
            <!-- Modal -->
            <div class="modal fade" id="package_inovice_details" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel1">Package Invoice Deails </h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                        </div>
                        <div class="modal-body" id="invoice_details">


                        </div>
                        
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</div>
<!-- END: Content-->

@endsection
@section('js')
    <script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
    
    <script>
        function showpackagedetails(customer_id)
        {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/showpackagedetails') }}",
                'type':'post',
                'dataType':'text',
                data:{customer_id:customer_id},
                success:function(data)
                {
                    $("#package_inovice_details").modal('show')
                    $("#invoice_details").empty().html(data);
                }
            });
            
        }
    </script>
@endsection