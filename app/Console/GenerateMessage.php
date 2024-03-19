<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use \DB;

class GenerateMessage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gen:message';

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
        $this->GenNotifyMessage();
    }
	
	private function GenNotifyMessage(){
		$plaintexts = DB::table('plaintext')
                ->select('plan_id', 'plan_title', 'plan_context', 'plan_status','plain_channel','d_send')
                ->where('plan_status', '=', 1)->take(100)
                ->get();
		$channels = DB::table('channel')
                ->select('chl_id')
                ->where('chl_status', '=', 1)
                ->get();
		$addArry=[];
		for($i=0;$i<count($plaintexts);$i++){
			$plaintext=$plaintexts[$i];
			for($j=0;$j<count($channels);$j++){
				$channel =$channels[$j];
				if($plaintext->plain_channel=='0'||$plaintext->plain_channel==$channel->chl_id){
					$uuid=str_replace('-','',(string)Str::orderedUuid());
					$addArry[]=['msg_id'=>$uuid,'msg_title'=>$plaintext->plan_title, 'msg_context'=>$plaintext->plan_context, 'plan_id'=>$plaintext->plan_id, 'chl_id'=>$channel->chl_id,'chl_type'=>1, 'msg_status'=>1,'d_send'=>$plaintext->d_send,'comment'=>'Line Notify Mesage'];
				}
			}
		}
		DB::beginTransaction();
		for($i=0;$i<count($addArry);$i++){
			$add=$addArry[$i];
			DB::table('message')->insert($add);
			DB::table('plaintext')->where('plan_id', $add['plan_id'])
            ->update(['plan_status' => 2,'d_upd'=> DB::raw('now()')]);
		}
		DB::commit();
		
			
		
	}
	
	
	
}
