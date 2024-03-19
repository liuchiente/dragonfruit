<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Providers\RouteServiceProvider;

use Exception;

use App\Services\LineService;
use App\Models\LineAuth;
use App\Models\User;


class LoginController extends Controller
{
    protected $lineService;

    public function __construct(LineService $lineService)
    {
        $this->lineService = $lineService;
    }

    public function pageLine()
    {
        $url = $this->lineService->getLoginBaseUrl();
        return view('line.login')->with('url', $url);
    }

    public function lineLoginCallBack(Request $request)
    {
        try {
            $error = $request->input('error', false);
            if ($error) {
                throw new Exception($request->all());
            }
            $code = $request->input('code', '');
            $response = $this->lineService->getLineToken($code);
            $user_profile = $this->lineService->getUserProfile($response['access_token']);

            $lineAuth=LineAuth::where('line_user_id',$user_profile['userId'])->first();
            if($lineAuth==null){
                //儲存Line Auth登入記錄
                $lineAuth=new LineAuth();
                $lineAuth->line_user_id=$user_profile['userId'];
                $lineAuth->line_display_name=$user_profile['displayName'];
                $lineAuth->line_status_msg=$user_profile['statusMessage'];
                $lineAuth->line_pic_url=$user_profile['pictureUrl'];
  
                $user=new User();
                $user->name=$user_profile['displayName'];
                $user->email="";
                $user->email_verified_at=null;
                $user->phone="";
                $user->phone_verified_at=null;
                $user->birthday="";
                $user->password="";
                $user->remember_token="";
                $user->save();
                
                $lineAuth->user_id=$user->id;
                $lineAuth->save();

                //login user
                Auth::loginUsingId($user->id);

            }else{
                $user=User::where('id',$lineAuth->user_id)->first();
                Auth::loginUsingId($user->id);
            }

           
        } catch (Exception $ex) {
            Log::error($ex);
        }

        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
