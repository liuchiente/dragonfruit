<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\FirebaseService;

class SendFirebaseMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-firebase-message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To send Firebase Message';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //發送Firebase訊息
        $firebaseService=new FirebaseService();
        $firebaseService->sendPushMessage();
    }
}
