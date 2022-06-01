<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Models\User;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::with('users')->get();
        foreach ($teams as $team) {
            $user = User::where('id', $team->user_id)->get();
            $team->user_name = $user[0]->name;
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

        if(!$team) {
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
}
