@extends('layouts.app')
@section('content')
    <div class="row" ng-controller="myCampaignViewCtr" ng-init="campaignDisplayByKind('all')" >  		 
		{{Support\Popup::campaign_add_label()}}   
        <div class="col-sm-2 ">
            @include("pages/include/campaign/campaign-sidebar")
        </div>
        <div class="col-sm-10 right-side-container-opposite"  >
            @include('pages/include/campaign/campaign-all-view')
        </div>
    </div>
@endsection
