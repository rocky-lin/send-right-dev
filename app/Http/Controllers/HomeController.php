<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Activity; 
use App\Helper; 

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
         return view('home');
    }

    public function previewActivities() 
    { 
        $activities = Activity::getAllAcitivities()->toArray(); 
        foreach($activities as $index => $activity) {
            $activities[$index]['create_at_ago'] = Helper::toAgo($activity['created_at']); 
        } 
        return view('pages.home.home-activity-view', compact('activities'));
    }  
    public function previewContacts()
    {
        // 
        $activities = '';
        return view('pages.home.home-contact-view', compact('activities'));
    }
    public function previewLists()
    { 
        $activities = '';
        return view('pages.home.home-list-view', compact('activities'));
    }
    public function previewForms()
    {
        $activities = '';
        return view('pages.home.home-form-view', compact('activities'));
    }
    public function previewCampaigns()
    {
        $activities = '';
        return view('pages.home.home-campaign-view', compact('activities'));
    }
    public function previewStatistics()
    {
        $activities = '';
        return view('pages.home.home-statistic-view', compact('activities'));
    }
}     