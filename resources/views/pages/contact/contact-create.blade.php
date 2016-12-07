@extends('layouts.app')
@section('content')
<div class="container"> 
    <div class="row">
        <div class="">   
            {{-- add new contact --}}
            <div class="panel panel-default" > 
                <div class="panel-heading">Create New Contact</div>   
                <div class="panel-body">      
                    @include('pages/include/other/submitted-form-response-one',  ['messangeName'=>'status'])  
                    @include('pages.include.contact.contact-form')  
                </div>   
            </div> 
        </div>
    </div>
</div>
@endsection

