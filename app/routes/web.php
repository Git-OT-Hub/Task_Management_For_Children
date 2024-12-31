<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TopController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\ForgotPasswordController as AdminForgotPasswordController;
use App\Http\Controllers\Admin\ResetPasswordController as AdminResetPasswordController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Admin\RewardController as AdminRewardController;

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

Route::get('/', [TopController::class, "index"]);

Route::group(['middleware' => 'auth'], function() {
    // room
    Route::resource("rooms", RoomController::class);
    Route::prefix('rooms')->name('rooms.')->group(function () {
        Route::post("/{room}/join", [RoomController::class, "join"])->name("join");
        Route::get("/search/{content}", [RoomController::class, "roomSearch"]);
        Route::get("/tasks/search/{content}", [RoomController::class, "taskSearch"]);
    });
    // task
    Route::resource("rooms.tasks", TaskController::class)->only("create", "store", "show", "edit", "update", "destroy");
    Route::prefix('rooms')->name('rooms.tasks.')->group(function () {
        Route::post("/{room}/tasks/{task}/image/ai", [TaskController::class, "generateImage"])->name("image.ai");
        Route::delete("/{room}/tasks/{task}/image", [TaskController::class, "deleteImage"])->name("image.destroy");
        Route::post("/{room}/tasks/{task}/completion", [TaskController::class, "completion"])->name("completion");
        Route::post("/{room}/tasks/{task}/redo", [TaskController::class, "redo"])->name("redo");
        Route::post("/{room}/tasks/{task}/approval", [TaskController::class, "approval"])->name("approval");
    });
    // reward
    Route::resource("rooms.rewards", RewardController::class)->only("index", "store", "update", "destroy");
    Route::prefix('rooms')->name('rooms.rewards.')->group(function () {
        Route::post("/{room}/rewards/{reward}/earn", [RewardController::class, "earn"])->name("earn");
    });
    // profile
    Route::prefix('profiles')->name('profiles.')->group(function () {
        Route::get("/", [ProfileController::class, "index"])->name("index");
        Route::get("/edit", [ProfileController::class, "edit"])->name("edit");
        Route::patch("/update", [ProfileController::class, "update"])->name("update");
        Route::delete("/icon", [ProfileController::class, "deleteIcon"])->name("icon.destroy");
    });
    // notification
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::post('/{notification}/read', [NotificationController::class, "read"])->name('read');
    });
});

// 管理者機能
Route::prefix('admin')->name('admin.')->group(function () {
    // 管理者　認証
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name("login");
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name("logout");
    Route::get('/register', [AdminRegisterController::class, 'showRegistrationForm'])->name("register");
    Route::post('/register', [AdminRegisterController::class, 'register']);
    // 管理者　パスワードリセット
    Route::get('/password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name("password.request");
    Route::post('/password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name("password.email");
    Route::get('/password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name("password.reset");
    Route::post('/password/reset', [AdminResetPasswordController::class, 'reset'])->name("password.update");
});

Route::group(['middleware' => 'auth:admin'], function() {
    Route::get('/admin/home', [AdminHomeController::class, "index"]);
    // profile
    Route::prefix('admin/profiles')->name('admin.profiles.')->group(function () {
        Route::get("/", [AdminProfileController::class, "index"])->name("index");
        Route::get("/edit", [AdminProfileController::class, "edit"])->name("edit");
        Route::patch("/update", [AdminProfileController::class, "update"])->name("update");
        Route::delete("/icon", [AdminProfileController::class, "deleteIcon"])->name("icon.destroy");
    });
    // user_management
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get("/", [AdminUserController::class, "index"])->name("index");
        Route::get("/search/{content}", [AdminUserController::class, "userSearch"]);
        Route::delete("/{user}", [AdminUserController::class, "destroy"])->name("destroy");
    });
    // room_management
    Route::prefix('admin/rooms')->name('admin.rooms.')->group(function () {
        Route::get("/", [AdminRoomController::class, "index"])->name("index");
        Route::get("/search/{content}", [AdminRoomController::class, "roomSearch"]);
        Route::delete("/{room}", [AdminRoomController::class, "destroy"])->name("destroy");
    });
    // task_management
    Route::prefix('admin/tasks')->name('admin.tasks.')->group(function () {
        Route::get("/", [AdminTaskController::class, "index"])->name("index");
        Route::get("/search/{content}", [AdminTaskController::class, "taskSearch"]);
        Route::delete("/{task}", [AdminTaskController::class, "destroy"])->name("destroy");
    });
    // reward_management
    Route::prefix('admin/rewards')->name('admin.rewards.')->group(function () {
        Route::get("/", [AdminRewardController::class, "index"])->name("index");
        Route::get("/search/{content}", [AdminRewardController::class, "rewardSearch"]);
        Route::delete("/{reward}", [AdminRewardController::class, "destroy"])->name("destroy");
    });
});

Route::fallback(function () {
    if (auth('admin')->check()) {

        return redirect('/admin/home');
    } elseif (auth()->check()) {

        return redirect('/');
    }

    return redirect('/');
});
