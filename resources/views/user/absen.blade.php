<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Absen Berhasil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <script>
        function goToHome() {
            window.location.href = "/user/home";
        }

        // Format waktu dalam HH:mm:ss
        function formatTime(timeStr) {
            if (!timeStr) return "--:--:--";
            return timeStr;
        }

        // Format tanggal dalam format yang diterima (misal "01 Januari 2024")
        function formatDate(dateStr) {
            if (!dateStr) return "--/--/----";
            return dateStr;
        }

        // Fungsi untuk mengkapitalisasi huruf pertama
        function capitalizeFirstLetter(str) {
            if (!str) return "";
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        // Muat data absensi dari localStorage dan update UI
        function loadAttendanceData() {
            const jenisAbsen = localStorage.getItem('processed_jenis_absen') || "";
            const statusDetail = localStorage.getItem('processed_status_detail') || "";
            const waktu = localStorage.getItem('processed_time') || "";
            const tanggal = localStorage.getItem('processed_date') || "";

            const absenStatusEl = document.getElementById('absenStatus');
            const absenTimeEl = document.getElementById('absenTime');
            const absenDateEl = document.getElementById('absenDate');
            const absenDescEl = document.getElementById('absenDesc');

            if (jenisAbsen && statusDetail) {
                absenStatusEl.textContent = `Absen ${capitalizeFirstLetter(jenisAbsen)} (${statusDetail})`;
            } else {
                absenStatusEl.textContent = "Absen Sukses";
            }

            absenTimeEl.textContent = formatTime(waktu);
            absenDateEl.textContent = formatDate(tanggal);

            if (statusDetail && tanggal) {
                absenDescEl.textContent = `Berhasil absen dengan status "${statusDetail}" pada tanggal ${tanggal}`;
            } else if (tanggal) {
                absenDescEl.textContent = `Berhasil absen pada tanggal ${tanggal}`;
            } else {
                absenDescEl.textContent = "";
            }
        }

        window.addEventListener("DOMContentLoaded", () => {
            loadAttendanceData();
        });
    </script>
</head>

<body class="bg-white font-sans min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-blue-700 flex items-center justify-between px-6 py-3 shadow-md relative">
        <div>
            <!-- Anda bisa render data user dinamis dari backend jika menggunakan blade -->
            <a href="/user/profil" class="text-white text-[17px] font-normal leading-[20px] underline">
                Prof. Munir, M.Kom
            </a>
            <div class="text-white text-[11px] font-normal leading-[13px] mt-[2px]">
                19740516 189705 1 001
            </div>
        </div>
        <div class="flex items-center space-x-8 text-white text-[14px] font-semibold leading-[16px] relative">
            <a href="/user/home" class="hover:underline">Home</a>
            <a href="/user/profil" class="hover:underline">Profile</a>
            <a href="/user/history" class="hover:underline">Riwayat</a>
            <div class="relative">
                <button id="userBtn" aria-label="User menu" class="focus:outline-none">
                    <i class="fas fa-user-circle text-[24px]"></i>
                </button>
                <!-- Dropdown panel -->
                <div id="userDropdown"
                    class="hidden absolute right-0 top-full mt-1 w-48 bg-gray-200 rounded shadow-lg text-gray-800 z-50">
                    <div class="px-4 py-3 border-b border-gray-300">
                        <p class="font-semibold text-sm">Prof. Munir, M.Kom</p>
                        <p class="text-xs truncate">@username.absen.co</p>
                    </div>
                    <button onclick="window.location.href='/'"
                        class="w-full flex items-center justify-center gap-2 text-red-600 text-sm font-semibold py-2 hover:bg-red-100"
                        type="button">
                        <i class="fas fa-power-off"></i> LOGOUT
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-xl p-12 text-center flex flex-col items-center"
            role="main">
            <div class="mb-8">
                <img src="{{ asset('images/berhasil.png') }}" alt="Berhasil" class="mx-auto" />
            </div>
            <h1 class="text-4xl font-semibold text-gray-800 mb-4" id="absenStatus">
                Absen Sukses
            </h1>
            <p class="text-gray-600 font-mono text-2xl mb-2" id="absenTime">08:00:00</p>
            <p class="text-green-500 text-lg mb-6" id="absenDate">
                Berhasil absen pada tanggal 01-01-2024
            </p>
            <p class="text-gray-700 italic mb-10" id="absenDesc"></p>
            <button onclick="goToHome()"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-10 py-4 rounded transition text-lg"
                type="button" aria-label="Kembali ke halaman utama">
                Kembali ke Halaman Utama
            </button>
        </div>
    </main>

    <script>
        const userBtn = document.getElementById('userBtn');
        const userDropdown = document.getElementById('userDropdown');

        userBtn.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });

        // Close dropdown if clicked outside
        document.addEventListener('click', (e) => {
            if (!userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
