<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TaskController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::get('/', function () {
    return view('top');
});

Route::group(['middleware' => 'auth'], function() {
    Route::resource("rooms", RoomController::class);
    Route::post("/rooms/{room}/join", [RoomController::class, "join"])->name("rooms.join");
    Route::resource("rooms.tasks", TaskController::class)->only("create", "store", "show", "edit", "update", "destroy");
    Route::post("/rooms/{room}/tasks/{task}/image/ai", [TaskController::class, "generateImage"])->name("rooms.tasks.image.ai");
    Route::delete("/rooms/{room}/tasks/{task}/image", [TaskController::class, "deleteImage"])->name("rooms.tasks.image.destroy");
    Route::post("/rooms/{room}/tasks/{task}/completion", [TaskController::class, "completion"])->name("rooms.tasks.completion");
});
