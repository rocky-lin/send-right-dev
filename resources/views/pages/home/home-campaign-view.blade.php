@if(empty($campaigns)) 
	<br><br><br><br>
	<center>
	No campaigns yet...
	</center>
@else   
	<div class="list-group">   
		@foreach($campaigns as $campaign)
	 	<a href="#" class="list-group-item"> {{  $campaign['title'] .' '. $campaign['create_at_ago']}}   </a>  
	 	@endforeach
	  <br>
	  <center><a href="{{route('campaign.index')}}">view more..</a></center>
	</div> 
@endif