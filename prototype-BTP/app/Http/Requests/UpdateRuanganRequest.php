<?php

namespace App\Http\Requests;

class UpdateRuanganRequest extends BaseRuanganRequest
{
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'nama_ruangan' => 'required|string',
        ]);
    }
}
