@extends('layouts.app')  
@section('content')
 
<div class="container"  > 
    <div class="row">
        <div class="col-sm-12">     
        <div class="bs-docs-section" ng-controller="TypeaheadDemoCtrl">  
          <div class="bs-example" style="padding-bottom: 24px;" append-source>


                {{ Form::open(['url'=>route('user.form.register.step1'), 'method'=>'post'], ['class'=>'form-control']) }}
                <form class="form-inline" role="form">   
                    <div class="form-group"> 
                        {{ Form::label('Form Name', 'Form Name', ['class'=>'label label-primary'])}}
                        {{ Form::text('formName', '', ['class'=>'form-control', 'placeholder'=>'Form Name']) }} 
                    </div>  
                    <br><br>
                    <div class="form-group">
                        <h3 class="label label-primary" >Select List</h3>
                        <input name='selectedList' type="text" class="form-control" ng-model="selectedAddress" data-min-length="0" data-html="1" data-auto-select="true" data-animation="am-flip-x" bs-options="list as list.name for list in getLists($viewValue)" placeholder="Type keyword" bs-typeahead>
                    </div>    
                    <br><br>
                    <div class="form-group">
                        {{ Form::label('template', 'Select Form Template', ['class'=>'label label-primary'])}}
                        {{ Form::select('template', ['Default','Business','Blog'], 'list1', ['class'=>'form-control']) }} 
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



