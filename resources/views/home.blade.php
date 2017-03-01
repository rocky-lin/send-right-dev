@extends('layouts.app')

@section('content') 
   <div class="row main-row-container">  
      <div class="col-md-9 right-side-container">  


        <br><br>
         <div class="alert alert-danger" role="alert">   

            <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>  

        "Oops, there seem to be an error in your billing, Don't worry!  Your email list and campaigns are fine! We just need to sort out a billing issue first.   Please <a href="#">CLICK HERE</a> to update your billing."
        </div>


          <!-- Top level !-->
          <div class="row ">           
            <div class="col-md-4 ">
              <div class="panel panel-default">
    <div class="panel-heading">  
                
                <i class="material-icons">supervisor_account</i>
                <span>All Contacts</span>
                <a href="#" class="btn btn-default"> Create </a>
                
                </div>
                
      <div class="panel-body">
      
      <div class="text-center"> Subscriber not added yet </div>
      
       <br/> 
      
       <div class="text-center">  
        <a href="#">Click here to add subscriber</a>  
      </div>
                
                
                </div>
              </div>

            </div>
            
            
            
            <div class="col-md-4">

<div class="panel panel-default">
  <div class="panel-heading">
    
              <i class="material-icons">pie_chart</i>
                <span>Contact Chart</span> 
                <!-- Single button -->



<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Today <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Today</a></li>
    <li><a href="#">Yesterday</a></li>
    <li><a href="#">Last Week</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Last Month</a></li>
  </ul>
</div>


<div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
    <li><a href="#">Today</a></li>
    <li><a href="#">Yesterday</a></li>
    <li><a href="#">Last Week</a></li>
    <li role="separator" class="divider"></li>
    <li><a href="#">Last Month</a></li>
  </ul>
</div>


  </div>
    <div class="panel-body">  
      <div class="alert alert-info" > 
        Use filter to see the chart
      </div>
  
  </div>
</div>
            </div>
            
            
            
            
            <div class="col-md-4">
<div class="panel panel-default">
    <div class="panel-heading">
      <i class="material-icons">face</i>
      <span> Top Contacts  </span>
  </div>
    <div class="panel-body"> 
      <div>
        Subscriber not added yet. <a href="#"> Click here to add subscriber</a>
      </div>
  
  </div>
</div>
            </div> 
            
             
          </div> 
          
          
          <!-- Low level !-->
          
          
           
          
              <div class="row">
         
            
            
            <div class="col-md-4">
              <div class="panel panel-default">
    <div class="panel-heading">
      
      
               <i class="material-icons">settings_phone</i>
                <span>Auto Responders</span>
                <a href="#" class="btn btn-default"> Create </a>
                
                </div>
    <div class="panel-body"> 
                
                <div class="alert alert-info" >No autoresponder found</div>
                </div>
              </div>

            </div>
            
            
            
            <div class="col-md-4">
<div class="panel panel-default">
  <div class="panel-heading">
    
    
      
 <i class="material-icons">timeline</i>
                <span>Automations</span>
                <a href="#" class="btn btn-default"> Create </a>
    
  </div>
    <div class="panel-body">
  <div class="alert alert-info" >No record found to list</div>
  </div>
</div>
            </div>
            
            
            <div class="col-md-4">
<div class="panel panel-default">
    <div class="panel-heading">
  
<i class="material-icons">perm_media</i>
                <span>Campaigns</span>
                <a href="#" class="btn btn-default"> Create </a>
      
      
  </div>
    <div class="panel-body">
  
    <div class="alert alert-info" >No record found to list</div>
  </div>
</div>
            </div> 
            
             
          </div> 
          
          
              
         </div>
      
     <div class="col-md-3 left-side-container"  >
        <br><br>
          <!-- Display create campaign button !-->  
          
          <!-- Large button group -->
          
          <div class="btn-group" style="width:100%;" >
          <button style="width:100%;" class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Large button <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" style="width:100%;" >
            <li>
              <a href="#">
                Create Newsletter
              </a>
            </li>
            <li>
              <a href="#">
                Create Auto Responder
              </a> 
            </li>
            <li>
              <a href="#">
                Create Mobile Optin
              </a> 
            </li>
          </ul>
        </div>
      <br/><br/>
         
          <!-- Display activities !--> 
            <div class="list-group">
              <a href="#" class="list-group-item">
              <i class="material-icons">event</i>
                Dapibus ac facilisis in
              </a>
              <a href="#" class="list-group-item">
                <i class="material-icons">exit_to_app</i>
                Morbi leo risus
              </a>
              <a href="#" class="list-group-item">
                <i class="material-icons">extension</i>
                Porta ac consectetur ac
              </a>
              <a href="#" class="list-group-item">
                <i class="material-icons">flip_to_front</i>
                Vestibulum at eros
              </a>
              <a href="#" class="list-group-item">
               <i class="material-icons">schedule</i>
                Vestibulum at eros 
              </a>
            </div> 
           <center>
             <button class="btn btn-default" >  
               Load More.. 
              <i class="material-icons">swap_vert</i>
             </button>
           </center>

       
     
         </div>
      </div>  
  
@endsection