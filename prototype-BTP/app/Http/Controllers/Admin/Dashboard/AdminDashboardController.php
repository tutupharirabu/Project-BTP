<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;

class AdminDashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
        $this->middleware(function ($request, $next) {
            $this->authorize('view-admin-dashboard');
            return $next($request);
        });
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
