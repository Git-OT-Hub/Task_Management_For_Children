<?php

namespace App\Services;

use App\Interfaces\ProfileInterface;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileService
{
    public function __construct(ProfileInterface $profileInterface)
    {
        $this->profileInterface = $profileInterface;
    }

	public function update($request)
    {
        // インターフェースで定義したメソッド呼び出し
        $user = $this->profileInterface->getUser();

        // ストレージへの画像保存とDBへの画像情報登録
        DB::transaction(function () use($request, $user) {

            // 画像が添付されてフォームから送信された場合、ストレージへ添付画像を保存
            if ($request->hasFile("icon")) {
                // 既存の画像があれば削除
                if ($currentIcon = $user->icon) {
                    Storage::disk("public")->delete($currentIcon);
                }

                // 画像のリサイズ処理、ファイル名作成、ストレージへ保存
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
    }

	public function deleteIcon()
    {
        // インターフェースで定義したメソッド呼び出し
        $user = $this->profileInterface->getUser();

        // ストレージの画像削除とDBの画像情報削除
        DB::transaction(function () use($user) {
            if ($currentIcon = $user->icon) {
                Storage::disk("public")->delete($currentIcon);
            }
            $user->icon = null;
            $user->save();
        });
    }
}
