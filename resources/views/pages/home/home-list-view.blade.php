@if(empty($lists)) 
	<br><br><br><br>
	<center>
	No lists yet...
	</center>
@else
	<div class="list-group">   
		@foreach ($lists as $index => $list) 
	 		<a href="#" class="list-group-item"> {{ $list['name']}} {{$list['create_at_ago']}} </a>  
		@endforeach  

	  <br>
	  <center><a href="{{route('list.index')}}">view more..</a></center>
	</div>
@endif