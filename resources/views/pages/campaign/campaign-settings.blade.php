
@extends('layouts.app') 
@section('content') 

<link rel="stylesheet" href="https://unpkg.com/flatpickr/dist/flatpickr.min.css">
<script src="https://unpkg.com/flatpickr"></script>


<div class="panel panel-default">
  <div class="panel-heading">Campaign </div>
  <div class="panel-body"> 
  		<b>Name:</b> Jesus Erwin Suarez <br>
  		<b>List:</b> List Chard<br>
  		<b>Template:</b> Default<br>
  </div>
</div> 
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Sender Details</h3>
  </div>
  <div class="panel-body"> 
		<ul class="list-group">  
			   	<b>Sender Name:</b> Jesus Erwin Suarez <br> 
			  	<b>Sender Email:</b> mrjesuserwinsuarez@gmail.com <br>  
			  	<b>Subject:</b> This is the subject of the email<br>   
		</ul> 
  </div>
</div> 
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Delivery Type</h3>
  </div>
  <div class="panel-body"> 
	<form>
		<ul class="list-group">
		    <li class="list-group-item">   
		    	<input name="option" type="radio" class="pull-right pull-right1" rel = "pullRight1" checked> 
				<b>Direct Send:</b> yes<br>
			</li>
		    <li class="list-group-item">   
		    	<input name="option" type="radio" class="pull-right pull-right2" rel = "pullRight2" > 
		    	<input type="datetime-local" value="2016-11-12T23:20:50.52" class = "showDatetime" style = "display:none"/><br>
				<b>Schedule:</b> <br>
         <p class = "dateConverted">
          December 21, 2016 at 10:am 
         </p>

         <section id="example-altInput"><h4>Display a human-readable date</h4><pre><code class="js hljs javascript">flatpickr(<span class="hljs-string">".flatpickr"</span>, {
    <span class="hljs-attr">enableTime</span>: <span class="hljs-literal">true</span>,

    <span class="hljs-comment">// create an extra input solely for display purposes</span>
    altInput: <span class="hljs-literal">true</span>,
    <span class="hljs-attr">altFormat</span>: <span class="hljs-string">"F j, Y h:i K"</span>
});
</code></pre><input class="flatpickr flatpickr-input" type="hidden" placeholder="Select Date.." data-alt-input="true" data-enable-time="true" data-alt-format="F j, Y h:i K" value="2016-12-14 12:00"><input class="form-control input" placeholder="Select Date.." type="text" readonly="readonly"></section>
			</li>
			<li class="list-group-item">   

    <b>Repeat:</b> <br> 
       
        {{Form::select('campaignRepeat', ['daily'=>'daily', 'weekly'=>'weekly', 'monthly'=>'monthly', 'one time'=>'one time'], 'one time' )}} 
			</li>
		</ul> 		  	 
	</form> 
  </div>
</div> 

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Preview</h3>
  </div>
  <div class="panel-body">
      <a href="{{route('user.campaign.create.settings.preview.mobile' )}}" target="_blank" >Preview mobile email</a> <br>
      <a href="{{route('user.campaign.create.settings.preview.desktop')}}" target="_blank" >Preview desktop email</a> <br>
      <a href="{{route('user.campaign.create.settings.preview.tablet')}}" target="_blank" >Preview Campaign</a> <br>
  </div>  
</div>  

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Finished</h3>
  </div>
  <div class="panel-body">
    <input class="btn btn-info" type="submit" value="Finish" />
  </div>  
</div>  
@endsection



