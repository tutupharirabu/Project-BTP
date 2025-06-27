<?php

namespace App\Http\Requests\Ruangan;

use App\Enums\Database\RuanganDatabaseColumn;

class UpdateRuanganRequest extends BaseRuanganRequest
{
    public function rules(): array
    {
        $namaRuangan = RuanganDatabaseColumn::NamaRuangan->value;

        return array_merge(parent::rules(), [
            $namaRuangan => 'required|string',
        ]);
    }
}
