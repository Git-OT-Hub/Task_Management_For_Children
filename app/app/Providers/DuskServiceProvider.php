<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Dusk\Browser;

class DuskServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Browser::macro('create_room', function ($participant) {
            $this->visit("/rooms/create")
                 ->assertSee("ルーム作成")
                 ->type('input[name="room_name"]', 'Testルーム')
                 ->type('input[name="user_name"]', $participant->name)
                 ->press('button[type="submit"]');
        
            return $this;
        });
    }
}
