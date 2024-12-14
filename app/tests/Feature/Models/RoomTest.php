<?php

namespace Tests\Feature\App\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class RoomTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_room_participants(): void
    {
        $master = User::factory()->create();
        $participant = User::factory()->create();
        $room = Room::factory()->create(['user_id' => $master->id]);
        $room->participants()->attach($master->id, ["join_flg" => 1, "master_flg" => 1]);
        $room->participants()->attach($participant->id, ["join_flg" => 0, "master_flg" => 0]);

        $this->assertInstanceOf(Collection::class, $room->participants);
        $this->assertInstanceOf(User::class, $room->participants->get(0));

        $this->dumpdb();
    }
}
