<?php

namespace App\Services;

use Illuminate\Support\Str;
use GuzzleHttp\Client;
use \DB;
use Log;
use Carbon\Carbon;

use App\Models\LineNotifyTemplate;
use App\Models\LineNotifyMessage;

/**
 * Line Notify Message 服務
 */
class LineNotifyMessageService extends AbsractScheduler
{

    public function job($shceduler_id,$shceduler_no,$shceduler_now){
        $templates=LineNotifyTemplate::join('line_notify_channel', 'line_notify_channel.id', '=', 'line_notify_plaintext.plain_channel')->where('line_notify_plaintext.send_at','<=',$shceduler_now)
        ->where('line_notify_plaintext.plain_schedule',$shceduler_id)->where('line_notify_plaintext.plan_status',1)->where('line_notify_channel.chl_status',1)
        ->get();
        for($i=0;$i<count($templates);$i++){
            $template=$templates[$i];
            $uuid=str_replace('-','',(string)Str::orderedUuid());
            $lineNotifyMessage=new LineNotifyMessage();
            $lineNotifyMessage->msg_id=$uuid;
            $lineNotifyMessage->msg_title=$template->plan_title;
            $lineNotifyMessage->msg_context=$template->plan_context;
            $lineNotifyMessage->plan_id=$template->id;
            $lineNotifyMessage->chl_id=$template->plain_channel;
            $lineNotifyMessage->chl_type=1;
            $lineNotifyMessage->msg_status=1;
            $lineNotifyMessage->send_at=$shceduler_now;
            $lineNotifyMessage->comment='Line Notify Plain Mesage '.$shceduler_no;
            $lineNotifyMessage->save();

            //更新時間
            $template->send_at=$shceduler_now;
            $template->save();
        }
    }

	
}