<?php
namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use App\Models\UserProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Sentry;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // Create new task
    public function createTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => 'required|string',
            'due_date' => 'required|date',
            'is_reminder' => 'required|boolean',
            'assignees' => 'required|array',
            'organizationId' => 'required|integer',
            'created_by' => 'required|integer',
            'team' => 'required|string',
            'priority_level' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        try {


            // 创建任务
            $task = Task::create([
                'description' => $request->description,
                'due_date' => $request->due_date,
                'is_reminder' => $request->is_reminder,
                'assignees' => json_encode($request->assignees),
                'organization_id' => $request->organizationId,
                'created_by' => $request->created_by,
                'team' => $request->team,
                'priority_level' => $request->priority_level,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Task created successfully!',
                'data' => $task,
            ], 201);
        } catch (\Exception $e) {
            Sentry::captureException($e);
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * {
  "description": "Complete Laravel Migration",
  "due_date": "2024-11-30",
  "is_reminder": true,
  "assignees": [1, 2],
  "organizationId": 1,
  "created_by": 1,
  "team": "Development",
  "priority_level": "high"
}


{
  "organizationId": 1
}

 
{
  "status": "in progress",
  "description": "Continue working on migration",
  "due_date": "2024-12-10",
  "is_reminder": false,
  "assignees": [1],
  "team": "Development",
  "priority_level": "medium"
}

{
  "userId": 1
}

     */


    public function getTasks(Request $request, $organizationId)
    {
        try {
           
            // 获取任务
            $tasks = Task::with(['organization', 'creator.profile'])->where('organization_id', $organizationId)->get();

            if ($tasks->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'No task found',
                ], 404);
            }

            $task_o=[];
            // 获取参与者
            foreach ($tasks as &$task) {
                $participants = [];
                foreach ($task->assignees as $assigneeId) {
                    $userprofile = UserProfile::where('user_id',$assigneeId)->where('organization_id',$organizationId)->first();
                    if ($userprofile) {
                        $participants[] = $userprofile;
                    }
                }
                $task->assignees = $participants;
                $user_profile= $task->creator->profile;
                $task_arr=$task->toArray();
                $task_arr['creator'] =  $user_profile;
                $task_o[]= $task_arr;
            }

            return response()->json([
                'status' => true,
                'message' => 'List of tasks for Organization',
                'data' => $task_o,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function updateTask(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'is_reminder' => 'nullable|boolean',
            'assignees' => 'nullable|array',
            'team' => 'nullable|string',
            'priority_level' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors(),
            ], 400);
        }

        try {

            // 查找任务
            $task = Task::find($id);

            if (!$task) {
                return response()->json([
                    'status' => false,
                    'message' => 'No task found',
                ], 404);
            }

            // 更新任务
            $task->update([
                'status' => $request->status ?? $task->status,
                'description' => $request->description ?? $task->description,
                'due_date' => $request->due_date ?? $task->due_date,
                'is_reminder' => $request->is_reminder ?? $task->is_reminder,
                'assignees' => $request->assignees ? json_encode($request->assignees) : $task->assignees,
                'team' => $request->team ?? $task->team,
                'priority_level' => $request->priority_level ?? $task->priority_level,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Task updated!',
                'data' => $task,
            ], 200);
        } catch (\Exception $e) {
            Sentry::captureException($e);
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function getTaskStatusCount(Request $request, $userId)
    {
        try {

            $user = Auth::user();
        
            $todoTask = Task::where('created_by', $userId)->where('status', 'todo')->count();
            $inProgressTask = Task::where('created_by', $userId)->where('status', 'in progress')->count();
            $completedTask = Task::where('created_by', $userId)->where('status', 'completed')->count();

            return response()->json([
                'status' => true,
                'message' => 'Statistic for Tasks',
                'data' => [
                    ['todo' => $todoTask],
                    ['in_progress' => $inProgressTask],
                    ['completed' => $completedTask],
                ],
            ], 200);

        } catch (\Exception $e) {
            
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }



}
