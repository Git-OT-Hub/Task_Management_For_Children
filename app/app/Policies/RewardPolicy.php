<?php

namespace App\Policies;

use App\Models\Reward;
use App\Models\User;
use App\Models\Room;
use Illuminate\Auth\Access\Response;

class RewardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, Room $room): bool
    {
        foreach ($room->participants as $participant) {
            if ($user->id === $participant->id && $participant->pivot->join_flg == 1) {
                return true;
            }
        }
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Reward $reward): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Room $room): bool
    {
        return $user->id === $room->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Room $room): bool
    {
        return $user->id === $room->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Room $room): bool
    {
        return $user->id === $room->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Reward $reward): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Reward $reward): bool
    {
        //
    }

    public function earn(User $user, Room $room, Reward $reward): bool
    {
        $earnedPoint = $room->earnedPoint;
        return $user->id === $earnedPoint->user_id && $earnedPoint->room_id === $reward->room_id;
    }
}
