<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Room;
use App\Models\EarnedPoint;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EarnedPoint>
 */
class EarnedPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_id' => Room::factory(),
            'user_id' => User::factory(),
            'point' => 1000,
        ];
    }
}
