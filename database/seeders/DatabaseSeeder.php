<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Sugeng Admin Aplikasi',
            'nip' => '19740199705516001443',
            'email' => 'admin@absensi.test',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => User::ROLE_ADMIN,
            'jabatan' => 'Administrator Sistem', // Contoh Jabatan Admin
            'jadwal_kerja_mulai' => '08:00:00', // Contoh Jadwal Admin
            'jadwal_kerja_selesai' => '17:00:00', // Contoh Jadwal Admin
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Karyawan Contoh Satu',
            'nip' => '72738274612199705001',
            'email' => 'karyawan1@absensi.test',
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => User::ROLE_EMPLOYEE,
            'jabatan' => 'Staf IT', // Contoh Jabatan Karyawan
            'jadwal_kerja_mulai' => '09:00:00', // Contoh Jadwal Karyawan
            'jadwal_kerja_selesai' => '17:30:00', // Contoh Jadwal Karyawan
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Karyawan Contoh Dua',
            'nip' => '83629173920199807002', // Pastikan NIP unik
            'email' => 'karyawan2@absensi.test', // Pastikan Email unik
            'password' => Hash::make('password'), // Ganti dengan password aman
            'role' => User::ROLE_EMPLOYEE,
            'jabatan' => 'Staf Administrasi', // Contoh Jabatan Karyawan lain
            'jadwal_kerja_mulai' => '08:30:00',
            'jadwal_kerja_selesai' => '17:00:00',
            'email_verified_at' => now(),
        ]);
    }
}
