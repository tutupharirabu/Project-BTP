<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Ruangan\BaseRuanganRepository;
use App\Repositories\Authentication\LoginRepository;
use App\Repositories\Ruangan\AdminRuanganRepository;
use App\Repositories\Ruangan\PenyewaRuanganRepository;
use App\Repositories\Authentication\RegisterRepository;
use App\Repositories\Peminjaman\PenyewaPeminjamanRepository;
use App\Repositories\Ruangan\Okupansi\AdminOkupansiRepository;
use App\Interfaces\Repositories\Ruangan\BaseRuanganRepositoryInterface;
use App\Interfaces\Repositories\Authentication\LoginRepositoryInterface;
use App\Interfaces\Repositories\Ruangan\AdminRuanganRepositoryInterface;
use App\Interfaces\Repositories\Ruangan\PenyewaRuanganRepositoryInterface;
use App\Interfaces\Repositories\Authentication\RegisterRepositoryInterface;
use App\Interfaces\Repositories\Peminjaman\BasePeminjamanRepositoryInterface;
use App\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepository;
use App\Repositories\Peminjaman\StatusPengajuan\AdminStatusPengajuanRepository;
use App\Interfaces\Repositories\Peminjaman\PenyewaPeminjamanRepositoryInterface;
use App\Interfaces\Repositories\Ruangan\Okupansi\AdminOkupansiRepositoryInterface;
use App\Repositories\Peminjaman\RiwayatPeminjaman\AdminRiwayatPeminjamanRepository;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\BaseStatusPengajuanRepositoryInterface;
use App\Interfaces\Repositories\Peminjaman\StatusPengajuan\AdminStatusPengajuanRepositoryInterface;

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

        $this->app->bind(
            BaseStatusPengajuanRepositoryInterface::class,
            BaseStatusPengajuanRepository::class
        );

        $this->app->bind(
            AdminStatusPengajuanRepositoryInterface::class,
            AdminStatusPengajuanRepository::class
        );

        $this->app->bind(
            AdminOkupansiRepositoryInterface::class,
            AdminOkupansiRepository::class
        );

        $this->app->bind(
            BaseRuanganRepositoryInterface::class,
            BaseRuanganRepository::class
        );

        $this->app->bind(
            BasePeminjamanRepositoryInterface::class,
            AdminRiwayatPeminjamanRepository::class
        );

        $this->app->bind(
            RegisterRepositoryInterface::class,
            RegisterRepository::class
        );

        $this->app->bind(
            LoginRepositoryInterface::class,
            LoginRepository::class
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
