<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                "room_id" => 1,
                "task_sender" => 1,
                "task_recipient" => 2,
                "title" => "user-2への課題1",
                "deadline" => Carbon::create(2024, 11, 20, 17, 0, 0),
                "point" => 100,
                "body" => "Hello!",
                "complete_flg" => true,
                "approval_flg" => true,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 1,
                "task_sender" => 1,
                "task_recipient" => 2,
                "title" => "user-2への課題2",
                "deadline" => Carbon::create(2024, 11, 21, 18, 0, 0),
                "point" => 1500,
                "body" => "Yaaa!",
                "complete_flg" => true,
                "approval_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "room_id" => 1,
                "task_sender" => 1,
                "task_recipient" => 2,
                "title" => "user-2への課題3",
                "deadline" => Carbon::create(2024, 11, 22, 19, 0, 0),
                "point" => 5000,
                "body" => "Hello! user-2",
                "complete_flg" => false,
                "approval_flg" => false,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ];

        foreach ($params as $param) {
            DB::table("tasks")->insert($param);
        }
    }
}
