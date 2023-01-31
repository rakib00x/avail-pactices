@extends('seller.seller-master')
@section('title')
    Ticket Details
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Ticket Details : <?php echo $ticket_value->ticket_number; ?></h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">

                                    <h4 class="mt-1"><?php echo $ticket_value->ticket_title; ?> </h4>
                                    <span style="font-size:12px;"> Status: <?php if($ticket_value->status == 0){echo "Pending"; }else{echo "Solved" ;} ?> <?php echo date("d-m-Y h:i:s A", strtotime($ticket_value->created_at)) ; ?></span>
                                    <p class="mt-1"><?php echo $ticket_value->ticket_details ; ?></p>
                                    <?php if ($ticket_value->image != "" || $ticket_value->image != null): ?>
                                        <img src="{{ URL::to('public/images/'.$ticket_value->image) }}" alt="">
                                    <?php endif ?>
                                    <?php if ($ticket_value->ticket_reply != null || $ticket_value->ticket_reply != ""): ?>
                                        <h4 class="ml-1">Reply</h4>
                                        <p class="ml-2"><?php echo $ticket_value->ticket_reply; ?></p>
                                    <?php endif ?>
                                    

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
