<?php
if(session_id() === ''){

	session_start();
	
	if(!isset($_SESSION['user'])){
		header('Location: ../');exit;
	}
}
?>

<div align="center">
	<a class="cfgenwp-button cfgenwp-button-blue" href="editor/index.php">Create a new form</a>
</div>

<h2>Forms</h2>

<div class="cfgenwp-list cfgenwp-index-panel">

	<?php
	$form_decode = ($form_decode = $contactformeditor_obj->getFormsIndex()) ? $form_decode : array();
	
	$cfgenwp_printobject = '';

	function cfgenwp_sortForms($a, $b){
		global $topstudio_tools_obj;
		return $topstudio_tools_obj->sortArrayBy($a, $b, 'form_name');
	}
	
	if(isset($form_decode['forms'])){
	
		usort($form_decode['forms'], 'cfgenwp_sortForms');
		
		foreach($form_decode['forms'] as $form_key=>$form_v){
		
			$cfgenwp_loop_form = $form_decode['forms'][$form_key];
				
			if(is_dir($contactformeditor_obj->forms_dir_path.$cfgenwp_loop_form['form_dir'])){
			
				if(!isset($cfgenwp_print_selectall_container)){?>
					<div class="cfgenwp-index-panel-c">

						<div class="cfgenwp-selectall">
							<input type="checkbox" class="cfgenwp-checkbox-selectall" id="cfgenwp-forms-selectall" >
							<label class="cfgenwp-label-selectall" for="cfgenwp-forms-selectall">Select all</label>&nbsp;&nbsp;&nbsp;<span class="cfgenwp-deleteselected cfgenwp-disabled" data-cfgenwp_delete_target="form">Delete selected</span><img src="editor/img/loading.gif" class="cfgen-loading" alt="">
						</div>

					</div>
					
					<?php
					$cfgenwp_print_selectall_container = true;
				}
				
				$cfgenwp_printobject = 1;
				
				// find zip archive
				$zipfile = '';
				
				$contactform_objects = scandir($contactformeditor_obj->forms_dir_path.$cfgenwp_loop_form['form_dir']);
				
				foreach($contactform_objects as $value_contactform_objects){
					if(substr($value_contactform_objects, -3) === 'zip'){
						$zipfile = $value_contactform_objects;
					}
				}

				?>
				<div class="cfgenwp-div-listitem">
					
					<div class="cfgenwp-list-item-c cfgenwp-list-item-name">
						<input type="checkbox" class="cfgenwp-item-checkbox-delete" value="<?php echo $cfgenwp_loop_form['form_id'];?>" >
						<a href="<?php echo 'editor/?id='.$cfgenwp_loop_form['form_id'];?>"><?php echo $cfgenwp_loop_form['form_name']; ?></a>
					</div>
					
					<div class="cfgenwp-list-item-c cfgenwp-list-item-id">
						<?php echo $cfgenwp_loop_form['form_id'];?>
					</div>
					
					<div class="cfgenwp-list-item-c cfgenwp-list-item-edit">
						<a href="<?php echo 'editor/?id='.$cfgenwp_loop_form['form_id'];?>">Edit</a>
					</div>
					
					<div class="cfgenwp-list-item-c cfgenwp-list-item-view">
						<a href="<?php echo 'editor/'.$contactformeditor_obj->forms_dir.'/'.$cfgenwp_loop_form['form_dir'];?>/index.php" target="_blank">View</a>
					</div>
					
					<div class="cfgenwp-list-item-c cfgenwp-list-item-duplicate">
						<a href="<?php echo 'editor/?id='.$cfgenwp_loop_form['form_id'].'&duplicate=1';?>">Duplicate</a>
					</div>
					
					<div class="cfgenwp-list-item-c cfgenwp-list-item-zip">
						<?php
						if($zipfile){?>
							<a href="<?php echo 'editor/'.$contactformeditor_obj->forms_dir.'/'.$cfgenwp_loop_form['form_dir'].'/'.$zipfile;?>" >Download</a>
							<?php
						} else echo '&nbsp;';
						?>
					</div>
					
					<div class="cfgenwp-list-item-c cfgenwp-list-item-date">
						<?php
						$cfgenwp_form_date = '';
						if(isset($cfgenwp_loop_form['date']) && $cfgenwp_loop_form['date']){
							$cfgenwp_form_date = @date('Y/m/d H:i', $cfgenwp_loop_form['date']);
						}
						echo $cfgenwp_form_date;
						?>
					</div>
					
					<div class="cfgenwp-clear"></div>
					
				</div>
			<?php
			} // is_dir
		} // foreach($form_decode['forms'] as $form)
	} // isset($form_decode['forms'])
	
	if(!$cfgenwp_printobject){?>
		<div class="cfgenwp-index-panel-c">
			<p>No form created yet</p>
		</div>
		<?php
		}
	?>
</div>


<h2>Uploads</h2>

<div class="cfgenwp-list cfgenwp-index-panel">

	<div class="cfgenwp-index-panel-c">
	<?php
	$objects = scandir('editor/upload');
	// why scandir: http://stackoverflow.com/questions/2947941/how-to-iterate-over-non-english-file-names-in-php
	$notemptydir = '';
	
	foreach($objects as $object){
		
		if($object != "." && $object != ".." && $object != 'index.html'){
			
			$notemptydir = true;
			break;
		}
	}
	
	if($notemptydir){?>
		<div class="cfgenwp-selectall">
			<input type="checkbox" class="cfgenwp-checkbox-selectall" id="cfgenwp-upload-selectall" >
			<label class="cfgenwp-label-selectall" for="cfgenwp-upload-selectall">Select all</label>&nbsp;&nbsp;&nbsp;<span class="cfgenwp-deleteselected cfgenwp-disabled" data-cfgenwp_delete_target="upload">Delete selected</span><img src="editor/img/loading.gif" class="cfgen-loading" alt="">
		</div>
		<?php
	}
	
	foreach($objects as $object){ 
	
		if($object != "." && $object != ".." && $object != 'index.html'){
			
			$notemptydir = true;
			?>
			<div class="cfgenwp-div-listitem">
				
				<div class="cfgenwp-list-item-c cfgenwp-list-item-name">
					<?php 
					$img_ext = array ('jpg', 'jpeg', 'jpe', 'gif', 'png');
					
					if(in_array(substr($object, -3), $img_ext)){?>
					
						<img src="editor/upload/<?php echo $object;?>" height="40" style="margin-left:4px" alt="" >
						<br>
						<input type="checkbox" class="cfgenwp-item-checkbox-delete" value="<?php echo $contactformeditor_obj->htmlEntities($object);?>" >
						<?php echo $object;?>
						
					<?php
					}
					?>
				</div>
			
					
				<div class="cfgenwp-clear"></div>
				
			</div>

			<?php
		} 
	}
	
	if(!$notemptydir){
		echo '<p>No image uploaded yet</p>';
	}
	?>
	</div>

</div>

<script>
jQuery(function(){

	jQuery('input[type="checkbox"].cfgenwp-checkbox-selectall').click(function(){
		var list_container = jQuery(this).closest('div.cfgenwp-list');
		list_container.find('input[type="checkbox"].cfgenwp-item-checkbox-delete').prop('checked', this.checked);
		
		if(jQuery(this).is(':checked') && list_container.find('input[type="checkbox"].cfgenwp-item-checkbox-delete:checked').length){
			list_container.find('.cfgenwp-deleteselected').removeClass('cfgenwp-disabled').addClass('cfgenwp-enabled');
			list_container.find('.cfgenwp-div-listitem').addClass('cfgenwp-selected');
		} else{
			list_container.find('.cfgenwp-deleteselected').removeClass('cfgenwp-enabled').addClass('cfgenwp-disabled');
			list_container.find('.cfgenwp-div-listitem').removeClass('cfgenwp-selected');
		}
	});
	
	jQuery('input[type="checkbox"].cfgenwp-item-checkbox-delete').click(function(){
		var list_container = jQuery(this).closest('div.cfgenwp-list');
		
		jQuery(this).closest('.cfgenwp-div-listitem').toggleClass('cfgenwp-selected');
		

		if(list_container.find('input[type="checkbox"].cfgenwp-item-checkbox-delete:checked').length){
			list_container.find('.cfgenwp-deleteselected').removeClass('cfgenwp-disabled').addClass('cfgenwp-enabled');
		} else{
			list_container.find('.cfgenwp-deleteselected').removeClass('cfgenwp-enabled').addClass('cfgenwp-disabled');
		}
	});
	
	jQuery('body').on('click', '.cfgenwp-deleteselected.cfgenwp-enabled, .cfgenwp-deleteselected.cfgenwp-enabled', function(){

		var button = jQuery(this);
		var delete_target = button.data('cfgenwp_delete_target');
		var list_container = button.closest('.cfgenwp-list');
		var loading = list_container.find('.cfgen-loading');
		var checkbox = list_container.find('.cfgenwp-checkbox-selectall');
		var checkbox_val = Array();
		
		var checked = list_container.find('.cfgenwp-item-checkbox-delete:checked');
		
		checked.each(function(){
			checkbox_val.push(jQuery(this).val());
		});
		
		
		if(delete_target == 'form'){
			var dialog_title = 'Delete form';
			var alert_msg = '<p>Are you sure you want to delete the selected form(s)?</p><p>There is no undo.</p>';
			var post_obj = {'form_id':checkbox_val};
			var post_url = 'editor/inc/editform-delete.php';
		}
		
		if(delete_target == 'upload'){
			var dialog_title = 'Delete file';
			var alert_msg = '<p>Are you sure you want to delete this file?</p><p>There is no undo.</p>';
			var post_url = 'editor/inc/editimage-delete.php';
			var post_obj = {'filename':checkbox_val};
		}
		
		jQuery.cfgenwp_dialog_box.html('<p>'+alert_msg+'</p>')
			.dialog({
				autoOpen: true,
				title: dialog_title,
				buttons:{
						'Delete': function(){
									jQuery(this).dialog('close');
			
									button.hide();
									loading.show();

									jQuery.post(post_url,
											post_obj,
											function(data){
												// console.log(data);
												var json_data = $.parseJSON(data);
												
												loading.hide();
												button.show();

												if(json_data && json_data['response'] == 'nok'){
													// ^--  if json_data prevents "Cannot read property 'response' of null"
												
													// remove the items that were deleted before the first error
													if(json_data['form_deleted']){
														jQuery.each(json_data['form_deleted'], function(index, value) {
															jQuery('.cfgenwp-item-checkbox-delete[value='+value+']').closest('.cfgenwp-div-listitem').slideUp(100, function(){jQuery(this).remove()});
														});
													}

													jQuery.cfgenwp_dialog_box.html('<p>'+json_data['response_msg']+'</p>')
																	  .dialog({
																			autoOpen: true,
																			title: 'Error',
																			buttons: {
																				Ok: function(){jQuery(this).dialog('close');}
																			}
																			});
												} else{
													checkbox.prop('checked', false);
													
													checked.each(function(){
														jQuery(this).closest('.cfgenwp-div-listitem').slideUp(100, function(){jQuery(this).remove()});
													});
													
													button.removeClass('cfgenwp-enabled').addClass('cfgenwp-disabled');
												}
											} // callback
									); // jQuery.post
								
								},
							Cancel: function(){ jQuery(this).dialog('close'); }
						}
			}); // end dialog message
	}); // end delete

});
</script>