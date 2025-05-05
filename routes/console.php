<?php
//use Illuminate\Support\Facades\Schedule;

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

use Illuminate\Console\Scheduling\Schedule;

return function (Schedule $schedule) {
 $schedule->command('app:background-scheduler')->cron('* * * * *')->withoutOverlapping();
 $schedule->command('app:send-line-notify-message')->cron('*/10 * * * *')->withoutOverlapping();
 $schedule->command('app:send-firebase-message')->cron('*/10 * * * *')->withoutOverlapping();
 $schedule->command('app:generate-notification-message')->cron('* * * * *')->withoutOverlapping();
};