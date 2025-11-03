<?php

namespace App\Http\Controllers\Admin\Peminjaman\StatusPengajuan;

use InvalidArgumentException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Client\RequestException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Peminjaman\StatusPengajuan\AdminStatusPengajuanService;

class AdminStatusPengajuanController extends Controller
{
    protected AdminStatusPengajuanService $adminStatusPengajuanService;

    public function __construct(AdminStatusPengajuanService $adminStatusPengajuanService)
    {
        $this->adminStatusPengajuanService = $adminStatusPengajuanService;
        $this->middleware(function ($request, $next) {
            $this->authorize('access-status-pengajuan');
            return $next($request);
        });
    }

    public function index()
    {
        $dataPeminjaman = $this->adminStatusPengajuanService->getAllPeminjaman();
        return view('admin.statusPengajuanAdmin', compact('dataPeminjaman'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $this->adminStatusPengajuanService->updateStatus(
                $id,
                $request->input('pilihan'),
                Auth::id()
            );

            return redirect('/statusPengajuanAdmin')->with('message', 'Status peminjaman berhasil diperbarui!');
        } catch (ModelNotFoundException $e) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Peminjaman tidak ditemukan!');
        } catch (InvalidArgumentException $e) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Pilihan status tidak valid!');
        }
    }

    public function finish(string $id)
    {
        try {
            $this->adminStatusPengajuanService->finishPeminjaman($id, Auth::id());

            return redirect('/statusPengajuanAdmin')->with('message', 'Peminjaman berhasil diselesaikan!');
        } catch (ModelNotFoundException $e) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Peminjaman tidak ditemukan!');
        }
    }

    public function destroy(string $id)
    {
        try {
            $this->adminStatusPengajuanService->deletePeminjaman($id);

            return redirect('/statusPengajuanAdmin')->with('message', 'Peminjaman berhasil dihapus!');
        } catch (ModelNotFoundException $e) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Peminjaman tidak ditemukan!');
        } catch (\Throwable $e) {
            Log::error('Gagal menghapus peminjaman', [
                'peminjaman_id' => $id,
                'message' => $e->getMessage(),
            ]);

            return redirect('/statusPengajuanAdmin')->with('error', 'Terjadi kesalahan saat menghapus peminjaman.');
        }
    }

    public function downloadDocument(string $id, string $document)
    {
        $allowedDocuments = ['ktp', 'ktm', 'npwp'];

        if (!in_array($document, $allowedDocuments, true)) {
            abort(404);
        }

        try {
            $peminjaman = $this->adminStatusPengajuanService->getPeminjamanById($id);
        } catch (ModelNotFoundException $e) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Peminjaman tidak ditemukan!');
        }

        $signedUrl = match ($document) {
            'ktp' => $peminjaman->ktp_signed_url ?? null,
            'ktm' => $peminjaman->ktm_signed_url ?? null,
            'npwp' => $peminjaman->npwp_signed_url ?? null,
        };

        if (!$signedUrl) {
            return redirect('/statusPengajuanAdmin')->with('error', 'Dokumen tidak tersedia.');
        }

        try {
            $response = Http::withOptions(['stream' => true])->get($signedUrl);

            if ($response->failed()) {
                throw new RequestException($response);
            }

            $psrStream = $response->toPsrResponse()->getBody();
            $fileExtension = pathinfo(parse_url($signedUrl, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION) ?: 'jpg';
            $filename = sprintf(
                '%s-%s.%s',
                strtoupper($document),
                Str::slug($peminjaman->nama_peminjam ?? 'dokumen'),
                $fileExtension
            );

            return response()->streamDownload(function () use ($psrStream) {
                while (!$psrStream->eof()) {
                    echo $psrStream->read(1024);
                }
            }, $filename);
        } catch (RequestException $e) {
            Log::error('Gagal mengunduh dokumen peminjaman', [
                'peminjaman_id' => $id,
                'document' => $document,
                'message' => $e->getMessage(),
            ]);

            return redirect('/statusPengajuanAdmin')->with('error', 'Gagal mengunduh dokumen.');
        }
    }
}
