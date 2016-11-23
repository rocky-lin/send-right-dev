       <div ng-controller="myListCtr" ng-init="listId={{$listId}}">    
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
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true" data-ng-click="deleteContact(contact)"></span>   
                                        </td>
                                        <td>
                                             <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-ng-click="editContact(contact)"></span> 
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