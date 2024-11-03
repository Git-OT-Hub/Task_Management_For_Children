<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ParticipantsTableSeeder extends Seeder
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
                "join_flg" => true,
                "master_flg" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 1,
                "user_id" => 2,
                "join_flg" => true,
                "master_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 2,
                "user_id" => 3,
                "join_flg" => true,
                "master_flg" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 2,
                "user_id" => 4,
                "join_flg" => false,
                "master_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 3,
                "user_id" => 5,
                "join_flg" => true,
                "master_flg" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 3,
                "user_id" => 1,
                "join_flg" => false,
                "master_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ];

        foreach ($params as $param) {
            DB::table("participants")->insert($param);
        }
    }
}
