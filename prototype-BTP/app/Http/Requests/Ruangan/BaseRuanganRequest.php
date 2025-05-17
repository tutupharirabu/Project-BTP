<?php

namespace App\Http\Requests\Ruangan;

use Illuminate\Foundation\Http\FormRequest;

class BaseRuanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';

        /**
         *  Jika menggunakan Policy
         *  return $this->user()->can('create', Ruangan::class);
         */
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kapasitas_maksimal' => 'required|integer|min:1',
            'kapasitas_minimal' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'satuan' => 'required|string|max:255',
            'harga_ruangan' => 'required|numeric|min:0',
            'url.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
