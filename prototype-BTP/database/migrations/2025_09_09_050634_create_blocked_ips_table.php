<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockedIpsTable extends Migration
{
    public function up()
    {
        Schema::create('blocked_ips', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('blocked_ips');
    }
}