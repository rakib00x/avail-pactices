<option value="">Select Sub-Menu</option>
@foreach($submenu as $sevalue)
<option value="{{ $sevalue->id }}">{{ $sevalue->sub_menu_name }}</option>
@endforeach