<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AutoResponseDetails extends Model
{
    protected $table = 'auto_response_details';
    protected $fillable = [
        'auto_response_id',
        'table_name',
        'table_id',
        'status',
        'email'
    ];
    
    protected $hidden = [];

    public function autoResponse()
    {
        return $this->belongsTo('App\AutoResponse', 'auto_response_id');
    }

    public static function getActiveAutoResponses()
    {
        $autoResponseDetails = self::where('id', 1)->get();

        print "<pre>";
//        print "Testtsts";
//        dd($autoResponseDetails);
        foreach($autoResponseDetails as $autoResponseDetail){
//            dd($autoResponseDetail);
//            print "<pre>";
            $campaignSchedule = $autoResponseDetail->autoResponse->campaign->campaignSchedule()->first();
            // get campaign schedule

            print "<br>repeat as "  . $campaignSchedule->repeat;
            print "<br>repeat as days "  . $campaignSchedule->days;
            print "<br>repeat as hours "  . $campaignSchedule->hours;
            print "<br>repeat as mins "  . $campaignSchedule->mins;
//            print "<pre>";
        }
        // return self::where('status', 'active')->get();
        // return "test";
    }
}
