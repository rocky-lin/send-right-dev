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
      Sender Details
      <a href="{{route('user.campaign.create.sender.view')}}?action=edit&id={{$_SESSION['campaign']['id']}}">
    <span class="glyphicon glyphicon-pencil" data-toggle="modal" data-target="#editIcon2" style="float: right;position: relative;"></span>
  </a> 
    </div> 
    <div class="panel-body">  
      <table style="width:50%">
        <tr>
          <th>Sender Name:</th>
          <td>{{$_SESSION['campaign']['sender']['name']}}</td>
        </tr>
        <tr>
          <th>Sender Email:</th> 
          <td>{{$_SESSION['campaign']['sender']['email']}}</td>
        </tr>
        <tr>
          <th>Subject:</th>
          <td>{{$_SESSION['campaign']['sender']['subject']}}</td>
        </tr>
      </table> 
    </div>
  </div> 



@if($_SESSION['campaign']['kind'] == 'auto responder') 

  <?php   // dd($campaignSchedule);   ?>
      <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Auto Response Type</h3>
      </div>
      <div class="panel-body"> 
        <ul class="list-group">
            <li class="list-group-item">   
              <input type="radio" class="pull-right pull-right1" rel = "pullRight1" name="campaign_type" value="immediate response" id="campaign_type_direct_send"   
              {{($campaign->type == 'immediate response') ? 'checked' : null }} />
              <b>Immediate Response:</b>
            </li>
            <li class="list-group-item">   
              <input type="radio" class="pull-right pull-right2" rel = "pullRight2" name="campaign_type" value="schedule response" id="campaign_type_schedule_send"     
              {{($campaign->type == 'schedule response') ? 'checked' : null }} /> 
              <b>Schedule Response:</b> <br>   <br>    
            <div class='form-group'> 
              <label class="label label-primary" > Days </label>
              <input class='form-control' type="number" value="{{isset($campaignSchedule->days) ? $campaignSchedule->days : '0' }}" name="campaign_schedule_days" min="0" />
            </div>
             <div class='form-group'> 
              <label class="label label-primary" > Hours </label>
              <input class='form-control'  type="number" value="{{isset($campaignSchedule->hours) ? $campaignSchedule->hours : '0' }}" name="campaign_schedule_hours" min="0" />
            </div>
             <div class='form-group'> 
              <label class="label label-primary" > Mins </label>
              <input class='form-control'  type="number" value="{{isset($campaignSchedule->mins) ? $campaignSchedule->mins : '0' }}" name="campaign_schedule_mins" min="0" /> 
            </div> 
            <div style='display:none'>
              <br>
              <input  type="hidden" value="Response All Time"  name="campaign_schedule_repeat" /> 
              <br>
              <input type="hidden" name="campaign_schedule_send"  class="flatpickr flatpickr-input"  placeholder="Select Date.." data-alt-input="true" data-enable-time="true" data-alt-format="F j, Y h:i K" value="{{Carbon\Carbon::now()}}" />  
                
            </div>
          </li> 
        </ul>          
      </div>
    </div>  
@else 
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Delivery Type</h3>
      </div>
      <div class="panel-body"> 
    		<ul class="list-group">
    		    <li class="list-group-item">   
              <input type="radio" class="pull-right pull-right1" rel = "pullRight1" name="campaign_type" value="direct send" id="campaign_type_direct_send"  <?php print ($_SESSION['campaign']['delivery']['directSend']['input'] == true) ? 'checked' : null ?> />
              <b>Direct Send:</b> 
            </li>
            <li class="list-group-item">   
              <input type="radio" class="pull-right pull-right2" rel = "pullRight2" name="campaign_type" value="schedule send" id="campaign_type_schedule_send" <?php print ($_SESSION['campaign']['delivery']['scheduleSend']['input'] == true) ? 'checked' : null ?> />
              <br>
              <b>Schedule:</b> <br>   <br>  
            <div> 
              <section  id="exampleb-altInput" style = " width: 24%;"  >
                <input   name="campaign_schedule_send" type="hidden" class="flatpickr flatpickr-input"  placeholder="Select Date.." data-alt-input="true" data-enable-time="true" data-alt-format="F j, Y h:i K" value="<?php print $_SESSION['campaign']['delivery']['scheduleSend']['dateTime']; ?>" >  
             </section>  
             <br>
            <b>Repeat:</b> <br>  <br>  
              {{Form::select('campaign_schedule_repeat', ['One Time'=>'One Time', 'Daily'=>'Daily', 'Weekly'=>'Weekly', 'Monthly'=>'Monthly'], $_SESSION['campaign']['delivery']['scheduleSend']['repeat'],['class'=>'select-option'] )}}
            </div>
    			</li> 
    		</ul> 		  	 
      </div>
    </div>  
  @endif






  <!-- Analytic --> 
<div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">Email Tracking</h3>
    </div>
    <div class="panel-body">  
       <ul class="list-group">
          <li class="list-group-item">Email Reply<input type="checkbox" name="campaign_email_analytic_reply" class="pull-right" <?php print ($_SESSION['campaign']['email']['reply'] == true) ? 'checked' : null ?> /></li>
          <li class="list-group-item">Email Open/Read<input type="checkbox" name="campaign_email_analytic_open" class="pull-right" <?php print ($_SESSION['campaign']['email']['openOrRead'] == true) ? 'checked' : null ?> /></li>   
          <li class="list-group-item">Email Click Link<input type="checkbox" name="campaign_email_analytic_click_link" class="pull-right" <?php print ($_SESSION['campaign']['email']['clickLink'] == true) ? 'checked' : null ?> /></li>   
        </ul>
    </div>  
</div>    
<div class="panel panel-default">
    <div class="panel-heading"> 
      <h3 class="panel-title">Send Test Email</h3>
    </div>
    <div class="panel-body">   
      <div class="form-group" >
        <input type="email" name="test_email" value="" id="test_email" class="form-control" placeholder="Place email address that will receive the test email campaign." />
      </div>
      <input class="btn btn-default" type="button" name="submit" value="Send Test" id="campaign-send-test" /> <span id="campaign-send-test-status"> </span>

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