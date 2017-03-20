<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AutoResponseDetailsController;
class CampaignAutoResponseSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'campaign:auto-response-send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger send auto responders queue';

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
        $this->info("Sending auto response to from entries");   
       $ardc = new AutoResponseDetailsController();   
       $ardc->startResponse(); 
    }
}
