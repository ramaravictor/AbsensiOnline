<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Profile Page
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-white min-h-screen flex">
    <!-- Sidebar -->
    <aside class="bg-[#0a4aa0] w-44 flex flex-col justify-between py-6 px-5 relative min-h-screen">
        <div>
            <img alt="Official emblem logo with star, waves, and green leaves" class="mb-10" height="80"
                src="https://storage.googleapis.com/a1aa/image/b8a2577d-6f49-43cc-628e-7137d15ec12a.jpg"
                width="60" />
            <nav class="flex flex-col space-y-6 text-white text-sm font-semibold">
                <a class="opacity-50 hover:opacity-100 transition-opacity duration-300 text-[14px]"
                    href="/admin/dashboard">
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

    <!-- Main Content -->
    <main class="mt-10 w-[600px] max-w-full rounded-lg shadow-lg overflow-hidden mx-auto">
        <section class="bg-[#0D8B2F] flex flex-col items-center py-8 px-6 rounded-t-lg">
            <img alt="Profile image of a man wearing a brown uniform and a black face mask, standing outdoors"
                class="w-20 h-20 rounded-full object-cover mb-4" height="80"
                src="https://storage.googleapis.com/a1aa/image/de7019d2-d27f-4958-7ab5-abc19d228791.jpg"
                width="80" />
            <h2 class="text-white font-semibold text-lg leading-tight">
                {{ Auth::user()->name }}
            </h2>
            <p class="text-[#A7C9A7] text-[9px] mt-1 leading-tight">
                {{ Auth::user()->nip }}
            </p>
            <p class="text-[#A7C9A7] text-[9px] mt-1 text-center leading-tight max-w-[280px]">
                {{ Auth::user()->jabatan }}
            </p>
        </section>
        <section class="bg-[#E6E6E6] rounded-b-lg p-4 mt-0">
            <div class="flex rounded-lg bg-[#E6E6E6] p-4 relative">
                <div class="border-l-4 border-[#0B57A0] absolute left-0 top-0 bottom-0 rounded-l-lg">
                </div>
                <div class="flex flex-col w-full ml-4">
                    <h3 class="font-semibold text-sm mb-1">
                        Data Pegawai
                    </h3>
                    <div class="flex justify-between text-[9px] text-[#4B4B4B]">
                        <div class="flex flex-col space-y-1">
                            <span>
                                Instansi
                            </span>
                            <span>
                                Kantor
                            </span>
                        </div>
                        <div class="flex flex-col space-y-1 text-right">
                            <span>
                                Pemerintah Provinsi Lombok Barat
                            </span>
                            <span>
                                Dinas Lingkungan Hidup
                            </span>
                        </div>
                    </div>
                </div>
                <div class="border-r-4 border-[#0B57A0] absolute right-0 top-0 bottom-0 rounded-r-lg">
                </div>
            </div>
        </section>
    </main>
    <!-- Floating button bottom right LOGOUT ADMIN -->
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
