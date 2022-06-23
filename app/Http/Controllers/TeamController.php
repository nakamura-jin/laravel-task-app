<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskNumber;
use Illuminate\Support\Facades\DB;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('users')->get();
        foreach ($teams as $team) {
            $user = User::where('id', $team->user_id)->get();
            $team->user_name = $user[0]->name;
            $tasks = Task::where('team_id', $team->id)->get();
            $team->tasks = $tasks;
            foreach ($tasks as $task) {
                $task_user = User::where('id', $task->user_id)->first();
                $task->user_name = $task_user->name;
            }
        }

        return response()->json(['teams' => $teams], 200);
    }

    public function create(TeamRequest $request)
    {
        $input = $request->validated();

        $team = Team::create([
            'name' => $input['name'],
            'user_id' => $input['user_id'],
        ]);

        $team_id = Team::find($team->id);
        foreach($input['member'] as $member) {
            $team_id->users()->attach($member);
        }

        if(!$team) {
            return response()->json(['message' => 'error'], 404);
        }

        return response()->json(['team' => $team], 201);
    }

    public function show(Request $request)
    {
        $team = Team::with('users')->find($request->id);
        $tasks = Task::where('team_id', $request->id)->get();
        $team->tasks = $tasks;
        foreach ($tasks as $task) {
            $user = User::find($task->user_id);
            $task->user_name = $user->name;
        }

        $task_count = TaskNumber::where('team_id', $request->id)->orderBy('task_count', 'desc')->get();
        $answer = $task_count == null ? null : $task_count;

        if(isset($answer[0])) {
            $team->task_count = $task_count[0]->task_count;
        }

        if (!$team) {
            return response()->json(['message' => 'Team not found'], 404);
        }

        return response()->json(['team' => $team], 200);



    }

    public function edit(Request $request)
    {
        $data = [
            'name' => $request->name,
            'user_id' => $request->user_id,
        ];

        $team = Team::find($request->team_id);
        $team->users()->sync($request->member);


        $update = Team::where('id', $request->id)->update($data);

        if(!$update) {
            return response()->json(['message' => 'Could not update.'], 404);
        }

        return response()->json(['message' => 'Successfully'], 200);

    }

    public function delete(Request $request)
    {
        $team = Team::where('id', $request->id)->delete();

        if(!$team) {
            return response()->json(['message' => 'Could not delete.'], 404);
        }

        return response()->json(['message' => 'Successfully'], 200);

    }

    public function test(Request $request)
    {
        // for ($i = 0; $i < 30; $i++) {
        //     // タスク作成のチーム取得
        //     $random_id = rand(1, 10);
        //     $team = Team::with('users')->find($random_id);
        //     // チーム内メンバーのid取得（配列）
        //     foreach ($team->users as $user) {
        //         $user_array[] = $user->id;
        //     }
        //     $task_number = TaskNumber::where('team_id', $team->id)->orderBy('task_count', 'desc')->first();

        //     $key = array_rand($user_array);
        //     $user_id = $user_array[$key];

        //     if (!$task_number) {
        //         $task_count = TaskNumber::create([
        //             'team_id' => $team->id,
        //             'task_count' => 1
        //         ]);
        //         Task::create([
        //             'title' => $faker->word(),
        //             'contents' => $faker->realText(),
        //             'user_id' => $user_id,
        //             'team_id' => $task_count->team_id,
        //             'item_id' => $faker->numberBetween(1, 4),
        //             'task_count' => $task_count->task_count
        //         ]);
        //     } else {
        //         $task_count = $task_number->task_count;
        //         $create_task = TaskNumber::create([
        //             'team_id' => $random_id,
        //             'task_count' => $task_count + 1
        //         ]);

        //         Task::create([
        //             'title' => $faker->word(),
        //             'contents' => $faker->realText(),
        //             'user_id' => $user_id,
        //             'team_id' => $create_task->team_id,
        //             'item_id' => $faker->numberBetween(1, 4),
        //             'task_count' => $create_task->task_count
        //         ]);
        //     }
        // }
        $team = Team::with('users')->find(3);
        foreach ($team->users as $user) {
            $user_array[] = $user->id;
        }

        // $result = TaskNumber::where('team_id', $team->id)->orderBy('task_count', 'desc')->first();
        $key = array_rand($user_array);
        $user_id = $user_array[$key];

        return $user_id;
    }
}
