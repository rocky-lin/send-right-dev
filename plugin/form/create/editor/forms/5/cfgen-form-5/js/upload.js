var swfupload_cfgen_element_5_6; // this variable name is also used in onclick="cfg_upload_xxx.cancelQueue();"
				jQuery(function(){
					var swfupload_cfgen_element_5_6 = new SWFUpload({
											flash_url : "cfgen-form-5/js/swfupload/swfupload.swf",
											upload_url: "cfgen-form-5/inc/upload.php?btn_upload_id=uploadbutton_cfgen_element_5_6",
											post_params: {"PHPSESSID" : "34lgos9im7trh3v8k1dulc13c6"},
											file_size_limit : "1MB",
											file_types : "*.*",
											file_types_description : "All Files",
											file_upload_limit : 0,
											file_queue_limit : 1,
											custom_settings : {
												progressTarget : "fsUploadProgress_cfgen_element_5_6",
												cancelButtonId : "btnCancel_cfgen_element_5_6"
											},
											debug: false,
											
											// Button settings
											button_image_url: "cfgen-form-5/js/swfupload/img/upload-button.png",
											button_width: "130",
											button_height: "31",
											button_placeholder_id: "uploadbutton_cfgen_element_5_6",

											button_action:SWFUpload.BUTTON_ACTION.SELECT_FILE, // when the Flash button is clicked the file dialog will only allow a single file to be selected
											button_cursor: SWFUpload.CURSOR.HAND,
									
											// The event handler functions are defined in handlers.js
											file_queued_handler : fileQueued,
											file_queue_error_handler : fileQueueError,
											file_dialog_complete_handler : fileDialogComplete,
											upload_start_handler : uploadStart,
											upload_progress_handler : uploadProgress,
											upload_error_handler : uploadError,
											upload_success_handler : uploadSuccess, // uploadSuccess in handlers.js
											upload_complete_handler : uploadComplete // FileProgress.prototype.setComplete in fileprogress.js
										});
						/* queue_complete_handler : queueComplete	// queueComplete in handlers.js, Queue plugin event */

				});

