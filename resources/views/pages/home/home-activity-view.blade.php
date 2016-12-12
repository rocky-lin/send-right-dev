<div class="list-group">  
@foreach ($activities as $index => $activity) 
 	<a href="#" class="list-group-item"> {{ $activity['action']}} {{$activity['create_at_ago']}} </a> 
@endforeach  
  <br>
  <center><a href="#">view more..</a></center>
</div>