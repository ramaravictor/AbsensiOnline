<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboardAdmin');
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





    public function login()
    {
        return view('admin.loginAdmin');
    }

    public function rekapAbsensi()
    {
        return view('admin.rekapAbsensi');
    }

    public function profilAdmin()
    {
        return view('admin.profilAdmin');
    }
}
