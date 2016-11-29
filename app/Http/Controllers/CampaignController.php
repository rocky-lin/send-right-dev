<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Campaign;
use Validator;
use App\Http\Requests\ValidateCampaignList;
use App\Http\Requests\ValidateCampaignSender; 

class CampaignController extends Controller
{

    public function index() 
    { 
    	return view('pages.campaign.campaign');
    } 

    // STEP 1
    public function create()
    { 

        return view('pages.campaign.campaign-connect-list');  
    }
    public function createValidate(ValidateCampaignList $request)
    {   
        session_start();
        $_SESSION['campaign']['name'] = $request->get('campaignName');
        $_SESSION['campaign']['list'] =  $request->get('selectList');  
        $_SESSION['campaign']['template'] =  'default';

        return redirect(route('user.campaign.create.sender.view'));
    }
    
    // STEP 2 
    public function createSender() 
    {

        return view('pages/campaign/campaign-sender');  
    } 
    public function createSenderValidate(ValidateCampaignSender $request) 
    {  
        session_start();
        $_SESSION['campaign']['sender']['name'] = $request->get('senderName'); 
        $_SESSION['campaign']['sender']['email'] = $request->get('senderEmail'); 
        $_SESSION['campaign']['sender']['subject'] = $request->get('emailSubject');  
        return redirect(url('extension/campaign/index.php'));
    }


    // STEP 3
    public function composeValidate(Requests $request) 
    {

        dd($request); 
    }

    // STEP 4
    public function createSettings() 
    {  
        return view('pages.campaign.campaign-settings'); 
    }   
    public function createSettingsValidate() 
    {  
        
        // validate here
    }


    // preview 

    public function getPreviewMobile() 
    {

        return view('pages.campaign.campaign-preview-mobile'); 
    }
    public function getPreviewDesktop() 
    {
        return view('pages.campaign.campaign-preview-desktop'); 
    }
    public function getPreviewTablet() 
    {
        return view('pages.campaign.campaign-preview-tablet'); 
    } 




    public function getAllCampaign()
    {
        return Campaign::getCampaignsByAccount();
    }

    public function edit($id)
    {
        return "THis is to edit the campaign, redirect url..";
    }

    public function destroy($id)
    {
        // delete campaign
        // delete schedule
        // delete list
    }

}