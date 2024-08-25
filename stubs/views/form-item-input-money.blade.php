<label>{{ucwords($item)}} (€)</label>
<input type="text" class="form-control" id="{{$item}}" name="{{$item}}" value="{{$value}}"  data-toggle="input-mask" data-mask-format="00000.00" data-reverse="true" placeholder="120,00"{{$required}}>
							