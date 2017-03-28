
 

@extends('layouts.app')

@section('content') 


       <?php
        $member = session('payshortcut_member');
        print_r($member);
      ?>

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
                      <div class="panel panel-default panel-body-home">
                        <div class="panel-heading">   
                            <i class="material-icons">supervisor_account</i> 
                            <span>All Contacts</span>  {{count($contacts)}} 
                            <a href="{{url('user/contact/create')}}" class="btn btn-default"> Create </a> 
                        </div>  

                        @if(count($contacts) > 0) 
                          <div class="panel-body-content"  >

                            <ul class="list-group">
                                @foreach($contacts as $contact) 
                                  @if($contact->first_name != null)
                                    <li class="list-group-item">
                                      <a href="{{url('user/contact/profile', $contact->id)}}">
                                        {{$contact->first_name}}
                                      </a>
                                    </li>   
                                  @endif
                                @endforeach
                            </ul>  
                            <div class="pull-center">  
                              <a href="{{url('user/contact')}}">
                                <input type="button" value="More.." class="btn btn-info" />
                              </a>
                            </div>
                            <br> 

                          </div> 
                        @else
                          <div class="panel-body panel-body-content"> 
                              <div>Subscriber not added yet. <a href="{{url('user/contact/create')}}"> Click here to add subscriber</a> </div> 
                          </div> 
                        @endif 
                      </div> 
                    </div> 


                <div class="col-md-4"> 
                    <div class="panel panel-default panel-body-home">
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
                    </div> 
                </div>
                <div class="panel-body panel-body-content">  
                    <div class="alert alert-info" > 
                        Use filter to see the chart
                    </div> 
                </div>
            </div>
        </div> 

        <div class="col-md-4">
            <div class="panel panel-default panel-body-home">
                <div class="panel-heading">
                    <i class="material-icons">face</i>
                    <span> Top Contacts  </span>
                    </div>
                    <div class="panel-body panel-body-content"> 
                        <div>Subscriber not added yet. <a href="#" > Click here to add subscriber</a> </div> 
                    </div>
                </div>
            </div>  
        </div> 
          
         
        
        
        
          <!-- Low level !-->     
            <div class="row"> 
                <!-- All contacts !-->  
                <div class="col-md-4">
                    <div class="panel panel-default panel-body-home"> 
                        <div class="panel-heading"> 
                            <i class="material-icons">settings_phone</i>
                            <span>Auto Responders</span>  {{count($autoResponders)}}  
                            <a href="{{url('user/campaign/create?ck=auto+responder')}}" class="btn btn-default"> Create </a>  
                        </div> 
                        @if(count($contacts) > 0) 
                          <div class="panel-body-content"  > 
                            <ul class="list-group">
                                @foreach($autoResponders as $autoResponder) 
                                  @if($autoResponder['title'] != null)
                                    <li class="list-group-item">
                                      <a href="#">
                                        {{$autoResponder['title']}}
                                      </a>

                                      <span class="pull-right">{{$autoResponder['created_ago']}}</span>


                                    </li>   
                                  @endif
                                @endforeach
                            </ul>  
                            <div class="pull-center">  
                              <a href="{{url('user/campaign/view?type=auto responder')}}">
                                <input type="button" value="More.." class="btn btn-info" />
                              </a>
                            </div>
                            <br> 

                          </div> 
                        @else
                        <div class="panel-body panel-body-content">  
                            <div class="alert alert-info" >No autoresponder found</div>
                        </div>
                        @endif 










                    </div> 
                </div>  
            <!-- All animation !-->  
            <div class="col-md-4">
                <div class="panel panel-default panel-body-home">
                    <div class="panel-heading"> 
                        <i class="material-icons">timeline</i>
                        <span>Automations</span>
                        <a href="#" class="btn btn-default"> Create </a>   
                    </div>  
                    <div class="panel-body panel-body-content">
                        <div class="alert alert-info" >No record found to list</div>
                    </div>
                </div>
            </div>      
            <!-- All campaigns !-->  
            <div class="col-md-4">
                <div class="panel panel-default panel-body-home">
                    <div class="panel-heading"> 
                        <i class="material-icons">send</i>
                        <span>Campaigns</span>
                        <a href="#" class="btn btn-default"> Create </a> 
                    </div>
                    <div class="panel-body panel-body-content"> 
                        <div class="alert alert-info" >No record found to list</div>
                    </div>
                </div>
            </div>    
        </div> <!-- end of col md 4  !-->  
         
        <!-- 3rd level !-->      
        <div class="row ">           
            <div class="col-md-4 ">
                <div class="panel panel-default panel-body-home">
                    <div class="panel-heading">   
                        <i class="material-icons">format_list_bulleted</i>
                        <span>All lists</span> {{count($lists)}}  
                        <a href="{{url('user/list/create')}}" class="btn btn-default"> Create </a>   
                    </div>   
                      @if(count($lists) > 0) 
                          <div class="panel-body-content"  > 
                            <ul class="list-group">
                                @foreach($lists as $list) 
                                  @if($list->name != null)
                                    <li class="list-group-item">
                                      <a href="{{url('user/list/' . $list->id . '/edit')}}">{{$list->name}} </a>   
                                      <span class="badge"> {{App\List1::getListTotalContact($list->id) }} </span>
                                    </li>   
                                  @endif
                                @endforeach
                            </ul>  
                            <div class="pull-center">  
                              <a href="{{url('user/list')}}">
                                <input type="button" value="More.." class="btn btn-info" />
                              </a>
                            </div>
                            <br> 

                          </div> 
                      @else
                        <div class="panel-body panel-body-content"> 
                          <div class="text-center"> Subscriber not added yet </div> 
                          <br/>  
                          <div class="text-center">  
                              <a href="{{url('user/list/create')}}">Click here to add list</a>  
                         </div> 
                        </div> 
                      @endif




                    




                </div> 
            </div>
            
            
            
            <div class="col-md-4"> 
                <div class="panel panel-default panel-body-home">
                    <div class="panel-heading">
    
                    <i class="material-icons">folder</i>
                    <span>All Forms</span>  {{count($forms)}}  
                        <a href="{{url('user/form/list/connect/view')}}" class="btn btn-default"> Create </a>   
                    <div class="btn-group"> 
                </div> 
            </div>
      


                        @if(count($forms) > 0) 
                          <div class="panel-body-content"  > 
                            <ul class="list-group">
                                @foreach($forms as $form) 
                                  @if($form->name != null)
                                    <li class="list-group-item">
                                      <a href="{{url('user/form/' . $form->id . '/contacts/view')}}">{{$form->name}} </a>    
                                    </li>   
                                  @endif
                                @endforeach
                            </ul>  
                            <div class="pull-center">  
                              <a href="{{url('user/form')}}">
                                <input type="button" value="More.." class="btn btn-info" />
                              </a>
                            </div>
                            <br> 

                          </div> 
                      @else
                        <div class="panel-body panel-body-content"> 
                          <div class="text-center"> Subscriber not added yet </div> 
                          <br/>  
                          <div class="text-center">  
                              <a href="{{url('user/form')}}">Click here to add form</a>  
                         </div> 
                        </div> 
                      @endif







            </div> 
        </div> 


            <div class="col-md-4">
              <div class="panel panel-default panel-body-home">
                  <div class="panel-heading">
                    <i class="material-icons">grid_on</i>
                    <span> Activities  </span> {{count($activities)}}
                  </div>
  
                  @if(count($activities) > 0) 
                          <div class="panel-body-content"  >

                            <ul class="list-group">
                                @foreach($activities as $activity) 
                                  @if($activity->action != null)
                                    <li class="list-group-item"> 
                                        {{$activity->action}}   
                                        <small class="alert-success">   
                                        {{$created_ago = Carbon\Carbon::createFromTimeStamp(strtotime($activity->created_at))->diffForHumans()}}
                                        </small>
                                    </li>   
                                  @endif
                                @endforeach
                            </ul>  

                            <div class="pull-center" style="display:none">  
                              <a href="#">
                                <input type="button" value="More.." class="btn btn-info" />
                              </a>
                            </div>
                            <br> 

                          </div> 
                        @else
                        <div class="panel-body panel-body-content"> 
                          <div class="alert alert-info">
                              No activities found yet
                          </div> 
                        </div>

                        @endif 

                    




                  </div>
            </div>  
          </div>  
          </div> <!-- end of row !--> 
       
      
      
      
      
      
        
      
      
      
      
      
     <div class="col-md-3 left-side-container"  >
        <br><br>
          <!-- Display create campaign button !-->   
          <!-- Large button group --> 
          <div class="btn-group" style="width:100%;" >
          <button style="width:100%;" class="btn btn-default btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Create campaign <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" style="width:100%;" >
            <li>
                <a href="{{url('user/campaign/create?ck=newsletter')}}">
                    Create Newsletter
                </a>
            </li>
            <li>
                <a href="{{url('user/campaign/create?ck=auto+responder')}}">
                    Create Auto Responder
                </a> 
            </li>
            <li>
              <a href="{{url('user/campaign/create?ck=mobile+email+optin')}}">
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