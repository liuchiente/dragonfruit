<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Carbon\Carbon;

use App\Models\Inbox;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserToken;

use App\Models\InboxNotification;


use Illuminate\Support\Facades\Log;


class NotificationService
{
   public static function genereateMessage(){

        /*$inboxes=Inbox::with('users')::where('queue_at','<=',Carbon::now())->whereNotNull('queue_at')->get();
 
        
        //組合inbox_notifications資料
        $inboxes->map(function ($inbox){
            $user_ids=$inbox->users->plurk('id');
            $user_tokens=UserToken::whereIn('user_id',$user_ids)->where('token_type',1)->whereNotNull('token')->get()->only(['user_id','token']);



            return [
                'title' => $tilte,
                'message' => $message,
                'user_id' => $user_token['user_id'],
                'token' => $user_token['token'],
                'send_date' => $send_time
            ];
        })->toArray();

        /*DB::transaction(function () use ($inbox_notifications,$inbox_users,$inbox) {
            $inboxObj=Inbox::create($inbox);
            $inbox_notifications = array_map(function($item) use($inboxObj) {
                $item['inbox_id'] =  $inboxObj->id;
                return $item;
            }, $inbox_notifications);

            $inbox_users = array_map(function($item) use($inboxObj) {
                $item['inbox_id'] =  $inboxObj->id;
                return $item;
            }, $inbox_users);

            InboxNotification::insert($inbox_notifications); 
            InboxUser::insert($inbox_users); 
        });*/

        $results = DB::table('inboxes')
        ->join('inbox_user', 'inboxes.id', '=', 'inbox_user.inbox_id')  // 連接 inbox_users 和 inboxes
        ->join('user_tokens', 'inbox_user.user_id', '=', 'user_tokens.user_id')  // 連接 inbox_users 和 user_tokens
        ->where('inboxes.send_at','<=',Carbon::now())->whereNotNull('inboxes.message')->whereNull('inboxes.queue_at')->whereNotNull('user_tokens.token')
        ->select('inboxes.*','user_tokens.*','inbox_user.inbox_id')  // 選擇所需的欄位
        ->get();

        /*$inbox_notifications =$results->map(function($data){
             return [
                'title' => $data->title,
                'message' => $data->message,
                'user_id' => $data->user_id,
                'token' => $data->token,
                'send_at' => $data->send_at,
                'inbox_id'=>$data->inbox_id,
            ];
        });*/


        $grouped = $results->groupBy(function ($notifications) {
            return $notifications->inbox_id;
        });


        $grouped->map(function ($group) { 

            $inbox_id=$group->first()->inbox_id;

             $data = [
                'title' => $group->first()->title,
                'message' =>$group->first()->message,
                'user_ids' => $group->pluck('user_id')->unique()->toArray(),
                'tokens' => $group->pluck('token')->unique()->toArray(),
                'send_at' => $group->first()->send_at,
                'inbox_id'=>$inbox_id,
            ];



            DB::transaction(function () use ($data,$inbox_id) {
                InboxNotification::create($data); 
                Inbox::where('id',$inbox_id)->update(['queue_at'=>Carbon::now()]); 
            });
        });

   }

    
}