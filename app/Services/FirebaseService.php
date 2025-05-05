<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


use Carbon\Carbon;

use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

use App\Models\Employee;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserToken;
use App\Models\InboxNotification;


class FirebaseService
{
    /**
     * 發送 HTTP 請求並處理回應
     *
     * @param string $userAccount 用戶帳號
     * @param string $userPassword 用戶密碼
     * @return mixed
     */
    public function updateUserPushTokenFcm($user, $fcmToken, $deviceName)
    {
        
        // Update user's FCM token
        //移除相同使用者、裝置卻不同Token的紀錄
        /*UserToken::where('token', '<>', $fcmToken)->where(function($query) {
            $query->where('user_id', '<>', $user->id)->
            ->orWhere('name', '<>', $deviceName)  ;
        })->update([
            'token' => null,
        ]);*/

        if($fcmToken<>''){

            UserToken::where('token', '<>', $fcmToken)->where('name', '=', $deviceName)->where('user_id', '=', $user->id)->update([
                'token' => null,
            ]);

            //移除相同Token、使用者卻不同裝置的紀錄
            UserToken::where('token', '=', $fcmToken)->where('name', '<>', $deviceName)->where('user_id', '=', $user->id)->update([
                'token' => null,
            ]);

        }

        $userToken=UserToken::updateOrCreate(['name' => $deviceName,'user_id' => $user->id],['name' => $deviceName,'user_id' => $user->id,'token' => $fcmToken,'token_type' => 1]);
        //$user->update(['fcm_token' => $fcmToken]);

    }

    protected $messaging;

    public function __construct()
    {
        //初始化推播物件
        $this->messaging = app('firebase.messaging');
    }

    public  function sendPushMessage(){
        $inboxNotification=InboxNotification::whereJsonLength('tokens', '>', 0)->where('send_at','<=',Carbon::now())->whereNull('sent_at')->get();
        
        $grouped = $inboxNotification->groupBy(function ($notfiy) {
            return $notfiy['title'] . '-' . $notfiy['message'];
        });

        $grouped->map(function ($group) { 

            $ids=$group->pluck('id')->toArray();
            $tokens=$group->pluck('tokens')->toArray();
            $title=$group->first()['title'];
            $message=Str::limit($group->first()['message'], 30);
            $inbox_id=$group->first()['inbox_id'];

            //notify data
            $data = [
                'type' => 'inbox',
                'index' => $inbox_id,
                'tips' =>'你有一封新訊息',
                'audio' =>'inbox.mp3'
            ];

            $tokens = collect($tokens)->flatten()->unique()->toArray();   // 去除重複元素
            $this->sendMultiplePushNotification($tokens,$title,$message,$data);
            InboxNotification::whereIn('id',$ids)->update(['sent_at'=>Carbon::now()]); 
            //暫停100ms,避免失敗
            usleep(100);
        });

    }    

    public  function sendPushNotification($deviceToken, $title, $body, $data)
    {
        // 設置推播訊息
        $message = CloudMessage::new()
            ->withTarget($deviceToken) // 目標設備的 FCM Token
            ->withNotification([
                'title' => $title,
                'body' => $body,
            ])->withData($data);

        $message = CloudMessage::new()->withNotification(Notification::create($title, $body));

        // 發送訊息
        try {
            $this->messaging->send($message);
            return response()->json(['status' => 'success', 'message' => 'Notification sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }


    public  function sendMultiplePushNotification($deviceTokens, $title, $body, $data)
    {

        //組合發送資料
        $message = CloudMessage::new()->withNotification(Notification::create($title, $body))->withData($data);;
        try {
            // 發送訊息
            $sendReport = $this->messaging->sendMulticast($message, $deviceTokens);

            Log::info('Successful sends: '.$sendReport->successes()->count());
            Log::info('Failed sends: '.$sendReport->failures()->count());

            if ($sendReport->hasFailures()) {
                foreach ($sendReport->failures()->getItems() as $failure) {
                    Log::info($failure->error()->getMessage());
                }
            }

            // 更新異常的推播裝置
            $unknownTargets = $sendReport->unknownTokens(); // string[]
            $invalidTargets = $resensendReportdReportport->invalidTokens(); // string[]
    
            UserToken::whereIn('token', $unknownTargets)
                ->update(['token' => null]);
            UserToken::whereIn('token', $invalidTargets)
            ->update(['token' => null]);

            return response()->json(['status' => 'success', 'message' => 'Notification sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    
}