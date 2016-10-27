@extends('layouts.app')

@section('content')
<div class="container"> 
    <div class="row">
        <div class=""> 
            <div class="panel panel-default" ng-controller="myAddContactCtrl"> 
                <div class="panel-heading">Create New Contact!</div>   
                <div class="panel-body">  
                
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif 

                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
 

                    {{ Form::open(['route' => 'contact.store', 'method'=>'post', 'name'=>'addContactFrm', 'autocomplete'=>'off'])}}   

                        <div class="form-group">
                            {{ Form::label('First Name', null, ['class' => 'control-label']) }}
                            {{Form::text('first_name', null ,['class' => 'form-control', 'ng-model'=>'firstName', 'required' ]) }}                                
                            <div style="margin-top:5px" class="alert alert-warning ng-hide" ng-show="!addContactFrm.first_name.$valid && !addContactFrm.first_name.$pristine"> First ame is required! </div>
                        </div>    

                        <div class="form-group">
                            {{ Form::label('Last Name', null, ['class' => 'control-label']) }}
                            {{Form::text('last_name', null ,['class' => 'form-control', 'ng-model'=>'lastName',  'required']) }}   
                             <div style="margin-top:5px" class="alert alert-warning ng-hide" ng-show="!addContactFrm.last_name.$valid && !addContactFrm.last_name.$pristine"> Last Name is required! </div>
                        </div>      

                        <div class="form-group">
                            {{ Form::label('Email', null, ['class' => 'control-label']) }}
                            {{Form::email('email', null ,['class' => 'form-control','ng-model'=>'frmEmail', 'required']) }}    

                            <div style="margin-top:5px" class="alert alert-warning ng-hide" ng-show="addContactFrm.email.$error.required && !addContactFrm.email.$pristine"> 
                                Email is required!  
                            </div>

                            <div style="margin-top:5px" class="alert alert-warning ng-hide" ng-show="addContactFrm.email.$error.email && !addContactFrm.email.$pristine"> 
                                Email is valid
                            </div> 



                        </div>       

                        <div class="form-group">
                            {{ Form::label('Location', null, ['class' => 'control-label']) }}
                            {{Form::text('location', null ,['class' => 'form-control']) }}   
                        </div>    

                        <div class="form-group">
                            {{ Form::label('Phone Number', null, ['class' => 'control-label']) }}
                            {{Form::text('phone_number', null ,['class' => 'form-control']) }}   
                        </div>   

                          
                         <div class="form-group">
                            {{ Form::label('Telephone Number', null, ['class' => 'control-label']) }}
                            {{Form::text('telephone_number', null ,['class' => 'form-control']) }}   
                        </div>   

                         <div class="form-group">
                            {{ Form::label('Contact Type', null, ['class' => 'control-label']) }}
                            {{Form::text('type', null ,['class' => 'form-control']) }}   
                        </div>   
    
                        <div class="form-group">
                            {{Form::submit('Create', ['class'=>'btn btn-default', 'ng-disabled'=>'addContactFrm.$invalid'])}}
                        </div> 

                        {{-- <button type="submit" class="btn btn-default">Submit</button> --}}
            
                    {{ Form::close()}} 

                </div>

                  {{-- <form> --}}
    {{-- <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password">
    </div>
    <div class="checkbox">
      <label><input type="checkbox"> Remember me</label>
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
  </form> --}}
            </div>
        </div>
    </div>
</div>
@endsection

