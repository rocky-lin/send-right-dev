@extends('layouts.app') 
@section('content')
<div class="container"> 
    <div class="row">
        <div class=""> 
            <div class="panel panel-default" ng-controller="myEditContactCtrl" > 
                <div class="panel-heading">Edit Current Contact</div>    
                <div class="panel-body" data-ng-init="contactId={{$id}}">      
                    @include('pages.include.contact.contact-form', ['contact' => $contact, 'id'=>$id])
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection 
