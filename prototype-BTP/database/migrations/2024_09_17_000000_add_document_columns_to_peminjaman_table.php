<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->string('ktm_url')->nullable()->after('ktp_url');
            $table->string('npwp_url')->nullable()->after('ktm_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            if (Schema::hasColumn('peminjaman', 'npwp_url')) {
                $table->dropColumn('npwp_url');
            }
            if (Schema::hasColumn('peminjaman', 'ktm_url')) {
                $table->dropColumn('ktm_url');
            }
        });
    }
};
