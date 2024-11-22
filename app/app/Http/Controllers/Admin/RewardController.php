<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Reward;
use App\Models\EarnedReward;

class RewardController extends Controller
{
    public function index(Request $request)
    {
        $rewards = Reward::paginate(5);

        if ($request->ajax()) {
            return view("admin.rewards.rewards_list", compact("rewards"))->render();
        }

        return view("admin.rewards.index")->with(["rewards" => $rewards]);
    }

    public function rewardSearch(Request $request)
    {
        $reward = $request->reward;
        $point_from = $request->point_from;
        $point_until = $request->point_until;
        $status = $request->status;
        $room_id = $request->room_id;

        $query = Reward::query();

        if ($reward) {
            $query->where("reward", "like", "%{$reward}%");
        }

        if ($point_from && $point_until) {
            $query->whereBetween("point", [$point_from, $point_until]);
        } elseif ($point_from && !$point_until) {
            $query->where("point", ">=", $point_from);
        } elseif (!$point_from && $point_until) {
            $query->where("point", "<=", $point_until);
        }

        if ($status) {
            if ($status == "unearned") {
                $query->where("acquired_flg", 0);
            } elseif ($status == "earned") {
                $query->where("acquired_flg", 1);
            }
        }

        if ($room_id) {
            $query->where("room_id", $room_id);
        }

        $rewards = $query->paginate(5)->withQueryString();

        return view("admin.rewards.rewards_list", compact("rewards"))->render();
    }

    public function destroy(Reward $reward)
    {
        $reward->delete();

        return response()->json($reward);
    }
}
