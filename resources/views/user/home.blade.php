<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Home - Absensi Online</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    {{-- Leaflet CSS & JS untuk Peta --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        #welcomePopup,
        #absenModal {
            z-index: 1050;
        }

        .pagination nav {
            display: flex;
            justify-content: flex-end;
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

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
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
                <a href="{{ route('user.home') }}" class="border-b-2 border-white pb-[2px]">Home</a>
                <a href="{{ route('user.profil') }}" class="hover:underline">Profil</a>
                <a href="{{ route('user.history') }}" class="hover:underline">Riwayat</a>
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

        <main class="flex-grow flex flex-col justify-center items-center p-4 sm:p-6">
            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 w-full max-w-5xl"
                    role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 w-full max-w-5xl" role="alert">
                    <p class="font-bold">Error</p>
                    <p>{{ session('error') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 w-full max-w-5xl" role="alert">
                    <p class="font-bold">Terjadi Kesalahan Validasi:</p>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-lg w-full max-w-5xl p-6 sm:p-10" style="min-height: 550px;">
                <div class="flex flex-col sm:flex-row items-center sm:space-x-6 mb-8">
                    @php
                        $name = Auth::user()->name ?? 'User';
                        $avatarUrl =
                            'https://ui-avatars.com/api/?name=' .
                            urlencode($name) .
                            '&background=random&size=80&rounded=true';
                    @endphp

                    <img alt="Avatar of {{ $name }}" class="w-20 h-20 rounded-full mb-4 sm:mb-0" height="80"
                        width="80" src="{{ Auth::user()->avatar_url ?? $avatarUrl }}" />
                    <div>
                        <div class="text-lg font-semibold text-gray-700 text-center sm:text-left">
                            {{ Auth::user()->name ?? 'Nama Pengguna' }}</div>
                        <div class="text-sm text-gray-400 text-center sm:text-left">
                            @if (isset($loginTime) && $loginTime)
                                Login Absen: {{ $loginTime }}
                            @elseif (Auth::user()->last_login_at)
                                Login Sistem: {{ Auth::user()->last_login_at->format('H:i, d M Y') }}
                            @else
                                Status: Aktif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow">
                    <form method="GET" action="{{ route('user.home') }}"
                        class="flex flex-col sm:flex-row sm:items-end sm:space-x-3 space-y-3 sm:space-y-0">
                        <div>
                            <label for="month_filter" class="block text-sm font-medium text-gray-700">Bulan:</label>
                            <select name="month" id="month_filter"
                                class="mt-1 block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                                @foreach ($monthsForFilter as $monthNumber => $monthName)
                                    <option value="{{ $monthNumber }}"
                                        {{ $selectedMonth == $monthNumber ? 'selected' : '' }}>
                                        {{ $monthName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="year_filter" class="block text-sm font-medium text-gray-700">Tahun:</label>
                            <select name="year" id="year_filter"
                                class="mt-1 block w-full sm:w-auto pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 rounded-md shadow-sm">
                                @foreach ($yearsForFilter as $year)
                                    <option value="{{ $year }}"
                                        {{ $selectedYear == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md shadow-sm">
                            Filter
                        </button>
                    </form>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 md:gap-8 text-center mb-8">
                    <div class="bg-gray-50 rounded-lg shadow-md p-4 md:p-6">
                        <div class="text-green-600 font-bold text-2xl md:text-3xl">{{ $rekapHadir ?? 0 }}</div>
                        <div class="text-sm text-gray-500 mt-1">
                            Hadir
                            @if (isset($rekapTerlambat) && $rekapTerlambat > 0)
                                <span class="block text-xs text-orange-500">(Terlambat: {{ $rekapTerlambat }})</span>
                            @endif
                        </div>
                    </div>
                    <div class="bg-gray-50 rounded-lg shadow-md p-4 md:p-6">
                        <div class="text-blue-600 font-bold text-2xl md:text-3xl">{{ $rekapSakit ?? 0 }}</div>
                        <div class="text-sm text-gray-500 mt-1">Sakit</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg shadow-md p-4 md:p-6">
                        <div class="text-yellow-500 font-bold text-2xl md:text-3xl">{{ $rekapIzin ?? 0 }}</div>
                        <div class="text-sm text-gray-500 mt-1">Izin</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg shadow-md p-4 md:p-6">
                        <div class="text-red-600 font-bold text-2xl md:text-3xl">{{ $rekapAlpha ?? 0 }}</div>
                        <div class="text-sm text-gray-500 mt-1">Alpha</div>
                    </div>
                </div>

                <div id="mapRealtime" class="mb-8 rounded overflow-hidden border border-gray-300 relative"
                    style="height: 300px; sm:height: 350px; width: 100%;">
                </div>

                <div class="text-center mb-8">
                    <div class="font-mono font-semibold text-2xl" id="currentTime" aria-live="polite"
                        aria-atomic="true">
                        00:00:00
                    </div>
                    <div class="font-sans text-sm text-gray-600 mt-1" id="currentDate">
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-center sm:justify-between gap-4 max-w-md mx-auto">
                    <button
                        class="bg-orange-600 text-white text-lg font-semibold px-8 py-3 rounded hover:bg-orange-700 transition w-full sm:w-auto"
                        onclick="openAbsenModal()" type="button">
                        ABSEN
                    </button>
                    <button
                        class="bg-orange-600 text-white text-lg font-semibold px-8 py-3 rounded hover:bg-orange-700 transition w-full sm:w-auto"
                        type="button" onclick="window.location.href='{{ route('user.history') }}'">
                        RIWAYAT
                    </button>
                </div>
            </div>
        </main>
    </div>

    <div id="welcomePopup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden"
        role="dialog" aria-modal="true" aria-labelledby="welcomeTitle" style="z-index: 1050;">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative mx-4">
            <button type="button" aria-label="Close welcome popup"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none"
                onclick="closeWelcomePopup()">
                <i class="fas fa-times fa-lg"></i>
            </button>
            <h2 class="text-lg font-semibold mb-4 text-center" id="welcomeTitle">Selamat Datang!</h2>
            <div class="flex items-center space-x-4 mb-4">
                @php
                    $name = Auth::user()->name ?? 'User';
                    $avatarUrl =
                        'https://ui-avatars.com/api/?name=' .
                        urlencode($name) .
                        '&background=random&size=80&rounded=true';
                @endphp

                <img alt="Avatar of {{ $name }}" class="w-20 h-20 rounded-full mb-4 sm:mb-0" height="80"
                    width="80" src="{{ Auth::user()->avatar_url ?? $avatarUrl }}" />

                <div class="text-xs leading-tight">
                    <p class="font-bold text-[13px]">{{ Auth::user()->name ?? 'Nama Pengguna' }}</p>
                    <p class="text-[10px]">NIP: {{ Auth::user()->nip ?? 'NIP Pengguna' }}</p>
                    <p class="text-[10px]">{{ Auth::user()->jabatan ?? 'Jabatan Belum Diatur' }}</p>
                </div>
            </div>
            <hr class="border-gray-400" />
            <p class="text-[10px] font-bold text-center mt-4">
                Dinas Lingkungan Hidup Kabupaten<br />Bantul
            </p>
        </div>
    </div>

    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden" id="absenModal"
        role="dialog" aria-modal="true" aria-labelledby="absenModalTitle" style="z-index: 1050;">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-sm p-6 relative mx-4">
            <button type="button" aria-label="Close absen modal"
                class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 focus:outline-none"
                onclick="closeAbsenModalWithoutRedirect()">
                <i class="fas fa-times fa-lg"></i>
            </button>
            <h2 class="text-lg font-semibold mb-4" id="absenModalTitle">Pilih Jenis Absen</h2>
            <form id="formAbsensi">
                @csrf
                <select aria-label="Pilih absen hadir atau pulang"
                    class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    id="absenType" name="jenis_absen" onchange="onAbsenTypeChange()">
                    <option value="" selected disabled>-- Pilih Absen --</option>
                    <option value="hadir">Absen Hadir</option>
                    <option value="pulang">Absen Pulang</option>
                </select>

                <input type="hidden" name="selected_option" id="selectedOptionInput">
                <input type="hidden" name="latitude" id="latitudeInput">
                <input type="hidden" name="longitude" id="longitudeInput">
                <input type="hidden" name="accuracy" id="accuracyInput">

                <div class="space-y-3 hidden" id="absenHadirOptions" aria-label="Pilihan absen hadir">
                    <button aria-pressed="false" data-value="Hadir"
                        class="w-full bg-gray-200 text-gray-700 rounded-lg px-3 py-3 font-semibold text-center shadow hover:bg-green-600 hover:text-white hover:shadow-lg hover:scale-105 transform transition-all"
                        onclick="selectOption(this)" type="button">Hadir</button>
                    <button aria-pressed="false" data-value="Sakit"
                        class="w-full bg-gray-200 text-gray-700 rounded-lg px-3 py-3 font-semibold text-center shadow hover:bg-blue-600 hover:text-white hover:shadow-lg hover:scale-105 transform transition-all"
                        onclick="selectOption(this)" type="button">Sakit</button>
                    <button aria-pressed="false" data-value="Izin"
                        class="w-full bg-gray-200 text-gray-700 rounded-lg px-3 py-3 font-semibold text-center shadow hover:bg-yellow-500 hover:text-white hover:shadow-lg hover:scale-105 transform transition-all"
                        onclick="selectOption(this)" type="button">Izin</button>
                </div>
                <div class="space-y-3 hidden" id="absenPulangOptions" aria-label="Pilihan absen pulang">
                    <button aria-pressed="false" data-value="Pulang Tepat Waktu" {{-- Nilai data-value disesuaikan agar unik jika perlu --}}
                        class="w-full bg-gray-200 text-gray-700 rounded-lg px-3 py-3 font-semibold text-center shadow hover:bg-green-600 hover:text-white hover:shadow-lg hover:scale-105 transform transition-all"
                        onclick="selectOption(this)" type="button">Pulang Tepat Waktu</button>
                </div>
                <div class="flex justify-between mt-6 hidden" id="actionButtons">
                    <button
                        class="bg-gray-300 text-gray-700 font-semibold px-4 py-2 rounded hover:bg-gray-400 transition"
                        onclick="resetModal(); closeAbsenModalWithoutRedirect();" type="button">
                        Batal
                    </button>
                    <button id="continueBtn"
                        class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition"
                        type="button">
                        Lanjut
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let mapInstance;
        let currentLocationMarker;
        let accuracyCircle;

        function closeWelcomePopup() {
            const el = document.getElementById("welcomePopup");
            if (el) el.classList.add("hidden");
        }

        function openAbsenModal() {
            const el = document.getElementById("absenModal");
            if (el) el.classList.remove("hidden");
            resetModal();
        }

        function closeAbsenModalWithoutRedirect() {
            const el = document.getElementById("absenModal");
            if (el) el.classList.add("hidden");
        }

        function resetModal() {
            const absenTypeEl = document.getElementById("absenType");
            if (absenTypeEl) absenTypeEl.value = "";
            const hadirOptionsEl = document.getElementById("absenHadirOptions");
            if (hadirOptionsEl) hadirOptionsEl.classList.add("hidden");
            const pulangOptionsEl = document.getElementById("absenPulangOptions");
            if (pulangOptionsEl) pulangOptionsEl.classList.add("hidden");
            clearSelection();
            const actionButtonsEl = document.getElementById("actionButtons");
            if (actionButtonsEl) actionButtonsEl.classList.add("hidden");
        }

        function clearSelection() {
            const buttons = document.querySelectorAll("#absenHadirOptions button, #absenPulangOptions button");
            buttons.forEach((btn) => {
                btn.classList.remove("bg-green-600", "text-white", "shadow-lg", "scale-105", "bg-blue-600",
                    "bg-yellow-500");
                btn.classList.add("bg-gray-200", "text-gray-700", "shadow-none", "scale-100");
                btn.setAttribute("aria-pressed", "false");
            });
            const selectedOptionInput = document.getElementById('selectedOptionInput');
            if (selectedOptionInput) selectedOptionInput.value = '';
        }

        function onAbsenTypeChange() {
            clearSelection();
            const actionButtonsEl = document.getElementById("actionButtons");
            if (actionButtonsEl) actionButtonsEl.classList.add("hidden");
            const val = document.getElementById("absenType").value;
            const hadirOptionsEl = document.getElementById("absenHadirOptions");
            const pulangOptionsEl = document.getElementById("absenPulangOptions");
            if (val === "hadir") {
                if (hadirOptionsEl) hadirOptionsEl.classList.remove("hidden");
                if (pulangOptionsEl) pulangOptionsEl.classList.add("hidden");
            } else if (val === "pulang") {
                if (pulangOptionsEl) pulangOptionsEl.classList.remove("hidden");
                if (hadirOptionsEl) hadirOptionsEl.classList.add("hidden");
            } else {
                if (hadirOptionsEl) hadirOptionsEl.classList.add("hidden");
                if (pulangOptionsEl) pulangOptionsEl.classList.add("hidden");
            }
        }

        function selectOption(button) {
            const parent = button.parentElement;
            if (!parent) return;
            const buttons = parent.querySelectorAll("button");
            buttons.forEach((btn) => {
                btn.classList.remove("bg-green-600", "bg-blue-600", "bg-yellow-500", "text-white", "shadow-lg",
                    "scale-105");
                btn.classList.add("bg-gray-200", "text-gray-700", "shadow-none", "scale-100");
                btn.setAttribute("aria-pressed", "false");
            });
            button.classList.remove("bg-gray-200", "text-gray-700", "shadow-none", "scale-100");
            const buttonValue = button.dataset.value;
            if (buttonValue === "Hadir" || buttonValue === "Pulang Tepat Waktu") { // Sesuaikan dengan data-value
                button.classList.add("bg-green-600", "text-white");
            } else if (buttonValue === "Sakit") {
                button.classList.add("bg-blue-600", "text-white");
            } else if (buttonValue === "Izin") {
                button.classList.add("bg-yellow-500", "text-white");
            }
            button.classList.add("shadow-lg", "scale-105");
            button.setAttribute("aria-pressed", "true");
            const actionButtonsEl = document.getElementById("actionButtons");
            if (actionButtonsEl) actionButtonsEl.classList.remove("hidden");
            const selectedOptionInput = document.getElementById('selectedOptionInput');
            if (selectedOptionInput) selectedOptionInput.value = button.dataset.value || button.textContent.trim();
        }

        function updateTime() {
            const now = new Date();
            const hours = now.getHours().toString().padStart(2, "0");
            const minutes = now.getMinutes().toString().padStart(2, "0");
            const seconds = now.getSeconds().toString().padStart(2, "0");
            const timeString = `${hours}:${minutes}:${seconds}`;
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September',
                'Oktober', 'November', 'Desember'
            ];
            const dayName = days[now.getDay()];
            const dayOfMonth = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            const dateString = `${dayName}, ${dayOfMonth} ${monthName} ${year}`;
            const timeElement = document.getElementById("currentTime");
            if (timeElement) timeElement.textContent = timeString;
            const dateElement = document.getElementById("currentDate");
            if (dateElement) dateElement.textContent = dateString;
        }

        function initializeLeafletMap() {
            const mapElement = document.getElementById('mapRealtime');
            if (mapElement && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPositionOnMap, showErrorInitializingMap, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else if (mapElement) {
                mapElement.innerHTML =
                    "<p class='text-center text-red-500 p-4'>Geolocation tidak didukung oleh browser Anda.</p>";
            }
        }

        function showPositionOnMap(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            const acc = position.coords.accuracy;
            const mapElement = document.getElementById('mapRealtime');
            if (mapElement) mapElement.innerHTML = '';
            if (!mapInstance) {
                mapInstance = L.map('mapRealtime').setView([lat, lon], 16);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mapInstance);
            } else {
                mapInstance.setView([lat, lon], 16);
            }
            if (currentLocationMarker) mapInstance.removeLayer(currentLocationMarker);
            if (accuracyCircle) mapInstance.removeLayer(accuracyCircle);
            currentLocationMarker = L.marker([lat, lon]).addTo(mapInstance)
                .bindPopup(`<b>Lokasi Anda Saat Ini</b><br>Akurasi: ${acc.toFixed(0)} meter`).openPopup();
            accuracyCircle = L.circle([lat, lon], {
                radius: acc
            }).addTo(mapInstance);
        }

        function showErrorInitializingMap(error) {
            const mapElement = document.getElementById('mapRealtime');
            let message = "Gagal memuat peta: ";

            // TAMBAHKAN PENGECEKAN INI
            if (error.code === error.PERMISSION_DENIED) {
                message =
                    "Izin lokasi ditolak. Pastikan Anda mengakses situs melalui HTTPS dan izinkan akses lokasi untuk Safari di Pengaturan iPhone Anda.";
            } else {
                switch (error.code) {
                    case error.POSITION_UNAVAILABLE:
                        message += "Informasi lokasi tidak tersedia.";
                        break;
                    case error.TIMEOUT:
                        message += "Permintaan lokasi timed out.";
                        break;
                    default:
                        message += "Kesalahan tidak diketahui.";
                        break;
                }
            }

            if (mapElement) mapElement.innerHTML = `<p class='text-center text-red-500 p-4'>${message}</p>`;
            console.error("Error Geolocation Map: ", error);
        }

        function submitAttendanceData() {
            const jenisAbsenEl = document.getElementById("absenType");
            const jenisAbsen = jenisAbsenEl ? jenisAbsenEl.value : null;
            const selectedOptionInputEl = document.getElementById('selectedOptionInput');
            let selectedOption = selectedOptionInputEl ? selectedOptionInputEl.value : null;
            let isValid = true;

            if (!jenisAbsen) {
                isValid = false;
                alert("Silakan pilih jenis absen (Hadir atau Pulang).");
            } else if (jenisAbsen === "hadir" && !selectedOption) {
                isValid = false;
                alert("Silakan pilih status kehadiran (Hadir, Sakit, atau Izin).");
            } else if (jenisAbsen === "pulang" && !selectedOption) {
                isValid = false;
                alert("Silakan pilih opsi untuk absen pulang.");
            }
            if (!isValid) return;

            const continueBtn = document.getElementById('continueBtn');
            if (navigator.geolocation) {
                if (continueBtn) {
                    continueBtn.disabled = true;
                    continueBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memproses...';
                }
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        document.getElementById('latitudeInput').value = position.coords.latitude;
                        document.getElementById('longitudeInput').value = position.coords.longitude;
                        document.getElementById('accuracyInput').value = position.coords.accuracy;
                        const form = document.getElementById('formAbsensi');
                        const formData = new FormData(form);
                        fetch("{{ route('user.attendance.store') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": formData.get('_token'),
                                    "Accept": "application/json"
                                },
                                body: formData
                            })
                            .then(async response => {
                                const isJson = response.headers.get('content-type')?.includes(
                                    'application/json');
                                const responseBody = isJson ? await response.json() : await response.text();
                                if (!response.ok) {
                                    let errorData = {
                                        message: "Terjadi kesalahan pada server.",
                                        errors: {},
                                        status: response.status
                                    };
                                    if (isJson && typeof responseBody === 'object') errorData = {
                                        ...errorData,
                                        ...responseBody
                                    };
                                    else if (typeof responseBody === 'string') errorData.message = responseBody;
                                    throw errorData;
                                }
                                return responseBody;
                            })
                            .then(data => {
                                console.log("Success data from server:", data);
                                let alertMessageForHome = "Operasi berhasil!";
                                if (typeof data === 'object' && data.message) alertMessageForHome = data.message;
                                else if (typeof data === 'object' && data.success) alertMessageForHome =
                                    "Absensi berhasil diproses!";
                                else if (typeof data === 'string') alertMessageForHome = data;
                                alert(alertMessageForHome);
                                if (data.attendance_details) {
                                    localStorage.setItem('processed_jenis_absen', data.attendance_details
                                        .jenis_absen);
                                    localStorage.setItem('processed_status_detail', data.attendance_details
                                        .status_detail_display);
                                    localStorage.setItem('processed_time', data.attendance_details.time);
                                    localStorage.setItem('processed_date', data.attendance_details.date);
                                    localStorage.setItem('alert_message_from_home', alertMessageForHome);
                                } else {
                                    localStorage.setItem('processed_status_detail',
                                        'Status tidak diterima dari server');
                                    localStorage.setItem('processed_time', '--:--:--');
                                    localStorage.setItem('processed_date', 'Tanggal tidak diterima');
                                    localStorage.setItem('alert_message_from_home', alertMessageForHome);
                                }
                                window.location.href = "{{ route('user.absen') }}";
                            })
                            .catch(error => {
                                console.error("Error processing attendance:", error);
                                let errorMessage = "Terjadi kesalahan saat mengirim data absensi.";
                                if (error.status === 422 && error.errors) {
                                    errorMessage = "Kesalahan Validasi:\n";
                                    for (const key in error.errors) errorMessage +=
                                        `- ${error.errors[key].join(', ')}\n`;
                                } else if (error.message) errorMessage = error.message;
                                else if (typeof error === 'string') errorMessage = error;
                                alert(errorMessage);
                            })
                            .finally(() => {
                                if (continueBtn) {
                                    continueBtn.disabled = false;
                                    continueBtn.innerHTML = 'Lanjut';
                                }
                                closeAbsenModalWithoutRedirect();
                            });
                    },
                    (error) => {
                        let geoMessage = "Tidak dapat mengambil lokasi untuk absensi: ";
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                geoMessage += "Izin lokasi ditolak.";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                geoMessage += "Informasi lokasi tidak tersedia.";
                                break;
                            case error.TIMEOUT:
                                geoMessage += "Permintaan lokasi timed out.";
                                break;
                            default:
                                geoMessage += "Kesalahan tidak diketahui.";
                                break;
                        }
                        alert(geoMessage);
                        console.error("Geolocation Error for Attendance: ", error);
                        if (continueBtn) {
                            continueBtn.disabled = false;
                            continueBtn.innerHTML = 'Lanjut';
                        }
                    }, {
                        enableHighAccuracy: true,
                        timeout: 15000,
                        maximumAge: 0
                    }
                );
            } else {
                alert("Geolocation tidak didukung oleh browser ini untuk melakukan absensi.");
            }
        }

        window.addEventListener("DOMContentLoaded", () => {
            const welcomePopupEl = document.getElementById("welcomePopup");
            if (welcomePopupEl) welcomePopupEl.classList.remove("hidden");
            const userBtn = document.getElementById("userBtn");
            const userDropdown = document.getElementById("userDropdown");
            if (userBtn && userDropdown) {
                userBtn.addEventListener("click", (e) => {
                    e.stopPropagation();
                    userDropdown.classList.toggle("hidden");
                });
                document.addEventListener("click", (event) => {
                    if (!userDropdown.classList.contains("hidden") && !userBtn.contains(event.target) && !
                        userDropdown.contains(event.target)) {
                        userDropdown.classList.add("hidden");
                    }
                });
            }
            const continueBtnModal = document.getElementById("continueBtn");
            if (continueBtnModal) {
                const newContinueBtn = continueBtnModal.cloneNode(true);
                continueBtnModal.parentNode.replaceChild(newContinueBtn, continueBtnModal);
                newContinueBtn.addEventListener("click", submitAttendanceData);
            }
            updateTime();
            setInterval(updateTime, 1000);
            initializeLeafletMap();
        });
    </script>
</body>

</html>
