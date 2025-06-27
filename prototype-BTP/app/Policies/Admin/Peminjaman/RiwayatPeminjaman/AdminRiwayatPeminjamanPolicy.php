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
        $allowedRoles = [RoleAdmin::Admin->value, RoleAdmin::Petugas->value];
        return in_array($user->role, $allowedRoles);
    }

    public function download(Users $user): bool
    {
        $allowedRoles = [RoleAdmin::Admin->value, RoleAdmin::Petugas->value];
        return in_array($user->role, $allowedRoles);
    }
}
