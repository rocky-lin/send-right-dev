


@if(!empty($contact)) 
<div ng-controller="myEditContactCtrl" data-ng-init="contactId={{$id}}" >  
{{ Form::open(['route' => ['contact.update', $id], 'method'=>'PATCH', 'name'=>'addContactFrm', 'autocomplete'=>'off'])}}    
@else
<div ng-controller="myAddContactCtrl">
{{ Form::open(['route' => 'contact.store', 'method'=>'post', 'name'=>'addContactFrm', 'autocomplete'=>'off'])}}    
@endif 

    <h3>Contact Details</h3>
    <br><br>

    <div class="form-group">
        {{ Form::label('Email', null, ['class' => 'control-label']) }}
        {{Form::email('email', null ,['class' => 'form-control', 'ng-model'=>'email', 'required']) }}     
        <div style="margin-top:5px" class="alert alert-warning ng-hide" ng-show="addContactFrm.email.$error.required && !addContactFrm.email.$pristine"> 
            Email is required!  
        </div> 
        <div style="margin-top:5px" class="alert alert-warning ng-hide" ng-show="addContactFrm.email.$error.email && !addContactFrm.email.$pristine"> 
            Email is valid
        </div>  
    </div>      
    <div class="form-group">
        {{ Form::label('First Name', null, ['class' => 'control-label']) }}
        {{Form::text('first_name', null, ['class' => 'form-control', 'ng-model'=>'firstName', 'required' ]) }}                                
        <div style="margin-top:5px" class="alert alert-warning ng-hide" ng-show="!addContactFrm.first_name.$valid && !addContactFrm.first_name.$pristine"> First ame is required! </div>
    </div>     
    <div class="form-group">
        {{ Form::label('Last Name', null, ['class' => 'control-label']) }}
        {{Form::text('last_name', null ,['class' => 'form-control', 'ng-model'=>'lastName',  'required']) }}   
         <div style="margin-top:5px" class="alert alert-warning ng-hide" ng-show="!addContactFrm.last_name.$valid && !addContactFrm.last_name.$pristine"> Last Name is required! </div>
    </div>      
    <br><br>
    <hr>
    <br><br> 
    <div class="form-group">
        {{ Form::label('Location', null, ['class' => 'control-label']) }}
        {{Form::text('location', null ,['class' => 'form-control', 'ng-model'=>'location']) }}   
    </div>     
    <div class="form-group">
        {{ Form::label('Phone Number', null, ['class' => 'control-label']) }}
        {{Form::text('phone_number', null ,['class' => 'form-control', 'ng-model'=>'phoneNumber']) }}   
    </div>    
     <div class="form-group">
        {{ Form::label('Telephone Number', null, ['class' => 'control-label']) }}
        {{Form::text('telephone_number', null ,['class' => 'form-control', 'ng-model'=>'telephoneNumber']) }}   
    </div>    

 
        @if(!empty($contact))  
             <div class="form-group">
                {{ Form::label('Contact Type', null, ['class' => 'control-label']) }}
                {{ Form::select('type', ['contact' => 'contact', 'subscriber' => 'subscriber'], 'contact', ['class'=>'form-control', 'ng-model'=>'contactType']) }}
            </div>                 
        @else
                <div class="form-group">
                {{ Form::label('Contact Type', null, ['class' => 'control-label']) }}
                {{ Form::select('type', ['contact' => 'contact', 'subscriber' => 'subscriber'], 'contact', ['class'=>'form-control']) }}
            </div> 
        @endif  



        <br>
        <div class="form-group"> 
            <label class="control-label"> Custom Field 1</label> <small>(coming soon..)</small>
             <input type="text" class="form-control" disabled="" />
        </div>      
        <br>
        <div class="form-group"> 
            <label class="control-label"> Custom Field 2</label> <small>(coming soon..)</small>
             <input type="text" class="form-control" disabled="" />
        </div>      
        <br>
        <div class="form-group"> 
            <label class="control-label"> Custom Field 3</label> <small>(coming soon..)</small>
             <input type="text" class="form-control" disabled="" />
        </div>     



   </div>  
    <div class="form-group">
        @if(!empty($contact)) 
            {{Form::submit('Update', ['class'=>'btn btn-default', 'ng-disabled'=>'addContactFrm.$invalid'])}}
        @else
             {{Form::submit('Create', ['class'=>'btn btn-default', 'ng-disabled'=>'addContactFrm.$invalid'])}}
        @endif  
    </div>   
   
{{ Form::close()}}  
 