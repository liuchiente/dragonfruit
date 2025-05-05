<?php

namespace App\Services;

use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;

use Poliander\Cron\CronExpression;

use App\Models\Scheduler;





class BackgroundScheduleService
{


    /**
     * 檢查每個背景服務,並確認使用到這個背景服務的程式需要運作
     */
    public static function runBackgroundService()
    {
      $schedulers=Scheduler::where('next_at','<=',Carbon::now())->get();
      for($i=0;$i<count($schedulers);$i++){
          $scheduler=$schedulers[$i];
          $target=$scheduler->target;
          $targetObj=new $target();
          call_user_func(array($targetObj, 'run'),$scheduler->id,$scheduler->scheduler_id,Carbon::now());
          $expression = new CronExpression($scheduler->scheduler_cron);
          //計算下次再呼叫
          $scheduler->next_at=$expression->getNext();
          $scheduler->save();
      }
    }

   
}