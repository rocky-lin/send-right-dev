<?php 

namespace Support;

class Popup {   
	
	public static function campaign_delete_label()
	{?>
		<div class="modal fade" id="deleteFormLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title" id="myModalLabel">Delete Label</h4>
		            </div>
		            <div class="modal-body">
		                <label class="label label-default">Are you sure you want to delete this label?</label><br>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		                <button type="button" class="btn btn-primary">Save changes</button>
		            </div>
		        </div>
		    </div>
		</div><?php 
	}

	public static function campaign_add_label()
	{ ?> 
		<div class="modal fade" id="addCampaignLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
		        <div class="modal-content">
		            <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title" id="myModalLabel">Campaign Label</h4>
		            </div>
		            <div class="modal-body">
		                <label class="label label-default">Add New Label</label><br>
		                <input type="text" class="form-control" ng-model="name" > <br>  
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		                <button type="button" class="btn btn-primary" ng-click="saveNewLabel()" >Save</button> 
		            </div>
		        </div>
		    </div>
		</div><?php 
	}
}