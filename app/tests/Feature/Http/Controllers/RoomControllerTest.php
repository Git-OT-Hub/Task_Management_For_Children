<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Room;
use App\Models\User;

class RoomControllerTest extends TestCase
{
    //use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    // ルーム一覧画面が表示できる
    public function test_room_index(): void
    {
        $user = User::factory()->make(['name' => 'test_user1']);

        $response = $this
            ->actingAs($user)
            ->get('rooms');

        $response
            ->assertOk()
            ->assertSee('ルーム一覧');
    }
}
