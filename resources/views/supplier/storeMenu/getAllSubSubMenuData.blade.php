<div class="card-body card-dashboard">
    <div class="table-responsive">
        <table class="table zero-configuration">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Menu</th>
                    <th>Sub-Menu</th>
                    <th>Sub Sub-Menu</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>
            </thead>

            <tbody >
                <?php $i=1;?>
                @foreach($result as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value->menu_name}}</td>
                    <td>{{$value->sub_menu_name}}</td>
                    <td>{{$value->sub_sub_menu_name}}</td>
                    <td>
                        <div class="custom-control custom-switch custom-control-inline mb-1">
                            <input type="checkbox" class="custom-control-input statusChange" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getSubid="{{$value->id}}" id="supplierSwitch3{{$value->id}}">
                            <label class="custom-control-label mr-1" for="supplierSwitch3{{$value->id}}"></label>
                        </div>
                    </td>

                    <td>
                        <div class="invoice-action">
                            <a onclick="editsubmenu('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editsubmenuModal" href="" class="invoice-action-edit cursor-pointer">
                                <i style="font-size:25px;" class="bx bx-edit"></i>
                            </a>
                            <a onclick="deleteSubSubMenu('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
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

<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/datatables/datatable.js')}}"></script>