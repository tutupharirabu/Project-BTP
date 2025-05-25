<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Enums\Database\UsersDatabaseColumn;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(UsersDatabaseColumn::Users->value, function (Blueprint $table) {
            $table->uuid(UsersDatabaseColumn::IdUsers->value)->primary();
            $table->string(UsersDatabaseColumn::Username->value, 255);
            $table->string(UsersDatabaseColumn::Email->value, 255);
            $table->enum(UsersDatabaseColumn::Role->value, ['Admin', 'Petugas']);
            $table->string(UsersDatabaseColumn::NamaLengkap->value, 255);
            $table->string(UsersDatabaseColumn::Password->value, 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(UsersDatabaseColumn::Users->value);
    }
};
