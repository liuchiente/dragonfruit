<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use App\Models\Employee;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserToken;
use App\Models\InboxNotification;
use App\Models\Inbox;
use App\Models\InboxUser;
use App\Models\Organization;



class EnterpriseService
{
    /**
     * 發送 HTTP 請求並處理回應
     *
     * @param string $userAccount 用戶帳號
     * @param string $userPassword 用戶密碼
     * @return mixed
     */
    public function pushMessage($empolyee, $tilte, $message ,$from, $send_at=null)
    {
        $user_ids=[];
        if(count($empolyee)>0){
            //有指定發送人
            $userProfiles=UserProfile::with(['empolyee' => function ($query) use ($empolyee) {
                $query->whereIn('emp_no', $empolyee); 
            }])->get();
            $user_ids=array_unique($userProfiles->pluck('user_id')->toArray());
        }else{
            $organization=Organization::where('name',$from)->first();
            //沒指定發送人
            $userProfiles=UserProfile::where('organization_id',$organization->id)->get();
            $user_ids=array_unique($userProfiles->pluck('user_id'));
        }
        if(count($user_ids)>0){
            

            $send_at_timestamp= strtotime($send_at);
            $send_time=$send_at_timestamp === false ? Carbon::now() : Carbon::createFromTimestamp($send_at_timestamp);

            $inbox_users = collect($user_ids)->map(function ($user_id) use ($tilte, $message, $send_time) {
                return [
                    'user_id' => $user_id
                ];
            })->toArray();


            $inbox = [
                'title' => $tilte,
                'message' => $message,
                'user_id' => 0,
                'status'=>'completed',
                'due_date'=>$send_time,
                'send_at'=>$send_time,
                'team'=>'ALL',
                'like'=>[],
                'type' =>'notification',
                'action'=>'view'
            ];

            //新增通知訊息
            //新增參與人
            DB::transaction(function () use ($inbox_users,$inbox) {
                $inboxObj=Inbox::create($inbox);
  
                $inbox_users = array_map(function($item) use($inboxObj) {
                    $item['inbox_id'] =  $inboxObj->id;
                    return $item;
                }, $inbox_users);
                
                InboxUser::insert($inbox_users); 
            });

        }
        return $userProfiles;
        
    }


}