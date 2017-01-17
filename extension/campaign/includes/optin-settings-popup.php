


<?php  

$optin_url = str_replace(' ', '-', $_SESSION['campaign']['name']);
$optin_email_subject = '';
$optin_email_content = '';
$optin_email_to_name = $recieverName; 
$optin_popup_link = '';
 $optin_email_to_mail =  str_replace(' ', '-', $campagn_title) . '@sendright.net'; 
if($campaign_id) { 

    $optin_url           = (!empty($campaign->optin_url)) ? $campaign->optin_url : null;
    $optin_email_subject = (!empty($campaign->optin_email_subject)) ? $campaign->optin_email_subject : null;
    $optin_email_content = (!empty($campaign->optin_email_content)) ? $campaign->optin_email_content : null;
    $optin_email_to_name = (!empty($campaign->optin_email_to_name)) ? $campaign->optin_email_to_name : $recieverName;
    $optin_email_to_mail = (!empty($campaign->optin_email_to_mail)) ? $campaign->optin_email_to_mail : $sendRightEmail;
    $optin_popup_link    = (!empty($campaign->optin_popup_link)) ? $campaign->optin_popup_link : null;
   
    $_SESSION['campaign']['optin']['url']           = $optin_url;
    $_SESSION['campaign']['optin']['email_subject'] =  $optin_email_subject;
    $_SESSION['campaign']['optin']['email_content'] =  $optin_email_content;
    $_SESSION['campaign']['optin']['email_to_name'] =  $optin_email_to_name;
    $_SESSION['campaign']['optin']['email_to_mail'] =  $optin_email_to_mail;
    $_SESSION['campaign']['optin']['popup_link']    = $optin_popup_link; 
    $_SESSION['campaign']['optin']['status']        = 'success';  
    $_SESSION['campaign']['kind']                   = $campaign->kind;   
}  else { 
    $_SESSION['campaign']['optin']['email_to_mail'] =  $optin_email_to_mail;
}
?>
    <!-- Email OptIn PopUp Container  -->
    <div class="container"  >  
        <div class="modal fade" id="emailOptIn" role="dialog" style="z-index: 200px">
            <div class="modal-dialog  ">  
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Mobile Optin Settings</h4>
                </div>
                <div class="modal-body">  
                        
                    <div id="optin-status"> </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-xs-2 col-form-label">OptIn Url</label>
                        <div class="col-xs-10"> 

                            <input class="form-control" type="text" value="<?php print $optin_url; ?>" id="optInUrlInput" placeholder="Optin Url"   >  

                            <div style="padding-top:5px;">
                                <small id="emailHelp" class="form-text text-muted"> <?php print $_SESSION['url']['hoem'] . '/optin/' . $_SESSION['campaign']['optin']['id'];  ?>/<span id="optInUrlTyped"><?php print $optin_url; ?></span></small>
                            </div> 
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-xs-2 col-form-label">OptIn Email Subject</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="<?php print $optin_email_subject; ?>" id="optInEmailSubject" placeholder="OptIn Email Subject" > 
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-xs-2 col-form-label">OptIn Email Content</label>
                        <div class="col-xs-10">
                            <textarea name="" class="form-control" id="optInEmailContent" placeholder="OptIn Email Content" rows="6"  ><?php print $optin_email_content; ?></textarea>      
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-xs-2 col-form-label">OptIn Receiver Name</label>
                        <div class="col-xs-10">
                            <input class="form-control" id="optInRecieverName" type="text" value="<?php print $optin_email_to_name; ?>" placeholder="OptIn Receiver Name"> 
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-xs-2 col-form-label">OptIn Receiver Email</label>
                        <div class="col-xs-10">

                            <input class="form-control" type="text" value="<?php print $optin_email_to_mail; ?>" id="" placeholder="OptIn Receiver Email" disabled> 
                            <input class="form-control" id="optInRecieverEmail" type="hidden" value="<?php print $optin_email_to_mail; ?>" id="" placeholder="OptIn Receiver Email"> 
                            <div style="padding-top:5px;">
                                <small id="emailHelp" class="form-text text-muted">Changing this email will now allow you to receive the subscribers data</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="example-text-input" class="col-xs-2 col-form-label">OptIn Response Url</label>
                        <div class="col-xs-10">
                            <input class="form-control" type="text" value="<?php print $optin_popup_link; ?>" id="optInResponseUrl" placeholder="OptIn Response Url" > 
                        </div>
                    </div>  

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
                  <button type="button" class="btn btn-primary btn-lg " id="save_optin_settings" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing Order">Update Settings</button>
                </div>
              </div> 
            </div>
        </div>
    </div> 