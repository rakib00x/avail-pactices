<div class="card-body card-dashboard">
    <div class="table-responsive">
        <table class="table zero-configuration">
            <thead>
                <tr>
                    <th width="5%">SN</th>
                    <th width="10%">Question</th>
                    <th width="15%">Answer</th>
                    <th width="15%">Action</th>
                </tr>
            </thead>

            <tbody >
                <?php $i=1;?>
                @foreach($faq as $value)
                <tr>
                    <td width="5%">{{$i++}}</td>
                    <td width="10%">{{ $value->qun }}</td>
                    <td width="10%">{{ $value->ans }}</td>
                    
                    <td width="15%">
                        <div class="invoice-action">
                            <a onclick="edit('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editModal" href="#" class="invoice-action-edit cursor-pointer">
                                <i style="font-size:25px;" class="bx bx-edit"></i>
                            </a>
                            <a onclick="deleteFaq('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
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