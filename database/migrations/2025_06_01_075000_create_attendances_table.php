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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id(); // Kolom ID auto-increment (Primary Key)
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key ke tabel 'users', onDelete('cascade') berarti jika user dihapus, absensinya juga terhapus
            $table->timestamp('check_in')->nullable(); // Waktu absen masuk
            $table->timestamp('check_out')->nullable(); // Waktu absen pulang
            $table->date('date'); // Tanggal absensi (bisa juga didapat dari check_in, tapi ini mempermudah query)
            $table->string('status'); // Status absensi: 'hadir', 'sakit', 'izin', 'alpha', 'terlambat', dll.
            $table->string('location_check_in')->nullable(); // Koordinat atau nama lokasi saat check-in
            $table->string('location_check_out')->nullable(); // Koordinat atau nama lokasi saat check-out
            $table->string('accuracy_check_in')->nullable(); // Akurasi lokasi GPS saat check-in (dalam meter)
            $table->string('accuracy_check_out')->nullable(); // Akurasi lokasi GPS saat check-out (dalam meter)
            $table->text('notes')->nullable(); // Catatan tambahan jika ada
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
