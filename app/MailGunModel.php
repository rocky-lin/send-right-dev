<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Mailgun\Mailgun;
use Carbon\Carbon;

class MailGunModel extends Model
{
    protected $table = 'mail_guns';




    public static function getLatestStatusApi()
    {
        $mgClient = new Mailgun('key-e031c2be3c5c39dd733d9ded47e57dbf');
        $domain = 'mail.sendright.net';

        $beginDate =  date("D, d F Y, 00:00:00 -0000",strtotime( Carbon::now()->addDay(-60)));
        $endDate   =  date("D, d F Y, 00:00:00 -0000",strtotime( Carbon::now()->addDay(1)));


        print " end date " . human_readable_date_time($endDate);
        print " begin date " . human_readable_date_time($beginDate);
        print "<br><br><br>";

        //        exit;
        //        print " biggin date " . $beginDate;
        $queryString = array(
            'begin'        => $endDate,
            'end'          => $beginDate,
            'ascending'    => 'no',
            'limit'        =>  200
        );

        # Make the call to the client.
        $result = $mgClient->get("$domain/events", $queryString);
        //$queryString = array('event' => 'rejected OR failed');
        //# Make the call to the client.
        $result = $mgClient->get("$domain/events", $queryString);
//        print "<pre>";
//        print_r($result->http_response_body->items);
//        print "</pre>";
//        exit;
        //        print_r($result);
        return $result->http_response_body->items;
        //        exit;
        //        print "<pre>";
        //        print_r($result->http_response_body->items);
        //        print "</pre>"    ;
        //        foreach($result->http_response_body->items   as $reponse){
        //            print "sender" . $reponse->envelope->sender;
        //        }
        //        exit;
        //        return $data;

    }

}
