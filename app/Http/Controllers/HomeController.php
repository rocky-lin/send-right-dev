<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

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



    // public function test(){
    //     return view('plugin.test');
    // }
}
