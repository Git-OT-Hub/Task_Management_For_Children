<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;

class ProfileControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_saving_icon(): void
    {
        $this->login();
        $user = User::first();

        Storage::fake('public');

        $file = UploadedFile::fake()->image('gaju0.jpg');

        $response = $this->patch(route('profiles.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'icon' => $file,
        ]);

        $response->assertRedirect(route('profiles.index'));

        Storage::disk('public')->assertExists($user->fresh()->icon);

        $this->dumpdb();
    }
}
