<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class GenerateNorificationMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-notification-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To generate Notification Message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //訊息
        NotificationService::genereateMessage();
    }
}
