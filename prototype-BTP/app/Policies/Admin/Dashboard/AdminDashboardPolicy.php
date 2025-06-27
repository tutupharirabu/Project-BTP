<?php

namespace App\Policies\Admin\Dashboard;

use App\Models\Users;
use App\Enums\Admin\RoleAdmin;

class AdminDashboardPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(Users $user): bool
    {
        $allowedRoles = [RoleAdmin::Admin->value, RoleAdmin::Petugas->value];
        return in_array($user->role, $allowedRoles);
    }
}
