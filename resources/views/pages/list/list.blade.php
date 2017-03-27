@extends('layouts.app') 
@section('content')
    <div class="wrapper">
        <div class="row">
            <div class="col-md-12 col-md-12-padding">
                <div ng-controller="myListsViewCtr">
                        <input type="hidden" ng-model="checkbox_checked" />
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                                <h3>List</h3>
                            </div>
                            <div class="col-md-6" style="text-align: right">
                                <a href="{{ route('list.create')}}" >
                                    <input type="button" value="Add New List"  class="btn btn-success" />
                                </a>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3" style="text-align: right">
                                {{--<input type="button" value="Add New List"  class="btn btn-success" />--}}
                                <!-- Single button -->
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Import Contacts <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Edit</a></li>
                                        <li><a href="#">View Contacts</a></li>
                                        <li><a href="#">Engagement Management</a></li>
                                        <li><a href="#">Segments</a></li>
                                        <li><a href="#">Subscribe by Email</a></li>
                                        <li><a href="#">Subscribe by SMS</a></li>
                                        <li><a href="#">Advance Settings</a></li>
                                        <li><a href="#">Copy</a></li>
                                        <li><a href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-3" style="text-align: right">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="material-icons" style="font-size: 19px">search</i></span>
                                    <input ng-model="q" class="form-control" placeholder="Search" aria-describedby="basic-addon1" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                                </div>
                            </div>
                        </div>
                        {{--<h3>Your total list  @{{ totalList }} </h3>--}}
                        <div class="row ">
                            <div class="col-sm-6">
                                {{--<label for="seach" > Search Lists </label>--}}
                                {{--<input ng-model="q" id="search" class="form-control" >--}}
                            </div>
                            <div class="col-sm-6">
                            <div/>
                        </div>
                    </div>
                    <div class="row" style="margin-left:0px; margin-right:0px; min-height: 490px" >
                        <div  class="col-sm-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" />
                                        </th>
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
                                        <td><input type="checkbox" value="@{{list.id}}" /></td>
                                        <td>@{{list.name}}  </td>
                                        <td>@{{list.contact_total}}</td>
                                        <td>
                                            <i class="material-icons" data-ng-click="deleteList(list)"  >delete_forever</i>
                                            {{--<span class="glyphicon glyphicon-trash" aria-hidden="true" data-ng-click="deleteList(list)" ></span>--}}
                                        </td>
                                        <td>
                                            <i class="material-icons" data-ng-click="editList(list)" >mode_edit</i>
                                             {{--<span class="glyphicon glyphicon-pencil" aria-hidden="true" data-ng-click="editList(list)"></span>--}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


                            @include("pages/include/pagination/pagination")

                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection 