<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                "name" => "user-1",
                "email" => "user1@example.com",
                "password" => bcrypt("password"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "user-2",
                "email" => "user2@example.com",
                "password" => bcrypt("password"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "user-3",
                "email" => "user3@example.com",
                "password" => bcrypt("password"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "user-4",
                "email" => "user4@example.com",
                "password" => bcrypt("password"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "user-5",
                "email" => "user5@example.com",
                "password" => bcrypt("password"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ];

        foreach ($params as $param) {
            DB::table("users")->insert($param);
        }
    }
}
