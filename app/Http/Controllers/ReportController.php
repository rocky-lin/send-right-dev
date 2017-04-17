<?php

namespace App\Http\Controllers;
use Input;
use Illuminate\Http\Request;
use App\User;
use App\List1;
use Event;
use App\Report; 
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $page = Input::get('page'); 

        if($page == 'campaign') { 

            /**
             * Get User lists
             */
            $lists = List1::where('account_id', User::getUserAccount())->get();

            return view('pages/report/report-campaign', compact('lists'));
        } else {
            return 'Other pages';
        } 
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


    public function testEventRoute() {  
        // print "test";
        // event('campaign.send');
    }
    public function testEventTrigger()
    {
        // print "test event";
    }
    public function debuggingTest()
    {
        print " getAndUpdateRate " .   Report::getAndUpdateRate(299, 'total_arrival_rate'); 
        print " getAndUpdateRate " .   Report::getAndUpdateRate(299, 'total_open_rate'); 
        print " getAndUpdateRate " .   Report::getAndUpdateRate(299, 'total_click_rate'); 
        print " getAndUpdateRate " .   Report::getAndUpdateRate(299, 'total_unsubscribe_rate');
    }
}
