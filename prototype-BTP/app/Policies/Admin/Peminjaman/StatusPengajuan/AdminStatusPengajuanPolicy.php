<?php

namespace App\Policies\Admin\Peminjaman\StatusPengajuan;

use App\Models\Users;

class AdminStatusPengajuanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function access(Users $user): bool
    {
        return in_array($user->role, ['Admin', 'Petugas']);
    }
}
