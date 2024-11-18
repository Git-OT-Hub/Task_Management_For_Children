<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;

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
    Route::get("/rooms/search/{content}", [RoomController::class, "roomSearch"]);
    Route::get("/rooms/tasks/search/{content}", [RoomController::class, "taskSearch"]);
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
    Route::delete("/profiles/icon", [ProfileController::class, "deleteIcon"])->name("profiles.icon.destroy");
    // notification
    Route::post('/notifications/{notification}/read', [NotificationController::class, "read"])->name('notifications.read');
});

// 管理者　認証
Route::view('/admin/login', 'admin/login');
Route::post('/admin/login', [App\Http\Controllers\Admin\LoginController::class, 'login']);
Route::post('/admin/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout']);
Route::view('/admin/register', 'admin/register');
Route::post('/admin/register', [App\Http\Controllers\Admin\RegisterController::class, 'register']);
Route::group(['middleware' => 'auth:admin'], function() {
    Route::view('/admin/home', 'admin/home');
    // profile
    Route::get("/admin/profiles", [App\Http\Controllers\Admin\ProfileController::class, "index"])->name("admin.profiles.index");
    Route::get("admin/profiles/edit", [App\Http\Controllers\Admin\ProfileController::class, "edit"])->name("admin.profiles.edit");
    Route::patch("admin/profiles/update", [App\Http\Controllers\Admin\ProfileController::class, "update"])->name("admin.profiles.update");
    Route::delete("admin/profiles/icon", [App\Http\Controllers\Admin\ProfileController::class, "deleteIcon"])->name("admin.profiles.icon.destroy");
    // user_management
    Route::get("/admin/users", [App\Http\Controllers\Admin\UserController::class, "index"])->name("admin.users.index");
    Route::get("/admin/users/search/{content}", [App\Http\Controllers\Admin\UserController::class, "userSearch"]);
});
// 管理者　パスワードリセット
Route::view('/admin/password/reset', 'admin/passwords/email');
Route::post('/admin/password/email', [App\Http\Controllers\Admin\ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::get('/admin/password/reset/{token}', [App\Http\Controllers\Admin\ResetPasswordController::class, 'showResetForm']);
Route::post('/admin/password/reset', [App\Http\Controllers\Admin\ResetPasswordController::class, 'reset']);
