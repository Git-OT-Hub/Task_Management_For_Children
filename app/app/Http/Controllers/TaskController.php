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


        //return redirect()->route("rooms.tasks.show", ["room" => $room]);
    }

    public function show(Room $room, Task $task)
    {


        return view("rooms.tasks.show")->with(["room" => $room, "task" => $task]);
    }
}
