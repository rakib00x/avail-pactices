@extends('supplier.masterSupplier')
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


</style>
@endpush
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">

            <section id="page-account-settings">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <!-- left menu section -->
                            <div class="col-md-3 mb-2 mb-md-0 pills-stacked">
                                <ul class="nav nav-pills flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center active" id="account-pill-general" data-toggle="pill" href="#account-vertical-general" aria-expanded="true">
                                            <i class="bx bx-cog"></i>
                                            <span>Menu </span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="account-pill-password" data-toggle="pill" href="#account-vertical-password" aria-expanded="false">
                                            <i class="bx bx-lock"></i>
                                            <span>Sub-Menu</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link d-flex align-items-center" id="account-pill-info" data-toggle="pill" href="#account-vertical-info" aria-expanded="false">
                                            <i class="bx bx-info-circle"></i>
                                            <span>Sub Sub-Menu</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- right content section -->
                            <div class="col-md-9">
                                <div class="tab-content">

                                    <div role="tabpanel" class="tab-pane active" id="account-vertical-general" aria-labelledby="account-pill-general" aria-expanded="true">

                                        <section id="basic-datatable">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title float-left">Menu List</h4>

                                                            <a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#addModal" >+ Add Menu</a>

                                                        </div>

                                                        <div class="card-content" id="body_data"> 
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                    </div>

                                    <!-- sub menu -->
                                    <div class="tab-pane fade " id="account-vertical-password" role="tabpanel" aria-labelledby="account-pill-password" aria-expanded="false">

                                        <section id="basic-datatable">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title float-left"> Sub-Menu List</h4>

                                                            <a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#addsubModal" >+ Add Sub-Menu</a>

                                                        </div>

                                                        <div class="card-content" id="submenu_data">
                                                           
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                    </div>

                                    <!-- sub sub-menu -->
                                    <div class="tab-pane fade" id="account-vertical-info" role="tabpanel" aria-labelledby="account-pill-info" aria-expanded="false">

                                        <section id="basic-datatable">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title float-left"> Sub Sub-Menu List</h4>

                                                            <a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#adddoublesubmenu" >+ Add Sub Sub-Menu</a>

                                                        </div>

                                                        <div class="card-content" id="doublesubmenu_data">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div>


<!-- menu add modal -->
<div class="content-body">

    <div class="modal fade" id="addModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel1">Add Menu</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">

                    {!! Form::open(['id' =>'insertMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Menu <span style="color:red;">*</span></label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" class="form-control menu_name" name="menu_name" required="">
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
    <!-- end menu add modal -->

    <!-- update menu modal -->
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myModalLabel1">Update Menu</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">

                    {!! Form::open(['id' =>'updateMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                    <div class="form-body" id="editMenu">

                    </div>
                    {!! Form::close() !!}
                </div>

            </div>
        </div>
    </div>
    <!-- end menu update modal -->

</div>
</div>
</div>



<!-- sub menu add modal -->
<div class="modal fade" id="addsubModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel1">Add Sub-Menu</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' =>'insertSubMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Select MenuS<span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <select class="form-control" id="menu_id">
                                <option value="">Select Menu</option>
                                <?php foreach ($result as $value) { ?>
                                    <option value="<?php echo $value->id ; ?>" ><?php echo $value->menu_name ; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Sub-Menu <span style="color:red;">*</span></label>
                        </div>
                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control sub_menu_name" name="sub_menu_name" required="">
                        </div>
                        <br>
                        <br>
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

<!-- sub menu update modal -->
<div class="modal fade" id="editsubModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel1">Update Sub-Menu</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' =>'updateSubMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                <div class="form-body" id="subEdit">
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>


<!-- sub sub-menu add modal-->
<div class="modal fade" id="adddoublesubmenu" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel1">Add Sub Sub-Menu</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body">

                {!! Form::open(['id' =>'insertSubSubMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Select Menu<span style="color:red;">*</span></label>
                        </div>

                        <div class="col-md-8 form-group">
                            <select class="form-control submainmenu" id="submainmenu" name="menu_name">
                                <option value="">Select Menu</option>
                                <?php foreach ($result as $value) { ?>
                                    <option value="<?php echo $value->id ; ?>" ><?php echo $value->menu_name ; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Select Sub-Menu<span style="color:red;">*</span></label>
                        </div>

                        <div class="col-md-8 form-group">
                            <select class="form-control secondary_menu" id="secondary_menu" name="sub_menu_name">

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Sub Sub-Menu<span style="color:red;">*</span></label>
                        </div>

                        <div class="col-md-8 form-group">
                            <input type="text" class="form-control sub_sub_menu_name" name="sub_sub_menu_name" required="">

                        </div>

                        <br>
                        <br>
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


<!-- sub sub-menu update modal -->


<div class="modal fade" id="editsubmenuModal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myModalLabel1">Update Sub Sub-Menu</h3>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">

                {!! Form::open(['id' =>'updateSubSubMenuInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                <div class="form-body" id="menuThreeEdit">

                </div>
                {!! Form::close() !!}

            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<!-- Alert Assets -->
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>

<!-- Delete Section Start Here -->
<script type="text/javascript">

    $('body').on('click', '#addCategory', function (e) {
        $("#addModal").modal();
        return false ;
    });

    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/getAllMenu') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                $("#body_data").empty();
                $("#body_data").html(data);

            }
        });

    });

    $('body').on('submit', '#insertMenuInfo', function (e) {
        e.preventDefault();
        var menu_name = $('[name="menu_name"]').val() ;
        if (menu_name == "") {
            toastr.info('Oh shit!! Please Input Menu Name', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/insertMenuInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {menu_name: menu_name},
            success:function(data){

                if (data == "success") {

                    $.ajax({
                        'url':"{{ url('/getAllMenu') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);

                        }
                    });

                    $("#addModal").modal('hide');
                    toastr.success('Thanks !! Menu Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !! Menu Not Added', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "duplicate_found"){
                    toastr.error('Sorry !! Menu Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });

    });

    $(function(){
        $('body').on('click', '.changeMenuStatus', function (e) {
            e.preventDefault();

            var menu_id = $(this).attr('getMenuid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/changeMenuStatus') }}",
                'type':'post',
                'dataType':'text',
                data:{menu_id:menu_id},
                success:function(data)
                {
                    $.ajax({
                        'url':"{{ url('/getAllMenu') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);
                        }
                    });

                    if(data == "success"){
                        toastr.success('Thanks !! The status has activated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Thanks !! The status has deactivated', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }
                }
            });

        })
    });



    $('body').on('submit', '#updateMenuInfo', function (e) {
        e.preventDefault();

        var menu_name   = $("#menu_update").val() ;
        var primary_id      = $("[name=primary_id]").val() ;

        if (menu_name == "") {
            toastr.info('Oh shit!! Please Input Menu Name', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updateMenuInfo') }}",
            'type':'post',
            'dataType':'text',
            data: {menu_name: menu_name, primary_id:primary_id},
            success:function(data){
                $.ajax({
                    'url':"{{ url('/getAllMenu') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#body_data").empty();
                        $("#body_data").html(data);

                    }
                });
                $("#editModal").modal('hide') ;
                if (data == "success") {
                    toastr.success('Thanks !! Menu Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !! Menu Not Updated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "duplicate_found"){
                    toastr.error('Sorry !! Menu Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });

    });

    function deleteMenu(id) {

        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/menuDelete') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){

                    if (data == "success") {
                        $.ajax({
                            'url':"{{ url('/getAllMenu') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                $("#body_data").empty();
                                $("#body_data").html(data);

                            }
                        });

                        toastr.error('Thanks !! You have Delete the Menu', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else if(data == "cused"){
                        toastr.error('Sorry !! Menu Already Used', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Sorry !! Menu Not Delete', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }

                }
            });
        } else {
            toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
    }
    function edit(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/editMainMenu') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){

                $("#editMenu").empty().html(data) ;

            }
        });
    }

//get all sub menu
$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':"{{ url('/getAllSubMenuData') }}",
        'type':'post',
        'dataType':'text',
        success:function(data){
            $("#submenu_data").empty();
            $("#submenu_data").html(data);
        }
    });
});

$('body').on('submit', '#insertSubMenuInfo', function (e) {
    e.preventDefault();

    var menu_id = $("#menu_id").val() ;
    var sub_menu_name = $('[name="sub_menu_name"]').val() ;

    if (menu_id == "") {
        toastr.info('Oh shit!! Select Menu First', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    if (sub_menu_name == "") {
        toastr.info('Oh shit!! Please Input Sub-Menu Name', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':"{{ url('/insertSubMenuInfo') }}",
        'type':'post',
        'dataType':'text',
        data: {menu_id: menu_id,sub_menu_name: sub_menu_name},
        success:function(data){
            if (data == "success") {
                $.ajax({
                    'url':"{{ url('/getAllSubMenuData') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#submenu_data").empty();
                        $("#submenu_data").html(data);
                    }
                });

                $("#addsubModal").modal('hide');
                toastr.success('Thanks !! Sub-Menu Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                return false;
            }else if(data == "failed"){
                toastr.error('Sorry !! Sub-Menu Not Added', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else if(data == "duplicate_found"){
                toastr.error('Sorry !! Sub-Menu Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
        }
    });

});

$(function(){
    $('body').on('click', '.changeSubMenuStatus', function (e) {
        e.preventDefault();

        var sub_menu_id = $(this).attr('getSubMenuid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changeSubMenuStatus') }}",
            'type':'post',
            'dataType':'text',
            data:{sub_menu_id:sub_menu_id},
            success:function(data)
            {
                $.ajax({
                    'url':"{{ url('/getAllSubMenuData') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#submenu_data").empty();
                        $("#submenu_data").html(data);

                    }
                });

                if(data == "success"){
                    toastr.success('Thanks !! The status has activated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.error('Thanks !! The status has deactivated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            }
        });

    })
});



$('body').on('submit', '#updateSubMenuInfo', function (e) {
    e.preventDefault();

    var menu_id           = $("#mainmenu").val() ;
    var primary_id          = $("[name=primary_id]").val() ;
    var sub_menu_name       = $("#sub_menu_name").val() ;

    if (menu_id == "") {
        toastr.info('Oh shit!! Select Menu First', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    if (sub_menu_name == "") {
        toastr.info('Oh shit!! Please Input Sub-Menu Name', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':"{{ url('/updateSubMenuInfo') }}",
        'type':'post',
        'dataType':'text',
        data: {menu_id: menu_id,sub_menu_name: sub_menu_name,primary_id:primary_id},
        success:function(data){
            $.ajax({
                'url':"{{ url('/getAllSubMenuData') }}",
                'type':'post',
                'dataType':'text',
                success:function(data){
                    $("#submenu_data").empty();
                    $("#submenu_data").html(data);

                }
            });
            $("#editsubModal").modal('hide') ;
            if (data == "success") {
                toastr.success('Thanks !! Sub-Menu Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                return false;
            }else if(data == "failed"){
                toastr.error('Sorry !! Sub-Menu Not Updated', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else if(data == "duplicate_found"){
                toastr.error('Sorry !! Sub-Menu Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
        }
    });

});

function deleteSubMenu(id) {

    var r = confirm("Are You Sure To Delete It!");
    if (r == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/subMenuDelete') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){

                if (data == "success") {
                    $.ajax({
                        'url':"{{ url('/getAllSubMenuData') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#submenu_data").empty();
                            $("#submenu_data").html(data);

                        }
                    });

                    toastr.error('Thanks !! You have Delete the Sub-Menu', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "cused"){
                    toastr.error('Sorry !! Sub-Menu Name Already Used', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.error('Sorry !! Sub-Menu Not Delete', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });
    } else {
        toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
        return false;
    }
}

function editsub(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        'url':"{{ url('/editSubMenu') }}",
        'type':'post',
        'dataType':'text',
        data:{id:id},
        success:function(data){

            $("#subEdit").empty().html(data) ;

        }
    });
}

//sub sub-menu all data

$(document).ready(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':"{{ url('/getAllSubSubMenuData') }}",
        'type':'post',
        'dataType':'text',
        success:function(data){
            $("#doublesubmenu_data").empty();
            $("#doublesubmenu_data").html(data);

        }
    });

});

$('body').on('change', '.submainmenu', function (e) {
    e.preventDefault();
    var menu_id = $(this).val() ;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':"{{ url('/getSubMenuByMenu') }}",
        'type':'post',
        'dataType':'text',
        data: {menu_id: menu_id},
        success:function(data){
            $(".secondary_menu").empty().html(data) ;
        }
    });

});

$('body').on('submit', '#insertSubSubMenuInfo', function (e) {
    e.preventDefault();

    var menu_id    = $("#submainmenu").val() ;
    var sub_menu_id  = $("#secondary_menu").val() ;
    var sub_sub_menu_name    = $("[name=sub_sub_menu_name]").val() ;


    if (menu_id == "") {
        toastr.info('Oh shit!! Select Menu First', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    if (sub_menu_id == "") {
        toastr.info('Oh shit!! Select Sub-Menu First', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    if (sub_sub_menu_name == "") {
        toastr.info('Oh shit!! Please Input Sub Sub-Menu', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':"{{ url('/insertSubSubMenuInfo') }}",
        'type':'post',
        'dataType':'text',
        data: {menu_id: menu_id,sub_menu_id: sub_menu_id, sub_sub_menu_name:sub_sub_menu_name},
        success:function(data){

            if (data == "success") {

                $.ajax({
                    'url':"{{ url('/getAllSubSubMenuData') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#doublesubmenu_data").empty();
                        $("#doublesubmenu_data").html(data);

                    }
                });

                $("#adddoublesubmenu").modal('hide');
                toastr.success('Thanks !! Sub Sub-Menu Add Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                return false;
            }else if(data == "failed"){
                toastr.error('Sorry !! Sub Sub-Menu Not Added', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else if(data == "duplicate_found"){
                toastr.error('Sorry !! Sub Sub-Menu Already Exist', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
        }
    });

});

$(function(){
    $('body').on('click', '.statusChange', function (e) {
        e.preventDefault();

        var sub_sub_menu_id = $(this).attr('getSubid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/changeSubSubMenuStatus') }}",
            'type':'post',
            'dataType':'text',
            data:{sub_sub_menu_id:sub_sub_menu_id},
            success:function(data)
            {
                $.ajax({
                    'url':"{{ url('/getAllSubSubMenuData') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#doublesubmenu_data").empty();
                        $("#doublesubmenu_data").html(data);

                    }
                });

                if(data == "success"){
                    toastr.success('Thanks !! The status has activated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.error('Thanks !! The status has deactivated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            }
        });

    })
});


//update sub sub-menu

$('body').on('submit', '#updateSubSubMenuInfo', function (e) {
    e.preventDefault();

    var primary_id          = $("[name=primary_id]").val() ;
    var menu_id = $(".menuone").val() ;
    var sub_menu_id  = $(".menutwo").val() ;
    var sub_sub_menu_name   = $("#lastmenu").val() ;


    if (menu_id == "") {
        toastr.info('Oh shit!! Select Menu First', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    if (sub_menu_id == "") {
        toastr.info('Oh shit!! Select Sub-Menu Category First', { positionClass: 'toast-bottom-full-width', });
        return false;
    }

    if (sub_sub_menu_name == "") {
        toastr.info('Oh shit!! Please Input Sub Sub-Menu Name', { positionClass: 'toast-bottom-full-width', });
        return false;
    }


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        'url':"{{ url('/updateSubSubMenuInfo') }}",
        'type':'post',
        'dataType':'text',
        data: {menu_id: menu_id,sub_menu_id: sub_menu_id, sub_sub_menu_name:sub_sub_menu_name, primary_id:primary_id},
        success:function(data){
            $.ajax({
                'url':"{{ url('/getAllSubSubMenuData') }}",
                'type':'post',
                'dataType':'text',
                success:function(data){
                    $("#doublesubmenu_data").empty();
                    $("#doublesubmenu_data").html(data);

                }
            });
            $("#editModal").modal('hide') ;
            if (data == "success") {
                toastr.success('Thanks !! Sub-Menu Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                return false;
            }else if(data == "failed"){
                toastr.error('Sorry !! Sub-Menu Not Updated', { positionClass: 'toast-bottom-full-width', });
                return false;
            }else if(data == "duplicate_found"){
                toastr.error('Sorry !! Sub-Menu Name Already Exist', { positionClass: 'toast-bottom-full-width', });
                return false;
            }
        }
    });

});


function deleteSubSubMenu(id) {

    var r = confirm("Are You Sure To Delete It!");
    if (r == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/subSubMenuDelete') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){

                if (data == "success") {
                    $.ajax({
                        'url':"{{ url('/getAllSubSubMenuData') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#doublesubmenu_data").empty();
                            $("#doublesubmenu_data").html(data);
                        }
                    });

                    toastr.error('Thanks !! You have Delete the Sub Sub-Menu', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.error('Sorry !! Sub Sub-Menu Not Delete', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }
            }
        });
    } else {
        toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
        return false;
    }
}

function editsubmenu(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        'url':"{{ url('/editSubSubMenu') }}",
        'type':'post',
        'dataType':'text',
        data:{id:id},
        success:function(data){
            console.log(data) ;
            $("#menuThreeEdit").empty().html(data) ;

        }
    });
}



</script>

@endsection