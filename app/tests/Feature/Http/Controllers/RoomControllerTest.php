<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Room;
use App\Models\User;

class RoomControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    // 未ログイン時は、ルーム一覧画面にアクセスできない
    public function test_not_be_redirected_to_room_without_login(): void
    {
        $response = $this->get('rooms');

        $response->assertRedirectToRoute('login');
    }
    
    // ログイン時は、自分のルーム一覧画面が表示できる
    public function test_my_room_index_only(): void
    {
        $me = $this->login();

        Room::factory()->create([
            'user_id' => $me->id,
            'name' => '私の部屋'
        ]);
        Room::factory()->create([
            'name' => '他人の部屋'
        ]);

        $response = $this->get('rooms');

        $response
            ->assertOk()
            ->assertSee('ルーム一覧', '私の部屋', $me->name)
            ->assertDontSee('他人の部屋');

        $this->dumpdb();
    }
}
