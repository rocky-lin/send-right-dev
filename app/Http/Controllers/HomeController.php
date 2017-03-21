<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Activity; 
use App\Helper; 
use App\Contact; 
use App\Campaign; 
use App\List1; 
use App\Form;
use App\Http\Controllers\CampaignController;  

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    } 
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // distroy mobile optin after insert or update     
        unset($_SESSION['campaign']['optin']);  
    
        /** Get all contact */
        $contacts = Contact::where('account_id', User::getUserAccount())->get();

        /** get all auto responder */
        $campaignController = new CampaignController(); 
        $autoResponders = $campaignController->getAllCampaignSortByKind('auto responder'); 
              
        /** Get all lists */
        $lists = List1::where('account_id', User::getUserAccount())->get();
 
        /** Get all form */
        $forms = Form::where('account_id', User::getUserAccount())->get();
        
        /** Get all activity for specific user */
        $activities = Activity::where('account_id', User::getUserAccount())->orderBy('id','desc')->get(); 



        // dd($activities);
        // dd($autoResponders);
        return view('home', compact('contacts', 'autoResponders', 'lists', 'forms', 'activities'));
    } 

    public function previewActivities() 
    { 
        $activities = Activity::getAllAcitivities(10)->toArray(); 
        foreach($activities as $index => $activity) {
            $activities[$index]['create_at_ago'] = Helper::toAgo($activity['created_at']); 
        } 
        return view('pages.home.home-activity-view', compact('activities'));
    }  
    public function previewContacts()
    {
        $contacts = Contact::getAllContacts(10)->toArray();   
        $contacts = Helper::responseAddCreatedAtAgo($contacts); 
        return view('pages.home.home-contact-view', compact('contacts'));
    }
    public function previewLists()
    { 
        $lists = List1::getAllLists(10)->toArray();   
        $lists = Helper::responseAddCreatedAtAgo($lists);    
        return view('pages.home.home-list-view', compact('lists'));
    }
    public function previewForms()
    {   
        $forms = Form::getAllForms(10)->toArray();
        $forms = Helper::responseAddCreatedAtAgo($forms);
        return view('pages.home.home-form-view', compact('forms')); 
    }
    public function previewCampaigns()
    {
        $campaigns = Campaign::getAllCampaigns(10)->toArray();   
        $campaigns = Helper::responseAddCreatedAtAgo($campaigns);     
        return view('pages.home.home-campaign-view', compact('campaigns'));
    }
    public function previewStatistics()
    {
        $statistics = '';
        return view('pages.home.home-statistic-view', compact('statistics'));
    }
}     