

<h2>Campaign Sorting: </h2>
<p>Whene you select options below, it will sort and show results based on your search option.</p>
<form>

    <label class="radio-inline">
        <input type="radio" name="optradio" ng-click="campaignDisplayByKind('all')"  checked >All
    </label>

    <label class="radio-inline">
        <input type="radio" name="optradio" ng-click="campaignDisplayByKind('newsletter')"   >Newsletters
    </label>
    <label class="radio-inline">
        <input type="radio" name="optradio" ng-click="campaignDisplayByKind('auto responder')"  >Auto Responders
    </label>
    <label class="radio-inline">
        <input type="radio" name="optradio" ng-click="campaignDisplayByKind('mobile email optin')"  >Mobile Email Optin
    </label> 
</form> 
<br> 
<div class="loader" ng-style="myStyle" ></div>