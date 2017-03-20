<div data-ng-controller="myListSelectCtr"   ng-init="loadDefaultLists('{{$defaultListIds}}')">
    <input type="hidden" name="list_ids" value="@{{selectedContactArray}}"   /> 
    
  {{--   <div class="row">
        <div class="col-sm-6">
            <label for="seach" > Search Contacts </label>
            <input ng-model="q" id="search" class="form-control" >
        </div>
        <div class="col-sm-6">
            <label for="limit show"> Show Rotal Rows </label>
            <select ng-model="pageSize" id="pageSize" class="form-control">
                <option value="5">5</option>
                <option value="10">10</option>
                @for($i=2; $i<10; $i++)
                    <option value="{{$i*10}}">{{$i*10}}</option>
                @endfor
            </select>
            <div/>
        </div>
    </div> --}}

 

    <label class="label label-primary"> Select List </label>

    <div class="row">
        <div class="col-md-3"> 
        </div>
        <div class="col-md-3" style="text-align: right">
          
        </div>
        <div class="col-md-3" style="text-align: right">
          
        </div>
        <div class="col-md-3" style="text-align: right">
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="material-icons" style="font-size: 19px">search</i></span>
                <input ng-model="q" class="form-control" placeholder="Search" aria-describedby="basic-addon1" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;">
            </div>
        </div>
    </div>


    <div class="row" style="margin-left:0px; margin-right:0px">
        <div  class="col-sm-12">
            <table class="table table-hover" >
                <thead>
                <tr>
                    <th>
                        {{-- <label>Select Contact</label> --}}
                        <input type="checkbox" />
                    </th>
                    <th>
                        <label>List Name</label>
                        <a href="#" title="First Name" data-toggle="popover" data-trigger="hover" data-content="First name of your contact.">(?)</a>
                    </th>
                    <th> 
                        <label>Total Contacts</label>
                    </th>
                    <th> Edit </th>
                </tr>
                </thead>
                <tbody>
                <tr data-ng-hide="deleteContact[contact.id]"  ng-repeat="contact in data | filter:q | startFrom:currentPage*pageSize | limitTo:pageSize | orderBy : email" >
                    <td>
                        <input type="checkbox" data-ng-value="@{{contact.id}}"   data-ng-click="selectContact(contact)" data-ng-checked="isContactSelected[@{{contact.id}}]" />
                    </td>
                    <td>@{{contact.name}} </td>
                    <td>
                        <i class="material-icons">contacts</i>  
                        @{{contact.contact_total}} 
                    </td>
                    <th> 
                        
                        <a href="{{$_SESSION['url']['hoem']}}/user/list/@{{contact.id}}/edit">
                            <i class="material-icons">mode_edit</i>
                        </a> 

                    </th>
                </tr>
                </tbody>
            </table>
<hr>
      @include("pages/include/pagination/pagination")

            
           {{--  <input type="button" class="btn btn-info" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1; setCheckBoxSelectedContact()" value="Previous" />
            @{{currentPage+1}}/@{{numberOfPages()}}
            <input type="button" class="btn btn-info" ng-disabled="currentPage >= getData().length/pageSize - 1" ng-click="currentPage=currentPage+1; setCheckBoxSelectedContact()" value="Next" /> --}}





        </div>
    </div>
</div>