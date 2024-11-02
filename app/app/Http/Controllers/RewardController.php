<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Reward;
use App\Http\Requests\RewardRequest;

class RewardController extends Controller
{
    public function index(Room $room)
    {
        $this->authorize('viewAny', [Reward::class, $room]);

        $rewards = $room->rewards()->where("acquired_flg", "=", 0)->orderBy("point", "asc")->get();
        $earnedRewards = $room->rewards()->where("acquired_flg", "=", 1)->orderBy("point", "asc")->get();
        $earnedPoint = $room->earnedPoint;
        $user = User::find($earnedPoint->user_id);
        $receiveRewardsUser = ["user_icon" => $user->icon, "user_name" => $user->name, "earned_point" => $earnedPoint->point];
        
        return view("rooms.rewards.index")->with(["room" => $room, "rewards" => $rewards, "receiveRewardsUser" => $receiveRewardsUser, "earnedRewards" => $earnedRewards]);
    }

    public function store(RewardRequest $request, Room $room)
    {
        $this->authorize('create', [Reward::class, $room]);
        
        $reward = new Reward;
        $reward->room_id = $room->id;
        $reward->user_id = $room->user_id;
        $reward->acquired_flg = false;
        $columns = ["point", "reward"];
        foreach ($columns as $column) {
            $reward->$column = $request->$column;
        }
        $reward->save();
        session()->flash("successMessage", "報酬を作成しました。");

        $rewards = $room->rewards()->where("acquired_flg", "=", 0)->orderBy("point", "asc")->get();

        return response()->json($rewards);
    }
}
