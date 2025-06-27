<?php

namespace App\Http\Requests\Ruangan;

use App\Enums\Database\GambarDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;

class StoreRuanganRequest extends BaseRuanganRequest
{
    public function rules(): array
    {
        $groupIdRuangan = RuanganDatabaseColumn::GroupIdRuangan->value;
        $namaRuangan = RuanganDatabaseColumn::NamaRuangan->value;
        $urlGambar = GambarDatabaseColumn::UrlGambar->value;

        return array_merge(parent::rules(), [
            $groupIdRuangan => 'nullable|string|uuid',
            $namaRuangan => 'required|string|max:255|unique:ruangan,nama_ruangan',
            $urlGambar => 'required|array',
        ]);
    }
}
