@extends('layouts.app')
@section('content')
    <div class="row">
        <!-- left content as sidebar -->
        <div class="col-sm-2 ">
            @include("pages/include/form/form-sidebar")
        </div>
        <div class="col-sm-10 right-side-container-opposite"  >
            @include('pages/include/form/form-view')
        </div>
    </div>
@endsection 