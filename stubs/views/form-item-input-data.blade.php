<label>{{ucfirst($item)}}</label>
<input class="date form-control"  type="text" id="{{$item}}" name="{{$item}}" value="{{$value}}"  placeholder="DD/MM/YYYY" value="{{date('d/m/Y')}}" {{$required}}>

<script type="text/javascript">
	$('.date').datepicker({
		format: 'dd/mm/yyyy'
	});
</script>