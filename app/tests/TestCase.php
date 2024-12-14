<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Console\CliDumper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Room;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function dumpdb(): void
    {
        if (class_exists(CliDumper::class)) {
            CliDumper::resolveDumpSourceUsing(fn () => null); // ファイル名や行数の出力を消す
        }

        foreach (Schema::getAllTables() as $table) {
            // テーブル情報の形式が異なる場合に備えて、$table->name または $table を配列にキャストして reset で、最初の要素を取得
            if (isset($table->name)) {
                $name = $table->name;
            } else {
                $table = (array) $table;
                $name = reset($table);
            }

            // migrations テーブルは除外 continue で、残りの処理をスキップ
            // in_array 配列に値があるかチェック
            if (in_array($name, ['migrations'], true)) {
                continue;
            }

            // DB::table($name)->get() で指定したテーブルの全データを取得
            // データが空の場合はスキップ
            $collection = DB::table($name)->get();
            if ($collection->isEmpty()) {
                continue;
            }

            // 各レコード（オブジェクト）から created_at と updated_at のフィールドを削除
            // unset 指定した変数や配列の要素などを削除
            // 配列形式に変換して $data に格納
            $data = $collection->map(function ($item) {
                unset($item->created_at, $item->updated_at);
                return $item;
            })->toArray();

            // データをダンプ
            // %s 文字列
            // 第二引数~より指定した数値型の変数が %s の箇所に順番に当てはめられる
            dump(sprintf('■■■■■■■■■■■■■■■■■■■ %s %s件 ■■■■■■■■■■■■■■■■■■■', $name, $collection->count()));
            dump($data);
        }

        // テストが失敗しないように、ダミーのアサーションを追加
        $this->assertTrue(true);
    }

    // テスト中に実行されたSQLクエリをダンプするメソッド
    protected function dumpQuery(): void
    {
        // Laravelのアプリケーションコンテナからdb（データベース接続マネージャ）を取得
        // db はLaravelで用意されているデータベース接続マネージャ（Illuminate\Database\DatabaseManager）
        $db = $this->app->make('db');

        // クエリログを有効化
        $db->enableQueryLog();

        // Laravelアプリケーションが破棄される直前に実行される
        // beforeApplicationDestroyed Illuminate\Foundation\Testing\TestCase クラスで定義されている
        $this->beforeApplicationDestroyed(function () use ($db) {
            // テスト中に実行されたSQLクエリのログを取得し、出力
            dump($db->getQueryLog());
        });
    }

    protected function login($user = null)
    {
        $user = $user ?? User::factory()->create();
        $this->actingAs($user);

        return $user;
    }

    protected function room_create($user = null)
    {
        if ($user == null) {
            $master = $this->login();
        }
        $master = $user;
        $participant = User::factory()->create();

        $room = Room::factory()->create(['user_id' => $master->id]);
        $room->participants()->attach($master->id, ["join_flg" => 1, "master_flg" => 1]);
        $room->participants()->attach($participant->id, ["join_flg" => 0, "master_flg" => 0]);

        return $room;
    }

    protected function participants_create($room, $master, $participant)
    {
        $room->participants()->attach($master->id, ["join_flg" => 1, "master_flg" => 1]);
        $room->participants()->attach($participant->id, ["join_flg" => 0, "master_flg" => 0]);
    }
}
