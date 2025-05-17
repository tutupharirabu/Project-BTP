<?php

namespace App\Http\Requests\Ruangan;

class UpdateRuanganRequest extends BaseRuanganRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'nama_ruangan' => 'required|string',
        ]);
    }
}
