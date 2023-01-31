<div class="card-body card-dashboard">
    <div class="table-responsive">
        <table class="table zero-configuration">
            <thead>
                <tr>
                    <th width="5%">SN</th>
                    <th width="15%">Frist Name</th>
                    <th width="15%">Last Namer</th>
                    <th width="10%">Email</th>
                    <th width="15%">Mobile</th>
                    <th width="15%">Store Name</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>

            <tbody >
                <?php $i=1;?>
                @foreach($result as $value)
                <tr>
                    <td width="5%">{{$i++}}</td>
                    <td width="15%">{{ $value->first_name }}</td>
                    <td width="15%">{{ $value->last_name }}</td>
                    <td width="10%">{{ $value->email }}</td>
                    <td width="15%">{{ $value->mobile }}</td>
                    <td width="15%">
                       {{ $value->storeName }}
                    </td>
                    {{--<td width="5%">
                        <div class="custom-control custom-switch custom-control-inline mb-1">
                            <input type="checkbox" class="custom-control-input changePopupAdsStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getAdsId="{{$value->id}}" id="customSwitch{{$value->id}}">
                            <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                        </div>
                    </td>--}}
                    <td width="15%">
                        <div class="invoice-action">
                            <a onclick="edit('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editModal" href="#" class="invoice-action-edit cursor-pointer">
                                <i style="font-size:25px;" class="bx bx-show-alt"></i>
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