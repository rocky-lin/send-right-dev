
			<div class="form-horizontal">
				<fieldset>  
				<!-- Form Name -->
				<legend>Change password</legend>  
					<div  class="col-md-6" ng-class="new_password_class"  ng-show="new_password_invalid"   ng-hide="!new_password ||  !repeat_new_password"   >@{{new_password_text}}</div>
					 <div ng-class="old_password_class"  ng-show="old_password_invalid"  ng-hide="!current_password"  >@{{old_password_text}}
					 </div> 
				<!-- Password input--> 
				<div class="form-group" style="display:none">
				  <label class="col-md-2 control-label" for="piCurrPass">Current Password</label>
				  <div class="col-md-4">
				  	<input type="text"  ng-model="old_password" ng-init="old_password='test1'" style="display:none"/> 
				    <input id="piCurrPass" name="piCurrPass" type="password" placeholder="" class="form-control input-md" required="" ng-model="current_password">  
				  </div>
				</div> 
		 
				<div style="clear:both"> </div> 
				<!-- Password input--> 
				<div class="form-group">
				  <label class="col-md-2 control-label" for="piNewPass">New Password</label>
				  <div class="col-md-4">  
				    <input id="piNewPass" name="piNewPass" type="password" placeholder="" class="form-control input-md" required="" ng-model="new_password" >    
				  </div> 
				</div> 
				<!-- Password input-->
				<div class="form-group">
				  <label class="col-md-2 control-label" for="piNewPassRepeat">Repeat New Password</label>
				  <div class="col-md-4">
				    <input id="piNewPassRepeat" name="piNewPassRepeat" type="password" placeholder="" class="form-control input-md" required="" ng-model="repeat_new_password" > 
				  </div>
				</div>  
				<!-- Button (Double) -->
				<div class="form-group">
				  <label class="col-md-4 control-label" for="bCancel"></label>
				  <div class="col-md-8"> 
				    <button id="bGodkend" name="bGodkend" class="btn btn-success" ng-click="changePassword()" data-ng-disabled="!passwordAllowUpdate" >Update</button>
				  </div>
				</div>  
				old pass 
 				@{{old_password}}<br>
 				old pass type
				@{{current_password}} <br>
				new pass
				@{{new_password}}<br>
				repeat new pass
				@{{repeat_new_password}} <br> 
				</fieldset> 
				{{-- <label data-ng-model="old_password_invalid"> old password now correct! </label> --}} 
	</div>

 