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
            return reponse()->json(['message' => "Can't create user"], 404);
        }

        return response()->json(['user' => $user], 200);
    }
}
