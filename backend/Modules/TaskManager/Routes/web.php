<?php

use Illuminate\Support\Facades\Route;
use Modules\TaskManager\Http\Controllers\TaskManagerController;
use Modules\TaskManager\Http\Middleware\ShareDataMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('taskmanager')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    ShareDataMiddleware::class
])
    ->as('taskmanager.')
    ->group(function () {
        Route::get('/', [TaskManagerController::class, 'index']);
        Route::post('store', [TaskManagerController::class, 'store'])->name('store');
        Route::put('completed/{task_id}', [TaskManagerController::class, 'completed'])->name('completed');
        Route::put('chain-end/{task_id}', [TaskManagerController::class, 'chainEnd'])->name('chain-end');
    });
