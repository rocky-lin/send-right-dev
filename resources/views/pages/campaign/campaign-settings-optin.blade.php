@extends('layouts.app') 
@section('content')  
<style>
table, th, td {
    border-collapse: collapse;
}
th, td {
    padding: 1% !important;
}
th {
    width: 20%;
}
.select-option{
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px; 
    width: 15%;
    border: 1px solid whitesmoke;
}
</style>  
{!!$status!!} 
<form method="POST" action="{{route('user.campaign.create.settings.validate')}}" > 
 {{ csrf_field() }}
<input id="" type='hidden'  name='sender_name' value="{{$_SESSION['campaign']['sender']['name']}}" />
<input id="" type='hidden'  name='sender_email' value="{{$_SESSION['campaign']['sender']['email']}}" />
<input id="" type='hidden'  name='sender_subject' value="{{$_SESSION['campaign']['sender']['subject']}}" />
<input id="" type='hidden'  name='title' value="{{$_SESSION['campaign']['name']}}" /> 
<input id="" type='hidden'  name='template' value="{{$_SESSION['campaign']['template']}}" />
<input  type='hidden'  name='campaign_id' value="{{$_SESSION['campaign']['id']}}" id="campaign_id" />
<input id="" type='hidden'  name='list_ids' value="{{$_SESSION['campaign']['listIds']}}" />
<input id="" type='hidden'  name='campaign_kind' value="{{$_SESSION['campaign']['kind']}}" /> 
@include('pages.include.other.campaign-header-steps',  ['currentStep' => 'Campaign Settings']) 
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Campaign Status</h3>
    </div>
    <div class="panel-body">  
       <ul class="list-group">

          <li class="list-group-item">Active

          <input type="radio" name="campaign_status" class="pull-right"  value="active" <?php print ($_SESSION['campaign']['status']['active'] == true) ? 'checked' : null ?>/></li>
  
          <li class="list-group-item">Pending<input type="radio" name="campaign_status" class="pull-right" value="inactive" <?php print ($_SESSION['campaign']['status']['inactive'] == true) ? 'checked' : null ?> /></li>

        </ul>
    </div>  
</div>      
  <div class="panel panel-default">
      <div class="panel-heading" >
        Campaign Details
          <a href="{{route('campaign.create')}}?action=edit&id={{$_SESSION['campaign']['id']}}">
              <span class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#editIcon1" style="float: right;position: relative;"></span> 
          </a>
      </div> 
      <div class="panel-body"> 
        <table style="width:50%">
          <tr>
            <th>Name:</th>
            <td>{{$_SESSION['campaign']['name']}}</td>
          </tr>
          <tr>
            <th>Lists:</th>
            <td>{{$listNames}}</td>
          </tr>
          <tr>
            <th>Template:</th>
            <td>{{$_SESSION['campaign']['template']}}</td>
          </tr>
        </table>  
      </div>
  </div> 
  
  <div class="panel panel-default">
      <div class="panel-heading" >
        Email Optin Details 
      </div> 
      <div class="panel-body"> 
        <table style="width:100%"> 
          @foreach($optinDetails as $key => $value)
            <tr> 
              <th>{{$key}}</th>
              <td>{{$value}}</td>  
            </tr> 
          @endforeach 
        </table>  
      </div>
  </div>  
{{-- Start preview campaign  --}}
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Preview</h3>
    </div>
    <div class="panel-body">  
  <!-- Modal for preview mobile email -->
    <div class="modal fade" id="myModal1" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Campaign preview</h4>
          </div>
          <div class="modal-body" id="previewDesktopDisplay"> 
            Loading content.. 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>   
       <div class="modal fade" id="myModal2" role="dialog">
      <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Campaign preview</h4>
          </div>
          <div class="modal-body" id="previewMobileDisplay"> 
            Loading content.. 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>   
    <!-- Trigger the modal with a button -->
    <a href = "" data-toggle="modal" data-target="#myModal1" id="previewDesktop" campaign-id="{{$_SESSION['campaign']['id']}}"> Large view </a><br> 
        <a href = "" data-toggle="modal" data-target="#myModal2" id="previewMobile" campaign-id="{{$_SESSION['campaign']['id']}}">Normal View </a><br> 
    </div>  
  </div> 
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Finished</h3>
    </div>
    <div class="panel-body">
      <input class="btn btn-info" type="submit" name="submit" value="Save now" id="campaign-finish" />  
</button>
    </div>  
  </div>   
 </form>
@endsection