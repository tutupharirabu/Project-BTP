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
        $namaPenyewa = PeminjamanDatabaseColumn::NamaPenyewa->value;
        $statusPenyewa = PeminjamanDatabaseColumn::StatusPenyewa->value;
        $nomorIndukPenyewa = PeminjamanDatabaseColumn::NomorIndukPenyewa->value;
        $nomorTeleponPenyewa = PeminjamanDatabaseColumn::NomorTeleponPenyewa->value;
        $tanggalMulai = PeminjamanDatabaseColumn::TanggalMulai->value;
        $jamMulai = PeminjamanDatabaseColumn::JamMulai->value;
        $jumlahPeserta = PeminjamanDatabaseColumn::JumlahPeserta->value;
        $totalHarga = PeminjamanDatabaseColumn::TotalHarga->value;
        $idRuangan = RuanganDatabaseColumn::IdRuangan->value;
        $urlKtp = PeminjamanDatabaseColumn::UrlKtp->value;
        $tanggalSelesai = PeminjamanDatabaseColumn::TanggalSelesai->value;
        $jamSelesai = PeminjamanDatabaseColumn::JamSelesai->value;

        $statusMahasiswa = StatusPenyewa::Mahasiswa->value;
        $statusUmum = StatusPenyewa::Umum->value;
        $statusPegawai = StatusPenyewa::Pegawai->value;

        $rules = [
            $namaPenyewa => 'required|string|max:255',
            $statusPenyewa => 'required|in:Mahasiswa,Umum,Pegawai',
            $nomorIndukPenyewa => 'required',
            $nomorTeleponPenyewa => 'required',
            $tanggalMulai => 'required|date',
            $jamMulai => 'required',
            $jumlahPeserta => 'required|integer', // Ini jumlah peserta
            $totalHarga => 'nullable|numeric',
            $idRuangan => 'required'
        ];

        if (in_array($this->input($statusPenyewa), [$statusMahasiswa, $statusUmum])) {
            $rules[$urlKtp] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        if ($this->input($statusPenyewa) === $statusPegawai) {
            $rules[$tanggalSelesai] = 'required|date';
            $rules[$jamSelesai] = 'required';
        }

        return $rules;
    }
}
