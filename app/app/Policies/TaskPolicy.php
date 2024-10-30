<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Room;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Room $room): bool
    {
        foreach ($room->participants as $participant) {
            if ($user->id === $participant->id && $participant->pivot->join_flg == 1) {
                return true;
            }
        }
        return false;
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
    public function restore(User $user, Task $task): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        //
    }

    public function completion(User $user, Task $task): bool
    {
        $recipient = User::find($task->task_recipient);

        return $user->id === $recipient->id;
    }

    public function redo(User $user, Room $room): bool
    {
        return $user->id === $room->user_id;
    }

    public function approval(User $user, Room $room): bool
    {
        return $user->id === $room->user_id;
    }
}
