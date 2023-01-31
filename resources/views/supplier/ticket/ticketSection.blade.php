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
                        <h5 class="content-header-title float-left pr-1 mb-0">Ticket</h5>
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb p-0 mb-0">
                                <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                                </li>
                                <li class="breadcrumb-item"><a href="#">Ticket</a>
                                </li>
                                <li class="breadcrumb-item active"> All Ticket
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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Add Ticket</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    {!! Form::open(['id' =>'insertTicketInfo','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <label>Subject <span style="color:red;">*</span></label>
                                                <input type="text" class="form-control" name="subject" required="">
                                            </div>

                                            <div class="col-md-12 form-group">
                                                <label>Note <span style="color:red;">*</span></label>
                                                <textarea class="form-control" name="note" required=""></textarea>
                                            </div>

                                            <div class="col-md-12 form-group">
                                                <label>Screenshot </label>
                                                <input type="file" class="form-control" name="image" >
                                            </div>
                                            <br>
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ticket List</h4>
                            </div>
                            <div class="card-content">
                                <ul class="list-group">
                                    <?php 
                                        $all_ticket = DB::table('tbl_support_ticket')
                                            ->where('supplier_id', Session::get('supplier_id'))
                                            ->orderBy('id', 'desc')
                                            ->limit(4)
                                            ->get() ;
                                     ?>
                                    <?php foreach ($all_ticket as $value): ?>
                                        <a href="{{ URL::to('ticketDetails/'.$value->ticket_number) }}" title="">
                                            <li class="list-group-item <?php if($value->status == 0){echo "list-group-item-warning"; }else{echo "list-group-item-success" ;} ?> ">
                                                
                                                    <div class="row">
                                                      <div class="col-8">
                                                          <span style="color:black!important">{{ Str::limit($value->ticket_title, 30) }}</span>
                                                      </div>
                                                      <div class="col-4">
                                                          <span style="color:black!important;font-size:10px;"><?php echo date("Y-m-d H:i:s", strtotime($value->created_at)); ?></span>
                                                          <br>
                                                          <span style="color:black!important;font-size:11px;">Status: <?php if($value->status == 0){echo "pending"; }else{echo "Solved" ;} ?></span>
                                                      </div>
                                                      <div class="col-12">
                                                          <span style="color:black!important">
                                                            {{ Str::limit($value->ticket_details, 50) }} </span>
                                                      </div>
                                                    </div>
                                                
                                            </li>
                                        </a>
                                    <?php endforeach ?>

                                </ul>
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
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ URL::to('public/app-assets/js/scripts/extensions/toastr.min.js') }}"></script>
<script>
    $("#insertTicketInfo").submit(function(e){
        e.preventDefault() ;

        let myForm = document.getElementById('insertTicketInfo');
        let formData = new FormData(myForm);

        $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':"{{ url('/insertTicketInfo') }}",
            'data': formData,
            'processData': false, // prevent jQuery from automatically transforming the data into a query string.
            'contentType': false,
            'type': 'POST',
            success: function(data) {
                if (data) {
                    toastr.success('Ticket Add Successfully. Please Wait For Respone', { positionClass: 'toast-bottom-full-width', });
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                    return false ;
                }
            }
        })
    })
</script>
@endsection
