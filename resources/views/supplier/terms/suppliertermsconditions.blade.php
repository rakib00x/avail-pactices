@extends('supplier.masterSupplier')
@section('title')
Supplier Accounts Settings
@endsection
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
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-12 mb-2 mt-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h5 class="content-header-title float-left pr-1 mb-0">Conditions</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Conditions</a>
                                </li>
                                <li class="breadcrumb-item active"> All Conditions
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="basic-input">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Conditions</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {!! Form::open(['id' =>'insertSupplierTermsconditions','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="row">

                                            <div class="col-md-12 form-group mt-2">
                                                <label>Subject <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" name="conditions_name" required="">
                                            </div>

                                            <div class="col-md-12 form-group">
                                                <label>Terms Details <span style="color:red;">*</span></label>
                                           <fieldset class="form-group">
                                        <textarea class="form-control" name="conditions_details" rows="10" placeholder="Product Description" id="product_details_users" required=""></textarea>
                                       </fieldset>      
                                                
                                                <!--<textarea class="form-control summernote" name="conditions_details" required="" style="height:500px"></textarea>-->
                                            </div>

                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Terms & Conditions List</h4>
                            </div>

                            <?php if(Session::get('success') != null) { ?>
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                                <strong><?php echo Session::get('success') ;  ?></strong>
                                <?php Session::put('success',null) ;  ?>
                            </div>
                            <?php } ?>

                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sl</th>
                                                <th>Date</th>
                                                <th>Subject</th>
                                                <th>Details</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($result as $key => $value): ?>
                                                <tr>
                                                    <td>{{ $key+1 }}</td>
                                                    <td>{{ $value->created_at }}</td>
                                                    <td>{{ $value->conditions_name }}</td>
                                                    <td>{{ substr(strip_tags($value->conditions_details), 0, 50) }}</td>
                                                    <td>
                                                        <div class="custom-control custom-switch custom-control-inline mb-1">
                                                            <input type="checkbox" class="custom-control-input changesupplierconditions" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getCurrencyid="{{$value->id}}" id="supplierSwitch{{$value->id}}">
                                                            <label class="custom-control-label mr-1" for="supplierSwitch{{$value->id}}"></label>
                                                        </div>
                                                    </td>
                                                     <td>
                                                         <a href="#" class="btn btn-success btn-sm" onclick="editConditions(<?php echo $value->id; ?>)">Edit</a>
                                                         <a href="{{ URL::to('deleteTermsAndCoditions/'.$value->id) }}" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete it ??')" >Delete</a>
                                                     </td>
                                                </tr>
                                            <?php endforeach ?>
                                            
                                        </tbody>
                                    </table>
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

<!-- Modal -->
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel1">Update Slider </h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">

                    {!! Form::open(['id' =>'updateSupplierConditions','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                    <div class="form-body" id="conditionEditForm">

                    </div>
                    {!! Form::close() !!}

                    <!-- Nav Filled Ends -->
                </div>

            </div>
        </div>
    </div>

@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('//cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.3/tinymce.min.js') }}" integrity="sha512-DB4Mu+YChAdaLiuKCybPULuNSoFBZ2flD9vURt7PgU/7pUDnwgZEO+M89GjBLvK9v/NaixpswQtQRPSMRQwYIA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      tinymce.init({
        selector: '#product_details_users',
        plugins: 'code lists',
          mobile: {
            menubar: true,
            plugins: 'autosave lists autolink',
            toolbar: ' styleselect | bold italic underline alignleft aligncenter alignright alignjustify bullist numlist | link'
          }
      });
    </script>
<script>
    $("#insertSupplierTermsconditions").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('insertSupplierTermsconditions');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/insertSupplierTermsconditions') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data) {
                    toastr.success('Conditions Add Successfully. Please Wait For Respone', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }
            }
        })
    });

    $(function(){
            $('body').on('click', '.changesupplierconditions', function (e) {
                e.preventDefault();

                var terms_id = $(this).attr('getCurrencyid');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    'url':"{{ url('/changesupplierconditions') }}",
                    'type':'post',
                    'dataType':'text',
                    data:{terms_id:terms_id},
                    success:function(data)
                    {
                        toastr.success('Thanks !! Status Change Successfully', { positionClass: 'toast-bottom-full-width', });

                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                        return false ;
                    }
                });

            })
        });

    function editConditions(condition_id) {


        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/editSupplierConditions') }}",
            'type':'post',
            'dataType':'text',
            data:{condition_id:condition_id},
            success:function(data)
            {
                $("#editModal").modal('show') ;
                $("#conditionEditForm").empty().html(data) ;
            }
        });
    }

    $("#updateSupplierConditions").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('updateSupplierConditions');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updateSupplierTermsconditions') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data) {
                    toastr.success('Conditions Update Successfully. ', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }
            }
        })
    });



</script>
@endsection
