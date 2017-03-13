<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CampaignTemplate; 

class CampaignTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getTheme() {   
        // if($_SESSION['campaign']['kind'] == 'auto responder') { 
        // $templates = CampaignTemplate::where('type', $_SESSION['campaign']['kind'])->get();
        // } else if($_SESSION['campaign']['kind'] == 'mobile email optin') { 
        //     $templates = CampaignTemplate::where('type', 'mobile email optin')->get();
        // } else { 
        //     $templates = CampaignTemplate::where('type', 'newsletter')->get();
        // }  
        // dd($templates); 

        $templates = CampaignTemplate::where('id', '>', 0)->get() ;

        return $templates;
    }
    public function getBasic() { }
     



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


 
}
