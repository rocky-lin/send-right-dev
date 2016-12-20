
 

<div class="container" data-ng-init="accountInfoInit={{$userAccount}}">
  <h1>Edit Profile</h1>
  <hr style="width:91%">



  <div class="row">
    <!-- left column -->
    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="text-center">
        <img src="{{url('/public/img/others/profile.jpg')}}" class="avatar img-circle img-thumbnail" alt="avatar">
        <h6>Upload a different photo...</h6>
        <input type="file" class="text-center center-block well well-sm">
      </div>
    </div>
    <!-- edit form column -->
    <div class="col-md-7 col-sm-6 col-xs-12 personal-info">
      <div ng-bind-html="accountInfoStatusModel" ng-class="accountInfoStatusClass" ng-show="accountInfoStatusShow" style="width:91%; "> 
 
        <i class="fa fa-coffee"></i>
        @{{accountInfoStatusModel}}
      </div>
      <h3>Personal info</h3>
      <form class="form-horizontal ng-pristine ng-valid" role="form">
       
        <div class="form-group">
          <label class="col-lg-3 control-label">Full Name:</label>
          <div class="col-lg-8">  
            <input ng-model="user_full_name" class="form-control" type="text">  
          </div>

 
        </div>
           <div class="form-group">
          <label class="col-lg-3 control-label">Email:</label>
          <div class="col-lg-8">
            <input  ng-model="user_email" class="form-control"  type="text">
          </div>
        </div>
        <div class="form-group">
          <label class="col-lg-3 control-label">Company:</label>
          <div class="col-lg-8">
            <input  ng-model="user_company" class="form-control"   type="text">
          </div>
        </div> 
        <div class="form-group">
          <label class="col-lg-3 control-label">Time Zone:</label>
          <div class="col-lg-8">
            <div class="ui-select">
            <input  ng-model="user_time_zome" class="form-control"   type="text" disabled> 
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-3 control-label">Username:</label> <br>
          <div class="col-md-8"> 
            <input ng-model="user_name"  class="form-control"  type="text" disabled="">
          </div>
        </div>
        
        </form></div>
        <div class="form-group">
          <label class="col-md-3 control-label"></label>
          <div class="col-md-10">
             <div class="loader pull-right"  ng-style="accountInfoUpdateLoaderStyle" ng-init="accountInfoUpdateLoaderStyle={'margin-top': '6px', 'display': 'none', 'margin-left': '13px'}" syle="display:none" ></div>
            <input ng-click="updateAccount()" class="btn btn-primary pull-right" value="Save Changes" type="button">         
            <span></span> 
          </div>
        </div> 
    </div>
  </div>

