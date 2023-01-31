<div class="card-body card-dashboard">
    <div class="table-responsive">
        <table class="table zero-configuration">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th width="25%">Name</th>
                    <th width="25%">Mobile</th>
                    <th width="25%">Thana</th>
                    <th width="25%">Shop List</th>
                    <th width="25%">Confirm Paymeent</th>
                    <th width="25%">Pending Paymeent</th>
                    <th width="25%">Total Balance</th>
                    <th width="30%">Action</th>
                </tr>
            </thead>

            <tbody >
                @foreach($result as $value)
                <tr>
                @php
                     $tha = DB::table('thanas')->where('id', $value->thana)->first();
                     $cal = $value->shop_list*$value->rate;
                     $view = DB::table('express')->where('marketing_id', $value->id)->count();
                     
                     @endphp
                    <td width="5%">{{$value->id}}</td>
                    <td width="10%">{{ $value->name }}</td>
                    <td width="10%">{{ $value->mobile }}</td>
                  {{--  <td width="10%">{{$tha->name}}</td> --}}
                     <td width="10%">{{ $view }}</td>
                    <td width="10%">{{ $value->confirm_amount }}</td>
                    <td width="10%"><?php echo $cal-$value->confirm_amount; ?></td>
                    <td width="10%">{{ $value->shop_list*$value->rate }}</td>
                    <td width="25%">
                        <div class="invoice-action">
                            <a onclick="edit('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editModal" href="#" class="invoice-action-edit cursor-pointer">
                                <i style="font-size:25px;" class="bx bx-edit"></i>
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