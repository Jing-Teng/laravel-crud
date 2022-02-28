<?php

use Illuminate\Support\Facades\Route;

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

// 1.CRUD a User
// 2.List all users and their respective tasks
// 3.Assign to a user or remove a task from a user
//      by taskId
// 4.Download a list of all users and tasks as a JSON
//      can download by JS or API
Route::get('/', ['App\Http\Controllers\PageController', 'usersView']);

// CRUD a Task
Route::get('/tasks', ['App\Http\Controllers\PageController', 'tasksView']);
