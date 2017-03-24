@extends('layouts.app')
@section('content') 
<style>
.checkbox label:after, 
.radio label:after {
    content: '';
    display: table;
    clear: both;
}

.checkbox .cr,
.radio .cr {
    position: relative;
    display: inline-block;
    border: 1px solid #a9a9a9;
    border-radius: .25em;
    width: 1.3em;
    height: 1.3em;
    float: left;
    margin-right: .5em;
}

.radio .cr {
    border-radius: 50%;
}

.checkbox .cr .cr-icon,
.radio .cr .cr-icon {
    position: absolute;
    font-size: .8em;
    line-height: 0;
    top: 50%;
    left: 20%;
}

.radio .cr .cr-icon {
    margin-left: 0.04em;
}

.checkbox label input[type="checkbox"],
.radio label input[type="radio"] {
    display: none;
}

.checkbox label input[type="checkbox"] + .cr > .cr-icon,
.radio label input[type="radio"] + .cr > .cr-icon {
    transform: scale(3) rotateZ(-20deg);
    opacity: 0;
    transition: all .3s ease-in;
}

.checkbox label input[type="checkbox"]:checked + .cr > .cr-icon,
.radio label input[type="radio"]:checked + .cr > .cr-icon {
    transform: scale(1) rotateZ(0deg);
    opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled + .cr,
.radio label input[type="radio"]:disabled + .cr {
    opacity: .5;
}

</style>
 
<div class="container-full">  
 		<br><br>
		<div>
	  		<h3>Where do you want to import contacts form?</h3>
	    <hr/>   

	    <form action="{{route('user.contact.import.choose.post')}}" method="post" >
	    {{csrf_field()}}
	    <div class="col-sm-12">
	        <br><br>
	        <div class="radio">
	          <label>
	            <input type="radio" name="import_contact" value="csv_txt" checked>
	            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok-sign"></i></span>
	         	 <b>CSV or tab-delimited text file  </b>
	          </label>
	          	<br>
	             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	             <small>Import contact from .csv or txt file </small>
	        </div>

	        <br><br>
	        <div class="radio">
	          <label>
	            <input type="radio" name="o1" value="xls"  name="import_contact"   disabled="">
	            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok-sign"></i></span>
	         	<b>Copy/paste from file</b>
	          </label>
	          	<br>
	             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	             <small>Copy and paste contact from .xls or xlsx files </small>
	        </div>
	        <br><br>

	        <div class="radio">
	          <label>
	            <input type="radio" name="o1" value="service"  name="import_contact" disabled=""> 
	            <span class="cr"><i class="cr-icon glyphicon glyphicon-ok-sign"></i></span>
	         	<b>Integrated service</b>
	          </label>
	          	<br>
	             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	             <small>Import contact from service like google contact, salesforce, zendesk and more..</small>
	        </div> 

	        <br><br><br><br> 
			<br><br><br> 
	        <input type="submit" value="Next" class="btn btn-success pull-right" />
	    </div> 
 
	    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	</div> 
@endsection

