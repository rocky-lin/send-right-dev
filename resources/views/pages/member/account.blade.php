@extends('layouts.app') 
@section('content') 
<div class="container"  data-ng-controller="myUserAccountCtrl">   
    <div class="panel panel-default"> 
        <div class="panel-heading">Account</div>
        <div class="panel-body">     
               	@include('pages/include/member/profile-edit'); 
               	@include('pages/include/member/change-password'); 
        </div>
    </div> 
</div> 
@endsection