<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TimerController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TimerSoundController;
use App\Http\Controllers\SettingsModalController;
use App\Http\Controllers\TimerIntervalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/me', [ AuthController::class, 'me' ]);

    Route::get('/users/{user}', [ UserController::class, 'show' ]);
    Route::put('/users/{user}', [ UserController::class, 'update' ]);

    Route::get('/timers', [ TimerController::class, 'index']);
    Route::get('/timers/{timer}', [ TimerController::class, 'show']);

    Route::post('/timers', [ TimerController::class, 'store']);
    Route::put('/timers/{timer}', [ TimerController::class, 'update']);
    Route::delete('/timers/{timer}', [ TimerController::class, 'destroy']);

    Route::get('/timer-sounds', [ TimerSoundController::class, 'index']);

    Route::get('/timer-intervals', [ TimerIntervalController::class, 'index']);
    Route::get('/timer-intervals/{timerInterval}', [ TimerIntervalController::class, 'show']);
    Route::post('/timer-intervals', [ TimerIntervalController::class, 'store']);
    Route::put('/timer-intervals/{timerInterval}', [ TimerIntervalController::class, 'update']);
    Route::delete('/timer-intervals/{timerInterval}', [ TimerIntervalController::class, 'destroy']);

    Route::get('/settings', [ SettingsController::class, 'index']);
    Route::get('/settings/{settings:key}', [ SettingsController::class, 'show']);
    Route::patch('/settings', [ SettingsController::class, 'update']);

    Route::patch('/settings-modal', [ SettingsModalController::class,'update']);
});
