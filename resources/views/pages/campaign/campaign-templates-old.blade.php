@extends('layouts.app')
@section('content')



@include('pages.include.other.campaign-header-steps',  ['currentStep' => 'Select Template'])



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" >
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Preview </h4>
            </div>
            <div class="modal-body">
                <center>
                    <img alt="100%x200" data-src="holder.js/100%x200" src="{{ url('/public/img/template/default.png') }}" data-holder-rendered="true"
                         style=" display: block; max-width: 90%" id="campaign-template-image-src" >
                </center>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
            </div>
        </div>

    </div>
</div>


    {{-- Ui --}}
    <div class="container" ng-controller="myCampaignViewCtr" ng-init="campaignDisplayByKind('newsletter')" >
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Select Template</div>
                    <div class="panel-body">

                        @if(session('status'))
                            <div class="alert alert-danger">
                                {{session('status')}}
                            </div>
                        @endif

                        <div class="bs-example" data-example-id="thumbnails-with-custom-content" id="campaign-template-preview-container">
                            <div class="row">
                                @foreach($templates as $template)
                                <div class="col-sm-6 col-md-4" >
                                    <div class="thumbnail"  style="border:1px solid grey" id="template-thumbnail-{{ $template->id }}"  >
                                        @if(!file_exists (  base_path().'/public/img/template/' . $template->id . '.png') )
                                            <img alt="100%x200" data-src="holder.js/100%x200" src="{{ url('/public/img/template/default.png') }}" data-holder-rendered="true"
                                                style="height: 200px; width: 100%; display: block;">
                                            <div class="caption">
                                                <h3>{{$template->name}}</h3>
                                                <p>
                                                    <button class="btn btn-info" role="button" data-template-id="{{$template->id}}" id="campaign-template-select" >Select</button>
                                                    <button class="btn btn-default" role="button" data-toggle="modal" data-target="#myModal" id="campaign-template-preview" data-src="{{  url('/public/img/template/default.png') }}" >Preview</button>
                                                </p>
                                            </div>
                                        @else
                                            <img alt="100%x200" data-src="holder.js/100%x200" src="{{ url('/public/img/template/' . $template->id . '.png') }}" data-holder-rendered="true"
                                                 style="height: 200px; width: 100%; display: block;">
                                            <div class="caption">
                                                <h3>{{$template->name}}</h3>
                                                <p>
                                                    <button class="btn btn-info" role="button"  data-template-id="{{$template->id}}" id="campaign-template-select"  >Select</button>
                                                    <button class="btn btn-default" role="button" data-toggle="modal" data-target="#myModal" id="campaign-template-preview" data-src="{{ url('/public/img/template/' . $template->id . '.png') }}" >Preview</button>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <form action="{{ route('user.post.campaign.choose.template') }}" method="POST"  >
                            {{csrf_field()}}
                            <input type="hidden" name="template" id="select-campaign-template"  /> <br> 
                          
                            <input type="submit" class="btn btn-info" value="Next" id="campaign-template-next-button" disabled/>
                            <small id="campaign-template-next-button-text" style="color:red"> Please select template to enable next button..</small>

                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection
