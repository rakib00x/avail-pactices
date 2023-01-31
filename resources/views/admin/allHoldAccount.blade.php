@extends('admin.masterAdmin')
@section('content')
@push('styles')
    <style>
        @media screen and (min-width: 992px){
            .modal-dialog {
                max-width: 1000px!important;
            }
        }
        
        .siam_active .card{
            border: 2px solid #42b72a ;
        }
        
        .selected_icon{
            position: absolute;
            padding: 38%;
            font-size: 30px;
            color: #4ebd37;
        }
        
        .siam_class{
            cursor: pointer;
        }
        
        .meta_class_image{
            cursor: pointer;
        }
        
        .remove_project_file3{
            width: 100px;
            height: 100px;
            float: left;
            margin: 5px;
        } 

    </style>
@endpush
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="card-title">Hold Account List</h4>
                            <div class="card p-2">

                                <div class="card-content" >
                                                                    <!-- datatable start -->
                                    <div class="table-responsive">
                                        <table id="users-list-datatable" class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>name</th>
                                                    <th>phone</th>
                                                    <th>email</th>
                                                    <th>Store Name</th>
                                                    <th>Num. of Products</th>
                                                    <th>verified</th>
                                                    <th>status</th>
                                                    <th>Option</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($result as $value) { ?>
                                                    <tr>
                                                        <td><?php echo $value->id ; ?></td>
                                                        <td><?php echo $value->first_name." ".$value->last_name; ?></td>
                                                        <td><?php echo $value->mobile ; ?></td>
                                                        <td><?php echo $value->email; ?></td>
                                                        <td>
                                                            @if($value->type == 2)
                                                                <a href="{{ URL::to('store/'.$value->storeName) }}" target="_blank"> <?php echo $value->storeName; ?></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <?php
                                                                $total_product = DB::table('tbl_product')
                                                                    ->where('supplier_id', $value->id)
                                                                    ->count() ;
                                                                echo $total_product ;
                                                            ?>
                                                        </td>
                                                        <td>{{ $value->package_name }}</td>
                                                        <td>  
                                                            <div class="custom-control custom-switch custom-control-inline mb-1">
                                                                <input type="checkbox" class="custom-control-input changeSellerStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getCurrencyid="{{$value->id}}" id="customSwitch{{$value->id}}">
                                                                <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($value->type == 2)
                                                            <div class="btn-group mb-1">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-primary btn-sm dropdown-toggle mr-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Action
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                                        <a class="dropdown-item" href="{{URL::to('/sellerProfile/'.$value->id)}}">Profile</a>

                                                                        <a class="dropdown-item" target="_new" href="{{URL::to('loginWithSeller/'.$value->id)}}">Login as this seller</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                <?php } ?>


                                            </tbody>
                                        </table>
                                    </div>
                                        <!-- BEGIN: Page JS-->

                                </div>
                            </div>
                        </div>
                    </div>
                </section>



            </div>
        </div>
    </div>

@endsection

@section('js')
<!-- Alert Assets -->
    <script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
    <script>
    $('body').on('change', '.changeSellerStatus', function (e) {
        e.preventDefault();

        var seller_id = $(this).attr('getCurrencyid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changeHOldAccountToActive') }}",
            'type':'post',
            'dataType':'text',
            data:{seller_id:seller_id},
            success:function(data)
            {
                toastr.success('Thanks !! status has activated', { positionClass: 'toast-bottom-full-width', });
                setTimeout(function(){
                    location.reload() ;
                }, 3000);

                return false;
            }
        });

    });
    
    </script>

@endsection