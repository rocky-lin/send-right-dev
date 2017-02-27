  

 
<?php 
	
	$stepLists = ['Campaigns'=>'#', 'Campaign Details'=>'#', 'Sender Details'=>'#', 'Select Template'=>'#', 'Compose Campaign'=>'#', 'Campaign Settings'=>'#'];


	// $stepLists = ['Campaigns'=>route('campaign.index'), 'Campaign Details'=>route('campaign.create'), 'Sender Details'=>route('user.campaign.create.sender.view'), 'Compose Campaign'=>'#', 'Campaign Settings'=>route('user.campaign.create.settings')]; 

?>
<ol class="breadcrumb"> 
	<?php $disableNext = false; ?>
 	@foreach($stepLists as $step => $url)  

 		@if($step == $currentStep)
			<?php $disableNext = true; ?>
 			<li  class="active" >{{$step}}</li>
 		@else  
 			@if($disableNext == true)  
 				<li><a href="#">{{$step}}</a></li>
 			@else 
				<li><a href="{{$url}}">{{$step}}</a></li>
 			@endif 
		@endif 
 	@endforeach 
</ol>


{{-- <ol class="breadcrumb"> --}}
  
{{--   <li  class="active" >Campaigns</li>
  <li><a href="#">Campaign Details</a></li>
  <li><a href="#">Sender Details</a></li>
  <li><a href="#">Compose Campaign</a></li>
  <li><a href="#">Campaign Settings</a></li> 
 --}}  
{{-- </ol> --}}