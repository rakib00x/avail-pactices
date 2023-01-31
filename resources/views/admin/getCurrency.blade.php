<div class="card-body card-dashboard">
    <div class="table-responsive">
        <table class="table zero-configuration">
            <thead>
            <tr>
                <th>SN</th>
                <th width="10%">Currency name</th>
                <th width="20%">Currency symbol</th>
                <th width="20%">Currency code</th>
                <th width="20%">Exchange Rate(1 USD = ?)</th>
                <th width="15%">Status</th>
                <th width="15%">Action</th>

            </tr>
            </thead>
            <?php $i=1;?>
            <tbody>
            @foreach($currency as $currency)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$currency->name}}</td>
                    <td>{{$currency->symbol}}</td>
                    <td>{{$currency->code}}</td>
                    <td>{{$currency->rate}}</td>
                    <td>
                        <div class="custom-control custom-switch custom-control-inline mb-1">
                            <input type="checkbox" class="custom-control-input changeCurrencyStatus" <?php if($currency->status == 1){ echo 'checked'; }else{ echo ''; } ?> getCurrencyid="{{$currency->id}}" id="customSwitch{{$currency->id}}">
                            <label class="custom-control-label mr-1" for="customSwitch{{$currency->id}}"></label>
                        </div>
                    </td>
                    <td>
                        <div class="invoice-action">
                            <a onclick="edit('{{$currency->id}}')" data-toggle="modal" id="edit" data-target="#update" href="" class="invoice-action-edit cursor-pointer">
                                <i style="font-size:25px;" class="bx bx-edit"></i>
                            </a>
                            <a onclick="deleteCurrency('{{$currency->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
                                <i style="font-size:25px;" class="bx bx-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <!-- BEGIN: Page JS-->
    <script src="{{ URL::to('public/app-assets/js/scripts/pages/dashboard-analytics.js') }}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.min.js')}}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>

    <script src="{{ URL::to('public/app-assets/vendors/js/tables/datatable/responsive.bootstrap.min.js')}}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/pages/app-invoice.js')}}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/datatables/datatable.js')}}"></script>
</div>