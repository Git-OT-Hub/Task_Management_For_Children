<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Room;

class RewardTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     */
    public function test_login(): void
    {
        $user = User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                    ->type('input[type="email"]', $user->email)
                    ->type('input[type="password"]', 'password')
                    ->press('button[type="submit"]')
                    ->assertPathIs('/rooms');
        });
    }

    public function test_reward_create(): void
    {
        $master = User::factory()->create();
        $participant = User::factory()->create();
        $room = $this->set_room(master: $master, participant: $participant);

        $this->browse(function (Browser $browser) use ($master, $participant, $room) {
            $browser->loginAs($master)
                    ->visit("/rooms/{$room->id}/rewards")
                    ->waitFor('#reward-create-btn')
                    ->assertButtonEnabled('#reward-create-btn')
                    //->assertSee("報酬一覧")
                    ->with('#reward-create-form', function ($form) {
                        $form->type('point', 100)
                             ->type('reward', 'new reward')
                             ->value('input#create-point', 100)
                             ->value('input#create-reward', 'new reward')
                             ->press('button[type="button"]');
                             //->click('#reward-create-btn');
                    })
                    // ->pause(1000) // 一時停止（簡易的な解決策だが推奨されない）
                    // ->assertDatabaseHas('rewards', [
                    //     'point' => 100,
                    //     'reward' => 'new reward',
                    // ]);
                    //->assertDialogOpened('報酬の作成に失敗しました。');
                    ->waitForText('new reward')
                    ->assertSee('new reward');
                    //->waitForTextIn('td.point', '100')
                    //->waitForTextIn('td.reward', 'new reward')
                    //->assertSeeIn('td.point', '100')
                    //->assertSeeIn('td.reward', 'new reward');
        });
    }
}
