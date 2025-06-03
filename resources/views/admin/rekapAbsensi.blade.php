<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Rekap Absensi
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        /* Custom scrollbar for sidebar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
    </style>
</head>

<body class="bg-gray-300 ">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-[#0a4aa0] w-44 flex flex-col justify-between py-6 px-5 relative">
            <div>
                <img alt="Yellow and green emblem logo with star and water elements" class="mb-10" height="80"
                    src="https://storage.googleapis.com/a1aa/image/b91d97f7-43d5-4edf-1673-f1a9e16a31fa.jpg"
                    width="60" />
                <nav class="flex flex-col space-y-6 text-white text-sm font-bold">
                    <a class="opacity-50 hover:opacity-100 transition-opacity duration-300 text-[15px]"
                        href="/admin/dashboard">
                        Dashboard
                    </a>
                    <a class="opacity-100 border-l-2 border-white pl-2 text-[16px]" href="/admin/rekap-absensi">
                        Rekap Absensi
                    </a>
                    <a class="opacity-50 hover:opacity-100 transition-opacity duration-300 text-[15px]"
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
        <main class="flex-1 p-6">
            <h1 class="text-lg font-bold mb-4">
                Rekap Absensi
            </h1>
            <div class="bg-white rounded-md shadow-md p-4">
                <div class="flex justify-between items-center bg-[#0a8ad0] rounded-t-md px-4 py-2 mb-2">
                    <div class="text-white text-sm font-semibold flex items-center space-x-2">
                        <i class="fas fa-print">
                        </i>
                        <span>
                            Pilih Bulan
                        </span>
                    </div>
                    <select aria-label="Pilih Bulan"
                        class="text-sm rounded border border-gray-300 px-2 py-1 focus:outline-none focus:ring-1 focus:ring-[#0a8ad0]">
                        <option>Januari</option>
                        <option>Februari</option>
                        <option>Maret</option>
                        <option>April</option>
                        <option>Mei</option>
                        <option>Juni</option>
                        <option>Juli</option>
                        <option>Agustus</option>
                        <option>September</option>
                        <option>Oktober</option>
                        <option>November</option>
                        <option>Desember</option>
                    </select>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse border border-gray-300 text-xs">
                        <thead>
                            <tr class="bg-gray-200 text-center">
                                <th class="border border-gray-300 px-2 py-1 font-normal">
                                    No
                                </th>
                                <th class="border border-gray-300 px-2 py-1 font-normal">
                                    ID Karyawan
                                </th>
                                <th class="border border-gray-300 px-2 py-1 font-normal">
                                    Nama
                                </th>
                                <th class="border border-gray-300 px-2 py-1 font-normal">
                                    Jam Masuk
                                </th>
                                <th class="border border-gray-300 px-2 py-1 font-normal">
                                    Jam Keluar
                                </th>
                                <th class="border border-gray-300 px-2 py-1 font-normal">
                                    Keterangan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    1
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    09.50
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    12.00
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <span class="bg-red-600 text-white text-[10px] font-semibold px-2 py-0.5 rounded">
                                        Terlambat
                                    </span>
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    2
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    07.00
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    12.00
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    <span class="bg-green-600 text-white text-[10px] font-semibold px-2 py-0.5 rounded">
                                        Tepat Waktu
                                    </span>
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    3
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    4
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    5
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    6
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    7
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    8
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    9
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    10
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    11
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    12
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    13
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    14
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    15
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    16
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>
                            <tr class="text-center">
                                <td class="border border-gray-300 px-2 py-1">
                                    17
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    812753813712
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Mucen
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>

                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end items-center space-x-2 mt-3 text-xs text-gray-700">
                    <button class="px-2 py-1 rounded text-gray-600" type="button">
                        kembali
                    </button>
                    <input aria-label="Page number"
                        class="w-8 text-center border border-gray-300 rounded py-1 text-xs" type="text"
                        value="1" />
                    <button class="px-3 py-1 rounded bg-gray-200 text-gray-700" type="button">
                        Lanjut
                    </button>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
