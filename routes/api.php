<?php

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

Route::middleware('todo.auth')->group(function () {
    Route::apiResource('labels', 'LabelController')->only('store','index');
    Route::apiResource('tasks', 'TaskController')->only('store','update','index','show');
});
