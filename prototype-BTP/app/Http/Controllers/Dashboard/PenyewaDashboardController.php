<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;

class PenyewaDashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $data = $this->dashboardService->getDashboardData(false);

        return view('penyewa.userDashboard', [
            'peminjamans' => $data['peminjamans'],
            'events' => $data['events'],
            'RuangDashboard' => $data['RuangDashboard'],
        ]);
    }
}
