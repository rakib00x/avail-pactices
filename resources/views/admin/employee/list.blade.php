@extends('admin.masterAdmin')
@section('title','Employee Suppliers List')
@section('content')
 <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- invoice list -->
                <section class="invoice-list-wrapper">
                    <!-- Options and filter dropdown button-->
                    <div class="table-responsive">
                        <table class="table invoice-data-table dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <!--<th>Image</th>-->
                                    <!-- <th>
                                        <span class="align-middle">Invoice#</span>
                                    </th> -->
                                    <th>Name</th>
                                    <th>Name</th>
                                    <th>Number</th>
                                    <th>Email</th>
                                    <!--<th>ID</th>-->
                                    <th>Join Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @php
                                 $i = 1;
                                 @endphp
                                <?php foreach ($result as $value): ?>
                                   
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <!-- <td></td> -->
                     
                                       {{--
                                       <td>
                                            <a href="#">INV-{{ $value->invoice_number }}</a>
                                        </td>
                                       --}} 


                                        <!--<td><span class="invoice-amount"></span></td>-->
                                        <td><small class="text-muted"> {{$value->name}}</small></td>
                                        <td><span class="invoice-customer"> {{$value->mobile}}</span></td>
                                        <td><span class="invoice-customer">{{$value->email}}</span></td>
                                        <td><span class="invoice-customer">
                                           {{$value->created_at}}
                                            </span></td>
                                        <td>
                                            <?php if ($value->status == 0): ?>
                                                <span class="badge badge-light-danger badge-pill">Pending</span>
                                            <?php else: ?>
                                                <span class="badge badge-light-success badge-pill">Completed</span>
                                            <?php endif ?>
                                        </td>
                                        <td>
                                            
                                           <div class="btn-group mb-1">
                                                            <div class="dropdown">
                                                                <button class="btn btn-primary btn-sm dropdown-toggle mr-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Action
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalLong" onclick="edit('{{$value->id}}')">
                                                                     Show Supplier
                                                                    </button>
                                                                    <button type="button" class="btn btn-primary" onclick="deleteeployee(event, <?php echo $value->id; ?>)">
                                                                     Delete
                                                                    </button>
                                                                    <a class="dropdown-item" target="_new" href="{{URL::to('loginWithEmployee/'.$value->id)}}">Login as this employee</a>
                                                                </div>
                                                            </div>
                                                        </div> 
                                            
                                        </td>
                                    </tr>
                                <?php endforeach ?>

                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
    
    <!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Supplier List</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
         {!! Form::open(['id' =>'viewSupplier','method' => 'post','role' => 'form', 'class' => 'form form-horizontal', 'files'=>'true']) !!}
                    <div class="form-body" id="supplierviewForm">

                    </div>
         {!! Form::close() !!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>

   <!-- Modal -->
<div class="modal fade" id="modelList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Employee Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
         
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-primary">Save changes</button>-->
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="{{ URL::to('public/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>

<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
        toastr.info("{{ Session::get('message') }}");
        break;
        case "success":
        toastr.success("{{ Session::get('message') }}");
        setTimeout(function(){
            location.reload();
        }, 3000);
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
    function edit(id) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        'url':"{{ url('/employeesupplier') }}",
        'type':'post',
        'dataType':'text',
        data:{id:id},
        success:function(data){
            $("#supplierviewForm").empty().html(data) ;

        }
    });
}


function deleteeployee(event, id) {
        event.preventDefault() ;

        var r = confirm("Are You Sure To Delete It!");
        if (r == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                'url':"{{ url('/deleteEmployee') }}",
                'type':'post',
                'dataType':'text',
                data:{id:id},
                success:function(data){

                    if (data == "success") {
                        location.reload(true);
                        $.ajax({
                            'url':"{{ url('/empllist') }}",
                            'type':'post',
                            'dataType':'text',
                            success:function(data){
                                // $("#exampleModalLong").hide();
                                $("#body_data").empty();
                                $("#body_data").html(data);

                            }
                        });

                        toastr.success('Thanks !! You have Delete the  Employee', { positionClass: 'toast-bottom-full-width', });
                        return false;
                    }else{
                        toastr.error('Sorry !! Employee Not Delete', { positionClass: 'toast-bottom-full-width', });
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