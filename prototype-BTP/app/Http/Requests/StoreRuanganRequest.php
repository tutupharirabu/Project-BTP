<?php

namespace App\Http\Requests;

class StoreRuanganRequest extends BaseRuanganRequest
{
    public function rules(): array
    {
        return array_merge (parent::rules(), [
            'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
            'url' => 'required|array',
        ]);
    }
}
