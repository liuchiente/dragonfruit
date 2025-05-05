<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

use Illuminate\Support\Facades\Auth;

use App\Services\UserProfileService;

class AuthController extends Controller
{
    // 用戶註冊
    public function register(Request $request)
    {
        // 驗證輸入
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 創建新用戶
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // 返回新用戶資料
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }

    // 用戶登入
    public function login(Request $request)
    {
        // 驗證輸入
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // 嘗試查找用戶並驗證密碼
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // 用 Passport 生成 token
        $token = $user->createToken('AppName')->accessToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }

    // 取得用戶的資料
    public function user(Request $request){
        
        $user=Auth::user();
        $device=$request->header('Device');
        //想查詢的組織身份
        $organization_id=$request->query('organization_id');
        $userProfileService=new UserProfileService();
        //處理身份資料
        $profile=$userProfileService->getUser($user,$organization_id,$device);
        $profile['auth_token']=$request->bearerToken();
        return response()->json([
            'status' => true,
            'message' => 'Query successful!',
            'data' => $profile,
        ], 200);
    }
}

