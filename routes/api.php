<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeamController;


Route::group(['middleware' => 'api', 'prefix' => 'v1'], function() {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

    Route::get('team', [TeamController::class, 'index']);
    Route::post('team', [TeamController::class, 'create']);
    Route::get('team/{id}', [TeamController::class, 'show']);
    Route::put('team/{id}', [TeamController::class, 'edit']);
    Route::delete('team/{id}', [TeamController::class, 'delete']);
});
