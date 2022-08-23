<?php

use App\API\V1\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group( ['prefix' => 'auth'], function () {
        Route::middleware('auth:api')->post('/me', [AuthController::class, 'me']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
    });
});

