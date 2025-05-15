<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repositories\AdminRuanganRepositoryInterface;
use App\Repositories\AdminRuanganRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AdminRuanganRepositoryInterface::class,
            AdminRuanganRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        if (config('app.env') !== 'development') {
            URL::forceScheme('https');
        } else {
            URL::forceScheme('http');
        }
    }
}
