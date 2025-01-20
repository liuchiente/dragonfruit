<?php

namespace App\Http\Controllers\Line;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;

use App\Providers\RouteServiceProvider;

use Exception;

use App\Services\LineNotifyService;
use App\Models\LineNotifyToken;


class NotifyController extends Controller
{
    protected $linenotifyService;

    public function __construct(LineNotifyService $linenotifyService)
    {
        $this->linenotifyService = $linenotifyService;
    }

    public function addOneChannel()
    {
        $url = $this->linenotifyService->getSeriveRegisterBaseUrl();
        return redirect($url);
    }

    public function lineNotifyCallBack(Request $request)
    {
        try {
            $error = $request->input('error', false);
            if ($error) {
                throw new Exception($request->all());
            }
            $code = $request->input('code', '');
            $response = $this->linenotifyService->getLineNotifyToken($code);

            //Line Notify Token
            $token=$response['access_token'];
            $user_id = Auth::id();

            $lineNotifyToken=LineNotifyToken::where('chl_tag',$token)->where('user_id',$user_id)->first();

            if($lineNotifyToken==null){
                $lineNotifyToken=new LineNotifyToken();
            }

            $lineNotifyToken->user_id=$user_id;
            $lineNotifyToken->chl_id=Carbon::now()->timestamp;;
            $lineNotifyToken->chl_tag=$token;
            $lineNotifyToken->chl_title='';
            $lineNotifyToken->chl_type=1;
            $lineNotifyToken->save();
            //儲存到資料庫
            
        } catch (Exception $ex) {
            Log::error($ex);
        }
        //重新導向到編輯畫面,預設帶入token代號
        return redirect()->route('notify.token.edit', ['channel' =>  $lineNotifyToken->id]);
    }

   
}
