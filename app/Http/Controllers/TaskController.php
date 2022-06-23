<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\TaskNumber;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();

        return response()->json(['tasks' => $tasks], 200);
    }

    public function create(TaskRequest $request)
    {
        $input = $request->validated();
        $task_number = TaskNumber::where('team_id', $input['team_id'])->orderBy('task_count', 'desc')->first();

        if(!$task_number) {
            $task_count = TaskNumber::create([
                'team_id' => $input['team_id'],
                'task_count' => 1
            ]);

            $task = Task::create([
                'title' => $input['title'],
                'contents' => $input['contents'],
                'user_id' => $input['user_id'],
                'team_id' => $input['team_id'],
                'item_id' => $input['item_id'],
                'task_count' => $task_count->task_count
            ]);
        } else {
            $task_count = $task_number->task_count;
            $create_task = TaskNumber::create([
                'team_id' => $input['team_id'],
                'task_count' => $task_count + 1
            ]);

            $task = Task::create([
                'title' => $input['title'],
                'contents' => $input['contents'],
                'user_id' => $input['user_id'],
                'team_id' => $input['team_id'],
                'item_id' => $input['item_id'],
                'task_count' => $create_task->task_count
            ]);
        }

        if(!$task) {
            return response()->json(['message' => 'Could not create task'], 404);
        }

        return response()->json(['task' => $task], 201);
    }

    public function show(Request $request)
    {
        $task = Task::find($request->id);

        if(!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        return response()->json(['task' => $task], 200);
    }

    public function edit(Request $request)
    {
        $data = [
            'title' => $request->title,
            'contents' => $request->contents,
            'user_id' => $request->user_id,
            'team_id' => $request->team_id,
            'item_id' => $request->item_id,
            'task_count' => $request->task_count
        ];

        $task = Task::where('id', $request->id)->update($data);

        if(!$task) {
            return response()->json(['task' => 'Could not update'], 404);
        }

        return response()->json(['message' => 'Successfully'], 200);
    }

    public function delete(Request $request)
    {
        $task = Task::where('id', $request->id)->delete();

        if(!$task) {
            return response()->json(['task' => 'Could not delete'], 404);
        }

        return response()->json(['message' => 'Successfully'], 200);
    }
}
