<?php

namespace App\Services;

use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;

use App\Models\Scheduler;


class ScheduleService
{

    private const _ID_PREFIX='SCH';
    private const _ID_LEN=10;

    public static function getDefinedId($str){
        return self::_ID_PREFIX.Str::padLeft($str, self::_ID_LEN, '0');
    }

    public function saveOrUpdateSchedule($param)
    {
      $scheduler=Scheduler::where('scheduler_cron',$param['scheduler_cron'])->where('target',$param['target'])->first();
      if($scheduler==null){
        $scheduler=new Scheduler();
        $scheduler->scheduler_cron=$param['scheduler_cron'];
        $scheduler->target=$param['target'];
        $scheduler->next_at=Carbon::now()->addMinute(10);
        $scheduler->scheduler_id=self::getDefinedId(Scheduler::next());
        $scheduler->save();
      }
      return $scheduler;
    }

   
}