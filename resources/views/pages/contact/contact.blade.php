@extends('layouts.app') 
@section('content')
<div class="container"> 
    <div class="row">
        <div class="col-sm-12"> 
        
            <div class="panel panel-default"> 
                <div class="panel-heading">Dashboard</div>   
                <div class="panel-body">  
                <div ng-controller="myContactsViewCtr">    
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
                                        <th>Firstname</th>
                                        <th>Email</th>
                                        <th>Contact Type</th> 
                                        <th>Delete</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr  ng-repeat="item in data | filter:q | startFrom:currentPage*pageSize | limitTo:pageSize" >
                                        <td>@{{item.first_name}} @{{item.last_name}}</td>
                                        <td>@{{item.email}}</td>
                                        <td>@{{item.type}}</td> 
                                        <td> delete </td>
                                        <td> edit</td>
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
                <a href="{{ route('contact.create')}}" title="">
                    <button type="button" class="btn btn-primary"> Add New Contact</button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
