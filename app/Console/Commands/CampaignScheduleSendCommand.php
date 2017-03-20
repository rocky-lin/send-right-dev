<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\CampaignScheduleController; 
 
use App\CampaignSchedule; 
use Carbon\Carbon;
use App\Campaign;
use Mail;  
use App\Mail\CampaignSendMail; 
use Log; 
use App\Helper; 
use App\Activity; 
use App\User; 

 
class CampaignScheduleSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:schedule-send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger campaign schedule check and send to email,sms or notification.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    } 
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    { 
        $this->info("Sending email to contacts now..");  
        $campaignScheduleCtr = new CampaignScheduleController();
        $campaignScheduleCtr->send(); 
    }
}
