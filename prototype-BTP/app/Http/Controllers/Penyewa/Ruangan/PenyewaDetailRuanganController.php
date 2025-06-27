<?php

namespace App\Http\Controllers\Penyewa\Ruangan;

use App\Enums\Database\PeminjamanDatabaseColumn;
use App\Enums\Database\RuanganDatabaseColumn;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PenyewaDetailRuanganController extends PenyewaRuanganController
{
    public function show($id)
    {
        try {
            $result = $this->penyewaRuanganService->getRuanganDetailWithEvents($id);

            return view('penyewa.detailRuanganPenyewa', [
                'ruangan' => $result['ruangan'],
                'dataRuangan' => $result['dataRuangan'],
                'events' => $result['events'],
            ]);
        } catch (Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function getAvailableTimes(Request $request)
    {
        try {
            $tanggalMulaiKey = PeminjamanDatabaseColumn::TanggalMulai->value;
            $tanggalSelesaiKey = PeminjamanDatabaseColumn::TanggalSelesai->value;

            $slots = $this->penyewaRuanganService->getUsedTimeSlots(
                $request->input('ruangan_id'),
                $request->input($tanggalMulaiKey),
                $request->input($tanggalSelesaiKey)
            );
            return response()->json(['usedTimeSlots' => $slots]);
        } catch (Exception $e) {
            Log::error("Error: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function getCoworkingWeeklySeatStatus(Request $request)
    {
        $idRuanganKey = RuanganDatabaseColumn::IdRuangan->value;
        $tanggalMulaiKey = PeminjamanDatabaseColumn::TanggalMulai->value;
        $tanggalSelesaiKey = PeminjamanDatabaseColumn::TanggalSelesai->value;

        $idRuangan = $request->input($idRuanganKey);
        $tanggalMulai = $request->input($tanggalMulaiKey);
        $tanggalSelesai = $request->input($tanggalSelesaiKey);

        $result = $this->penyewaRuanganService->getCoworkingWeeklySeatStatus(
            $idRuangan,
            $tanggalMulai,
            $tanggalSelesai
        );
        return response()->json($result);
    }
}
