 @extends('layouts.app') 
@section('content')
<div class="container"> 
    <div class="row">
        <div class="col-sm-12"> 
            <div class="panel panel-default">  
                <div class="panel-heading">Dashboard</div>   
                <div class="panel-body">    
						@include('pages.include.newsletter.newsletter-view'); 
            </div>
        </div>E 
    </div>
</div>
@endsection 
