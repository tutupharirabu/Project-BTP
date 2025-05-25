<?php

namespace App\Enums\Database;

enum UsersDatabaseColumn: string
{
  case Users = 'users';
  case IdUsers = 'id_users';
  case Username = 'username';
  case Email = 'email';
  case Role = 'role';
  case NamaLengkap = 'nama_lengkap';
  case Password = 'password';
}