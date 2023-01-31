<div class="card-body card-dashboard">
    <div class="table-responsive">
        <table class="table zero-configuration">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Title</th>
                    <th>Discription</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody >
                <?php $i=1;?>
                @foreach($result as $value)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value->about_title}}</td>
                    <td>{{Str::limit( $value->about_details, 100 )}}</td>
                    <td>
                        <img src="{{ URL::to('public/images/'.$value->image) }}" alt="" style="width:50px; height:50px;">
                    </td>
                    <td>
                        <div class="invoice-action">
                            <a onclick="deleteAboutPageInfo('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
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