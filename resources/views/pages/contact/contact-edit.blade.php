@extends('layouts.app') 
@section('content')
<div class="container"> 
    <div class="row">
        <div class=""> 
            <div class="panel panel-default" > 
                <div class="panel-heading">Edit Current Contact</div>    
                <div class="panel-body">      
                    @include('pages.include.contact.contact-form', ['contact' => $contact, 'id'=>$id])
                </div> 
            </div>
        </div>
    </div>
</div>
@endsection 
