<label>{{ucfirst($input)}}</label>
<input class="date form-control"  type="text" id="{{$input}}" name="{{$input}}" placeholder="DD/MM/YYYY" value="{{date('d/m/Y')}}" {{$required}}>

<script type="text/javascript">
	$('.date').datepicker({
		format: 'dd/mm/yyyy'
	});
</script>