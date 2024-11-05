<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view("profiles.index");
    }

    public function edit()
    {
        return view("profiles.edit");
    }

    public function update(ProfileRequest $request)
    {
        $user = User::find(Auth::user()->id);

        if ($request->hasFile("icon")) {
            $file = $request->file("icon");
            $filename = Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = Storage::disk("public")->putFileAs("icons", $file, $filename);
            $user->icon = $path;
        }

        $columns = ["name", "email", "goal"];
        foreach ($columns as $column) {
            $user->$column = $request->$column;
        }

        $user->save();

        return redirect()->route("profiles.index");
    }
}
