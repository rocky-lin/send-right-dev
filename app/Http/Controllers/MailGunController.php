<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Report;
use App\MailGunModel;

class MailGunController extends Controller
{



    public function testQuery()
    {

        MailGunModel::getLatestStatusApi();
    }

    public function executeQueriesStatusApi()
    {
        $eventArray  = ['delivered', 'opened', 'clicked', 'complained', 'accepted'];
        $from  = '';
        $title = '';
        $campaignId = null;

        // get status latest 0-50 so that it should be recorded as status of the campaigns
        $statuses = MailGunModel::getLatestStatusApi();

        $reportApi = [];

        // only execute and get data if data response exist
        if(!empty($statuses)) {

            // start foreach
            foreach($statuses as $index => $reponse){

                // add response to array variable

                $reportApi[$index]['sender']     = (!empty($reponse->envelope->sender)) ?   $reponse->envelope->sender   : null;
                $reportApi[$index]['event']      = (!empty($reponse->event)) ? $reponse->event  : null;
                $reportApi[$index]['target']     = (!empty($reponse->envelope->targets)) ?  $reponse->envelope->targets   : null;
                $reportApi[$index]['id']         = (!empty($reponse->id)) ?   $reponse->id  : null;
                $reportApi[$index]['title']      = (!empty($reponse->message->headers->subject)) ?   $reponse->message->headers->subject : null;
                $reportApi[$index]['fromName']   = (!empty($reponse->message->headers->from)) ?   $reponse->message->headers->from  : null;
                $reportApi[$index]['fromName']   = (!empty($reponse->message->headers->{'message-id'})) ?   $reponse->message->headers->{'message-id'}  : null;
                $reportApi[$index]['timestamp']  = (!empty($reponse->timestamp)) ?   $reponse->timestamp  : null;

                 // Assigne variables
                $from      = $reportApi[$index]['sender'];
                $title     = $reportApi[$index]['title']; //$status['title'];
                $timestamp = $reportApi[$index]['timestamp'];
                $event     = $reportApi[$index]['event'];


                print "\nfrom $from, title $title";
                // Get Report information of the specific campaign via from and title
                $report = Report::getByCampaignFromAndTitle($from, $title);

                if($report != false) {
                    print "\ncampaign id " . $report->campaign_id . '';
                    // check if already recorded or not
                    if ($report->last_time_stamp_counted_mailgun_entry < $timestamp) {


                        if (in_array($event, $eventArray)) {
                            // increment total count
                            if ($event == 'accepted') {

                                if($report->total_arrival < $report->total_send) {
                                    //print "<br>accepted";
                                    Report::find($report->id)->increment('total_arrival');
                                } else {
                                    print "\n no need to increment total arrival because arrival is already equal or greater than total send";
                                }

                            } else if ($event == 'opened') {

                                //print "<br>opened";
                                Report::find($report->id)->increment('total_open');

                            } else if ($event == 'clicked') {

                                //print "<br>click";
                                Report::find($report->id)->increment('total_click');

                            } else if ($event == 'complained') {

                                //print "<br>compaint";
                                Report::find($report->id)->increment('total_complain');

                            }
                            // print "<br> report id " . $report->id . ' update timestamp last_time_stamp_counted_mailgun_entry = ' . $timestamp;
                            // update latest count date
                            Report::find($report->id)->update(['last_time_stamp_counted_mailgun_entry' => $timestamp]);

                            // calculate rating specific campaign
                            Report::reportRatingCalculateUpdateAll($report->campaign_id);
                        }
                    } else {
                        print "\nthis time stamp is less than with current timesptam  added";
                    }
                } else {
                    print "\ncampaign not exist";
                }
            }
        }
                print "<pre>";
                print_r($reportApi);
                print "</pre>";
     }

}
