<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Dashboard
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: "Poppins", sans-serif;
        }
    </style>
</head>

<body class="bg-gray-300 min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-[#0a4aa0] w-44 flex flex-col justify-between py-6 px-5 relative">
        <div>
            <img alt="Official emblem logo with star, waves, and green leaves" class="mb-10" height="80"
                src="https://storage.googleapis.com/a1aa/image/b8a2577d-6f49-43cc-628e-7137d15ec12a.jpg"
                width="60" />
            <nav class="flex flex-col space-y-6 text-white text-sm font-semibold">
                <a class="opacity-100 border-l-2 border-white pl-2 text-[15px]" href="/admin/dashboard">
                    Dashboard
                </a>
                <a class="opacity-50 hover:opacity-100 transition-opacity duration-300 text-[14px]"
                    href="/admin/rekap-absensi">
                    Rekap Absensi
                </a>
                <a class="opacity-50 hover:opacity-100 transition-opacity duration-300 text-[14px]"
                    href="/admin/karyawan">
                    Data Karyawan
                </a>
            </nav>
        </div>
        <button onclick="window.location.href='{{ url('/admin/profil-admin') }}'"
            class="absolute bottom-6 bg-gray-300 rounded-lg px-4 py-2 text-center w-28"
            style="font-size: 12px; font-weight: 700;">
            <p class="font-bold">
                {{ Auth::user()->name }}
            </p>
            <p class="text-xs font-normal">
                Admin
            </p>
        </button>
    </aside>
    <!-- Main content -->
    <main class="flex-1 p-8">
        <h1 class="text-black font-bold text-lg mb-8">
            Dashboard
        </h1>
        <section class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-4xl">
            <div class="bg-white rounded-lg p-6 flex items-center justify-between" style="min-width: 220px;">
                <span class="text-3xl font-extrabold">
                    10
                </span>
                <div class="text-right">
                    <p class="font-bold text-lg leading-tight">
                        Total Karyawan
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 flex items-center justify-between" style="min-width: 220px;">
                <span class="text-3xl font-extrabold">
                    10%
                </span>
                <div class="text-right">
                    <p class="font-bold text-lg leading-tight">
                        Presentase Tepat waktu
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 flex items-center justify-between" style="min-width: 220px;">
                <span class="text-3xl font-extrabold">
                    0
                </span>
                <div class="text-right">
                    <p class="font-bold text-lg leading-tight">
                        Tepat Waktu Hari ini
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 flex items-center justify-between" style="min-width: 220px;">
                <span class="text-3xl font-extrabold">
                    2
                </span>
                <div class="text-right">
                    <p class="font-bold text-lg leading-tight">
                        Terlambat Hari ini
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 flex items-center justify-between" style="min-width: 220px;">
                <span class="text-3xl font-extrabold">
                    6
                </span>
                <div class="text-right">
                    <p class="font-bold text-lg leading-tight">
                        Presentasi Hari ini
                    </p>
                </div>
            </div>
            <div class="bg-white rounded-lg p-6 flex items-center justify-between" style="min-width: 220px;">
                <span class="text-3xl font-extrabold">
                    2
                </span>
                <div class="text-right">
                    <p class="font-bold text-lg leading-tight">
                        Cuti Bulan ini
                    </p>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
