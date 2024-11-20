<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;
use App\Models\EarnedPoint;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::with(["participants"])->paginate(5);
        $results = [];
        foreach ($rooms as $room) {
            $array = [];
            $array["room_id"] = $room->id;
            $array["room_name"] = $room->name;
            
            foreach ($room->participants as $user) {
                if ($room->user_id == $user->id) {
                    $array["master"] = $user->name;
                } elseif ($room->user_id !== $user->id) {
                    $array["implementer"] = $user->name;
                }
            }

            $results[] = $array;
        }

        if ($request->ajax()) {
            return view("admin.rooms.rooms_list", compact("rooms", "results"))->render();
        }

        return view("admin.rooms.index")->with(["rooms" => $rooms, "results" => $results]);
    }

    public function roomSearch(Request $request)
    {
        $room_name = $request->room_name;
        $master = $request->master;
        $implementer = $request->implementer;

        $query = Room::query()->with(["participants"]);
        if ($room_name) {
            $query->where("name", "like", "%{$room_name}%");
        }
        if ($master) {
            $query->whereHas("participants", function ($q) use ($master) {
                $q->where("name", "like", "%{$master}%")->where("participants.master_flg", 1);
            });
        }
        if ($implementer) {
            $query->whereHas("participants", function ($q) use ($implementer) {
                $q->where("name", "like", "%{$implementer}%")->where("participants.master_flg", 0);
            });
        }
        $rooms = $query->paginate(5)->withQueryString();

        $results = [];
        foreach ($rooms as $room) {
            $array = [];
            $array["room_id"] = $room->id;
            $array["room_name"] = $room->name;
            
            foreach ($room->participants as $user) {
                if ($room->user_id == $user->id) {
                    $array["master"] = $user->name;
                } elseif ($room->user_id !== $user->id) {
                    $array["implementer"] = $user->name;
                }
            }

            $results[] = $array;
        }

        return view("admin.rooms.rooms_list", compact("rooms", "results"))->render();
    }

    public function destroy(Room $room)
    {
        $room->delete();

        return response()->json($room);
    }
}
