@foreach($currencies as $currency)
<option value="{{ $currency->id }}" <?php if($currency->default_status == 1){echo "selected"; }else{echo " ";} ?>>{{ $currency->name }}</option>
@endforeach