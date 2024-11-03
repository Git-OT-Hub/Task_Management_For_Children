<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RewardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                "room_id" => 1,
                "user_id" => 1,
                "point" => 100,
                "reward" => "ドーナツ",
                "acquired_flg" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 1,
                "user_id" => 1,
                "point" => 500,
                "reward" => "カバン",
                "acquired_flg" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 1,
                "user_id" => 1,
                "point" => 1000,
                "reward" => "パンケーキのお店で外食",
                "acquired_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 1,
                "user_id" => 1,
                "point" => 1500,
                "reward" => "洋菓子詰め合わせ",
                "acquired_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 1,
                "user_id" => 1,
                "point" => 2000,
                "reward" => "焼肉食べ放題",
                "acquired_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 1,
                "user_id" => 1,
                "point" => 3000,
                "reward" => "温泉日帰り",
                "acquired_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 1,
                "user_id" => 1,
                "point" => 6000,
                "reward" => "ユニバーサルスタジオジャパン",
                "acquired_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            
        ];

        foreach ($params as $param) {
            DB::table("rewards")->insert($param);
        }
    }
}
