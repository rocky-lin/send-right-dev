@extends('layouts.app') 
@section('content')
<div class="container"> 
    <div class="row">
        <div class="col-sm-12"> 
            <div class="panel panel-default">  
                <div class="panel-heading">Dashboard</div>   
                <div class="panel-body">   
					<div class="row"> 
						<div class="col-sm-6">
	                 		<a href="{{route('campaign.create')}}" title="">Create Campaign</a>
						</div>
						<div class="col-sm-6">
	                 		<a href="{{route('campaign.create')}}" title="">Create Auto Responder</a> 
	                 	</div>
	                </div>

            </div>
        </div>
    </div>
</div>
@endsection 
