<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $params = [
            [
                "name" => "admin-1",
                "email" => "admin1@example.com",
                "password" => bcrypt("password"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "admin-2",
                "email" => "admin2@example.com",
                "password" => bcrypt("password"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
            [
                "name" => "admin-3",
                "email" => "admin3@example.com",
                "password" => bcrypt("password"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ];

        foreach ($params as $param) {
            DB::table("admins")->insert($param);
        }
    }
}
