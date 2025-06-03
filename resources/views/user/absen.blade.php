<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Status Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
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
            <a href="{{ route('user.history') }}" class="hover:underline">Riwayat</a>
            <div class="relative">
                <button id="userBtn" aria-label="User menu" class="focus:outline-none">
                    <i class="fas fa-user-circle text-xl sm:text-[24px]"></i>
                </button>
                <div id="userDropdown"
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

    <main class="flex-grow flex items-center justify-center p-6 mt-10">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-8 sm:p-12 text-center flex flex-col items-center"
            role="main">
            <div class="mb-6">
                <i id="statusIcon" class="fas fa-check-circle text-green-500 text-6xl sm:text-7xl"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-semibold text-gray-800 mb-2" id="absenPageTitle">
                Absensi Berhasil!
            </h1>
            {{-- Elemen untuk menampilkan status utama (misal: Hadir, Sakit, Izin, Pulang) --}}
            <p class="text-gray-700 font-semibold text-xl sm:text-2xl mb-1" id="absenPageStatusDisplay">
                {{-- Status utama akan diisi JavaScript --}}
            </p>
            {{-- Elemen untuk menampilkan keterangan tambahan (misal: Terlambat) --}}
            <p class="text-orange-500 font-medium text-lg sm:text-xl mb-3" id="absenPageKeterangan">
                {{-- Keterangan akan diisi JavaScript jika ada --}}
            </p>
            <p class="text-gray-600 font-mono text-lg sm:text-xl mb-4">
                Pukul: <span id="absenPageTime" class="font-semibold">--:--:--</span>
            </p>
            <p class="text-gray-500 text-base sm:text-lg mb-8">
                Pada tanggal: <span id="absenPageDate" class="font-semibold">-- -- ----</span>
            </p>
            <button onclick="window.location.href='{{ route('user.home') }}'"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-8 py-3 rounded-lg transition text-base sm:text-lg"
                type="button" aria-label="Kembali ke halaman utama">
                Kembali ke Halaman Utama
            </button>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusDisplay = localStorage.getItem('attendance_status');
            const timeDisplay = localStorage.getItem('attendance_time');
            const dateDisplay = localStorage.getItem('attendance_date');
            const keteranganDisplay = localStorage.getItem(
                'attendance_keterangan'); // Bisa jadi string kosong atau null

            const absenPageTitleEl = document.getElementById('absenPageTitle');
            const absenPageStatusDisplayEl = document.getElementById(
                'absenPageStatusDisplay'); // Elemen baru untuk status utama
            const absenPageKeteranganEl = document.getElementById(
                'absenPageKeterangan'); // Elemen baru untuk keterangan
            const absenPageTimeEl = document.getElementById('absenPageTime');
            const absenPageDateEl = document.getElementById('absenPageDate');
            const statusIconEl = document.getElementById('statusIcon');

            if (statusDisplay && timeDisplay && dateDisplay) {
                if (absenPageStatusDisplayEl) absenPageStatusDisplayEl.textContent = statusDisplay;
                if (absenPageTimeEl) absenPageTimeEl.textContent = timeDisplay;
                if (absenPageDateEl) absenPageDateEl.textContent = dateDisplay;

                // Tampilkan keterangan hanya jika ada dan tidak string kosong
                if (keteranganDisplay && keteranganDisplay.trim() !== '' && keteranganDisplay !== 'null') {
                    if (absenPageKeteranganEl) absenPageKeteranganEl.textContent = `(${keteranganDisplay})`;
                } else {
                    if (absenPageKeteranganEl) absenPageKeteranganEl.textContent =
                        ''; // Kosongkan jika tidak ada keterangan
                }

                // Sesuaikan judul dan ikon berdasarkan apakah ada kata "gagal" atau "error" di status utama
                // Atau berdasarkan apakah ada keterangan "Terlambat" untuk kasus sukses tapi terlambat
                if (statusDisplay.toLowerCase().includes('gagal') || statusDisplay.toLowerCase().includes(
                        'error')) {
                    if (absenPageTitleEl) absenPageTitleEl.textContent = "Absensi Gagal";
                    if (statusIconEl) {
                        statusIconEl.classList.remove('fa-check-circle', 'text-green-500');
                        statusIconEl.classList.add('fa-times-circle', 'text-red-500');
                    }
                } else {
                    if (absenPageTitleEl) absenPageTitleEl.textContent = "Absensi Berhasil!";
                    if (statusIconEl) {
                        statusIconEl.classList.remove('fa-times-circle', 'text-red-500');
                        statusIconEl.classList.add('fa-check-circle', 'text-green-500');
                    }
                }

            } else {
                if (absenPageTitleEl) absenPageTitleEl.textContent = "Status Absensi Tidak Diketahui";
                if (absenPageStatusDisplayEl) absenPageStatusDisplayEl.textContent =
                    "Tidak ada detail absensi yang diterima.";
                if (absenPageKeteranganEl) absenPageKeteranganEl.textContent = '';
                if (statusIconEl) {
                    statusIconEl.classList.remove('fa-check-circle', 'text-green-500');
                    statusIconEl.classList.add('fa-question-circle', 'text-gray-500');
                }
            }

            localStorage.removeItem('attendance_status');
            localStorage.removeItem('attendance_time');
            localStorage.removeItem('attendance_date');
            localStorage.removeItem('attendance_keterangan');

            const userBtn = document.getElementById('userBtn');
            const userDropdown = document.getElementById('userDropdown');
            if (userBtn && userDropdown) {
                userBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', (e) => {
                    if (!userDropdown.classList.contains('hidden') && !userBtn.contains(e.target) && !
                        userDropdown.contains(e.target)) {
                        userDropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>

</html>
