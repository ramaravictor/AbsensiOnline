<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // Untuk mengakses jadwal kerja user
use Illuminate\Support\Facades\Log;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'check_in',
        'check_out',
        'date',
        'status', // 'hadir', 'sakit', 'izin', 'alpha'
        'keterangan', // 'Terlambat', 'Cepat Pulang', dll.
        'location_check_in',
        'location_check_out',
        'accuracy_check_in',
        'accuracy_check_out',
        'notes',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor untuk mendapatkan tanggal yang diformat.
     * Contoh: 03 Juni 2025
     */
    public function getFormattedDateAttribute(): string
    {
        return Carbon::parse($this->date)->translatedFormat('d F Y');
    }

    /**
     * Accessor untuk mendapatkan waktu check_in yang diformat.
     * Contoh: 08:00:00
     */
    public function getFormattedCheckInAttribute(): ?string
    {
        return $this->check_in ? Carbon::parse($this->check_in)->format('H:i:s') : null;
    }

    /**
     * Accessor untuk mendapatkan waktu check_out yang diformat.
     * Contoh: 17:00:00
     */
    public function getFormattedCheckOutAttribute(): ?string
    {
        return $this->check_out ? Carbon::parse($this->check_out)->format('H:i:s') : null;
    }

    /**
     * Accessor untuk menghitung durasi keterlambatan.
     * Mengembalikan string format HH:MM:SS atau null jika tidak terlambat/tidak ada jadwal.
     */
    public function getDurasiTerlambatAttribute(): ?string
    {
        $user = $this->user; // Ambil user terkait dari relasi
        if (!$user || !$user->jadwal_kerja_mulai || !$this->check_in || $this->status !== 'hadir') {
            return '00:00:00'; // Atau null jika lebih sesuai
        }

        try {
            $jadwalMulaiUser = Carbon::createFromTimeString($user->jadwal_kerja_mulai, config('app.timezone'));
            $checkInTime = Carbon::parse($this->check_in);
            $jadwalMulaiPadaHariAbsen = $jadwalMulaiUser->copy()->setDateFrom($checkInTime);

            if ($checkInTime->isAfter($jadwalMulaiPadaHariAbsen)) {
                $diffInSeconds = $checkInTime->diffInSeconds($jadwalMulaiPadaHariAbsen);
                return gmdate('H:i:s', $diffInSeconds);
            }
        } catch (\Exception $e) {
            // Log error jika ada masalah parsing
            Log::error("Error calculating lateness for attendance ID {$this->id}: " . $e->getMessage());
            return 'Error';
        }
        return '00:00:00'; // Tidak terlambat
    }

    /**
     * Accessor untuk menghitung durasi pulang cepat.
     * Mengembalikan string format HH:MM:SS atau null jika tidak cepat pulang/tidak ada jadwal.
     */
    public function getDurasiCepatPulangAttribute(): ?string
    {
        $user = $this->user;
        if (!$user || !$user->jadwal_kerja_selesai || !$this->check_out || $this->status !== 'hadir') {
            return '00:00:00'; // Atau null
        }

        try {
            $jadwalSelesaiUser = Carbon::createFromTimeString($user->jadwal_kerja_selesai, config('app.timezone'));
            $checkOutTime = Carbon::parse($this->check_out);
            $jadwalSelesaiPadaHariAbsen = $jadwalSelesaiUser->copy()->setDateFrom($checkOutTime);

            if ($checkOutTime->isBefore($jadwalSelesaiPadaHariAbsen)) {
                $diffInSeconds = $jadwalSelesaiPadaHariAbsen->diffInSeconds($checkOutTime);
                return gmdate('H:i:s', $diffInSeconds);
            }
        } catch (\Exception $e) {
            Log::error("Error calculating early departure for attendance ID {$this->id}: " . $e->getMessage());
            return 'Error';
        }
        return '00:00:00'; // Tidak pulang cepat
    }

    /**
     * Accessor untuk menentukan teks status utama yang akan ditampilkan.
     */
    public function getStatusDisplayAttribute(): string
    {
        if ($this->status === 'hadir') {
            // Keterangan akan ditangani terpisah di view
            return 'Hadir';
        }
        if ($this->status === 'sakit') {
            return 'Sakit';
        }
        if ($this->status === 'izin') {
            return 'Izin';
        }
        if ($this->status === 'alpha') {
            return 'Alpha (Tidak Hadir)';
        }
        return ucfirst($this->status) ?: 'Tidak Diketahui';
    }

    /**
     * Accessor untuk menentukan warna teks status.
     */
    public function getStatusTextColorAttribute(): string
    {
        if ($this->status === 'hadir') {
            return $this->keterangan === 'Terlambat' ? 'text-red-600' : 'text-green-600';
        }
        if ($this->status === 'sakit') {
            return 'text-blue-600';
        }
        if ($this->status === 'izin') {
            return 'text-yellow-600';
        }
        if ($this->status === 'alpha') {
            return 'text-red-600';
        }
        return 'text-gray-700';
    }

    /**
     * Accessor untuk menentukan warna border kiri.
     */
    public function getBorderColorAttribute(): string
    {
        if ($this->status === 'alpha' || ($this->status === 'hadir' && $this->keterangan === 'Terlambat')) {
            return 'border-red-500';
        }
        return 'border-[#0B57A4]'; // Default biru
    }
}
