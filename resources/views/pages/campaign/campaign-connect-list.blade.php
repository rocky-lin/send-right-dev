@extends('layouts.app')   
@section('content')
 
 <br><br>
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
        <div class="alert alert-danger">
            <ul>
                <li>
                    {{ session('status') }}
                </li>
            </ul>
        </div>
    @endif  
    {{-- {{$kind}}   --}} 
    <div class="row">
        <div class="col-sm-12"> 
        @include('pages.include.other.campaign-header-steps',  ['currentStep' => 'Campaign Details']) 
         <br><br>

        <div class="bs-docs-section" ng-controller="myListConnectCtrl">  

          <div class="bs-example" style="padding-bottom: 24px;" append-source> 
                @if(!empty($action))
                    {{ Form::open(['url'=>[route('user.campaign.create.update', $id)], 'method'=>'post'], ['class'=>'form-control']) }}  
                @else
                    {{ Form::open(['url'=>route('user.campaign.create.validate'), 'method'=>'post'], ['class'=>'form-control']) }}
                @endif 

                <form class="form-inline" role="form"> 
                    {{ Form::hidden('kind', $kind) }}  
                    <div class="form-group"> 
                        {{ Form::label('Campaign Name', 'Campaign Name', ['class'=>'label label-primary'])}}
                        {{ Form::text('campaignName', (!empty($campaign['title'])) ? $campaign['title'] : '' , ['class'=>'form-control', 'placeholder'=>'Campaign Name']) }}
                    </div>  

                    
                    <br><br>  
                    @include('pages/include/list/list-select')  
                    <br><br>  

                    @if(empty($campaign))
                        <div class="form-group campaign-choose-template-status" >
                            {{ Form::label('template', 'Select Campaign Template', ['class'=>'label label-primary'])}}
                        
                            <select class="form-control"  name="template" id="select-campaign-template" >
                                @foreach($campaignTemplate as $template) 
                                    <option value="{{$template->id}}">{{$template->name}}</option>
                                @endforeach
                            </select> 
                  
                            <br>  
                            <div  id="selected-campaign-template-preview-loader" style="display: none " >
                                <i class="fa fa-circle-o-notch fa-spin" style="font-size:24px;" ></i>
                                <small>Please wait..</small>
                            </div>
                            <div id="selected-campaign-template-preview-container" style="display:none" >  
                                <h3 class="template-preview-title"> Template Preview </h3>
                                <div id="selected-campaign-template-preview" class="selected-campaign-template-preview" > </div>
                            </div>
                          
                            {{-- {{ Form::select('template', ['Default' => 'Default','Business'=>'Business','Blog'=>'Blog'], 'list1', ['class'=>'form-control']) }}  --}}
                            </div>
                            @endif
                        <br> 
                        <div class="row">
                            <div class="col-md-12 pull-right " style="text-align: right;" >
                                <div class="form-group">
                                    @if(!empty($campaign))
                                        {{Form::submit('Update', ['class'=>'btn btn-success'])}}
                                    @else
                                        {{Form::submit('Next', ['class'=>'btn btn-success'])}}
                                    @endif 
                                </div> 
                            </div>
                        </div>
            {{ Form::close() }}
            </div> 
        </div>  
        </div>
    </div> 
@endsection