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


Route::resource('/tasks', 'App\Http\Controllers\APIs\TaskController');
Route::resource('/users', 'App\Http\Controllers\APIs\UserController');

// create a separate resource that manages the relation between users and tasks
Route::get('/user-task',  ['App\Http\Controllers\APIs\UserTaskController', 'getUsersWithTasks']);
Route::post('/user-task',  ['App\Http\Controllers\APIs\UserTaskController', 'assignTaskToUser']);
Route::delete('/user-task',  ['App\Http\Controllers\APIs\UserTaskController', 'removeTaskFromUser']);
Route::get('/download-user-task',  ['App\Http\Controllers\APIs\UserTaskController', 'downloadUserTaskJSON']);


