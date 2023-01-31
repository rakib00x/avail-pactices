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


</style>
@endpush
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-body">
            <section id="basic-datatable">
                <div class="row">
                    <div class="col-12">
                        <h4 class="card-title">Paymeent History</h4>
                        <div class="card">
                            <div class="card-header">

                                <!--<a role="button" class="float-right btn btn-primary btn-md"  data-toggle="modal" id="add" data-target="#addModal" >+ Add Salat</a>-->

                            </div>

                            <div class="card-content" id="body_data">
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
                   <td width="10%">{{$tha->name}}</td> 
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
                                
                                
                             </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="modal fade" id="editModal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myModalLabel1">Paymeent Option</h3>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">

                            {!! Form::open(['id' =>'updatePaymeent','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                            <div class="form-body" id="paymeentForm">
                            </div>
                            {!! Form::close() !!}
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')
<!-- Alert Assets -->
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/empllist') }}",
            'type':'post',
            'dataType':'text',
            success:function(data){
                console.log(data);
                return false;
                
                $("#body_data").empty();
                $("#body_data").html(data);

            }
        });

    });

 $('body').on('submit', '#updatePaymeent', function (e) {
        e.preventDefault();

        var shop_list	   = $("#shop_list").val() ;
         var rate	   = $("#rate").val() ;
        var peanding_amount	   = $("#peanding_amount").val() ;
        var confirm_amount	   = $("#confirm_amount").val() ;
        var balance	   = $("#balance").val() ;
        var id 	= $("[name=id]").val() ;

        if (shop_list == "") {
            toastr.info('Oh shit!! Please Input  Shop List', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
     if (peanding_amount == "") {
            toastr.info('Oh shit!! Please Input  Peanding Amount', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
        if (confirm_amount == "") {
            toastr.info('Oh shit!! Please Input  Confirm Amount', { positionClass: 'toast-bottom-full-width', });
            return false;
        }
        if (balance == "") {
            toastr.info('Oh shit!! Please Input  Balance', { positionClass: 'toast-bottom-full-width', });
            return false;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/updateEmployee') }}",
            'type':'post',
            'dataType':'text',
            data: {shop_list:shop_list,peanding_amount:peanding_amount,confirm_amount:confirm_amount,balance:balance,rate:rate,id:id},
            success:function(data){

                $.ajax({
                    'url':"{{ url('/empllist') }}",
                    'type':'post',
                    'dataType':'text',
                    success:function(data){
                        $("#body_data").empty();
                        $("#body_data").html(data);

                    }
                });

                $("#editModal").modal('hide') ;
                if (data == "success") {
                    toastr.success('Thanks !!  Namaz Update Successfully Compeleted', {positionClass: 'toast-bottom-full-width', });

                    return false;
                }else if(data == "failed"){
                    toastr.error('Sorry !!  Namaz Not Updated', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else if(data == "duplicate_found"){
                    toastr.error('Sorry !!  This Namaz Time Already Exist', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });

    });


    function edit(id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/emppaymeent') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){

                $("#paymeentForm").empty().html(data) ;

            }
        });
    }
</script>

@endsection
