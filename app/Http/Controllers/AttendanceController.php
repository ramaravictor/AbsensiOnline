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
            'selected_option' => [ // Opsi yang dipilih di modal (Hadir, Sakit, Izin, Pulang Tepat Waktu)
                Rule::requiredIf(fn () => $request->input('jenis_absen') === 'hadir' || $request->input('jenis_absen') === 'pulang'), // Wajib jika hadir atau pulang
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
        $messageForAlert = "";
        $statusDetailForDisplayPage = "";
        $keteranganForDb = null; // Keterangan yang akan disimpan ke DB ('Terlambat', dll)

        if ($validatedData['jenis_absen'] === 'hadir') {
            $batasAwalAbsenHadir = $jadwalMulaiToday->copy()->subMinutes(60);
            // Batas akhir pengguna BISA melakukan check-in hadir (meskipun akan ditandai sangat terlambat)
            $batasMaksimalCheckIn = $jadwalMulaiToday->copy()->addMinutes(60); // Contoh: Boleh absen hingga 60 menit terlambat

            // Batas waktu untuk dianggap TIDAK TERLAMBAT (toleransi)
            $batasToleransiTidakTerlambat = $jadwalMulaiToday->copy()->addMinutes(60);

            $existingAttendance = Attendance::where('user_id', $user->id)
                                        ->whereDate('date', $today)
                                        ->whereNotNull('check_in')
                                        ->first();

            if ($existingAttendance) {
                return response()->json(['error' => true, 'message' => 'Anda sudah melakukan absensi (hadir/sakit/izin/alpha) hari ini.'], 400);
            }

            if ($now->isBefore($batasAwalAbsenHadir)) {
                return response()->json(['error' => true, 'message' => 'Absen hadir baru dibuka pukul ' . $batasAwalAbsenHadir->format('H:i') . '.'], 400);
            }

            if ($now->isAfter($batasMaksimalCheckIn)) {
                return response()->json(['error' => true, 'message' => 'Batas waktu maksimal untuk absen hadir hari ini (pukul ' . $batasMaksimalCheckIn->format('H:i') . ') telah lewat.'], 400);
            }

            $statusInput = strtolower($validatedData['selected_option']); // 'hadir', 'sakit', atau 'izin'

            if (empty($validatedData['selected_option']) || !in_array($validatedData['selected_option'], ['Hadir', 'Sakit', 'Izin'])) {
                return response()->json(['error' => true, 'message' => 'Silakan pilih status kehadiran (Hadir, Sakit, atau Izin).'], 422);
            }

            if ($statusInput === 'hadir') {
                if ($now->isAfter($batasToleransiTidakTerlambat)) { // LEBIH DARI 15 menit setelah jam mulai
                    $keteranganForDb = 'Terlambat';
                    $durasiTerlambatObj = $now->diff($jadwalMulaiToday);
                    $durasiTerlambatFormatted = ($durasiTerlambatObj->h > 0 ? $durasiTerlambatObj->format('%H jam ') : '') . $durasiTerlambatObj->format('%I menit');
                    $messageForAlert = 'Anda tercatat Hadir (Terlambat '.$durasiTerlambatFormatted.'). Absensi berhasil!';
                    $statusDetailForDisplayPage = "Datang Terlambat";
                } elseif ($now->isAfter($jadwalMulaiToday) && $now->lte($batasToleransiTidakTerlambat)) { // Antara jam mulai s/d +15 menit
                    // Tidak dianggap terlambat parah, tapi bisa diberi keterangan jika mau
                    // $keteranganForDb = 'Terlambat (Toleransi)'; // Jika ingin tetap ada catatan di DB
                    $messageForAlert = 'Absen Hadir (dalam toleransi waktu) berhasil dicatat!';
                    $statusDetailForDisplayPage = "Datang Tepat Waktu"; // Atau "Datang Dalam Toleransi"
                } else { // Tepat waktu atau sebelum jam mulai (dalam rentang -15 menit)
                    $messageForAlert = 'Absen Hadir tepat waktu berhasil dicatat!';
                    $statusDetailForDisplayPage = "Datang Tepat Waktu";
                }
            } elseif (in_array($statusInput, ['sakit', 'izin'])) {
                if ($now->isAfter($jadwalMulaiToday)) {
                    return response()->json(['error' => true, 'message' => 'Anda hanya bisa memilih status Sakit atau Izin sebelum jam kerja dimulai (' . $jadwalMulaiToday->format('H:i') . ').'], 400);
                }
                $messageForAlert = 'Absen '.ucfirst($statusInput).' berhasil dicatat!';
                $statusDetailForDisplayPage = ucfirst($statusInput);
            }

            $attendanceRecord = Attendance::create([
                'user_id' => $user->id,
                'check_in' => $now,
                'date' => $today,
                'status' => $statusInput,
                'keterangan' => $keteranganForDb,
                'location_check_in' => $validatedData['latitude'] . ',' . $validatedData['longitude'],
                'accuracy_check_in' => $validatedData['accuracy'] ?? null,
            ]);

        } elseif ($validatedData['jenis_absen'] === 'pulang') {
            $batasAwalAbsenPulang = $jadwalSelesaiToday->copy();
            $batasAkhirAbsenPulang = $jadwalSelesaiToday->copy()->addMinutes(60); // Toleransi 60 menit untuk pulang

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
                 return response()->json(['error' => true, 'message' => 'Status absensi Anda hari ini (' . ucfirst($attendanceRecord->status) . ') tidak memungkinkan untuk absen pulang.'], 400);
            }

            $attendanceRecord->update([
                'check_out' => $now,
                'location_check_out' => $validatedData['latitude'] . ',' . $validatedData['longitude'],
                'accuracy_check_out' => $validatedData['accuracy'] ?? null,
                // Anda bisa menambahkan logika untuk 'keterangan' pulang cepat di sini jika perlu
            ]);
            $messageForAlert = 'Absen pulang berhasil dicatat!';
            $statusDetailForDisplayPage = "Pulang Tepat Waktu"; // Tambahkan logika cepat pulang jika perlu
        } else {
             return response()->json(['error' => true, 'message' => 'Jenis absen tidak valid.'], 400);
        }

        if ($attendanceRecord) {
            $waktuAbsenYangDitampilkan = ($validatedData['jenis_absen'] === 'hadir') ? $attendanceRecord->check_in : $attendanceRecord->check_out;

            return response()->json([
                'success' => true,
                'message' => $messageForAlert,
                'attendance_details' => [
                    'jenis_absen' => $validatedData['jenis_absen'],
                    'status_detail_display' => $statusDetailForDisplayPage,
                    'time' => Carbon::parse($waktuAbsenYangDitampilkan)->format('H:i:s'),
                    'date' => Carbon::parse($attendanceRecord->date)->translatedFormat('d F Y'),
                    // 'keterangan_db' => $attendanceRecord->keterangan // Jika JS perlu keterangan mentah dari DB
                ]
            ]);
        }
        return response()->json(['error' => true, 'message' => 'Gagal menyimpan atau memproses detail absensi.'], 500);
    }
}
