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
                        <h4 class="card-title">Contact List</h4>
                        <div class="card">



                            <div class="card-content" id="body_data">
                                <div class="card-body card-dashboard">
                                    <div class="table-responsive">
                                        <table class="table zero-configuration" >
                                            <thead>
									                <tr>
									                    <th>SN</th>
									                    <th>Date</th>
									                    <th>Name </th>
									                    <th>Email</th>
									                    <th>Subject</th>
									                    <th>Show</th>
									                </tr>
									            </thead>

									            <tbody>
									                <?php $i=1;?>
									                @foreach($result as $value)
									                <tr class="" <?php if($value->status == 0){ echo 'style="background:#8B0000"'; }else{ echo ''; } ?> href="#">
									                    <td>{{$i++}}</td>
									                    <td>{{ $value->created_at }}</td>
									                    <td>{{$value->name}}</td>
									                    
									                    <td>
									                    	{{ $value->email }}
									                    </td>
									                    
									                    <td>
									                    	{{ $value->subject  }}
									                    </td>
									                    
									                    <td>
									                   <a onclick="viewAdminContact(event, '{{$value->id}}')" href="#" class="invoice-action-edit cursor-pointer showContactStutas" getContactid="{{$value->id}}" title="details">
                                                                <i style="font-size:25px;" class="bx bx-edit"></i>
                                                            </a>
                                                            <a onclick="deleteContact('{{$value->id}}')" class="invoice-action-view mr-1" style="cursor: pointer;">
                                                                <i style="font-size:25px;" class="bx bx-trash"></i>
                                                            </a>
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

            <!-- Modal -->
                <div class="modal fade" id="contact_modal" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myModalLabel1">Contact Details</h3>
                                <button type="button" class="close reLoad" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                {!! Form::open(['id' =>'addTicketReply','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                                    <div class="form-body" id="reviewDetails">

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

<script>

 $(function(){
        $('body').on('click', '.showContactStutas', function (e) {
            e.preventDefault();

            var contact_id = $(this).attr('getContactid');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/showContactStutas') }}",
                'type':'post',
                'dataType':'text',
                data:{contact_id:contact_id},
                success:function(data)
              {
                console.log('show message');
             }
            });

        })
    });
    
    $('body').on('click', '.reLoad', function (e) {
            e.preventDefault();
            location.reload();
    });
    function viewAdminContact(event, id) {
        event.preventDefault() ;

        $("#contact_modal").modal('show') ;

       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/getAdminContact') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data)
            {
                $("#reviewDetails").empty().html(data) ;
            }
        }); 
    }
    
   

</script>
<script>
     // delete
function deleteContact(id) {
    var r = confirm("Are You Sure To Delete It!");
    if (r == true) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            'url':"{{ url('/deleteContact') }}",
            'type':'post',
            'dataType':'text',
            data:{id:id},
            success:function(data){
                location.reload();

                if (data == "success") {
                    $.ajax({
                        'url':"{{ url('/showContactStutas') }}",
                        'type':'post',
                        'dataType':'text',
                        success:function(data){
                            $("#body_data").empty();
                            $("#body_data").html(data);
                        }
                    });

                    toastr.error('Thanks !! You have Delete the Ads', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }else{
                    toastr.error('Sorry !! Ads Not Delete', { positionClass: 'toast-bottom-full-width', });
                    return false;
                }

            }
        });
    } else {
        toastr.error('Thanks !! Delete Cancel', { positionClass: 'toast-bottom-full-width', });
        return false;
    }
}
</script>

@endsection