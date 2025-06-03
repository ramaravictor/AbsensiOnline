<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Dashboard Admin</title>
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
                src="https://storage.googleapis.com/a1aa/image/b91d97f7-43d5-4edf-1673-f1a9e16a31fa.jpg" />
            <nav class="flex flex-col space-y-3 text-white text-sm font-semibold">
                <a class="py-2 px-3 rounded-md hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 opacity-100' : 'opacity-70' }}"
                    href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                </a>
                <a class="py-2 px-3 rounded-md hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.rekap') ? 'bg-blue-700 opacity-100' : 'opacity-70' }}"
                    href="{{ route('admin.rekap') }}">
                    <i class="fas fa-calendar-alt mr-2"></i>Rekap Absensi
                </a>
                <a class="py-2 px-3 rounded-md hover:bg-blue-700 transition-colors {{ request()->routeIs('admin.karyawan*') ? 'bg-blue-700 opacity-100' : 'opacity-70' }}"
                    href="{{ route('admin.karyawan') }}">
                    <i class="fas fa-users mr-2"></i>Data Karyawan
                </a>
            </nav>
        </div>
        <div class="mt-auto">
            <a href="{{ route('admin.profil') }}"
                class="block bg-gray-200 hover:bg-gray-300 rounded-lg px-3 py-2 text-center w-full text-gray-700">
                <p class="font-bold text-xs truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                <p class="text-xs font-normal">Admin</p>
            </a>
        </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6 sm:p-8 overflow-y-auto">
        <h1 class="text-gray-800 font-bold text-2xl mb-8">
            Dashboard Admin
        </h1>
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Card Total Karyawan --}}
            <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
                <span class="text-4xl font-extrabold text-blue-600">
                    {{ $totalKaryawan ?? 0 }}
                </span>
                <div class="text-right">
                    <p class="font-bold text-gray-700 text-base sm:text-lg leading-tight">
                        Total Karyawan
                    </p>
                    <p class="text-xs text-gray-500">(Role Employee)</p>
                </div>
            </div>

            {{-- Card Persentase Tepat Waktu Bulan Ini --}}
            <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
                <span class="text-4xl font-extrabold text-green-600">
                    {{ $persentaseTepatWaktu ?? 0 }}%
                </span>
                <div class="text-right">
                    <p class="font-bold text-gray-700 text-base sm:text-lg leading-tight">
                        Tepat Waktu
                    </p>
                    <p class="text-xs text-gray-500">(Bulan Ini)</p>
                </div>
            </div>

            {{-- Card Tepat Waktu Hari Ini --}}
            <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
                <span class="text-4xl font-extrabold text-green-500">
                    {{ $tepatWaktuHariIni ?? 0 }}
                </span>
                <div class="text-right">
                    <p class="font-bold text-gray-700 text-base sm:text-lg leading-tight">
                        Tepat Waktu
                    </p>
                    <p class="text-xs text-gray-500">(Hari Ini)</p>
                </div>
            </div>

            {{-- Card Terlambat Hari Ini --}}
            <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
                <span class="text-4xl font-extrabold text-orange-500">
                    {{ $terlambatHariIni ?? 0 }}
                </span>
                <div class="text-right">
                    <p class="font-bold text-gray-700 text-base sm:text-lg leading-tight">
                        Terlambat
                    </p>
                    <p class="text-xs text-gray-500">(Hari Ini)</p>
                </div>
            </div>

            {{-- Card Presentasi/Hadir Hari Ini --}}
            <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
                <span class="text-4xl font-extrabold text-indigo-600">
                    {{ $hadirHariIni ?? 0 }}
                </span>
                <div class="text-right">
                    <p class="font-bold text-gray-700 text-base sm:text-lg leading-tight">
                        Hadir
                    </p>
                    <p class="text-xs text-gray-500">(Hari Ini)</p>
                </div>
            </div>

            {{-- Card Izin/Sakit Bulan Ini --}}
            <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
                <span class="text-4xl font-extrabold text-yellow-500">
                    {{ $tidakMasukDenganKeteranganBulanIni ?? 0 }}
                </span>
                <div class="text-right">
                    <p class="font-bold text-gray-700 text-base sm:text-lg leading-tight">
                        Izin/Sakit
                    </p>
                    <p class="text-xs text-gray-500">(Bulan Ini)</p>
                </div>
            </div>
        </section>

        {{-- Anda bisa menambahkan chart atau tabel ringkasan lainnya di sini --}}

    </main>
</body>

</html>
