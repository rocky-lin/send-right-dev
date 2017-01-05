@extends('layouts.app') 
@section('content') 
<div class="container" ng-controller="myCampaignViewCtr" ng-init="campaignDisplayByKind('mobile email optin')" >
    <div class="row"> 
        <div class="col-sm-12"> 
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    @include('pages/include/campaign/campaign-mobile-optin-view')
            </div> 
        </div>
    </div>
</div>
@endsection 
