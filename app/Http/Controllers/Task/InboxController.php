<?php

namespace App\Http\Controllers\Task;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

use App\Http\Controllers\Controller;
use App\Services\InboxService;
use App\Models\Inbox;
use App\Models\User;

class InboxController extends Controller
{
    // Get user's inbox messages
    public function getUserInbox(Request $request, $userId)
    {
        try {
            $user = Auth::user();

            $inboxService=new InboxService();
            $inbox=$inboxService->getInbox($user);

            return response()->json([
                'status' => true,
                'message' => 'List of messages',
                'data' => $inbox
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
   
            $user = Auth::user();

            $inboxService=new InboxService();
            $inboxComments=$inboxService->getInboxComment($user, $inboxId);

            return response()->json([
                'status' => true,
                'message' => 'List of comments for inbox',
                'data' => $inboxComments
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
            $user = Auth::user();
            $requestData = $request->all();
            $inboxService=new InboxService();
            $inbox = $inboxService->addInbox($requestData,$user);

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
    public function createUserInboxComment(Request $request, $inboxId)
    {
        try {
            $user = Auth::user();
            $requestData = $request->all();
            $inboxService=new InboxService();
            $comment=$inboxService->addInboxComment($requestData,$user,$inboxId);

            return response()->json([
                'status' => true,
                'message' => 'Message created successfully!',
                'data' => $comment
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