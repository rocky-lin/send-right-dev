<div class="row">
    <div class="col-md-12 pull-center">
        <div data-pagination="" data-num-pages="numPages()" data-current-page="currentPage" data-max-size="maxSize" data-boundary-links="true"></div>
        <div class="pager-container" >
            <select class="pager-select" ng-model="pageSize" >
                <option value="5">5</option>
                <option value="10">10</option>
                @for($i=2; $i<10; $i++)  <option value="{{$i*10}}">{{$i*10}}</option>    @endfor
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 pull-center">
        <hr>
        <button class="btn btn-info" ng-disabled="currentPage == 0" ng-click="currentPage=currentPage-1">
            Previous
        </button>
        @{{currentPage+1}} / @{{numberOfPages()}}
        <button class="btn btn-info" ng-disabled="currentPage >= getData().length/pageSize - 1" ng-click="currentPage=currentPage+1">
            Next
        </button>
    </div>
</div>
<br><br>
