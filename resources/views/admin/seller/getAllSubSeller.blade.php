                                <!-- datatable start -->
                                <div class="table-responsive">
                                    <table id="users-list-datatable" class="table zero-configuration">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>name</th>
                                                <th>phone</th>
                                                <th>Create Date</th>
                                                <th>Nam Of Product</th>
                                                <th>Action </th>
                                                 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $i=1;@endphp
                                            <?php foreach ($result as $value) { ?>
                                                <tr>
                                                    
                                                    <td><?php echo $i++ ; ?></td>
                                                    <td><?php echo $value->first_name." ".$value->last_name; ?></td>
                                                    <td><?php echo $value->mobile ; ?></td>
                                                    <td>{{$value->created_at}}  </td>
                                                  
                                                  <td>
                                                      <?php
                                                            $total_product = DB::table('tbl_product')
                                                                ->where('supplier_id', $value->id)
                                                                ->count() ;
                                                            echo $total_product ;
                                                        ?>
                                                       
                                                    </td>
                                                    
                                                    <td>
                                                        <div class="btn-group mb-1">
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary btn-sm dropdown-toggle mr-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Action
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item" href="{{URL::to('/SubsellerProfile/'.$value->id)}}">Profile</a>
                                                                    <a class="dropdown-item" target="_new" href="{{URL::to('loginWithSubSeller/'.$value->id)}}">Login as this seller</a>
                                                                    <a class="dropdown-item" onclick="adminSupplierEdit(event, {{ $value->id }})" href="#">edit</a>
                                                                    @if($value->status != 3)
                                                                    <a onclick="suspendSeller(event, {{ $value->id }})"  class="dropdown-item" href="#">Suspend</a>
                                                                    @endif
                                                                    <a  onclick="deleteSupplierInfo(event, {{ $value->id }})" class="dropdown-item" href="#">delete</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>


                                        </tbody>
                                    </table>
                                </div>
                                    <!-- BEGIN: Page JS-->

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/datatables/datatable.js')}}"></script>

