<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\BackgroundScheduleService;

class BackgroundScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:background-scheduler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A command for running background schedule service.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //run service
        BackgroundScheduleService::runBackgroundService();
    }
}
