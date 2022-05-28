<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Contorllers\AuthController;


Route::group(['middleware' => 'api'], function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
});
