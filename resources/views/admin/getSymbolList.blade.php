@foreach($symbols as $symbol)
<option value="{{ $symbol->id }}" <?php if($symbol->status == 1){echo "selected"; }else{echo " ";} ?>>{{ $symbol->symbol_name }}</option>
@endforeach