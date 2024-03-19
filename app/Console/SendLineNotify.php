<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Log;

class SendLineNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:linenotify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$this->sendLineNotifyMessage();
    }
	
	private function sendLineNotifyMessage(){
		$messages = DB::table('message')
                ->select('message.msg_id', 'message.msg_title', 'message.msg_context', 'message.plan_id', 'message.chl_id','channel.chl_tag')
				->join('channel', 'message.chl_id', '=', 'channel.chl_id')
                ->where('channel.chl_status','=',1)
				->where('message.msg_status','=',1)
				->where('message.d_send','<=',DB::raw('now()'))
                ->get();
		$eng=curl_init();
		for($i=0;$i<count($messages);$i++){
			$message=$messages[$i];
			$this->sendMessageActive($message,$eng);
			//10ms
			usleep( 10000 );
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
		//var_dump($receive);
		$err = curl_error($eng);
		if ($err) {
			Log::info("cURL Error #:" . $err." ".$message->chl_tag);
		  } else {
			$respose=json_decode($receive,true);
			//var_dump($respose);
			if(isset($respose['status'])&&($respose['status']=='200'||$respose['status']==200)){
				DB::table('message')->where('msg_id', $message->msg_id)
				->update(['msg_status' => 2,'d_upd'=> DB::raw('now()'),'d_sent'=> DB::raw('now()')]);
			}else{
				DB::table('message')->where('msg_id', $message->msg_id)
				->update(['msg_status' => 0,'d_upd'=> DB::raw('now()'),'d_sent'=> DB::raw('now()'),'comment'=>$receive]);
			}
		  }
        return;
    }
	
	
}
