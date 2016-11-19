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
        $_SESSION['account_id'] = User::getUserAccount(); 
         
        // return home view
        return view('home');
    }



    public function test(){
        return view('plugin.test');
    }
}
