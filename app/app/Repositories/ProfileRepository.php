<?php

namespace App\Repositories;

use App\Interfaces\ProfileInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class ProfileRepository implements ProfileInterface
{
    public function getUser(): User
    {
        return User::find(Auth::user()->id);
    }

    public function updateUser(ProfileRequest $request, User $user)
    {
        $columns = ["name", "email", "goal"];
        foreach ($columns as $column) {
            $user->$column = $request->$column;
        }

        $user->save();
    }

    public function deleteIcon(User $user)
    {
        $user->icon = null;

        $user->save();
    }
}
