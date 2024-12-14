<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Room;
use App\Models\Task;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $room = Room::factory()->create();
        return [
            'room_id' => $room,
            'task_sender' => $room->user_id,
            'task_recipient' => User::factory(),
            'title' => fake()->realText(20),
            'deadline' => Carbon::tomorrow(),
            'point' => 100,
            'body' => 'タスク',
        ];
    }
}
