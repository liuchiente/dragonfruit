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

class EmployeeService
{
    /**
     * 發送 HTTP 請求並處理回應
     *
     * @param string $userAccount 用戶帳號
     * @param string $userPassword 用戶密碼
     * @return mixed
     */
    public function loginWithEmployee($userAccount, $userPassword)
    {
        $url = 'https://www.fonlee.com.tw/app/wrapper/transfer_employee.php';
        
        // 發送 POST 請求
        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Cookie' => 'PHPSESSID=9tprnljd0s8smumj8p42vohfm4'
        ])
        ->asForm()
        ->post($url, [
            'tDataWrapper[type]' => 'getUserLogin',
            'tDataWrapper[pack][userAccount]' => $userAccount,
            'tDataWrapper[pack][userPassword]' => $userPassword,
            'tDataWrapper[pack][userLoginType]' => 'employee',
        ]);

        // 去除 HTML 標籤
        $cleanString = strip_tags($response->body());

        // 嘗試將字串轉換為 JSON 物件
        $data = json_decode($cleanString, true);

        // 判斷是否成功（code 200）
        if ($response->successful() && $data['code'] === '200') {
            // 取得回應的資料
            $data = $response->json();

            // 更新或儲存用戶數據
            $user=$this->updateUser($data['pack']);
            $this->updateUserProfiles($data['pack'],$user);
            $this->updateUserEmployee($data,$userPassword,$user);
            
            return $user; // 返回處理後的數據
        } else {
            //  如果回應碼不是200，丟出異常
            throw new \Exception('API 回應失敗：' . $data['message']);
        }
    }

    /**
     * 更新或儲存用戶資料
     *
     * @param array $userData 用戶資料
     * @return void
     */
    protected function updateUserEmployee($userData,$pass,$user)
    {
        // 嘗試找到對應的用戶
        $user = Employee::updateOrCreate(
            [
                'emp_account' => $userData['pack']['userAccount'],
                'emp_no' => $userData['pack']['staffCode']
            ], // 假設 'user_account' 是唯一識別
            [
                'emp_password' => $pass,
                'user_id' =>$user->id,
                'emp_id' => $userData['pack']['userID'],
                'emp_name' => $userData['pack']['username'],
                'email' => $userData['pack']['email'],
                'identity' => $userData['pack']['identity'],
                'IDRep' => $userData['pack']['IDRep'],
                'leave_day' => $userData['pack']['leaveDay'],
                'login_time' => $userData['pack']['loginTime'],
                'login_key' => $userData['key']
            ]
        );
    }

    /**
     * 更新或儲存用戶資料
     *
     * @param array $userData 用戶資料
     * @return void
     */
    protected function updateUserProfiles($userData,$user)
    {
      
        $team='Employee';
        if($userData['IDRep']=='E'){
            $team='Engering';
        }
        $uuid=$this->generateUnique128Char();
        // 嘗試找到對應的用戶
        $user = UserProfile::updateOrCreate(
            [
                'user_id' => $user->id,
                'organization_id'=>$user->organization_id,
                'team'=> $team
            ], // 假設 'user_id' 是唯一識別
            [
                'name' => $userData['username'],
                'email' => $userData['email'],
                'uid' =>$uuid
            ]
        );
    }

    /**
     * 更新或儲存用戶資料
     *
     * @param array $userData 用戶資料
     * @return void
     */
    protected function updateUser($userData)
    {
        // 嘗試找到對應的用戶
        return $user = User::updateOrCreate(
            [
                'email' => $userData['email'], // 假設 'email' 是唯一識別
                'account' => $userData['userAccount'],
            ], 
            [
                'name' => $userData['username'],
                'password' => Crypt::encryptString($userData['email']),
            ]
        );
    }

    private function generateUnique128Char() {
        return  $uuid128 = substr(str_replace('-', '', Str::uuid()->toString().Str::uuid()->toString()), 0, 64);
    }

}