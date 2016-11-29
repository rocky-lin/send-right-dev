@extends('layouts.app')   
@section('content')

 
<div class="container"  > 
 
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="row">
        <div class="col-sm-12">     
        <div class="bs-docs-section" ng-controller="myListConnectCtrl">  
          <div class="bs-example" style="padding-bottom: 24px;" append-source> 
                {{ Form::open(['url'=>route('user.campaign.create.validate'), 'method'=>'post'], ['class'=>'form-control']) }}
                <form class="form-inline" role="form">   
                    <div class="form-group"> 
                        {{ Form::label('Campaign Name', 'Campaign Name', ['class'=>'label label-primary'])}}
                        {{ Form::text('campaignName', '', ['class'=>'form-control', 'placeholder'=>'Campaign Name']) }} 
                    </div>  
                    <br><br>
                    <div class="form-group">
                        <h3 class="label label-primary" >Select List</h3>
                        <input name='selectList' type="text" class="form-control" ng-model="selectedAddress" data-min-length="0" data-html="1" data-auto-select="true" data-animation="am-flip-x" bs-options="list as list.name for list in getLists($viewValue)" placeholder="Type keyword" bs-typeahead>
                    </div>    
                    <br><br>
                    <div class="form-group">
                        {{ Form::label('template', 'Select Campaign Template', ['class'=>'label label-primary'])}}
                        {{ Form::select('template', ['Default' => 'Default','Business'=>'Business','Blog'=>'Blog'], 'list1', ['class'=>'form-control']) }} 
                        <br>
                        <div class="form-group">
                            {{Form::submit('Next', ['class'=>'btn btn-primary'])}}
                        </div>  
                    <div /> 
            {{ Form::close() }}
            </div> 
        </div>  
        </div>
    </div>
</div> 
@endsection



