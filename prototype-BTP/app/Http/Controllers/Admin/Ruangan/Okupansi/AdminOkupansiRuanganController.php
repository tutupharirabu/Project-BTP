<?php

namespace App\Http\Controllers\Admin\Ruangan\Okupansi;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use App\Services\Ruangan\Okupansi\AdminOkupansiService;

class AdminOkupansiRuanganController extends Controller
{
    protected AdminOkupansiService $adminOkupansiService;

    public function __construct(AdminOkupansiService $adminOkupansiService)
    {
        $this->adminOkupansiService = $adminOkupansiService;
    }

    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $okupansiData = $this->adminOkupansiService->getOkupansiData($selectedMonth);

        return view('admin.okupansi', array_merge($okupansiData, ['selectedMonth' => $selectedMonth]));
    }

    public function downloadOkupansi(Request $request)
    {
        $selectedMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $okupansiData = $this->adminOkupansiService->getOkupansiData($selectedMonth);
        $csvResult = $this->adminOkupansiService->generateCsvData($okupansiData, $selectedMonth);
        $csvData = $csvResult['csvData'];

        $fileName = 'Data Okupansi Peminjaman Ruangan BTP.csv';
        $filePath = storage_path('app/public/' . $fileName);

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0777, true);
        }

        $file = fopen($filePath, 'w');
        foreach ($csvData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);

        return Response::download($filePath);
    }
}
