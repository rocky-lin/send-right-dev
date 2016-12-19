@extends('layouts.app') 
@section('content')  
<link rel="stylesheet" type="text/css" href="{{url('/public/css/billing.css')}}" />
<div class="container">  
    <div class="panel panel-default"> 
        <div class="panel-heading" style="text-align: left;">billing</div>
        <div class="panel-body">   
               	@include('pages/include/member/billing'); 
        </div>
    </div> 
</div> 
@endsection