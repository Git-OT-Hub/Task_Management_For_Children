<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Room;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Auth::user()->rooms;
        $room_status = [];
        foreach ($rooms as $room) {
            $array = [];
            $array["room_name"] = $room->name;
            if ($room->pivot->master_flg == 1) {
                $array["room_master"] = Auth::user()->name;
                $array["room_master_icon"] = Auth::user()->icon;
                foreach ($room->users as $user) {
                    if ($user->id !== Auth::user()->id) {
                        $array["participant"] = $user->name;
                        $array["participant_icon"] = $user->icon;
                    }
                }
            } elseif ($room->pivot->master_flg == 0) {
                $array["participant"] = Auth::user()->name;
                $array["participant_icon"] = Auth::user()->icon;
                foreach ($room->users as $user) {
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
            $room_status[] = $array;
        }

        return view("rooms.index")->with(["results" => $room_status]);
    }

    public function create()
    {

    }
}
