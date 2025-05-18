<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class HealthCheckController extends Controller
{
    public function check()
    {
        try {
            // Periksa koneksi database tanpa menampilkan info sensitif
            DB::connection()->getPdo();

            // Respons yang tidak mengungkapkan detail
            return response('OK', 200);
        } catch (\Exception $e) {
            // Log error lengkap, tapi respons terbatas
            \Log::error('Healthcheck failed: ' . $e->getMessage());
            return response('Service Unavailable', 503);
        }
    }
}
