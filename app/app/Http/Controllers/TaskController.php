<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use App\Http\Requests\TaskImageRequest;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function create(Room $room)
    {
        $this->authorize('create', [Task::class, $room]);

        return view("rooms.tasks.create")->with(["room" => $room]);
    }

    public function store(Room $room, TaskRequest $request)
    {
        $this->authorize('create', [Task::class, $room]);

        $task = new Task();
        $task->room_id = $room->id;
        foreach ($room->participants as $user) {
            if ($user->id == $room->user_id) {
                $task->task_sender = $user->id;
            } elseif ($user->id !== $room->user_id) {
                $task->task_recipient = $user->id;
            }
        }
        $columns = ["title", "deadline", "point", "body"];
        foreach ($columns as $column) {
            $task->$column = $request->$column;
        }
        $task->complete_flg = false;
        $task->approval_flg = false;
        $task->save();
        session()->flash("successMessage", "課題を作成しました。");

        return redirect()->route("rooms.tasks.show", ["room" => $room, "task" => $task]);
    }

    public function generateImage(Room $room, Task $task, TaskImageRequest $request)
    {
        $this->authorize('create', [Task::class, $room]);

        try {
            // 日本語を英語に翻訳
            $sentence = $request->image_description;
            $response = Http::get(
                'https://api-free.deepl.com/v2/translate',
                [
                    'auth_key' => env('DEEPL_KEY'),
                    'target_lang' => 'EN-US',
                    'text' => $sentence,
                ]
            );
            $translated_text = $response->json('translations')[0]['text'];

            // OpenAI で画像生成
            $Image = OpenAI::images()->create([
                "prompt" => $translated_text,
                "n" => 1,
                "size" => "1024x1024",
            ]);

            $url = $Image->data[0]->url;
            $filename = Str::random(10) . ".jpg";
            $path = "public/uploads/{$filename}";

            DB::transaction(function () use($task, $url, $path) {
                if ($currentImage = $task->image) {
                    Storage::delete($currentImage);
                }

                $imageContents = file_get_contents($url);
                Storage::put($path, $imageContents);

                $task->image = $path;
                $task->save();
            });

            session()->flash("successMessage", "画像を生成しました。");

            return redirect()->route("rooms.tasks.show", ["room" => $room, "task" => $task]);

        } catch (\Throwable $e) {
            session()->flash("imageGenerationFailure", "画像生成に失敗しました。時間を置いてから試してください。");

            return redirect()->route("rooms.tasks.show", ["room" => $room, "task" => $task]);
        }
    }

    public function show(Room $room, Task $task)
    {
        $this->authorize('view', [Task::class, $room]);

        return view("rooms.tasks.show")->with(["room" => $room, "task" => $task]);
    }

    public function deleteImage(Room $room, Task $task)
    {
        $this->authorize('delete', [Task::class, $room]);

        DB::transaction(function () use($task) {
            if ($currentImage = $task->image) {
                Storage::delete($currentImage);
            }
            $task->image = null;
            $task->save();
        });
        session()->flash("successMessage", "画像を削除しました。");

        return redirect()->route("rooms.tasks.show", ["room" => $room, "task" => $task]);
    }

    public function edit(Room $room, Task $task)
    {
        $this->authorize('update', [Task::class, $room]);
        
        return view("rooms.tasks.edit")->with(["room" => $room, "task" => $task]);
    }

    public function update(Room $room, Task $task, TaskRequest $request)
    {
        $this->authorize('update', [Task::class, $room]);
        
        $columns = ["title", "deadline", "point", "body"];
        foreach ($columns as $column) {
            $task->$column = $request->$column;
        }
        $task->save();
        session()->flash("successMessage", "課題を編集しました。");

        return redirect()->route("rooms.tasks.show", ["room" => $room, "task" => $task]);
    }

    public function destroy(Room $room, Task $task)
    {
        $this->authorize('delete', [Task::class, $room]);

        $task->delete();
        session()->flash("successMessage", "課題を削除しました。");

        return redirect()->route("rooms.show", $room);
    }

    public function completion(Room $room, Task $task)
    {
        $this->authorize('completion', $task);

        if ($task->complete_flg == 0 && $task->approval_flg == 0) {
            $task->complete_flg = true;
            $result = $task->save();
        }
        session()->flash("successMessage", "完了報告しました。");

        return redirect()->route("rooms.tasks.show", ["room" => $room, "task" => $task]);
    }

    public function redo(Room $room, Task $task)
    {
        $this->authorize('redo', [Task::class, $room]);

        if ($task->approval_flg == 0 && $task->complete_flg == 1) {
            $task->complete_flg = false;
            $result = $task->save();
        }
        session()->flash("successMessage", "やり直しを依頼しました。");

        return redirect()->route("rooms.tasks.show", ["room" => $room, "task" => $task]);
    }

    public function approval(Room $room, Task $task)
    {
        $this->authorize('approval', [Task::class, $room]);

        if ($task->approval_flg == 0 && $task->complete_flg == 1) {
            $task->approval_flg = true;
            $result = $task->save();
        }
        session()->flash("successMessage", "承認しました。");

        return redirect()->route("rooms.tasks.show", ["room" => $room, "task" => $task]);
    }
}
