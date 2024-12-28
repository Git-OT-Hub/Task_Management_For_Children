<?php

namespace App\Interfaces;

use App\Models\User;
use App\Http\Requests\ProfileRequest;

interface ProfileInterface
{
	public function getUser(): User;
	public function updateUser(ProfileRequest $request, User $user);
	public function deleteIcon(User $user);
}
