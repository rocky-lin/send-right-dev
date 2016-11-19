       <div ng-controller="myFormViewCtr">    
                    <h3>Your total forms  @{{ totalForm }} </h3>
                        <div class="row">   
                            <div class="col-sm-6">
                                <label for="seach" > Search Forms </label> 
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
                                        <label>Name</label>
                                          <a href="#" title="First Name" data-toggle="popover" data-trigger="hover" data-content="First name of your form.">(?)</a>  
                                        </th>  

                                        <th> 
                                            <label>View </label>
                                            <a href="#" title="Delete" data-toggle="popover" data-trigger="hover" data-content="Delete your form forever.">(?)</a> 
                                        </th>
                                        <th>
                                            <label>Edit </label>
                                            <a href="#" title="Edit" data-toggle="popover" data-trigger="hover" data-content="Update your form.">(?)</a> 
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-hide="deleteForm[form.id]"  ng-repeat="form in data | filter:q | startFrom:currentPage*pageSize | limitTo:pageSize | orderBy : email" >
                                        <td>@{{form.name}} </td>  
                                        <td>    
                                            <span class="glyphicon glyphicon-eye-open" aria-hidden="true" data-ng-click="viewNowForm(form)"></span>     
                                        </td> 
                                        <td>   
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true" data-ng-click="deleteForm(form)"></span>   
                                        </td>
                                        <td>
                                             <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-ng-click="editForm(form)"></span> 
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
                {{-- <a href="{{ url('extension/form/create/editor/index.php') }}" title=""> --}}
                <a href="{{ route('user.form.list.connect.view') }}" title=""> 
                    <button type="button" class="btn btn-primary"> Add New Forms</button>
                </a> 
         