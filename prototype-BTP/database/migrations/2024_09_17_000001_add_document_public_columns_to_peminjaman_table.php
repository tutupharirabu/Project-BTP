<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('ktp_public_id')->nullable()->after('ktp_url');
            $table->string('ktp_format')->nullable()->after('ktp_public_id');
            $table->string('ktm_public_id')->nullable()->after('ktm_url');
            $table->string('ktm_format')->nullable()->after('ktm_public_id');
            $table->string('npwp_public_id')->nullable()->after('npwp_url');
            $table->string('npwp_format')->nullable()->after('npwp_public_id');
        });
    }

    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            foreach ([
                'npwp_format',
                'npwp_public_id',
                'ktm_format',
                'ktm_public_id',
                'ktp_format',
                'ktp_public_id',
            ] as $column) {
                if (Schema::hasColumn('peminjaman', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
