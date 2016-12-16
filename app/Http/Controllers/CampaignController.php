<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Validator;
use App\Http\Requests\ValidateCampaignList;
use App\Http\Requests\ValidateCampaignSender; 

use App\Campaign; 
use App\CampaignSchedule; 
use App\EmailAnalytic;
use App\List1; 
use App\CampaignList;
use DB;
use Illuminate\Support\Facades\Input;
use App\User;
use Carbon\Carbon; 
use App\Helper; 
use Redirect;
use App\Http\Controllers\CampaignScheduleController;  
use Session;

class CampaignController extends Controller
{

    public function index() 
    { 
    	return view('pages.campaign.campaign');
    } 

    public function createStart()
    {
        // print "test";
        // exit;
        return view('pages.campaign.campaign-create-start'); 
    }

    // STEP 1
    public function create()
    { 
        session_start();

        if(Input::get('ck') == 'newsletter') {   
            $_SESSION['campaign']['kind'] = 'newsletter';
        } else if(Input::get('ck') == 'auto responder')  {  
            // session('campaign_kind', '');
           $_SESSION['campaign']['kind'] = 'auto responder';
        } else {
            if(Input::get('action') != 'edit') {
                return redirect()->route('user.campaign.create.start')->with('status', 'please select campaign type');
            }
        }



        $campaign = [];
        $defaultListIds = '0';
        $action = '';
        $id = '';

        if(Input::get('action') == 'edit') {
            $action = Input::get('action');
            $id = Input::get('id');
            $campaign = [];

            // get campaign title
            $campaign['title']    = Campaign::find($id)->first()->title;
            $campaign['template'] = 'Default';
            // get lists, this is ready for multiple lists retrieved
            $lists = Campaign::find($id)->campaignList;

            foreach($lists as $list) {
                $defaultListIds = $list->id .','; 
                // $campaign['lists'][] = $list->list1->name; 
            }

            // set default campaign list ids
            $defaultListIds = (!empty( $_SESSION['campaign']['listIds'] )) ?  $_SESSION['campaign']['listIds'] : $defaultListIds; 

            // set default campaign name or title
            $campaign['title'] = (!empty($_SESSION['campaign']['name'])) ? $_SESSION['campaign']['name'] : $campaign; 
        }

        $defaultListIds = Campaign::stringListIdsremoveBracket($defaultListIds); 
        return view('pages.campaign.campaign-connect-list', compact('campaign', 'defaultListIds', 'action', 'id'));
    }
    public function createValidate(ValidateCampaignList $request)
    {   
        session_start();
        $_SESSION['campaign']['name']     = $request->get('campaignName');
        $_SESSION['campaign']['listIds']  =  $request->get('list_ids');
        $_SESSION['campaign']['template'] =  'Default'; //$request->get('template');
        // print  $_SESSION['campaign']['listIds'];
        // 
        // print " list ids ".  $_SESSION['campaign']['listIds'];
        // exit; 
        $listIdsTotal = count(explode(',', $request->get('list_ids'))); 
        // dd($listIdsTotal); 
        if( $listIdsTotal < 2 ) {
            return Redirect::back()->withInput(Input::all())->with('status', 'Please select at least 1 list.');
        } else { 
            return redirect(route('user.campaign.create.sender.view'));
        }
    }

    public function createUpdate(Request $request, $id)
    { 
        session_start();
        $_SESSION['campaign']['name']     = $request->get('campaignName');
        $_SESSION['campaign']['listIds']  =  $request->get('list_ids');
        $_SESSION['campaign']['template'] =  'Default';//$request->get('template');
 
               // dd($request->all());
        // print "update now";


        // dd($_SESSION['campaign']);


        // after update redirect to settings
        return redirect(route('user.campaign.create.settings'));
    }

    // STEP 2 
    public function createSender() 
    {    
        session_start();
        // dd($_SESSION['campaign']['sender']);
            $campaign['sender'] = []; 
            $action = ''; 
            $id = 0;
            $action = ''; 

            if(Input::get('action') == 'edit') 
            {                  
                // get data from url parameter
                $action = Input::get('action'); 
                $id = Input::get('id'); 
 
                $campaign1 = Campaign::find($id); 
 
                $campaign['sender']['name'] = (!empty($_SESSION['campaign']['sender']['name'])) ? $_SESSION['campaign']['sender']['name']  : $campaign1->sender_name;

                $campaign['sender']['email'] = (!empty($_SESSION['campaign']['sender']['email'])) ? $_SESSION['campaign']['sender']['email']  : $campaign1->sender_email;

                $campaign['sender']['subject'] = (!empty($_SESSION['campaign']['sender']['subject'])) ? $_SESSION['campaign']['sender']['subject']  : $campaign1->sender_subject; 
            } 

        return view('pages.campaign.campaign-sender', compact('campaign', 'id', 'action'));  
    } 
    public function createSenderValidate(ValidateCampaignSender $request) 
    {  
        session_start();
        $_SESSION['campaign']['sender']['name'] = $request->get('senderName'); 
        $_SESSION['campaign']['sender']['email'] = $request->get('senderEmail'); 
        $_SESSION['campaign']['sender']['subject'] = $request->get('emailSubject');  
        return redirect(url('extension/campaign/index.php'));
    }

    public function createSenderUpdate(Request $request, $id)
    { 
        session_start(); 
        $_SESSION['campaign']['sender']['name'] = $request->get('senderName'); 
        $_SESSION['campaign']['sender']['email'] = $request->get('senderEmail'); 
        $_SESSION['campaign']['sender']['subject'] = $request->get('emailSubject');  

        // dd($request->all());
        // redirect after update sender
        return redirect(route('user.campaign.create.settings'));
        //        return view('pages/campaign/campaign-sender');
    }

    // STEP 3
    public function composeValidate(Requests $request) 
    {

        dd($request); 
    }

    // STEP 4
    public function createSettings() 
    { 

        session_start(); 
        // print_r($_SESSION['campaign']['listIds']); 
        // exit 
        // 
//         print "campaign id  " . $_SESSION['campaign']['id'];

        $campaignSchedule = CampaignSchedule::where('campaign_id', $_SESSION['campaign']['id'])->first();
        $campaign = Campaign::where('id' , $_SESSION['campaign']['id'])->first();
//        dd($campaign );
        return view('pages.campaign.campaign-settings', ['status'=>'', 'listNames'=>List1::getCurrentCampaignListNames(), 'campaignSchedule'=>$campaignSchedule, 'campaign'=>$campaign]);
    }   

    public function createSettingsValidate(Request $request) 
    {   
        session_start();
        // dd($request->all());
        // print"<pre>";
        // print_r($_SESSION['campaign']);
        // exit;
        // if($request->get('campaign_send_as') == 'sendNow') {
        //    print "send send";
        // };
        // UPDATE CAMPAIGN
        
        Campaign::createOrUpdateByCampaignId([
            'account_id'=>User::getUserAccount(),
            'sender_name'=>$request->get('sender_name'),
            'sender_email'=>$request->get('sender_email'),
            'sender_subject'=>$request->get('sender_subject'),
            'title'=>$request->get('title'), 
            'id'=>$request->get('campaign_id'), 
            'status'=>$request->get('campaign_status'),
            'type'=>$request->get('campaign_type'), 
            'kind' => $request->get('campaign_kind')  
        ]);

        // UPDATE OR CREATE CAMPAIGN SCHEDULE
              
            CampaignSchedule::createOrUpdateByCampaignId([
                'campaign_id'=>$request->get('campaign_id'), 
                'repeat' => $request->get('campaign_schedule_repeat'), 
                'schedule_send' => $request->get('campaign_schedule_send'), 
                'days' =>  (!empty($request->get('campaign_schedule_days')))? $request->get('campaign_schedule_days') : 0,
                'hours' => (!empty($request->get('campaign_schedule_hours')))? $request->get('campaign_schedule_hours') : 0,
                'mins' =>  (!empty($request->get('campaign_schedule_mins')))? $request->get('campaign_schedule_mins') : 0,
            ]);   
  

        // UPDATE OR CREATE NEW EMAIL ANALYTIC
            EmailAnalytic::createOrUpdateByCampaignId([
                'table_id'=>$request->get('campaign_id'),
                'table_name'=>'campaigns',
                'open_or_read'=>$request->get('campaign_email_analytic_open'),
                'click_link'=>$request->get('campaign_email_analytic_click_link'),
                'reply'=>$request->get('campaign_email_analytic_reply')
            ]); 

         //INSERT LISTS  
         // print_r($_SESSION['campaign']['listIds']);
        // exit; 
            CampaignList::createOrUpdateByCampaignId([
                'campaign_id' => $request->get('campaign_id'),
                'campaign_lists' => $request->get('list_ids'),
            ]);
 
        // $status = '<div class="alert alert-success"> Campaign settings successfully updated and  ' . $request->get('campaign_send_as') . '!</div>';

        $listNames = List1::getCurrentCampaignListNames();

        // save new and set new settings into session 
        // this will be used in populating in correct values in the settings after the new settings is submitted.
        Campaign::setDefaultValueToSession($request->get('campaign_id'));  

        // message status 
            




        if($request->get(   'campaign_type') == 'direct send') {
            if($request->get('campaign_status') == 'active') {
 
                    $campaignSchedule = new CampaignScheduleController();  
                    $campaignSchedule->directSend($request->get('campaign_id')); 

                $status = "<div class='alert alert-success'> Campaign email sent to contacts...</div>";     
            } else {
                $status = "<div class='alert alert-danger'> Sending now failed and must be in active status..</div>"; 
            } 
        } else {
            $status = "<div class='alert alert-success'> Campaign email schedule saved..</div>";
        }


        $campaignSchedule = CampaignSchedule::where('campaign_id', $_SESSION['campaign']['id'])->first();
        $campaign = Campaign::where('id' , $_SESSION['campaign']['id'])->first();
        return view('pages.campaign.campaign-settings', compact('status', 'listNames', 'campaignSchedule', 'campaign')); 
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
     
    // store final data in campaign
    public function store(Requests $request)
    {

        dd($request->all());
    }

    // other
    public function getAllCampaign()
    {
 
        $campaigns = Campaign::getCampaignsByAccount()->toArray(); 

     
        $collection = collect( $campaigns ); 
        $sorted = $collection->sortBy('id', SORT_REGULAR, true);  
        $campaigns = $sorted->values()->all();
 
        foreach($campaigns as $index => $campaign)  { 
            $created_ago = Carbon::createFromTimeStamp(strtotime($campaign['created_at']))->diffForHumans(); 
            // print "ago " .   $ago;
            $campaigns[$index]['created_ago'] = $created_ago;
             $campaigns[$index]['next_send'] = Helper::createDateTime(CampaignSchedule::where('campaign_id', $campaigns[$index]['id'])->first()->schedule_send)->format('l jS \\of F Y h:i:s A');
             $campaigns[$index]['total_contacts'] =  count(Campaign::getAllEmailWillRecieveTheCampaign($campaigns[$index]['id'])['contacts']); 
        } 
        //dd($campaigns);  
        return $campaigns; 
    }

    public function getAllCampaignSortByKind($kind)
    {

        $campaigns = Campaign::getCampaignsByAccountSortByKind($kind)->toArray();


        $collection = collect( $campaigns );
        $sorted = $collection->sortBy('id', SORT_REGULAR, true);
        $campaigns = $sorted->values()->all();

        foreach($campaigns as $index => $campaign)  {
            $created_ago = Carbon::createFromTimeStamp(strtotime($campaign['created_at']))->diffForHumans();
            // print "ago " .   $ago;
            $campaigns[$index]['created_ago'] = $created_ago;
             $campaigns[$index]['next_send'] = Helper::createDateTime(CampaignSchedule::where('campaign_id', $campaigns[$index]['id'])->first()->schedule_send)->format('l jS \\of F Y h:i:s A');
             $campaigns[$index]['total_contacts'] =  count(Campaign::getAllEmailWillRecieveTheCampaign($campaigns[$index]['id'])['contacts']);
        }
        //dd($campaigns);
        return $campaigns;
    }

    public function edit($id)
    {
        return "THis is to edit the campaign, redirect url..";
    }

    public function destroy($id)
    {
        print "alright delete pa more id " . $id;
        //        Campaign::find($id)->delete();
        //        Campaign::find($id)->campaignSchedule()->delete();
        //        EmailAnalytic::where('table_name', 'campaigns')->whereAnd('tabled_id', $id)->delete();
        //        Campaign::find($id)->campaignList()->delete();
        Campaign::find($id)->campaignSchedule()->delete();
        EmailAnalytic::where('table_name', 'campaigns')->where('table_id', $id)->delete();
        Campaign::find($id)->campaignList()->delete();
        Campaign::find($id)->delete();
    } 
    public function sendTestCampaignEmail($id, $email)
    {  
        // print "$id, $email";
        // $campaignSendTest = CampaignSchedule::getScpecificCampaignByCampaignId($id); 

            // print "<pre>";
            //     print_r($campaignSendTest); 
            // print "</pre>";  
          $campaignSchedule = new CampaignScheduleController();
          $boolean = $campaignSchedule->testSend($id, $email); 

          if($boolean) {
            print "<span style='color:green' > successfully sent test email</span>"; 
          } else {
            print "<span style='color:red'>failed send test email</span>";
          }
 
        // print "new email test sent!";
        // campaign id
        // send to sender
        // return successfully sent
    }




}