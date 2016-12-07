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
          @include('pages.include.other.campaign-header-steps',  ['currentStep' => 'Sender Details'])
          
        <div class="bs-docs-section" ng-controller="myListConnectCtrl">  
          <div class="bs-example" style="padding-bottom: 24px;" append-source> 
                        

                            
                            @if(!empty($action))
                                {{ Form::open(['url'=>route('user.campaign.sender.update', $id), 'method'=>'post'], ['class'=>'form-control']) }}
                            @else 
                                {{ Form::open(['url'=>route('user.campaign.create.sender.validate'), 'method'=>'post'], ['class'=>'form-control']) }}
                            @endif 
                


                <form class="form-inline" role="form">   
                    <div class="form-group"> 
                        {{ Form::label('Sender Name', 'Sender Name', ['class'=>'label label-primary'])}}
                        {{ Form::text('senderName', (!empty($campaign['sender']['name'])) ? $campaign['sender']['name'] : Auth::user()->name, ['class'=>'form-control', 'placeholder'=>'Sender Name']) }} 
                    </div>   
                     <div class="form-group"> 
                        {{ Form::label('Sender Email', 'Sender Email', ['class'=>'label label-primary'])}}
                        {{ Form::email('senderEmail', (!empty($campaign['sender']['email'])) ? $campaign['sender']['email'] : Auth::user()->email, ['class'=>'form-control', 'placeholder'=>'Sender Email']) }} 
                    </div>   
                    <div class="form-group">
                        {{ Form::label('Email Subject', 'Email Subject', ['class'=>'label label-primary'])}}
                         {{ Form::text('emailSubject', (!empty($campaign['sender']['name'])) ? $campaign['sender']['subject'] : $_SESSION['campaign']['name'], ['class'=>'form-control', 'placeholder'=>'Sender Subject']) }} 
                        <br>
                        <div class="form-group">
                            @if(!empty($action))
                                {{Form::submit('Next', ['class'=>'btn btn-primary'])}}
                            @else 
                                {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
                            @endif 
                        </div>  
                    <div /> 
            {{ Form::close() }}
            </div> 
        </div>  
        </div>
    </div>
</div> 
@endsection



