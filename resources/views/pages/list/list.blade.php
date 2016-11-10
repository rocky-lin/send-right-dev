@extends('layouts.app') 
@section('content')
<div class="container"> 
    <div class="row">
        <div class="col-sm-12"> 
            <div class="panel panel-default"> 
                <div class="panel-heading">Dashboard</div>   
                <div class="panel-body">  
                <div ng-controller="myListsViewCtr">    

                        
                        <h3>Your total list  @{{ totalList }} </h3>
                       

                        <div class="row">   
                            <div class="col-sm-6">
                                <label for="seach" > Search Lists </label> 
                                <input ng-model="q" id="search" class="form-control" >
                            </div>
                            <div class="col-sm-6">
                                <label for="limit show"> Show Rotal Rows </label> 
                                <select ng-model="pageSize" id="pageSize" class="form-control"  > 
                                    <option value="5">5</option>
                                    <option value="10">10</option>  
                                    @for($i=2; $i<10; $i++)  <option value="{{$i*10}}">{{$i*10}}</option>    @endfor
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
                                          <a href="#" title="First Name" data-toggle="popover" data-trigger="hover" data-content="First name of your list.">(?)</a>  
                                        </th>
                                        <th> 
                                            <label>Total List Contacts</label>
                                            <a href="#" title="Email" data-toggle="popover" data-trigger="hover" data-content="Email of your list.">(?)</a> 
                                        </th> 
                                        <th> 
                                            <label>Delete </label>
                                            <a href="#" title="Delete" data-toggle="popover" data-trigger="hover" data-content="Delete your list forever.">(?)</a> 
                                        </th>
                                        <th>
                                            <label>Edit </label>
                                            <a href="#" title="Edit" data-toggle="popover" data-trigger="hover" data-content="Update your list.">(?)</a> 
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-hide="deleteList[list.id]"  ng-repeat="list in data | filter:q | startFrom:currentPage*pageSize | limitTo:pageSize | orderBy : email" >
                                        <td>@{{list.name}}  </td>
                                        <td>@{{list.contact_total}}</td> 

                                        <td>   
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true" data-ng-click="deleteList(list)"></span>   
                                        </td>
                                        <td>
                                             <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-ng-click="editList(list)"></span> 
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
                <a href="{{ route('list.create')}}" title="">
                    <button type="button" class="btn btn-primary"> Add New List</button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 