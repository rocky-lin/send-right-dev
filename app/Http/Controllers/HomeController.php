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
    public function index(Request $request)
    { 
        //  use this data anywhere in the project
        session_start();
        $_SESSION['UserId'] = Auth::user()->id;
        // unset($_SESSION['UserId']);
        $_SESSION['account_id'] = User::getUserAccount();  
        $_SESSION['extension']['db_name'] = env('DB_DATABASE');
        $_SESSION['extension']['db_user'] = env('DB_USERNAME');
        $_SESSION['extension']['db_pass'] = env('DB_PASSWORD');
        $_SESSION['extension']['site_url'] = url('/'); 
        $_SESSION['form_builder']['menu']['excludedFields'] = ['url', 'textarea', 'checkbox', 'radio', 'select','selectmultiple','upload','date','rating','time','hidden','image','terms'];
        $_SESSION['form_builder']['db_contact']['entry_fields_filters'] = ['first_name', 'last_name', 'email', 'location', 'phone', 'telephone'];

        $_SESSION['url']['hoem'] =  url('/'); 

        // return home view
        // distroy mobile optin after insert or update     
        unset($_SESSION['campaign']['optin']);

        return view('home');
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