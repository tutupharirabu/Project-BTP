<?php

namespace App\Policies\Admin\Peminjaman\RiwayatPeminjaman;

use App\Models\Users;
use App\Enums\Admin\RoleAdmin;

class AdminRiwayatPeminjamanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function viewAny(Users $user): bool
    {
        return in_array($user->role, [RoleAdmin::Admin->value, RoleAdmin::Petugas->value]);
    }

    public function download(Users $user): bool
    {
        return in_array($user->role, [RoleAdmin::Admin->value, RoleAdmin::Petugas->value]);
    }
}
