@extends('layouts.app')
@section('content')
    <div class="wrapper">
        <div class="row row-offcanvas row-offcanvas-left">

            <div class="column col-sm-2 col-xs-1 sidebar-offcanvas left-side-container-opposite " id="sidebar">
                @include("pages/include/contact/sidebar")
            </div>

            <div class="column col-sm-10 col-xs-11 right-side-container-opposite" id="main">
                @include('pages/include/other/submitted-form-response-one',  ['messangeName'=>'status'])
                @include('pages/include/contact/contact-form')
            </div>

        </div>
    </div>
@endsection

