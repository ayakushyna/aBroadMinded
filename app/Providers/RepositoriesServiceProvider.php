<?php

namespace App\Providers;

use App\Repositories\BookingRepository;
use App\Repositories\CalendarRepository;
use App\Repositories\FeedbackRepository;
use App\Repositories\GeoRepository;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\Interfaces\CalendarRepositoryInterface;
use App\Repositories\Interfaces\FeedbackRepositoryInterface;
use App\Repositories\Interfaces\GeoRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use App\Repositories\Interfaces\PropertyTypeRepositoryInterface;
use App\Repositories\ProfileRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\PropertyTypeRepository;
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
        $this->app->bind(PropertyRepositoryInterface::class, PropertyRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(FeedbackRepositoryInterface::class, FeedbackRepository::class);
        $this->app->bind(GeoRepositoryInterface::class, GeoRepository::class);
        $this->app->bind(CalendarRepositoryInterface::class, CalendarRepository::class);
        $this->app->bind(PropertyTypeRepositoryInterface::class, PropertyTypeRepository::class);
    }
}
