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

@if(!empty($contact)) 
{{ Form::open(['route' => ['contact.update', $id], 'method'=>'PATCH', 'name'=>'addContactFrm', 'autocomplete'=>'off'])}}    
@else
{{ Form::open(['route' => 'contact.store', 'method'=>'post', 'name'=>'addContactFrm', 'autocomplete'=>'off'])}}    
@endif 
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
     <div class="form-group">
        {{ Form::label('Contact Type', null, ['class' => 'control-label']) }}
        {{ Form::select('type', ['contact' => 'contact', 'subscriber' => 'subscriber'], 'contact', ['class'=>'form-control', 'ng-model'=>'contactType']) }}
    </div>     
   </div> 
 {{--        <select data-ng-model="contactType"> 
            <option data-ng-repeat="lst in list" data-ng-value="@{{lst.name}}">@{{lst.name}}</option> 
        </select>  --}}
    </div>
    <div class="form-group">
        @if(!empty($contact)) 
            {{Form::submit('Update', ['class'=>'btn btn-default', 'ng-disabled'=>'addContactFrm.$invalid'])}}
        @else
             {{Form::submit('Create', ['class'=>'btn btn-default', 'ng-disabled'=>'addContactFrm.$invalid'])}}
        @endif  
    </div>  
{{ Form::close()}}  