<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('garage-door/{id}', [App\Http\Controllers\GarageDoorController::class, 'show'])->middleware('apiToken');
Route::get('garage-door/trigger/{id}', [App\Http\Controllers\GarageDoorController::class, 'trigger'])->middleware('apiToken');
