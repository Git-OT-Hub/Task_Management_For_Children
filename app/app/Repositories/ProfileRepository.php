<?php

namespace App\Repositories;

use App\Interfaces\ProfileInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileRepository implements ProfileInterface
{
    public function getUser()
    {
        return User::find(Auth::user()->id);
    }
}
