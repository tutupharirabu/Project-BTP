<?php

namespace App\Http\Requests\Peminjaman;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Enums\Penyewa\StatusPenyewa;
use Illuminate\Foundation\Http\FormRequest;
use Spatie\Health\Enums\Status;

class BasePeminjamanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function baseRules(): array
    {
        $rules = [
            PeminjamanDatabaseColumn::NamaPenyewa->value => 'required|string|max:255',
            PeminjamanDatabaseColumn::StatusPenyewa->value => 'required|in:Mahasiswa,Umum,Pegawai',
            PeminjamanDatabaseColumn::NomorIndukPenyewa->value => 'required',
            PeminjamanDatabaseColumn::NomorTeleponPenyewa->value => 'required',
            PeminjamanDatabaseColumn::TanggalMulai->value => 'required|date',
            PeminjamanDatabaseColumn::JamMulai->value => 'required',
            PeminjamanDatabaseColumn::JumlahPeserta->value => 'required|integer', // Ini jumlah peserta
            PeminjamanDatabaseColumn::TotalHarga->value => 'nullable|numeric',
            RuanganDatabaseColumn::IdRuangan->value => 'required'
        ];

        if (in_array($this->input(PeminjamanDatabaseColumn::StatusPenyewa->value), [StatusPenyewa::Mahasiswa->value, StatusPenyewa::Umum->value])) {
            $rules[PeminjamanDatabaseColumn::UrlKtp->value] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        if ($this->input(PeminjamanDatabaseColumn::StatusPenyewa->value) === StatusPenyewa::Pegawai->value) {
            $rules[PeminjamanDatabaseColumn::TanggalSelesai->value] = 'required|date';
            $rules[PeminjamanDatabaseColumn::JamSelesai->value] = 'required';
        }

        return $rules;
    }
}
