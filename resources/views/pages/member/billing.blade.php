@extends('layouts.app') 
@section('content')  
<link rel="stylesheet" type="text/css" href="{{url('/public/css/billing.css')}}" />
<div class="container">
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#home">Subscription</a></li>
            <li><a data-toggle="tab" href="#menu1">Invoice</a></li>
        </ul>
        <div class="tab-content">
            <div id="home" class="tab-pane fade in active">
                <div class="panel panel-default">
                    <div class="panel-heading" style="text-align: left;">billing</div>
                    <div class="panel-body">
                        @include('pages/include/member/billing');
                    </div>
                </div>
            </div>
            <div id="menu1" class="tab-pane fade">
                List of invoice here..
            </div>
        </div>
    </div>
</div> 
@endsection