<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function home(Request $request) // Tambahkan Request $request
    {
        $user = Auth::user();
        $appTimezone = config('app.timezone');
        $now = Carbon::now($appTimezone);

        // Tentukan bulan dan tahun untuk filter
        // Ambil dari request, atau default ke bulan dan tahun saat ini
        $selectedYear = $request->input('year', $now->year);
        $selectedMonth = $request->input('month', $now->month);

        // Buat objek Carbon dari bulan dan tahun yang dipilih untuk perhitungan
        try {
            $currentFilterDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1, $appTimezone);
        } catch (\Exception $e) {
            // Fallback jika input tidak valid, gunakan tanggal saat ini
            $currentFilterDate = $now->copy();
            $selectedYear = $now->year;
            $selectedMonth = $now->month;
        }

        $loginTime = null;
        $attendanceToday = Attendance::where('user_id', $user->id)
                            ->whereDate('date', $now->toDateString()) // Selalu cek untuk hari ini
                            ->orderBy('check_in', 'asc')
                            ->first();

        if ($attendanceToday && $attendanceToday->check_in) {
            $loginTime = Carbon::parse($attendanceToday->check_in)->format('H:i');
        }

        // --- Rekap Absensi untuk Bulan dan Tahun yang Dipilih ---
        $startOfMonth = $currentFilterDate->copy()->startOfMonth();
        $endOfMonth = $currentFilterDate->copy()->endOfMonth();

        $attendancesSelectedMonth = Attendance::where('user_id', $user->id)
                                    ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                                    ->get();

        $rekapHadir = $attendancesSelectedMonth->where('status', 'hadir')->count();
        $rekapSakit = $attendancesSelectedMonth->where('status', 'sakit')->count();
        $rekapIzin = $attendancesSelectedMonth->where('status', 'izin')->count();

        $rekapTerlambat = 0;
        if ($user->jadwal_kerja_mulai) {
            try {
                $jadwalMulaiUser = Carbon::createFromTimeString($user->jadwal_kerja_mulai, $appTimezone);
                foreach ($attendancesSelectedMonth->where('status', 'hadir') as $attendance) {
                    if ($attendance->check_in) {
                        $checkInTime = Carbon::parse($attendance->check_in);
                        $jadwalMulaiPadaHariAbsen = $jadwalMulaiUser->copy()->setDateFrom($checkInTime);
                        if ($checkInTime->isAfter($jadwalMulaiPadaHariAbsen)) {
                            $rekapTerlambat++;
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error("Error parsing jadwal_kerja_mulai untuk user {$user->id} saat menghitung keterlambatan: " . $e->getMessage());
            }
        }

        $rekapAlpha = 0;
        // Untuk Alpha, kita hitung dari awal bulan yang dipilih hingga hari ini JIKA bulan yang dipilih adalah bulan saat ini
        // ATAU hingga akhir bulan yang dipilih JIKA bulan yang dipilih adalah bulan lalu.
        $endDateForAlphaCheck = $currentFilterDate->isSameMonth($now, true) ? $now->copy()->min($endOfMonth) : $endOfMonth->copy();

        if ($user->jadwal_kerja_mulai && $user->jadwal_kerja_selesai) {
            $period = CarbonPeriod::create($startOfMonth, $endDateForAlphaCheck);
            foreach ($period as $date) {
                if ($date->isWeekday()) {
                    $hasAttendanceRecord = $attendancesSelectedMonth->contains(function ($attendance) use ($date) {
                        return Carbon::parse($attendance->date)->isSameDay($date) &&
                               in_array(strtolower($attendance->status), ['hadir', 'sakit', 'izin']);
                    });
                    if (!$hasAttendanceRecord) {
                        $rekapAlpha++;
                    }
                }
            }
        }

        // Menyiapkan data untuk dropdown filter
        $yearsForFilter = [];
        $currentYear = $now->year;
        // Ambil 5 tahun ke belakang dan 1 tahun ke depan untuk opsi tahun
        for ($year = $currentYear + 1; $year >= $currentYear - 5; $year--) {
            $yearsForFilter[] = $year;
        }

        $monthsForFilter = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthsForFilter[$month] = Carbon::create()->month($month)->getTranslatedMonthName('id'); // Nama bulan dalam Bahasa Indonesia
        }


        return view('user.home', compact(
            'loginTime',
            'rekapHadir',
            'rekapSakit',
            'rekapIzin',
            'rekapAlpha',
            'rekapTerlambat',
            'yearsForFilter',     // Kirim data tahun ke view
            'monthsForFilter',    // Kirim data bulan ke view
            'selectedYear',       // Kirim tahun yang dipilih saat ini
            'selectedMonth'       // Kirim bulan yang dipilih saat ini
        ));
    }

    public function showAbsenPage() // Method untuk menampilkan halaman /user/absen
    {
        // Anda bisa mengirim data status absensi terakhir ke halaman ini jika perlu
        $user = Auth::user();
        $today = Carbon::now()->toDateString();
        $absensiHariIni = Attendance::where('user_id', $user->id)
                                ->where('date', $today)
                                ->first();

        return view('user.absen', compact('absensiHariIni')); // Pastikan view 'user.absen' ada
    }

    public function history(Request $request)
    {
        $user = Auth::user();
        $appTimezone = config('app.timezone');
        $now = Carbon::now($appTimezone);

        // Tentukan bulan dan tahun untuk filter
        $selectedYear = $request->input('year', $now->year);
        $selectedMonth = $request->input('month', $now->month);

        try {
            $currentFilterDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1, $appTimezone);
        } catch (\Exception $e) {
            $currentFilterDate = $now->copy();
            $selectedYear = $now->year;
            $selectedMonth = $now->month;
        }

        $startOfSelectedMonth = $currentFilterDate->copy()->startOfMonth();
        $endOfSelectedMonth = $currentFilterDate->copy()->endOfMonth();

        $history = Attendance::where('user_id', $user->id)
                            ->whereBetween('date', [$startOfSelectedMonth->toDateString(), $endOfSelectedMonth->toDateString()])
                            ->orderBy('date', 'desc') // Urutkan dari tanggal terbaru
                            ->orderBy('check_in', 'desc') // Jika ada beberapa entri di hari yang sama
                            ->paginate(10) // Paginasi 10 item per halaman
                            ->withQueryString(); // Agar parameter filter (month, year) terbawa saat paginasi

        // Menyiapkan data untuk dropdown filter
        $yearsForFilter = [];
        $currentYear = $now->year;
        for ($year = $currentYear + 1; $year >= $currentYear - 5; $year--) {
            $yearsForFilter[] = $year;
        }

        $monthsForFilter = [];
        for ($month = 1; $month <= 12; $month++) {
            // Menggunakan Carbon untuk mendapatkan nama bulan dalam Bahasa Indonesia
            $monthsForFilter[$month] = Carbon::create()->month($month)->locale('id')->getTranslatedMonthName();
        }

        // Jika tidak ada data absensi sama sekali untuk pengguna, untuk menghindari error pada filter
        if (Attendance::where('user_id', $user->id)->count() == 0) {
             $yearsForFilter = [$now->year]; // Hanya tahun ini
             $monthsForFilter = [$now->month => Carbon::create()->month($now->month)->locale('id')->getTranslatedMonthName()];
        }


        return view('user.history', compact(
            'history',
            'yearsForFilter',
            'monthsForFilter',
            'selectedYear',
            'selectedMonth'
        ));
    }


    public function login()
    {
        return view('auth.login');
    }

    public function profil()
    {
        return view('user.profil');
    }
}
