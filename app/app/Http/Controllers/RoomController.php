<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Http\Requests\RoomRequest;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Auth::user()->participatedRooms()->latest()->get();
        $room_informations = [];
        foreach ($rooms as $room) {
            $array = [];
            $array["room_id"] = $room->id;
            $array["room_name"] = $room->name;
            if ($room->pivot->master_flg == 1) {
                $array["room_master"] = Auth::user()->name;
                $array["room_master_icon"] = Auth::user()->icon;
                foreach ($room->participants as $user) {
                    if ($user->id !== Auth::user()->id) {
                        $array["participant"] = $user->name;
                        $array["participant_icon"] = $user->icon;
                    }
                }
            } elseif ($room->pivot->master_flg == 0) {
                $array["participant"] = Auth::user()->name;
                $array["participant_icon"] = Auth::user()->icon;
                foreach ($room->participants as $user) {
                    if ($user->id !== Auth::user()->id) {
                        $array["room_master"] = $user->name;
                        $array["room_master_icon"] = $user->icon;
                    }
                }
            }
            if ($room->pivot->join_flg == 0) {
                $array["join_status"] = 0;
            } elseif ($room->pivot->join_flg == 1) {
                $array["join_status"] = 1;
            }
            $array["created_at"] = $room->created_at;
            $room_informations[] = $array;
        }

        return view("rooms.index")->with(["results" => $room_informations]);
    }

    public function create()
    {
        return view("rooms.create");
    }

    public function store(RoomRequest $request)
    {
        $room = new Room();
        $room->user_id = Auth::user()->id;
        $room->name = $request->room_name;
        $room->save();

        $participant = User::where("name", "=", $request->user_name)->first();
        $room->participants()->attach(Auth::user()->id, ["join_flg" => 1, "master_flg" => 1]);
        $room->participants()->attach($participant->id, ["join_flg" => 0, "master_flg" => 0]);

        return redirect()->route("rooms.index");
    }

    public function show(Room $room)
    {
        $this->authorize('view', $room);

        $task_informations = [];
        $tasks = $room->tasks()->latest()->get();
        foreach ($tasks as $task) {
            $array = [];
            $sender = User::find($task->task_sender);
            $array["sender_icon"] = $sender->icon;
            $array["sender_name"] = $sender->name;
            $array["task_title"] = $task->title;
            $array["task_point"] = $task->point;
            $array["task_deadline"] = $task->deadline;
            $array["task_image"] = $task->image;
            $array["task_complete_flg"] = $task->complete_flg;
            $array["task_approval_flg"] = $task->approval_flg;
            $array["task_created_at"] = $task->created_at;
            $task_informations[] = $array;
        }
        foreach ($room->participants as $user) {
            if ($user->id !== $room->user_id) {
                $recipient = $user->name;
            }
        }

        return view("rooms.show")->with(["room" => $room, "results" => $task_informations, "recipient" => $recipient]);
    }

    public function join(Room $room)
    {
        $this->authorize('join', $room);

        foreach ($room->participants as $participant) {
            if (Auth::user()->id === $participant->id && $participant->pivot->join_flg == 0) {
                $room->participants()->updateExistingPivot($participant->id, ["join_flg" => 1]);
                return redirect()->route("rooms.show", $room);
            }
        }
    }

    public function update(RoomRequest $request, Room $room)
    {
        $room->name = $request->room_name;
        $room->save();

        return response()->json($room);
    }
}
