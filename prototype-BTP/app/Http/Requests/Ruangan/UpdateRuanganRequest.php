<?php

namespace App\Http\Requests\Ruangan;

use App\Enums\Database\RuanganDatabaseColumn;

class UpdateRuanganRequest extends BaseRuanganRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            RuanganDatabaseColumn::NamaRuangan->value => 'required|string',
        ]);
    }
}
