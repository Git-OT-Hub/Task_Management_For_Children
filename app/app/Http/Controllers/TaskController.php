<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Task;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function create(Room $room)
    {
        return view("rooms.tasks.create")->with(["room" => $room]);
    }

    public function store(Room $room, TaskRequest $request)
    {
        $task = new Task();
        $task->room_id = $room->id;
        foreach ($room->participants as $user) {
            if ($user->id == $room->user_id) {
                $task->task_sender = $user->id;
            } elseif ($user->id !== $room->user_id) {
                $task->task_recipient = $user->id;
            }
        }
        $columns = ["title", "deadline", "point", "body"];
        foreach ($columns as $column) {
            $task->$column = $request->$column;
        }
        $task->complete_flg = false;
        $task->approval_flg = false;
        $task->save();

        return redirect()->route("rooms.tasks.show", ["room" => $room, "task" => $task]);
    }

    public function show(Room $room, Task $task)
    {


        return view("rooms.tasks.show")->with(["room" => $room, "task" => $task]);
    }
}
