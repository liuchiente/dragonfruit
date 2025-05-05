<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\EnterpriseService;


class EnterpriseController extends Controller
{
    protected $enterpriseservice;

    public function __construct(EnterpriseService $enterpriseservice)
    {
        $this->enterpriseservice = $enterpriseservice;
    }


    /**
     *  提供第三方公司使用API推播訊息給APP使用者
     */
    public function notify(Request $request)
    {
        $key = $request->input('key');
        $from = $request->input('from');
        $tilte = $request->input('title');
        $message = $request->input('message');
        $send_at = $request->input('send_at');
        $users= collect($request->get('to'));
        try {
            
            $user = $this->enterpriseservice->pushMessage($users, $tilte, $message , $from , $send_at=null);

            return response()->json([
                'message' => 'push message successful',
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
/**
  {
  "key": "d421d5q1d542153q432q4w32",
  "tilte": "aa",
  "message": "xxxxx",
  "send_at": "2022-02-03 15:55",
  "from": "fonlee",
  "to": [
    "emo01",
    "emo02",
    "emo03"
  ]
}
 */
}
