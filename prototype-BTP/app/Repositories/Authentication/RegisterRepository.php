<?php

namespace App\Repositories\Authentication;

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
    return Users::where('email', $email)
      ->whereIn('role', ['Admin', 'Petugas'])
      ->first();
  }
}