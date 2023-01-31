<option value="">Select Secondary Category</option>
@foreach($all_secondarycategory as $sevalue)
<option value="{{ $sevalue->id }}">{{ $sevalue->secondary_category_name }}</option>
@endforeach