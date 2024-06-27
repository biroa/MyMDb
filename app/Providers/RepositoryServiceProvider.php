<?php

namespace App\Providers;

use App\Http\Interfaces\MovieRepositoryInterface;
use App\Http\Repositories\MovieRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
