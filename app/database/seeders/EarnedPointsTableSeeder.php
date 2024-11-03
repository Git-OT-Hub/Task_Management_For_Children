<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EarnedPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                "room_id" => 1,
                "user_id" => 2,
                "point" => 5400,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 2,
                "user_id" => 4,
                "point" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 3,
                "user_id" => 1,
                "point" => 0,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ];

        foreach ($params as $param) {
            DB::table("earned_points")->insert($param);
        }
    }
}
