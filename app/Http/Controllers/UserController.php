<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register']]);
    }

    public function index()
    {
        $users = User::all();

        return response()->json(['users' => $users], 200);
    }

    public function register(RegisterRequest $request)
    {
        $input = $request->validated();

        $user = User::create([
            'name' => $input['name'],
            'worker_number' => $input['worker_number'],
            'password' => Hash::make($input['password']),
            'role_id' => $input['role_id']
        ]);

        if(!$user) {
            return response()->json(['message' => "Could not create"], 404);
        }

        return response()->json(['user' => $user], 200);
    }

    public function edit(Request $request)
    {
        $data = [
            'name' => $request->name,
            'worker_number' => $request->worker_number,
            'role_id' => $request->role_id
        ];

        $update = User::where('id', $request->id)->update($data);

        if(!$update) {
            return reponse()->json(['message' => "Could not update"], 404);
        }

        return response()->json(['message' => 'udpate successfully'], 200);
    }

    public function destory(Request $request)
    {
        $user = User::where('id', $request->id)->delete();
        if(!$user) {
            return reponse()->json(['message' => "Could not deleted", 404]);
        }

        return response()->json(['message' => 'Deleted Successfully'], 200);
    }
}
