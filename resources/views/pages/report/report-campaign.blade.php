@extends('layouts.app')
@section('content')
    <div class="row" ng-controller="reportCampaignViewCtr" ng-init="campaignDisplayByKind('all')" >   
        <div class="col-sm-2 ">
            @include("pages/include/sidebar/report-campaign-sidebar")
        </div>
        <div class="col-sm-10 right-side-container-opposite"  >
            @include('pages/include/campaign/report-campaign-all-view')
        </div>
    </div>
@endsection
