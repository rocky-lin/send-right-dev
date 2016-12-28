

<div id="billing-address">
<h1> Billing Address</h1>
<hr>

 {{Form::open(['url'=>url('/billing/address')])}}


<div class="form-group">
    {{Form::label('Your Address', 'Your Address', 'col-sm-3 control-label' )}}
    {{Form::text('address', null, ['class'=>'form-control', 'placeholder'=>'you address', 'ng-model'=>'address'])}}
</div>
<div class="form-group">
    {{Form::label('Street Address', 'Street Address', 'col-sm-3 control-label' )}}
    {{Form::text('streetAddress', null, ['class'=>'form-control', 'placeholder'=>"Street Address", 'ng-model'=>'streetAddress'])}}
</div>

<div class="form-group">
    {{Form::label('Address Line 2', 'Address Line 2', 'col-sm-3 control-label' )}}
    {{Form::text('addressLine2', null, ['class'=>'form-control', 'placeholder'=>"Address Line 2", 'ng-model'=>'addressLine2'])}}
</div>
<div class="form-group">
    {{Form::label('City', 'City', 'col-sm-3 control-label' )}}
    {{Form::text('city', null, ['class'=>'form-control', 'placeholder'=>"City",  'ng-model'=>'city'])}}
</div>
<div class="form-group">
    {{Form::label('State', 'State', 'col-sm-3 control-label' )}}
    {{Form::text('state', null, ['class'=>'form-control', 'placeholder'=>"State",  'ng-model'=>'state'])}}
</div>

<div class="form-group">
    {{Form::label('ZIP Code', 'ZIP Code', 'col-sm-3 control-label' )}}
    {{Form::text('zipCode', null, ['class'=>'form-control', 'placeholder'=>"ZIP Code",  'ng-model'=>'zipCode'])}}
</div>

<div class="form-group">
    <input type="button" ng-click="updateBillingAddress()" class="btn btn-primary" value="Submit" />
</div>

{{Form::close()}}
</div>