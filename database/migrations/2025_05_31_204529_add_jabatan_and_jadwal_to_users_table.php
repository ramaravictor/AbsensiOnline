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
        Schema::table('users', function (Blueprint $table) {
            $table->string('jabatan')->nullable()->after('role');
            $table->time('jadwal_kerja_mulai')->nullable()->after('jabatan');
            $table->time('jadwal_kerja_selesai')->nullable()->after('jadwal_kerja_mulai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['jabatan', 'jadwal_kerja_mulai', 'jadwal_kerja_selesai']);
        });
    }
};
