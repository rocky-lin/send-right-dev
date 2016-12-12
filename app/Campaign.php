<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use db;
use Auth;
use App\User;
use App\Account;
use App\EmailAnalytic;
use Carbon\Carbon;

class Campaign   extends Model
{

    protected $table = "campaigns";

    protected $fillable = [
        'account_id',
        'sender_name',
        'sender_email',
        'sender_subject',
        'title',
        'content',
        'type',
        'status',
        'type'
    ];

    protected $hidden = [];

    public function account()
    {
        return $this->belongsTo('App\Account');
    }  
    public static function getCampaignsByAccount()
    {
        return Account::find(User::getUserAccount())->campaigns;
    }
    // public function emailAnalytic() 
    // { 
    //     return $this->hasOne('App\EmailAnalytic', 'campaign_id', 'id'); 
    // } 
    public function campaignSchedule()
    {
        return $this->hasOne('App\CampaignSchedule', 'campaign_id', 'id');  
    }

    public function campaignList() 
    {
        return $this->hasMany('App\CampaignList', 'campaign_id', 'id');
    }

    public static function createOrUpdateByCampaignId($campaign)
    {
        //        print "<pre>";
        //        print_r($campaign);
        //        print "</pre>";
        if(!self::where('id', $campaign['id'])->update($campaign)) {
            return self::create($campaign)->id;

        } else {
              return $campaign['id'];
        }
    }
    public static function getListIdsAsString($id) 
    {  
        
        
        $campaignLists = self::find($id)->campaignList; 

        $strListId = '';

        $strListId = '[';  
 
        $counter = 0; 

        foreach ($campaignLists as $list) {

            $counter++; 
            $strListId .= $list->list_id; 

            if($counter < count($campaignLists)) {

                $strListId .= ',';

            } 
        }

        $strListId .= ']';  

        return $strListId;  
    }  

    public static function emailAnalytic($id) 
    {
        return EmailAnalytic::where('table_name', 'campaigns')->where('table_id', $id)->first();  
    }

    public static function setDefaultValueToSessionClear($id) 
    {

        // get existing campaign info
        $campaign = self::find($id);  
        $campaignSchedule = self::find($id)->campaignSchedule;
        $emailAnalytic = self::emailAnalytic($id);
 
        // set default campaign status
        $_SESSION['campaign']['status']['active'] = ($campaign->status == 'active') ? true : false; 
        $_SESSION['campaign']['status']['inactive'] = ($campaign->status == 'inactive') ? true : false; 

        // set default campaign details
        $_SESSION['campaign']['name']     = $campaign->title;
        $_SESSION['campaign']['listIds']  =  self::getListIdsAsString($_SESSION['campaign']['id']);;
        $_SESSION['campaign']['template'] =  'Default';
 
        // set default campaign sender
        $_SESSION['campaign']['sender']['name'] = $campaign->sender_name; 
        $_SESSION['campaign']['sender']['email'] = $campaign->sender_email; 
        $_SESSION['campaign']['sender']['subject'] = $campaign->sender_subject;    

        // set default delivery type 
        $_SESSION['campaign']['delivery']['scheduleSend'] = array();
         $_SESSION['campaign']['delivery']['directSend'] = array(); 
 
        $_SESSION['campaign']['delivery']['directSend']['input'] = ($campaign->type == 'direct send') ? true : false; 
        $_SESSION['campaign']['delivery']['scheduleSend']['input'] = ($campaign->type == 'schedule send') ? true : false;  
        $_SESSION['campaign']['delivery']['scheduleSend']['dateTime'] = Carbon::now();
        $_SESSION['campaign']['delivery']['scheduleSend']['repeat'] = 'One Time';
                        
        // set default email type
        $_SESSION['campaign']['email']['reply'] = false;
        $_SESSION['campaign']['email']['openOrRead'] = false;
        $_SESSION['campaign']['email']['clickLink'] =  false; 

    }
    public static function setDefaultValueToSession($id)
    {


        // get existing campaign info
        $campaign = self::find($id);  
        $campaignSchedule = self::find($id)->campaignSchedule;
        $emailAnalytic = self::emailAnalytic($id);

 
        // set default campaign status
        $_SESSION['campaign']['status']['active'] = ($campaign->status == 'active') ? true : false; 
        $_SESSION['campaign']['status']['inactive'] = ($campaign->status == 'inactive') ? true : false; 

        // set default campaign details
        $_SESSION['campaign']['name']     = $campaign->title;
        $_SESSION['campaign']['listIds']  =  self::getListIdsAsString($_SESSION['campaign']['id']);;
        $_SESSION['campaign']['template'] =  'Default';
 
        // set default campaign sender
        $_SESSION['campaign']['sender']['name'] = $campaign->sender_name; 
        $_SESSION['campaign']['sender']['email'] = $campaign->sender_email; 
        $_SESSION['campaign']['sender']['subject'] = $campaign->sender_subject;    

        // set default delivery type 
        $_SESSION['campaign']['delivery']['scheduleSend'] = array();
         $_SESSION['campaign']['delivery']['directSend'] = array(); 
 
        $_SESSION['campaign']['delivery']['directSend']['input'] = ($campaign->type == 'direct send') ? true : false; 
        $_SESSION['campaign']['delivery']['scheduleSend']['input'] = ($campaign->type == 'schedule send') ? true : false;  
        $_SESSION['campaign']['delivery']['scheduleSend']['dateTime'] = $campaignSchedule->schedule_send;
        $_SESSION['campaign']['delivery']['scheduleSend']['repeat'] = $campaignSchedule->repeat;
                        
        // set default email type
        $_SESSION['campaign']['email']['reply'] = ($emailAnalytic->reply == 'on') ? true : false;
        $_SESSION['campaign']['email']['openOrRead'] = ($emailAnalytic->open_or_read == 'on') ? true : false;
        $_SESSION['campaign']['email']['clickLink'] = ($emailAnalytic->click_link == 'on') ? true : false;
        
        //  print "<pre>";  
        // print_r($_SESSION['campaign']);  
        // print "</pre>"; 
        // exit; 
    }

    
    public static function stringListIdsToArray($strListIds) 
    {  
        $arrListIds = []; 
        $strListIds = str_replace('[', '', $strListIds);
        $strListIds = str_replace(']', '', $strListIds);
        $arrListIds = explode(',', $strListIds); 
        // print "done ";
        // print_r($arrListIds);

        return  $arrListIds;
    }
    public static function stringListIdsremoveBracket($strListIds) 
    {   
        $strListIds = str_replace('[', '', $strListIds);
        $strListIds = str_replace(']', '', $strListIds); 
        // print "done ";
        // print_r($arrListIds);

        return  $strListIds;
    }

    public static function getAllEmailWillRecieveTheCampaign($campaignId)
    {   
        $contacts = []; 
        // get lists contact of the specific campaign 
        $campaignLists = Campaign::find($campaignId)->campaignList;   
        $counter=0; 
        // dd($campaignLists );
        // exit;
        foreach ($campaignLists as  $campaignList) {
             // print " <br> &nbsp;&nbsp; list id " . $campaignList->list_id;  
             foreach ($campaignList->list1->list_contact as $listContact) {
                 // print " <br>  &nbsp;&nbsp; &nbsp; email " . $listContact->contact->email;   
                 
                $contacts['contacts'][$listContact->contact->id]['email'] = $listContact->contact->email;  
                $contacts['contacts'][$listContact->contact->id]['full_name'] = $listContact->contact->first_name . ' ' . $listContact->contact->last_name; 
                $contacts['contacts'][$listContact->contact->id]['first_name'] =  $listContact->contact->first_name;
                $contacts['contacts'][$listContact->contact->id]['last_name'] =  $listContact->contact->last_name;
                $contacts['contacts'][$listContact->contact->id]['email'] =  $listContact->contact->email;
                $contacts['contacts'][$listContact->contact->id]['location'] =  $listContact->contact->location;  
                $contacts['contacts'][$listContact->contact->id]['phone_number'] =  $listContact->contact->phone_number;
                $contacts['contacts'][$listContact->contact->id]['telephone_number'] =  $listContact->contact->telephone_number; 
                $contacts['contacts'][$listContact->contact->id]['contact_id'] =  $listContact->contact->telephone_number; 
                $counter++; 
            }
        } 
        return $contacts;  
    }

    public static function supplyContactFilteres($contactFilters, $campaign)
    {
         foreach ($contactFilters as $contactFilter => $contactValue) { 
            $campaign = str_replace($contactFilter, $contactValue, $campaign); 
        }
        return $campaign; 
    } 
}
