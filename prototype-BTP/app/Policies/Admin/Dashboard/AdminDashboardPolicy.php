<?php

namespace App\Policies\Admin\Dashboard;

use App\Models\Users;

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
        return in_array($user->role, ['Admin', 'Petugas']);
    }
}
