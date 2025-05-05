<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;
/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/



//Schedule::command('app:background-scheduler')->cron('* * * * *')->withoutOverlapping();
//Schedule::command('app:send-line-notify-message')->cron('*/10 * * * *')->withoutOverlapping();
Schedule::command('app:send-firebase-message')->cron('*/10 * * * *')->withoutOverlapping();
Schedule::command('app:generate-notification-message')->cron('*/10 * * * *')->withoutOverlapping();

Schedule::call(function () {
    Log::info('calling');
})->everyFifteenMinutes();