<?php

namespace App\Services;

use Illuminate\Support\Str;
use GuzzleHttp\Client;
use \DB;
use Log;

use App\Models\LineNotifyTemplate;
use App\Models\LineNotifyMessage;

abstract class AbsractScheduler
{

    public function run($shceduler_id,$shceduler_no,$shceduler_now){
        $this->job($shceduler_id,$shceduler_no,$shceduler_now);
        return;
    }

    abstract protected function job($shceduler_id,$shceduler_no,$shceduler_now);

	
}