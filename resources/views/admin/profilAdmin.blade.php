<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Profil Admin - {{ Auth::user()->name ?? 'Admin' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: "Poppins", sans-serif;
        }

        aside::-webkit-scrollbar {
            width: 6px;
        }

        aside::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
    </style>
</head>

<body class="bg-gray-200 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-[#0a4aa0] w-48 flex-shrink-0 flex flex-col justify-between py-6 px-5 relative shadow-lg">
        <div>
            <img alt="Emblem Logo" class="mb-10 h-16 w-auto mx-auto"
                src="https://storage.googleapis.com/a1aa/image/b8a2577d-6f49-43cc-628e-7137d15ec12a.jpg" />
            <nav class="flex flex-col space-y-3 text-white text-sm font-semibold">
                <a class="py-2 px-3 rounded-md hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 opacity-100' : 'opacity-70 hover:opacity-100' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a class="py-2 px-3 rounded-md hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.rekap') ? 'bg-blue-700 opacity-100' : 'opacity-70 hover:opacity-100' }}"
                    href="{{ route('admin.rekap') }}">
                    <i class="fas fa-calendar-alt mr-2"></i>Rekap Absensi
                </a>
                <a class="py-2 px-3 rounded-md hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.karyawan*') ? 'bg-blue-700 opacity-100' : 'opacity-70 hover:opacity-100' }}"
                    href="{{ route('admin.karyawan') }}">
                    <i class="fas fa-users mr-2"></i>Data Pengguna
                </a>
            </nav>
        </div>
        <div class="mt-auto">
            <a href="{{ route('admin.profil') }}" {{-- Tombol ini menuju halaman profil admin itu sendiri --}}
                class="block bg-gray-200 hover:bg-gray-300 rounded-lg px-3 py-2 text-center w-full text-gray-700">
                <p class="font-bold text-xs truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-xs font-normal">Admin</p>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
        <h1 class="text-gray-800 font-bold text-2xl mb-8">Profil Admin</h1>
        <div class="w-full max-w-3xl mx-auto rounded-lg shadow-xl overflow-hidden">
            <!-- Header Profil (Hijau) -->
            <section
                class="bg-gradient-to-r from-[#0D8B2F] to-[#0a6b24] flex flex-col items-center py-8 px-6 rounded-t-lg text-white">
                @php
                    $adminName = Auth::user()->name ?? 'Admin User';
                    $adminAvatar =
                        Auth::user()->avatar_url ??
                        'https://ui-avatars.com/api/?name=' .
                            urlencode($adminName) .
                            '&background=1f9d55&color=fff&size=96&font-size=0.33&bold=true&rounded=true';
                @endphp
                <img alt="Profile image of {{ $adminName }}"
                    class="w-24 h-24 rounded-full object-cover mb-4 border-4 border-white shadow-lg"
                    src="{{ $adminAvatar }}" />
                <h2 class="text-2xl font-semibold leading-tight">
                    {{ Auth::user()->name ?? 'Nama Admin' }}
                </h2>
                <p class="text-sm opacity-90 mt-1 leading-tight">
                    NIP: {{ Auth::user()->nip ?? '-' }}
                </p>
                <p class="text-sm opacity-90 mt-2 text-center leading-tight max-w-xs">
                    {{ Auth::user()->jabatan ?? 'Administrator Sistem' }}
                </p>
            </section>

            <!-- Detail Informasi (Putih) -->
            <section class="bg-white rounded-b-lg p-6 sm:p-8">
                {{-- Detail Informasi Pribadi Admin --}}
                <div class="bg-gray-50 rounded-lg p-6 text-sm text-gray-700 leading-relaxed relative shadow mb-6">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-600 rounded-l-md"></div>
                    <div class="pl-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Data Pribadi</h3>
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

                {{-- Informasi Instansi Admin (jika relevan dan ada di database) --}}
                <div class="bg-gray-50 rounded-lg p-6 text-sm text-gray-700 leading-relaxed relative shadow">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-emerald-600 rounded-l-md"></div>
                    <div class="pl-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Instansi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-4">
                            <div>
                                <strong class="block text-gray-500">Instansi:</strong>
                                <p class="text-gray-800">{{ Auth::user()->instansi ?? 'Nama Instansi (Contoh)' }}</p>
                            </div>
                            <div>
                                <strong class="block text-gray-500">Kantor/Unit Kerja:</strong>
                                <p class="text-gray-800">{{ Auth::user()->unit_kerja ?? 'Unit Kerja Admin (Contoh)' }}
                                </p>
                            </div>
                            {{-- Anda bisa menambahkan field lain seperti Eselon, Pangkat/Gol jika ada untuk admin --}}
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-center">
                    {{-- Tombol Edit Profil Admin (jika ada fungsionalitasnya) --}}
                    {{-- <a href="{{ route('admin.profil.edit') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-3 rounded-lg transition text-base">
                        <i class="fas fa-edit mr-2"></i>Edit Profil
                    </a> --}}
                </div>
            </section>
    </main>
    </div>

    <!-- Tombol Logout Melayang (jika tidak menggunakan dropdown di navbar) -->
    <form method="POST" action="{{ route('logout') }}" class="fixed bottom-8 right-8"
        onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
        @csrf
        <button type="submit" aria-label="Logout"
            class="bg-white border-2 border-red-600 text-red-600 rounded-full w-12 h-12 flex items-center justify-center shadow-lg hover:bg-red-600 hover:text-white transition focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
            <i class="fas fa-sign-out-alt fa-lg"></i>
        </button>
    </form>
</body>

</html>
