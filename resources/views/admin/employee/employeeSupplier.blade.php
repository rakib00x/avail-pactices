<table class="table" style="margin-right:5rem;">
  <thead>
    <tr>
      <th scope="col">Sl</th>
      <th scope="col">Store Name</th>
      <th scope="col">Mobile </th>
      <th scope="col">Employee Id </th>
    </tr>
  </thead>
  <tbody>
     <?php $i=1;?> 
     @foreach($result as $value)
    <tr>
      <th scope="row">{{$i++}}</th>
      <td>{{$value->storeName}}</td>
      <td>{{$value->mobile}}</td>
      <td>{{$value->marketing_id}}</td>
    </tr>
    @endforeach
  </tbody>
</table>