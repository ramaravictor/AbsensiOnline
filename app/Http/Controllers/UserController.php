<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function home(Request $request)
    {
        $user = Auth::user();
        $appTimezone = config('app.timezone');
        $now = Carbon::now($appTimezone);

        $selectedYear = $request->input('year', $now->year);
        $selectedMonth = $request->input('month', $now->month);

        try {
            $currentFilterDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1, $appTimezone);
        } catch (\Exception $e) {
            $currentFilterDate = $now->copy();
            $selectedYear = $now->year;
            $selectedMonth = $now->month;
        }

        $loginTime = null;
        $attendanceToday = Attendance::where('user_id', $user->id)
                            ->whereDate('date', $now->toDateString())
                            ->orderBy('check_in', 'asc')
                            ->first();

        if ($attendanceToday && $attendanceToday->check_in) {
            $loginTime = Carbon::parse($attendanceToday->check_in)->format('H:i');
        }

        $startOfMonth = $currentFilterDate->copy()->startOfMonth();
        $endOfMonth = $currentFilterDate->copy()->endOfMonth();

        $attendancesSelectedMonth = Attendance::where('user_id', $user->id)
                                    ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                                    ->get();

        $rekapHadir = $attendancesSelectedMonth->where('status', 'hadir')->count();
        $rekapSakit = $attendancesSelectedMonth->where('status', 'sakit')->count();
        $rekapIzin = $attendancesSelectedMonth->where('status', 'izin')->count();

        $rekapTerlambat = $attendancesSelectedMonth->where('status', 'hadir')
                                             ->where('keterangan', 'Terlambat')
                                             ->count();

        $rekapAlpha = 0;
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

        $yearsForFilter = [];
        $currentYear = $now->year;
        for ($year = $currentYear + 1; $year >= $currentYear - 5; $year--) {
            $yearsForFilter[] = $year;
        }

        $monthsForFilter = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthsForFilter[$month] = Carbon::create()->month($month)->locale('id')->getTranslatedMonthName();
        }

        if (Attendance::where('user_id', $user->id)->count() == 0) {
             $yearsForFilter = [$now->year];
             $monthsForFilter = [$now->month => Carbon::create()->month($now->month)->locale('id')->getTranslatedMonthName()];
        }

        return view('user.home', compact(
            'loginTime',
            'rekapHadir',
            'rekapSakit',
            'rekapIzin',
            'rekapAlpha',
            'rekapTerlambat',
            'yearsForFilter',
            'monthsForFilter',
            'selectedYear',
            'selectedMonth'
        ));
    }

    public function profil(Request $request)
    {
        $user = Auth::user();
        $appTimezone = config('app.timezone');
        $now = Carbon::now($appTimezone);

        $selectedYear = $request->input('year', $now->year);
        $selectedMonth = $request->input('month', $now->month);
        try {
            $currentFilterDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1, $appTimezone);
        } catch (\Exception $e) {
            $currentFilterDate = $now->copy();
            $selectedYear = $now->year;
            $selectedMonth = $now->month;
        }

        $loginTime = null;
        $attendanceToday = Attendance::where('user_id', $user->id)
                            ->whereDate('date', $now->toDateString())
                            ->orderBy('check_in', 'asc')
                            ->first();
        if ($attendanceToday && $attendanceToday->check_in) {
            $loginTime = Carbon::parse($attendanceToday->check_in)->format('H:i');
        }

        $startOfMonth = $currentFilterDate->copy()->startOfMonth();
        $endOfMonth = $currentFilterDate->copy()->endOfMonth();

        $attendancesSelectedMonth = Attendance::where('user_id', $user->id)
                                    ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                                    ->get();

        $rekapHadir = $attendancesSelectedMonth->where('status', 'hadir')->count();
        $rekapSakit = $attendancesSelectedMonth->where('status', 'sakit')->count();
        $rekapIzin = $attendancesSelectedMonth->where('status', 'izin')->count();
        $rekapTerlambat = $attendancesSelectedMonth->where('status', 'hadir')
                                             ->where('keterangan', 'Terlambat')
                                             ->count();
        $rekapAlpha = 0;
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

        $yearsForFilter = [];
        $currentYearForDropdown = $now->year;
        for ($yearDropdown = $currentYearForDropdown + 1; $yearDropdown >= $currentYearForDropdown - 5; $yearDropdown--) {
            $yearsForFilter[] = $yearDropdown;
        }
        $monthsForFilter = [];
        for ($monthDropdown = 1; $monthDropdown <= 12; $monthDropdown++) {
            $monthsForFilter[$monthDropdown] = Carbon::create()->month($monthDropdown)->locale('id')->getTranslatedMonthName();
        }
         if (Attendance::where('user_id', $user->id)->count() == 0) {
             $yearsForFilter = [$now->year];
             $monthsForFilter = [$now->month => Carbon::create()->month($now->month)->locale('id')->getTranslatedMonthName()];
        }

        return view('user.profil', compact(
            'loginTime',
            'rekapHadir',
            'rekapSakit',
            'rekapIzin',
            'rekapAlpha',
            'rekapTerlambat',
            'yearsForFilter',
            'monthsForFilter',
            'selectedYear',
            'selectedMonth'
        ));
    }

    public function history(Request $request)
    {
        $user = Auth::user();
        $appTimezone = config('app.timezone');
        $now = Carbon::now($appTimezone);

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
                            ->orderBy('date', 'desc')
                            ->orderBy('check_in', 'desc')
                            ->paginate(10)
                            ->withQueryString();

        $yearsForFilter = [];
        $currentYearForDropdown = $now->year;
        for ($yearDropdown = $currentYearForDropdown + 1; $yearDropdown >= $currentYearForDropdown - 5; $yearDropdown--) {
            $yearsForFilter[] = $yearDropdown;
        }
        $monthsForFilter = [];
        for ($monthDropdown = 1; $monthDropdown <= 12; $monthDropdown++) {
            $monthsForFilter[$monthDropdown] = Carbon::create()->month($monthDropdown)->locale('id')->getTranslatedMonthName();
        }
         if (Attendance::where('user_id', $user->id)->count() == 0) {
             $yearsForFilter = [$now->year];
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

    public function showAbsenPage()
    {
        $user = Auth::user();
        $today = Carbon::now(config('app.timezone'))->toDateString();
        $absensiHariIni = Attendance::where('user_id', $user->id)
                                ->where('date', $today)
                                ->first();
        // Logika untuk halaman /user/absen tidak memerlukan data rekap,
        // hanya menampilkan status dari localStorage yang di-set oleh halaman home.
        return view('user.absen'); // Tidak perlu compact('absensiHariIni') jika JS menangani dari localStorage
    }

    public function login()
    {
        return view('auth.login');
    }
}
