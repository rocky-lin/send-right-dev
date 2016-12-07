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
            
        @include('pages.include.other.campaign-header-steps',  ['currentStep' => 'Campaign Details'])

        <div class="bs-docs-section" ng-controller="myListConnectCtrl">  
          <div class="bs-example" style="padding-bottom: 24px;" append-source>


                @if(!empty($action))
                    {{ Form::open(['url'=>[route('user.campaign.create.update', $id)], 'method'=>'post'], ['class'=>'form-control']) }} 
                         
                @else
                    {{ Form::open(['url'=>route('user.campaign.create.validate'), 'method'=>'post'], ['class'=>'form-control']) }}
                @endif



                <form class="form-inline" role="form">   
                    <div class="form-group"> 
                        {{ Form::label('Campaign Name', 'Campaign Name', ['class'=>'label label-primary'])}}
                        {{ Form::text('campaignName', (!empty($campaign['title'])) ? $campaign['title'] : '' , ['class'=>'form-control', 'placeholder'=>'Campaign Name']) }}
                    </div>  
                    <br><br>


                    @include('pages.include.list.list-select')


                    {{--<div class="form-group">--}}
                        {{--<h3 class="label label-primary" >Select List</h3>--}}
                        {{--<input id="list-search" name='selectList' value="" type="text" class="form-control" ng-change="testChange(list)"  ng-model="selectedAddress" data-min-length="0" data-html="1" data-auto-select="true" data-animation="am-flip-x" bs-options="list as list.name for list in getLists($viewValue)" placeholder="Type keyword" bs-typeahead>--}}
                    {{--</div>--}}
                    {{--<div class="form-group">--}}
                        {{--<ul ng-model="selectAddressPreview" ng-repeat="list in lists">--}}
                            {{--<li> @{{ list.name }} </li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}


                    {{--@if(!empty($campaign))--}}
                        {{--@foreach($campaign['lists'] as $key => $list)--}}
                            {{--{{ $list }}--}}
                        {{--@endforeach--}}
                    {{--@endif--}}


                    <br><br>

                    @if(empty($campaign))
                        <div class="form-group"> 
                            {{ Form::label('template', 'Select Campaign Template', ['class'=>'label label-primary'])}}
                            {{ Form::select('template', ['Default' => 'Default','Business'=>'Business','Blog'=>'Blog'], 'list1', ['class'=>'form-control']) }} 
                        <div /> 
                    @endif
                    
                        <br>
                        <div class="form-group">
                            @if(!empty($campaign))
                                {{Form::submit('Update', ['class'=>'btn btn-primary'])}}
                            @else
                                {{Form::submit('Next', ['class'=>'btn btn-primary'])}}
                            @endif

                        </div>  
                    
            {{ Form::close() }}
            </div> 
        </div>  
        </div>
    </div>
</div> 
@endsection



