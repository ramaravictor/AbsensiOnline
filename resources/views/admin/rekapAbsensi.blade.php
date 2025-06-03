<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Rekap Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom scrollbar for sidebar */
        aside::-webkit-scrollbar {
            width: 6px;
        }

        aside::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }

        /* Pagination Styles */
        .pagination nav {
            display: flex;
            justify-content: flex-end;
            padding-top: 1rem;
        }

        .pagination span[aria-current="page"] span,
        .pagination a {
            padding: 0.5rem 0.75rem;
            margin-left: 0.25rem;
            border-radius: 0.25rem;
            font-size: 0.75rem;
            /* text-xs */
        }

        .pagination span[aria-current="page"] span {
            background-color: #0a4aa0;
            color: white;
            border: 1px solid #0a4aa0;
        }

        .pagination a {
            background-color: white;
            color: #0a4aa0;
            border: 1px solid #ddd;
        }

        .pagination a:hover {
            background-color: #f0f0f0;
        }

        .pagination span[aria-disabled="true"] span {
            color: #ccc;
            border: 1px solid #ddd;
            background-color: white;
        }

        .table-fixed th,
        .table-fixed td {
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-all;
        }
    </style>
</head>

<body class="bg-gray-200">
    <div class="flex min-h-screen">
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
                    <p class="font-bold text-xs truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs font-normal">Admin</p>
                </a>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 p-6 overflow-y-auto">
            <h1 class="text-xl font-bold text-gray-800 mb-6">
                Rekap Absensi Karyawan
            </h1>
            <div class="bg-white rounded-md shadow-md p-4">
                <form method="GET" action="{{ route('admin.rekap') }}">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center bg-[#0a8ad0] rounded-t-md px-4 py-2 mb-3">
                        <div class="text-white text-sm font-semibold flex items-center space-x-2 mb-2 sm:mb-0">
                            <i class="fas fa-calendar-alt"></i>
                            <span>Pilih Periode</span>
                        </div>
                        <div
                            class="flex flex-col sm:flex-row items-center space-y-2 sm:space-y-0 sm:space-x-2 w-full sm:w-auto">
                            <select name="month" aria-label="Pilih Bulan"
                                class="text-sm rounded border border-gray-300 px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#0a8ad0] w-full sm:w-auto">
                                @foreach ($monthsForFilter as $monthNumber => $monthName)
                                    <option value="{{ $monthNumber }}"
                                        {{ $selectedMonth == $monthNumber ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="year" aria-label="Pilih Tahun"
                                class="text-sm rounded border border-gray-300 px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#0a8ad0] w-full sm:w-auto">
                                @foreach ($yearsForFilter as $year)
                                    <option value="{{ $year }}"
                                        {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-4 rounded text-sm w-full sm:w-auto">
                                Filter
                            </button>
                            <button type="button" onclick="window.print()"
                                class="bg-green-500 hover:bg-green-600 text-white font-semibold py-1 px-4 rounded text-sm w-full sm:w-auto flex items-center justify-center">
                                <i class="fas fa-print mr-1"></i> Cetak
                            </button>
                        </div>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 text-xs table-fixed">
                        <thead class="bg-gray-200 text-center text-gray-700 sticky top-0 z-10">
                            <tr>
                                <th class="border border-gray-300 px-2 py-2 w-10">No</th>
                                <th class="border border-gray-300 px-2 py-2 w-24">Tanggal</th>
                                <th class="border border-gray-300 px-2 py-2 w-32">NIP</th>
                                <th class="border border-gray-300 px-2 py-2 w-40">Nama Karyawan</th>
                                <th class="border border-gray-300 px-2 py-2 w-20">Check In</th>
                                <th class="border border-gray-300 px-2 py-2 w-20">Check Out</th>
                                <th class="border border-gray-300 px-2 py-2 w-24">Status</th>
                                <th class="border border-gray-300 px-2 py-2 w-28">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($rekapAttendances as $index => $item)
                                <tr class="text-center {{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                                    <td class="border border-gray-300 px-2 py-1.5">
                                        {{ $rekapAttendances->firstItem() + $index }}</td>
                                    <td class="border border-gray-300 px-2 py-1.5">{{ $item->formattedDate }}</td>
                                    <td class="border border-gray-300 px-2 py-1.5">{{ $item->user->nip ?? '-' }}</td>
                                    <td class="border border-gray-300 px-2 py-1.5 text-left">
                                        {{ $item->user->name ?? 'User Dihapus' }}</td>
                                    <td class="border border-gray-300 px-2 py-1.5">{{ $item->formattedCheckIn ?: '-' }}
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1.5">
                                        {{ $item->formattedCheckOut ?: '-' }}</td>
                                    <td class="border border-gray-300 px-2 py-1.5">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                        @if ($item->status === 'hadir') {{ $item->keterangan === 'Terlambat' ? 'bg-orange-100 text-orange-800' : 'bg-green-100 text-green-800' }}
                                        @elseif($item->status === 'sakit') bg-blue-100 text-blue-800
                                        @elseif($item->status === 'izin') bg-yellow-100 text-yellow-800
                                        @elseif($item->status === 'alpha') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-300 px-2 py-1.5">
                                        {{ $item->keterangan ?: 'Tepat Waktu' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8"
                                        class="text-center border border-gray-300 px-2 py-10 text-gray-500">
                                        Tidak ada data rekap absensi untuk periode ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if (isset($rekapAttendances) && $rekapAttendances->hasPages())
                    <div class="mt-4 pagination">
                        {{ $rekapAttendances->links() }}
                    </div>
                @endif
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Script untuk dropdown user di navbar jika ada
            // (Anda bisa menyalinnya dari halaman user.history.blade.php jika diperlukan)
        });
    </script>
</body>

</html>
