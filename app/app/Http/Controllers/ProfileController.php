<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

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
            // サービスで定義したメソッド呼び出し
            $this->profileService->update($request);

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
            // サービスで定義したメソッド呼び出し
            $this->profileService->deleteIcon();

            session()->flash("successMessage", "アイコンを削除しました。");

            return redirect()->route("profiles.index");
        } catch (\Throwable $e) {
            session()->flash("failureMessage", "アイコンの削除に失敗しました。");

            return redirect()->route("profiles.index");
        }
    }
}
