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
            border: 1px solid red ;
        }

        .siam_class{
            cursor: pointer;
        }

        .selected_icon{
            position: absolute;
            padding: 38%;
            font-size: 30px;
            color: #4ebd37;
        }

    </style>
@endpush
<div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">

                <section id="basic-datatable">
                    <div class="row">


                        <div class="col-12">

                            <h4 class="card-title">Package Category List</h4>

                            <div class="card">
                                <div class="card-header">
                                    <a  class="float-right btn btn-primary btn-md" href="{{ URL::to('addAdminPackageCategory') }}" >+ Add Package Category</a>

                                </div>

                                <div class="card-content" id="body_data">
                                      <?php if(Session::get('success') != null) { ?>
                                        <div class="alert alert-info alert-dismissible" role="alert">
                                        <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                        <strong><?php echo Session::get('success') ;  ?></strong>
                                        <?php Session::put('success',null) ;  ?>
                                    </div>
                                    <?php } ?>

                                    <?php
                                        if(Session::get('failed') != null) { ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                        <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                        <strong><?php echo Session::get('failed') ; ?></strong>
                                        <?php echo Session::put('failed',null) ; ?>
                                    </div>
                                    <?php } ?>

                                    @if (count($errors) > 0)
                                        @foreach ($errors->all() as $error)      
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                            <strong>{{ $error }}</strong>
                                        </div>
                                        @endforeach
                                    @endif
                                  
                                    <div class="card-body card-dashboard">
                                        <div class="table-responsive">
                                            <table class="table zero-configuration">
                                                <thead>
                                                    <tr>
                                                        <th>SN</th>
                                                        <th>Category Name</th>
                                                        <th>Category Type</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <?php $i=1;?>
                                                    @foreach($result as $value)
                                                    <tr>
                                                        <td>{{$i++}}</td>
                                                        <td>{{$value->category_name}}</td>
                                                        <td>
                                                            @if($value->duration_type == 1)
                                                                Month
                                                            @else
                                                                Year
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="custom-control custom-switch custom-control-inline mb-1">
                                                                <input type="checkbox" class="custom-control-input changepackagecategorystatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> packagecategoryid="{{$value->id}}" id="customSwitch{{$value->id}}">
                                                                <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="invoice-action">
                                                                <a  href="{{ URL::to('editpackagecategory/'.$value->id) }}" class="invoice-action-edit cursor-pointer">
                                                                    <i style="font-size:25px;" class="bx bx-edit"></i>
                                                                </a>
                                                                <a onclick="return confirm('Are you sure to delete it ??')" class="invoice-action-view mr-1" style="cursor: pointer;" href="{{ URL::to('deleteadminpackagecategory/'.$value->id) }}">
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

    <script type="text/javascript">


        $(function(){
            $('body').on('click', '.changepackagecategorystatus', function (e) {
                e.preventDefault();

                var packagecategoryid = $(this).attr('packagecategoryid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changepackagecategorystatus') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{packagecategoryid:packagecategoryid},
                    success:function(data)
                    {
                     location.reload(true);
                    // alert('Reloading Page');
                    toastr.success('Thanks !! Status Change Successfully', { positionClass: 'toast-bottom-full-width', });
                    return false;
                // if(data == "success"){
                
                //   }else{
                //         toastr.error('Thanks !! The  status has deactivated', { positionClass: 'toast-bottom-full-width', });
                //         return false;
                //     }
                       
                      
                    }
                });

            })
        });
            

    </script>
@endsection