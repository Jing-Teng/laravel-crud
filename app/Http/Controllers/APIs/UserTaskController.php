<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Task;

class userTaskController extends Controller
{
    public function getUsersWithTasks() {
        $users = User::select('id', 'name','role')
            ->orderBy('updated_at', 'desc')
            ->with(['tasks' => function ($query) {
                    $query->select('id', 'name', 'due_date');
                }]
            )->get();

        $userList= [];
        foreach ($users as $user) {
            $tasks = $user->tasks;
            array_push($userList, $user->toArray());
        }

        return $userList;
    }

    public function assignTaskToUser(Request $request)
    {
        $user = User::findOrFail($request->userId);

        Task::findOrFail($request->taskId);
        $taskId = $request->taskId;
        if( $user->tasks->contains('id', $taskId) ) {
            abort(400, "This task was already assigned to this user.");
        }

        // append taskId into pivot table
        $user->tasks()->syncWithoutDetaching([$taskId]);

        return \Response::json(['message'=>'Task was assigned successfully']);
    }

    public function removeTaskFromUser(Request $request)
    {
        $user = User::findOrFail($request->userId);
        Task::findOrFail($request->taskId);
        $taskId = $request->taskId;

        if( !$user->tasks->contains('id', $taskId) ) {
            abort(400, "This task doesn't belong to this user.");
        }

        $user->tasks()->detach([$taskId]);
        return \Response::json(['message'=>'Task was removed successfully']);
    }

    public function downloadUserTaskJSON()
    {
        $data = $this->getUsersWithTasks();
        $json = json_encode($data);
        Storage::disk('public')->put('json/user-list.json', $json);

        $file = Storage::disk('public')->get('json/user-list.json');
        return response($file, 200)->header('Content-Type', 'text/csv');
    }
}
