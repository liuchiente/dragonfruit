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
use App\Models\UserToken;
use App\Models\Inbox;
use App\Models\Comment;


use Illuminate\Support\Facades\Auth;

class InboxService
{

    public function getInbox($user)
    {
  
        $inboxs = Inbox::with('user.profile')->with('users.profile')->orderBy('id', 'desc')->whereHas('users', function ($query) use($user) {
            $query->where('user_id', $user->id);  // 查詢 Inbox 中的 UserId 為 1
        })->orWhere('user_id', $user->id)->orWhere('user_id', 0)->where('created_at', '>=', Carbon::now()->subDays(7))->get();


        if ($inboxs->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No messages found'
            ], 404);
        }

        $inboxes=$inboxs->map(function ($inbox) {
            $box=$inbox->only([
                'id',
                'title',
                'message',
                'user_id',
                'due_date',
                'send_at',
                'queue_at',
                'status',
                'team',
                'like',
                'type',
                'action',
                'created_at',
                'updated_at',
                ]);

            $owner=[];
            //if($inbox->user!=null){
                $owner['organization']=$inbox->user?->profile->organization->only(['id','name','code']);
                $owner['id']=$inbox->user?->profile->id??'';
                $owner['name']=$inbox->user?->profile->name;
                $owner['picture']=$inbox->user?->profile->picture??'';
                //$owner['userId']=$inbox->user?->id;
                //$owner['email']=$inbox->user?->profile->email??'';
                $owner['team']=$inbox->user?->profile->team??'';
                $owner['phone_number']=$inbox->user?->profile->phone_number??'';
          //  }
            
            $box['owner']=$owner;
           
            /*$box['participant']=$inbox->users?->map(function ($part) {
                $partner=[];
                $partner['organization']=$part?->organization;
                $partner['id']=$part?->profile->id??'';
                $partner['name']=$part?->profile->name;
                $partner['picture']=$part?->profile->picture??'';
                $partner['userId']=$part?->id;
                $partner['email']=$part?->profile->email??'';
                $partner['team']=$part?->profile->team??'';
                $partner['phone_number']=$part?->profile->phone_number??'';
                return $partner;
           });*/
            $box['comments']=$inbox->comments->map(function ($comment) {
                $comment_data=[];
                $comment_data['id']=$comment?->id;
                $comment_data['message']=$comment?->message;
                $comment_data['attaches']=$comment?->attaches;
                $comment_data['created_at']=$comment?->created_at;
                $comment_data['updated_at']=$comment?->updated_at;
                $comment_data['user']=[];
                $comment_data['user']['id']=$comment->user?->id??'';
                $comment_data['user']['name']=$comment->user?->name??'';
                return $comment_data;
           });
           return $box;
        });

        return $inboxes;
    }

    public function getInboxComment($user,$indox_id)
    {
  
        $comments = Comment::where('inbox_id', $indox_id)
                ->with('user') // Load the user who created the comment
                ->get();

            if ($comments->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No comments found',
                ], 404);
            }

        $inboxComments=$comments->map(function ($comment) {
            $data=$comment->only(['id','message','like','type','action','created_at','updated_at','attaches']);
            $data['user']=$comment->user->only(['id','name']);
            return $data;
        });

        return $inboxComments;
    }


    public function addInboxComment($comment,$user,$inbox_id)
    {
        
        $data['message']=$comment['comment'];
        $data['user_id']=$user->id;
        $data['type']='report';
        $data['action']='view';
        $data['inbox_id']=$inbox_id;

        if (!empty($comment['attaches']) && is_array($comment['attaches'])) {
            $data['attaches']=$comment['attaches'];
          
        }

        $result =  Comment::create($data);
        return $result;
    }

    public function addInbox($inbox,$user)
    {
        $data=$inbox;
        $data['user_id']=$user->id;
         $data['type']='report';
          $data['action']='view';
          $data['status']='start';

        $result =  Inbox::create($data);
        return $result;
    }

  

}