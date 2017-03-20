 
<div class="row">
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
            <select class="pager-select" ng-model="pageSize"  >
                <option value="20">20 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
                <option value="200">200 per page</option> 
            </select>
        </div> 
    </div>
</div>
<br><br> 