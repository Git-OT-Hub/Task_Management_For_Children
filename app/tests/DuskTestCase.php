<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Support\Collection;
use Laravel\Dusk\TestCase as BaseTestCase;
use PHPUnit\Framework\Attributes\BeforeClass;
use Laravel\Dusk\Browser;
use App\Models\User;
use App\Models\Room;
use App\Models\EarnedPoint;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function baseUrl()
    {
        return 'http://curriculum-nginx';
    }

    /**
     * Prepare for Dusk test execution.
     */
    #[BeforeClass]
    public static function prepare(): void
    {
        if (! static::runningInSail()) {
            static::startChromeDriver(['--port=9515']);
        }
    }

    /**
     * Create the RemoteWebDriver instance.
     */
    protected function driver(): RemoteWebDriver
    {
        $options = (new ChromeOptions)->addArguments(collect([
            $this->shouldStartMaximized() ? '--start-maximized' : '--window-size=1920,1080',
            '--disable-search-engine-choice-screen',
        ])->unless($this->hasHeadlessDisabled(), function (Collection $items) {
            return $items->merge([
                '--disable-gpu',
                '--headless=new',
            ]);
        })->all());

        return RemoteWebDriver::create(
            // $_ENV['DUSK_DRIVER_URL'] ?? env('DUSK_DRIVER_URL') ?? 'http://localhost:9515',
            $_ENV['DUSK_DRIVER_URL'] ?? env('DUSK_DRIVER_URL') ?? 'http://selenium:4444/wd/hub',
            DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    protected function set_room($master, $participant)
    {
        $room = Room::factory()->create(['user_id' => $master->id]);
        $room->participants()->attach($master->id, ["join_flg" => 1, "master_flg" => 1]);
        $room->participants()->attach($participant->id, ["join_flg" => 0, "master_flg" => 0]);

        $earnedPoint = EarnedPoint::factory()->create(['room_id' => $room->id, 'user_id' => $participant->id]);

        return $room;
    }
}
