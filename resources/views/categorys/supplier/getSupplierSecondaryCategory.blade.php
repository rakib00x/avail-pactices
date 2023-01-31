

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
            <h4 class="float-left card-title">Secondary Category List</h4>
                    <a role="button" class="float-right btn btn-primary btn-md" href="" id="addSecondaryCategory">+ Add Secondary Category</a>

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
                                        <th>Status</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                
                                <tbody>
                                    
                                    <?php $i=1;?>
                                    @foreach($secondary_all as $scvalue)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{ $scvalue->category_name }}</td>
                                            <td>{{ $scvalue->secondary_category_name }}</td>
                                            <td>
                                                <div class="custom-control custom-switch custom-control-inline mb-1">
                                                    <input type="checkbox" class="custom-control-input changeSupplierSecodnaryCategoryStatus" <?php if($scvalue->status == 1){ echo 'checked'; }else{ echo ''; } ?> getSecodnaryCategoryId="{{$scvalue->id}}" id="supplierSwitch2{{$scvalue->id}}">
                                                    <label class="custom-control-label mr-1" for="supplierSwitch2{{$scvalue->id}}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="invoice-action">
                                                    <a onclick="secondarycategoryedit('{{$scvalue->id}}')" data-toggle="modal" id="secondarycategoryedit" data-target="#editSecondaryCategory" href="" class="invoice-action-edit cursor-pointer">
                                                        <i style="font-size:25px;" class="bx bx-edit"></i>
                                                    </a>
                                                    <a onclick="deleteSecondaryCategory('{{$scvalue->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
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
