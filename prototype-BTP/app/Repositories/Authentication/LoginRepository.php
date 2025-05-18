<?php

namespace App\Repositories\Authentication;

use Illuminate\Support\Facades\Auth;
use App\Interfaces\Repositories\Authentication\LoginRepositoryInterface;

class LoginRepository implements LoginRepositoryInterface
{
  public function authenticate(array $credentials): bool
  {
    return Auth::attempt($credentials);
  }

  public function logout(): void
  {
    Auth::logout();
  }
}