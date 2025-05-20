<?php

namespace App\Policies\Admin\Peminjaman\RiwayatPeminjaman;

use App\Models\Users;

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
        return in_array($user->role, ['Admin', 'Petugas']);
    }

    public function download(Users $user): bool
    {
        return in_array($user->role, ['Admin', 'Petugas']);
    }
}
