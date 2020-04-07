<?php

namespace App\Providers;

use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\ProfileRepository;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
    }
}
