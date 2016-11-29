<?php session_start(); ?>
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
                {{ Form::open(['url'=>route('user.campaign.create.sender.validate'), 'method'=>'post'], ['class'=>'form-control']) }}
                <form class="form-inline" role="form">   
                    <div class="form-group"> 
                        {{ Form::label('Sender Name', 'Sender Name', ['class'=>'label label-primary'])}}
                        {{ Form::text('senderName', Auth::user()->name, ['class'=>'form-control', 'placeholder'=>'Sender Name']) }} 
                    </div>   
                     <div class="form-group"> 
                        {{ Form::label('Sender Email', 'Sender Email', ['class'=>'label label-primary'])}}
                        {{ Form::email('senderEmail', Auth::user()->email, ['class'=>'form-control', 'placeholder'=>'Sender Email']) }} 
                    </div>   
                    <div class="form-group">
                        {{ Form::label('Email Subject', 'Email Subject', ['class'=>'label label-primary'])}}
                         {{ Form::text('emailSubject', $_SESSION['campaign']['name'], ['class'=>'form-control', 'placeholder'=>'Sender Subject']) }} 
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



