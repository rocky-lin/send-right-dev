<div ng-controller="myFormViewCtr">
    <div class="row">
        <div class="col-md-6">
             <h3>Forms</h3>
        </div>
        <div class="col-md-3" style="text-align: right">
        </div>
        <div class="col-md-3" style="text-align: right">
            <br>
            <a href="{{ route('user.form.list.connect.view') }}">
                <input type="button" value="Add New Form" class="pull-right btn btn-success" >
            </a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-6">
              <input type="button" value="Add Labels" class="pull-left btn btn-default"  data-toggle="modal" data-target="#addFormLabel">
        </div>
        <div class="col-md-3" style="text-align: right">
            {{--<input type="button" value="Add New List"  class="btn btn-success" />--}}
            <!-- Single button -->
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Actions <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#">Edit</a></li>
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
    <br>
    <div class="row" style="margin-left:0px; margin-right:0px"> 
        <div  class="col-sm-12">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" />
                        </th>
                        <th>
                        <label>Name</label>
                          <a href="#" title="First Name" data-toggle="popover" data-trigger="hover" data-content="First name of your form.">(?)</a>  
                        </th>   
                        <th> 
                            <label>View </label>
                            <a href="#" title="Delete" data-toggle="popover" data-trigger="hover" data-content="Delete your form forever.">(?)</a> 
                        </th>
                        <th>
                            <label>Delete </label>
                            <a href="#" title="Edit" data-toggle="popover" data-trigger="hover" data-content="Update your form.">(?)</a> 
                        </th>
                        <th>
                            <label>Edit </label>
                            <a href="#" title="Edit" data-toggle="popover" data-trigger="hover" data-content="Update your form.">(?)</a> 
                        </th>
                         <th>
                            <label>View Contacts </label>
                            <a href="#" title="Edit" data-toggle="popover" data-trigger="hover" data-content="Update your form.">(?)</a> 
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr data-ng-hide="deleteForm[form.id]"  ng-repeat="form in data | filter:q | startFrom:currentPage*pageSize | limitTo:pageSize | orderBy : email" >


                        <td> <input type="checkbox" /> </td>
                        <td>@{{form.name}} </td>
                        <td>
                            <i class="material-icons" data-ng-click="viewNowForm(form)"  style="cursor:pointer;">remove_red_eye</i>
                            {{--<span class="glyphicon glyphicon-eye-open" aria-hidden="true" ></span>     --}}
                        </td> 
                        <td>

                            <i class="material-icons" data-ng-click="deleteForm(form)" style="cursor:pointer;" >delete_forever</i>
                            {{--<span class="glyphicon glyphicon-trash" aria-hidden="true" data-ng-click="deleteForm(form)"></span>   --}}
                        </td>
                        <td>

                            <i class="material-icons" data-ng-click="editForm(form)" style="cursor:pointer;"  >mode_edit</i>
                             {{--<span class="glyphicon glyphicon-pencil" aria-hidden="true" data-ng-click="editForm(form)"></span> --}}
                        </td>
                         <td>
                             <i class="material-icons"  data-ng-click="viewFormContacts(form)" style="cursor:pointer;"  >contacts</i>
                             {{--<span class="glyphicon glyphicon-user" aria-hidden="true" data-ng-click="viewFormContacts(form)"></span> --}}
                             (@{{form.total_entry}})
                        </td>
                    </tr> 
                </tbody>
            </table>


            @include("pages/include/pagination/pagination")

            {{--<button class="btn btn-info" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">--}}
                {{--Previous--}}
            {{--</button>--}}
            {{--@{{currentPage+1}}/@{{numberOfPages()}}--}}
            {{--<button class="btn btn-info" ng-disabled="currentPage >= getData().length/pageSize - 1" ng-click="currentPage=currentPage+1">--}}
                {{--Next--}}
            {{--</button>--}}
        </div>
    </div>
</div>
{{--<hr>      --}}
{{-- <a href="{{ url('extension/form/create/editor/index.php') }}" title=""> --}}
{{--<a href="{{ route('user.form.list.connect.view') }}" title=""> --}}
    {{--<button type="button" class="btn btn-primary"> Add New Forms</button>--}}
{{--</a> --}}
