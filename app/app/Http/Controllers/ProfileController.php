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
        try {
            $user = User::find(Auth::user()->id);

            DB::transaction(function () use($request, $user) {
                if ($request->hasFile("icon")) {
                    if ($currentIcon = $user->icon) {
                        Storage::disk("public")->delete($currentIcon);
                    }
                    $file = $request->file("icon");
                    $imageFile = Image::read($file);
                    $imageFile->coverDown(200, 200);
                    $filename = 'icons/' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    Storage::disk("public")->put($filename, $imageFile->encode());
                    $user->icon = $filename;
                }

                $columns = ["name", "email", "goal"];
                foreach ($columns as $column) {
                    $user->$column = $request->$column;
                }

                $user->save();
            });

            session()->flash("successMessage", "プロフィールを更新しました。");

            return redirect()->route("profiles.index");
        } catch (\Throwable $e) {
            session()->flash("failureMessage", "プロフィールの更新に失敗しました。");

            return redirect()->route("profiles.index");
        }
    }

    public function deleteIcon()
    {
        try {
            $user = User::find(Auth::user()->id);

            DB::transaction(function () use($user) {
                if ($currentIcon = $user->icon) {
                    Storage::disk("public")->delete($currentIcon);
                }
                $user->icon = null;
                $user->save();
            });

            session()->flash("successMessage", "アイコンを削除しました。");

            return redirect()->route("profiles.index");
        } catch (\Throwable $e) {
            session()->flash("failureMessage", "アイコンの削除に失敗しました。");

            return redirect()->route("profiles.index");
        }
    }
}
