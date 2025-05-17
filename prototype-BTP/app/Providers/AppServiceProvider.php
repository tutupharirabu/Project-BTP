<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;
use App\Repositories\Ruangan\PenyewaRuanganRepository;
use App\Interfaces\Repositories\Ruangan\AdminRuanganRepositoryInterface;
use App\Repositories\Ruangan\AdminRuanganRepository;
use App\Interfaces\Repositories\Peminjaman\PenyewaPeminjamanRepositoryInterface;
use App\Repositories\Peminjaman\PenyewaPeminjamanRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AdminRuanganRepositoryInterface::class,
            AdminRuanganRepository::class,
        );

        $this->app->bind(
            PenyewaRuanganRepositoryInterface::class,
            PenyewaRuanganRepository::class
        );

        $this->app->bind(
            PenyewaPeminjamanRepositoryInterface::class,
            PenyewaPeminjamanRepository::class
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
