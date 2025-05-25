<?php

namespace App\Policies\Admin\Ruangan\Okupansi;

use App\Models\Users;
use App\Enums\Admin\RoleAdmin;

class AdminOkupansiRuanganPolicy
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
        return in_array($user->role, [RoleAdmin::Admin->value, RoleAdmin::Petugas->value]);
    }
}
