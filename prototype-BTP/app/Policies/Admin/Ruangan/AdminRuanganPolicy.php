<?php

namespace App\Policies\Admin\Ruangan;

use App\Models\Users;
use App\Enums\Admin\RoleAdmin;

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
        $allowedRoles = [RoleAdmin::Admin->value, RoleAdmin::Petugas->value];
        return in_array($user->role, $allowedRoles);
    }
}
