<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Services\EmployeeService;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     *  提供第三方公司使用自己的登入機制來登入會員
     *  呼叫員工資料的 API 並處理回應
     */
    public function transfer(Request $request)
    {
        $userAccount = $request->input('userAccount');
        $userPassword = $request->input('userPassword');
        $organization = $request->header('Organization');

        try {

            if($organization==null||$organization==''){
                return response()->json([
                'status' => false,
                'message' =>'Organization not found',
            ], 400);
            }
            
            $user = $this->employeeService->loginWithEmployee($userAccount, $userPassword, $organization);

            // 用 Passport 生成 token
            $token = $user->createToken('AppName')->accessToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
