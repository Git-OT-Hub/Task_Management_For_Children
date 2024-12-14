<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Room;
use App\Models\User;
use App\Models\Task;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\TestWith;

class TaskControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    private function validData(array $overrides = [])
    {
        return array_merge([
            'title' => 'タイトル 編集',
            'deadline' => new Carbon('+1 weeks'),
            'point' => 200,
            'body' => 'タスク 編集',
        ], $overrides);
    }

    // タスク作成ができる
    public function test_task_create(): void
    {
        $me = $this->login();
        $room = $this->room_create($me);
        $this->get(route('rooms.tasks.create', $room))->assertOk();

        $validData = [
            'title' => 'タスク1',
            'deadline' => Carbon::tomorrow(),
            'point' => 100,
            'body' => 'タスク1を作成',
        ];
        $response = $this->post(route('rooms.tasks.store', $room), $validData);
        $response->assertRedirect(route('rooms.tasks.show', ['room' => $room, 'task' => Task::first()]));
        $this->get(route('rooms.tasks.show', ['room' => $room, 'task' => Task::first()]))
            ->assertOk()
            ->assertSee('課題を作成しました。');

        $participant = null;
        foreach ($room->participants as $user) {
            if ($user->id !== $me->id) {
                $participant = $user;
            }
        }

        $this->assertDatabaseHas('tasks', 
            array_merge($validData, ['room_id' => $room->id, 'task_sender' => $me->id, 'task_recipient' => $participant->id])
        );
    }

    // タスク編集画面にアクセスできる
    public function test_task_edit_form(): void
    {
        $task = Task::factory()->create();
        $room = Room::find($task->room_id);
        $master = User::find($task->task_sender);
        $participant = User::find($task->task_recipient);
        $this->participants_create(room: $room, master: $master, participant: $participant);

        $this->login($master);
        $this->get(route('rooms.tasks.edit', ['room' => $room, 'task' => $task]))
            ->assertOk();
        
        $this->dumpdb();
    }

    // マスター以外はタスク編集画面にアクセスできない
    public function test_prohibited_task_edit_form(): void
    {
        $task = Task::factory()->create();
        $room = Room::find($task->room_id);
        $master = User::find($task->task_sender);
        $participant = User::find($task->task_recipient);
        $this->participants_create(room: $room, master: $master, participant: $participant);

        $this->login($participant);
        $this->get(route('rooms.tasks.edit', ['room' => $room, 'task' => $task]))
            ->assertRedirect('/');
        
        $this->dumpdb();
    }

    // タスクの更新ができる
    public function test_task_update(): void
    {
        $task = Task::factory()->create();
        $room = Room::find($task->room_id);
        $master = User::find($task->task_sender);
        $participant = User::find($task->task_recipient);
        $this->participants_create(room: $room, master: $master, participant: $participant);

        $this->login($master);
        $this->get(route('rooms.tasks.edit', ['room' => $room, 'task' => $task]))
            ->assertOk();

        $validData = $this->validData();

        $this->put(route('rooms.tasks.update', ['room' => $room, 'task' => $task]), $validData)
            ->assertRedirect(route('rooms.tasks.show', ['room' => $room, 'task' => $task]));

        $this->assertDatabaseHas('tasks', $validData);
        $this->assertDatabaseCount('tasks', 1);

        $this->dumpdb();
    }

    // マスター以外はタスクの更新ができない
    public function test_prohibited_task_update(): void
    {
        $task = Task::factory()->create(['title' => '元のタイトル']);
        $room = Room::find($task->room_id);
        $master = User::find($task->task_sender);
        $participant = User::find($task->task_recipient);
        $this->participants_create(room: $room, master: $master, participant: $participant);

        $this->login($participant);
        $this->get(route('rooms.tasks.edit', ['room' => $room, 'task' => $task]))
            ->assertRedirect('/');

        $validData = $validData = $this->validData();

        $this->put(route('rooms.tasks.update', ['room' => $room, 'task' => $task]), $validData)
            ->assertRedirect('/');

        $this->assertSame('元のタイトル', $task->fresh()->title);

        $this->dumpdb();
    }

    // タスクの削除ができる
    public function test_task_delete(): void
    {
        $task = Task::factory()->create();
        $room = Room::find($task->room_id);
        $master = User::find($task->task_sender);
        $participant = User::find($task->task_recipient);
        $this->participants_create(room: $room, master: $master, participant: $participant);

        $this->login($master);

        $this->delete(route('rooms.tasks.destroy', ['room' => $room, 'task' => $task]))
            ->assertRedirect(route('rooms.show', $room));

        $this->assertModelMissing($task);

        $this->dumpdb();
    }

    // マスター以外はタスクの削除ができない
    public function test_prohibited_task_delete(): void
    {
        $task = Task::factory()->create();
        $room = Room::find($task->room_id);
        $master = User::find($task->task_sender);
        $participant = User::find($task->task_recipient);
        $this->participants_create(room: $room, master: $master, participant: $participant);

        $this->login($participant);

        $this->delete(route('rooms.tasks.destroy', ['room' => $room, 'task' => $task]))
            ->assertRedirect('/');

        $this->assertModelExists($task);

        $this->dumpdb();
    }

    // タスクの更新ができる(複数)
    #[TestWith(["タスク1", 100])]
    #[TestWith(["タスク2", 200])]
    public function test_task_update_multiple(string $title, int $point): void
    {
        $task = Task::factory()->create();
        $room = Room::find($task->room_id);
        $master = User::find($task->task_sender);
        $participant = User::find($task->task_recipient);
        $this->participants_create(room: $room, master: $master, participant: $participant);

        $this->login($master);
        $this->get(route('rooms.tasks.edit', ['room' => $room, 'task' => $task]))
            ->assertOk();

        $validData = $this->validData([
            'title' => $title,
            'point' => $point,
        ]);

        $this->put(route('rooms.tasks.update', ['room' => $room, 'task' => $task]), $validData)
            ->assertRedirect(route('rooms.tasks.show', ['room' => $room, 'task' => $task]));

        $this->assertDatabaseHas('tasks', $validData);
        $this->assertDatabaseCount('tasks', 1);

        $this->dumpdb();
    }
}
