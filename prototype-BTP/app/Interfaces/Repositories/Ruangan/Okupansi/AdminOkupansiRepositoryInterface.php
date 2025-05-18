<?php

namespace App\Interfaces\Repositories\Ruangan\Okupansi;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface AdminOkupansiRepositoryInterface
{
  public function getPeminjamanByMonth(Carbon $start, Carbon $end): Collection;
}