<?php

namespace App\Http\Requests\Peminjaman;

use Illuminate\Foundation\Http\FormRequest;

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
            'nama_peminjam' => 'required|string|max:255',
            'role' => 'required|in:Mahasiswa,Umum,Pegawai',
            'nomor_induk' => 'required',
            'nomor_telepon' => 'required',
            'tanggal_mulai' => 'required|date',
            'jam_mulai' => 'required',
            'jumlah' => 'required|integer', // Ini jumlah peserta
            'total_harga' => 'nullable|numeric',
            'id_ruangan' => 'required'
        ];

        if (in_array($this->input('role'), ['Mahasiswa', 'Umum'])) {
            $rules['ktp_url'] = 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        if ($this->input('role') === 'Pegawai') {
            $rules['tanggal_selesai'] = 'required|date';
            $rules['jam_selesai'] = 'required';
        }

        return $rules;
    }
}
