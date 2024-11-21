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
            return view("admin.tasks.tasks_list", compact("tasks"))->render();
        }

        return view("admin.tasks.index")->with(["tasks" => $tasks]);
    }

    public function taskSearch(Request $request)
    {
        $title = $request->title;
        $point_from = $request->point_from;
        $point_until = $request->point_until;
        $deadline_from = $request->deadline_from;
        $deadline_until = $request->deadline_until;
        $status = $request->status;
        $room_id = $request->room_id;

        $query = Task::query();

        if ($title) {
            $query->where("title", "like", "%{$title}%");
        }

        if ($point_from && $point_until) {
            $query->whereBetween("point", [$point_from, $point_until]);
        } elseif ($point_from && !$point_until) {
            $query->where("point", ">=", $point_from);
        } elseif (!$point_from && $point_until) {
            $query->where("point", "<=", $point_until);
        }

        if ($deadline_from && $deadline_until) {
            $query->whereBetween("deadline", [$deadline_from, $deadline_until]);
        } elseif ($deadline_from && !$deadline_until) {
            $query->where("deadline", ">=", $deadline_from);
        } elseif (!$deadline_from && $deadline_until) {
            $query->where("deadline", "<=", $deadline_until);
        }

        if ($status) {
            if ($status == "none") {
                $query->where("complete_flg", 0)->where("approval_flg", 0);
            } elseif ($status == "reported") {
                $query->where("complete_flg", 1)->where("approval_flg", 0);
            } elseif ($status == "completed") {
                $query->where("complete_flg", 1)->where("approval_flg", 1);
            }
        }

        if ($room_id) {
            $query->where("room_id", $room_id);
        }

        $tasks = $query->paginate(5)->withQueryString();

        return view("admin.tasks.tasks_list", compact("tasks"))->render();
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return response()->json($task);
    }
}
