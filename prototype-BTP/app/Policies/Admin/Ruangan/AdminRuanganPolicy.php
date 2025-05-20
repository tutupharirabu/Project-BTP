<?php

namespace App\Policies\Admin\Ruangan;

use App\Models\Users;

class AdminRuanganPolicy
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
