<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Inbox;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class InboxController extends Controller
{
    // Get user's inbox messages
    public function getUserInbox(Request $request, $userId)
    {
        try {
            $user = Auth::user();

            $inboxs = Inbox::where('user_id', $user->id)
                ->with(['comments', 'user.profile']) // Load related comments and user
                ->get();

            if ($inboxs->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No messages found'
                ], 404);
            }

             $inbox_o=[];
            // 获取参与者
            foreach ($inboxs as $inbox) {
                $user_profile= $inbox->user->profile;

                $inbox_arr=$inbox->toArray();
                $inbox_arr['user'] =  $user_profile;
                $inbox_o[]= $inbox_arr;
            }

            return response()->json([
                'status' => true,
                'message' => 'List of messages',
                'data' => $inbox_o
            ], 200);
        } catch (Exception $e) {
           // throw  $e;
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Get comments for a specific inbox message
    public function getUserInboxComment(Request $request, $inboxId)
    {
        try {
   
            $comments = Comment::where('inboxId', $inboxId)
                ->with('user') // Load the user who created the comment
                ->get();

            if ($comments->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No comments found',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'message' => 'List of comments for inbox',
                'data' => $comments
            ], 200);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Create a new inbox message
    public function createInbox(Request $request)
    {
        try {

            $requestData = $request->all();
            $inbox = Inbox::create($requestData);

            return response()->json([
                'status' => true,
                'message' => 'Message created successfully!',
                'data' => $inbox
            ], 201);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    // Create a new inbox message
    public function createUserInboxComment(Request $request)
    {
        try {

            $requestData = $request->all();
            $inbox = Inbox::create($requestData);

            return response()->json([
                'status' => true,
                'message' => 'Message created successfully!',
                'data' => $inbox
            ], 201);

        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

}

/**'
 * {
  "userId": 1,
  "title": "New Inbox Message",
  "body": "This is a test message"
}

{
  "status": true,
  "message": "Message created successfully!",
  "data": {
    "id": 1,
    "userId": 1,
    "title": "New Inbox Message",
    "body": "This is a test message",
    "created_at": "2024-11-12T12:34:56",
    "updated_at": "2024-11-12T12:34:56"
  }
}

GET /api/inbox/1
Authorization: Bearer <valid_token>

{
  "status": true,
  "message": "List of messages",
  "data": [
    {
      "id": 1,
      "userId": 1,
      "title": "New Inbox Message",
      "body": "This is a test message",
      "created_at": "2024-11-12T12:34:56",
      "updated_at": "2024-11-12T12:34:56",
      "comments": [
        {
          "id": 1,
          "userId": 2,
          "comment": "This is a comment",
          "user": {
            "id": 2,
            "name": "John Doe"
          }
        }
      ]
    }
  ]
}



GET /api/inbox/1/comments
Authorization: Bearer <valid_token>


{
  "status": true,
  "message": "List of comments for inbox",
  "data": [
    {
      "id": 1,
      "inboxId": 1,
      "userId": 2,
      "comment": "This is a comment",
      "user": {
        "id": 2,
        "name": "John Doe"
      }
    }
  ]
}

 */