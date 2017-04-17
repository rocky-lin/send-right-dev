<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\MailGunController;

class CampaignReportTriggerCalculateCampaignCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:report-trigger-calculate-campaign-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will do calculation for campaign status and update campaign status values';

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
        $mailGun  = new MailGunController();

        $mailGun->executeQueriesStatusApi();
    }
}
