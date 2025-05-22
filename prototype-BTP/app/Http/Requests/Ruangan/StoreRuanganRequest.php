<?php

namespace App\Http\Requests\Ruangan;

class StoreRuanganRequest extends BaseRuanganRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'group_id_ruangan' => 'nullable|string|uuid',
            'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
            'url' => 'required|array',
        ]);
    }
}
