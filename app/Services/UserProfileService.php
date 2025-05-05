<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

use Carbon\Carbon;

use App\Models\Employee;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserToken;

use Illuminate\Support\Facades\Auth;

class UserProfileService
{

    public function getUser($user, $organization_id,$device)
    {

        $organization_id=($organization_id==null||$organization_id=='')?$user->organization_id:$organization_id;

        $user_data=[];
        //$user_data['profiles']=$user->profiles;
        $user_data['organization']=[];

        $user_data['sign_in_provider']='';
        $user_data['auth_token']='';
        $user_data['id']='';
        $user_data['name']=$user->name;
        $user_data['picture']='';
        $user_data['user_id']='';
        $user_data['email']=$user->email;
        $user_data['uid']='';
        $user_data['organization_id']=$organization_id;
        $user_data['team']='';
        $user_data['fcm_token']='';
        $user_data['created_at']=$user->created_at;
        $user_data['updated_at']=$user->updated_at;

        //如果指定了組織代號
        if($organization_id!=0){

            $profile=$user->profiles->filter(function ($profile) use($organization_id) {
                return $profile->organization_id == $organization_id;
            })->first();

            $user_data['organization']=$profile->organization;
            $user_data['id']=$profile->id??'';
            $user_data['name']=$user->name;
            $user_data['picture']=$profile->picture??'';
            $user_data['user_id']=$user->id;
            $user_data['email']=$profile->email??'';
            $user_data['sign_in_provider']='CUSTOMER';
            $user_data['uid']=$profile->uid??'';
            $user_data['team']=$profile->team??'';
            $user_data['phone_number']=$profile->phone_number??'';
        }else{
            
            $profile=$user->profile;
            $user_data['organization']=$profile->organization;
            $user_data['id']=$profile->id??'';
            $user_data['name']=$user->name;
            $user_data['picture']=$profile->picture??'';
            $user_data['user_id']=$user->id;
            $user_data['email']=$profile->email??'';
            $user_data['sign_in_provider']='CUSTOMER';
            $user_data['uid']=$profile->uid??'';
            $user_data['team']=$profile->team??'';
            $user_data['phone_number']=$profile->phone_number??'';
        }

        $token=$user->tokens->filter(function ($token) use($device) {
            return $token->name == $device;
        })->first();
        $user_data['fcm_token']=$token->token??'';
       return $user_data;
    }

  

}