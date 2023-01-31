@foreach($result as $value)
<tr>
    <td><p style="height:35px;width:35px;border-radius: 50%;background-color: {{$value->color_code}}"></p></td>
    <td>{{$value->color_code}}</td>
    <td>
        <a class="btn btn-primary" onclick="editFontColor('{{$value->id}}')" data-toggle="modal" id="edit" data-target="#editModalFont" href="#" >Change Color</a>
    </td>
</tr>
@endforeach