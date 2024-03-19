<?php

namespace App\Services;

use Illuminate\Support\Str;
use GuzzleHttp\Client;



/**
 * Line Notify 服務
 */
class LineNotifyService
{
    /**
     *  取認證網址
     */
    public function getSeriveRegisterBaseUrl()
    {
        $seed= Str::random(64);
        session(['line_seed' => $seed]);
        // 組成 Line Login Url
        $url = config('line.authorize_base_url') . '?';
        $url .= 'response_type=code';
        $url .= '&client_id=' . config('line.channel_id');
        $url .= '&redirect_uri=' . config('app.url') . '/callback/linenotify';
        $url .= '&state='.$seed; // 暫時固定方便測試
        $url .= '&scope=notify';
        return $url;
    }

    public function getLineNotifyToken($code)
    {
        $client = new Client();
        $response = $client->request('POST', config('line.get_token_url'), [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => config('app.url') . '/callback/linenotify',
                'client_id' => config('line.channel_id'),
                'client_secret' => config('line.secret')
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }

}