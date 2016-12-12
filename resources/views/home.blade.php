@extends('layouts.app')

@section('content')
    <div class="container"> 
        <div class="row"> 

            {{-- status display --}}
            @if(Auth::user()->status == 'inactive') 
                <div class="alert alert-danger"  > {{  "your account is currently in active, please visit your email and hit comfirm, thank you!" }} </div>
            @endif  
 
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
                                     
                                    </div>
                                </div> 
                                <div class="portlet">
                                    <div class="portlet-header">Lists</div>
                                    <div class="portlet-content" id="home-list-preview" >Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
                                </div> 
                                <div class="portlet">
                                    <div class="portlet-header"  >Campaign</div>
                                    <div class="portlet-content" id="home-campaign-preview" >Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
                                </div> 
                            </div>
                        </div>  
                        <div class="column col-sm-6">   
                            <div class="column" > 
                                <div class="portlet">
                                    <div class="portlet-header">Contacts</div>
                                    <div class="portlet-content" id="home-contact-preview" >Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
                                </div> 
                                <div class="portlet">
                                    <div class="portlet-header">Forms</div>
                                    <div class="portlet-content" id="home-form-preview" >Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
                                </div> 
                                <div class="portlet">
                                    <div class="portlet-header">Statistics</div>
                                    <div class="portlet-content" id="home-statistic-preview">Lorem ipsum dolor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit olor sit ameasdasd asd asd asd asda sas dast, consectetuerit ameasdasd asd asd asd asda sas dast, consectetuerit ameasdasd asd asd asd asda sas dast, consectetuer adipiscing elit</div>
                                </div> 
                            </div>
                        </div>  
                    </div>  
                </div>
            </div>  

        </div>
    </div> 
@endsection
