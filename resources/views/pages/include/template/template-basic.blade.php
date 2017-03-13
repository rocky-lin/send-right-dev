
<div data-ng-controller="myTemplateThemeCtr" >

    @if(session('status')) 
        <br><br>
        <div class="alert alert-danger">
            {{session('status')}} 
        </div>
    @endif

	<br><br><br>
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3">  
					<select class="form-control">
						<option value="">All</option>
						<option value="template 1">Template 1</option>
						<option value="template 2">Template 2</option>
					</select>
				</div>
				<div class="col-md-3">  
					<div class="input-group">
		                <span class="input-group-addon" id="basic-addon1"><i class="material-icons" style="font-size: 19px">search</i></span>
		                <input ng-model="q" class="form-control" placeholder="Search" aria-describedby="basic-addon1" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;" />
		            </div>
				 </div>
				<div class="col-md-3">  </div>
			</div>
		</div> 
	</div> 
	<hr>  
	<div class="row" id="template-container-main">   
          {{-- <input type="button" ng-click="testingModel=1234" value ="ng-click" /> --}}
        <div data-ng-hide="deleteCampaign[campaign.id]"  ng-repeat="campaign in data | filter:q | filter:type | filter:list | startFrom:currentPage*pageSize | limitTo:pageSize | orderBy : email"  class="col-md-2">    
    {{-- @for($i=0; $i<10; $i++)  --}}
        <div class="col-md-2 template-container"  style="width:100%" ng-mouseenter="templateBackgroundBg={display:'block'}"  ng-mouseleave="templateBackgroundBg={display:'none'}" >    
            <div class="template-container-main-bg" style="height:100%; width:100%" ng-style="templateBackgroundBg"> 
                <div class="template-container-hover" > 

 
                    <input type="button" value="Select" class="btn btn-info" ng-click="selectedTheme(campaign)">  <br><br>
                    @{{selectedCampaignTemplate}}
                    <input type="button" value="Preview" class="btn btn-default">  
                </div> 
                <div class="template-container-hover-bg" >   
                </div>
            </div> 
            <div class="thumbnail" style="width:193px">   
                <img alt="100%x200" data-src="holder.js/100%x200" src="data:image/smc+" data-holder-rendered="true" style="height: 200px; width: 100%; display: block;">   
            </div>     
            <div class="pull-center">     
                <p> @{{campaign.name}} </p>              
                {{-- <p> {{$i}} </p> --}}
           </div>
        </div>   
    {{-- @endfor --}}
	</div>  
	<hr> 
	<div class="row"> 
		<div class="col-md-12">
				@include("pages/include/pagination/pagination")
		</div>   
	</div> 
    <div class="row"> 
        <div class="col-md-12"> 
        <form action="{{ route('user.post.campaign.select') }}" method="POST"  >
            {{csrf_field()}}   

                <input type="text" name="template" id="select-campaign-template" ng-model="selectedThemeModel" data-ng-value="selectedThemeModel"   /> <br>   

                <input type="hidden" name="method" value="POST"  /> <br> 

                <input type="submit" class="btn btn-info" value="Next" id="campaign-template-next-button"   ng-disabled="templateNextEnable" ng-init="templateNextEnable=true" />

                <small id="campaign-template-next-button-text" style="color:red" ng-hide="hideAlertMessage"> Please select template to enable next button..</small>  
                
            </form>
        </div>
    </div>
</div>
 