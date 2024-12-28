<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProfileInterface;
use App\Repositories\ProfileRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // InterfaceとRepositoryを紐付け
        $this->app->bind(ProfileInterface::class, ProfileRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
