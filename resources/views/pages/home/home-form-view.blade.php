@if(empty($forms)) 
	<br><br><br><br>
	<center>
	No forms yet...
	</center>
@else
	<div class="list-group">    
		@foreach ($forms as $index => $from) 
	 		<a href="#" class="list-group-item"> {{ $from['name']}} {{$from['create_at_ago']}}     </a>  
		@endforeach   
	  <br>
	  <center><a href="{{route('form.index')}}">view more..</a></center>
	</div> 
@endif 