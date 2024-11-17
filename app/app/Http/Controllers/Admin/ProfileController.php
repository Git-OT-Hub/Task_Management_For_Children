<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Http\Requests\Admin\ProfileRequest;

class ProfileController extends Controller
{
    public function index()
    {
        return view("admin.profiles.index");
    }

    public function edit()
    {
        return view("admin.profiles.edit");
    }

    public function update(ProfileRequest $request)
    {
        $user = Admin::find(Auth::user()->id);

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

            $columns = ["name", "email"];
            foreach ($columns as $column) {
                $user->$column = $request->$column;
            }

            $user->save();
        });

        session()->flash("successMessage", "プロフィールを更新しました。");

        return redirect()->route("admin.profiles.index");
    }

    public function deleteIcon()
    {
        $user = Admin::find(Auth::user()->id);

        DB::transaction(function () use($user) {
            if ($currentIcon = $user->icon) {
                Storage::disk("public")->delete($currentIcon);
            }
            $user->icon = null;
            $user->save();
        });

        session()->flash("successMessage", "アイコンを削除しました。");

        return redirect()->route("admin.profiles.index");
    }
}
