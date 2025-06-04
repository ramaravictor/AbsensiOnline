<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil Pengguna - {{ Auth::user()->name ?? 'Pengguna' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <!-- Navbar -->
    <nav class="bg-blue-700 flex items-center justify-between px-4 sm:px-6 py-3 shadow-md relative">
        <div>
            <a href="{{ route('user.profil') }}"
                class="text-white text-base sm:text-[17px] font-normal leading-tight sm:leading-[20px] underline">
                {{ Auth::user()->name ?? 'Nama Pengguna' }}
            </a>
            <div class="text-white text-xs sm:text-[11px] font-normal leading-tight sm:leading-[13px] mt-[2px]">
                NIP: {{ Auth::user()->nip ?? 'NIP Pengguna' }}
            </div>
        </div>
        <div
            class="flex items-center space-x-4 sm:space-x-8 text-white text-sm sm:text-[14px] font-semibold leading-tight sm:leading-[16px] relative">
            <a href="{{ route('user.home') }}" class="hover:underline">Home</a>
            <a href="{{ route('user.profil') }}" class="border-b-2 border-white pb-[2px]">Profil</a>
            <a href="{{ route('user.history') }}" class="hover:underline">Riwayat</a>
            <div class="relative">
                <button id="userBtnProfil" aria-label="User menu" class="focus:outline-none">
                    <i class="fas fa-user-circle text-xl sm:text-[24px]"></i>
                </button>
                <div id="userDropdownProfil"
                    class="hidden absolute right-0 top-full mt-1 w-48 bg-gray-200 rounded shadow-lg text-gray-800 z-50">
                    <div class="px-4 py-3 border-b border-gray-300">
                        <p class="font-semibold text-sm">{{ Auth::user()->name ?? 'Nama Pengguna' }}</p>
                        <p class="text-xs truncate">{{ Auth::user()->email ?? 'email@example.com' }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="w-full"
                        onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center justify-center gap-2 text-red-600 text-sm font-semibold py-2 hover:bg-red-100">
                            <i class="fas fa-power-off"></i> LOGOUT
                        </button>
                    </form>
                </div>
            </div>
    </nav>

    <!-- Main content -->
    <main class="flex-grow flex justify-center items-start py-10 px-4">
        <section class="w-full max-w-2xl rounded-lg shadow-xl border border-gray-200 overflow-hidden">
            <!-- Header Profil Pengguna (Hijau) -->
            <div
                class="bg-gradient-to-r from-green-500 to-emerald-600 p-8 rounded-t-lg flex flex-col items-center text-white">
                @php
                    $name = Auth::user()->name ?? 'User';
                    // Menggunakan avatar_url dari database jika ada, jika tidak, gunakan UI Avatars
                    $avatar =
                        Auth::user()->avatar_url ??
                        'https://ui-avatars.com/api/?name=' .
                            urlencode($name) .
                            '&background=0D8B2E&color=fff&size=96&font-size=0.33&bold=true&rounded=true';
                @endphp
                <img alt="Avatar of {{ $name }}"
                    class="w-24 h-24 rounded-full mb-4 border-4 border-white shadow-lg" src="{{ $avatar }}" />
                <h1 class="text-2xl font-semibold leading-tight">
                    {{ Auth::user()->name ?? 'Nama Pengguna' }}
                </h1>
                <p class="text-sm font-normal leading-tight tracking-wider mt-1">
                    NIP: {{ Auth::user()->nip ?? '-' }}
                </p>
                <p class="text-sm font-normal leading-tight tracking-wider mt-2 text-center max-w-xs">
                    {{ Auth::user()->jabatan ?? 'Jabatan Belum Diatur' }}
                </p>
            </div>

            <!-- Area Konten Putih untuk Detail Informasi -->
            <div class="bg-white p-6 sm:p-8">
                {{-- Detail Informasi Pegawai --}}
                <div class="bg-gray-50 rounded-lg p-6 text-sm text-gray-700 leading-relaxed relative shadow mb-6">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-600 rounded-l-md"></div>
                    <div class="pl-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Pegawai</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                            <div>
                                <strong class="block text-gray-500">Email:</strong>
                                <p class="text-gray-800">{{ Auth::user()->email ?? '-' }}</p>
                            </div>
                            <div>
                                <strong class="block text-gray-500">Role:</strong>
                                <p class="text-gray-800">{{ Str::ucfirst(Auth::user()->role ?? '-') }}</p>
                            </div>
                            <div>
                                <strong class="block text-gray-500">Jadwal Kerja Mulai:</strong>
                                <p class="text-gray-800">
                                    {{ Auth::user()->jadwal_kerja_mulai ? \Carbon\Carbon::parse(Auth::user()->jadwal_kerja_mulai)->format('H:i') : '-' }}
                                </p>
                            </div>
                            <div>
                                <strong class="block text-gray-500">Jadwal Kerja Selesai:</strong>
                                <p class="text-gray-800">
                                    {{ Auth::user()->jadwal_kerja_selesai ? \Carbon\Carbon::parse(Auth::user()->jadwal_kerja_selesai)->format('H:i') : '-' }}
                                </p>
                            </div>
                            <div class="md:col-span-2">
                                <strong class="block text-gray-500">Terakhir Login Sistem:</strong>
                                <p class="text-gray-800">
                                    {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->translatedFormat('d F Y, H:i') : 'Belum tercatat' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Instansi (Contoh Data Statis, sesuaikan jika dinamis) --}}
                <div class="bg-gray-50 rounded-lg p-6 text-sm text-gray-700 leading-relaxed relative shadow">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-600 rounded-l-md"></div>
                    <div class="pl-4">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Instansi</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                            <div>
                                <strong class="block text-gray-500">Instansi:</strong>
                                <p class="text-gray-800">
                                    {{ Auth::user()->instansi ?? 'Pemerintah Provinsi Lombok Barat (Contoh)' }}</p>
                            </div>
                            <div>
                                <strong class="block text-gray-500">Kantor/Unit Kerja:</strong>
                                <p class="text-gray-800">
                                    {{ Auth::user()->unit_kerja ?? 'Dinas Lingkungan Hidup (Contoh)' }}</p>
                            </div>
                            <div>
                                <strong class="block text-gray-500">Eselon:</strong>
                                <p class="text-gray-800">{{ Auth::user()->eselon ?? '- - -' }}</p>
                            </div>
                            <div>
                                <strong class="block text-gray-500">Pangkat / Golongan:</strong>
                                <p class="text-gray-800">
                                    {{ Auth::user()->pangkat_golongan ?? 'Pembina Tk. I / IV - a (Contoh)' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('user.home') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition text-base">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali ke Home
                    </a>
                    {{-- Jika ada halaman edit profil pengguna oleh pengguna itu sendiri --}}
                    {{-- <a href="{{ route('user.profil.edit') }}" class="ml-4 bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg transition text-base">
                        <i class="fas fa-edit mr-2"></i>Edit Profil Saya
                    </a> --}}
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userBtnProfil = document.getElementById('userBtnProfil');
            const userDropdownProfil = document.getElementById('userDropdownProfil');

            if (userBtnProfil && userDropdownProfil) {
                userBtnProfil.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userDropdownProfil.classList.toggle('hidden');
                });

                document.addEventListener('click', (e) => {
                    // Pastikan userDropdownProfil tidak null sebelum mengakses classList
                    if (userDropdownProfil && !userDropdownProfil.classList.contains('hidden') &&
                        userBtnProfil && !userBtnProfil.contains(e.target) &&
                        !userDropdownProfil.contains(e.target)) {
                        userDropdownProfil.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
