
    
       <div>

                        <div class="row">   
                            <div class="col-sm-6">
                                <label for="seach" > Search Campaigns </label> 
                                <input ng-model="q" id="search" class="form-control" >
                            </div>
                            <div class="col-sm-6">
                                <label for="limit show"> Show Rotal Rows </label> 
                                <select ng-model="pageSize" id="pageSize" class="form-control"  > 
                                    <option value="5">5</option>
                                    <option value="10">10</option>  
                                    @for($i=2; $i<10; $i++)
                                        <option value="{{$i*10}}">{{$i*10}}</option>
                                    @endfor
                                 </select>  
                            <div/> 
                        </div>
                    </div> 
                    <div class="row" style="margin-left:0px; margin-right:0px">
                        <div  class="col-sm-12">
                         <br> <hr>
                            <table class="table table-hover">
                                <thead>
                                    <tr> 
                                        <th>
                                            <label>Campaign Title</label> 
                                        </th> 
                                        <th>
                                            <label> Total Contacts </label>
                                        </th>
                                        <th>
                                            <label>Status</label>
                                        </th>   
                                        <th>
                                            <label>Url</label>
                                        </th>   

                                        <th>
                                            <labe> Created at </labe>
                                        </th>   
                                        <th>
                                            <label>Delete </label> 
                                        </th>
                                        <th>
                                            <label>Edit </label> 
                                        </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-hide="deleteCampaign[campaign.id]"  ng-repeat="campaign in data | filter:q | startFrom:currentPage*pageSize | limitTo:pageSize | orderBy : email" >  
                                        <td>@{{campaign.title }}</td>  
                                        <td> @{{campaign.total_contacts}} </td>
                                        <td ng-class="{'campaign-inactive': campaign.status === 'inactive', 
                                        'campaign-active' : campaign.status === 'active'}" >@{{campaign.status}}</td> 
                                        
                                        <td>
                                            <a target="_blank" href="{{url('/optin')}}/@{{campaign.optin_url}}">Open Url</a>
                                            

                                            </td>
                                        <td>@{{campaign.created_ago}}</td>
                                        <td>   
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true" data-ng-click="deleteCampaign(campaign)"></span>
                                        </td>
                                        <td>

                                             {{-- <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-ng-click="editCampaign(campaign)"></span> --}}
                                            <a href="{{url("extension/campaign/index.php?type=mobile email optin&id=")}}@{{campaign.id}}" >
                                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                             </a>
                                        </td> 
                                    </tr> 
                                </tbody>
                            </table>  
                            <button class="btn btn-info" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
                                Previous
                            </button>
                            @{{currentPage+1}}/@{{numberOfPages()}}
                            <button class="btn btn-info" ng-disabled="currentPage >= getData().length/pageSize - 1" ng-click="currentPage=currentPage+1">
                                Next
                            </button>
                        </div>
                    </div>
                </div>    

				<hr>


                            {{Form::open(['url'=>route('campaign.create'), 'method'=>'get'])}}
                                <input type="hidden" value="mobile email optin" name="ck">
                                 <button type="submit" class="btn btn-primary"> 
                                        Create email optin
                                </button>
                            {{Form::close()}}
                         
               {{--  <a href="{{ route('user.campaign.create.start')}}" title="">
                    <button type="button" class="btn btn-primary"> Add New Campaign</button>
      --}}
