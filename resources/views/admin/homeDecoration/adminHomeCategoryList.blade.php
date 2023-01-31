@extends('admin.masterAdmin')
@section('title','Home Category Decoration List')
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
                                <h4 class="card-title">Category Decoration List</h4>
                                <a href="{{ URL::to('adminHomeCategoryDecoration') }}" class="float-right btn btn-success btn-md ml-1">Category Ascending/Descending</a>
                                <a href="{{ URL::to('addAdminHomeCategorys') }}" class="float-right btn btn-primary btn-md">+ Add Home Category</a>
                            </div>
                            
                            <div class="card-content">
                                <div class="card-body">
                                    <!-- datatable start -->
                                    <div class="table-responsive">
                                        <table id="users-list-datatable" class="table zero-configuration">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>Category Name</th>
                                                    <th>Show Name</th>
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
                                                <td>{{$value->h_category_name}}</td>

                                                    <td>
                                                        <div class="custom-control custom-switch custom-control-inline mb-1">
                                                            <input type="checkbox" class="custom-control-input changeHomeCatgeoryStatus" <?php if($value->status == 1){ echo 'checked'; }else{ echo ''; } ?> getCategoryId="{{$value->id}}" id="customSwitch{{$value->id}}">
                                                            <label class="custom-control-label mr-1" for="customSwitch{{$value->id}}"></label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="invoice-action">
                                                            <a href="{{ URL::to('eidtAdminHomeCategory/'.$value->id) }}" class="invoice-action-edit cursor-pointer">
                                                                <i style="font-size:25px;" class="bx bx-edit"></i>
                                                            </a>
                                                            <a onclick="deletHomeCategory('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
                                                                <i style="font-size:25px;" class="bx bx-trash"></i>
                                                            </a>
                                                        </div>
                                                    </td>
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
            'url':"{{ url('/changeAdminHomeCategoryStatus') }}",
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
                }else{
                    toastr.warning('Thanks !! The Category status has In Active', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload() ;
                    }, 500);
                    return false;
                }


            }
        });
    });

    function deletHomeCategory(id) {

    var r = confirm("Are You Sure To Delete It!");
    if (r == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/adminHomeCategoryDelete') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){
                toastr.error('Thanks !! You have Delete the Primary Category', { positionClass: 'toast-bottom-full-width', });
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


</script>



@endsection