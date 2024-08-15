<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class StatusPenyewaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dataPeminjaman = Peminjaman::with('ruangan')
            ->orderBy('created_at', 'desc')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('penyewa.statusPenyewa', compact('dataPeminjaman'));
    }

    public function generateInvoice($id)
    {
        $data = Peminjaman::findOrFail($id);

        $pdf = PDF::loadView('penyewa.invoices.invoice', compact('data'))->setPaper([0, 0, 595.28, 566.93], 'portrait');

        return $pdf->stream('invoice.pdf');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
