<?

namespace App\Interfaces\Repositories\Authentication;

use App\Models\Users;

interface RegisterRepositoryInterface
{
  public function createAdmin(array $data): Users;
  public function checkExistsByField(string $field, string $value): bool;
  public function findAdminByEmail(string $email): ?Users;
}