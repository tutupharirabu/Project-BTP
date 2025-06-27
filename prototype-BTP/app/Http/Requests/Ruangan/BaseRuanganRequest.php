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
        $adminRole = RoleAdmin::Admin->value;
        $petugasRole = RoleAdmin::Petugas->value;

        return auth()->check() && in_array(auth()->user()->role, [$adminRole, $petugasRole]);

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
        $kapasitasMaksimal = RuanganDatabaseColumn::KapasitasMaksimal->value;
        $kapasitasMinimal = RuanganDatabaseColumn::KapasitasMinimal->value;
        $lokasiRuangan = RuanganDatabaseColumn::LokasiRuangan->value;
        $satuanPenyewaanRuangan = RuanganDatabaseColumn::SatuanPenyewaanRuangan->value;
        $hargaRuangan = RuanganDatabaseColumn::HargaRuangan->value;

        return [
            $kapasitasMaksimal => 'required|integer|min:1',
            $kapasitasMinimal => 'required|integer|min:1',
            $lokasiRuangan => 'required|string|max:255',
            $satuanPenyewaanRuangan => 'required|string|max:255',
            $hargaRuangan => 'required|numeric|min:0',
            'url.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
