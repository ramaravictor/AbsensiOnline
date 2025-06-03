<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        $appTimezone = config('app.timezone');
        $now = Carbon::now($appTimezone);
        $today = $now->toDateString();
        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();

        // 1. Total Karyawan (hanya role 'employee')
        $totalKaryawan = User::where('role', User::ROLE_EMPLOYEE)->count();

        // Data untuk hari ini
        $attendancesToday = Attendance::with('user')
                                ->where('date', $today)
                                ->get();

        // 2. Karyawan Tepat Waktu Hari Ini
        // Asumsi: status 'hadir' dan keterangan BUKAN 'Terlambat'
        $tepatWaktuHariIni = $attendancesToday->filter(function ($attendance) {
            return $attendance->status === 'hadir' && $attendance->keterangan !== 'Terlambat';
        })->count();

        // 3. Karyawan Terlambat Hari Ini
        // Asumsi: status 'hadir' dan keterangan 'Terlambat'
        $terlambatHariIni = $attendancesToday->where('status', 'hadir')
                                          ->where('keterangan', 'Terlambat')
                                          ->count();

        // 4. Total Karyawan Hadir (Presentasi) Hari Ini
        $hadirHariIni = $attendancesToday->where('status', 'hadir')->count();


        // Data untuk bulan ini
        $attendancesThisMonth = Attendance::whereBetween('date', [$startOfMonth, $endOfMonth])
                                    ->get();

        // 5. Persentase Tepat Waktu Bulan Ini
        $totalHadirBulanIni = $attendancesThisMonth->where('status', 'hadir')->count();
        $totalTepatWaktuBulanIni = $attendancesThisMonth->filter(function ($attendance) {
            return $attendance->status === 'hadir' && $attendance->keterangan !== 'Terlambat';
        })->count();

        $persentaseTepatWaktu = ($totalHadirBulanIni > 0) ? round(($totalTepatWaktuBulanIni / $totalHadirBulanIni) * 100, 2) : 0;

        // 6. Jumlah Karyawan Cuti/Izin/Sakit Bulan Ini
        // Kita gabungkan 'izin' dan 'sakit' sebagai "Tidak Masuk (Izin/Sakit)"
        $tidakMasukDenganKeteranganBulanIni = $attendancesThisMonth->whereIn('status', ['izin', 'sakit'])->count();


        return view('admin.dashboardAdmin', compact(
            'totalKaryawan',
            'persentaseTepatWaktu',
            'tepatWaktuHariIni',
            'terlambatHariIni',
            'hadirHariIni', // Ini adalah "Presentasi Hari ini"
            'tidakMasukDenganKeteranganBulanIni' // Ini adalah "Cuti Bulan ini"
        ));
    }

    public function karyawan(Request $request) // Inject Request
    {
        $searchQuery = $request->input('search_pengguna'); // Ambil kata kunci dari input

        $query = User::query(); // Mulai dengan query builder

        if ($searchQuery) {
            // Jika ada kata kunci pencarian, tambahkan kondisi WHERE
            $query->where(function ($q) use ($searchQuery) {
                $q->where('name', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('nip', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('email', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('jabatan', 'LIKE', "%{$searchQuery}%")
                  ->orWhere('role', 'LIKE', "%{$searchQuery}%"); // Anda juga bisa mencari berdasarkan role
            });
        }

        $users = $query->orderBy('name', 'asc')->paginate(10);

        return view('admin.dataKaryawan', [
            'users' => $users,
            // Opsional: kirim kembali searchQuery untuk ditampilkan di input jika Anda tidak menggunakan request() helper di blade
            // 'searchQuery' => $searchQuery
        ]);
    }


    /**
     * Menampilkan form untuk mengedit data pengguna.
     */
    public function editKaryawan(User $user) // Menggunakan Route Model Binding
    {
        // Anda bisa mengambil daftar role atau data lain jika diperlukan untuk form
        $roles = [User::ROLE_ADMIN, User::ROLE_EMPLOYEE]; // Contoh jika Anda ingin dropdown role

        return view('admin.karyawan.edit', [
            'user' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Mengupdate data pengguna di database.
     */
    public function updateKaryawan(Request $request, User $user) // Menggunakan Route Model Binding
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', Rule::in([User::ROLE_ADMIN, User::ROLE_EMPLOYEE])],
            'jadwal_kerja_mulai' => ['nullable', 'date_format:H:i'],
            'jadwal_kerja_selesai' => ['nullable', 'date_format:H:i', 'after_or_equal:jadwal_kerja_mulai'], // Menggunakan after_or_equal untuk fleksibilitas

            'password' => ['nullable', 'string', 'confirmed', Password::min(8)],
            // Jika password diisi (tidak null atau string kosong), maka harus string, terkonfirmasi, dan minimal 8 karakter.
            // Jika password tidak diisi (null), aturan ini akan dilewati berkat 'nullable'.
        ]);

        // Update data utama pengguna
        $user->name = $validatedData['name'];
        $user->nip = $validatedData['nip'];
        $user->email = $validatedData['email'];
        $user->jabatan = $validatedData['jabatan'];
        $user->role = $validatedData['role'];
        $user->jadwal_kerja_mulai = $validatedData['jadwal_kerja_mulai'];
        $user->jadwal_kerja_selesai = $validatedData['jadwal_kerja_selesai'];

        // Update password hanya jika diisi dan valid
        if ($request->filled('password')) { // Pastikan password benar-benar diisi, bukan hanya string kosong
            if ($validatedData['password']) { // Cek apakah password lolos validasi (ada di $validatedData)
                $user->password = Hash::make($validatedData['password']);
            }
        }
        $user->save();

        return redirect()->route('admin.karyawan')->with('success', 'Data pengguna berhasil diperbarui.');
    }


    /**
     * Menghapus data pengguna dari database.
     */
    public function destroyKaryawan(User $user) // Menggunakan Route Model Binding
    {
        // Tambahkan logika untuk mencegah admin menghapus dirinya sendiri jika perlu
        if (Auth::id() === $user->id) {
            return redirect()->route('admin.karyawan')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.karyawan')->with('success', 'Data pengguna berhasil dihapus.');
    }





    // public function login()
    // {
    //     return view('admin.loginAdmin');
    // }

    public function rekapAbsensi(Request $request)
    {
        $appTimezone = config('app.timezone');
        $now = Carbon::now($appTimezone);

        // Tentukan bulan dan tahun untuk filter
        $selectedYear = $request->input('year', $now->year);
        $selectedMonth = $request->input('month', $now->month);

        try {
            $currentFilterDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1, $appTimezone);
        } catch (\Exception $e) {
            // Fallback jika input tidak valid, gunakan tanggal saat ini
            $currentFilterDate = $now->copy();
            $selectedYear = $now->year;
            $selectedMonth = $now->month;
        }

        $startOfSelectedMonth = $currentFilterDate->copy()->startOfMonth();
        $endOfSelectedMonth = $currentFilterDate->copy()->endOfMonth();

        // Ambil semua data absensi untuk bulan dan tahun yang dipilih
        // Sertakan data pengguna terkait untuk menampilkan nama dan NIP
        $rekapAttendances = Attendance::with('user') // Eager load relasi user
                                ->whereBetween('date', [$startOfSelectedMonth->toDateString(), $endOfSelectedMonth->toDateString()])
                                ->orderBy('date', 'desc')
                                ->orderBy('user_id', 'asc')
                                ->orderBy('check_in', 'asc')
                                ->paginate(20) // Sesuaikan jumlah item per halaman
                                ->withQueryString(); // Agar parameter filter terbawa saat paginasi

        // Menyiapkan data untuk dropdown filter
        $yearsForFilter = [];
        $currentYear = $now->year;
        // Ambil 5 tahun ke belakang dan 1 tahun ke depan untuk opsi tahun
        for ($year = $currentYear + 1; $year >= $currentYear - 5; $year--) {
            $yearsForFilter[] = $year;
        }

        $monthsForFilter = [];
        for ($month = 1; $month <= 12; $month++) {
            $monthsForFilter[$month] = Carbon::create()->month($month)->locale('id')->getTranslatedMonthName();
        }

        // Jika tidak ada data absensi sama sekali untuk filter awal
        if (Attendance::count() == 0 && !$request->has('month') && !$request->has('year')) {
             $yearsForFilter = [$now->year];
             $monthsForFilter = [$now->month => Carbon::create()->month($now->month)->locale('id')->getTranslatedMonthName()];
        }


        return view('admin.rekapAbsensi', compact( // Pastikan path view Anda benar
            'rekapAttendances',
            'yearsForFilter',
            'monthsForFilter',
            'selectedYear',
            'selectedMonth'
        ));
    }

    public function profilAdmin()
    {
        return view('admin.profilAdmin');
    }
}
