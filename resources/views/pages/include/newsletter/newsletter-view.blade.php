       <div ng-controller="myCampaignViewCtr">
                    <h3>Your total contact  @{{ totalContact }} </h3>
                        <div class="row">   
                            <div class="col-sm-6">
                                <label for="seach" > Search Contacts </label> 
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
                                            <label>Sender Email </label> 
                                        </th>
                                        <th>
                                            <label>Sender Subject </label> 
                                        </th>
                                        <th>
                                            <label>Campaign Title</label> 
                                        </th>
                                        <th>
                                            <label>Campaign Type </label> 
                                        </th>
                                        <th>
                                            <label>Next Send</label>
                                        </th>
                                        <th>
                                            <label> Total Contacts </label>
                                        </th>
                                        <th>
                                            <label>Status</label>
                                        </th>
                                        <th>
                                            <label>Type</label>
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
                                        <td>@{{campaign.sender_email }}</td>
                                        <td>@{{campaign.sender_subject}}</td>
                                        <td>@{{campaign.title }}</td>
                                        <td>@{{campaign.type }}</td> 
                                        <td> @{{campaign.next_send}} </td> 
                                        <td> @{{campaign.total_contacts}} </td>
                                        <td ng-class="{'campaign-inactive': campaign.status === 'inactive', 
                                        'campaign-active' : campaign.status === 'active'}" >@{{campaign.status}}</td>
                                        <td>@{{campaign.type}}</td> 
                                        <td>@{{campaign.created_ago}}</td>
                                        <td>   
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true" data-ng-click="deleteCampaign(campaign)"></span>
                                        </td>
                                        <td>
                                             <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-ng-click="editCampaign(campaign)"></span>
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
                <a href="{{ route('campaign.create')}}" title="">
                    <button type="button" class="btn btn-primary"> Add New Campaign</button>
         