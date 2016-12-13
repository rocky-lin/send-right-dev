@if(empty($contacts)) 
	<br><br><br><br>
	<center>
	No contacts yet...
	</center>
@else   
	<div class="list-group">     
		@foreach($contacts as $contact)
	 	<a href="#" class="list-group-item"> {{$contact['first_name'] . ' ' . $contact['last_name'] .' '. $contact['create_at_ago']}}  </a>   
	 	@endforeach
	  <br>
	  <center><a href="{{route('contact.index')}}">view more..</a></center>
	</div> 
@endif