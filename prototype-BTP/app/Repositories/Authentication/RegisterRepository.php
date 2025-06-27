<?php

namespace App\Repositories\Authentication;

use App\Enums\Admin\RoleAdmin;
use App\Enums\Database\UsersDatabaseColumn;
use App\Models\Users;
use App\Interfaces\Repositories\Authentication\RegisterRepositoryInterface;

class RegisterRepository implements RegisterRepositoryInterface
{
  public function createAdmin(array $data): Users
  {
    return Users::create($data);
  }

  public function checkExistsByField(string $field, string $value): bool
  {
    return Users::where($field, $value)->exists();
  }

  public function findAdminByEmail(string $email): ?Users
  {
    $roles = [RoleAdmin::Admin->value, RoleAdmin::Petugas->value];
    return Users::where(UsersDatabaseColumn::Email->value, $email)
      ->whereIn(UsersDatabaseColumn::Role->value, $roles)
      ->first();
  }
}