@extends('layouts.app') 
@section('content') 
<div class="container" data-ng-controller="myProfileCtr">  
    <div class="panel panel-default"> 
        <div class="panel-heading">User profile</div>
        <div class="panel-body">   
				@include("pages/include/member/profile-view")
        </div>
    </div> 
</div> 
@endsection