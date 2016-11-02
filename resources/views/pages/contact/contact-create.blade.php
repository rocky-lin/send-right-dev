@extends('layouts.app') 
@section('content')
<div class="container"> 
    <div class="row">
        <div class=""> 
            <div class="panel panel-default" ng-controller="myAddContactCtrl"> 
                <div class="panel-heading">Create New Contact</div>   
                <div class="panel-body">   
                    @include('pages.include.contact.contact-form')
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection

