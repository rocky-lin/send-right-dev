@extends('layouts.app') 
@section('content')
<div class="container"> 
    <div class="row">
        <div class="col-sm-12"> 
            <div class="panel panel-default">  
                <div class="panel-heading"><h4>Select Campaign Type</h4></div>   
                <div class="panel-body">   

					@include('errors.error-status')
 
					<div class="row"> 
						<div class="col-sm-12" >  

				<div class="list-group">
					{{Form::open(['url'=>route('campaign.create'), 'method'=>'get'])}} 
						<input type="hidden" value="newsletter" name="ck">
					  	<button type="submit" class="list-group-item"> 
	             			<div>
								<img src="{{url('/public/img/icon/campaign.png')}}" />
							</div>
						    <label>Create Newsletter</label> 
					  </button>
				  {{Form::close()}}
						{{Form::open(['url'=>route('campaign.create'), 'method'=>'get'])}} 
						<input type="hidden" value="auto responder" name="ck">
					  	<button type="submit" class="list-group-item"> 
	             			<div>
								<img src="{{url('/public/img/icon/autoresponse.png')}}" />
							</div>
						    <label>Create auto responder</label> 
					  </button>
 
				</div>


	                 		
                 		
						</div> 
	                </div>

            </div>
        </div>
    </div>
</div>
@endsection 
