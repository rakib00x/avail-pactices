

<section id="basic-datatable">
    <div class="row">

        <div class="col-12">

            <h4 class="card-title">Tertiary Category List</h4>

            <div class="card">

                <div class="card-header">

                    <a role="button" class="float-right btn btn-primary btn-md" href="" id="addTetiaryCategory">+ Add Tertiary Category</a>

                </div>

                <div class="card-content">

                    
                    <div class="card-body card-dashboard">
                        <div class="table-responsive">
                            <table class="table zero-configuration">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Categroy Name</th>
                                        <th>Secondary Category Name</th>
                                        <th>Tertiary Category Name</th>
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                    <?php $i=1;?>
                                    @foreach($tertiary_all as $tcvalue)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{ $tcvalue->category_name }}</td>
                                            <td>{{ $tcvalue->secondary_category_name }}</td>
                                            <td>{{ $tcvalue->tartiary_category_name }}</td>
                                            <td>
                                                <div class="custom-control custom-switch custom-control-inline mb-1">
                                                    <input type="checkbox" class="custom-control-input changeSupplierTertiaryCategoryStatus" <?php if($tcvalue->status == 1){ echo 'checked'; }else{ echo ''; } ?> getTetiaryCategoryId="{{$tcvalue->id}}" id="supplierSwitch3{{$tcvalue->id}}">
                                                    <label class="custom-control-label mr-1" for="supplierSwitch3{{$tcvalue->id}}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="invoice-action">
                                                    <a onclick="tertiarycategoryedit('{{$tcvalue->id}}')" data-toggle="modal" id="tertiarycategoryedit" data-target="#editTertiaryCategory" href="" class="invoice-action-edit cursor-pointer">
                                                        <i style="font-size:25px;" class="bx bx-edit"></i>
                                                    </a>
                                                    <a onclick="deleteTertiaryCategory('{{$tcvalue->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
                                                        <i style="font-size:25px;" class="bx bx-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

<!-- BEGIN: Page JS-->
<script src="{{ URL::to('public/app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/pages/app-invoice.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/datatables/datatable.js')}}"></script>
