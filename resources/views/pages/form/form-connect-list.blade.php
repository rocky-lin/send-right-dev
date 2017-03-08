@extends('layouts.app')  
@section('content')
    <br><br>
    @include('errors/error-status')
    <div class="row">
        <div class="col-sm-12">
            <div class="bs-docs-section" ng-controller="myListConnectCtrl">
                <div class="bs-example" style="padding-bottom: 24px;" append-source>
                {{ Form::open(['url'=>route('user.form.register.step1'), 'method'=>'post'], ['class'=>'form-control']) }}
                    <div class="form-group">
                        {{ Form::label('Form Name', 'Form Name', ['class'=>'label label-primary'])}}
                        {{ Form::text('formName', '', ['class'=>'form-control', 'placeholder'=>'Form Name']) }}
                    </div>
                    <br><br>
                    <div class="form-group">
                        {{ Form::label('Select Auto Response', 'Select Auto Response', ['class'=>'label label-primary'])}}
                        {{ Form::select('selectedAutoResponse', $autoRespondersArr, null, ['class'=>'form-control'])}}
                    </div>
                    <br><br>
                    <div class="form-group">
                        <h3 class="label label-primary" >Select List</h3>


                        <select class="form-control" name='selectedList' >

                            <option value="">Select..</option>

                            @foreach($lists  as $list)
                                <option value="{{$list->name}}">{{$list->name}}</option>
                            @endforeach
                        </select>
                        {{--<input name='selectedList' type="text" class="form-control" ng-model="selectedAddress" data-min-length="0" data-html="1" data-auto-select="true" data-animation="am-flip-x" bs-options="list as list.name for list in getLists($viewValue)" placeholder="Type keyword" bs-typeahead>--}}
                    </div>
                    <br><br>
                    <div class="form-group">
                        {{ Form::label('template', 'Select Form Template', ['class'=>'label label-primary'])}}
                        {{ Form::select('template', ['Default','Business','Blog'], 'list1', ['class'=>'form-control']) }}
                        <br>
                        <div class="form-group">
                            {{Form::submit('Next', ['class'=>'btn btn-primary'])}}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
            </div>
        </div>
    </div>
    <div style="height: 100px;"> </div>
@endsection



