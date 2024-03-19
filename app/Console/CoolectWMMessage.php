<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \Log;

class CoolectWMMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'collect:wmmessage';

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
        $res=$this->reqMessage();
		$this->sendMessageActive($res);
    }
	
	private static function sendMessageActive($message){
		$eng=curl_init();		
		$messagePackage=[];
		$messagePackage["Message"]=$message;
		$messagePayload=http_build_query($messagePackage);
		curl_setopt_array($eng, array(
		  CURLOPT_URL =>"https://notify-api.line.me/api/notify",
		  CURLOPT_RETURNTRANSFER => false,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$messagePayload,
		  CURLOPT_SSL_VERIFYPEER =>false,
		  CURLOPT_HTTPHEADER => array(
			"Content-Type:application/x-www-form-urlencoded",
			"Authorization:Bearer rMXROO2zc7jArcYrmQx9Caxzahd4GBZcHA0ePPF9fwb"
		  ),
		));
		$receive=curl_exec($eng);
		$err = curl_error($eng);
		curl_close($eng);
		if ($err) {
			Log::info("cURL Error #:" . $err);
		  } else {
			Log::info(receive);
		  }
        return;
    }
	
	private static function reqMessage(){
		$eng=curl_init();
		curl_setopt_array($eng, array(
		  CURLOPT_URL =>"http://60.199.132.186/s.php",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_SSL_VERIFYPEER =>false,
		  CURLOPT_USERAGENT=>'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13',
		));
		$receive=curl_exec($eng);
		var_dump($receive);
		$err = curl_error($eng);
		var_dump($err);
		curl_close($eng);
		Log::info($receive);
        return $receive;
    }
}
