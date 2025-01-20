<?php

namespace App\Services;

use Illuminate\Support\Str;
use GuzzleHttp\Client;
use \DB;
use Log;
use Carbon\Carbon;

use Poliander\Cron\CronExpression;

use App\Models\LineNotifyToken;
use App\Models\LineNotifyTemplate;
use App\Models\LineNotifyMessage;

/**
 * Line Notify 服務
 */
class LineNotifyService
{

    private const _ID_PREFIX='LTP';
    private const _ID_LEN=10;

    public static function getDefinedId($str){
        return self::_ID_PREFIX.Str::padLeft($str, self::_ID_LEN, '0');
    }


    /**
     *  取認證網址
     */
    public function getSeriveRegisterBaseUrl()
    {
        $seed= Str::random(64);
        session(['line_seed' => $seed]);
        // 組成 Line Login Url
        $url = config('line.bot_notify_base_url') . '?';
        $url .= 'response_type=code';
        $url .= '&client_id=' . config('line.line_notify_client');
        $url .= '&redirect_uri=' . config('app.url') . '/callback/notify-channel';
        $url .= '&state='.$seed; // 暫時固定方便測試
        $url .= '&scope=notify';
        return $url;
    }

    public function getLineNotifyToken($code)
    {
        $client = new Client();
        $response = $client->request('POST', config('line.get_bot_notify_token_url'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => config('app.url') . '/callback/notify-channel',
                'client_id' => config('line.line_notify_client'),
                'client_secret' => config('line.line_notify_secret')
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * 發送Line Notify訊息
     * 使用SQL查詢,不使用ORM
     */
    public static function sendLineNotifyMessage(){
		$messages = DB::table('line_notify_message')
                ->select('line_notify_message.msg_id', 'line_notify_message.msg_title', 'line_notify_message.msg_context', 'line_notify_message.plan_id', 'line_notify_message.chl_id','line_notify_channel.chl_tag')
				->join('line_notify_channel', 'line_notify_message.chl_id', '=', 'line_notify_channel.id')
                ->where('line_notify_channel.chl_status','=',1)
				->where('line_notify_message.msg_status','=',1)
				->where('line_notify_message.send_at','<=',Carbon::now())
				->whereNull('line_notify_message.sent_at')
                ->get();
		$eng=curl_init();
		for($i=0;$i<count($messages);$i++){
			$message=$messages[$i];
			self::sendMessageActive($message,$eng);
			//100ms
			usleep( 100 );
		}
		curl_close($eng);
	}
	
	/**
    *   發送消息用引擎
    */
    private static function sendMessageActive($message,$eng){		
		$messagePackage=[];
		$messagePackage["Message"]=$message->msg_context;
		$messagePayload=http_build_query($messagePackage);
		curl_setopt_array($eng, array(
		  CURLOPT_URL =>"https://notify-api.line.me/api/notify",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$messagePayload,
		  CURLOPT_SSL_VERIFYPEER =>false,
		  CURLOPT_HTTPHEADER => array(
			"Content-Type:application/x-www-form-urlencoded",
			"Authorization:Bearer ".$message->chl_tag
		  ),
		));
		$receive=curl_exec($eng);
		$err = curl_error($eng);
		if ($err) {
			Log::info("cURL Error #:" . $err." ".$message->chl_tag);
		  } else {
			$respose=json_decode($receive,true);
			if(isset($respose['status'])&&($respose['status']=='200'||$respose['status']==200)){
				DB::table('line_notify_message')->where('msg_id', $message->msg_id)
				->update(['msg_status' => 2,'updated_at'=> Carbon::now(),'sent_at'=> Carbon::now()]);
			}else{
				DB::table('line_notify_message')->where('msg_id', $message->msg_id)
				->update(['msg_status' => 0,'updated_at'=> Carbon::now(),'sent_at'=> Carbon::now(),'comment'=>$receive]);
			}
		  }
        return;
    }


	/**
	 * 取得Line Notify Token
	 */
	public function getLineNotifyChannel($param){
		$lineNotifyToken=LineNotifyToken::where('id',$param['channel'])->where('user_id',$param['user_id'])->first();
        return $lineNotifyToken;
    }

	/**
	 * 取得Line Notify Token
	 */
	public function getManyLineNotifyChannel($param){
		$lineNotifyToken=LineNotifyToken::where('user_id',$param['user_id'])->get();
        return $lineNotifyToken;
    }


	/**
	 * 儲存Line Notify Token
	 */
	public function saveLineNotifyChannel($param){
		//先檢查原先的Token是不是已經存在,是的話則修改原本的資料
		$lineNotifyToken=LineNotifyToken::where('id',$param['channel'])->where('user_id',$param['user_id'])->first();
		if($lineNotifyToken==null){
			$lineNotifyToken=new LineNotifyToken();
		}
		$lineNotifyToken->chl_type=$param['type'];
		$lineNotifyToken->chl_status=$param['status'];
		$lineNotifyToken->chl_title=$param['title'];
		$lineNotifyToken->save();

    }

	/**
	 * 取得Line Notify Template
	 */
	public function getLineNotifyTemplate($param){
		$lineNotifyTemplate=LineNotifyTemplate::join('line_notify_channel', 'line_notify_channel.id', '=', 'line_notify_plaintext.plain_channel')->join('scheduler', 'scheduler.id', '=', 'line_notify_plaintext.plain_schedule')->where('line_notify_plaintext.id',$param['template'])->where('user_id',$param['user_id'])
		->select('line_notify_plaintext.*','scheduler.scheduler_cron')->first();
        return $lineNotifyTemplate;
    }

	/**
	 * 取得Line Notify Template
	 */
	public function getManyLineNotifyTemplate($param){
		$lineNotifyTemplate=LineNotifyTemplate::join('line_notify_channel', 'line_notify_channel.id', '=', 'line_notify_plaintext.plain_channel')->where('line_notify_channel.user_id',$param['user_id'])->get();
        return $lineNotifyTemplate;
    }

	/**
	 * 儲存Line Notify Template
	 */
	public function saveLineNotifyTemplate($param){
		//先檢查原先的是不是已經存在,是的話則修改原本的資料
		$lineNotifyTemplate=LineNotifyTemplate::where('id',$param['template'])->first();
		if($lineNotifyTemplate==null){
			$lineNotifyTemplate=new LineNotifyTemplate();
			$lineNotifyTemplate->plan_id=self::getDefinedId(LineNotifyTemplate::next());
		}

		$lineNotifyTemplate->plan_title=$param['plan_title'];
		$lineNotifyTemplate->plan_context=$param['plan_context'];
		$lineNotifyTemplate->plain_channel=$param['channel'];
		$lineNotifyTemplate->plain_schedule=$param['plain_schedule'];
		$lineNotifyTemplate->plan_status=$param['status'];		
		
		//計算下次再呼叫時間
		$expression = new CronExpression($param['scheduler_cron']);
		$lineNotifyTemplate->send_at=Carbon::createFromTimestamp($expression->getNext());
        $lineNotifyTemplate->save();

    }

	public function getManyLineNotifyMessage($param){
		$lineNotifyMessage=LineNotifyMessage::join('line_notify_channel', 'line_notify_channel.id', '=', 'line_notify_message.chl_id')->where('line_notify_channel.user_id',$param['user_id'])->get();
        return $lineNotifyMessage;
    }

	
}