<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\ProfileController;

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
    // room
    Route::resource("rooms", RoomController::class);
    Route::post("/rooms/{room}/join", [RoomController::class, "join"])->name("rooms.join");
    // task
    Route::resource("rooms.tasks", TaskController::class)->only("create", "store", "show", "edit", "update", "destroy");
    Route::post("/rooms/{room}/tasks/{task}/image/ai", [TaskController::class, "generateImage"])->name("rooms.tasks.image.ai");
    Route::delete("/rooms/{room}/tasks/{task}/image", [TaskController::class, "deleteImage"])->name("rooms.tasks.image.destroy");
    Route::post("/rooms/{room}/tasks/{task}/completion", [TaskController::class, "completion"])->name("rooms.tasks.completion");
    Route::post("/rooms/{room}/tasks/{task}/redo", [TaskController::class, "redo"])->name("rooms.tasks.redo");
    Route::post("/rooms/{room}/tasks/{task}/approval", [TaskController::class, "approval"])->name("rooms.tasks.approval");
    // reward
    Route::resource("rooms.rewards", RewardController::class)->only("index", "store", "update", "destroy");
    Route::post("/rooms/{room}/rewards/{reward}/earn", [RewardController::class, "earn"])->name("rooms.rewards.earn");
    // profile
    Route::get("/profiles", [ProfileController::class, "index"])->name("profiles.index");
    Route::get("/profiles/edit", [ProfileController::class, "edit"])->name("profiles.edit");
    Route::patch("/profiles/update", [ProfileController::class, "update"])->name("profiles.update");
});
