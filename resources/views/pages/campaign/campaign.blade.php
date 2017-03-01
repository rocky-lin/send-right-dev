@extends('layouts.app') 
@section('content')
<div class="container" ng-controller="myCampaignViewCtr" ng-init="campaignDisplayByKind('newsletter')" >
    <div class="row">  
        <div class="col-sm-12">

            <div class="panel panel-default">
                <div class="panel-heading">Dashboard 1</div>
                <div class="panel-body">
                    @include('pages/include/campaign/campaign-view')
            </div>


        </div>
    </div>
</div>
@endsection 
