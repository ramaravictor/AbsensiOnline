<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Riwayat Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

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
        }

        .pagination span[aria-current="page"] span {
            background-color: #0a5eb7;
            color: white;
            border: 1px solid #0a5eb7;
        }

        .pagination a {
            background-color: white;
            color: #0a5eb7;
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
    </style>
</head>

<body class="bg-gray-100 font-sans">
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
            <a href="{{ route('user.profil') }}" class="hover:underline">Profil</a>
            <a href="{{ route('user.history') }}" class="border-b-2 border-white pb-[2px]">Riwayat</a>
            <div class="relative">
                <button id="userBtnHistory" aria-label="User menu" class="focus:outline-none">
                    <i class="fas fa-user-circle text-xl sm:text-[24px]"></i>
                </button>
                <div id="userDropdownHistory"
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

    <main class="flex justify-center mt-6 sm:mt-10 px-4 pb-10">
        <section class="w-full max-w-[800px] bg-white border border-gray-300 rounded-lg shadow-md p-4 sm:p-6 relative"
            style="min-height: 500px;">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6 text-center">Riwayat Absensi</h1>

            <form method="GET" action="{{ route('user.history') }}"
                class="flex flex-col sm:flex-row items-center sm:space-x-3 mb-6 space-y-3 sm:space-y-0">
                <div class="w-full sm:w-auto">
                    <label for="month_filter_history" class="sr-only">Bulan</label>
                    <select name="month" id="month_filter_history"
                        class="border border-gray-400 rounded text-xs sm:text-sm font-semibold px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
                        @if (isset($monthsForFilter))
                            @foreach ($monthsForFilter as $monthNumber => $monthName)
                                <option value="{{ $monthNumber }}"
                                    {{ $selectedMonth == $monthNumber ? 'selected' : '' }}>
                                    {{ $monthName }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="w-full sm:w-auto">
                    <label for="year_filter_history" class="sr-only">Tahun</label>
                    <select name="year" id="year_filter_history"
                        class="border border-gray-400 rounded text-xs sm:text-sm font-semibold px-3 py-2 w-full focus:ring-blue-500 focus:border-blue-500">
                        @if (isset($yearsForFilter))
                            @foreach ($yearsForFilter as $year)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <button type="submit"
                    class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm">
                    Filter
                </button>
            </form>

            <div class="space-y-4">
                @forelse ($history as $item)
                    <article
                        class="bg-gray-100 rounded-md p-3 sm:p-4 relative flex justify-between items-start border-l-4 {{ $item->borderColorAttribute }}"
                        style="box-shadow: 0 1px 2px rgb(0 0 0 / 0.1);">
                        <div class="flex flex-col max-w-[65%] sm:max-w-[70%]">
                            <span class="text-[10px] sm:text-[11px] font-semibold leading-tight text-gray-600 mb-1">
                                {{ $item->formattedDate }}
                            </span>
                            <span
                                class="text-xs sm:text-[12px] font-extrabold leading-tight {{ $item->statusTextColorAttribute }} mb-1">
                                {{ $item->statusDisplay }}
                            </span>
                            @if ($item->check_in)
                                <span
                                    class="text-[8px] sm:text-[9px] font-bold leading-tight {{ $item->statusTextColorAttribute }}">
                                    Waktu Hadir : {{ $item->formattedCheckIn }}
                                </span>
                            @endif
                            @if ($item->status === 'hadir' && $item->keterangan === 'Terlambat')
                                <span class="text-[8px] sm:text-[9px] font-bold leading-tight text-red-600">
                                    Terlambat : {{ $item->durasiTerlambat }}
                                </span>
                            @endif
                            @if ($item->status === 'sakit' || $item->status === 'izin')
                                <span
                                    class="text-[8px] sm:text-[9px] font-normal leading-tight text-gray-500 mt-1 italic">
                                    Keterangan: {{ $item->notes ?: '-' }}
                                </span>
                            @endif
                        </div>
                        <div
                            class="flex flex-col text-[8px] sm:text-[9px] font-semibold leading-tight text-gray-600 text-right max-w-[35%] sm:max-w-[30%]">
                            @if ($item->check_out)
                                <span>Waktu Pulang : {{ $item->formattedCheckOut }}</span>
                                @if ($item->status === 'hadir' && $item->durasiCepatPulang !== '00:00:00' && $item->durasiCepatPulang !== null)
                                    <span class="text-orange-500">Cepat Pulang : {{ $item->durasiCepatPulang }}</span>
                                @endif
                            @else
                                @if ($item->status === 'hadir')
                                    <span>Belum Absen Pulang</span>
                                @endif
                            @endif
                        </div>
                        {{-- Garis dekoratif di kanan tidak diperlukan jika sudah ada border kiri --}}
                    </article>
                @empty
                    <div class="text-center text-gray-500 py-10">
                        <p class="text-lg">Tidak ada riwayat absensi untuk periode ini.</p>
                    </div>
                @endforelse
            </div>

            @if (isset($history) && $history->hasPages())
                <div class="mt-6 pagination">
                    {{ $history->appends(request()->except('page'))->links() }}
                </div>
            @endif
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userBtnHistory = document.getElementById('userBtnHistory');
            const userDropdownHistory = document.getElementById('userDropdownHistory');

            if (userBtnHistory && userDropdownHistory) {
                userBtnHistory.addEventListener('click', (e) => {
                    e.stopPropagation(); // Mencegah event sampai ke document
                    userDropdownHistory.classList.toggle('hidden');
                });

                // Menutup dropdown jika diklik di luar area dropdown atau tombol
                document.addEventListener('click', (e) => {
                    if (!userDropdownHistory.classList.contains('hidden') && !userBtnHistory.contains(e
                            .target) && !userDropdownHistory.contains(e.target)) {
                        userDropdownHistory.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
