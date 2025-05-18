<?php

namespace App\Services\Authentication;

use App\Interfaces\Repositories\Authentication\RegisterRepositoryInterface;

class RegisterService
{
  protected RegisterRepositoryInterface $registerRepository;

  public function __construct(RegisterRepositoryInterface $registerRepositoryInterface)
  {
    $this->registerRepository = $registerRepositoryInterface;
  }

  public function registerAdmin(array $data)
  {
    return $this->registerRepository->createAdmin($data);
  }

  public function checkUnique(string $field, string $value): bool
  {
    return $this->registerRepository->checkExistsByField($field, $value);
  }
}