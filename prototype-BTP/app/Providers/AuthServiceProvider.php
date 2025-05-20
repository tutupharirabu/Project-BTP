<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Policies\Admin\Ruangan\AdminRuanganPolicy;
use App\Policies\Admin\Dashboard\AdminDashboardPolicy;
use App\Policies\Admin\Ruangan\Okupansi\AdminOkupansiRuanganPolicy;
use App\Policies\Admin\Peminjaman\StatusPengajuan\AdminStatusPengajuanPolicy;
use App\Policies\Admin\Peminjaman\RiwayatPeminjaman\AdminRiwayatPeminjamanPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('view-admin-dashboard', [AdminDashboardPolicy::class, 'view']);

        Gate::define('view-riwayat-peminjaman', [AdminRiwayatPeminjamanPolicy::class, 'viewAny']);
        Gate::define('download-riwayat-peminjaman', [AdminRiwayatPeminjamanPolicy::class, 'download']);

        Gate::define('access-status-pengajuan', [AdminStatusPengajuanPolicy::class, 'access']);

        Gate::define('access-okupansi', [AdminOkupansiRuanganPolicy::class, 'access']);

        Gate::define('access-ruangan', [AdminRuanganPolicy::class, 'access']);
    }
}
