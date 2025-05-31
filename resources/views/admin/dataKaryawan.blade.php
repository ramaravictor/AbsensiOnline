<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>
        Data Karyawan
    </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
</head>

<body class="bg-gray-300 font-sans">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-[#0a5eb7] w-36 flex flex-col items-center py-8 space-y-8 shadow-lg relative">
            <img alt="Official emblem with star, mountain, river, and green leaves" class="mb-6" height="72"
                src="https://storage.googleapis.com/a1aa/image/de472ba4-1a91-4e3b-d205-ecee86752dbb.jpg"
                width="72" />
            <nav class="flex flex-col space-y-6 text-white text-sm font-semibold text-center">
                <a class="hover:underline" href="/admin/dashboard">
                    Dashboard
                </a>
                <a class="hover:underline" href="/admin/rekap-absensi">
                    Rekap Absensi
                </a>
                <a class="opacity-100 border-l-2 border-white pl-2" href="/admin/karyawan">
                    Data Karyawan
                </a>
            </nav>
            <button onclick="window.location.href='{{ url('/admin/profil-admin') }}'"
            class="absolute bottom-6 bg-gray-300 rounded-lg px-4 py-2 text-center w-28"
            style="font-size: 12px; font-weight: 700;">
            <p class="font-bold">
                Munir
            </p>
            <p class="text-xs font-normal">
                Admin
            </p>
        </button>
        </aside>
        <!-- Main content -->
        <main class="flex-1 p-6">
            <h1 class="text-black font-bold text-lg mb-4">
                Data Karyawan
            </h1>
            <section class="bg-[#0a5eb7] rounded-md p-3 flex flex-col">
                <div class="flex justify-between items-center mb-3">
                    <button aria-label="Print" class="text-white hover:text-gray-300" title="Print">
                        <i class="fas fa-print fa-lg">
                        </i>
                    </button>
                    <input class="rounded px-3 py-1 text-sm focus:outline-none" placeholder="Search....."
                        type="search" />
                </div>
                <div class="overflow-x-auto bg-white rounded-md shadow-inner max-h-[360px] overflow-y-auto">
                    <table class="w-full border-collapse border border-gray-300 text-xs">
                        <thead class="bg-gray-200 text-center text-gray-700 sticky top-0 z-10">
                            <tr>
                                <th class="border border-gray-300 px-2 py-1 w-8">
                                    No
                                </th>
                                <th class="border border-gray-300 px-2 py-1 w-36">
                                    ID Karyawan
                                </th>
                                <th class="border border-gray-300 px-2 py-1 w-28">
                                    Nama
                                </th>
                                <th class="border border-gray-300 px-2 py-1 w-28">
                                    Jabatan
                                </th>
                                <th class="border border-gray-300 px-2 py-1 w-32">
                                    Jadawal Kerja
                                </th>
                                <th class="border border-gray-300 px-2 py-1 w-32">
                                    Tanggal Hari Ini
                                </th>
                                <th class="border border-gray-300 px-2 py-1 w-40">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-center text-gray-700">
                            <tr>
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
                                    Karyawan
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    07.00 - 15.00
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                    Juli 10, 2024
                                </td>
                                <td class="border border-gray-300 px-2 py-1 space-x-2">
                                    <button
                                        class="bg-gray-300 text-gray-700 text-xs rounded px-3 py-1 hover:bg-gray-400"
                                        type="button">
                                        Edit
                                    </button>
                                    <button
                                        class="bg-gray-300 text-gray-700 text-xs rounded px-3 py-1 hover:bg-gray-400"
                                        type="button">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <tr>
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
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                            </tr>
                            <tr>
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
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                            </tr>
                            <tr>
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
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                            </tr>
                            <tr>
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
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                            </tr>
                            <tr>
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
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                            </tr>
                            <tr>
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
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                            </tr>
                            <tr>
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
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                            </tr>
                            <tr>
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
                                <td class="border border-gray-300 px-2 py-1">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div
                    class="flex justify-end items-center space-x-2 mt-2 bg-white px-3 py-1 rounded-b-md text-xs text-gray-700">
                    <button class="border border-gray-300 rounded px-2 py-0.5">
                        kembali
                    </button>
                    <input class="w-10 border border-gray-300 rounded text-center text-xs py-0.5" min="1"
                        type="number" value="1" />
                    <button class="border border-gray-300 rounded px-2 py-0.5">
                        Lanjut
                    </button>
                </div>
            </section>
        </main>
    </div>
</body>

</html>
