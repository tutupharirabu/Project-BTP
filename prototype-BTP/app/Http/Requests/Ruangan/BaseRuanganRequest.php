<?php

namespace App\Http\Requests\Ruangan;

use App\Enums\Admin\RoleAdmin;
use App\Enums\Database\RuanganDatabaseColumn;
use Illuminate\Foundation\Http\FormRequest;

class BaseRuanganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, [RoleAdmin::Admin->value, RoleAdmin::Petugas->value]);

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
            RuanganDatabaseColumn::KapasitasMaksimal->value => 'required|integer|min:1',
            RuanganDatabaseColumn::KapasitasMinimal->value => 'required|integer|min:1',
            RuanganDatabaseColumn::LokasiRuangan->value => 'required|string|max:255',
            RuanganDatabaseColumn::SatuanPenyewaanRuangan->value => 'required|string|max:255',
            RuanganDatabaseColumn::HargaRuangan->value => 'required|numeric|min:0',
            'url.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
