<?php

namespace App\Http\Controllers\Line;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Carbon\Carbon;

use App\Services\LineNotifyService;
use App\Services\ScheduleService;

class NotifyDataController extends Controller
{
    
    /**
     * 修改Line Notify Token資料
     */
    public function getOneChannel(Request $request)
    {
        try {
            $request->validate([
                'channel' => ['required','numeric']
            ]);
            $user=Auth::user();
            $param=collect($request->only(['channel']))->merge(['user_id'=>$user->id]);
            $lineNotifyService=new LineNotifyService();
            $notifyChannel=$lineNotifyService->getLineNotifyChannel($param);
        } catch (Exception $ex) {
            Log::error($ex);
        }
         return view('line.notify.channel',['channel'=>$notifyChannel]);
    }

    public function saveOneChannel(Request $request)
    {
         try {
           $request->validate([
                'channel' => ['required','numeric'],
                'title' => ['required','string'],
                'status' => ['required','numeric'],
                'type' => ['required','numeric'],
            ]);

            $user=Auth::user();
            $param=collect($request->only(['channel','title','status','type']))->merge(['user_id'=>$user->id]);
            $lineNotifyService=new LineNotifyService();
            $lineNotifyService->saveLineNotifyChannel($param);
        } catch (Exception $ex) {
            Log::error($ex);
        }
        return redirect()->route('notify.token.show')->with('active-message',__('Saved.'))->with('active-tittle',"頻道設定");
    }

    public function getManyChannel(Request $request)
    {
        try {
            $user=Auth::user();
            $param=collect(['user_id'=>$user->id]);
            $lineNotifyService=new LineNotifyService();
            $notifyChannels=$lineNotifyService->getManyLineNotifyChannel($param);
        } catch (Exception $ex) {
            Log::error($ex);
        }
       return view('line.notify.channellist',['channels'=>$notifyChannels]);
    }

    /**
     * 修改Line Notify Template資料
     */
    public function getOneTemplate(Request $request){
         try {
            $request->validate([
                'template' => ['required','numeric']
            ]);
            $user=Auth::user();
            $param=collect($request->only(['template']))->merge(['user_id'=>$user->id]);
            $lineNotifyService=new LineNotifyService();
            $notifyTemplate=$lineNotifyService->getLineNotifyTemplate($param);
            $notifyChannels=$lineNotifyService->getManyLineNotifyChannel($param);
        } catch (Exception $ex) {
            Log::error($ex);
        }

         return view('line.notify.template',['template'=>$notifyTemplate,'channels'=>$notifyChannels]);
    }

    public function addOneTemplate(Request $request){
        $user=Auth::user();
        $param=collect($request->only(['template']))->merge(['user_id'=>$user->id]);
        $lineNotifyService=new LineNotifyService();
        $notifyChannels=$lineNotifyService->getManyLineNotifyChannel($param);
        return view('line.notify.template',['channels'=>$notifyChannels]);
    }


    public function saveOneTemplate(Request $request){
        $validated =$request->validate([
            'plan_title' => ['required','string'],
            'plan_context' => ['required', 'string'],
            'channel' => ['required', 'numeric'],
            'scheduler_cron' => ['required','string'],
            'status' => ['required', 'numeric'],
            'scheduler' => ['required', 'numeric'],
            'template' => ['required', 'numeric'],
        ]);

        $user=Auth::user();
        $scheduleService=new ScheduleService();
        $paramScheduler=collect($request->only(['scheduler','scheduler_cron']))->merge(['target'=>' App\Services\LineNotifyMessageService']);
        
        $scheduler=$scheduleService->saveOrUpdateSchedule($paramScheduler);
        
        $lineNotifyService=new LineNotifyService();
        $paramTemplate=collect($request->only(['plan_title','plan_context','status','template','channel','scheduler_cron']))->merge(['plain_schedule'=>$scheduler->id]);
        $lineNotifyService->saveLineNotifyTemplate($paramTemplate);
     
        return redirect()->route('notify.template.show')->with('active-message',__('Saved.'))->with('active-tittle',"範本設定");
    }

    public function getManyTemplate(Request $request)
    {
        try {
            $user=Auth::user();
            $param=collect(['user_id'=>$user->id]);
            $lineNotifyService=new LineNotifyService();
            $notifyTemplates=$lineNotifyService->getManyLineNotifyTemplate($param);
        } catch (Exception $ex) {
            Log::error($ex);
        }
       return view('line.notify.templatelist',['templates'=>$notifyTemplates]);
    }

    public function getManyMessage(Request $request)
    {
        try {
            $user=Auth::user();
            $param=collect(['user_id'=>$user->id]);
            $lineNotifyService=new LineNotifyService();
            $notifyMessages=$lineNotifyService->getManyLineNotifyMessage($param);
        } catch (Exception $ex) {
            Log::error($ex);
        }
       return view('line.notify.messagelist',['messages'=>$notifyMessages]);
    }
}
