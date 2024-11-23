<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Models\Reward;
use App\Models\EarnedReward;
use App\Http\Requests\RewardRequest;
use Illuminate\Support\Facades\DB;

class RewardController extends Controller
{
    public function index(Room $room)
    {
        $this->authorize('viewAny', [Reward::class, $room]);

        $rewards = $room->rewards()->where("acquired_flg", "=", 0)->orderBy("point", "asc")->get();
        $earnedRewards = $room->rewards()->where("acquired_flg", "=", 1)->orderBy("point", "asc")->get();
        $earnedPoint = $room->earnedPoint;
        $recipientUser = User::find($earnedPoint->user_id);
        $receiveRewardsUser = ["user_icon" => $recipientUser->icon, "user_name" => $recipientUser->name, "earned_point" => $earnedPoint->point];
        
        return view("rooms.rewards.index")->with(["room" => $room, "rewards" => $rewards, "receiveRewardsUser" => $receiveRewardsUser, "earnedRewards" => $earnedRewards, "recipientUser" => $recipientUser]);
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

        $earnedPoint = $room->earnedPoint;
        $recipientUser = User::find($earnedPoint->user_id);

        return view("rooms.rewards.reward", compact("reward", "room", "recipientUser"))->render();
    }

    public function update(RewardRequest $request, Room $room, Reward $reward)
    {
        $this->authorize('update', [Reward::class, $room]);

        if ($reward->acquired_flg == 1) {
            $message = ["message" => "報酬「 {$reward->point} P / {$reward->reward} 」は他のユーザーによって獲得されたため、更新できませんでした。"];

            return response()->json($message, 400);
        }
        $columns = ["point", "reward"];
        foreach ($columns as $column) {
            $reward->$column = $request->$column;
        }
        $reward->save();

        return response()->json($reward);
    }

    public function destroy(Room $room, Reward $reward)
    {
        $this->authorize('delete', [Reward::class, $room]);

        if ($reward->acquired_flg == 1) {
            $message = ["message" => "報酬「 {$reward->point} P / {$reward->reward} 」は他のユーザーによって獲得されたため、削除できませんでした。"];

            return response()->json($message, 400);
        }
        $reward->delete();

        return response()->json($reward);
    }

    public function earn(RewardRequest $request, Room $room, Reward $reward)
    {
        $this->authorize('earn', [Reward::class, $room, $reward]);

        if ($request->point != $reward->point || $request->reward != $reward->reward) {
            $message = ["message" => "報酬「 {$request->point} P / {$request->reward} 」はルームマスターによって編集されたため、獲得できませんでした。\n画面を更新して、最新の報酬情報を確認してください。"];

            return response()->json($message, 400);
        }

        $earnedPoint = $room->earnedPoint;
        if ($earnedPoint->point < $reward->point) {
            $message = ["message" => "保有ポイントが不足しているため、報酬「 {$reward->point} P / {$reward->reward} 」は獲得できません。"];

            return response()->json($message, 400);
        }

        DB::transaction(function () use($reward, $room) {
            $reward->acquired_flg = true;
            $reward->save();
            
            $earnedPoint = $room->earnedPoint;
            $earnedPoint->point = $earnedPoint->point - $reward->point;
            $earnedPoint->save();

            $earnedReward = new EarnedReward;
            $earnedReward->reward_id = $reward->id;
            $earnedReward->user_id = $earnedPoint->user_id;
            $earnedReward->save();
        });

        return response()->json(["reward" => $reward, "earnedPoint" => $earnedPoint]);
    }
}
