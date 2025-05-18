<?php

namespace App\Interfaces\Repositories\Authentication;

interface LoginRepositoryInterface
{
  public function authenticate(array $credentials): bool;
  public function logout(): void;
}