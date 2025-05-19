<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;

class AdminDashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $data = $this->dashboardService->getDashboardData(true);

        return view('admin.adminDashboard', [
            'peminjamans' => $data['peminjamans'],
            'events' => $data['events'],
            'occupancyPerMonth' => $data['occupancyPerMonth'],
            'totalCapacityPerRoom' => $data['totalCapacityPerRoom'],
        ]);
    }
}
