<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

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
    public function user(Request $request)
    {
        $idx=$request->query('i');
        ($idx==null||$idx=='')?0:$idx;
        $profiles=$request->user()->profiles;
        $profile_arr=(count($profiles)>0)?$profiles[0]->toArray():[];
        foreach($profiles as $profile){
            if($profile->organization_id==$idx){
                $profile_arr=$profile->toArray();
            }
        }
        return response()->json([
            'status' => true,
            'message' => 'Query successful!',
            'data' => $profile_arr,
        ], 200);
    }
}

