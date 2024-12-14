<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Room;
use App\Models\Reward;

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
                    ->with('#reward-create-form', function ($form) {
                        $form->type('point', 100)
                             ->type('reward', 'new reward')
                             ->press('button[type="button"]');
                    })
                    ->waitForText('100')
                    ->waitForText('new reward')
                    ->assertSee('100')
                    ->assertSee('new reward');
        });
    }

    public function test_reward_update(): void
    {
        $master = User::factory()->create();
        $participant = User::factory()->create();
        $room = $this->set_room(master: $master, participant: $participant);
        $reward = Reward::factory()->create(['room_id' => $room->id, 'user_id' => $master->id]);

        $this->browse(function (Browser $browser) use ($master, $participant, $room, $reward) {
            $browser->loginAs($master)
                    ->visit("/rooms/{$room->id}/rewards")
                    ->assertSee($reward->reward)
                    ->with("#reward-{$reward->id}", function (Browser $item) use($reward) {
                        $item->click('button.dropdown-toggle')
                             ->assertAttribute('#update-reward', 'value', $reward->reward)
                             ->type('point', 250)
                             ->type('reward', 'update reward')
                             ->click('button.reward-update');
                    })
                    ->waitForText('250')
                    ->waitForText('update reward')
                    ->assertSee('250')
                    ->assertSee('update reward');
        });
    }

    public function test_reward_delete(): void
    {
        $master = User::factory()->create();
        $participant = User::factory()->create();
        $room = $this->set_room(master: $master, participant: $participant);
        $reward = Reward::factory()->create(['room_id' => $room->id, 'user_id' => $master->id]);

        $this->browse(function (Browser $browser) use ($master, $participant, $room, $reward) {
            $browser->loginAs($master)
                    ->visit("/rooms/{$room->id}/rewards")
                    ->assertSee($reward->reward)
                    ->with("#reward-{$reward->id}", function (Browser $item) use($reward) {
                        $item->click('button.reward-delete')
                             ->assertDialogOpened("報酬「 {$reward->point} P / {$reward->reward} 」を削除しますか?")
                             ->acceptDialog();
                    })
                    ->waitUntilMissingText($reward->reward)
                    ->assertDontSee($reward->point)
                    ->assertDontSee($reward->reward);
        });
    }
}
