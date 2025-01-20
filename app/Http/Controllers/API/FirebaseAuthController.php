<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Exception;

class FirebaseAuthController extends Controller
{
    // Login and authenticate user with Firebase token
    public function login(Request $request)
    {
        $token = $request->input('token');

        try {
            // Firebase token verification (using Firebase Admin SDK)
            $firebaseUrl = 'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=' . env('FIREBASE_API_KEY');
            $response = Http::post($firebaseUrl, ['idToken' => $token]);

            if ($response->failed()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and SignIn again.'
                ], 401);
            }

            $decodedToken = $response->json()['users'][0];

            if ($decodedToken) {
                // Check if user exists or create a new user
                $user = User::updateOrCreate(
                    ['email' => $decodedToken['email']],
                    [
                        'name' => $decodedToken['displayName'],
                        'picture' => $decodedToken['photoUrl'],
                        'user_id' => $decodedToken['localId'],
                        'auth_token' => $token,
                        'sign_in_provider' => $decodedToken['providerId']
                    ]
                );

                return response()->json([
                    'status' => true,
                    'message' => 'Authentication successful',
                    'data' => $user
                ], 201);
            }

            return response()->json([
                'status' => false,
                'message' => 'Authentication failed.'
            ], 400);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Update user FCM token
    public function updateUserToken(Request $request)
    {
        $fcmToken = $request->input('fcm_token');

        try {
            $user = Auth::user(); // Get the authenticated user

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and SignIn again.'
                ], 401);
            }

            // Update user's FCM token
            $user->update(['fcm_token' => $fcmToken]);

            return response()->json([
                'status' => true,
                'message' => 'User token updated',
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Get user information
    public function getUserInformation()
    {
        try {
            $user = Auth::user(); // Get the authenticated user

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and SignIn again.'
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'User information retrieved successfully',
                'data' => $user,
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Update user information
    public function updateUserInformation(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'picture' => 'nullable|string|max:255',
        ]);

        try {
            $user = Auth::user(); // Get the authenticated user

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token has expired. Logout and SignIn again.'
                ], 401);
            }

            // Update user information
            $user->update([
                'name' => $request->input('name', $user->name),
                'phone_number' => $request->input('phone_number', $user->phone_number),
                'picture' => $request->input('picture', $user->picture),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'User information updated successfully',
                'data' => $user
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}


/**
 * 
 * 
 * {
  "token": "your_firebase_id_token"
}

{
  "fcm_token": "your_fcm_token"
}

{
  "status": true,
  "message": "User information retrieved successfully",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john.doe@example.com",
    "phone_number": "123456789",
    "picture": "https://example.com/profile.jpg",
    "user_id": "firebase_user_id",
    "auth_token": "firebase_auth_token",
    "created_at": "2024-11-12T12:34:56",
    "updated_at": "2024-11-12T12:34:56"
  }
}

{
  "name": "John Doe Updated",
  "phone_number": "987654321",
  "picture": "https://example.com/new-profile.jpg"
}

 */