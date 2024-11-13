<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Models\EarnedPoint;
use App\Http\Requests\RoomRequest;
use Illuminate\Support\Facades\DB;
use App\Notifications\InformationNotification;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function index()
    {
        // $rooms = Auth::user()->participatedRooms()->latest()->get();
        $rooms = Auth::user()->participatedRooms()->latest()->paginate(4);
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

        return view("rooms.index")->with(["results" => $room_informations, "rooms" => $rooms]);
    }

    public function create()
    {
        return view("rooms.create");
    }

    public function store(RoomRequest $request)
    {
        try {
            DB::transaction(function () use($request) {
                $room = new Room();
                $room->user_id = Auth::user()->id;
                $room->name = $request->room_name;
                $room->save();

                $participant = User::where("name", "=", $request->user_name)->first();
                $room->participants()->attach(Auth::user()->id, ["join_flg" => 1, "master_flg" => 1]);
                $room->participants()->attach($participant->id, ["join_flg" => 0, "master_flg" => 0]);

                $earnedPoint = new EarnedPoint();
                $earnedPoint->room_id = $room->id;
                $earnedPoint->user_id = $participant->id;
                $earnedPoint->save();

                // 通知
                $information = [
                    "sender" => Auth::user()->name,
                    "content" => "『 {$room->name} 』に招待されています。",
                    "url" => route('rooms.index'),
                    "recipient_id" => $participant->id
                ];
                $participant->notify(new InformationNotification((object) $information));
            });

            session()->flash("successMessage", "ルームを作成しました。");

            return redirect()->route("rooms.index");
        } catch (\Throwable $e) {
            Log::error('Room creation error: ' . $e->getMessage());
            session()->flash("failureMessage", "ルームの作成に失敗しました。");

            return redirect()->route("rooms.index");
        }
    }

    public function show(Room $room)
    {
        $this->authorize('view', $room);

        $task_informations = [];
        // $tasks = $room->tasks()->latest()->get();
        $tasks = $room->tasks()->latest()->paginate(4);
        foreach ($tasks as $task) {
            $array = [];
            $sender = User::find($task->task_sender);
            $array["sender_icon"] = $sender->icon;
            $array["sender_name"] = $sender->name;
            $array["task_id"] = $task->id;
            $array["task_title"] = $task->title;
            $array["task_point"] = $task->point;
            $array["task_deadline"] = $task->deadline;
            $array["task_image"] = $task->image;
            $array["task_complete_flg"] = $task->complete_flg;
            $array["task_approval_flg"] = $task->approval_flg;
            $array["task_created_at"] = $task->created_at;
            $task_informations[] = $array;
        }

        $recipient = "";
        $room_member = [];
        foreach ($room->participants as $user) {
            if ($user->id !== $room->user_id) {
                $recipient = $user->name;
                $room_member["participant_icon"] = $user->icon;
                $room_member["participant_name"] = $user->name;
                $room_member["participant_join_flg"] = $user['pivot']['join_flg'];
            } elseif ($user->id == $room->user_id) {
                $room_member["room_master_icon"] = $user->icon;
                $room_member["room_master_name"] = $user->name;
            }
        }

        return view("rooms.show")->with(["room" => $room, "results" => $task_informations, "recipient" => $recipient, "room_member" => $room_member, "tasks" => $tasks]);
    }

    public function join(Room $room)
    {
        $this->authorize('join', $room);

        foreach ($room->participants as $participant) {
            if (Auth::user()->id === $participant->id && $participant->pivot->join_flg == 0) {
                $room->participants()->updateExistingPivot($participant->id, ["join_flg" => 1]);
            } elseif (Auth::user()->id !== $participant->id) {
                // 通知
                $information = [
                    "sender" => Auth::user()->name,
                    "content" => "『 {$room->name} 』に参加しました。",
                    "url" => route('rooms.show', $room),
                    "recipient_id" => $participant->id
                ];
                $participant->notify(new InformationNotification((object) $information));
            }
        }
        session()->flash("successMessage", "ルームに参加しました。");

        return redirect()->route("rooms.show", $room);
    }

    public function update(RoomRequest $request, Room $room)
    {
        $this->authorize('update', $room);

        $room->name = $request->room_name;
        $room->save();

        return response()->json($room);
    }

    public function destroy(Room $room)
    {
        $this->authorize('delete', $room);

        $room->delete();
        session()->flash("successMessage", "ルームを削除しました。");
        
        return redirect()->route("rooms.index");
    }

    public function search(Request $request)
    {
        $room_name = $request->room_name;
        $user_name = $request->user_name;
        $participation_status = $request->participation_status;

        $search = Auth::user()->participatedRooms()->latest();
        if ($room_name) {
            $search->where("name", "like", "%{$room_name}%");
        }
        if ($user_name) {
            $search->whereHas("participants", function ($q) use ($user_name) {
                $q->where("name", "like", "%{$user_name}%");
            });
        }
        if ($participation_status) {
            $search->whereHas("participants", function ($q) use ($participation_status) {
                $q->where("user_id", Auth::user()->id)->where("join_flg", $participation_status);
            });
        }
        $rooms = $search->get();

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
            $array["created_at"] = $room->created_at->format('Y/m/d');
            $room_informations[] = $array;
        }

        return response()->json($room_informations);
    }
}
