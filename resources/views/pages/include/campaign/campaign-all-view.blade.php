
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Campaigns</h3>
                        </div>
                        <div class="col-md-3" style="text-align: right">
                        </div>
                        <div class="col-md-3" style="text-align: right">
                            <br>
                            {{-- <a href="{{ route('user.campaign.create.start')}}"> --}}
                            <a href="#" data-toggle="modal" data-target="#createNewCampaign">
                                <input type="button" value="Add New Campaign" class="pull-right btn btn-success" >
                            </a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <input type="button" value="Add Labels" class="pull-left btn btn-default"  data-toggle="modal" data-target="#addCampaignLabel">
                            <select ng-model="labelSelectedId" data-ng-change="assignLabel()" data-ng-show="assignLabelDropdownShow" data-ng-init="assignLabelDropdownShow=false"  name=""  style="width: 50%;margin-left: 27px;padding: 6px;border-radius: 5px;border: 1px solid #cccccc;"  >
                            <option value="">Please select label..</option>   
                            @foreach($labels as $label)
                                <option value="{{$label->id}}">{{ucfirst($label->name)}}</option>
                            @endforeach  
                        </select>
                        <i class="fa fa-spinner fa-spin" aria-hidden="true" data-ng-show="assignListShow" data-ng-init="assignListShow=false"></i>
                        </div>
                        <div class="col-md-3" style="text-align: right">
                            <div class="form-group">
                                <select class="form-control" data-ng-change="" data-ng-model="type" >
                                    <option value="" >Filter Type</option> 
                                    <option value="mobile optin">Mobile Optin</option> 
                                    <option value="newsletter">Newsletter</option> 
                                    <option value="auto responder">Auto Responder</option> 
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3" style="text-align: right">
                            {{--<input type="button" value="Add New List"  class="btn btn-success" />--}}
                            <!-- Single button --> 
                                <div class="form-group">
                                    <select class="form-control" ng-model='list.list_id_str' >
                                        <option value="">Filter By List</option>
                                        @foreach($lists as $list)
                                            <option  >{{$list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                        </div>
                        <div class="col-md-3" style="text-align: right">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="material-icons" style="font-size: 19px">search</i></span>
                                <input ng-model="q" class="form-control" placeholder="Search" aria-describedby="basic-addon1" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div> 
                    <div class="row" style="margin-left:0px; margin-right:0px">
                        <div  class="col-sm-12">
                         <br> <hr>
                            <table class="table table-hover">
                                <thead>
                                    <tr>  
                                         <th>
                                            {{-- <input type="checkbox" data-ng-click="checked_all === true? checked_all = false: checked_all=true"  /> --}}
                                            <input type="checkbox" data-ng-init="checked_all=false"  ng-model="main_checkbox" data-ng-click="checked_all === true? checked_all = false: checked_all=true;manageCheckStatus()"    />
                                        </th>  
                                        <th>
                                            <label>Campaign Title</label> 
                                        </th>
                                        <th>
                                            <label>Send Schedule </label> 
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
                                            <label>List</label> 
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
                                    <tr data-ng-hide="deleteCampaign[campaign.id]"  ng-repeat="campaign in data | filter:q | filter:type | filter:list | startFrom:currentPage*pageSize | limitTo:pageSize | orderBy : email" >  

                                        {{-- <td>  <input type="checkbox" data-ng-checked="checked_all" /> </td> --}}
                                        <td><input type="checkbox" data-ng-checked="checked_all"  data-ng-model="checked_all_model[campaign.id]" ng-click="manageCheckStatus()" /></td>

                                        <td>
                                            @{{campaign.title }}
                                            <br>
                                            <button   type="button" class="btn btn-primary" style="margin-right: 5px;margin-bottom: 5px;padding: 0px;padding: 4px;" ng-hide="campaign_label_hide[@{{label_assign.id}}]" ng-repeat="label_assign in campaign.label_assignment">
                                                @{{label_assign.name}} <span class="badge"   data-ng-click="removeCampaignFromLabel(label_assign)" >x</span>
                                            </button>

                                        </td>


                                        <td>@{{campaign.type }}</td>
                                        <td> @{{campaign.next_send}} </td> 
                                        <td> @{{campaign.total_contacts}} </td>
                                        <td ng-class="{'campaign-inactive': campaign.status === 'inactive', 
                                        'campaign-active' : campaign.status === 'active'}" >@{{campaign.status}}</td>
                                        <td>@{{campaign.kind}}</td>  
                                        <td>@{{campaign.created_ago}}</td>
                                        <td>@{{campaign.list_id_str}}</td>
                                        <td>
                                            <i class="material-icons" data-ng-click="deleteCampaign(campaign)" >delete_forever</i>
                                            {{-- <span class="glyphicon glyphicon-trash" aria-hidden="true" data-ng-click="deleteCampaign(campaign)" ></span> --}}
                                        </td>
                                        <td> 
                                            <a href="{{url("extension/campaign/index.php")}}?type=@{{campaign.kind}}&id=@{{campaign.id}}" >
                                                <i class="material-icons">mode_edit</i>
                                                {{-- <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> --}}
                                             </a> 
                                             {{-- <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-ng-click="editCampaign(campaign)"></span> --}}
                                        </td> 
                                        
                                    </tr> 
                                </tbody>
                            </table>
                            @include("pages/include/pagination/pagination")
                        </div>
                    </div>
                </div>
				<hr>     
            {{--     {{Form::open(['url'=>route('campaign.create'), 'method'=>'get'])}}
                        <input type="hidden" value="newsletter" name="ck">
                        <button type="submit" class="btn btn-primary"> 
                             Create Newsletter 
                      </button>
                {{Form::close()}} --}}
{{--                 <a href="{{ route('user.campaign.create.start')}}" title="">
                    <button type="button" class="btn btn-primary"> Add New Campaign</button>  --}}