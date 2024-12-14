<?php

namespace Tests\Feature\Http\Requests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;

class TaskRequestTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_validation_task_create(): void
    {
        $room = Room::factory()->create();
        $user = User::find($room->user_id);
        $this->login($user);
        $url = route('rooms.tasks.store', $room);
        
        $this->post($url, ['title' => ''])->assertInvalid('title');
        $this->post($url, ['title' => str_repeat('a', 51)])->assertInvalid('title');
        $this->post($url, ['title' => 'タスク', 'deadline' => Carbon::tomorrow(), 'point' => -100])->assertInvalid('point');
    }
}
