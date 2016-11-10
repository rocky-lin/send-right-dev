@extends('layouts.app')  
@section('content')
<div class="container"> 
    <div class="row">
        <div class="">    
            <div class="panel panel-default" > 
                <div class="panel-heading">Import Contact via .csv </div>   
                <div class="panel-body">       
                   @include('pages/include/other/submitted-form-response-one', ['messangeName'=>'status1'])  
                   @include('pages/include/contact/contact-import-file') 
                </div>   
            </div> 
        </div>
    </div>
</div>
@endsection

