@extends('layouts.app') 
@section('content')
<div class="container"> 
    <div class="row">
        <div class="col-sm-12"> 
            <div class="panel panel-default">  
                <div class="panel-heading">Dashboard</div>    
                <div class="panel-body">   
                    @include('pages/include/other/submitted-form-response-one')  
                	<div data-ng-controller="myListCreateViewCtr" data-ng-init="listId={{$id}}" >    
						    {!! Form::open(['route' => ['list.update', $id], 'method'=>'PATCH', 'name'=>'addListFrm', 'autocomplete'=>'off']) !!} 
								@include('pages.include.list.list-form', ['list'=>$list]) 
					 			@include('pages.include.contact.contact-select')   
			            	{!!Form::close()!!}     
                	</div>     
                </div>       
            </div>
        </div>
    </div>
</div>
@endsection 