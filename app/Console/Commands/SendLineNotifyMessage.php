<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LineNotifyService;

class SendLineNotifyMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-line-notify-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To send Line Notify Message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //發送Line Notify訊息
        LineNotifyService::sendLineNotifyMessage();
    }
}
