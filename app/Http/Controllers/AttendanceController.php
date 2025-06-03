<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AttendanceController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_absen' => ['required', 'string', Rule::in(['hadir', 'pulang'])],
            'latitude' => ['required', 'numeric'],
            'longitude' => ['required', 'numeric'],
            'accuracy' => ['nullable', 'numeric'],
            'selected_option' => [
                Rule::requiredIf(fn () => $request->input('jenis_absen') === 'hadir'),
                'nullable',
                'string',
                Rule::in(['Hadir', 'Sakit', 'Izin', 'Pulang', 'Pulang Tepat Waktu']),
            ],
        ]);

        $user = Auth::user();
        $appTimezone = config('app.timezone');
        $now = Carbon::now($appTimezone);
        $today = $now->toDateString();

        if (!$user->jadwal_kerja_mulai || !$user->jadwal_kerja_selesai) {
            Log::warning("User ID {$user->id}: Jadwal kerja tidak ditemukan saat mencoba absen.");
            return response()->json(['error' => true, 'message' => 'Jadwal kerja Anda belum diatur. Hubungi Admin.'], 400);
        }

        try {
            $jadwalMulaiToday = Carbon::createFromTimeString($user->jadwal_kerja_mulai, $appTimezone)->setDate($now->year, $now->month, $now->day);
            $jadwalSelesaiToday = Carbon::createFromTimeString($user->jadwal_kerja_selesai, $appTimezone)->setDate($now->year, $now->month, $now->day);
        } catch (\Exception $e) {
            Log::error("User ID {$user->id}: Error parsing jadwal kerja - " . $e->getMessage());
            return response()->json(['error' => true, 'message' => 'Format jadwal kerja tidak valid. Hubungi Admin.'], 400);
        }

        $attendanceRecord = null;

        if ($validatedData['jenis_absen'] === 'hadir') {
            $batasAwalAbsenHadir = $jadwalMulaiToday->copy()->subMinutes(15);
            $batasMaksimalCheckIn = $jadwalMulaiToday->copy()->addMinutes(60); // Contoh: Boleh absen hingga 60 menit terlambat

            // Batas akhir untuk dianggap TIDAK TERLAMBAT (toleransi)
            $batasToleransiTidakTerlambat = $jadwalMulaiToday->copy()->addMinutes(15);


            $existingAttendance = Attendance::where('user_id', $user->id)
                                        ->whereDate('date', $today)
                                        ->whereNotNull('check_in')
                                        ->first();

            if ($existingAttendance) {
                return response()->json(['error' => true, 'message' => 'Anda sudah melakukan absensi (hadir/sakit/izin) hari ini.'], 400);
            }

            if ($now->isBefore($batasAwalAbsenHadir)) {
                return response()->json(['error' => true, 'message' => 'Absen hadir baru dibuka pukul ' . $batasAwalAbsenHadir->format('H:i') . '.'], 400);
            }

            if ($now->isAfter($batasMaksimalCheckIn)) {
                return response()->json(['error' => true, 'message' => 'Batas waktu maksimal untuk absen hadir hari ini (pukul ' . $batasMaksimalCheckIn->format('H:i') . ') telah lewat.'], 400);
            }

            $statusAbsen = strtolower($validatedData['selected_option']);
            $keterangan = null;
            $message = 'Absen ' . ucfirst($statusAbsen) . ' berhasil dicatat! Anda akan diarahkan...';

            if (empty($validatedData['selected_option']) || !in_array($validatedData['selected_option'], ['Hadir', 'Sakit', 'Izin'])) {
                return response()->json(['error' => true, 'message' => 'Silakan pilih status kehadiran (Hadir, Sakit, atau Izin).'], 422);
            }

            if ($statusAbsen === 'hadir') {
                // Jika waktu saat ini LEBIH DARI (>) batas toleransi 15 menit SETELAH jam mulai kerja
                if ($now->isAfter($batasToleransiTidakTerlambat)) {
                    $keterangan = 'Terlambat';
                    $durasiTerlambatObj = $now->diff($jadwalMulaiToday); // Hitung selisih dari jam mulai seharusnya
                    $durasiTerlambatFormatted = '';
                    if ($durasiTerlambatObj->h > 0) {
                        $durasiTerlambatFormatted .= $durasiTerlambatObj->format('%H jam ');
                    }
                    $durasiTerlambatFormatted .= $durasiTerlambatObj->format('%I menit');

                    $message = 'Anda tercatat Hadir (Terlambat '.$durasiTerlambatFormatted.'). Absensi berhasil! Anda akan diarahkan...';
                }
                // Jika waktu saat ini SETELAH jam mulai kerja TAPI MASIH DALAM atau SAMA DENGAN batas toleransi 15 menit
                elseif ($now->isAfter($jadwalMulaiToday) && $now->lte($batasToleransiTidakTerlambat)) {
                    // Ini juga bisa dianggap terlambat, tapi mungkin tanpa sanksi atau dengan pesan berbeda
                    // Sesuai permintaan "jika LEBIH dari ini baru terhitung terlambat", maka kondisi di atas yang utama.
                    // Jika ingin kasus ini juga dicatat sebagai "Terlambat" namun dengan pesan berbeda, bisa ditambahkan.
                    // Untuk saat ini, jika dalam 15 menit toleransi, dianggap "tepat waktu" (keterangan = null).
                    // Jika ingin tetap dicatat terlambat tapi tanpa sanksi, set $keterangan = 'Terlambat (Toleransi)';
                    $message = 'Absen Hadir (dalam toleransi) berhasil dicatat! Anda akan diarahkan...';
                } else {
                    // Hadir tepat waktu atau sebelum jam mulai (dalam rentang -15 menit dari jam mulai)
                    $message = 'Absen Hadir tepat waktu berhasil dicatat! Anda akan diarahkan...';
                }
            } elseif (in_array($statusAbsen, ['sakit', 'izin'])) {
                if ($now->isAfter($jadwalMulaiToday)) {
                    return response()->json(['error' => true, 'message' => 'Anda hanya bisa memilih status Sakit atau Izin sebelum jam kerja dimulai (' . $jadwalMulaiToday->format('H:i') . ').'], 400);
                }
            }

            $attendanceRecord = Attendance::create([
                'user_id' => $user->id,
                'check_in' => $now,
                'date' => $today,
                'status' => $statusAbsen,
                'keterangan' => $keterangan,
                'location_check_in' => $validatedData['latitude'] . ',' . $validatedData['longitude'],
                'accuracy_check_in' => $validatedData['accuracy'] ?? null,
            ]);

        } elseif ($validatedData['jenis_absen'] === 'pulang') {
            // ... (Logika absen pulang tetap sama) ...
            $batasAwalAbsenPulang = $jadwalSelesaiToday->copy();
            $batasAkhirAbsenPulang = $jadwalSelesaiToday->copy()->addMinutes(15);

            if (!$now->between($batasAwalAbsenPulang, $batasAkhirAbsenPulang, true)) {
                 return response()->json(['error' => true, 'message' => 'Absen pulang hanya bisa dilakukan antara ' . $batasAwalAbsenPulang->format('H:i') . ' dan ' . $batasAkhirAbsenPulang->format('H:i') . '.'], 400);
            }

            $attendanceRecord = Attendance::where('user_id', $user->id)
                                            ->whereDate('date', $today)
                                            ->whereNotNull('check_in')
                                            ->whereNull('check_out')
                                            ->first();

            if (!$attendanceRecord) {
                return response()->json(['error' => true, 'message' => 'Anda belum melakukan absen hadir hari ini atau sudah absen pulang.'], 400);
            }

            if (in_array($attendanceRecord->status, ['sakit', 'izin', 'alpha'])) {
                 return response()->json(['error' => true, 'message' => 'Status absensi Anda hari ini adalah ' . ucfirst($attendanceRecord->status) . ', tidak dapat melakukan absen pulang.'], 400);
            }

            $attendanceRecord->update([
                'check_out' => $now,
                'location_check_out' => $validatedData['latitude'] . ',' . $validatedData['longitude'],
                'accuracy_check_out' => $validatedData['accuracy'] ?? null,
            ]);
            $message = 'Absen pulang berhasil dicatat! Anda akan diarahkan...';
        } else {
             return response()->json(['error' => true, 'message' => 'Jenis absen tidak valid.'], 400);
        }

        if ($attendanceRecord) {
            $waktuAbsenYangDitampilkan = $validatedData['jenis_absen'] === 'hadir' ? $attendanceRecord->check_in : $attendanceRecord->check_out;
            return response()->json([
                'success' => true,
                'message' => $message,
                'attendance_details' => [
                    'status_display' => $attendanceRecord->statusDisplayAttribute,
                    'time' => Carbon::parse($waktuAbsenYangDitampilkan)->format('H:i:s'),
                    'date' => Carbon::parse($attendanceRecord->date)->translatedFormat('d F Y'),
                    'keterangan' => $attendanceRecord->keterangan ?? null
                ]
            ]);
        }
        return response()->json(['error' => true, 'message' => 'Gagal memproses detail absensi.'], 500);
    }
}
