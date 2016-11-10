 	<div class="form-group"> 
		{{ Form::label('name', null, ['class' => 'control-label']) }}
		{!!Form::text('name', (!empty($list->name)) ? $list->name : null, ['class'=>'form-control'])!!}
	</div>

	<div class="form-group"> 
		{{ Form::label('reminder', null, ['class' => 'control-label']) }}
		{!!Form::text('reminder', (!empty($list->reminder)) ? $list->reminder : null, ['class'=>'form-control'])!!}
	</div> 
	
	<div class="form-group"> 
		{{ Form::label('url', null, ['class' => 'control-label']) }}
		{!!Form::text('url', (!empty($list->url)) ? $list->url : null, ['class'=>'form-control'])!!} 
	</div> 

	<div class="form-group"> 
		@if(!empty($list))  
			{{Form::submit('Update', ['class'=>'btn btn-info'])}}  
		@else 
			{{Form::submit('Create', ['class'=>'btn btn-info'])}}
		@endif
	</div>   