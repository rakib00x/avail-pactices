<div class="card-body card-dashboard">
    <div class="table-responsive">
        <table class="table zero-configuration">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Ads Image</th>
                    <th>Ads Title</th>
                    <th>Ads Link</th>
                    <th>Image Keyword</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody >
                <?php $i=1;?>
                @foreach($result as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>
                        <img src="{{ URL::to('public/images/categoryAds/'.$value->ads_image)}}" style="width: 75px;height: 33px;">
                    </td>
                    <td>{{$value->ads_title}}</td>
                    <td><a target="_blank" href="{{$value->ads_link}}"> {{$value->ads_link}} </a>  </td>
                    <td>{{$value->image_keyword}}</td>

                    <td>
                        <div class="custom-control custom-switch custom-control-inline mb-1">
                            <input type="checkbox" class="custom-control-input changeAdminAdsStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getAdminAdsid="{{$value->id}}" id="customSwitch{{$value->id}}">
                            <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                        </div>
                    </td>
                    <td>
                        <div class="invoice-action">
                            <a onclick="edit('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editModal" href="#" class="invoice-action-edit cursor-pointer">
                                <i style="font-size:25px;" class="bx bx-edit"></i>
                            </a>
                            <a onclick="deleteAds('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
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