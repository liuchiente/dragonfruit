<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LineNotifyService;

class GenerateLineNotifyMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-line-notify-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To generate Line Notify Message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //產生Line Notify訊息
        LineNotifyService::genereateLineNotifyMessage();
    }
}
