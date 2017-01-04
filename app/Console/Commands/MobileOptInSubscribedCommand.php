<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Activity;

class MobileOptInSubscribedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mobile-optin:subscribed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        Activity::createActivity( 
            [
                'account_id' => 1,
                'table_name' => 'email',
                'table_id' => 1,
                'action' => 'add new contact via register of email optin'
            ]
        ); 
    }
}
