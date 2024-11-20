<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::paginate(5);

        if ($request->ajax()) {
            //return view("admin.users.users_list", compact("users"))->render();
        }

        return view("admin.tasks.index")->with(["tasks" => $tasks]);
    }
}
