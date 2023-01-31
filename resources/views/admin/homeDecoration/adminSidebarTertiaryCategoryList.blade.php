@extends('admin.masterAdmin')
@section('title','Home Sidebar Category Decoration List')
@section('content')
<!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- users list start -->
                <section class="users-list-wrapper">
                    <div class="users-list-table">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Sidebar Tertiary Category Decoration List</h4>
                                <a href="#" class="float-right btn btn-primary btn-md" data-toggle="modal" id="add" data-target="#addModal">+ Add Sidebar Tertiary Category</a>
                            </div>
                            
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- datatable start -->
                                    <div class="table-responsive">
                                        <table id="users-list-datatable" class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Seconary Category Name</th>
                                                    <th>Tertiary category</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php $i=1;?>
                                            @foreach($result as $value)
                                                <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$value->secondary_category_name}}</td>
                                                    <td>
                                                        <table class="table zero-configuration">
                                                            <?php 
                                                                $another_result = DB::table('tbl_tartiarycategory')
                                                                    ->where('secondary_category_id', $value->id)
                                                                    ->where('sidebar_active', '>', 0)
                                                                    ->get();
                                                             ?>
                                                            <?php foreach ($another_result as $avalue): ?>
                                                                <tr>
                                                                    <td>{{ $avalue->tartiary_category_name }}</td>
                                                                    <td>
                                                                        <div class="custom-control custom-switch custom-control-inline mb-1">
                                                                            <input type="checkbox" class="custom-control-input changeHomeCatgeoryStatus" <?php if($avalue->sidebar_active == 1){ echo 'checked'; }else{ echo ''; } ?> getCategoryId="{{$avalue->id}}" id="customSwitch{{$avalue->id}}">
                                                                            <label class="custom-control-label mr-1" for="customSwitch{{$avalue->id}}"></label>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="invoice-action">
                                                                            <a onclick="deletetertiarycategorystatus('{{$avalue->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
                                                                                <i style="font-size:25px;" class="bx bx-trash"></i>
                                                                            </a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach ?>

                                                        </table>
                                                    </td>
                                                    <td><a href="{{ URL::to('adminsidebartertiarycategorydecration/'.$value->id) }}" title="" class="btn btn-primary btn-sm">Decration</a></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- datatable ends -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- users list ends -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel1">Add Tertiary Sidebar Category</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    {!! Form::open(['id' =>'insertSidebarTertiaryCategory','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Category<span style="color:red;">*</span></label>
                            </div>
                            <div class="col-md-8 form-group">
                                <select name="category_id" class="form-control unit_name" required="">
                                    <option value="">Select Category</option>
                                    @foreach($result as $catvalue)
                                        <option value="{{ $catvalue->id }}">{{ $catvalue->secondary_category_name }}</option>
                                    @endforeach
                                </select>
                            </div>                            
                            <div class="col-md-4">
                                <label>Tertiary Category<span style="color:red;">*</span></label>
                            </div>
                            <div class="col-md-8 form-group">
                                <select name="tertiary_category_id" class="form-control" id="tertiary_category_id" required="">
                                    <option value="">Select Tertiary Category</option>
                                </select>
                            </div>
                            <br>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;

        case 'success':
        toastr.info("{{ Session::get('message') }}");
        break;

        case 'warning':
        toastr.warning("{{ Session::get('message') }}");
        break;

        case 'failed':
        toastr.error("{{ Session::get('message') }}");
        break;
    }
    @endif
</script>

<script>
        $('body').on('click', '.changeHomeCatgeoryStatus', function (e) {
        e.preventDefault();

        var category_id = $(this).attr('getCategoryId');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changeAdminSidebarTertiaryCategoryStatus') }}",
            'type':'post',
            'dataType':'text',
            data:{category_id:category_id},
            success:function(data)
            {
                if(data == "success"){
                    toastr.success('Thanks !! The Category status has activated', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 500);
                    return false;
                }else if(data == "failed"){
                    toastr.warning('Thanks !! The Category status has In Active', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 500);
                    return false;
                }else{
                    toastr.warning('Thanks !! Category Limit Already Exit.', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }


            }
        });
    });

    function deletetertiarycategorystatus(id) {

    var r = confirm("Are You Sure To Delete It!");
    if (r == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/deletetertiarycategorystatus') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){
                toastr.error('Thanks !! You have Delete the Category', { positionClass: 'toast-bottom-full-width', });
                setTimeout(function(){
                    location.reload() ;
                }, 3000);
                return false;
                
            }
        });
        } else {
            toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
    }


    
    $('body').on('submit', '#insertSidebarTertiaryCategory', function (e) {
        e.preventDefault();

        var category_id          = $('[name="category_id"]').val() ;
        var tertiary_category_id = $('[name="tertiary_category_id"]').val() ;

        if (category_id == "") {
            toastr.info('Oh shit!! Please Select Category', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

        if (tertiary_category_id == "") {
            toastr.info('Oh shit!! Please Select Tertiary Category', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/insertSidebarTertiaryCategory') }}",
            'type':'post',
            'dataType':'text',
            data: {category_id: category_id, tertiary_category_id:tertiary_category_id},
            success:function(data){
                if (data == "success") {
                    $("#addModal").modal('hide');
                    toastr.success('Thanks !! Category Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 3000);
                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !!  Not Added', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "duplicate_found"){
                    toastr.error('Sorry !! Category Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            }
        });

    });


    $("[name=category_id]").change(function(e){
        e.preventDefault() ;

        var category_id = $(this).val() ;


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/gettertiarycategorybysecondarycategory') }}",
            'type':'post',
            'dataType':'text',
            data: {category_id: category_id},
            success:function(data){
                $("#tertiary_category_id").html(data) ;
            }
        });
    })

</script>



@endsection