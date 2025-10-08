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
        $urlKtm = PeminjamanDatabaseColumn::UrlKtm->value;
        $urlNpwp = PeminjamanDatabaseColumn::UrlNpwp->value;
        $tanggalSelesai = PeminjamanDatabaseColumn::TanggalSelesai->value;
        $jamSelesai = PeminjamanDatabaseColumn::JamSelesai->value;
        $jumlahSesi = 'jumlah_sesi';
        $jamMulaiSessions = 'jam_mulai_sessions';

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
            $idRuangan => 'required',
            $jumlahSesi => 'nullable|integer|min:1|max:3',
            $urlKtp => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            $urlKtm => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            $urlNpwp => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        $rules[$jamMulaiSessions] = 'sometimes|array';
        $rules[$jamMulaiSessions . '.*'] = 'string';

        if (in_array($this->input($statusPenyewa), [$statusMahasiswa, $statusUmum])) {
            $rules[$urlKtp] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        if ($this->input($statusPenyewa) === $statusMahasiswa) {
            $rules[$urlKtm] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        if ($this->input($statusPenyewa) === $statusUmum) {
            $rules[$urlNpwp] = 'nullable|image|mimes:jpeg,png,jpg|max:2048';
        }

        if ($this->input($statusPenyewa) === $statusPegawai) {
            $rules[$tanggalSelesai] = 'required|date';
            $rules[$jamSelesai] = 'required';
        }

        return $rules;
    }
}
