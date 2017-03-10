       <div ng-controller="myContactsViewCtr">    
                    <h4>All Contacts (@{{ totalContact }}) </h4>


               <div class="row contact-menu-setting">
                   <div class="col-md-2  ">
                       <ul class="nav nav-tabs contact-sorting-ul" style="border-bottom:none; visibility: visible; ">
                           <li role="presentation" class="dropdown">
                               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                  aria-haspopup="true" aria-expanded="false" ng-click="toogleColumn()"> Toogle Column <span class="caret"></span>
                               </a>

                           </li>
                       </ul>
                   </div>
                   <div class="col-md-2">
                       <ul class="nav nav-tabs contact-sorting-ul " style="border-bottom:none; visibility: hidden;">
                           <li role="presentation" class="dropdown ">
                               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                  aria-haspopup="true" aria-expanded="false">Filter By Tag<span class="caret"></span>
                               </a>
                               <ul class="dropdown-menu">
                                   <li><a href="#">Tag 1</a></li>
                                   <li><a href="#">Tag 2</a></li>
                                   <li><a href="#">Tag 3</a></li>
                               </ul>
                           </li>
                       </ul>
                   </div>
                   <div class="col-md-2">
                       <div class="form-group">
                           <select class="form-control"  ng-model="search.list_id_str" >
                               <option value="">Filter By List</option>
                               @foreach($lists as $list)
                                   <option value="{{$list->name}}">{{$list->name}}</option>
                               @endforeach
                           </select>
                       </div>

                   </div>
                   <div class="col-md-3"> 
                      <select class="form-control" ng-model="status.type"> 
                        <option value="" >Filter By Status</option>
                        <option value="active">Active</option>
                        <option value="unconfirmed">Unconfirmed</option>
                        <option value="unsubscribed">Unsubscribed</option>
                        <option  value="bounced">Bounced</option>
                      </select> 
                      {{--  <ul class="nav nav-tabs contact-sorting-ul" style="border-bottom:none;">
                           <li role="presentation" class="dropdown">
                               <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                  aria-haspopup="true" aria-expanded="false">Filter By Status<span
                                           class="caret"></span> </a>
                               <ul class="dropdown-menu">
                                   <li><a href="#"  >Active ({{App\Contact::countByStatus('Active')}})</a></li>
                                   <li><a href="#"  >Unconfirmed ({{App\Contact::countByStatus('Unconfirmed')}})</a></li>
                                   <li><a href="#"  >Unsubscribed ({{App\Contact::countByStatus('Unsubscribed')}})</a></li>
                                   <li><a href="#"  >Bounced ({{App\Contact::countByStatus('Bounced')}})</a></li>
                               </ul>
                           </li>
                       </ul> --}}
                   </div>
                   <div class="col-md-3">
                       <div class="input-group">
                           <span class="input-group-addon" id="basic-addon1"><i class="material-icons" style="font-size: 19px">search</i></span>
                           <input ng-model="q" class="form-control" placeholder="Search" aria-describedby="basic-addon1" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
                       </div>
                   </div>
               </div>
                    <div class="row" style="margin-left:0px; margin-right:0px"> 
                        <div  class="col-sm-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th> <input type="checkbox" /> </th>
                                        <th>
                                        <label>Full Name </label>
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
                                            <label>Status </label> 
                                        </th> 
                                        <th> 
                                            <label>Delete </label>
                                            <a href="#" title="Delete" data-toggle="popover" data-trigger="hover" data-content="Delete your contact forever.">(?)</a> 
                                        </th>
                                        <th>
                                            <label>Edit </label>
                                            <a href="#" title="Edit" data-toggle="popover" data-trigger="hover" data-content="Update your contact.">(?)</a> 
                                        </th>
                                         <th> 
                                            <label>List</label> 
                                        </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr data-ng-hide="deleteContact[contact.id]"  ng-repeat="contact in data | filter:q | filter:status.type | filter:search.list_id_str | startFrom:currentPage*pageSize | limitTo:pageSize | orderBy : email" > 
                                        <td> <input type="checkbox" name="name" /></td>

                                        <td> 
                                        <a href="{{route('user.contact.profile')}}/@{{contact.id}}">
                                          @{{contact.first_name}} @{{contact.last_name}}
                                        </a>

                                        </td> 
                                        <td>@{{contact.email}}</td>
                                        <td>@{{contact.type}} </td> 
                                        <td>@{{contact.status}} </td>  
                                        <td>    
                                            <i class="material-icons"  data-ng-click="deleteContact(contact)" >delete_forever</i>
                                            {{-- <span class="glyphicon glyphicon-trash" aria-hidden="true" data-ng-click="deleteContact(contact)"></span>    --}}
                                        </td>
                                        <td>
                                         <i class="material-icons" data-ng-click="editContact(contact)" >mode_edit</i>
                                             {{-- <span class="glyphicon glyphicon-pencil" aria-hidden="true" data-ng-click="editContact(contact)"></span>  --}}
                                        </td> 
                                        <td> @{{contact.list_id_str}} </td>
                                    </tr> 
                                </tbody>
                            </table>
                        </div>

                        @include("pages/include/pagination/pagination")



                        {{--<div class="row">--}}
                            {{--<div class="col-md-12" style="text-align:center">--}}

                                {{--<div data-pagination="" data-num-pages="numPages()-1    "--}}

                                     {{--data-current-page="currentPage" data-max-size="maxSize"--}}
                                     {{--data-min-size="1"--}}
                                     {{--data-boundary-links="true" style="cursor: pointer"></div>--}}

                                    {{--<select ng-model="pageSize" id="pageSize" class="form-control" style="width: 5%;display: inline;margin-top: -23px;"  >--}}
                                    {{--<option value="5">5</option>--}}
                                    {{--<option value="10">10</option>--}}
                                        {{--@for($i=2; $i<10; $i++)--}}
                                            {{--<option value="{{$i*10}}">{{$i*10}}</option>--}}
                                        {{--@endfor--}}
                                    {{--</select>--}}

                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>

				{{--<hr>     --}}
                {{--<a href="{{ route('contact.create')}}" title="">--}}
                    {{--<button type="button" class="btn btn-primary"> Add New Contact</button>--}}
                {{--</a>--}}
                {{--<a href="{{ route('user.contact.import')}}" title="">--}}
                    {{--<button type="button" class="btn btn-primary"> Import Contacts </button>--}}
                {{--</a>--}}

