<?php

namespace App\Http\Controllers\Penyewa\Peminjaman;

use RuntimeException;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Enums\Database\RuanganDatabaseColumn;
use App\Services\Peminjaman\PenyewaPeminjamanService;
use App\Http\Requests\Peminjaman\BasePeminjamanRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PenyewaPeminjamanController extends Controller
{
    protected PenyewaPeminjamanService $penyewaPeminjamanService;

    public function __construct(PenyewaPeminjamanService $penyewaPeminjamanService)
    {
        $this->penyewaPeminjamanService = $penyewaPeminjamanService;
    }

    public function index(?string $id = null)
    {
        $formData = $this->penyewaPeminjamanService->getFormData();
        $origin = $id ? 'detailRuangan' : 'dashboard';
        $ruangan = $id ? $this->penyewaPeminjamanService->getDetailRuanganById($id) : null;

        return view('penyewa.meminjamRuangan', [
            'dataPeminjaman' => $formData['dataPeminjaman'],
            'dataRuangan' => $formData['dataRuangan'],
            'origin' => $origin,
            'ruangan' => $ruangan,
        ]);
    }

    public function store(BasePeminjamanRequest $request)
    {
        try {
            $this->penyewaPeminjamanService->handlePeminjaman($request);
            return redirect('/dashboardPenyewa')->with('success', 'Peminjaman berhasil.');
        } catch (QueryException $e) {
            Log::error('Gagal menyimpan peminjaman dari penyewa.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $message = 'Peminjaman tidak dapat diproses. Mohon coba lagi atau hubungi admin.';

            if (str_contains($e->getMessage(), "Data too long for column 'keterangan'")) {
                $message = 'Deskripsi kegiatan terlalu panjang. Mohon ringkas isi kolom keterangan sebelum mengajukan lagi.';
            }

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        } catch (RuntimeException $e) {
            // Tangkap error dari service (waktu sudah dibooking, seat tidak cukup, dll)
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (Throwable $e) {
            Log::error('Terjadi kesalahan umum saat penyewa melakukan peminjaman.', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Sistem sedang mengalami kendala. Mohon coba beberapa saat lagi atau hubungi admin.',
            ], 500);
        }
    }

    public function getDetailRuangan(Request $request)
    {
        try {
            $ruangan = $this->penyewaPeminjamanService->getDetailRuanganById($request->query('id_ruangan'));
            return response()->json($ruangan);
        } catch (NotFoundHttpException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function getGroupRuanganIds(Request $request)
    {
        $id = $request->input(RuanganDatabaseColumn::IdRuangan->value);
        $ids = $this->penyewaPeminjamanService->getGroupRuanganIds($id); // pakai service kalau ada
        return response()->json($ids);
    }

    public function getUnavailableJam(Request $request)
    {
        $idRuangan = $request->input(RuanganDatabaseColumn::IdRuangan->value);
        $tanggal = $request->input('tanggal');

        // Panggil service
        $unavailableJam = $this->penyewaPeminjamanService->getUnavailableJam($idRuangan, $tanggal);

        return response()->json($unavailableJam);
    }

    public function getUnavailableTanggal(Request $request)
    {
        $idRuangan = $request->input(RuanganDatabaseColumn::IdRuangan->value);
        $unavailableDates = $this->penyewaPeminjamanService->getUnavailableTanggal($idRuangan);
        return response()->json($unavailableDates);
    }

    public function getAvailableJamMulaiHalfday(Request $request)
    {
        $idRuangan = $request->input(RuanganDatabaseColumn::IdRuangan->value);
        $tanggal = $request->input('tanggal');
        $data = $this->penyewaPeminjamanService->getAvailableJamMulaiHalfday($idRuangan, $tanggal);
        return response()->json($data);
    }

    public function getCoworkingBlockedDates(Request $request)
    {
        $idRuangan = $request->input(RuanganDatabaseColumn::IdRuangan->value);
        $dates = $this->penyewaPeminjamanService->getCoworkingFullyBookedDates($idRuangan);
        return response()->json($dates);
    }

    public function getCoworkingBlockedStartDatesForBulan(Request $request)
    {
        $idRuangan = $request->input(RuanganDatabaseColumn::IdRuangan->value);
        $blockedDates = $this->penyewaPeminjamanService->getCoworkingBlockedStartDatesForBulan($idRuangan);
        return response()->json($blockedDates);
    }

    public function getPrivateOfficeBlockedDates(Request $request)
    {
        $blocked = $this->penyewaPeminjamanService->getPrivateOfficeBlockedDates($request->input(RuanganDatabaseColumn::IdRuangan->value));
        return response()->json($blocked);
    }
}
