       <div ng-controller="myListCtr" ng-init="listId={{$listId}}">    


                    {{--     @{{pageSize}}
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
                    </div> --}}

                        <div class="col-md-9"> </div>
                        <div class="col-md-3" style="text-align: right">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1"><i class="material-icons" style="font-size: 19px">search</i></span>
                                <input ng-model="q" class="form-control" placeholder="Search" aria-describedby="basic-addon1" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                            </div>
                        </div>
                        <br><br><br> 

                    <div class="row" style="margin-left:0px; margin-right:0px"> 
                        <div  class="col-sm-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                        <label>First Name </label>
                                          <a href="#" title="First Name" data-toggle="popover" data-trigger="hover" data-content="First name of your contact.">(?)</a>  
                                        </th>
                                        <th> 
                                            <label>Email </label>
                                            <a href="#" title="Email" data-toggle="popover" data-trigger="hover" data-content="Email of your contact.">(?)</a> 
                                        </th>
                                        <th> 
                                            <label>Contact Type </label>
                                            <a href="#" title="Email" data-toggle="popover" data-trigger="hover" data-content="Type of your contact, subscriber or contact">(?)</a> 
                                        </th> 
                                        <th> 
                                            <label>Delete </label>
                                            <a href="#" title="Delete" data-toggle="popover" data-trigger="hover" data-content="Delete your contact forever.">(?)</a> 
                                        </th>
                                        <th>
                                            <label>Edit </label>
                                            <a href="#" title="Edit" data-toggle="popover" data-trigger="hover" data-content="Update your contact.">(?)</a> 
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-hide="deleteContact[contact.id]"  ng-repeat="contact in data | filter:q | startFrom:currentPage*pageSize | limitTo:pageSize | orderBy : email" >
                                        <td>@{{contact.first_name}} @{{contact.last_name}}</td>
                                        <td>@{{contact.email}}</td>
                                        <td>@{{contact.type}} </td>  
                                        <td>   
                                            <i class="material-icons" data-ng-click="deleteContact(contact)" >delete_forever</i> 
                                            {{-- <span class="glyphicon glyphicon-trash" aria-hidden="true" ></span>    --}}
                                        </td>
                                        <td>
                                            <i class="material-icons"  data-ng-click="editContact(contact)" >mode_edit</i>  
                                            {{-- <span class="glyphicon glyphicon-pencil" aria-hidden="true" ></span>  --}}
                                        </td>
                                    </tr> 
                                </tbody>
                            </table>    
                        </div>    
                        
                        @include("pages/include/pagination/pagination")  

                        {{-- <div class="row">
                            <div class="col-md-12 pull-center"> 
                                <hr> 
                                <button class="btn btn-default" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
                                    Previous
                                </button> 
                                @{{currentPage+1}} / @{{numberOfPages()}}
                                <button class="btn btn-default" ng-disabled="currentPage >= getData().length/pageSize - 1" ng-click="currentPage=currentPage+1">
                                    Next
                                </button> 
                                <div class="pager-container" >
                                    <select class="pager-select" ng-model="pageSize" data-ng-value="20" data-ng-init="pageSize=20" >
                                        <option value="20">20 per page</option>
                                        <option value="50">50 per page</option>
                                        <option value="100">100 per page</option>
                                        <option value="200">200 per page</option> 
                                    </select> 
                                </div> 
                            </div>
                        </div> --}}


                        <br><br> 
                    </div>
                </div> 