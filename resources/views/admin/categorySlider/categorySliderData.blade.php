<div class="card-body card-dashboard">
    <div class="table-responsive">
        <table class="table zero-configuration">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Slider Title</th>
                    <th>Slider Link</th>
                    <th>Slider Image</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php $i=1;?>
            @foreach($result as $value)
            <tr>
                <td>{{$i++}}</td>
                <td>{{$value->slider_title}}</td>
                <td>{{$value->slider_link}}</td>
                <td>
                    <img src="{{ URL::to('public/images/categorySlider/'.$value->slider_image)}}" alt="" style="width: 75px;height: 33px;">
                </td>
                <td>
                    <div class="custom-control custom-switch custom-control-inline mb-1">
                        <input type="checkbox" class="custom-control-input changeCategorySliderStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getSliderid="{{$value->id}}" id="customSwitch{{$value->id}}">
                        <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                    </div>
                </td>
                <td>
                    <div class="invoice-action">
                        <a onclick="edit('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editModal" href="#" class="invoice-action-edit cursor-pointer">
                            <i style="font-size:25px;" class="bx bx-edit"></i>
                        </a>
                        <a onclick="deleteCategorySlider('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
                            <i style="font-size:25px;" class="bx bx-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
            <tbody >

            </tbody>
        </table>
    </div>
</div>


<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/datatables/datatable.js')}}"></script>