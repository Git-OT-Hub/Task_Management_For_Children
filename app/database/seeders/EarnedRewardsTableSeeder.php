<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EarnedRewardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                "reward_id" => 1,
                "user_id" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "reward_id" => 2,
                "user_id" => 2,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ];

        foreach ($params as $param) {
            DB::table("earned_rewards")->insert($param);
        }
    }
}
