<?php

namespace App\Http\Controllers\Penyewa\Ruangan;

use Illuminate\Http\Request;

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
        } catch (\Exception $e) {
            abort(404, $e->getMessage());
        }
    }

    public function getAvailableTimes(Request $request)
    {
        try {
            $slots = $this->penyewaRuanganService->getUsedTimeSlots(
                $request->input('ruangan_id'),
                $request->input('tanggal_mulai'),
                $request->input('tanggal_selesai')
            );
            return response()->json(['usedTimeSlots' => $slots]);
        } catch (\Exception $e) {
            \Log::error("Error: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred'], 500);
        }
    }
}
