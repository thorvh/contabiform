<label>{{ucwords($item)}}</label>
<select class="browser-default form-select" name="$item" id="$item" $required>
	<option value="" selected>{{$item}}</option>
	@foreach ($item_array as $item)
		<option value="{{ $item->id }}">{{ $item->name }}</option>
	@endforeach
</select>

