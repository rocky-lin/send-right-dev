		
	<div id="cfgenwp-header" class="cfgenwp-header">
	
		<div id="cfgenwp-header-l" >
			<a href="index.php"><img src="img/logo.png" alt=""></a>
			<p id="baseline">Create forms without writing a single line of code. 1</p>
		</div>
	
		<div id="cfgenwp-header-r-r">
		<?php
			if($contactform_obj->demo == 1){?>
				<div style="float:right; width:210px; ">
				<a href="<?php echo $contactform_obj->envato_link;?>" target="_parent"><img src="img/buy.png" alt=""></a>
				</div>
				<?php
			} else { ?>
				
				<div class="cfgenwp-header-r-r">
					<?php
					if($contactform_obj->demo != 1){?>
						<a href="../index.php">Forms</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="../config.php">Config</a>&nbsp;&nbsp;&nbsp;<a href="inc/logout.php" id="logout">Logout</a>
					<?php } ?>
				</div>
				
				<div class="cfgenwp-header-r-l">
				<?php
				if($contactform_obj->demo != 1){?>
				
					<div>
					Version <?php echo $cfgenwp_editor_obj->version;?> © <a href="http://www.topstudiodev.com" target="_blank" class="cfgenwp-a-text"><span id="copyright-header">Top Studio</span></a>
					</div>
					
					<?php
					if(is_file($topstudio_tools_obj->license_filename_path)){
						include($topstudio_tools_obj->license_filename_path);
					}
					
					$print_newversionmessage = '';
					$cfgenwp_grab_version_url = 'http://www.topstudiodev.com/formgenerator/version.php?code='.(isset($topstudio_item_license_purchasecode) ? $topstudio_item_license_purchasecode : '');
					$cfgenwp_grab_version_json = '';
					$cfgenwp_grab_version = '';
					
					$cfgenwp_grab_version_json = $topstudio_tools_obj->loadCurlFile($cfgenwp_grab_version_url, array('force_referer'=>1));
					
					if(!$cfgenwp_grab_version_json && ini_get('allow_url_fopen')){
						$cfgenwp_grab_version_json = @file_get_contents($cfgenwp_grab_version_url);
					}
					
					
					if($cfgenwp_grab_version_json){
					
						$cfgenwp_grab_version = json_decode($cfgenwp_grab_version_json, true);						
						
						if(isset($cfgenwp_grab_version['version']) && is_numeric((string)$cfgenwp_grab_version['version'])){
						
							if($cfgenwp_grab_version['version'] != $cfgenwp_editor_obj->version){
								$print_newversionmessage = 1;
							}
						}
					}
					
					if(!$print_newversionmessage){?>
						<div class="cfgenwp-header-r-r-sub">
						<a href="http://www.topstudiodev.com/formgenerator" target="_blank" class="cfgenwp-small">Click here to be notified of the next update</a>
						</div>
						<?php
					}
				}
				?>
				</div>
				
				<div class="cfgenwp-clear"></div>
				<?php
			} // end else
			?>
			

					</div><!-- cfgenwp-header-r-r -->
		
		<div class="cfgenwp-clear"></div>
		
	</div><!-- header -->