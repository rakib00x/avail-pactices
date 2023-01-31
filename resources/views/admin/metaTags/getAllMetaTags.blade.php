<?php $i=1;?>
@foreach($result as $value)
<tr>
    <td >{{$i++}}</td>
    <td >{{ $value->meta_title }}</td>
    <td >{{ $value->meta_details }}</td>
    <td >{{ $value->meta_keywords }}</td>
    <td >
        <img src="{{ URL::to('public/images/'.$value->meta_image)}}" alt="" style="width: 75px;height: 33px;">
    </td>  

    <td>
        <div class="invoice-action">
            <a onclick="edit('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editModal" href="#" class="invoice-action-edit cursor-pointer">
                <i style="font-size:25px;" class="bx bx-edit"></i>
            </a>
        </div>
    </td>
</tr>
@endforeach