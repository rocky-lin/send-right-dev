@extends('layouts.app')

@section('content')
    <div class="container"> 
        <div class="row"> 
            {{-- status display --}}

            {{-- Start panel --}}
            <div class="panel panel-default"> 
                <div class="panel-heading">Dashboard</div>   
                <div class="panel-body">   
                    <div class="row "> 
                        <div class="column col-sm-6">   
                            <div class="column" > 
                                <div class="portlet">
                                    <div class="portlet-header">Activity</div>
                                    <div class="portlet-content" id="home-activity-preview">
                                        <br><br><br><br>
                                        <center>
                                            Loading activities...
                                        </center>
                                    </div>
                                </div> 
                                <div class="portlet">
                                    <div class="portlet-header">Lists</div>
                                    <div class="portlet-content" id="home-list-preview" >
                                        <br><br><br><br>
                                        <center>
                                        Loading lists...
                                        </center>
                                    </div>
                                </div> 
                                <div class="portlet">
                                    <div class="portlet-header"  >Campaign</div>
                                    <div class="portlet-content" id="home-campaign-preview" >
                                        <br><br><br><br>
                                        <center>
                                        Loading campaigns...
                                        </center>
                                    </div>
                                </div> 
                            </div>
                        </div>  
                        <div class="column col-sm-6">   
                            <div class="column" > 
                                <div class="portlet">
                                    <div class="portlet-header">Contacts</div>
                                    <div class="portlet-content" id="home-contact-preview" >
                                        <br><br><br><br>
                                        <center>
                                            Loading contacts...
                                        </center>
                                    </div>
                                </div> 
                                <div class="portlet">
                                    <div class="portlet-header">Forms</div>
                                    <div class="portlet-content" id="home-form-preview" >
                                        <br><br><br><br>
                                        <center>
                                            Loading forms...
                                        </center>
                                    </div>
                                </div> 
                                <div class="portlet">
                                    <div class="portlet-header">Statistics</div>
                                    <div class="portlet-content" id="home-statistic-preview">
                                        <br><br><br><br>
                                        <center>
                                            Loading statistics...
                                        </center>
                                    </div>
                                </div> 
                            </div>
                        </div>  
                    </div>  
                </div>
            </div>  
        </div>
    </div> 
@endsection