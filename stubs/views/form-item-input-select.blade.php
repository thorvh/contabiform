<label>{{ucwords($input)}}</label>
<select class="browser-default form-select" name="$input" id="$input" $required>
	<option value="" selected>{{$input}}</option>
	@foreach ($input_array as $input)
		<option value="{{ $input->id }}">{{ $input->name }}</option>
	@endforeach
</select>

