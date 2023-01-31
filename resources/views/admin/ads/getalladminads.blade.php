<div class="card-body card-dashboard">
    <div class="table-responsive">
        <table class="table zero-configuration">
            <thead>
                <tr>
                    <th width="5%">SN</th>
                    <th width="10%">Title</th>
                    <th width="10%">Link</th>
                    <th width="10%">Start Date</th>
                    <th width="10%">End Date</th>
                    <th width="15%">Ads Image</th>
                    <th width="5%">Status</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>

            <tbody >
                <?php $i=1;?>
                @foreach($result as $value)
                <tr>
                    <td width="5%">{{$i++}}</td>
                    <td width="10%">{{ $value->title }}</td>
                    <td width="10%">{{ $value->ads_link }}</td>
                    <td width="10%">{{ $value->start_date }}</td>
                    <td width="10%">{{ $value->end_date }}</td>
                    <td width="15%">
                        <img src="{{ URL::to('public/images/adminssAds/'.$value->ads_image)}}" alt="" style="width: 75px;height: 33px;">
                    </td>
                    <td width="5%">
                        <div class="custom-control custom-switch custom-control-inline mb-1">
                            <input type="checkbox" class="custom-control-input changeAdminAdsStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getAds="{{$value->id}}" id="customSwitch{{$value->id}}">
                            <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                        </div>
                    </td>
                    <td width="15%">
                        <div class="invoice-action">
                            <a onclick="editAdmin('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editModal" href="#" class="invoice-action-edit cursor-pointer">
                                <i style="font-size:25px;" class="bx bx-edit"></i>
                            </a>
                            <a onclick="deleteAdminAds('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
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