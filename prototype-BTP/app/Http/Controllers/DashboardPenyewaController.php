<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use DateTime;


class DashboardPenyewaController extends Controller
{
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $date = $request->query('date') ? new DateTime($request->query('date')) : new DateTime('this week');
    $weekStart = (clone $date)->modify('this week');
    $weekEnd = (clone $weekStart)->modify('+6 days');

    $dataPeminjaman = Peminjaman::with('ruangan')
        ->whereBetween('tanggal_mulai', [$weekStart->format('Y-m-d'), $weekEnd->format('Y-m-d')])
        ->where('status','Disetujui')
        ->get();

    if ($request->ajax()) {
        return response()->json(['events' => $dataPeminjaman, 'weekStart' => $weekStart->format('Y-m-d')]);
    }

    return view('userDashboard', compact('dataPeminjaman', 'weekStart'));
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

