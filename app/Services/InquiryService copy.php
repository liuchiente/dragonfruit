<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Laravel\Passport\Passport;
use Exception;

class EmployeeService
{
    /**
     * 向外部 API 發送請求，取得員工資料並處理
     *
     * @param string $userAccount
     * @param string $userPassword
     * @return string|null
     */
    public function fetchEmployeeDataAndLogin(string $userAccount, string $userPassword)
    {
        try {
            // 發送 HTTP 請求
            $response = Http::withHeaders([
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Cookie' => 'PHPSESSID=ckm7conj29e5a10ttom9lhl1a1'
            ])
                ->asForm()
                ->post('https://www.fonlee.com.tw/app/wrapper/transfer_employee.php', [
                    'tDataWrapper[type]' => 'getUserLogin',
                    'tDataWrapper[pack][userAccount]' => $userAccount,
                    'tDataWrapper[pack][userPassword]' => $userPassword,
                    'tDataWrapper[pack][userLoginType]' => 'employee',
                ]);

            // 如果請求成功且返回資料
            if ($response->successful()) {
                $data = $response->json();

                if ($data['code'] == '200') {
                    // 將資料儲存到自定義的 Employee 模型中
                    $employee = Employee::create([
                        'user_id' => $data['pack']['userID'],
                        'user_account' => $data['pack']['userAccount'],
                        'username' => $data['pack']['username'],
                        'login_time' => $data['pack']['loginTime'],
                        'email' => $data['pack']['email'],
                        'identity' => $data['pack']['identity'],
                        'id_rep' => $data['pack']['IDRep'],
                        'leave_day' => $data['pack']['leaveDay'],
                        'key' => $data['key'],
                    ]);

                    // 更新 User 資料
                    $user = User::where('email', $data['pack']['email'])->first();
                    if ($user) {
                        $user->update([
                            'name' => $data['pack']['username'],
                            'email' => $data['pack']['email'],
                            'employee_id' => $data['pack']['userID'],  // 假設需要儲存員工 ID
                        ]);
                    }

                    // 使用 Passport 登入
                    return $this->loginUserWithPassport($user);
                }
            }

            throw new Exception('API returned an error: ' . $data['message']);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * 使用 Passport 登入並生成 OAuth2 Token
     *
     * @param User $user
     * @return string|null
     */
    private function loginUserWithPassport(User $user)
    {
        try {
            // 使用 Passport 創建 Token
            $token = $user->createToken('YourAppName')->accessToken;

            return $token;
        } catch (Exception $e) {
            return null;
        }
    }
}
