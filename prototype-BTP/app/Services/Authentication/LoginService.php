<?php

namespace App\Services\Authentication;

use App\Enums\Admin\RoleAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use App\Interfaces\Repositories\Authentication\LoginRepositoryInterface;

class LoginService
{
  protected LoginRepositoryInterface $loginRepository;

  public function __construct(LoginRepositoryInterface $loginRepositoryInterface)
  {
    $this->loginRepository = $loginRepositoryInterface;
  }

  public function authenticate(array $credentials): bool
  {
    return $this->loginRepository->authenticate($credentials);
  }

  public function logout(): void
  {
    $this->loginRepository->logout();
  }

  public function adminOrPetugas()
  {
    $user = Auth::user();
    $allowedRoles = [RoleAdmin::Admin->value, RoleAdmin::Petugas->value];
    if ($user && in_array($user->role, $allowedRoles)) {
      return $user;
    }
    throw new AuthorizationException('Anda tidak memiliki hak akses.');
  }
}