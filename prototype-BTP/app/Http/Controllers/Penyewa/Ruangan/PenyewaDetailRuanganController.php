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
            $slots = $this->penyewaRuanganService->getUsedTimeSlots(
                $request->input('ruangan_id'),
                $request->input(PeminjamanDatabaseColumn::TanggalMulai->value),
                $request->input(PeminjamanDatabaseColumn::TanggalSelesai->value)
            );
            return response()->json(['usedTimeSlots' => $slots]);
        } catch (Exception $e) {
            Log::error("Error: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }

    public function getCoworkingWeeklySeatStatus(Request $request)
    {
        $idRuangan = $request->input(RuanganDatabaseColumn::IdRuangan->value);
        $tanggalMulai = $request->input(PeminjamanDatabaseColumn::TanggalMulai->value);
        $tanggalSelesai = $request->input(PeminjamanDatabaseColumn::TanggalSelesai->value);

        $result = $this->penyewaRuanganService->getCoworkingWeeklySeatStatus(
            $idRuangan,
            $tanggalMulai,
            $tanggalSelesai
        );
        return response()->json($result);
    }
}
