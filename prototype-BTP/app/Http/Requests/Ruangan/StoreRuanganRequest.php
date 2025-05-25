<?php

namespace App\Http\Requests\Ruangan;

use App\Enums\Database\GambarDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;

class StoreRuanganRequest extends BaseRuanganRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            RuanganDatabaseColumn::GroupIdRuangan->value => 'nullable|string|uuid',
            RuanganDatabaseColumn::NamaRuangan->value => 'required|string|max:255|unique:ruangan,nama_ruangan',
            GambarDatabaseColumn::UrlGambar->value => 'required|array',
        ]);
    }
}
